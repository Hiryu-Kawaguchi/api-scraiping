<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\Carbon;

class MercariItemController extends Controller
{
    public function scraping(){
        $i = 0;
        $List = array();
        $url = "https://www.mercari.com/jp/search/?sort_order=&keyword=ipad+mini4&category_root=&brand_name=&brand_id=&size_group=&price_min=10000&price_max=30000";
        $client2 = new Client();
        //$client2->setHeader('User-Agent', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        //$client2->setHeader('accept-language', 'ja');
        //$client2->setHeader('accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8');
        $client2->setHeader('accept-encoding', 'gzip, deflate, br');
        $crawler = $client2->request('GET', $url);
        $items = $crawler->filter('div.items-box-content')->filter('section.items-box')->each(function($element) use (&$i,&$List){
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
            //
            echo $List[$i]['item_id'];
            echo '</br>';
            echo $List[$i]['url'];
            echo '</br>';
            echo $List[$i]['name'];
            echo '</br>';
            echo $List[$i]['price'];
            echo '</br>';
            echo $List[$i]['sold'];
            echo '</br>';
        });
    }
}
