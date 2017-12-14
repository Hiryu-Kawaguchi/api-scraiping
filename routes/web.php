<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
 * 登録したHTMLをスクレイピングしてきてDBに保管するプログラム
 *
 * */
//テスト用にPOSTでリクエスト出来るフォーム
Route::get('input/post',function(){
    return view('url_input');
});
//テスト用にGETでリクエスト出来るフォーム
Route::get('input/get',function(){
    return view('token_input');
});
//テスト用にGETでlistをリクエスト出来るフォーム
Route::get('input/get/list',function(){
    return view('date_input');
});

//テスト開発
Route::get('/test','TestApiController@test');

//APIの本体
Route::group(['prefix' => 'api'], function () {
    //html関連
    Route::get('get/data', 'HtmlApiController@getHtml');
    Route::get('get/list', 'HtmlApiController@getList');
    Route::post('store/url', 'HtmlApiController@storeUrl');
    //Slack関連
    Route::post('slack/news', 'TestApiController@slacknews');
});

Route::get('news/reload','TestApiController@index');

/*
 * メルカリで欲しい商品を登録しておくと
 * その商品が出品されたらSlackに通知が行くという素敵なAPI
 *
 * */

//test
Route::get('mercari/test','MercariItemController@scraping');

//商品登録
//商品一覧
//商品削除
//商品編集