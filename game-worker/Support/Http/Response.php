<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/5/19
 * Time: 11:25
 */

namespace GameWorker\Support\Http;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http;

class Response implements ResponseInterface
{
    use ResponseTail;

    public function send()
    {
        $response = $this;

        /**
         * Headers
         */
        // Write Headers to swoole response
        foreach ($response->getHeaders() as $key => $value) {
            $this->header($key, implode(';', $value));
        }

        /**
         * Cookies
         */
        foreach ((array)$this->cookies as $domain => $paths) {
            foreach ($paths ?? [] as $path => $item) {
                foreach ($item ?? [] as $name => $cookie) {
                    if ($cookie instanceof Cookie) {
                        $this->setCookie($cookie->getName(), $cookie->getValue() ? : 1, $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
                    }
                }
            }
        }

        /**
         * Status code
         */
        $this->withStatus($response->getStatusCode());

        /**
         * Body
         */
        $this->connect->send($response->getBody()->getContents());
    }
}