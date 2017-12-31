<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
        /*
         * 外部からのアクセスで攻撃を受けないように
         * IP制限をかけています
         * */
        /*
         *
         * BASIC認証でなんとかする
         *
         * */
//        $ip = $this->getIpAddress();
//        $host_name = gethostbyaddr($ip);
//        if(!(in_array($ip,Config::get('ip')))){
//            /*
//             * slackからのアクセスはIPがコロコロ変わるためtokenで判断
//             * */
//            if($request['token'] != Config::get('ip.slack')){
//                Redirect::to('/')->send();
//            }
//        }
    }

    function getIpAddress() {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
