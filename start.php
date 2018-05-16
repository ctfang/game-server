#!/usr/bin/env php
<?php

use GameWorker\Core\BusinessServer;
use GameWorker\Core\GatewayServer;
use GameWorker\Core\HttpServer;
use GameWorker\Core\RegisterServer;
use GameWorker\Game;

require './vendor/autoload.php';
require './game-worker/Helper/Functions.php';

/**
 *
 */
$game = new Game(__DIR__);

$game->loadServerConfig(__DIR__ . '/config/server.php');

$game->listen(new RegisterServer(Game::config('register')));

$game->listen(new GatewayServer(Game::config('gateway'), Game::config('register')));

$game->listen(new BusinessServer(Game::config('business'), Game::config('register')));


//$game->listen(new HttpServer(Game::config('http')));


try {
    $game->run();
} catch (\Exception $exception) {
    dump($exception);
}