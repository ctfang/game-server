<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 20:20
 */

namespace Apps\Events;


use GameWorker\Game;
use GameWorker\Support\WorkerEvent;
use GatewayWorker\Lib\Gateway;
use Workerman\Lib\Timer;

class DebugEvent extends WorkerEvent
{
    public static function onWorkerStart()
    {
        $debugAgentDir = Game::config('debugPullDir');
        if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);
        // 队列间隔
        $time_interval = Game::config('time_interval', 500000);
        Timer::add($time_interval,function ()use($debugAgentDir){
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
                    call_user_func_array(Gateway::class.'::'.$funName, $params);
                }
            }
        });
    }

    /**
     * 连接事件
     *
     * @param string $clientId 客户端连接id
     * @return mixed
     */
    public static function onConnect(string $clientId)
    {
        self::saveFile(__FUNCTION__, [$clientId]);
    }

    /**
     * 接收信息
     *
     * @param string $clientId
     * @param string|array $message
     * @return mixed
     */
    public static function onMessage(string $clientId, $message)
    {
        self::saveFile(__FUNCTION__, [$clientId, $message]);
    }

    /**
     * 客户端断开触发
     *
     * @param string $clientId
     * @return mixed
     */
    public static function onClose(string $clientId)
    {
        self::saveFile(__FUNCTION__, [$clientId]);
    }

    /**
     * @param $funName
     * @param $params
     */
    public static function saveFile($funName, $params)
    {
        $debugAgentDir = Game::config('debugPushDir');
        file_put_contents($debugAgentDir . '/' . time() . '_' . uniqid() . '.txt', json_encode([
            'funName' => $funName,
            'params'  => $params,
        ], JSON_UNESCAPED_UNICODE));
    }
}