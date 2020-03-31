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
	
	// Font Awesome Version - Woodkit option
	$fontawesome_version = woodkit_get_option("fontawesome-version", "4");

	// Dashicons
	wp_enqueue_style('dashicons');

	// Action before woodkit enqueue styles
	do_action("woodkit_front_enqueue_styles_before");

	// Loads parts stylesheets
	// -- bxslider
	$css_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.css');
	if (!empty($css_bxslider)){
		wp_enqueue_style('woodkit-css-bxslider', $css_bxslider, array(), '2.1.1');
	}
	// -- fancybox
	$css_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'fancybox-3.5.2/dist/jquery.fancybox.min.css');
	if (!empty($css_fancybox)){
		wp_enqueue_style('woodkit-css-fancybox', $css_fancybox, array('woodkit-css-bxslider'), '3.5.2');
	}
	// -- fontawesome
	if ($fontawesome_version == "5"){
		wp_enqueue_script('woodkit-fontawesome-js', 'https://kit.fontawesome.com/7520443ec7.js', array (), $fontawesome_version, true);
	}else{
		$css_fontawesome = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_FONTS_FOLDER.'font-awesome-4/css/font-awesome.min.css');
		if (!empty($css_fontawesome)){
			wp_enqueue_style('woodkit-css-fontawesome', $css_fontawesome, array('woodkit-css-bxslider'), "4.4.7");
		}
	}
	
	// -- front
	$css_front = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-front.css');
	if (!empty($css_front)){
		wp_enqueue_style('woodkit-css-front', $css_front, array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
	}
	
	// -- isotope/slider
	$css_isotope_slider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-isotope-slider.css');
	if (!empty($css_isotope_slider)){
		wp_enqueue_style('woodkit-core-slider-style', $css_isotope_slider, array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
	}

	// Action after woodkit enqueue styles
	do_action("woodkit_front_enqueue_styles_after");

	// Action before woodkit enqueue scripts
	do_action("woodkit_front_enqueue_scripts_before");

	// Loads Cookies jQuery plugin
	$js_cookies = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'cookies/jquery.cookie.js');
	if (!empty($js_cookies)){
		wp_enqueue_script('woodkit-script-cookies', $js_cookies, array('jquery'), '1.4.1', true);
	}

	// Loads Isotope JavaScript file
	$js_isotope = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'isotope/isotope.pkgd.min.js');
	if (!empty($js_isotope)){
		wp_enqueue_script('woodkit-script-isotope', $js_isotope, array('jquery'), '3.0.3', true);
	}

	// Loads BxSlider JavaScript file
	$js_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.min.js');
	if (!empty($js_bxslider)){
		wp_enqueue_script('woodkit-script-bxslider', $js_bxslider, array('jquery'), '2.1.1', true);
	}

	// Loads Fancybox JavaScript file
	$js_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'fancybox-3.5.2/dist/jquery.fancybox.min.js');
	if (!empty($js_fancybox)){
		wp_enqueue_script('woodkit-script-fancybox', $js_fancybox, array('jquery'), '3.5.2', true);
	}

	// Loads Utils JavaScript file
	$js_utils = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-utils.js');
	if (!empty($js_utils)){
		wp_enqueue_script('woodkit-script-woodkit-utils', $js_utils, array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
		wp_localize_script('woodkit-script-woodkit-utils', 'Utils', array(
				"wait_label" => apply_filters('woodkit-js-wait-label', __('loading...', 'woodkit')),
				"wait_background" => apply_filters('woodkit-js-wait-background', "rgba(255,255,255,0.5)")
		));
	}

	// Action for javascripts tools
	do_action("woodkit_front_enqueue_scripts_tools", array("woodkit-script-woodkit-utils"));

	// Loads Gallery Matrix JavaScript file
	$js_gallery_matrix = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery-matrix.js');
	if (!empty($js_gallery_matrix)){
		wp_enqueue_script('woodkit-script-woodkit-gallery-matrix', $js_gallery_matrix, array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

	// Loads Gallery JavaScript file
	$js_gallery = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery.js');
	if (!empty($js_gallery)){
		wp_enqueue_script('woodkit-script-woodkit-gallery', $js_gallery, array('jquery', 'woodkit-script-woodkit-gallery-matrix'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

	// Loads slider JavaScript file
	$js_slider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-slider.js');
	if (!empty($js_slider)){
		wp_enqueue_script('woodkit-script-woodkit-slider', $js_slider, array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

	// Loads front general JavaScript file (contains tools javascript)
	$js_front = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-front.js');
	if (!empty($js_front)){
		wp_enqueue_script('woodkit-script-woodkit-front', $js_front, array('jquery', 'woodkit-script-woodkit-slider'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

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

	// Font Awesome Version - Woodkit option
	$fontawesome_version = woodkit_get_option("fontawesome-version", "4");

	// jQuery DatePicker
	wp_enqueue_script('jquery-ui-datepicker');

	// Wordpress Color Picker
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('wp-color-picker');

	// Fontawesome
	if ($fontawesome_version == "5"){
		wp_enqueue_script('woodkit-fontawesome-js', 'https://kit.fontawesome.com/7520443ec7.js', array (), $fontawesome_version, true);
	}else{
		$css_fontawesome = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_FONTS_FOLDER.'font-awesome-4/css/font-awesome.min.css');
		if (!empty($css_fontawesome)){
			wp_enqueue_style('woodkit-admin-css-fontawesome', $css_fontawesome, array(), "4.4.7");
		}
	}

	// Loads jquery-ui stylesheet (used by date jquery-ui-datepicker)
	$css_jquery_ui = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-jquery-ui.css');
	if (!empty($css_jquery_ui)){
		wp_enqueue_style('woodkit-admin-css-jquery-ui', $css_jquery_ui, array(), '1.11.2');
	}

	// Action for stylesheets tools
	do_action("woodkit_admin_enqueue_styles_tools", array("woodkit-admin-css-jquery-ui"));

	// Loads BxSlider specific stylesheet
	$css_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.css');
	if (!empty($css_bxslider)){
		wp_enqueue_style('woodkit-admin-css-bxslider', $css_bxslider, array(), '2.1.1');
	}

	// Loads Isotope/Slider specific stylesheet.
	$css_isotope_slider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-isotope-slider.css');
	if (!empty($css_isotope_slider)){
		wp_enqueue_style('woodkit-admin-css-isotope-slider', $css_isotope_slider, array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
	}

	// Loads our main template stylesheet
	$css_admin = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-admin.css');
	if (!empty($css_admin)){
		wp_enqueue_style('woodkit-admin-style', $css_admin, array('woodkit-admin-css-isotope-slider', 'woodkit-admin-css-jquery-ui'), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
	}

	// Loads Cookies jQuery plugin
	$js_cookies = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'cookies/jquery.cookie.js');
	if (!empty($js_cookies)){
		wp_enqueue_script('woodkit-script-cookies', $js_cookies, array('jquery'), '1.4.1', true);
	}

	// Loads Utils
	$js_utils = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-utils.js');
	if (!empty($js_utils)){
		wp_enqueue_script('woodkit-script-utils', $js_utils, array('jquery', 'wp-color-picker'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
		wp_localize_script('woodkit-script-utils', 'Utils', array(
				"wait_label" => apply_filters('woodkit-js-wait-label', __('loading...', 'woodkit')),
				"wait_background" => apply_filters('woodkit-js-wait-background', "rgba(255,255,255,0.5)")
		));
	}

	// Loads Isotope JavaScript file
	$js_isotope = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'isotope/isotope.pkgd.min.js');
	if (!empty($js_isotope)){
		wp_enqueue_script('woodkit-admin-script-isotope', $js_isotope, array('jquery'), '3.0.3', true);
	}

	// Loads BxSlider JavaScript file
	$js_bxslider = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'bxslider/jquery.bxslider.min.js');
	if (!empty($js_bxslider)){
		wp_enqueue_script('woodkit-admin-script-bxslider', $js_bxslider, array('jquery'), '2.1.1', true);
	}

	// Loads Gallery Matrix JavaScript file
	$js_gallery_matrix = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery-matrix.js');
	if (!empty($js_gallery_matrix)){
		wp_enqueue_script('woodkit-script-woodkit-gallery-matrix', $js_gallery_matrix, array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

	// Loads Gallery JavaScript file
	$js_gallery = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-gallery.js');
	if (!empty($js_gallery)){
		wp_enqueue_script('woodkit-script-woodkit-gallery', $js_gallery, array('jquery', 'woodkit-script-woodkit-gallery-matrix'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

	// Action for javascript tools
	do_action("woodkit_admin_enqueue_scripts_tools", array("woodkit-script-woodkit-gallery"));

	// Loads JavaScript file for admin.
	$js_admin = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-admin.js');
	if (!empty($js_admin)){
		wp_enqueue_script('woodkit-admin-script', $js_admin, array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}
	
	// Setup color picker (iris) palette colors
	$color_picker_options_palettes = array('#000000', '#ffffff', '#ff0000', '#00ff00', '#0000ff', '#fff000');
	// TODO get options for custom colors
	$color_picker_options_palettes = apply_filters("woodkit_admin_color_picker_options_palettes", $color_picker_options_palettes);
	wp_localize_script('woodkit-admin-script', 'CustomColorPicker', array("palettes" => $color_picker_options_palettes));

	// Load wp.media JavaScript in Admin environnement (widget, posts, ...)
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

	// Font Awesome Version - Woodkit option
	$fontawesome_version = woodkit_get_option("fontawesome-version", "4");

	// Fontawesome
	if ($fontawesome_version == "5"){
		wp_enqueue_script('woodkit-fontawesome-js', 'https://kit.fontawesome.com/7520443ec7.js', array (), $fontawesome_version, true);
	}else{
		$css_fontawesome = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_FONTS_FOLDER.'font-awesome-4/css/font-awesome.min.css');
		if (!empty($css_fontawesome)){
			wp_enqueue_style('woodkit-login-css-fontawesome', $css_fontawesome, array('woodkit-css-bxslider'), "4.4.7");
		}
	}

	// Login
	$css_login = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_CSS_FOLDER.'woodkit-login.css');
	if (!empty($css_login)){
		wp_enqueue_style('woodkit-login-css-login', $css_login, array(), WOODKIT_PLUGIN_WEB_CACHE_VERSION);
	}

	// Loads Utils
	$js_utils = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-utils.js');
	if (!empty($js_utils)){
		wp_enqueue_script('woodkit-script-utils', $js_utils, array('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

	// Loads login scripts
	$js_login = locate_web_ressource(WOODKIT_PLUGIN_TEMPLATES_FOLDER.WOODKIT_PLUGIN_JS_FOLDER.'woodkit-login.js');
	if (!empty($js_login)){
		wp_enqueue_script('woodkit-script-login', $js_login, array('jquery', 'woodkit-script-utils'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true);
	}

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
	// display woodkit widget on top
	global $wp_meta_boxes;
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	$woodkit_widget_backup = array('woodkit-dashboard-info-widget' => $normal_dashboard['woodkit-dashboard-info-widget']);
	unset($normal_dashboard['woodkit-dashboard-info-widget']);
	$sorted_dashboard = array_merge($woodkit_widget_backup, $normal_dashboard);
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	// end display woodkit widget on top
}
add_action('wp_dashboard_setup', 'woodkit_dashboard_setup');

/**
 * Dashboard Widgets : Woodkit Info
 *
 * @return void
*/
function woodkit_dashboard_info_widget() {
	include(WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TEMPLATES_DASHBOARD_FOLDER."infos.php");
}

/**
 * Sanitize FileName - fixe Mac filename encoding
 */
function woodkit_sanitize_file_name ($filename) {
	$clean = utf8_encode($filename);
	return remove_accents($clean);
}
add_filter('sanitize_file_name', 'woodkit_sanitize_file_name', 10);