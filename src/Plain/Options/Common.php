<?php
namespace Plain\Options;

use Psr\Log\LogLevel;

class Common
{
    public static $logLevels = [
        LogLevel::EMERGENCY => 7,
        LogLevel::ALERT     => 6,
        LogLevel::CRITICAL  => 5,
        LogLevel::ERROR     => 4,
        LogLevel::WARNING   => 3,
        LogLevel::NOTICE    => 2,
        LogLevel::INFO      => 1,
        LogLevel::DEBUG     => 0,
    ];

    public static $dateFormat = 'Y-m-d H:i:s.v';
    public static $outFormat  = "[%s] [%s] %s".PHP_EOL."%s";
}