<?php
namespace NetglueIpTest\Service;

use NetglueIp\Service\IpService;
use Zend\Stdlib\Message as AbstractRequest;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Stdlib\Parameters;

class IpServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testIsConsole()
    {
        $service = new IpService(new ConsoleRequest);
        $this->assertTrue($service->isConsole());

        $service = new IpService(new PhpRequest);
        $this->assertFalse($service->isConsole());
    }

    public function testIsPhpRequest()
    {
        $service = new IpService(new PhpRequest);
        $this->assertTrue($service->isPhpRequest());

        $service = new IpService(new ConsoleRequest);
        $this->assertFalse($service->isPhpRequest());
    }


    public function testIpIsNullOnConsole()
    {
        $service = new IpService(new ConsoleRequest);
        $this->assertNull($service->getRemoteAddress());
        $this->assertNull($service->getForwardFor());
        $this->assertNull($service->getCloudflareConnectingIp());
        $this->assertNull($service->getIp());
    }

    public function testGetRemoteAddr()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
        ]));
        $service = new IpService($request);

        $this->assertSame('127.0.0.1', $service->getRemoteAddress());
    }

    public function testGetCloudFlare()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_CF_CONNECTING_IP' => '127.0.0.2',
        ]));
        $service = new IpService($request);

        $this->assertSame('127.0.0.2', $service->getCloudflareConnectingIp());
    }

    public function testGetForwardForBasic()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_CF_CONNECTING_IP' => '127.0.0.2',
            'HTTP_X_FORWARDED_FOR' => '127.0.0.3',
        ]));
        $service = new IpService($request);

        $this->assertSame('127.0.0.3', $service->getForwardFor());
    }

    public function testGetForwardForAsArrayReturnsFirstInList()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_CF_CONNECTING_IP' => '127.0.0.2',
            'HTTP_X_FORWARDED_FOR' => '127.0.0.3, 127.0.0.4',
        ]));
        $service = new IpService($request);

        $this->assertSame('127.0.0.3', $service->getForwardFor());
    }

    public function testCloudflarePreferredIfPresent()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_CF_CONNECTING_IP' => '127.0.0.2',
            'HTTP_X_FORWARDED_FOR' => '127.0.0.3, 127.0.0.4',
        ]));
        $service = new IpService($request);

        $this->assertSame('127.0.0.2', $service->getIp());
    }

    public function testForwardForPreferredIfPresent()
    {
        $request = new PhpRequest;
        $request->setServer(new Parameters([
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_X_FORWARDED_FOR' => '127.0.0.3, 127.0.0.4',
        ]));
        $service = new IpService($request);

        $this->assertSame('127.0.0.3', $service->getIp());
    }


}

