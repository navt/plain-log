# Plain-log
Простая в использовании библиотека ведения журнала для PHP, совместимая с [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md). Минималистичная, легко расширяемая, предназначена для быстрого включения в прект. Много идей и фрагментов кода взято из библиотеки [pear/Log](https://github.com/pear/Log).
## Установка
Включите в свой `composer.json` следующие элементы
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
Выполните в консоли
```bash
$ composer update
```
## Использование
```php
<?php

use Plain\Logger;
use Psr\Log\LogLevel;

require_once "/vendor/autoload.php";

// создаете экземпляр логгера для вывода в консоль с помощью singleton 
// или factory
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
// вывод в консоль произойдет
$console->error("This array from error:", $a);

// вывода не будет
$console->debug("This debug message", $a);
```
### Вывод
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
Примеры использования смотрите в [`/examples/`](https://github.com/navt/plain-log/tree/master/examples).

## Установка порогового значения уровня логгирования
Plain-log реализует Psr\Log\LoggerInterface, поэтому вы можете использовать константы [Psr\Log\LogLevel](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#5-psrlogloglevel) для установки порогового уровня логгирования, чтобы не регистрировать сообщения ниже этого уровня. В приведённом выше примере выставлен порог `LogLevel::WARNING`.
Уровень по умолчанию - `DEBUG` и в этом случае все сообщения будут регистрироваться.