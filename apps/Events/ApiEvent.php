<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/17
 * Time: 22:06
 */

namespace Apps\Events;


use GameWorker\Support\WorkerEvent;

class ApiEvent extends WorkerEvent
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
     */
    public static function onMessage(string $clientId, $message)
    {
        // TODO: Implement onMessage() method.
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