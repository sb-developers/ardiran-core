<?php

namespace Ardiran\Core\Themosis\Routing\Middleware;

use Closure;

/**
 * Class Authenticate
 * {@inheritdoc }
 * @package Ardiran\Core\Themosis\Routing\Middleware
 */
class Authenticate{

	/**
	 * Handle an incomming request
	 *
	 * @param $request
	 * @param Closure $next
	 * @param null $guard
	 */
	public function handle($request, Closure $next, $guard = null){

		if (!is_user_logged_in()) {
			return \redirect('');
		}

		return $next($request);

	}

}