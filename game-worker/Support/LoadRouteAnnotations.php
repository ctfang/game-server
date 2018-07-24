<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 20:34
 */

namespace GameWorker\Support;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use FastRoute\RouteCollector;
use GameWorker\Annotation\Controller;
use GameWorker\Annotation\RequestMapping;
use ReflectionClass;

class LoadRouteAnnotations
{
    private $reader;

    /**
     * LoadRouteAnnotations constructor.
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct()
    {
        $this->reader = new AnnotationReader();

        $this->registerAnnotationLoader();
    }

    private function registerAnnotationLoader()
    {
        AnnotationRegistry::registerLoader(function ($class) {
            if (class_exists($class) || interface_exists($class)) {
                return true;
            }

            return false;
        });
    }

    /**
     * @param $controllerDir
     * @return array|\FastRoute\Dispatcher
     */
    public function load($controllerDir)
    {
        if (!is_dir($controllerDir)) {
            return [];
        }

        $dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $route) use ($controllerDir) {
            foreach ($this->getPhpFile($controllerDir) as $file) {
                $pathInfo = pathinfo($file);
                if (!isset($pathInfo['filename'])) {
                    continue;
                }
                $namespace = strstr($pathInfo['dirname'], 'Http');
                $namespace = str_replace('/', '\\', $namespace);
                $this->registerLoaderAndScanRoute("\\Apps\\" . $namespace . '\\' . $pathInfo['filename'], $route);
            }
        });

        return $dispatcher;
    }

    /**
     * @param $className
     * @param RouteCollector $route
     * @throws \ReflectionException
     */
    public function registerLoaderAndScanRoute($className, RouteCollector $route)
    {
        $reflectionClass  = new ReflectionClass($className);
        $classAnnotations = $this->reader->getClassAnnotations($reflectionClass);

        foreach ($classAnnotations as $classAnnotation) {
            if ($classAnnotation instanceof Controller) {
                foreach ($reflectionClass->getMethods() as $method) {
                    $methodAnnotations = $this->reader->getMethodAnnotations($method);
                    foreach ($methodAnnotations as $methodAnnotation){
                        if($methodAnnotation instanceof RequestMapping){
                            $methods = [];
                            foreach ($methodAnnotation->getMethod() as $value){
                                $methods[] = strtoupper($value);
                            }
                            $route->addRoute($methods,$classAnnotation->getPrefix().$methodAnnotation->getRoute(),[$className,$method->getName()]);
                        }
                    }
                }
            }
        }
    }

    /**
     * 获取php文件
     *
     * @param $controllerDir
     * @return \Generator
     */
    private function getPhpFile($controllerDir)
    {
        $list = scandir($controllerDir);
        foreach ($list as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            } elseif (is_dir($controllerDir . '/' . $file)) {
                yield $this->getPhpFile($controllerDir . '/' . $file)->current();
            } elseif (strpos($file, '.php') === false) {
                continue;
            } else {
                yield $controllerDir . '/' . $file;
            }
        }
    }
}