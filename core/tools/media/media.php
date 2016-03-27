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
 * REQUIREMENTS
*/
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.MEDIA_TOOL_NAME.'/custom-fields/media.php');

/**
 * Enqueue styles for the front end.
*/
function tool_media_woodkit_front_enqueue_styles_tools($dependencies) {

	$css_media = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.MEDIA_TOOL_NAME.'/css/tool-media.css');
	if (!empty($css_media))
		wp_enqueue_style('tool-media-css', $css_media, $dependencies, '1.0');

	$media_fancybox_active = woodkit_get_option('tool-media-fancybox-active');
	if (!empty($media_fancybox_active) && $media_fancybox_active == 'on'){
		$css_media_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.MEDIA_TOOL_NAME.'/css/tool-media-fancybox.css');
		if (!empty($css_media_fancybox))
			wp_enqueue_style('tool-media-css-fancybox', $css_media_fancybox, $dependencies, '1.0');
	}
}
add_action('woodkit_front_enqueue_styles_tools', 'tool_media_woodkit_front_enqueue_styles_tools');

/**
 * Enqueue scripts for the front end.
*/
function tool_media_woodkit_front_enqueue_scripts_tools($dependencies) {
	$media_fancybox_active = woodkit_get_option('tool-media-fancybox-active');
	if (!empty($media_fancybox_active) && $media_fancybox_active == 'on'){
		$js_tool_media_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.MEDIA_TOOL_NAME.'/js/tool-media-fancybox.js');
		if (!empty($js_tool_media_fancybox))
			wp_enqueue_script('tool-media-script-fancybox', $js_tool_media_fancybox, $dependencies, '1.0', true);
	}
}
add_action('woodkit_front_enqueue_scripts_tools', 'tool_media_woodkit_front_enqueue_scripts_tools');

/**
 * called after woodkit_setup_theme core function
*/
function tool_media_setup_theme_action(){

	// media image sizes
	add_image_size('tool-media-thumb', 500);
	add_image_size('tool-media-slider-nav-thumb', 150, 150, true);

	// can be override
	do_action('after_tool_media_setup_theme_action');

}
add_action("woodkit_after_setup_theme", "tool_media_setup_theme_action");

function tool_media_image_send_to_editor($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){

	$media_fancybox_active = woodkit_get_option('tool-media-fancybox-active');
	if (!empty($media_fancybox_active) && $media_fancybox_active == 'on'){
		$classes = 'fancybox'; // separated by spaces, e.g. 'img image-link'

		if ( preg_match('/<a.*? class=".*?">/', $html) ) {
			$html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
		} else {
			$html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
		}

		$rel = 'group-single';
		if ( preg_match('/<a.*? rel=".*?">/', $html) ) {
			$html = preg_replace('/(<a.*? rel=".*?)(".*?>)/', '$1 ' . $rel . '$2', $html);
		} else {
			$html = preg_replace('/(<a.*?)>/', '$1 rel="' . $rel . '" >', $html);
		}
	}
	
	return $html;
}
add_filter('image_send_to_editor','tool_media_image_send_to_editor',10,8);
