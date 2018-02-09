<?php

namespace Ardiran\Core;

use Ardiran\Core\Ardiran;
use Ardiran\Core\Traits\Singleton;

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
     * Register all aliases (Facades).
     *
     * @param array $aliases
     */
    public function registerAliases(array $aliases){

        $this->app->registerAliases($aliases);

    }

    /**
     * Register new providers in the container.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers){

        $this->app->registerProviders($providers);

    }

}