<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/19
 * Time: 17:38
 */

namespace GameWorker\Support\Http;


use GameWorker\Game;

class DebugResponse
{
    use ResponseTail;

    /**
     * 发送前拦截所有数据
     */
    public function send()
    {
        $response = $this;

        $arrSave = [];

        /**
         * Headers
         */
        $arrSave['headers'] = $response->getHeaders();

        /**
         * Cookies
         */
        $arrSave['cookies'] = $response->getHeaders();

        /**
         * Status code
         */
        $arrSave['code'] = $response->getStatusCode();

        /**
         * Body
         */
        $arrSave['body'] = $response->getBody()->getContents();

        $name = $this->connect->worker->name;

        $debugAgentDir = Game::config('debugPullDir').'/'.$name;

        if(!is_dir($debugAgentDir)){
            mkdir($debugAgentDir,0755,true);
        }

        file_put_contents($debugAgentDir . '/' . $name . '/' .'TcpConnection_'.$this->connect->id.'_'. uniqid() . '.txt', json_encode($arrSave));

        return $arrSave;
    }
}