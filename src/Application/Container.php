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
     * List with the aliases that have been loaded.
     *
     * @var array
     */
    protected $loadedAliases = [];

    /**
     * Register new providers in the container.
     *
     * @param array $providers
     */
    public function registerProviders(array $providers){

        foreach ($providers as $provider) {
            $this->registerProvider($provider);
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

    /**
     * Register all aliases (Facades).
     *
     * @param array $aliases
     */
    public function registerAliases(array $aliases){

        if (!empty($aliases) && is_array($aliases)) {

            foreach ($aliases as $alias => $fullname) {
                $this->registerAlias($fullname, $alias);
            }

        }

    }

    /**
     * Register alias class.
     *
     * @param $fullname
     * @param $alias
     */
    public function registerAlias($fullname, $alias){

        if (array_key_exists($aliaslwc = strtolower($alias), $this->loadedAliases)) {
            return;
        }

        $this->loadedAliases[$aliaslwc] = true;

        $this->alias($fullname, $alias);

    }

}