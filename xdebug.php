<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 16:34
 */

use GameWorker\Game;
use GameWorker\Support\DebugGateway;

require './vendor/autoload.php';
require './game-worker/Helper/Functions.php';

$game = new Game(__DIR__);
$game->loadServerConfig(__DIR__ . '/config');

$debugAgentDir = Game::config('debugPushDir');
$debugAgentDir = str_replace('/', '\\', $debugAgentDir);
if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);
$eventName = \Apps\Events\BusinessEvent::class;

class_alias(DebugGateway::class,"\\GatewayWorker\\Lib\\Gateway");

/**
 * 信息队列消费
 */
while (true) {
    $list = scandir($debugAgentDir);
    unset($list[0], $list[1]);
    foreach ($list as $fileName) {
        $fileName = $debugAgentDir . '/' . $fileName;
        $content  = file_get_contents($fileName);
        unlink($fileName);
        $json = json_decode($content, true);
        if (!empty($json)) {
            $funName = $json['funName'];
            $params  = $json['params'];
            call_user_func_array($eventName.'::'.$funName, $params);
        }
    }
    //延迟 0.5s
    usleep(500000);
}