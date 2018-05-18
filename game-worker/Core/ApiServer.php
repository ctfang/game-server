<?php
/**
 * Created by PhpStorm.
 * User: jingyu
 * Date: 2018/5/15
 * Time: 15:07
 */

namespace GameWorker\Core;


use GameWorker\Game;
use GameWorker\Support\Events\ApiEvent;
use GameWorker\Support\Events\HttpDebugEvent;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class ApiServer extends Worker
{
    public $eventHandler;

    public function __construct($config)
    {
        $this->name  = $config['name'];
        $this->count = $config['count'];
        $socket_name = $config['socketType'] . '://' . $config['host'] . ':' . $config['port'];

        if (Game::config('xdebug', false)) {
            $this->eventHandler = HttpDebugEvent::class;
        } else {
            $this->eventHandler = ApiEvent::class;
        }
        parent::__construct($socket_name);
    }
}