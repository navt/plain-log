<?php
namespace Plain\Options;

use Psr\Log\AbstractLogger;
use DateTime;

class File extends AbstractLogger
{
    private $active = false;
    private $logPath = "app.log";
    private $pointer = false;
    private $needClose = false;

    private $fileMode = 0644;
    private $dirMode = 0775;

    public function __construct(string $store, bool $active) {
        $this->active = $active;

        if ($store != "") {
            $this->logPath = $store;
        }
        
        if (is_dir(dirname($this->logPath)) === false) {
            $this->mkPath($this->logPath, $this->dirMode);
        }

        $this->open();

        register_shutdown_function([$this, "close"]);
    }

    // Function code taken from 
    // https://github.com/pear/Log/blob/master/Log/file.php#L174
    private function mkPath(string $path, int $mode = 0777) {
        /* Separate the last pathname component from the rest of the path. */
        $head = dirname($path);
        $tail = basename($path);

        /* Make sure we've split the path into two complete components. */
        if (empty($tail)) {
            $head = dirname($path);
            $tail = basename($path);
        }

        /* Recurse up the path if our current segment does not exist. */
        if (!empty($head) && !empty($tail) && !is_dir($head)) {
            $this->mkPath($head, $mode);
        }

        /* Create this segment of the path. */
        return @mkdir($head, $mode);
    }

    private function open() {
        $isNew = !file_exists($this->logPath);
        $this->pointer = fopen($this->logPath, 'a');

        $this->needClose = ($this->pointer !== false);

        if ($isNew && $this->needClose) {
            chmod($this->logPath, $this->fileMode);
        }
    }

    public function close() {

        if ($this->needClose && fclose($this->pointer)) {
            $this->needClose = false;
        }

    }

    public function log($level, $message, array $context = []) {
        if ($this->active === false) return;
        if ($this->needClose !== true) return;

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
        fwrite($this->pointer, $out);
    }

    private function displayContext(array $context=[]) {
        return ($context == []) ? "" : var_export($context, true).PHP_EOL;
    }
}