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

global $available_tools;
global $registered_tools;

if (!function_exists("woodkit_get_available_tools_paths_base")):
/**
 * retrieve available tools paths base
*/
function woodkit_get_available_tools_paths_base(){
	$paths_base = array();
	$paths_base[] = WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER;
	$paths_base = apply_filters("woodkit_get_available_tools_paths_base", $paths_base);
	return $paths_base;
}
endif;

if (!function_exists("woodkit_get_available_tools")):
/**
 * retrieve available tools
* @return array:array tools (array(array('slug', 'name', 'description'))
		*/
function woodkit_get_available_tools($reload = false){
	global $available_tools;
	if ($reload || empty($available_tools)){
		$available_tools = array();
		$paths_base = woodkit_get_available_tools_paths_base();
		if (!empty($paths_base)){
			foreach ($paths_base as $path_base){
				if (is_dir($path_base)){
					$tools_folders = scandir($path_base);
					if ($tools_folders){
						foreach ($tools_folders as $tool_folder){
							if ($tool_folder != '.' && $tool_folder != '..' && $tool_folder != '.DS_Store'){
								$tool_path = $path_base.$tool_folder.'/load.php';
								if (file_exists($tool_path)){
									require_once $tool_path;
									$available_tools[] = array('slug' => $tool_folder, 'name' => woodkit_get_tool_name($tool_folder), 'description' => woodkit_get_tool_description($tool_folder));
									do_action("woodkit_tool_loaded", $tool_folder);
								}
							}
						}
					}
				}
			}
		}
	}
	return $available_tools;
}
endif;

if (!function_exists("woodkit_get_registered_tools")):
/**
 * retrieve registered tools
* @return array:array tools (array(array('slug', 'name', 'description'))
		*/
function woodkit_get_registered_tools($reload = false){
	global $registered_tools;
	if ($reload || empty($registered_tools)){
		$registered_tools = array();
		if (woodkit_is_registered()){
			$available_tools = woodkit_get_available_tools();
			if (!empty($available_tools)){
				foreach ($available_tools as $tool){
					$active = apply_filters("woodkit_is_tool_".$tool['slug']."_active", false);
					if ($active){
						$registered_tools[] = $tool;
					}
				}
			}
		}
	}
	return $registered_tools;
}
endif;

if (!function_exists("woodkit_get_tool_name")):
/**
 * retrieve tool name
* @param string $tool_slug
* @return string
*/
function woodkit_get_tool_name($tool_slug){
	$tool_name = $tool_slug;
	$tool_name = apply_filters("woodkit_get_tool_name_".$tool_slug, $tool_name); // must be hooked by tool
	return $tool_name;
}
endif;

if (!function_exists("woodkit_get_tool_description")):
/**
 * retrieve tool description
* @param string $tool_slug
* @return string
*/
function woodkit_get_tool_description($tool_slug){
	$tool_description = $tool_slug;
	$tool_description = apply_filters("woodkit_get_tool_description_".$tool_slug, $tool_description); // must be hooked by tool
	return $tool_description;
}
endif;

if (!function_exists("woodkit_is_registered_tool")):
/**
 * check if specified tool name is registered
* @param string $tool_slug (ex. 'video')
* @return boolean
*/
function woodkit_is_registered_tool($tool_slug, $reload = false) {
	if (!empty($tool_slug)){
		$registered_tools = woodkit_get_registered_tools($reload);
		foreach ($registered_tools as $tool){
			if ($tool_slug == $tool['slug'])
				return true;
		}
	}
	return false;
}
endif;

if (!function_exists("activate_woodkit_tools")):
/**
 * activate registered tools
*/
function woodkit_activate_tools() {
	$registered_tools = woodkit_get_registered_tools();
	if (!empty($registered_tools)){
		foreach ($registered_tools as $tool){
			do_action("woodkit_tool_activate_".$tool['slug']); // must be hooked by tool
			do_action("woodkit_tool_activated", $tool['slug']);
		}
	}
	do_action("woodkit_tools_activated", $registered_tools);
}
endif;

/**
 * activate tools
 */
woodkit_activate_tools();