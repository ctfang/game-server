<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 16:34
 */

use Apps\Events\ApiEvent;
use Apps\Events\BusinessEvent;
use GameWorker\Core\XDebugServer;
use GameWorker\Game;

/**
 * 公用加载
 * @var Game $game
 */
$game = include __DIR__ . '/game-worker/autoload.php';

$debugServer = new XDebugServer();

/**
 * debug双向通讯,用于主动发送客户端的类名
 * 不能使用 object::class 生成
 */
$debugServer->setGateway("\\GatewayWorker\\Lib\\Gateway");

$debugServer->debugToEvent('ws', BusinessEvent::class);
$debugServer->debugToEvent('api', ApiEvent::class);

$debugServer->runWhile();