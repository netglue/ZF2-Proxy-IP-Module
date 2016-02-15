<?php

namespace NetglueIp;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\Request as ConsoleRequest;
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
    Feature\ConsoleBannerProviderInterface,
    Feature\ConsoleUsageProviderInterface,
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

            ],
            'aliases' => [

            ],
        ];
    }

    /**
     * Return console usage message
     * @param Console $console
     * @return array
     */
    public function getConsoleUsage(Console $console)
    {
        return [

        ];
    }

    /**
     * Return console banner
     * @param Console $console
     * @return string
     */
    public function getConsoleBanner(Console $console)
    {
        return 'Net Glue IP Module';
    }
}
