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