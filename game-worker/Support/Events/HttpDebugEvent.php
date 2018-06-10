<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 15:48
 */

namespace GameWorker\Support\Events;

use GameWorker\Game;
use GameWorker\Services\DispatcherService;
use GameWorker\Support\LoadRouteAnnotations;
use GameWorker\Support\QueueServer;
use GameWorker\Support\WorkerEvent;
use GatewayWorker\Lib\Gateway;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;

class HttpDebugEvent extends WorkerEvent
{
    /**
     * @var DispatcherService
     */
    protected $dispatcher;

    /** @var QueueServer */
    private $queue;

    private $workerName;

    private $connectionList;

    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return mixed
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function onWorkerStart(Worker $worker)
    {
        $this->workerName = $worker->name;

        $route = (new LoadRouteAnnotations())->load(Game::getRoot('/apps/Controllers'));
        $this->dispatcher = new DispatcherService();
        $this->dispatcher->setDispatcher($route);

        // 队列信息存储目录
        $debugAgentDir = Game::config('debugPushDir');
        if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);

        $this->queue = new QueueServer($debugAgentDir);

        $this->startPullDebug();
    }

    /**
     * 连接事件
     *
     * @param TcpConnection $connection 客户端连接id
     * @return mixed
     */
    public function onConnect(TcpConnection $connection)
    {
        $this->connectionList[$connection->id] = $connection;
        $this->queue->push($this->workerName,__FUNCTION__,['TcpConnectionId'=>$connection->id]);
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
        $this->queue->push($this->workerName,__FUNCTION__,['TcpConnectionId'=>$connection->id]);
    }

    /**
     * 客户端断开触发
     *
     * @param TcpConnection $connection
     * @return mixed
     */
    public function onClose(TcpConnection $connection)
    {
        $this->queue->push($this->workerName,__FUNCTION__,['TcpConnectionId'=>$connection->id]);
    }

    public function startPullDebug()
    {
        $debugAgentDir = Game::config('debugPullDir').'/'.$this->workerName;
        if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);
        Timer::add(0.1,function ()use($debugAgentDir){
            $list = scandir($debugAgentDir);
            unset($list[0], $list[1]);
            foreach ($list as $fileName) {

                if( strpos($fileName,'TcpConnection')===0 ){
                    $id         = explode('_', $fileName)[1];
                    /** @var TcpConnection $connection */
                    $connection = $this->connectionList[$id];
                    $fileName   = $debugAgentDir . '/' . $fileName;
                    $content    = file_get_contents($fileName);
                    unlink($fileName);
                    $arrData    = json_decode($content,true);
                    $connection->send($arrData['body']);
                }else{

                }
            }
        });
    }
}