<?php
error_reporting(E_ALL);
ini_set('display_errors', "1");

use Plain\Logger;

require_once __DIR__."/../vendor/autoload.php";

$console = Logger::factory("console", "", true);
$a = 
[
    'bool' => true,
    'null' => null,
    'string' => 'Foo',
    'int' => 0,
    'float' => 0.5,
    'nested' => ['with object' => new stdClass()],
    'object' => new \DateTime,
    'resource' => fopen('php://memory', 'r')
];
$console->debug("Это массив", $a);
