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
 * Enqueue scripts and styles for the front end.
 *
 * @return void
*/
function woodkit_scripts_styles() {
	
	// Dashicons
	wp_enqueue_style( 'dashicons' );
	
	// Action before woodkit enqueue styles
	do_action("woodkit_front_enqueue_styles_before");

	// Loads parts stylesheets
	// -- bxslider
	$css_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.css');
	if (!empty($css_bxslider)){
		wp_enqueue_style('woodkit-css-bxslider', $css_bxslider, array(), '2.1.1');
	}
	// -- fancybox
	$css_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'fancybox/jquery.fancybox.css');
	if (!empty($css_fancybox)){
		wp_enqueue_style('woodkit-css-fancybox', $css_fancybox, array('woodkit-css-bxslider'), '2.1.5');
	}
	// -- fontawesome
	$css_fontawesome = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.'/'.WOODKIT_PLUGIN_FONTS_FOLDER.'fontawesome/fontawesome-4.4.0.css');
	if (!empty($css_fontawesome)){
		wp_enqueue_style('woodkit-css-fontawesome', $css_fontawesome, array('woodkit-css-bxslider'), '4.4.0');
	}

	// Action for stylesheets tools
	do_action("woodkit_front_enqueue_styles_tools", array("woodkit-css-fontawesome"));
	
	// Other core stylesheets
	// -- isotope
	$css_isotope = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-isotope.css');
	if (!empty($css_isotope))
		wp_enqueue_style('woodkit-core-isotope-style', $css_isotope, array('woodkit-css-fontawesome'), '1.0');
	// -- slider
	$css_slider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-slider.css');
	if (!empty($css_slider))
		wp_enqueue_style('woodkit-core-slider-style', $css_slider, array('woodkit-core-isotope-style'), '1.0');
	
	// Action after woodkit enqueue styles
	do_action("woodkit_front_enqueue_styles_after");
	
	// Action before woodkit enqueue scripts
	do_action("woodkit_front_enqueue_scripts_before");

	// Loads Cookies jQuery plugin
	$js_cookies = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'cookies/jquery.cookie.js');
	if (!empty($js_cookies))
		wp_enqueue_script('woodkit-script-cookies', $js_cookies, array('jquery'), '1.4.1', true);

	// Loads Isotope JavaScript file
	$js_isotope = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'isotope/isotope.pkgd.min.js');
	if (!empty($js_isotope))
		wp_enqueue_script('woodkit-script-isotope', $js_isotope, array('jquery'), '2.1.1', true);

	// Loads BxSlider JavaScript file
	$js_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.min.js');
	if (!empty($js_bxslider))
		wp_enqueue_script('woodkit-script-bxslider', $js_bxslider, array('jquery'), '2.1.1', true);

	// Loads Fancybox JavaScript file
	$js_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'fancybox/jquery.fancybox.pack.js');
	if (!empty($js_fancybox))
		wp_enqueue_script('woodkit-script-fancybox', $js_fancybox, array('jquery'), '2.1.5', true);

	// Loads Utils JavaScript file
	$js_utils = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-utils.js');
	if (!empty($js_utils))
		wp_enqueue_script('woodkit-script-woodkit-utils', $js_utils, array('jquery'), '1.0', true);
	
	// Action for javascripts tools
	do_action("woodkit_front_enqueue_scripts_tools", array("woodkit-script-woodkit-utils"));

	// Loads Gallery Matrix JavaScript file
	$js_gallery_matrix = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery-matrix.js');
	if (!empty($js_gallery_matrix))
		wp_enqueue_script('woodkit-script-woodkit-gallery-matrix', $js_gallery_matrix, array('jquery'), '1.0', true);

	// Loads Gallery JavaScript file
	$js_gallery = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery.js');
	if (!empty($js_gallery))
		wp_enqueue_script('woodkit-script-woodkit-gallery', $js_gallery, array('jquery', 'woodkit-script-woodkit-gallery-matrix'), '1.0', true);

	// Loads slider JavaScript file
	$js_slider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-slider.js');
	if (!empty($js_slider))
		wp_enqueue_script('woodkit-script-woodkit-slider', $js_slider, array('jquery'), '1.0', true);
	
	// Action after woodkit enqueue scripts
	do_action("woodkit_front_enqueue_scripts_after");

}
add_action('wp_enqueue_scripts', 'woodkit_scripts_styles');

