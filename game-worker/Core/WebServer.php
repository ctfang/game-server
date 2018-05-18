<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/17
 * Time: 17:07
 */

namespace GameWorker\Core;


class WebServer extends \Workerman\WebServer
{
    public $myListen = [];

    public function __construct(array $config)
    {
        foreach ($config['root'] as $domain => $dir) {
            $this->addRoot($domain, $dir);
        }
        $this->name  = $config['name'];
        $this->count = $config['count'];
        $socket_name = $config['socketType'] . '://' . $config['host'] . ':' . $config['port'];
        parent::__construct($socket_name);
    }
}