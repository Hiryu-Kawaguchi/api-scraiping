<?php

return array(

    #.envに以下の変数で利用するipアドレスやslackのトークンを登録しておいて下さい

    'dev' => env('IP_DEV'),
    'heroku' => env('IP_HEROKU'),
    'home' => env('IP_HOME'),
    'slack'  => env('SLACK_TOKEN'),

);