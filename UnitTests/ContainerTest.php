<?php 

namespace Tekoway\Rollbar\UnitTests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Container test
 */
class ContainerTest extends KernelTestCase
{

    public function testContainerHasRollbarManager()
    {
        $this->assertTrue($this->getContainer()->has('tekoway.manager.rollbar'));
    }

    public function testContainerHasRollbarLogger()
    {
        $this->assertTrue($this->getContainer()->has('tekoway.logger.rollbar'));
    }

    public function testContainerHasRollbarExceptionListener()
    {
        $this->assertTrue($this->getContainer()->has('tekoway.listener.rollbar_exception'));
    }

    private function getContainer()
    {
        return static::$kernel->getContainer();
    }

    protected function setUp()
    {
        $this->bootKernel();
    }
}