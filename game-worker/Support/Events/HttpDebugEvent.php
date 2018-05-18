<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 15:48
 */

namespace GameWorker\Support\Events;

use GameWorker\Game;
use GameWorker\Support\QueueServer;
use GameWorker\Support\WorkerEvent;
use GatewayWorker\Lib\Gateway;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;

class HttpDebugEvent extends WorkerEvent
{
    /** @var QueueServer */
    private $queue;

    private $workerName;

    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return mixed
     */
    public function onStartWorker(Worker $worker)
    {
        // 队列信息存储目录
        $debugAgentDir = Game::config('debugPushDir');
        if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);

        $this->queue = new QueueServer($debugAgentDir);

        $this->workerName = $worker->name;
    }

    /**
     * 连接事件
     *
     * @param TcpConnection $connection 客户端连接id
     * @return mixed
     */
    public function onConnect(TcpConnection $connection)
    {
        $this->queue->push($this->workerName,__FUNCTION__,$connection);
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
        $this->queue->push($this->workerName,__FUNCTION__,$message);
    }

    /**
     * 客户端断开触发
     *
     * @param TcpConnection $connection
     * @return mixed
     */
    public function onClose(TcpConnection $connection)
    {
        $this->queue->push($this->workerName,__FUNCTION__,$connection);
    }
}