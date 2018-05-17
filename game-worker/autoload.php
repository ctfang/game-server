<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/17
 * Time: 10:58
 */

use GameWorker\Game;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../game-worker/Helper/Functions.php';

$game = new Game(dirname(__DIR__));
$game->loadServerConfig(dirname(__DIR__) . '/config');

return $game;