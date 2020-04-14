<?php
/**
 * @package Woodkit
* @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
* License: GPL2
* Text Domain: woodkit
*
* Copyright 2016 Sébastien Chandonay (email : please contact me from my website)
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
defined('ABSPATH') or die("Go Away!");

/**
 * Script dependencies
 */
wp_register_script('woodkit-js-masonry', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', array('jquery'), '4.2.2', true);
wp_register_script('woodkit-js-utils', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_JS_FOLDER.'woodkit-utils.js'), array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
wp_register_script('woodkit-js-front', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_JS_FOLDER.'woodkit-front.js'), array('jquery', 'woodkit-js-utils'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
wp_register_script('woodkit-js-admin', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_JS_FOLDER.'woodkit-admin.js'), array('jquery', 'woodkit-js-utils'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
wp_register_script('woodkit-js-login', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_JS_FOLDER.'woodkit-login.js'), array('jquery', 'woodkit-js-utils'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);

/**
 * Style dependencies
 */
wp_register_style('woodkit-css-fa', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FONTS_FOLDER.'fontawesome-free-5.10.3-web/css/all.min.css'), array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
wp_register_style('woodkit-css-front', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_CSS_FOLDER.'woodkit-front.css'), array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
wp_register_style('woodkit-css-admin', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_CSS_FOLDER.'woodkit-admin.css'), array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
wp_register_style('woodkit-css-login', locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_CSS_FOLDER.'woodkit-login.css'), array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);

/**
 * Enqueue scripts and styles for the front end.
 *
 * @return void
*/
function woodkit_scripts_styles() {

	// Dashicons
	wp_enqueue_style('dashicons');

	// Front styles
	wp_enqueue_style('woodkit-css-front');

	// Utils JS
	wp_enqueue_script('woodkit-js-utils');
	wp_localize_script('woodkit-js-utils', 'Utils', array(
			"wait_label" => apply_filters('woodkit-js-wait-label', __('loading...', 'woodkit')),
			"wait_background" => apply_filters('woodkit-js-wait-background', "rgba(255,255,255,0.5)")
	));

	// Front JS
	wp_enqueue_script('woodkit-js-front');

}
add_action('wp_enqueue_scripts', 'woodkit_scripts_styles');

/**
 * Enqueue scripts and styles for the back end.
 *
 * @since Woodkit 1.0
 * @return void
*/
function woodkit_admin_scripts_styles() {

	// Loads FontAwesome fonticon
	wp_enqueue_style('woodkit-css-fa');

	// Loads our main template stylesheet
	wp_enqueue_style('woodkit-css-admin');

	// Utils JS
	wp_enqueue_script('woodkit-js-utils');
	wp_localize_script('woodkit-js-utils', 'Utils', array(
			"wait_label" => apply_filters('woodkit-js-wait-label', __('loading...', 'woodkit')),
			"wait_background" => apply_filters('woodkit-js-wait-background', "rgba(255,255,255,0.5)")
	));

	// Admin JS
	wp_enqueue_script('woodkit-js-admin');

	// Load wp.media JavaScript in Admin environnement (widget, posts, ...)
	wp_enqueue_media();

}
add_action('admin_enqueue_scripts', 'woodkit_admin_scripts_styles');

/**
 * Enqueue scripts and styles for the login page.
 *
 * @return void
*/
function woodkit_login_scripts_styles() {

	// Login
	wp_enqueue_style('woodkit-css-login');

	// Login JS
	wp_enqueue_script('woodkit-js-login');

}
add_action('login_enqueue_scripts', 'woodkit_login_scripts_styles');

/**
 * Sanitize FileName - fixe Mac filename encoding
 */
function woodkit_sanitize_file_name ($filename) {
	$clean = utf8_encode($filename);
	return remove_accents($clean);
}
add_filter('sanitize_file_name', 'woodkit_sanitize_file_name', 10);