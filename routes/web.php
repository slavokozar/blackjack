<?php

$routes = [
    // this is where our routes will go

    // route to homepage (default)
    'homepage' => [
        'controller' => 'blackjackController', 
        'action' => 'index'
    ],

    'play' => [
        'controller' => 'blackjackController',
        'action' => 'play'
    ],

    'hit' => [
        'controller' => 'blackjackController',
        'action' => 'hit'
    ],

    'stand' => [
        'controller' => 'blackjackController',
        'action' => 'stand'
    ],

];