<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 16:34
 */

use GameWorker\Game;
use GameWorker\Support\DebugGateway;

/**
 * 公用加载
 * @var Game $game
 */
$game = include __DIR__ . '/game-worker/autoload.php';

// 队列信息存储目录
$debugAgentDir = Game::config('debugPushDir');
if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);

// 生成环境的 BusinessEvent
$eventName = \Apps\Events\BusinessEvent::class;

// Gateway 重定向信息
class_alias(DebugGateway::class, "\\GatewayWorker\\Lib\\Gateway");

// 队列间隔
$time_interval = Game::config('time_interval', 500000);

// 信息队列消费
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
            call_user_func_array($eventName . '::' . $funName, $params);
        }
    }
    //延迟 0.5s
    usleep($time_interval);
}