<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 22:00
 */

namespace GameWorker\Services;


use FastRoute\Dispatcher;
use GameWorker\Support\Http\BodyStream;
use GameWorker\Support\Http\Request;
use GameWorker\Support\Http\Response;

class DispatcherService
{
    /** @var Dispatcher */
    protected $dispatcher;

    protected $bindRouteInfo;

    /**
     * @param Dispatcher $dispatcher
     */
    public function setDispatcher(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        $this->bindRouteInfo[\FastRoute\Dispatcher::NOT_FOUND]          = 'notFound';
        $this->bindRouteInfo[\FastRoute\Dispatcher::METHOD_NOT_ALLOWED] = 'methodNotAllowed';
        $this->bindRouteInfo[\FastRoute\Dispatcher::FOUND]              = 'found';
    }


    public function dispatch(Request $request, Response $response)
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        return $this->{$this->bindRouteInfo[$routeInfo[0]]}($request, $response, $routeInfo[1]??[]);
    }

    public function notFound(Request $request, Response $response)
    {
        $response = $response->withStatus(404);

        $response->send();

        return $response;
    }

    public function methodNotAllowed(Request $request, Response $response)
    {
        $response->withStatus(501);
        $response->send();

        return $response;
    }

    public function found(Request $request, Response $response, array $routeInfo)
    {
        $controller = $routeInfo[0];
        $action     = $routeInfo[1];
        $content = call_user_func_array([new $controller(),$action],[$request]);

        $response->withBody(new BodyStream($content));
        $response->send();

        return $response;
    }
}