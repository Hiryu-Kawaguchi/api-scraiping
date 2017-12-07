
# api-scraiping

####Slackから最新のサッカーニュースをスクレイピングから取得することのできるアプリケーションです。

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


