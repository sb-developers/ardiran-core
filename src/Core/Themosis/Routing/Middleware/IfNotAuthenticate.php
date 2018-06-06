<?php

namespace Sb\Core\Themosis\Routing\Middleware;

use Closure;

/**
 * Class IfNotAuthenticate
 * {@inheritdoc }
 * @package Ardiran\Core\Themosis\Routing\Middleware
 */
class IfNotAuthenticate{

	/**
	 * Handle an incomming request
	 *
	 * @param $request
	 * @param Closure $next
	 * @param null $guard
	 */
	public function handle($request, Closure $next, $guard = null){

		if(is_user_logged_in()){
			return \redirect('');
		}

		return $next($request);

	}

}