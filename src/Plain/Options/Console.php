<?php
namespace Plain\Options;

use Psr\Log\AbstractLogger;
use DateTime;

class Console extends AbstractLogger
{
    private $active = false;
    private $stream = false;
    private $needClose = false;

    public function __construct(string $store, bool $active) {
        $this->active = $active;

        if (defined('STDOUT')) {
            $this->stream = STDOUT;
        } else {
            $this->stream = fopen('php://output', 'a');
            $this->needClose = true;
        }
    }

    public function log($level, $message, array $context = []) {
        if ($this->active === false) return;

        if (is_string($message) === false) {
            $s = var_export($message, true);
            $message = sprintf("Incorrect message: %s", $s);
        }

        $date = new DateTime();
        $outFormat = "[%s] [%s] %s".PHP_EOL."%s";
        $out = sprintf($outFormat,
            $date->format('Y-m-d H:i:s.v'), 
            ucfirst($level),
            $message,
            $this->displayContext($context));
        fputs($this->stream, $out);
    }

    private function displayContext(array $context=[]) {
        return ($context == []) ? "" : var_export($context, true).PHP_EOL;
    }

    public function close() {
        if ($this->needClose === true && is_resource($this->stream)) {
            fclose($this->stream);
        }
    }

}