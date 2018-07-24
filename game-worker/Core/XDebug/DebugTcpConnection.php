<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/7/16
 * Time: 16:43
 */

namespace GameWorker\Core\XDebug;


use React\Socket\ConnectionInterface;
use Workerman\Connection\TcpConnection;

class DebugTcpConnection extends TcpConnection
{
    /**
     * DebugTcpConnection constructor.
     * @param $socket
     * @param $remote_address
     */
    public function __construct($socket, $remote_address = '')
    {
        $this->_remoteAddress = $remote_address;
        $this->_socket        = $socket;
    }

    public function send($send_buffer, $raw = false)
    {
        $this->_socket->write(strlen($this->_remoteAddress).$this->_remoteAddress.$send_buffer);
    }
}