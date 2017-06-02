<?php

namespace codingbootcamp\tinymvc;

// FQN: \codingbootcamp\tinymvc\view
class view
{
    protected $__view_file = null;

    public function __construct($view_file)
    {
        $this->__view_file = $view_file;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        // turn on output buffering
        ob_start();

        // creates variables out of all properties of this object
        extract(get_object_vars($this));

        // include the view template
        include RESOURCES_DIR.'/views/'.$this->__view_file.'.php';

        // return the content of the included template
        return ob_get_clean();
    }
}