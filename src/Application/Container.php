<?php

namespace Ardiran\Core\Application;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Support\Facades\Facade;

class Container extends IlluminateContainer{

    /**
     * List with the providers to load in the Laravel container.
     *
     * @var array
     */
    protected $providers = [
        \Ardiran\Core\Facades\FacadeProvider::class,
        \Ardiran\Core\Config\ConfigProvider::class,
        \Ardiran\Core\Route\RouterProvider::class,
        \Ardiran\Core\View\Blade\BladeProvider::class,
    ];

    /**
     * List with the providers that have been loaded.
     *
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * Constructor
     */
    public function __construct(){

        $this->registerProviders($this->providers);

    }

    /**
     * All the providers are registered in the Laravel container.
     *
     * @return void
     */
    public function registerProviders(array $providers){

        foreach ($providers as $provider) {
            $this->register($provider);
        }

    }

    /**
     * Register a provider in the Laravel container.
     *
     * @param string $provider
     * @param array $options
     * @param boolean $force
     * @return void
     */
    public function register($provider, array $options = [], $force = false){

        if (!$provider instanceof ServiceProvider) {
            $provider = new $provider($this);
        }

        if (array_key_exists($providerName = get_class($provider), $this->loadedProviders)) {
            return;
        }

        $this->loadedProviders[$providerName] = true;

        $provider->register();

        if (method_exists($provider, 'boot')) {
            $provider->boot();
        }

    }

}