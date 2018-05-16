#!/usr/bin/env php
<?php

use GameWorker\Core\BusinessServer;
use GameWorker\Core\GatewayServer;
use GameWorker\Core\HttpServer;
use GameWorker\Core\RegisterServer;
use GameWorker\Game;

require './vendor/autoload.php';
require './game-worker/Helper/Functions.php';

$game = new Game(__DIR__);
$game->loadServerConfig(__DIR__ . '/config');

try {
    $game->listen(new RegisterServer(Game::config('register')));

    $game->listen(new GatewayServer(Game::config('gateway'), Game::config('register')));

    $game->listen(new BusinessServer(Game::config('business'), Game::config('register')));

    $game->listen(new HttpServer(Game::config('http')));

    $game->run();
} catch (\Exception $exception) {
    // 调试下，打印错误
    echo "\n",$exception->getMessage(),
    " in ",
    $exception->getFile(),
    " on line ",
    $exception->getLine(),
    "\nStack trace:\n",
    $exception->getTraceAsString(),
    "\n";
}