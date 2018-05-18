<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/17
 * Time: 21:30
 */

namespace GameWorker\Core;


use GameWorker\Game;
use GameWorker\Support\DebugGateway;
use GameWorker\Support\QueueServer;
use GameWorker\Support\WorkerEvent;

class XDebugServer
{
    private $eventList = [];

    private $queue;

    public function __construct()
    {
        // 队列信息存储目录
        $debugAgentDir = Game::config('debugPushDir');
        if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);

        $this->queue = new QueueServer($debugAgentDir);
    }

    /**
     * 绑定真实使用的event
     *
     * @param $workerName
     * @param $event
     */
    public function debugToEvent($workerName, $event)
    {
        $this->eventList[$workerName] = $event;
    }

    /**
     * 执行消费
     */
    public function runWhile()
    {
        while (true) {
            $workerParams = $this->queue->pull();
            if( !$workerParams ){
                continue;
            }

            $this->listen($this->eventList[$workerParams->name],$workerParams->onFunction,$workerParams->params);

            usleep(10000);
        }
    }

    private function listen(WorkerEvent $event, string $onFuncName, $params)
    {
        call_user_func_array($event . '::' . $onFuncName, $params);
    }

    /**
     * 设置跟Gateway通讯的woker类名称
     * Gateway 重定向信息
     *
     * @param string $alias
     */
    public function setGateway(string $alias)
    {
        class_alias(DebugGateway::class, $alias);
    }
}