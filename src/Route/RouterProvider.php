<?php

namespace Ardiran\Core\Route;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Ardiran\Core\Route\Router;

/**
 * Class RouterProvider
 *
 * @author Themosis
 * @url https://github.com/themosis/framework/blob/1.3/src/Themosis/Route/RouteServiceProvider.php
 */
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
