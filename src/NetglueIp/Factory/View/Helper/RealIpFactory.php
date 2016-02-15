<?php

namespace NetglueIp\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use NetglueIp\View\Helper\RealIp;

class RealIpFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $viewPluginManager
     * @return RealIp
     */
    public function createService(ServiceLocatorInterface $viewPluginManager)
    {
        $serviceLocator = $viewPluginManager->getServiceLocator();

        $plugin = new RealIp($serviceLocator->get('NetglueIp\Service\IpService'));

        return $plugin;
    }
}
