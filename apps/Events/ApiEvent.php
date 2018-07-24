<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/17
 * Time: 22:06
 */

namespace Apps\Events;


use GameWorker\Support\WorkerEvent;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class ApiEvent extends WorkerEvent
{

    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return mixed
     */
    public function onWorkerStart(Worker $worker)
    {
        // TODO: Implement onWorkerStart() method.
    }

    /**
     * 连接事件
     *
     * @param TcpConnection $connection 客户端连接
     * @return mixed
     */
    public function onConnect(TcpConnection $connection)
    {
        // TODO: Implement onConnect() method.
    }

    /**
     * 接收信息
     *
     * @param TcpConnection $connection
     * @param string|array $message
     * @return mixed
     */
    public function onMessage(TcpConnection $connection, $message)
    {
        // TODO: Implement onMessage() method.
    }

    /**
     * 客户端断开触发
     *
     * @param TcpConnection $connection
     * @return mixed
     */
    public function onClose(TcpConnection $connection)
    {
        // TODO: Implement onClose() method.
    }
}