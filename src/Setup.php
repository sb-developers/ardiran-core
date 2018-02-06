<?php

namespace Ardiran\Core;

use Ardiran\Core\Ardiran;
use Ardiran\Core\Traits\Singleton;
use Ardiran\Core\Http\Request;

class Setup{

    use Singleton;

    /**
     * Ardiran app.
     *
     * @var Ardiran
     */
    private $app;

    public function __construct(){

        $this->app = Ardiran::getInstance();

    }

    /**
     * Register the all configuration.
     * All configuration files are loaded and the config repository is generated.
     *
     * @param $path_configs
     */
    public function registerConfig($path_configs){

        $this->app->container('ardiran.config')->loadConfigurationFiles($path_configs);

    }

    /**
     * Register the serviceManager.
     * Necessary to later be able to use the facade 'ServiceManager'.
     *
     * @param $serviceManager
     */
    public function registerServiceManager($serviceManager){

        $this->app->container()->instance('ardiran.servicemanager', $serviceManager);

    }

    /**
     * Register all aliases (Facades).
     *
     * @param array $aliases
     */
    public function registerAliases(array $aliases){

        $this->app->container()->registerAliases($aliases);

    }

    /**
     * Register new providers in the container.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers){

        $this->app->container()->registerProviders($providers);

    }

    /**
     * Listen to all ajax controllers
     *
     * @param array $ajaxControllers
     */
    public function registerAjaxControllers(array $ajaxControllers){

        array_map(function ($class) {

            call_user_func($class . '::listen');

        }, $ajaxControllers);

    }

}