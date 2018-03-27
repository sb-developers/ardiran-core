<?php

namespace Ardiran\Core\Wp\Routing;

use Ardiran\Core\Application\ServiceProvider;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;

class RouterServiceProvider extends ServiceProvider {

    /**
     * Register the Router HTTP and redirector.
     *
     * @return void
     */
    public function register(){

        $this->app->singleton('ardiran.wp_router', function ($container) {
            return new Router($container['ardiran.events'], $container);
        });

        $this->app->bind('ardiran.wp_urlgenerator', function ($container) {

            $request = $container['ardiran.request'];
            $routes = $container['ardiran.wp_router']->getRoutes();

            $routes->refreshNameLookups();

            return new UrlGenerator($routes, $request);

        });

        $this->app->bind('ardiran.wp_redirector', function($container){
            return new Redirector($container['ardiran.wp_urlgenerator']);
        });

    }

}
