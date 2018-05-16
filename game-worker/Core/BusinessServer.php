<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 15:13
 */

namespace GameWorker\Core;

use GatewayWorker\BusinessWorker;

class BusinessServer extends BusinessWorker
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
        $this->eventHandler    = $config['eventHandler'];
        $this->registerAddress = $register['host'] . ':' . $register['port'];

        parent::__construct();
    }
}