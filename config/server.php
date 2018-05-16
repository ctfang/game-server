<?php

return [
    'http'     => [
        'name'        => 'api',
        'socketType' => 'http',
        'host'        => env('HTTP_HOST', '0.0.0.0'),
        'port'        => env('HTTP_PORT', 88),
        'count'       => env('HTTP_COUNT', 1),
    ],
    // gateway ws 连接端口
    'gateway'  => [
        'name'        => 'ws',
        'socketType' => 'WebSocket',
        'lanIp'       => env('Gateway_LanIp', '0.0.0.0'),
        'startPort'   => env('Gateway_StartPort', '9010'),
        'host'        => env('Gateway_HOST', '0.0.0.0'),
        'port'        => env('Gateway_PORT', 9003),
        'count'       => env('Gateway_COUNT', 1),
    ],
    // gateway 集群管理
    'register' => [
        'name'        => 'register',
        'socketType' => 'text',
        'host'        => env('REGISTER_HOST', '0.0.0.0'),
        'port'        => env('REGISTER_PORT', 9004),
    ],
    // gateway 业务处理
    'business' => [
        'name'         => 'business',
        'count'        => env('BUSINESS_COUNT', 1),
        'eventHandler' => env('BUSINESS_EVENT', \Apps\Events\BusinessEvent::class),
    ],

    'task' => [
        'host'  => env('HTTP_HOST', '0.0.0.0'),
        'port'  => env('HTTP_PORT', 81),
        'count' => env('WS_COUNT', 1),
    ],
];
