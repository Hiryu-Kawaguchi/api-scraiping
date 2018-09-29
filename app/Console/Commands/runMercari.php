<?php

namespace App\Console\Commands;

use Goutte\Client;
use Illuminate\Console\Command;
use App\Item;
use App\Keyword;

class runMercari extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runMercari';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
         * TOKENで判断する
         * keywordから持ってきてONのものをスクレイピング、DB更新
         * itemsのslackがtrueになっているものをSlackで通知
         * */
        $keywords = Keyword::where('switch', 1)->get();
        foreach ($keywords as $keyword){
            $this->scraping($keyword);
            sleep(5);
        }
        $this->slackSend();
    }

    public function slackSend(){
        $items = Item::all();
        foreach ($items as $item){
            if($item->slack_push == 1 && $item->sold == 0){
                $this->send($item);
                $item->slack_push = 0;
                $item->save();
                sleep(1);
            }
        }
    }

    public function scraping($keyword){
        $i = 0;
        $List = array();
        //URLに適合できるようにURLを変更
        $keyword->keyword = str_replace(" ", "+", $keyword->keyword);
        $api_id = $keyword->id;
        $url = "https://www.mercari.com/jp/search/?sort_order=&keyword=".$keyword->keyword."&category_root=&brand_name=&brand_id=&size_group=&price_min=".$keyword->price_min."&price_max=".$keyword->price_max;
        $client2 = new Client();
        $client2->setHeader('accept-encoding', 'gzip, deflate, br');
        $crawler = $client2->request('GET', $url);
        $items = $crawler->filter('div.items-box-content')->filter('section.items-box')->each(function($element) use (&$i,&$List,&$api_id){
            $List[$i]['name'] = $element->filter('h3')->text();
            $List[$i]['price'] = $element->filter('div.items-box-price')->text();
            $List[$i]['url'] = $element->filter('a')->attr('href');
            if(count($element->filter('div.item-sold-out-badge'))){
                $List[$i]['sold'] = 1;
            }else{
                $List[$i]['sold'] = 0;
            }
            /*
                priceを文字列から数値に変換
                その際に余計な文字も削除
            */
            $List[$i]['price'] = preg_replace('/[^0-9]/', '', $List[$i]['price']);
            //urlからitem_idを取得
            $List[$i]['item_id'] = basename($List[$i]['url']);

            $old_item = Item::where('item_id', $List[$i]['item_id'])->first();
            if($old_item == NULL){
                if($List[$i]['sold'] == 0){
                    $item = new Item();
                    $item->item_id = $List[$i]['item_id'];
                    $item->api_id = $api_id;
                    $item->name = $List[$i]['name'];
                    $item->price = $List[$i]['price'];
                    $item->sold = $List[$i]['sold'];
                    $item->url = $List[$i]['url'];
                    $item->slack_push = 1;
                    $item->save();
                }
            }else{
                $old_item->name = $List[$i]['name'];
                if($old_item->price != $List[$i]['price']){
                    $old_item->slack_push = 1;
                }
                $old_item->price = $List[$i]['price'];
                $old_item->sold = $List[$i]['sold'];
                $old_item->save();
            }
        });
    }

    public function send($item){
        $client = new Client();
        $price = number_format($item->price);
        $payload = ['text' => "\n\n:dog: *$item->name* \n:moneybag:` ¥$price ` \n <$item->url|リンクはこちら>"];
        $payload = json_encode($payload);
        $client->request('POST', 'https://hooks.slack.com/services/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', ['payload' => $payload]);
    }
}
