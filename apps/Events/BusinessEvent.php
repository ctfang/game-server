<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 15:23
 */

namespace Apps\Events;

use GameWorker\Support\WorkerEvent;
use \GatewayWorker\Lib\Gateway;

class BusinessEvent extends WorkerEvent
{
    /**
     * 连接事件
     *
     * @param string $clientId 客户端连接id
     * @return mixed
     */
    public static function onConnect(string $clientId)
    {
        // TODO: Implement onConnect() method.
    }

    /**
     * 接收信息
     *
     * @param string $clientId
     * @param string|array $message
     * @return mixed
     * @throws \Exception
     */
    public static function onMessage(string $clientId, $message)
    {
        // 可以在这里测试断点 1
        $test = time();
        // 可以在这里测试断点 2
        $test++;
        $test++;
        $test++;
        $test++;
        $test++;
        $test++;

        // 向客户端发送信息
        Gateway::sendToAll("{$clientId} said $message");
    }

    /**
     * 客户端断开触发
     *
     * @param string $clientId
     * @return mixed
     */
    public static function onClose(string $clientId)
    {
        // TODO: Implement onClose() method.
    }
}