<?php
namespace Plain\Options;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use DateTime;

class Browser extends AbstractLogger
{
    private $threshold = "";
    private $store; 
    private $methods = [
        LogLevel::EMERGENCY => "error",
        LogLevel::ALERT     => "error",
        LogLevel::CRITICAL  => "error",
        LogLevel::ERROR     => "error", 
        LogLevel::WARNING   => "warn",  
        LogLevel::NOTICE    => "info",
        LogLevel::INFO      => "info",  
        LogLevel::DEBUG     => "log",   
    ];
    private $js = 
        '<script type="text/javascript">'.PHP_EOL.
        '    if (window.console) {'.PHP_EOL.
        '        console.%method%("%out%");'.PHP_EOL.
        '    }'.PHP_EOL.
        '</script>';

    public function __construct(string $store, string $threshold) {
        $this->threshold = $threshold;
        $this->store = $store;
    }

    public function log($level, $message, array $context = []) {
        if (Common::$logLevels[$level] < Common::$logLevels[$this->threshold]) return;

        if (!is_string($message)) {
            $s = var_export($message, true);
            $message = sprintf("Incorrect message: %s", $s);
        }

        $date = new DateTime();
        $out = sprintf(Common::$outFormat,
            $date->format(Common::$dateFormat), 
            ucfirst($level),
            $message,
            $this->displayContext($context));
        $out = preg_replace("~\r?\n~", "\\n", $out);
        $method = $this->methods[$level];
        $js = str_replace(["%method%", "%out%"], [$method, $out], $this->js);
        echo $js;
    }

    private function displayContext(array $context=[]) {
        if ($context == []) return "";
        
        $dump = print_r($context, true);
        
        if(strpos($dump, Common::$recursion) !== false) {
            return addslashes($dump).PHP_EOL;
        }

        return addslashes(var_export($context, true)).PHP_EOL;
    }
}