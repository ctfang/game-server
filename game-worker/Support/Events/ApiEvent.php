<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 16:05
 */

namespace GameWorker\Support\Events;


use GameWorker\Game;
use GameWorker\Services\DispatcherService;
use GameWorker\Support\Http\Request;
use GameWorker\Support\Http\Response;
use GameWorker\Support\LoadRouteAnnotations;
use GameWorker\Support\WorkerEvent;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class ApiEvent extends WorkerEvent
{
    public $name = 'api_worker';

    /**
     * @var DispatcherService
     */
    protected $dispatcher;

    /**
     * 进程启动
     *
     * @param Worker $worker
     * @return mixed
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public function onWorkerStart(Worker $worker)
    {
        $route = (new LoadRouteAnnotations())->load(Game::getRoot('/apps/Http/Controllers'));

        $this->dispatcher = new DispatcherService();
        $this->dispatcher->setDispatcher($route);
    }

    /**
     * 连接事件
     *
     * @param TcpConnection $connection
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
        $psr7Request = Request::loadFromWorkerManRequest($message);
        $psr7Response = new Response($connection);

        return $this->dispatcher->dispatch($psr7Request, $psr7Response);
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