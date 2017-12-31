<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\SoccerNews;
use Carbon\Carbon;

class TestApiController extends Controller
{
    public function index(){
        global $articleList;
        $i = 0;
        $articleList = array();
        $client = new Client();
        $crawler = $client->request('GET', 'https://news.yahoo.co.jp/hl?c=socc');
        //一番上は例外なのでこのように扱う
        $articleList[$i]['title'] = $crawler->filter('span.ttl')->eq(0)->text();
        $articleList[$i]['url'] = $crawler->filter('span.ttl')->eq(0)->filter('a')->attr('href');
        //2番目以降のニュース
        $lists = $crawler->filter('div.articleList')->filter('ul li')->filter('p.ttl')->each(function($element) use (&$i,&$articleList){
            $i++;
            $articleList[$i]['title'] = $element->text();
            $articleList[$i]['url'] =$element->filter('a')->attr('href');
        });
        krsort($articleList);
        foreach ($articleList as $item){
            $SoccerNews = SoccerNews::where('title',$item['title'])->first();
            if($SoccerNews == NULL){
                $SoccerNews = new SoccerNews();
                $SoccerNews->title = $item['title'];
                $SoccerNews->url = $item['url'];
                $SoccerNews->save();
            }
        }
    }

    /*
     *  現状ではcronが使えないためアクセスするたびにスクレイピングしにいくという悲しい設計
     *
     * */
    public function slacknews(Request $request){
        //最新のレコードから5分間たったら更新してもいいよ
        $last = SoccerNews::orderBy('id','desc')->first();
        $last_time = $last->created_at;
        $last_time->addMinute(5);
        $now = Carbon::now();
        if($now->gt($last_time)){
            //スクレイピング実行！
            $this->index();
        }

        $SoccerNews = SoccerNews::orderBy('id','desc')->take(5)->get();
        if($_POST["user_name"] != "slackbot"){
            $text = "最新のサッカーニュースをお届けします！\n";
            foreach ($SoccerNews as $news) {
                $text .= "<".$news->url."|".$news->title.">"."\n";
            }
            $payload = array("text" => $text);

            echo json_encode($payload);
        }
    }

    public function test(){
        /*
         * ipが通るかどうかの確認に使って下さい
         * */
        echo 'hello';
    }

}
