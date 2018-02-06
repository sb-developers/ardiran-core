<?php

namespace Ardiran\Core\Application;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Support\Facades\Facade;

class Container extends IlluminateContainer{

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

    }

    /**
     * Register a provider in the Laravel container.
     *
     * @param string $provider
     * @param array $options
     * @param boolean $force
     * @return void
     */
    public function registerProvider($provider, array $options = [], $force = false){

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