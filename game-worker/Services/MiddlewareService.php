<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/6/11
 * Time: 15:43
 */

namespace GameWorker\Services;


use GameWorker\Support\Http\Request;
use GameWorker\Support\Http\Response;

class MiddlewareService
{
    protected $middlewares = [];

    public function next(Request $request)
    {

    }

    public function handle():Response
    {

    }


    /**
     * @param $middleware
     * @param string|null $name
     */
    public function addMiddleware($middleware, string $name = null)
    {
        // set key, can allow override it
        if ($name) {
            $this->middlewares[$name] = $middleware;
        } else {
            $this->middlewares[] = $middleware;
        }
    }
}