<?php
error_reporting(E_ALL);
ini_set('display_errors', "1");

use Plain\Logger;

require_once __DIR__."/../vendor/autoload.php";

$file = Logger::factory("file", __DIR__."/data/file.log", true);
// $file = Logger::factory("file", "", true);
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
$file->info("Это массив:", $a);

$b = "Hello from file!";
$file->debug("Это строка: $b");