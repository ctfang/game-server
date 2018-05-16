<?php
/**
 * Created by PhpStorm.
 * User: jingyu
 * Date: 2018/5/15
 * Time: 15:42
 */

namespace GameWorker\Support;


abstract class ServiceProvider
{
    public final function __construct()
    {

    }

    abstract public function boot();
}