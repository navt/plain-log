<?php
namespace Plain\Options;

use Psr\Log\AbstractLogger;
use DateTime;

class Console extends AbstractLogger
{
    private $threshold = "";
    private $stream = false;
    private $needClose = false;

    public function __construct(string $store, string $threshold) {
        $this->threshold = $threshold;

        if (defined('STDOUT')) {
            $this->stream = STDOUT;
        } else {
            $this->stream = fopen('php://output', 'a');
            $this->needClose = true;
        }

        if ($this->needClose === true) {
            register_shutdown_function([$this, "close"]);
        }
    }

    public function log($level, $message, array $context = []) {
        if (Common::$logLevels[$level] < Common::$logLevels[$this->threshold]) return;

        if (is_string($message) === false) {
            $s = var_export($message, true);
            $message = sprintf("Incorrect message: %s", $s);
        }

        $date = new DateTime();
        $out = sprintf(Common::$outFormat,
            $date->format(Common::$dateFormat), 
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