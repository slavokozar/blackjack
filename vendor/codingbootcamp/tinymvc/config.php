<?php

namespace codingbootcamp\tinymvc;

class config
{
    // the configuration
    protected static $config = [];

    /**
     * loads the configuration from one configuration file
     */
    protected static function loadConfig($name)
    {
        if(!isset(static::$config[$name]))
        {
            // initialize $config as empty array
            $config = [];

            // include the file with configuration for this
            // config family $name
            include CONFIG_DIR . '/' . $name . '.php';

            // save the retrieved configuration into the
            // static configuration under the key $name
            static::$config[$name] = $config;
        }
    }

    /**
     * returns a configuration value or the value of $default
     */
    public static function get($key, $default = null)
    {
        $file_key = explode('.', $key);
        $config_file = $file_key[0];
        $config_key = $file_key[1];

        static::loadConfig($config_file);

        if(array_key_exists($config_key, static::$config[$config_file]))
        {
            return static::$config[$config_file][$config_key];
        }
        else
        {
            return $default;
        }
    }
}