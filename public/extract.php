<?php

class foo
{
    public $name = 'Jan';
    public $age = 88;
}

$me = new foo();

$properties = get_object_vars($me);

var_dump($properties);

$array = [
    'first' => 'Value of first',
    'second' => 'Value of second'
];

extract(get_object_vars($me));

echo $name;