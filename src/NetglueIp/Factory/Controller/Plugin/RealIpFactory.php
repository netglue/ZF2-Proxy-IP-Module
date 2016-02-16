<?php

namespace NetglueIp\Factory\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use NetglueIp\Controller\Plugin\RealIp;

class RealIpFactory implements FactoryInterface
{

    /**
     * Return RealIp Plugin
     * @param  ServiceLocatorInterface $controllerPluginManager
     * @return RealIp
     */
    public function createService(ServiceLocatorInterface $controllerPluginManager)
    {
        $serviceLocator = $controllerPluginManager->getServiceLocator();
        $service = $serviceLocator->get('NetglueIp\Service\IpService');

        return new RealIp($service);
    }

}
