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
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/ajax/wall-ajax.php');
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/custom-fields/wall.php');

/**
 * Enqueue styles for the front end.
 */
function tool_wall_woodkit_front_enqueue_styles_tools($dependencies) {

	$css_wall = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/css/tool-wall.css');
	if (!empty($css_wall))
		wp_enqueue_style('tool-wall-css', $css_wall, $dependencies, '1.0');
}
add_action('woodkit_front_enqueue_styles_tools', 'tool_wall_woodkit_front_enqueue_styles_tools');

/**
 * Enqueue styles for the back end.
 */
function tool_wall_woodkit_admin_enqueue_styles_tools($dependencies) {

	$css_wall = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/css/tool-wall-admin.css');
	if (!empty($css_wall))
		wp_enqueue_style('tool-wall-css', $css_wall, $dependencies, '1.0');
}
add_action('woodkit_admin_enqueue_styles_tools', 'tool_wall_woodkit_admin_enqueue_styles_tools');

/**
 * called after woodkit_setup_theme core function
*/
function tool_wall_setup_theme_action(){

	// wall image sizes
	add_image_size('tool-wall-thumb', 500);
	add_image_size('tool-wall-slider-nav-thumb', 150, 150, true);

	// can be override
	do_action('after_tool_wall_setup_theme_action');

}
add_action("woodkit_after_setup_theme", "tool_wall_setup_theme_action");
