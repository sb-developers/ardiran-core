<?php

namespace Ardiran\Core\Routing;

use Ardiran\Core\Application\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Ardiran\Core\Http\Request;

class RouterServiceProvider extends ServiceProvider {

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

        $this->app->instance('ardiran.request', Request::capture());

    }

}
