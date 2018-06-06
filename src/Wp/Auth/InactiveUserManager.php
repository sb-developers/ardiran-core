<?php

namespace Ardiran\Wp\Auth;

/**
 * Class InactiveUsers
 * @package Sb\Wp\Auth
 * @source Wp Iddle logout https://github.com/greguly/wp-idle-logout
 */
class InactiveUserManager{

	/**
	 * Name space
	 */
	const ID = 'sb_';

	/**
	 * Default session time
	 */
	const default_idle_time = 3600;

	/**
	 * Default redirect url when logout user
	 */
	const default_redirect_url = "/";

	/**
	 * Add actions and filters
	 *
	 */
	public function __construct() {

		add_action( 'wp_login', array(&$this, 'login_key_refresh'), 10, 2 );
		add_action( 'init', array(&$this, 'check_for_inactivity') );
		add_action( 'clear_auth_cookie', array(&$this, 'clear_activity_meta') );

	}

	/**
	 * Retreives the maximum allowed idle time setting
	 *
	 * Checks if idle time is set in plugin options
	 * If not, uses the default time
	 * Returns $time in seconds, as integer
	 *
	 */
	private function get_idle_time_setting() {

		$time = apply_filters('sb_inactive_user_session_time', self::default_idle_time);

		if ( empty($time) || !is_numeric($time) ) {
			$time = self::default_idle_time;
		}

		return (int) $time;

	}

	/**
	 * Refreshes the meta key on login
	 *
	 * Tests if the user is logged in on 'init'.
	 * If true, checks if the 'last_active_time' meta is set.
	 * If it isn't, the meta is created for the current time.
	 * If it is, the timestamp is checked against the inactivity period.
	 *
	 */
	public function login_key_refresh( $user_login, $user ) {
		update_user_meta( $user->ID, self::ID . '_last_active_time', time() );
	}

	/**
	 * Checks for User Idleness
	 *
	 * Tests if the user is logged in on 'init'.
	 * If true, checks if the 'last_active_time' meta is set.
	 * If it isn't, the meta is created for the current time.
	 * If it is, the timestamp is checked against the inactivity period.
	 *
	 */
	public function check_for_inactivity() {

		if ( is_user_logged_in() ) {

			$user_id = get_current_user_id();
			$time = get_user_meta( $user_id, self::ID . '_last_active_time', true );

			if ( is_numeric($time) ) {

				if ( (int) $time + $this->get_idle_time_setting() < time() ) {

					wp_redirect( apply_filters('sb_inactive_user_redirect_url', self::default_redirect_url) );
					wp_logout();

					$this->clear_activity_meta( $user_id );

					exit;

				} else {
					update_user_meta( $user_id, self::ID . '_last_active_time', time() );
				}

			} else {
				delete_user_meta( $user_id, self::ID . '_last_active_time' );
				update_user_meta( $user_id, self::ID . '_last_active_time', time() );
			}

		}

	}

	/**
	 * Delete Inactivity Meta
	 *
	 * Deletes the 'last_active_time' meta when called.
	 * Used on normal logout and on idleness logout.
	 *
	 */
	public function clear_activity_meta( $user_id = false ) {

		if ( !$user_id ) {
			$user_id = get_current_user_id();
		}

		delete_user_meta( $user_id, self::ID . '_last_active_time' );

	}


}