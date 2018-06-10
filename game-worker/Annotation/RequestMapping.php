<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 20:20
 */

namespace GameWorker\Annotation;

/**
 * action方法注解
 *
 * @Annotation
 * @Target("METHOD")
 */
class RequestMapping
{
    /**
     * action路由规则
     *
     * @var string
     */
    private $route = '';

    /**
     * 路由支持的HTTP方法集合
     *
     * @var array
     */
    private $method = [RequestMethod::GET, RequestMethod::POST];

    /**
     * {"id"="\d+"}
     * @var array
     */
    private $params = [];

    /**
     * {"id"=12}
     * @var array
     */
    private $defaults = [];

    /**
     * RequestMapping constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->route = $values['value'];
        }

        if (isset($values['route'])) {
            $this->route = $values['route'];
        }

        if (isset($values['method'])) {
            $method = $values['method'];
            $this->method = (array)$method;
            $this->method = array_change_key_case($this->method,CASE_UPPER);
        }

        if (isset($values['params'])) {
            $this->params = $values['params'];
        }

        if (isset($values['defaults'])) {
            $this->defaults = $values['defaults'];
        }
    }

    /**
     * 获取路由
     *
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * 获取方法集合
     *
     * @return array
     */
    public function getMethod(): array
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     * @param array $defaults
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
    }
}