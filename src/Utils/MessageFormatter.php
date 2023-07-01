<?php

declare(strict_types=1);

namespace Eclesi\Validation\Utils;

class MessageFormatter
{
    public static function format(string $message, array $params): string
    {
        $keys = array_map(function ($key) {
            return '/{'.$key.'}/';
        }, array_keys($params));

        $message = preg_replace($keys, array_values($params), $message);

        return $message;
    }
}
