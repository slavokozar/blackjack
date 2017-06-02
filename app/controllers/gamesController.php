<?php

namespace app\controllers;

use \codingbootcamp\tinymvc\view as view;

class gamesController
{
    // listing action of games controller
    public function listing()
    {
        $document = new view('document');
        $document->title = 'List of games';

        return $document;
    }
}