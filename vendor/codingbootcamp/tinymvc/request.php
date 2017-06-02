<?php

namespace codingbootcamp\tinymvc;

// request class
class request
{

    /**
     * get a value from request
     *
     * return the value or the value of $default if it is not found
     */
    public static function get($name, $default = null)
    {
        // if(array_key_exists($name, $_REQUEST))
        // {
        //     return $_REQUEST[$name];
        // }
        // else
        // {
        //     return $default;
        // }
        // [condition] ? [if_true] : [if_false]
        return array_key_exists($name, $_REQUEST) ? $_REQUEST[$name] : $default;
    }



}