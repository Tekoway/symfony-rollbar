<?php
namespace Tekoway\Rollbar\EventListener;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Tekoway\Rollbar\Services\RollbarManager;


class ErrorListener implements EventSubscriberInterface
{
    /**
     * @var 
     */
    private $rollbarManager;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var callable
     */
    private $previousErrorHandler;

    /**
     * @param RollbarReporter $exceptionReporter [description]
     * @param RequestStack    $requestStack      [description]
     */
    public function __construct(RollbarManager $rollbarManager, RequestStack $requestStack)
    {
        $this->rollbarManager = $rollbarManager;
        $this->requestStack = $requestStack;
        set_error_handler(array($this, 'handleError'));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', 128),
            ConsoleEvents::EXCEPTION => array('onConsoleException', 128),
        );
    }

    /**
     * @param   $level   
     * @param   $message 
     * @param   $file    
     * @param   $line    
     * @return           
     */
    public function handleError($level, $message, $file, $line)
    {
        return $this->rollbarManager->reportError($level, $message, $file, $line);
    }


    /**
     * Report kernel exception.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        return $this->reportException($event->getException());
    }


    /**
     * Report console exception.
     *
     * @param \Symfony\Component\Console\Event\ConsoleExceptionEvent $event
     */
    public function onConsoleException(ConsoleExceptionEvent $event)
    {
        return $this->reportException($event->getException());
    }


    /**
     * @param \Exception $exception
     * @return string
     */
    private function reportException(\Exception $exception)
    {
        return $this->rollbarManager->report($exception);
    }
}