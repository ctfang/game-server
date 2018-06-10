<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 21:22
 */

namespace Apps\Controllers;

use GameWorker\Annotation\Controller;
use GameWorker\Annotation\RequestMapping;

/**
 * Class IndexController
 * @Controller("/")
 * @package Apps\Controllers
 */
class IndexController
{
    /**
     * @RequestMapping("index")
     */
    public function index()
    {
        return time();
    }
}