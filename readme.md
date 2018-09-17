
# api-scraiping

- htmlを登録しておくとそのトークンを使って定期的にhtmlを取得できるAPI
- Slackから最新のサッカーニュースをスクレイピングから取得することのできるAPI
- メルカリで自分の欲しい価格帯で出品されたらSlackに通知がいくAPI
    (ローカルでは動作するが、Heroku上では動作しません)

## 使い方

### 初期設定

`$ cp .env.example .env`
`$ composer update`

.envでipアドレスを指定してください
※不特定多数の場所からアクセスされると他のサーバーに迷惑かかるので。。

```

    'dev' => env('IP_DEV'),
    'heroku' => env('IP_HEROKU'),
    'home' => env('IP_HOME'),
    'slack'  => env('SLACK_TOKEN'),
    
```

現状ではipアドレスでの制限を解除し、Basic認証を採用している

` $ php artisan vendor:publish `

上記のコードを実行するとconfig/very_basic_auth.phpができるので、これを編集してIDとPASSWORDを設定

## 現状

herokuはcronがクレジット登録必須でつかえないのでアクセス時に5分間データベースが

更新されていなければスクレイピングする設計

Azureはcronが使えるみたいなので移行を検討中


# APIリファレンス

HerokuのURL
https://api-scraiping.herokuapp.com

## API一覧

|NO.|RequestType|機能概要|
|:---|:---|:---|
|1|POST|URLを登録しトークンを返す|
|2|GET|トークンをもらったらHTMLを返す|
|3|GET|日時とタイプをもらって適応するレコードのリストを返す|

### NO.1
#### ルート

|入力||
|:---|:---|
|アクセスURL|/api/store/url|

#### POSTデータ

|name|型|サイズ|必須|暗号化|検索結果|値の説明|
|:---|:---|:---|:---|:---|:---|:---|
|url|string|255|○|なし|完全一致|有効なURLであること|

#### 出力

|JSON Key|型|サイズ|必須|値の説明|
|:---|:---|:---|:---|:---|
|token|string|255|○|HTMLを引き出す時に必要な値|
|url|string|255|○|入力されたURLを返却する|
|status|string|255|○|成功時 success  失敗時 error:メッセージ|

### NO.2
#### ルート

|入力||
|:---|:---|
|アクセスURL|/api/get/data|

#### POSTデータ

|name|型|サイズ|必須|暗号化|検索結果|値の説明|
|:---|:---|:---|:---|:---|:---|:---|
|token|string|255|○|なし|完全一致|すでに登録されたトークンであること|

#### 出力

|JSON Key|型|サイズ|必須|値の説明|
|:---|:---|:---|:---|:---|
|token|string|255|○|受け取ったトークンを返す|
|html|string|65535|○|スクレイピングしたHTML|
|status|string|255|○|成功時 success  失敗時 error:メッセージ|

### NO.3
#### ルート

|入力||
|:---|:---|
|アクセスURL|/api/get/list|

#### GETデータ

|name|型|サイズ|必須|暗号化|検索条件|値の説明|
|:---|:---|:---|:---|:---|:---|:---|
|start_date|date|不明|○|なし|end_dateよりも前の日付であること|検索をかけるスタートの日付|
|start_date|date|不明|○|なし|start_dateよりも後の日付であること|検索をかける最後の日付|
|start_date|string|255|○|なし|updated_atかもしくはcreated_atであること|どちらのタイプで検索をかけるか|

#### 出力

|JSON Key|型|サイズ|必須|値の説明|
|:---|:---|:---|:---|:---|
|token|string|255|○|それぞれのトークン|
|html|string|65535|○|スクレイピングしたHTML|
|updated_at	|string|不明|○|いつスクレイピングしたか|
|created_at	|string|不明|○|いつURLを登録したか|
|status|string|255|○|成功時 success  失敗時 error:メッセージ|

