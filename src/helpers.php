<?php

if ( ! function_exists( 'register_ajax_controllers' ) ) {

	/**
	 * Listen to all ajax controllers
	 *
	 * @param array $ajaxControllers
	 */
	function register_ajax_controllers( array $ajaxControllers ) {

		array_map( function ( $class ) {
			call_user_func( $class . '::listen' );
		}, $ajaxControllers );

	}

}

if (! function_exists('url')) {

	/**
	 * Generate a url for the application.
	 *
	 * @param  string  $path
	 * @param  mixed   $parameters
	 * @param  bool    $secure
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	function url($path, $parameters = [], $secure = null){
		return container('ardiran.urlgenerator')->to($path, $parameters, $secure);
	}

}

if (! function_exists('secure_url')) {

	/**
	 * Generate a HTTPS url for the application.
	 *
	 * @param  string  $path
	 * @param  mixed   $parameters
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	function secure_url($path, $parameters = []){
		return url($path, $parameters, true);
	}

}


if (!function_exists('redirect')){

	/**
	 * Wp Redirect to route
	 *
	 * @param null $to
	 * @param int $status
	 * @param array $headers
	 * @param null $secure
	 * @return \Illuminate\Routing\Redirector|mixed
	 */
	function redirect($to = null, $status = 302, $headers = [], $secure = null){

		if(is_null($to)){
			return container('ardiran.redirector');
		}

		return container('ardiran.redirector')->to($to, $status, $headers, $secure);

	}

}