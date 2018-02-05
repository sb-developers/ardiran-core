<?php

namespace Ardiran\Core;

use Ardiran\Core\Ardiran;
use Ardiran\Core\Traits\Singleton;
use Ardiran\Core\Http\Request;

class Setup{

    use Singleton;

    private $app;

    private $aliases = [
        'Config' => \Ardiran\Core\Facades\Config::class,
        'Route' => \Ardiran\Core\Facades\Route::class,
        'Blade' => \Ardiran\Core\Facades\Blade::class,
        'ServiceManager' => \Ardiran\Core\Facades\ServiceManager::class,
    ];

    private $is_config_registered = false;

    private $is_servicemanager_registered = false;

    private $is_router_registered = false;

    private $is_aliases_registered = false;

    private $is_ajaxcontrollers_registered = false;

    private $is_providers_registered = false;

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
     * Set the router in Wordpress
     */
    public function registerRouter(){

        if(!$this->is_router_registered) {

            add_action('template_redirect', function () {

                if (is_feed() || is_comment_feed()) {
                    return;
                }

                try {

                    $request = $this->app->container('ardiran.request');
                    $response = $this->app->container('ardiran.router')->dispatch($request);

                    // We only send back the content because, headers are already defined
                    // by WordPress internals.
                    $response->sendContent();

                } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
                    /*
                     * Fallback to WordPress templates.
                     */
                }

            }, 20);

            $this->is_router_registered = true;

        }

    }

    /**
     * Register all aliases (Facades).
     *
     * @param array $aliases
     */
    public function registerAliases($aliases = array()){

        if(!$this->is_aliases_registered) {

            $aliases = $this->aliases + $aliases;

            if (!empty($aliases) && is_array($aliases)) {

                foreach ($aliases as $alias => $fullname) {
                    class_alias($fullname, $alias);
                }

            }

            $this->is_aliases_registered = true;

        }

    }

    /**
     * Register new providers in the container.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers){

        if(!$this->is_providers_registered) {

            $this->app->container()->registerProviders($providers);

            $this->is_providers_registered = true;

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