<?php

namespace Ardiran\Core\Themosis\Auth;

use WP_User;

/**
 * Class AuthManager
 * @package Ardiran\Core\Themosis\Auth
 */
class AuthManager {

	/**
	 * Currently logged in user.
	 *
	 * @var WP_User
	 */
	protected $user;

	/**
	 * Construct auth manager.
	 *
	 */
	public function __construct() {
		$this->setLoggedinUser();
	}

	/**
	 * Get logged in user object.
	 *
	 * @return void
	 */
	private function setLoggedinUser() {
		$wp_user = new WP_User($this->getCurrentUserId());

		$this->setUser($wp_user);
	}

	/**
	 * Get currently loged in user id.
	 *
	 * @return int
	 */
	public function getCurrentUserId(){
		return get_current_user_id();
	}

	/**
	 * Determine if the user is already logged in.
	 *
	 * @return bool
	 */
	public function check(){
		return is_user_logged_in();
	}

	/**
	 * Attempt user login.
	 *
	 * @param array $credentials
	 * @param bool $remember
	 *
	 * @return bool
	 */
	public function attempt(array $credentials, $remember = false){
		$credentials = array_merge($credentials, ['remember' => $remember]);

		$user = wp_signon($credentials);

		if (! is_wp_error($user)) {
			return true;
		}

		return false;
	}

	/**
	 * Login with User istance.
	 *
	 * @param WP_User $user
	 * @param bool $remember
	 * @param string $secure
	 *
	 * @return void
	 */
	public function login(WP_User $user, $remember = false, $secure = '') {
		wp_set_auth_cookie($user->id, $remember, $secure);

		wp_set_current_user($user->id);
	}

	/**
	 * Logout user.
	 *
	 * @return void
	 */
	public function logout(){
		return wp_logout();
	}

	/**
	 * Gets the Currently logged in user.
	 *
	 * @return WP_User
	 */
	public function user(){
		if ($this->check()) {
			return $this->user;
		}
	}

	/**
	 * Sets the Currently logged in user.
	 *
	 * @param WP_User $user the user
	 *
	 * @return self
	 */
	public function setUser(WP_User $user){
		$this->user = $user;

		return $this;
	}

}