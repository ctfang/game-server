<?php
/**
 * Created by PhpStorm.
 * User: jingyu
 * Date: 2018/4/27
 * Time: 16:21
 */

namespace GameWorker;


use GameWorker\Support\Config;
use Workerman\Worker;

class Game
{
    private static $container;

    public $rootPath;

    /** @var Config */
    public $config;

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
        self::$container = $this;
        self::$container->rootPath = $rootPath;
    }

    public function loadServerConfig($file)
    {
        self::$container->config = new Config($file);
    }

    /**
     * 通用注册回调
     *
     * @param Worker $worker
     */
    public function listen(Worker $worker)
    {
        if( isset($worker->myListen) ){
            // $worker 自定义的回调函数
            foreach ($worker->myListen as $func){
                if( method_exists($worker,$func) ){
                    $worker->{$func} = [$worker,$func];
                }
            }
        }else{
            foreach ($this->listen as $func){
                if( method_exists($worker,$func) ){
                    $worker->{$func} = [$worker,$func];
                }
            }
        }
    }

    public function run()
    {
        Worker::runAll();
    }

    public static function config($key, $default = null)
    {
        return self::$container->config->get($key, $default);
    }
}