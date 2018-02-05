<?php

namespace Ardiran\Core\Route;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Ardiran\Core\Route\Router;

class RouterProvider extends ServiceProvider{

    /**
     * Register the Events Dispatcher into the container.
     * Register the Router HTTP.
     *
     * @return void
     */
    public function register(){

        $this->app->bind('ardiran.events', function ($container) {
            return new Dispatcher($container);
        });

        $this->app->singleton('ardiran.router', function ($container) {
            return new Router($container['ardiran.events'], $container);
        });

    }

}
