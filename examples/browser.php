<html>
    <head>
        <title>Logging in browser</title>
    </head>
    <body>
        Run this script through browser. See log in browser Console.
    </body>        
</html>    
<?php
error_reporting(E_ALL);
ini_set('display_errors', "1");

use Plain\Logger;
use Psr\Log\LogLevel;

require_once __DIR__."/../vendor/autoload.php";

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

$browser = Logger::singleton("browser", "", LogLevel::WARNING);

$browser->warning("This array from warning:", $a);
?>