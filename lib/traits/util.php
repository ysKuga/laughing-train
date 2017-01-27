<?php

/**
 * utility method trait
 */
trait util {

    /**
     * explode $path to array using this
     * @var string explode() first argument
     */
    static public $hash_delimiter = '.';

    static public function hash_keys($path = null) {
        $keys = array();
        if (is_string($path) || is_numeric($path)) {
            $keys = explode(static::$hash_delimiter, $path);
        } else if (is_array($path)) {
            // if array, direct dimension search
            $keys = $path;
        }
        return $keys;
    }

    /**
     * if true hash_get() cast Object $data to Array
     * @var boolean allow access object like array 
     */
    static public $hash_object_access = false;

    /**
     * CakePHP Hash::get like method
     * 
     * @param array $data seach target
     * @param mixed $path explode by static::$hash_object_access or direct dimension as array
     * @param mixed $default not found, return value
     * @return mixed searched value
     */
    static public function hash_get($data = null, $path = null, $default = null) {
        // get value from multiple dimension array method like CakePHP Hash::get()
        $now_data = array();
        // init $return_value
        $value = $default;
        //if object and object search true
        if ((is_object($data) && static::$hash_object_access)
                // or array
                || is_array($data)) {
            // set search target
            $now_data = (array) $data;
        } else if (!is_array($now_data)) {
            return $value;
        }
        $keys = static::hash_keys($path);
        while (list($key_index, $key) = each($keys)) {
            if (is_array($now_data) && isset($now_data[$key])) {
                // next dimension
                $now_data = $now_data[$key];
            } else {
                // stop searching
                break;
            }
            unset($keys[$key_index]);
        }
        // if full dimeinsion searched
        if (!count($keys)) {
            // set $value
            $value = $now_data;
        }
        return $value;
    }

}
