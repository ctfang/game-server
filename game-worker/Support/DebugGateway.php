<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/16
 * Time: 21:53
 */

namespace GameWorker\Support;


use GameWorker\Game;

class DebugGateway
{
    public static function __callStatic($name, $arguments)
    {
        self::saveFile($name,$arguments);
    }


    /**
     * @param $funName
     * @param $params
     */
    public static function saveFile($funName, $params)
    {
        $debugAgentDir = Game::config('debugPullDir');
        $debugAgentDir = str_replace('/', '\\', $debugAgentDir);
        if (!is_dir($debugAgentDir)) mkdir($debugAgentDir, 0755, true);
        file_put_contents($debugAgentDir . '/' . time() . '_' . uniqid() . '.txt', json_encode([
            'funName' => $funName,
            'params'  => $params,
        ], JSON_UNESCAPED_UNICODE));
    }
}