<?php

namespace Ardiran\Core\Application;

use Illuminate\Container\Container as IlluminateContainer;

class Container extends IlluminateContainer{

    protected $providers = [
        \Ardiran\Core\View\Blade\BladeProvider::class
    ];

    protected $loadedProviders = [];

    public function __construct(){

        $this->registerProviders();

    }

    private function registerProviders(){

        foreach ($this->providers as $provider) {
            $this->register($provider);
        }

    }

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