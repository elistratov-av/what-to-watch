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

    'academy' => [
        'films' => [
            'url' => env('EXT_API_FILMS', 'http://academy.localhost/api/films/')
        ],
        'comments' => [
            'url' => env('EXT_API_COMMENTS', 'http://academy.localhost/api/comments/')
        ],
    ],

    'omdb' => [
        'films' => [
            'url' => trim(env('OMDB_API_FILMS', 'http://www.omdbapi.com'), '/') . '/?apikey=' . env('OMDB_API_KEY', '1a11fdad')
        ]
    ]

];
