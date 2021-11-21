# Plain-log
Easy-to-use logging library for PHP, compatible with [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md). Minimalistic, easily expandable, designed to be quickly incorporated into a project. Many ideas and code snippets are taken from the [pear/Log](https://github.com/pear/Log).
## Installation
Include the following elements in your `composer.json`
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/navt/plain-log"
        }
    ],
    "require": {
        "navt/plain-log": "dev-master"
    }
}
```
Execute in console
```bash
$ composer update
```
## Usage
```php
<?php

use Plain\Logger;
use Psr\Log\LogLevel;

require_once "/vendor/autoload.php";

// create a logger instance for console output using a singleton or factory
$console = Logger::singleton("console", "", LogLevel::WARNING);
// $console = Logger::factory("console", "", LogLevel::WARNING);
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
// output to console  take place
$console->error("This array from error:", $a);

// not output
$console->debug("This debug message", $a);
```
### Output
```log
[2021-11-19 14:50:42.053] [Error] This array from error:
array (
  'bool' => true,
  'null' => NULL,
  'string' => 'Foo',
  'int' => 0,
  'float' => 0.5,
  'nested' => 
  array (
    'with object' => 
    (object) array(
    ),
  ),
  'object' => 
  DateTime::__set_state(array(
     'date' => '2021-11-19 14:50:42.053831',
     'timezone_type' => 3,
     'timezone' => 'Europe/Moscow',
  )),
  'resource' => NULL,
)
```
See examples of use in [`/examples/`](https://github.com/navt/plain-log/tree/master/examples).

## Setting the threshold value of the logging level
Plain-log implements Psr\Log\LoggerInterface, so you can use the  [Psr\Log\LogLevel](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#5-psrlogloglevel) constants to set the logging threshold to not log messages below this level. In the above example, the threshold is `LogLevel::WARNING`. 
The default level is `DEBUG`, in which case all messages will be logged.