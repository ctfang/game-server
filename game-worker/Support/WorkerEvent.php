<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 20:11
 */

namespace GameWorker\Support;


abstract class WorkerEvent
{
    /**
     * 连接事件
     *
     * @param string $clientId 客户端连接id
     * @return mixed
     */
    abstract public static function onConnect(string $clientId);

    /**
     * 接收信息
     *
     * @param string $clientId
     * @param string|array $message
     * @return mixed
     */
    abstract public static function onMessage(string $clientId, $message);

    /**
     * 客户端断开触发
     *
     * @param string $clientId
     * @return mixed
     */
    abstract public static function onClose(string $clientId);
}