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
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.WIDGETMANAGER_TOOL_NAME.'/custom-fields/widgetmanager.php');

if (!function_exists("tool_widgetmanager_get_available_sidebars")):
function tool_widgetmanager_get_available_sidebar_ids(){
	$available_sidebars = array();
	foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar_id => $sidebar_args){
		$available_sidebars[] = $sidebar_id;
	}
	$available_sidebars = apply_filters("tool_widgetmanager_get_available_sidebars", $available_sidebars);
	return $available_sidebars;
}
endif;

/**
 * Enqueue styles for the back end.
 */
function tool_widgetmanager_woodkit_admin_enqueue_styles_tools($dependencies) {

	$css_widgetmanager = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WIDGETMANAGER_TOOL_NAME.'/css/tool-widgetmanager-admin.css');
	if (!empty($css_widgetmanager))
		wp_enqueue_style('tool-widgetmanager-css', $css_widgetmanager, $dependencies, '1.0');
}
add_action('woodkit_admin_enqueue_styles_tools', 'tool_widgetmanager_woodkit_admin_enqueue_styles_tools');

/**
 * filter widgets list and check they are not hidden by widgetmanager
*/
function tool_widgetmanager_sidebars_widgets($sidebars_widgets){
	if (!is_admin()){
		foreach ($sidebars_widgets as $sidebar => $widgets){
			$new_set = array();
			if (!empty($widgets)){
				foreach ($widgets as $widget){
					$hide = @get_post_meta(get_the_ID(), TOOL_WIDGETMANAGER_HIDE_WIDGET_.$sidebar.$widget, true);
					if (!isset($hide) || empty($hide) || $hide != 'on'){
						$new_set[] = $widget;
					}
				}
			}
			$sidebars_widgets[$sidebar] = $new_set;
		}
	}
	return $sidebars_widgets;
}
add_filter('sidebars_widgets', 'tool_widgetmanager_sidebars_widgets');