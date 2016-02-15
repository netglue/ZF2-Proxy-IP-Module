<?php
namespace NetglueIp\View\Helper;

use Zend\View\Helper\AbstractHelper;
use NetglueIp\Service\IpService;

class RealIp extends AbstractHelper
{

    /**
     * @var IpService
     */
    private $ipService;

    /**
     * Constructor
     */
    public function __construct(IpService $ipService)
    {
        $this->ipService = $ipService;
    }

    /**
     * Invoke
     * @return self
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * Return detected IP address
     * @return string
     */
    public function __toString()
    {
        $ip = $this->ipService->getIp();
        return (null === $ip) ? '' : $ip;
    }

}
