<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/18
 * Time: 20:15
 */

namespace GameWorker\Annotation;

/**
 * 控制器自动解析注解路由
 *
 * @Annotation
 * @Target("CLASS")
 * @package GameWorker\Annotation
 */
class Controller
{
    /**
     * @var string 控制器前缀
     */
    private $prefix = '';

    /**
     * AutoController constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->prefix = $values['value'];
        }

        if (isset($values['prefix'])) {
            $this->prefix = $values['prefix'];
        }
    }

    /**
     * 获取controller前缀
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}