/**
 * Enqueue scripts and styles for the back end.
 *
 * @since Woodkit 1.0
 * @return void
*/
function woodkit_admin_scripts_styles() {

	// jQuery DatePicker
	wp_enqueue_script('jquery-ui-datepicker');
	
	// Wordpress Color Picker
	wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
	
	// Fontawesome
	$css_fontawesome = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.'/'.WOODKIT_PLUGIN_FONTS_FOLDER.'fontawesome/fontawesome-4.4.0.css');
	if (!empty($css_fontawesome)){
		wp_enqueue_style('woodkit-admin-css-fontawesome', $css_fontawesome, array('wp-color-picker'), '4.4.0');
	}

	// Loads jquery-ui stylesheet (used by date jquery-ui-datepicker)
	$css_jquery_ui = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-jquery-ui.css');
	if (!empty($css_jquery_ui))
		wp_enqueue_style('woodkit-admin-css-jquery-ui', $css_jquery_ui, array('woodkit-admin-css-fontawesome'), '1.11.2');
	
	// Action for stylesheets tools
	do_action("woodkit_admin_enqueue_styles_tools", array("woodkit-admin-css-jquery-ui"));

	// Loads Isotope specific stylesheet.
	$css_isotope = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-isotope.css');
	if (!empty($css_isotope)){
		wp_enqueue_style('woodkit-admin-css-isotope', $css_isotope, array(), '1.0');
	}

	// Loads BxSlider specific stylesheet
	$css_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.css');
	if (!empty($css_bxslider)){
		wp_enqueue_style('woodkit-admin-css-bxslider', $css_bxslider, array(), '2.1.1');
	}

	// Loads Slider specific stylesheet.
	$css_slider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-slider.css');
	if (!empty($css_slider)){
		wp_enqueue_style('woodkit-admin-css-slider', $css_slider, array(), '1.0');
	}

	// Loads our main template stylesheet
	$css_admin = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-admin.css');
	if (!empty($css_admin))
		wp_enqueue_style('woodkit-admin-style', $css_admin, array('woodkit-admin-css-isotope', 'woodkit-admin-css-slider', 'woodkit-admin-css-jquery-ui'), '1.2');

	// Loads Cookies jQuery plugin
	$js_cookies = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'cookies/jquery.cookie.js');
	if (!empty($js_cookies))
		wp_enqueue_script('woodkit-script-cookies', $js_cookies, array('jquery'), '1.4.1', true);

	// Loads Utils
	$js_utils = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-utils.js');
	if (!empty($js_utils))
		wp_enqueue_script('woodkit-script-utils', $js_utils, array('jquery', 'wp-color-picker'), '1.0', true);

	// Loads Isotope JavaScript file
	$js_isotope = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'isotope/isotope.pkgd.min.js');
	if (!empty($js_isotope))
		wp_enqueue_script('woodkit-admin-script-isotope', $js_isotope, array('jquery'), '2.1.1', true);

	// Loads BxSlider JavaScript file
	$js_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.min.js');
	if (!empty($js_bxslider))
		wp_enqueue_script('woodkit-admin-script-bxslider', $js_bxslider, array('jquery'), '2.1.1', true);

	// Loads Gallery Matrix JavaScript file
	$js_gallery_matrix = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery-matrix.js');
	if (!empty($js_gallery_matrix))
		wp_enqueue_script('woodkit-script-woodkit-gallery-matrix', $js_gallery_matrix, array('jquery'), '1.0', true);

	// Loads Gallery JavaScript file
	$js_gallery = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery.js');
	if (!empty($js_gallery))
		wp_enqueue_script('woodkit-script-woodkit-gallery', $js_gallery, array('jquery', 'woodkit-script-woodkit-gallery-matrix'), '1.0', true);
	
	// Action for javascript tools
	do_action("woodkit_admin_enqueue_scripts_tools", array("woodkit-script-woodkit-gallery"));

	// Loads JavaScript file for admin.
	$js_admin = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-admin.js');
	if (!empty($js_admin))
		wp_enqueue_script('woodkit-admin-script', $js_admin, array('jquery'), '1.0', true);

	// wp.media JavaScript in Admin environnement (widget, posts, ...)
	wp_enqueue_media();
	
	// Action after woodkit enqueue admin scripts
	do_action("woodkit_admin_enqueue_scripts_after");

}
add_action('admin_enqueue_scripts', 'woodkit_admin_scripts_styles');

/**
 * Enqueue scripts and styles for the login page.
 *
 * @return void
*/
function woodkit_login_scripts_styles() {
	
	// Fontawesome
	$css_fontawesome = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.'/'.WOODKIT_PLUGIN_FONTS_FOLDER.'fontawesome/fontawesome-4.4.0.css');
	if (!empty($css_fontawesome)){
		wp_enqueue_style('woodkit-login-css-fontawesome', $css_fontawesome, array(), '4.4.0');
	}

	// Loads Utils
	$js_utils = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-utils.js');
	if (!empty($js_utils))
		wp_enqueue_script('woodkit-script-utils', $js_utils, array('jquery'), '1.0', true);
	
	// Action for stylesheets tools
	do_action("woodkit_login_enqueue_styles_tools", array());
	
	// Action for javascript tools
	do_action("woodkit_login_enqueue_scripts_tools", array("woodkit-script-utils"));

}
add_action('login_enqueue_scripts', 'woodkit_login_scripts_styles');

/**
 * Dashboard action
 *
 * @return void
 */
function woodkit_dashboard_setup() {
	wp_add_dashboard_widget('woodkit-dashboard-info-widget', Woodkit::get_info("Name")." | ".Woodkit::get_info("Version"), 'woodkit_dashboard_info_widget');
}
add_action('wp_dashboard_setup', 'woodkit_dashboard_setup' );

/**
 * Dashboard Widgets : Woodkit Info
 *
 * @return void
 */
function woodkit_dashboard_info_widget() {
	include(WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TEMPLATES_DASHBOARD_FOLDER."infos.php");
}