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

    /**
     * List facades.
     *
     * @var array
     */
    private $aliases = [
        'Config' => \Ardiran\Core\Facades\Config::class,
        'Route' => \Ardiran\Core\Facades\Route::class,
        'Blade' => \Ardiran\Core\Facades\Blade::class,
        'ServiceManager' => \Ardiran\Core\Facades\ServiceManager::class,
    ];

    /**
     * List with the providers to load in the Laravel container.
     *
     * @var array
     */
    private $providers = [
        \Ardiran\Core\Facades\FacadeProvider::class,
        \Ardiran\Core\Config\ConfigProvider::class,
        \Ardiran\Core\Routing\RouterProvider::class,
        \Ardiran\Core\View\Blade\BladeProvider::class,
    ];

    /**
     * @var bool
     */
    private $is_config_registered = false;

    /**
     * @var bool
     */
    private $is_servicemanager_registered = false;

    /**
     * @var bool
     */
    private $is_ajaxcontrollers_registered = false;

    public function __construct(){

        $this->app = Ardiran::getInstance();

        $this->registerProviders($this->providers);
        $this->registerAliases($this->aliases);

    }

    /**
     * Register the all configuration.
     * All configuration files are loaded and the config repository is generated.
     *
     * @param $path_configs
     */
    public function registerConfig($path_configs){

        if(!$this->is_config_registered){

            $this->app->container('ardiran.config')->loadConfigurationFiles($path_configs);

            $this->is_config_registered = true;

        }

    }

    /**
     * Register the serviceManager.
     * Necessary to later be able to use the facade 'ServiceManager'.
     *
     * @param $serviceManager
     */
    public function registerServiceManager($serviceManager){

        if(!$this->is_servicemanager_registered){

            $this->app->container()->instance('ardiran.servicemanager', $serviceManager);

            $this->is_servicemanager_registered = true;

        }

    }

    /**
     * Register all aliases (Facades).
     *
     * @param array $aliases
     */
    public function registerAliases(array $aliases){

        if (!empty($aliases) && is_array($aliases)) {

            foreach ($aliases as $alias => $fullname) {
                class_alias($fullname, $alias);
            }

        }

    }

    /**
     * Register new providers in the container.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers){

        foreach ($providers as $provider) {
            $this->app->container()->registerProvider($provider);
        }

    }

    /**
     * Listen to all ajax controllers
     *
     * @param array $ajaxControllers
     */
    public function registerAjaxControllers(array $ajaxControllers){

        if(!$this->is_ajaxcontrollers_registered) {

            array_map(function ($class) {

                call_user_func($class . '::listen');

            }, $ajaxControllers);

            $this->is_ajaxcontrollers_registered = true;

        }

    }

}