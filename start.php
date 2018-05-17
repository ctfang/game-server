#!/usr/bin/env php
<?php

use GameWorker\Core\BusinessServer;
use GameWorker\Core\GatewayServer;
use GameWorker\Core\HttpServer;
use GameWorker\Core\RegisterServer;
use GameWorker\Game;

/**
 * 公用加载
 * @var Game $game
 */
$game = include __DIR__.'/game-worker/autoload.php';

try {
    $game->listen(new RegisterServer(Game::config('register')));

    $game->listen(new GatewayServer(Game::config('gateway'), Game::config('register')));

    $game->listen(new BusinessServer(Game::config('business'), Game::config('register')));

    $game->listen(new HttpServer(Game::config('http')));

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