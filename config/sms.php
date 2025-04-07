<?php

return [
    'default' => env('SMS_DRIVER', 'log'), // Default is log (for testing)

    'drivers' => [
        'log' => [
            'channel' => env('LOG_CHANNEL', 'stack'), // Fake SMS logging
        ],
        // 'mtn' => [
        //     'base_url' => env('MTN_SMS_URL'), // API URL for MTN
        //     'username' => env('MTN_SMS_USERNAME'),
        //     'password' => env('MTN_SMS_PASSWORD'),
        //     'sender' => env('MTN_SMS_SENDER'),
        // ],
        // 'syriatel' => [
        //     'base_url' => env('SYRIATEL_SMS_URL'), // API URL for Syriatel
        //     'api_key' => env('SYRIATEL_SMS_API_KEY'),
        //     'sender' => env('SYRIATEL_SMS_SENDER'),
        // ],
    ],
];
