<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 14:58
 */

namespace GameWorker\Core;


use GatewayWorker\Gateway;

class GatewayServer extends Gateway
{
    public $myListen = [];

    /**
     * GatewayServer constructor.
     * @param array $config
     * @param array $register
     */
    public function __construct($config, $register)
    {
        $this->name            = $config['name'];
        $this->count           = $config['count'];
        $this->lanIp           = $config['lanIp'];
        $this->startPort       = $config['startPort'];
        $this->reloadable      = false;
        $this->registerAddress = $register['host'] . ':' . $register['port'];

        $socket_name = $config['socketType'] . '://' . $config['host'] . ':' . $config['port'];

        parent::__construct($socket_name);
    }
}