<?php

/*
Plugin Name: Ardiran Core
Plugin URI: https://github.com/acalvet/ardiran-core/
Description: A WordPress framework for customizing Ardirant Theme Wordpress.
Version: 1.0.0
Author: Adrian Calvet
Author URI: https://github.com/acalvet/ardiran-core/
*/

/*
 * Check if the framework is available.
 */
if (!isset($GLOBALS['themosis'])) {
	/*
	 * Those strings are not translated.
	 * We want to load only one textdomain for the theme with the domain
	 * defined inside the theme.config.php file.
	 */
	$text = 'The theme is only compatible with the Themosis framework. Please install the Themosis framework.';
	$title = 'WordPress - Missing framework';

	/*
	 * Add a notice in the wp-admin.
	 */
	add_action('admin_notices', function () use ($text) {
		printf('<div class="notice notice-warning is-dismissible"><p>%s</p></div>', $text);
	});

	/*
	 * Add a notice in the front-end.
	 */
	wp_die($text, $title);
}