<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 20:41
 */

return [
    /**
     * DebugEvent 拦截信息，并保存文件
     * xdebug.php文件消费这个目录的文件
     */
    'debugPushDir'=>dirname(__DIR__).'/runtime/debug/push',

    /**
     * DebugEvent消费的目录
     * 文件由xdebug.php推入
     */
    'debugPullDir'=>dirname(__DIR__).'/runtime/debug/pull',


    '$time_interval'=>1,
];