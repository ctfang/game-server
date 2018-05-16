<?php
/**
 * Created by PhpStorm.
 * User: jingyu
 * Date: 2018/5/15
 * Time: 15:07
 */

namespace GameWorker\Core;


use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class HttpServer extends Worker
{
    public function __construct($httpConfig)
    {
        $this->name  = $httpConfig['name'];
        $this->count = $httpConfig['count'];
        $socket_name = $httpConfig['socketType'] . '://' . $httpConfig['host'] . ':' . $httpConfig['port'];

        parent::__construct($socket_name);
    }

    public function onMessage(TcpConnection $connection, array $data)
    {
        $test = 123;


        $connection->send('hello world'.time());
    }
}