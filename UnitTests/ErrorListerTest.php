<?php

namespace Tekoway\Rollbar\UnitTests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;



class ErrorListerTest extends KernelTestCase
{
    private $errorListener;

    public function testOnKernelExceptionEvent(){
        $event = new GetResponseForExceptionEvent(static::$kernel, new Request(), null, new \Exception('test kernel exception'));
        $result = $this->errorListener->onKernelException($event);
        $this->assertTrue(is_bool($result));
    }

    public function testonConsoleExceptionEvent(){
        $command =  new Command('test_command');
        $input = new StringInput('test:command');
        $output = new ConsoleOutput();
        $event = new ConsoleExceptionEvent($command, $input, $output, new \Exception('test console exception'), 1);
        $result = $this->errorListener->onConsoleException($event);
        $this->assertTrue(is_bool($result));
    }

    protected function setUp()
    {
        $this->bootKernel();
        $this->errorListener = $this->getContainer()->get('tekoway.listener.rollbar_exception');
    }

    private function getContainer()
    {
        return static::$kernel->getContainer();
    }

}