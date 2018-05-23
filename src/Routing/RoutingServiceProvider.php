<?php

namespace Ardiran\Core\Routing;

use Themosis\Foundation\ServiceProvider;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;

class RoutingServiceProvider extends ServiceProvider {

	/**
	 * Register Urlgenerator y Redirector.
	 *
	 * @return void
	 */
	public function register(){

		$this->app->bind('ardiran.urlgenerator', function ($container) {

			$request = $container['request'];

			$routes = $container['router']->getRoutes();

			$routes->refreshNameLookups();

			return new UrlGenerator($routes, $request);

		});

		$this->app->bind('ardiran.redirector', function($container){

			return new Redirector($container['ardiran.urlgenerator']);

		});

	}

}