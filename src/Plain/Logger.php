<?php
namespace Plain;

class Logger 
{

    public function __construct() { }

    public static function factory(string $mode, string $store, string $threshold) {
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
    
}
