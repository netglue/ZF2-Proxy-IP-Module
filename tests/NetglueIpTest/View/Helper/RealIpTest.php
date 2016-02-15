<?php
namespace NetglueIpTest\View\Helper;

use NetglueIp\Service\IpService;
use NetglueIp\View\Helper\RealIp;

use NetglueIpTest\bootstrap;

use Zend\Stdlib\Message as AbstractRequest;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Stdlib\Parameters;

class RealIpTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $services = bootstrap::getServiceManager();
    }

    public function testHelperIsAvailableByShortName()
    {
        $services = bootstrap::getServiceManager();
        $manager = $services->get('ViewHelperManager');
        $this->assertTrue($manager->has('realIp'));
        $this->assertInstanceOf('NetglueIp\View\Helper\RealIp', $manager->get('realIp'));
    }

    public function testHelperIsInvokable()
    {
        $services = bootstrap::getServiceManager();
        $manager = $services->get('ViewHelperManager');
        $plugin = $manager->get('realIp');
        $this->assertSame($plugin, $plugin());
    }

    public function testHelperReturnsEmptyStringOnConsole()
    {
        $services = bootstrap::getServiceManager();
        $manager = $services->get('ViewHelperManager');
        $plugin = $manager->get('realIp');
        $this->assertSame('', (string) $plugin() );
    }

    public function testHelperReturnsIpInMockedRequest()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
        ]));
        $service = new IpService($request);
        $helper = new RealIp($service);
        $this->assertSame('127.0.0.1', (string) $helper());
    }

}
