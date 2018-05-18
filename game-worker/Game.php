<?php
/**
 * Created by PhpStorm.
 * User: jingyu
 * Date: 2018/4/27
 * Time: 16:21
 */

namespace GameWorker;


use Dotenv\Dotenv;
use GameWorker\Support\Config;
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
        if (isset($worker->eventHandler) && $worker->eventHandler) {
            $this->serverList[$worker->name] = $worker->eventHandler;
            $event                           = $worker->eventHandler;
            $event                           = new $event();
        } else {
            $this->serverList[$worker->name] = get_class($worker);
            $event                           = $worker;
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
        Worker::runAll();
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