<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\Carbon;
use App\Item;
use App\Keyword;

class MercariItemController extends Controller
{

    public function run(){

        // コマンド直に叩いている
        $exitCode = Artisan::call('runMercari');
    }

}
