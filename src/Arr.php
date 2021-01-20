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
    public static function keysToCamelCase(array $input): array
    {
        return static::camelKeys($input, false);
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
     * @param array $input
     * @return array
     * @deprecated
     */
    public static function keysToSnakeCase(array $input): array
    {
        return static::snakeKeys($input, false);
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

    /**
     * @param array|null $data
     * @return array|null
     */
    public static function prepareUtf8(?array $data): ?array
    {
        if (!isset($data)) {
            return null;
        }

        array_walk_recursive($data, function (&$item) {
            if (is_string($item) && !mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $data;
    }

    /**
     * https://www.php.net/manual/en/function.array-diff-assoc.php#111675
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function diffRecursive(array $array1, array $array2): array
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (!isset($array2[$key]) || !is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = static::diffRecursive($value, $array2[$key]);

                    if (!empty($new_diff)) {
                        $difference[$key] = $new_diff;
                    }
                }
            } else if (!array_key_exists($key, $array2) || $array2[$key] !== $value) {
                $difference[$key] = $value;
            }
        }

        return $difference;
    }

    /**
     * @param array $array
     * @param bool $recursive
     * @return array
     */
    public static function lowerKeys(array $array, bool $recursive = true): array
    {
        $lowerCased = [];

        foreach ($array as $key => $value) {
            $key = Str::lower($key);

            if ($recursive && is_array($value)) {
                $value = static::lowerKeys($value);
            }

            $lowerCased[$key] = $value;
        }

        return $lowerCased;
    }

    /**
     * @param array $array1
     * @param mixed ...$arrays
     * @return array
     */
    public static function mergeRecursiveDistinct(array $array1, ...$arrays): array
    {
        foreach ($arrays as $array2) {
            foreach ($array2 as $key => $value) {
                if (is_integer($key)) {
                    $result[] = $value;
                } else if (isset($array1[$key]) && is_array($array1[$key]) && is_array($value)) {
                    $array1[$key] = static::mergeRecursiveDistinct($array1[$key], $value);
                } else {
                    $array1[$key] = $value;
                }
            }
        }

        return $array1;
    }
}
