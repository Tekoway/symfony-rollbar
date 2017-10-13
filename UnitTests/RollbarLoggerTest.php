<?php 

namespace Tekoway\Rollbar\UnitTests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * tekoway.logger.rollbar service test
 */
class RollbarLoggerTest extends KernelTestCase
{

    private $logger;


    public function hasCriticalMethod(){
        $this->assertTrue(method_exists($this->logger, 'critical'));
    }

    public function testHasInfoMethod(){
        $this->assertTrue(method_exists($this->logger, 'info'));
    }

    public function testHasDebugMethod(){
        $this->assertTrue(method_exists($this->logger, 'debug'));
    }

    public function testHasErrorMethod(){
        $this->assertTrue(method_exists($this->logger, 'error'));
    }

    public function testHasEmergencyMethod(){
        $this->assertTrue(method_exists($this->logger, 'emergency'));
    }

    public function testHasAlertMethod(){
        $this->assertTrue(method_exists($this->logger, 'alert'));
    }

    public function testHasNoticeMethod(){
        $this->assertTrue(method_exists($this->logger, 'notice'));
    }

    public function testHasWarningMethod(){
        $this->assertTrue(method_exists($this->logger, 'warning'));
    }

    private function getContainer()
    {
        return static::$kernel->getContainer();
    }

    protected function setUp()
    {
        $this->bootKernel();
        $this->logger = $this->getContainer()->get('tekoway.logger.rollbar');
    }
}