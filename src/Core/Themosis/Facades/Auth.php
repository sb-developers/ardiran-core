<?php

namespace Ardiran\Core\Themosis\Facades;

use Themosis\Facades\Facade;

/**
 * Class Auth
 * {@inheritdoc }
 * @package Ardiran\Core\Themosis\Facades
 */
class Auth extends Facade {

	protected static function getFacadeAccessor() {
		return 'auth.manager';
	}

}