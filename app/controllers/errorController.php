<?php

namespace app\controllers;

// FQN: \app\controllers\errorController
class errorController
{
    public function error404()
    {
        return '404: page not found, darling';
    }

    public function error500()
    {
        return '500: oops, something happened';
    }
}