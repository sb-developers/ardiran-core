<?php

namespace Ardiran\Core\View;

use Ardiran\Core\View\Blade\WpDirective;
use Themosis\Foundation\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

	/**
	 * Register View Options
	 *
	 * @return void
	 */
	public function register(){

		$this->registerBladeDirectives($this->app);

	}

	/**
	 * Add blade directives
	 *
	 * @param $container
	 */
	private function registerBladeDirectives($container){

		$blade = $container->get('view')->getEngineResolver()->resolve('blade')->getCompiler();

		$blade = (new WpDirective())->extend($blade);

	}

}