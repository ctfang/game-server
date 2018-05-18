<?php

return [
    // 只提供api的web服务
    'api'      => [
        'name'       => 'api',
        'socketType' => 'http',
        'host'       => env('API_HOST', '0.0.0.0'),
        'port'       => env('API_PORT', 88),
        'count'      => env('API_COUNT', 1),
    ],
    // 提供静态文件的web服务
    'web'      => [
        'name'       => 'api',
        'socketType' => 'http',
        'host'       => env('WEB_HOST', '0.0.0.0'),
        'port'       => env('WEB_PORT', 89),
        'count'      => env('WEB_COUNT', 1),
        'root'       => [
            'www.example.me' => dirname(__DIR__).'/public',
        ],
    ],
    // gateway ws 连接端口
    'gateway'  => [
        'name'       => 'ws',
        'socketType' => 'WebSocket',
        'lanIp'      => env('GATEWAY_LANIP', '0.0.0.0'),
        'startPort'  => env('GATEWAY_STARTPORT', '9010'),
        'host'       => env('GATEWAY_HOST', '0.0.0.0'),
        'port'       => env('GATEWAY_PORT', 9003),
        'count'      => env('GATEWAY_COUNT', 1),
    ],
    // register 集群管理
    'register' => [
        'name'       => 'register',
        'socketType' => 'text',
        'host'       => env('REGISTER_HOST', '0.0.0.0'),
        'port'       => env('REGISTER_PORT', 9004),
    ],
    // gateway 业务处理
    'business' => [
        'name'         => 'business',
        'count'        => env('BUSINESS_COUNT', 1),
        'eventHandler' => \Apps\Events\BusinessEvent::class,
    ],
];
