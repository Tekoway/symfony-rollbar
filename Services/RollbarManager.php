<?php
namespace Tekoway\Rollbar\Services;

use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;
use Tekoway\Rollbar\Helper\LogLevel;

class RollbarManager
{
    /**
     * @var int
     */
    private $errorLevels;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @param string    $token      
     * @param string    $env        
     * @param int       $errorLevel 
     * @param boolean   $enabled    
     */
    public function __construct($token, $env, $errorLevels, $enabled){
        $this->errorLevels = $errorLevels;
        $this->enabled = $enabled;
        Rollbar::init([
            'access_token' => $token,
            'environment' => $env
        ]);
    }

    /**
     * @param  \Exception   $exception 
     * @param  array        $extraData 
     * @return boolean
     */
    public function report(\Exception $exception, $extraData = null){
        $response = false;
        $level = 1;
        if(method_exists($exception, 'getSeverity')){
            $level = $exception->getSeverity();
        }
        if($this->enabled && $this->isLevelAllowed($level)){
            Rollbar::log(Level::ERROR, $exception, $extraData);
            $response = true;
        }
        return $response;
    }

    /**
     * @param  int      $level   
     * @param  string   $message 
     * @param  string   $file    
     * @param  string   $line    
     * @return boolean          
     */
    public function reportError($level, $message, $file, $line){
        $response = false;
        if ($this->enabled && $this->isLevelAllowed($level)){
            Rollbar::log(Level::ERROR, $message, [
                'file' => $file,
                'line' => $line,
            ]);
            $response = true;
        }

        return $response;
    }

    /**
     * @param string $level   
     * @param string $message 
     */
    public function addLog($level, $message){
        if(!isset(LogLevel::$levels[$level])){
            throw new Exception("Log level: ".$level . " not found");
        }

        $mesage = date('[d-m-Y H:i:s] - ').$message;
        Rollbar::log(LogLevel::$levels[$level], $message);
        return true;
    }

    /**
     * @param  int  $level 
     * @return boolean        
     */
    protected function isLevelAllowed($level){
        $isAllowed = false;
        foreach($this->errorLevels as $errorLevel){
            if(constant($errorLevel) & $level){
                $isAllowed = true;
                break;
            }
        }
        return $isAllowed && (error_reporting() & $level);
    }
}