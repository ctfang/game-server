<?php
/**
 * Created by PhpStorm.
 * User: jingyu
 * Date: 2018/4/27
 * Time: 16:21
 */

namespace GameWorker;


use Dotenv\Dotenv;
use GameWorker\Core\XDebug\DebugTcpConnection;
use GameWorker\Support\Config;
use GameWorker\Support\Events\ApiEvent;
use GameWorker\Support\Http\Response;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use Workerman\Worker;

class Game
{
    private static $container;

    public $rootPath;

    /** @var Config */
    public $config;

    private $serverList = [];

    private $listen = [
        'onConnect',
        'onMessage',
        'onClose',
        'onError',
        'onWorkerStart',
        'onWorkerStop',
        'onWorkerReload',
    ];

    public function __construct($rootPath)
    {
        self::$container           = $this;
        self::$container->rootPath = $rootPath;
        if (file_exists($rootPath . '/.env')) {
            $dotenv = new Dotenv($rootPath);
            $dotenv->load();
        }

        Worker::$pidFile = dirname(__DIR__) . '/runtime/workerman.pid';
        Worker::$logFile = dirname(__DIR__) . '/runtime/workerman.log';
    }

    /**
     * @param string $dir
     * @throws \Noodlehaus\Exception\EmptyDirectoryException
     */
    public function loadServerConfig($dir)
    {
        self::$container->config = new Config($dir);
    }

    /**
     * 通用注册回调
     *
     * @param Worker $worker
     */
    public function listen(Worker $worker)
    {
        $this->serverList[$worker->name] = $worker;
        if (isset($worker->eventHandler) && $worker->eventHandler) {
            $event = $worker->eventHandler;
            $event = new $event();
        } else {
            $event = $worker;
        }

        if (isset($worker->myListen)) {
            // $worker 自定义的回调函数
            $listen = $worker->myListen;
        } else {
            $listen = $this->listen;
        }

        foreach ($listen as $func) {
            if (method_exists($event, $func)) {
                $worker->{$func} = [$event, $func];
            }
        }
    }

    /**
     * 启动
     */
    public function run()
    {
        if (defined('IS_XDEBUG') && IS_XDEBUG) {
            $this->loop();
        } else {
            Worker::runAll();
        }
    }

    private function loop()
    {
        foreach ($this->serverList as $name => $worker) {
            if (isset($worker->onWorkerStart)) {
                call_user_func_array($worker->onWorkerStart, [$worker]);
            }
        }
        $uri       = "tcp://127.0.0.1:89";
        $loop      = Factory::create();
        $connector = new Connector($loop);

        $connector->connect($uri)->then(function (ConnectionInterface $connection) {

            $connection->on('data', function ($chunk) use ($connection) {
                $message    = json_decode($chunk, true);
                if(!$message) return;
                $connect    = new DebugTcpConnection($connection,$message['id']);
                /** @var ApiEvent $worker */
                $worker = $this->serverList['api'];
                call_user_func_array($worker->onMessage, [$connect, $message]);
            });
        });

        $loop->run();
    }

    /**
     * 读取配置
     *
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function config($key, $default = null)
    {
        return self::$container->config->get($key, $default);
    }

    /**
     * 获取绝对路径
     *
     * @param string $dir
     * @return string
     */
    public static function getRoot(string $dir)
    {
        return dirname(__DIR__) . $dir;
    }
}