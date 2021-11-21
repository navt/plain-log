<?php
namespace Plain;

use Psr\Log\LogLevel;

class Logger 
{
    private static $instances = [];

    public function __construct() { }

    public static function factory(
        string $mode, 
        string $store, 
        string $threshold = LogLevel::DEBUG) {
        
        $mode = ucfirst($mode);
        $class = sprintf("Plain\Options\%s", $mode);
        
        $ds = DIRECTORY_SEPARATOR;
        $classPath = sprintf("%s%sOptions%s%s.php", __DIR__, $ds, $ds, $mode);

        if (file_exists($classPath) === false) {
            return null;
        }
 
        if (class_exists($class, false) === false) {
            $object = new $class($store, $threshold);
            return $object;
        }

        return null;
    }

    public static function singleton(
        string $mode, 
        string $store, 
        string $threshold = LogLevel::DEBUG) {

        $sign = serialize([$mode, $store, $threshold]);
        
        if (!isset(self::$instances[$sign])) {
            self::$instances[$sign] = Logger::factory($mode, $store, $threshold);
        }

        return self::$instances[$sign];
    }
    
}
