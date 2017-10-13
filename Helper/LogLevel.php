<?php
namespace Tekoway\Rollbar\Helper;

use \Rollbar\Payload\Level;

class LogLevel{

    const EMERGENCY = 'emergency';
    const ALERT = 'alert';
    const CRITICAL = 'critical';
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'notice';
    const INFO = 'info';
    const DEBUG = 'debug';

    public static $levels = [
        self::EMERGENCY => Level::EMERGENCY,
        self::ALERT => Level::ALERT,
        self::CRITICAL => Level::CRITICAL,
        self::ERROR => Level::ERROR,
        self::WARNING => Level::WARNING,
        self::NOTICE => Level::NOTICE,
        self::INFO => Level::INFO,
        self::DEBUG => Level::DEBUG
    ];
}