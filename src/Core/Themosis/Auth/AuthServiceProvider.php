<?php

namespace Ardiran\Core\Themosis\Auth;

use Themosis\Foundation\ServiceProvider;

/**
 * Class AuthServiceProvider
 * {@inheritdoc }
 * @package Sb\Core\Themosis\Auth
 */
class AuthServiceProvider extends ServiceProvider{

	/**
	 * Registrar servicios.
	 *
	 * @return void
	 */
	public function register(){

		// Registrar el Auth Manager
		$this->app->bind('auth.manager', 'Sb\Core\Themosis\Auth');

	}

}
