<?php

namespace NetglueIp\Factory\Service;

use NetglueIp\Service\IpService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IpServiceFactory implements FactoryInterface
{
    /**
     * Get IP Service
     * @param ServiceLocatorInterface $serviceLocator
     * @return
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $request = $serviceLocator->get('Request');
        return new IpService($request);
    }
}
