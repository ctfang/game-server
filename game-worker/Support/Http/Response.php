<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/19
 * Time: 11:25
 */

namespace GameWorker\Support\Http;

use Psr\Http\Message\ResponseInterface;
use Workerman\Protocols\Http;

class Response implements ResponseInterface
{
    use ResponseTail;

    public $statusCode = '';
    public $reasonPhrase = '';

    public function send()
    {
        // Write Headers to swoole response
        foreach ($this->getHeaders() as $key => $value) {
            $this->header($key, implode(';', $value));
        }

        /**
         * Cookies
         */
        foreach ((array)$this->cookies as $domain => $paths) {
            foreach ($paths ?? [] as $path => $item) {
                foreach ($item ?? [] as $name => $cookie) {
                    if ($cookie instanceof Cookie) {
                        $this->setCookie($cookie->getName(), $cookie->getValue() ?: 1, $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
                    }
                }
            }
        }

        /**
         * Status code
         */
        Http::header($this->getReasonPhrase(), true, $this->getStatusCode());
        /**
         * Body
         */
        $this->connect->send($this->getBody()->getContents());
    }
}