<?php

namespace Oilstone\Support;

use Illuminate\Support\Arr as BaseArr;

class Arr extends BaseArr {
    
    /**
     * Convert array keys to camelCase
     *
     * @param  array input
     * @return array
     */
    public static function keysToCamelCase(array $input) {

        $output = [];
        
        foreach($input as $key => $value) {

            $output[camel_case($key)] = (is_array($value)) ? self::keysToCamelCase($value) : $value;
        }
        
        return $output;
    }
    
    /**
     * Convert array keys to snake_case
     *
     * @param  array input
     * @return array
     */
    public static function keysToSnakeCase(array $input) {

        $output = [];
        
        foreach($input as $key => $value) {

            $output[snake_case($key)] = (is_array($value)) ? self::keysToSnakeCase($value) : $value;
        }
        
        return $output;
    }
}
