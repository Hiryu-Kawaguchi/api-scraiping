
# api-scraiping

#### Slackから最新のサッカーニュースをスクレイピングから取得することのできるアプリケーションです。

## 使い方

.envでipアドレスを指定してください

<code>

    'dev' => env('IP_DEV'),
    'heroku' => env('IP_HEROKU'),
    'home' => env('IP_HOME'),
    'slack'  => env('SLACK_TOKEN'),
    
</code>


## 現状

一応使うことができるのですが、herokuはcronがクレジット登録必須でつかえないのでAzureへの移行を検討

## APIリファレンス

HerokuのURL
https://slack-soccer.herokuapp.com

## API一覧

|NO.|RequestType|機能概要|
|:---|:---|:---|
|1|POST|URLを登録しトークンを返す|
|2|GET|トークンをもらったらHTMLを返す|
|3|GET|日時とタイプをもらって適応するレコードのリストを返す|


