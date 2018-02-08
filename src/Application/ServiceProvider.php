<?php

namespace Ardiran\Core\Application;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider{

    /**
     * Dynamically handle missing method calls.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function __call($method, $parameters){

        if ($method == 'boot') {
            return;
        }

        throw new \Exception("Call to undefined method [{$method}]");

    }

}