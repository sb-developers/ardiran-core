<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\Traits\Singleton;

class Ardiran{

    use Singleton;

    /**
     * Instance of Laravel Container.
     *
     * @var Container
     */
    private $container;

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
     * List facades.
     *
     * @var array
     */
    private $aliases = [
        'Config' => \Ardiran\Core\Facades\Config::class,
        'Route' => \Ardiran\Core\Facades\Route::class,
        'Request' => \Ardiran\Core\Facades\Request::class,
        'Blade' => \Ardiran\Core\Facades\Blade::class,
        'ServiceManager' => \Ardiran\Core\Facades\ServiceManager::class,
    ];
    
    /**
     * Constructor
     */
    public function __construct(){

        $this->container = new Container();

        $this->register();

    }

    /**
     * Register all principal elements of App.
     */
    private function register(){

        $this->container->registerProviders($this->providers);
        $this->container->registerAliases($this->aliases);

    }

    /**
     * Allows access to container functionalities or obtain the container.
     *
     * @param string $abstract
     * @param array $parameters
     * @return void
     */
    public function container($abstract = null, $parameters = []){
       
        if (!$abstract) {
            return $this->container;
        }

        return $this->container->bound($abstract)
            ? $this->container->make($abstract, $parameters)
            : $this->container->make("ardiran.{$abstract}", $parameters);

    }

}