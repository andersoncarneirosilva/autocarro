<?php

return [


    'default' => env('BROADCAST_DRIVER', 'pusher'),


    'connections' => [

        // DESENVOLVIMENTO
        // 'pusher' => [
        //     'driver' => 'pusher',
        //     'key' => env('PUSHER_APP_KEY'),
        //     'secret' => env('PUSHER_APP_SECRET'),
        //     'app_id' => env('PUSHER_APP_ID'),
        //     'options' => [
        //         'cluster' => env('PUSHER_APP_CLUSTER'),
        //         'useTLS' => false,
        //         'encrypted' => false,
        //         'host' => env('PUSHER_HOST', '127.0.0.1'),
        //         'port' => env('PUSHER_PORT', 6001),
        //         'scheme' => env('PUSHER_SCHEME', 'http'),
        //     ],
        // ],

        // PRODUÇÃO
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
                'useTLS' => true,
                'host' => env('PUSHER_HOST', 'ws.pusherapp.com'), // Verifique o host correto
                'port' => env('PUSHER_PORT', 443), // Ou 6001 para WebSockets próprios
                'scheme' => env('PUSHER_SCHEME', 'https'),
            ],
        ],

    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
    ],

        
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
