<?php

namespace Ardiran\Core\Routing;

use Ardiran\Core\Application\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Ardiran\Core\Routing\Router;
use Ardiran\Core\Http\Request;

class RouterProvider extends ServiceProvider {

    /**
     * Register the Events Dispatcher into the container.
     * Register the Router HTTP.
     *
     * @return void
     */
    public function register(){

        $this->app->instance('ardiran.request', Request::capture());

        $this->app->bind('ardiran.events', function ($container) {
            return new Dispatcher($container);
        });

        $this->app->singleton('ardiran.router', function ($container) {
            return new Router($container['ardiran.events'], $container);
        });

    }

}
