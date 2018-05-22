<?php

die("hey");

/*
 * No generator
 */

add_filter( 'the_generator', function(){
	return '';
} );

/*
 * Explain Less Login Issues
 */

add_filter('login_errors', function(){
	return 'ERROR: Los datos ingresados son incorrectos.';
});

/*
 * Rescritura de urls
 *
 * No se hace rewrite en multisitio o temas hijo para no joderlo todo.
 */

function add_filters($tags, $function) {
	foreach($tags as $tag) {
		add_filter($tag, $function);
	}
}

function roots_rewrites() {

	/**
	 * Define helper constants
	 */

	$get_theme_name = explode('/themes/', get_template_directory());

	define('RELATIVE_PLUGIN_PATH',  str_replace(home_url() . '/', '', plugins_url()));
	define('RELATIVE_CONTENT_PATH', str_replace(home_url() . '/', '', content_url()));
	define('THEME_NAME',            next($get_theme_name));
	define('THEME_PATH',            RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);

	/**
	 * Rewrites do not happen for multisite installations or child themes
	 *
	 * Rewrite:
	 *   /wp-content/themes/themename/theme/assets/styles/public/ to /theme/assets/styles/public/
	 *   /wp-content/themes/themename/theme/assets/scripts/public/  to /theme/assets/scripts/public/
	 *   /wp-content/themes/themename/theme/assets/images/ to /theme/assets/images/
	 *   /wp-content/themes/themename/theme/assets/fonts/webfonts/ to /theme/assets/fonts/webfonts/
	 *   /wp-content/themes/themename/theme/assets/fonts/icons/ to /theme/assets/fonts/icons/
	 *   /wp-content/plugins/                     to /plugins/
	 *
	 * If you aren't using Apache, Nginx configuration settings can be found in the README
	 */

	function roots_add_rewrites($content) {
		global $wp_rewrite;
		$roots_new_non_wp_rules = array(
			'theme/assets/styles/public/(.*)'          => THEME_PATH . '/theme/assets/styles/public/$1',
			'theme/assets/scripts/public/(.*)'          => THEME_PATH . '/theme/assets/scripts/public/$1',
			'theme/assets/images/(.*)'          => THEME_PATH . '/theme/assets/images/$1',
			'theme/assets/fonts/webfonts/(.*)'          => THEME_PATH . '/theme/assets/fonts/webfonts/$1',
			'theme/assets/fonts/icons/(.*)'          => THEME_PATH . '/theme/assets/fonts/icons/$1',

			'resources/assets/styles/public/(.*)'          => THEME_PATH . '/resources/assets/styles/public/$1',
			'resources/assets/scripts/public/(.*)'          => THEME_PATH . '/resources/assets/scripts/public/$1',
			'resources/assets/images/(.*)'          => THEME_PATH . '/resources/assets/images/$1',
			'resources/assets/fonts/webfonts/(.*)'          => THEME_PATH . '/resources/assets/fonts/webfonts/$1',
			'resources/assets/fonts/icons/(.*)'          => THEME_PATH . '/resources/assets/fonts/icons/$1',

			'plugins/(.*)'         => RELATIVE_PLUGIN_PATH . '/$1'
		);
		$wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $roots_new_non_wp_rules);
		return $content;
	}

	function roots_clean_urls($content) {
		if (strpos($content, RELATIVE_PLUGIN_PATH) > 0) {
			return str_replace('/' . RELATIVE_PLUGIN_PATH,  '/plugins', $content);
		} else {
			return str_replace('/' . THEME_PATH, '', $content);
		}
	}

	if (!is_multisite() && !is_child_theme()) {
		add_action('generate_rewrite_rules', 'roots_add_rewrites');

		if (!is_admin()) {
			$tags = array(
				'plugins_url',
				'bloginfo',
				'stylesheet_directory_uri',
				'template_directory_uri',
				'script_loader_src',
				'style_loader_src'
			);

			add_filters($tags, 'roots_clean_urls');
		}
	}

}

add_action('after_setup_theme', 'roots_rewrites');

/*
 * Limpieza de wp_head()
 *
 * Elimina enlaces innecesarios
 * Elimina el CSS utilizado por el widget de comentarios recientes
 * Elimina el  CSS utilizado en las galerías
 * Elimina el cierre automático de etiquetas y cambia de ''s a "'s en rel_canonical()
 */

add_action('init', function(){

	global $wp_widget_factory;

	// Eliminamos lo que sobra de la cabecera
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

	if (!class_exists('WPSEO_Frontend')) {

		remove_action('wp_head', 'rel_canonical');

		add_action('wp_head', function(){

			global $wp_the_query;

			if (!is_singular()) {
				return;
			}

			if (!$id = $wp_the_query->get_queried_object_id()) {
				return;
			}

			$link = get_permalink($id);

			echo "\t<link rel=\"canonical\" href=\"$link\">\n";

		});

	}

});

/*
 * Eliminamos la versión de WordPress
 */

add_filter('the_generator', '__return_false');

/*
 * Limpieza de los language_attributes() usados en la etiqueta <html>
 */

add_filter('language_attributes', function(){

	$attributes = array();
	$output = '';

	if (function_exists('is_rtl')) {
		if (is_rtl() == 'rtl') {
			$attributes[] = 'dir="rtl"';
		}
	}

	$lang = get_bloginfo('language');

	if ($lang && $lang !== 'es-ES') {
		$attributes[] = "lang=\"$lang\"";
	} else {
		$attributes[] = 'lang="es"';
	}

	$output = implode(' ', $attributes);
	$output = apply_filters('nowp_language_attributes', $output);

	return $output;

});

add_filter( "xmlrpc_methods", function($methods) {

	unset( $methods['pingback.ping'] );

	return $methods;

});