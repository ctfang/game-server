<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 20:34
 */

namespace GameWorker\Support;


class LoadRouteAnnotations
{
    public function __construct()
    {

    }

    public function load($controllerDir)
    {
        if( !is_dir($controllerDir) ){
            return [];
        }

        foreach ($this->getPhpFile($controllerDir) as $file){
            dump($file);
        }
    }

    private function getPhpFile($controllerDir)
    {
        $list = scandir($controllerDir);
        foreach ($list as $file){
            if( in_array($file,['.','..']) ){
                continue;
            }elseif ( is_dir($controllerDir.'/'.$file) ){
                yield $this->getPhpFile($controllerDir.'/'.$file)->current();
            }elseif ( strpos($file,'.php')===false ){
                continue;
            }else{
                yield $controllerDir.'/'.$file;
            }
        }
    }
}