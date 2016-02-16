<?php

namespace NetglueIp\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use NetglueIp\Service\IpService;

class RealIp extends AbstractPlugin
{

    /**
     * @var IpService
     */
    private $ipService;

    /**
     * Constructor
     */
    public function __construct(IpService $service)
    {
        $this->ipService = $service;
    }

    /**
     * Invoke
     * @return string|null
     */
    public function __invoke()
    {
        return $this->ipService->getIp();
    }

}
