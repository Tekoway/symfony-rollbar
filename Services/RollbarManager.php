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
     * @var array
     */
    private $exceptionsIgnoreList;

    /**
     * @param string    $token      
     * @param string    $env        
     * @param int       $errorLevel 
     * @param boolean   $enabled
     * @param array     $exceptionsIgnoreList
     */
    public function __construct($token, $env, $errorLevels, $enabled, $exceptionsIgnoreList){
        $this->errorLevels = $errorLevels;
        $this->enabled = $enabled;
        $this->exceptionsIgnoreList = $exceptionsIgnoreList;
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
        if($this->enabled && $this->isLevelAllowed($level) && !$this->isIgnored($exception)){
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

    /**
     * @param \Exception $exception
     * @return bool
     */
    protected function isIgnored(\Exception $exception){
        $isIgnored = false;
        if (is_array($this->exceptionsIgnoreList) && count($this->exceptionsIgnoreList) > 0) {
            foreach($this->exceptionsIgnoreList as $ignoredException){
                if($exception instanceof $ignoredException){
                    $isIgnored = true;
                    break;
                }
            }
        }

        return $isIgnored;
    }
}