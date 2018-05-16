<?php

if (!function_exists('env')) {
    /**
     * @param      $key
     * @param null $default
     * @return array|bool|false|null|string
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (strlen($value) > 1 && \GameWorker\Helper\StringHelper::startsWith($value, '"') && \GameWorker\Helper\StringHelper::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}