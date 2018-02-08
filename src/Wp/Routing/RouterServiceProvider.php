<?php

namespace Ardiran\Core\Wp\Routing;

use Ardiran\Core\Application\ServiceProvider;

class RouterServiceProvider extends ServiceProvider {

    /**
     * Register the Router HTTP.
     *
     * @return void
     */
    public function register(){

        $this->app->singleton('ardiran.wp_router', function ($container) {
            return new Router($container['ardiran.events'], $container);
        });

    }

}
