<?php

return [


    'default' => env('BROADCAST_DRIVER', 'pusher'),


    'connections' => [

        // DESENVOLVIMENTO
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => false,
                'encrypted' => false,
                'scheme' => env('PUSHER_SCHEME', 'http'),
                'host' => env('PUSHER_HOST', '127.0.0.1'),
                'port' => env('PUSHER_PORT', 6001),
            ],
        ],

        // PRODUÇÃO
        // 'pusher' => [
        //     'driver' => 'pusher',
        //     'key' => env('PUSHER_APP_KEY'),
        //     'secret' => env('PUSHER_APP_SECRET'),
        //     'app_id' => env('PUSHER_APP_ID'),
        //     'options' => [
        //         'cluster' => env('PUSHER_APP_CLUSTER'),
        //         'useTLS' => true,
        //         'encrypted' => true,
        //         'scheme' => env('PUSHER_SCHEME', 'https'),
        //         'host' => env('PUSHER_HOST'),
        //         'port' => env('PUSHER_PORT', 443),
        //         'curl_options' => [
        //             CURLOPT_SSL_VERIFYHOST => 2,
        //             CURLOPT_SSL_VERIFYPEER => 1,
        //         ],
        //     ],
        // ],



        
        'socket' => [
            'driver' => 'websockets',
            'host' => env('BROADCAST_HOST'),
            'port' => env('BROADCAST_PORT', 6001),
        ],
        

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
