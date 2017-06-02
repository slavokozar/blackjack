<?php

namespace app\controllers;

use \codingbootcamp\tinymvc\view as view;
use \codingbootcamp\tinymvc\config as config;

class indexController
{
    // index action of index controller
    public function index()
    {

        var_dump($_POST);
        
        // /resources/views/navigation.php
        $navigation = new view('navigation');
        $navigation->current_page = 'home';

        // /resources/views/   document     .php
        $document = new view('document');
        $document->content = '<h1>This is the homepage</h1>';
        $document->navigation = $navigation;

        return $document;
    }
}