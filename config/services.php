<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'webhook_secret' => env('TELEGRAM_WEBHOOK_SECRET'),
        /*
         * Исходящие запросы к Telegram API через HTTP-прокси (см. https://api.dashboard.proxy.market/docs).
         * Либо TELEGRAM_HTTP_PROXY целиком, либо host/port + user/password.
         * Хост и порт — из ответа POST /dev-api/list/{api_key}: поля ip и http_port.
         */
        'http_proxy' => env('TELEGRAM_HTTP_PROXY'),
        'proxy_host' => env('TELEGRAM_PROXY_HOST'),
        'proxy_port' => env('TELEGRAM_PROXY_PORT'),
        'proxy_user' => env('TELEGRAM_PROXY_USER'),
        'proxy_password' => env('TELEGRAM_PROXY_PASSWORD'),
    ],

    'webbot' => [
        'signing_key' => env('WEBBOT_SIGNING_KEY'),
    ],

    'hydraai' => [
        'key' => env('AI_TOKEN') ?: env('HYDRA_AI_KEY'),
        'model' => env('HYDRA_AI_MODEL', 'deepseek-v3.2'),
    ],

];
