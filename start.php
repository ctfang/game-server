#!/usr/bin/env php
<?php

use GameWorker\Core\ApiServer;
use GameWorker\Game;

/**
 * 公用加载
 * @var Game $game
 */
$game = include __DIR__.'/game-worker/autoload.php';

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