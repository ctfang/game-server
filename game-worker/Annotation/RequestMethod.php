<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 20:21
 */

namespace GameWorker\Annotation;


class RequestMethod
{
    /**
     * Get method
     */
    const GET = 'get';

    /**
     * Post method
     */
    const POST = 'post';

    /**
     * Put method
     */
    const PUT = 'put';

    /**
     * Delete method
     */
    const DELETE = 'delete';

    /**
     * Patch method
     */
    const PATCH = 'patch';

    /**
     * Options method
     */
    const OPTIONS = 'options';
}