<?php

namespace Tekoway\Rollbar\Services;

use Tekoway\Rollbar\Services\RollbarManager;
use Tekoway\Rollbar\Helper\LogLevel;

class RollbarLogger 
{

    /**
     * @var RollbarManager
     */
    private $rollbarManager;

    /**
     * @param RollbarManager $rollbarManager 
     */
    public function __construct(RollbarManager $rollbarManager){
        $this->rollbarManager = $rollbarManager;
    }

    /**
     * @param  string $message 
     * @return boolean
     */
    public function emergency($message){
        return $this->rollbarManager->addLog(LogLevel::EMERGENCY, $message);
    }

    /**
     * @param  string $message 
     * @return boolean
     */
    public function alert($message){
        return $this->rollbarManager->addLog(LogLevel::ALERT, $message);
    }


    /**
     * @param  string $message 
     * @return boolean
     */
    public function critical($message){
        return $this->rollbarManager->addLog(LogLevel::CRITICAL, $message);
    }

    /**
     * @param  string $message 
     * @return boolean
     */
    public function error($message){
        return $this->rollbarManager->addLog(LogLevel::ERROR, $message);
    }

    /**
     * @param  string $message 
     * @return boolean
     */
    public function warning($message){
        return $this->rollbarManager->addLog(LogLevel::WARNING, $message);
    }

    /**
     * @param  string $message 
     * @return boolean
     */
    public function notice($message){
        return $this->rollbarManager->addLog(LogLevel::NOTICE, $message);
    }

    /**
     * @param  string $message 
     * @return boolean
     */
    public function info($message){
        return $this->rollbarManager->addLog(LogLevel::INFO, $message);
    }

    /**
     * @param  string $message 
     * @return boolean
     */
    public function debug($message){
        return $this->rollbarManager->addLog(LogLevel::DEBUG, $message);
    }
}