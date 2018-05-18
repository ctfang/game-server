<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 20:11
 */

namespace GameWorker\Support;


use Workerman\Connection\TcpConnection;
use Workerman\Worker;

abstract class WorkerEvent
{
    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return mixed
     */
    abstract public function onWorkerStart(Worker $worker);

    /**
     * 连接事件
     *
     * @param TcpConnection $connection 客户端连接
     * @return mixed
     */
    abstract public function onConnect(TcpConnection $connection);

    /**
     * 接收信息
     *
     * @param TcpConnection $connection
     * @param string|array $message
     * @return mixed
     */
    abstract public function onMessage(TcpConnection $connection, $message);

    /**
     * 客户端断开触发
     *
     * @param TcpConnection $connection
     * @return mixed
     */
    abstract public function onClose(TcpConnection $connection);
}