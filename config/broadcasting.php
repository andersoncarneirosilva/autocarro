<?php

return [


    'default' => env('BROADCAST_DRIVER', 'websockets'),


    'connections' => [

        // DESENVOLVIMENTO
        'websockets' => [
            'driver' => 'websockets',
            'host' => env('BROADCAST_HOST', '127.0.0.1'),
            'port' => env('BROADCAST_PORT', 6001),
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
        //         'scheme' => env('PUSHER_SCHEME', 'https'),  // Certifique-se de que a URL de esquema está configurada corretamente
        //         'host' => env('PUSHER_HOST'),  // URL do Pusher
        //         'port' => env('PUSHER_PORT'),
        //     ],
        // ],


        
        'socket' => [
            'driver' => 'websockets',
            'host' => env('BROADCAST_HOST'),
            'port' => env('BROADCAST_PORT', 443),
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
