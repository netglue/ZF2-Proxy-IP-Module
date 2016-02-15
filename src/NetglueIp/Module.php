<?php

namespace NetglueIp;

use Zend\Console\Request as ConsoleRequest;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\EventManager\EventInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature;
use Zend\Mvc\MvcEvent;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\ControllerProviderInterface,
    Feature\ServiceProviderInterface,
    Feature\DependencyIndicatorInterface,
    Feature\ControllerPluginProviderInterface,
    Feature\ViewHelperProviderInterface,
    Feature\BootstrapListenerInterface
{
    /**
     * Expected to return an array of module names on which the current one depends on
     *
     * @return array
     */
    public function getModuleDependencies()
    {
        return [

        ];
    }

    /**
     * Return autoloader configuration
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            AutoloaderFactory::STANDARD_AUTOLOADER => [
                StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * Include/Return module configuration
     * @return array
     * @implements ConfigProviderInterface
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Bootstrap Listener
     *
     * @param EventInterface $event
     * @return void
     */
    public function onBootstrap(EventInterface $event)
    {
        $request = $event->getRequest();
        if (!$request instanceof PhpRequest) {
            return;
        }
        $app = $event->getTarget();
        $locator = $app->getServiceManager();
        $config = $locator->get('Config');
        if (true === $config['netglue_ip']['rewrite_remote_addr']) {
            $service = $locator->get('NetglueIp\Service\IpService');
            if ($ip = $service->getIp()) {
                $serverParams = $request->getServer();
                $serverParams->ORIGINAL_REMOTE_ADDR = $serverParams->REMOTE_ADDR;
                $serverParams->REMOTE_ADDR = $ip;
            }
        }
    }

    /**
     * Return Controller Config
     * @return array
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [

            ],
            'invokables' => [

            ],
        ];
    }

    /**
     * Return controller plugin config
     * @return array
     * @implements ControllerPluginProviderInterface
     */
    public function getControllerPluginConfig()
    {
        return [
            'factories' => [

            ],
            'invokables' => [

            ],
            'aliases' => [

            ],
        ];
    }

    /**
     * Return Service Config
     * @return array
     * @implements ServiceProviderInterface
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'NetglueIp\Service\IpService' => 'NetglueIp\Factory\Service\IpServiceFactory'
            ],
            'invokables' => [

            ],
        ];
    }

    /**
     * Return view helper plugin config
     * @return array
     * @implements ViewHelperProviderInterface
     */
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [

            ],
            'factories' => [
                'NetglueIp\View\Helper\RealIp' => 'NetglueIp\Factory\View\Helper\RealIpFactory',
            ],
            'aliases' => [
                'realIp' => 'NetglueIp\View\Helper\RealIp',
            ],
        ];
    }

}
