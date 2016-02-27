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
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.GALLERY_TOOL_NAME.'/custom-fields/gallery.php');
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.GALLERY_TOOL_NAME.'/inc/customizer.php');

/**
 * Enqueue styles for the front end.
 */
function tool_gallery_woodkit_front_enqueue_styles_tools($dependencies) {

	$css_gallery = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.GALLERY_TOOL_NAME.'/css/tool-gallery.css');
	if (!empty($css_gallery))
		wp_enqueue_style('tool-gallery-css', $css_gallery, $dependencies, '1.0');

	$css_gallery_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.GALLERY_TOOL_NAME.'/css/tool-gallery-fancybox.css');
	if (!empty($css_gallery_fancybox))
		wp_enqueue_style('tool-gallery-css-fancybox', $css_gallery_fancybox, $dependencies, '1.0');
}
add_action('woodkit_front_enqueue_styles_tools', 'tool_gallery_woodkit_front_enqueue_styles_tools');

/**
 * Enqueue scripts for the front end.
*/
function tool_gallery_woodkit_front_enqueue_scripts_tools($dependencies) {

	$js_tool_gallery_fancybox = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.GALLERY_TOOL_NAME.'/js/tool-gallery-fancybox.js');
	if (!empty($js_tool_gallery_fancybox))
		wp_enqueue_script('tool-gallery-script-fancybox', $js_tool_gallery_fancybox, $dependencies, '1.0', true);
}
add_action('woodkit_front_enqueue_scripts_tools', 'tool_gallery_woodkit_front_enqueue_scripts_tools');

/**
 * called after woodkit_setup_theme core function
*/
function tool_gallery_setup_theme_action(){

	// gallery image sizes
	add_image_size('tool-gallery-thumb', 500);
	add_image_size('tool-gallery-slider-nav-thumb', 150, 150, true);

	// can be override
	do_action('after_tool_gallery_setup_theme_action');

}
add_action("woodkit_after_setup_theme", "tool_gallery_setup_theme_action");
