<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/17
 * Time: 22:09
 */

namespace GameWorker\Support;


class QueueServer
{
    private $fileList;
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * 进入队列
     *
     * @param $name
     * @param $onFunction
     * @param $params
     */
    public function push($name, $onFunction, $params)
    {
        file_put_contents($this->dir . '/' . $name . '/' . uniqid() . '.txt', json_encode([
            'name' => $name,
            'onFunction' => $onFunction,
            'params' => $params
        ]));
    }

    /**
     * 推出一个信息
     *
     * @return bool|WorkerParams
     */
    public function pull()
    {
        $fileName = false;

        if ($this->fileList) {
            $fileName = array_shift($this->fileList);
        } else {
            $list = scandir($this->dir);
            unset($list[0], $list[1]);
            $this->fileList = array_values($list);
            if ($this->fileList) {
                $fileName = array_shift($this->fileList);
            }
        }

        if ($fileName) {
            $fileName = $this->fileList . '/' . $fileName;
            unlink($fileName);
            return $this->out($fileName);
        }
        return false;
    }

    private function out($fileName)
    {
        $content = file_get_contents($fileName);
        $json    = json_decode($content, true);

        if (!isset($json['name']) || !isset($json['onFunction']) || !isset($json['params'])) {
            return false;
        }

        return new WorkerParams($json['name'], $json['onFunction'], $json['params']);
    }
}


class WorkerParams
{
    public $name;
    public $onFunction;
    public $params;

    public function __construct($name, $onFunction, $params)
    {
        $this->name       = $name;
        $this->onFunction = $onFunction;
        $this->params     = $params;
    }
}