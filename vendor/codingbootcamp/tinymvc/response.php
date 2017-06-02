<?php

namespace codingbootcamp\tinymvc;

class response
{
    protected static $instance = null;

    protected $content = null;
    protected $flashed_variables = [];

    public static function getInstance()
    {
        if(static::$instance === null)
        {
            static::$instance = new response();
        }

        return static::$instance;
    }

    // send the current response
    public static function sendResponse()
    {
        // get the current response instance
        $response = static::getInstance();

        // send the response
        $response->send();
    }

    // set content of this response object
    // the content is the string that will be output
    // once the response is told to send content
    public function setContent($content)
    {
        $this->content = $content;
    }

    // print out the content
    public function send()
    {
        echo $this->content;
    }
}