<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 14:39
 */

namespace GameWorker\Core;


use GatewayWorker\Register;

class RegisterServer extends Register
{
    public function __construct($config)
    {
        $this->name  = $config['name'];
        $socket_name = $config['socketType'] . '://' . $config['host'] . ':' . $config['port'];

        parent::__construct($socket_name);
    }
}