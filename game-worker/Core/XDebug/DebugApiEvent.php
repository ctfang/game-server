<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/7/11
 * Time: 17:53
 */

namespace GameWorker\Core\XDebug;


use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;

class DebugApiEvent extends \GameWorker\Support\Events\ApiEvent
{
    public static $queue = null;


    public static $connectionList = [];

    public static $connectionMsg = [];
    /** @var TcpConnection */
    public static $debugConnection;

    /**
     * @param Worker $worker
     * @return mixed|void
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function onWorkerStart(Worker $worker)
    {
        parent::onWorkerStart($worker);

        $worker = new Worker('tcp://0.0.0.0:89');

        $worker->onConnect = function (TcpConnection $connection) {
            echo "调试已连接\n";
            self::$debugConnection = $connection;
        };
        $worker->onClose = function (TcpConnection $connection) {
            echo "调试已关闭\n";
        };

        $worker->onMessage = function (TcpConnection $connection, $str) {
            $data = substr($str, $str{0} + 1);
            $id   = substr($str, 1, $str{0});
            self::$connectionList[$id]->send($data);
        };
        $worker->listen();
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
        self::$connectionList[$connection->id] = $connection;
        $message['id']                         = $connection->id;
        if (isset(self::$debugConnection)) {
            self::$debugConnection->send(json_encode($message));
        }
    }
}