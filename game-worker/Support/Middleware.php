<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/6/11
 * Time: 15:39
 */

namespace GameWorker\Support;


interface Middleware
{
    /**
     * @param $request
     * @param $next
     */
    public function handle($request,$next);
}