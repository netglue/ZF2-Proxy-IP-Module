<?php
namespace NetglueIpTest\Controller\Plugin;

use NetglueIp\Service\IpService;
use NetglueIp\Controller\Plugin\RealIp;

use NetglueIpTest\bootstrap;

use Zend\Stdlib\Message as AbstractRequest;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Stdlib\Parameters;

class RealIpTest extends \PHPUnit_Framework_TestCase
{

    public function testHelperIsAvailableByShortName()
    {
        $services = bootstrap::getServiceManager();
        $manager = $services->get('ControllerPluginManager');
        $this->assertTrue($manager->has('realIp'));
        $this->assertInstanceOf('NetglueIp\Controller\Plugin\RealIp', $manager->get('realIp'));
    }

    public function testHelperIsInvokable()
    {
        $services = bootstrap::getServiceManager();
        $manager = $services->get('ControllerPluginManager');
        $plugin = $manager->get('realIp');
        $this->assertEmpty($plugin());
    }

    public function testHelperReturnsNullOnConsole()
    {
        $services = bootstrap::getServiceManager();
        $manager = $services->get('ControllerPluginManager');
        $plugin = $manager->get('realIp');
        $this->assertNull($plugin());
    }

    public function testHelperReturnsIpInMockedRequest()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
        ]));
        $service = new IpService($request);
        $helper = new RealIp($service);
        $this->assertSame('127.0.0.1', $helper());
    }

}
