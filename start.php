#!/usr/bin/env php
<?php

use GameWorker\Core\BusinessServer;
use GameWorker\Core\GatewayServer;
use GameWorker\Core\ApiServer;
use GameWorker\Core\RegisterServer;
use GameWorker\Core\WebServer;
use GameWorker\Game;

/**
 * 公用加载
 * @var Game $game
 */
$game = include __DIR__.'/game-worker/autoload.php';

try {
    /**
     * 在这里设置需要启动的worker服务
     * listen是一个统一设置onEvent的函数
     */
    //$game->listen(new RegisterServer(Game::config('register')));

    //$game->listen(new GatewayServer(Game::config('gateway'), Game::config('register')));

    //$game->listen(new BusinessServer(Game::config('business'), Game::config('register')));

    $game->listen(new ApiServer(Game::config('api')));

    //$game->listen(new WebServer(Game::config('web')));

    $game->run();

} catch (\Exception $exception) {
    // 打印错误
    echo "\n",$exception->getMessage(),
    " in ",
    $exception->getFile(),
    " on line ",
    $exception->getLine(),
    "\nStack trace:\n",
    $exception->getTraceAsString(),
    "\n";
}