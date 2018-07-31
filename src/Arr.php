<?php

namespace Oilstone\Support;

use Illuminate\Support\Arr as ArrHelper;
use Illuminate\Support\Str;

/**
 * Class Arr
 * @package Oilstone\Support
 */
class Arr extends ArrHelper
{
    /**
     * @param array $input
     * @return array
     * @deprecated
     */
    public static function keysToCamelCase(array $input)
    {
        return static::camelKeys($input, false);
    }

    /**
     * @param array $input
     * @return array
     * @deprecated
     */
    public static function keysToSnakeCase(array $input)
    {
        return static::snakeKeys($input, false);
    }

    /**
     * @param array $array
     * @param bool $recursive
     * @return array
     */
    public static function camelKeys(array $array, bool $recursive = true): array
    {
        $camelCased = [];

        foreach ($array as $key => $value) {
            $key = Str::camel($key);

            if ($recursive && is_array($value)) {
                $value = static::camelKeys($value);
            }

            $camelCased[$key] = $value;
        }

        return $camelCased;
    }

    /**
     * @param array $array
     * @param bool $recursive
     * @return array
     */
    public static function snakeKeys(array $array, bool $recursive = true): array
    {
        $camelCased = [];

        foreach ($array as $key => $value) {
            $key = Str::snake($key);

            if ($recursive && is_array($value)) {
                $value = static::snakeKeys($value);
            }

            $camelCased[$key] = $value;
        }

        return $camelCased;
    }

    /**
     * @param array $array
     * @param int $columns
     * @return array
     */
    public static function splitVertically(array $array, $columns = 2): array
    {
        return array_chunk($array, ceil(count($array) / $columns));
    }
}