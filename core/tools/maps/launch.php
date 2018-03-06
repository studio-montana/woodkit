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
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.MAPS_TOOL_NAME.'/googlemapsgenerator/googlemapsgenerator.php');
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.MAPS_TOOL_NAME.'/shortcode/shortcode.php');
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.MAPS_TOOL_NAME.'/widgets/googlemaps-widget.class.php');

/**
 * Enqueue styles for the front end.
 */
function tool_googlemaps_woodkit_front_enqueue_scripts_tools($dependencies) {
	$googlemap_api_enqueueapi = woodkit_get_tool_option(MAPS_TOOL_NAME, 'googlemaps-enqueueapi');
	if (!empty($googlemap_api_enqueueapi) && $googlemap_api_enqueueapi == 'on'){
		$googlemap_api_key = woodkit_get_tool_option(MAPS_TOOL_NAME, 'googlemaps-apikey');
		if (!empty($googlemap_api_key)){
			$googlemap_api_key = "?key=".$googlemap_api_key;
			wp_enqueue_script('tool-maps-googleapi-maps', 'https://maps.googleapis.com/maps/api/js'.$googlemap_api_key, array(), null, false); // be sure to not add "ver" query var
		}
	}
}
add_action('woodkit_front_enqueue_scripts_tools', 'tool_googlemaps_woodkit_front_enqueue_scripts_tools');

/**
 * Enqueue styles for the back end.
 */
function tool_googlemaps_woodkit_admin_enqueue_styles_tools($dependencies) {
	$css_googlemaps = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.MAPS_TOOL_NAME.'/css/tool-maps-admin.css');
	if (!empty($css_googlemaps))
		wp_enqueue_style('tool-googlemaps-css', $css_googlemaps, $dependencies, '1.0');
}
add_action('woodkit_admin_enqueue_styles_tools', 'tool_googlemaps_woodkit_admin_enqueue_styles_tools');