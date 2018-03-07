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
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_TOOLS_FOLDER.'tool.class.php');
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_TOOLS_FOLDER.'tools-config.php');

/**
 * GLOBALS
 */
global $woodkit_available_tools;
global $woodkit_activated_tools;
global $woodkit_tool_config_default_values;

if (!function_exists("woodkit_get_available_tools")):
/**
 * retrieve available tools (sorted by name)
* @return array:array tools (array(array('slug', 'name', 'description'))
		*/
function woodkit_get_available_tools(){
	global $woodkit_available_tools;
	if (!is_array($woodkit_available_tools)){
		$woodkit_available_tools = array();
		$tools_pathbase = WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER;
		if (is_dir($tools_pathbase)){
			$tools_folders = scandir($tools_pathbase);
			if ($tools_folders){
				foreach ($tools_folders as $tool_folder){
					if ($tool_folder != '.' && $tool_folder != '..' && $tool_folder != '.DS_Store'){
						$tool_path = $tools_pathbase.$tool_folder.'/index.php';
						if (file_exists($tool_path)){
							require_once $tool_path; // load all tool index.php file which must add_filter : "woodkit-register-tool" to register themself
						}
					}
				}
			}
		}
		$woodkit_available_tools = apply_filters("woodkit-register-tool", $woodkit_available_tools);
		usort($woodkit_available_tools, 'woodkit_cmp_tools_by_name');
	}
	return $woodkit_available_tools;
}
endif;

if (!function_exists("woodkit_get_activated_tools")):
/**
 * retrieve activated tools
* @return array:array tools (array(array('slug', 'name', 'description'))
		*/
function woodkit_get_activated_tools($reload = false){
	global $woodkit_activated_tools;
	if ($reload || empty($woodkit_activated_tools)){
		$woodkit_activated_tools = array();
		$available_tools = woodkit_get_available_tools();
		if (!empty($available_tools)){
			foreach ($available_tools as $tool){
				if (woodkit_is_activated_tool($tool->slug, $reload)){
					$woodkit_activated_tools[] = $tool;
				}
			}
		}
	}
	return $woodkit_activated_tools;
}
endif;

if (!function_exists("woodkit_get_tool")):
/**
 * Retrieve Tool
* @return NULL|WoodkitTool
*/
function woodkit_get_tool($tool_slug){
	$res_tool = null;
	$tools = woodkit_get_available_tools();
	if (!empty($tools)){
		foreach ($tools as $tool){
			if ($tool->slug == $tool_slug){
				$res_tool = $tool;
				break;
			}
		}
	}
	return $res_tool;
}
endif;

if (!function_exists("woodkit_get_tool_options")):
/**
 * Retrieve Tool's options
 * @return NULL|multiple
 */
function woodkit_get_tool_options($tool_slug){
	return woodkit_get_option('tool-'.$tool_slug, null);
}
endif;

if (!function_exists("woodkit_get_tool_option")):
/**
 * Retrieve Tool's option value
 * @param unknown $tool_slug - tool's slug
 * @param unknown $option_name - tool's option name
 * @param unknown $default - default value (after default value specified in tool's config.php file)
 * @return NULL|multiple
 */
function woodkit_get_tool_option($tool_slug, $option_name, $default = null){
	$tool_option = null;
	$tool_default_value = woodkit_get_tool_option_default_value($tool_slug, $option_name);
	$tool_options = woodkit_get_option('tool-'.$tool_slug);
	if (is_array($tool_options) && array_key_exists($option_name, $tool_options)){
		$tool_option = $tool_options[$option_name];
	}else if ($tool_default_value != null){
		$tool_option = $tool_default_value;
	}else{
		$tool_option = $default;
	}
	return $tool_option;
}
endif;

if (!function_exists("woodkit_get_tool_option_default_values")):
/**
 * retrieve woodkit tools option default values - array(tool_slug => array(option_slug => option_value))
* @return array
*/
function woodkit_get_tool_option_default_values($reload = false){
	global $woodkit_tool_config_default_values;
	if (!isset($woodkit_tool_config_default_values) || $reload){
		$woodkit_tool_config_default_values = array();
		$available_tools = woodkit_get_available_tools();
		if (!empty($available_tools)){
			foreach ($available_tools as $tool){
				$woodkit_tool_config_default_values[$tool->slug] = $tool->get_config_default_values();
			}
		}
	}
	return $woodkit_tool_config_default_values;
}
endif;

if (!function_exists("woodkit_get_tool_option_default_value")):
/**
 * retrieve woodkit tools option default value
 * @param unknown $tool_slug
 * @param unknown $option_name
 * @param string $reload
 * @return mixed|NULL
 */
function woodkit_get_tool_option_default_value($tool_slug, $option_name, $reload = false){
	$default_values = woodkit_get_tool_option_default_values($reload);
	if (isset($default_values[$tool_slug]) && isset($default_values[$tool_slug][$option_name])){
		return $default_values[$tool_slug][$option_name];
	}
	return null;
}
endif;

if (!function_exists("woodkit_save_tool_option")):
/**
 * Save Woodkit tool option
 * @param unknown $tool_slug
 * @param unknown $option_name
 * @param unknown $option_value
 */
function woodkit_save_tool_option($tool_slug, $option_name, $option_value){
	$tool_options = woodkit_get_option('tool-'.$tool_slug);
	if (empty($tool_options) || !is_array($tool_options)){
		$tool_options = array();
	}
	$tool_options[$option_name] = $option_value;
	woodkit_save_tool_options($tool_slug, $tool_options);
}
endif;

if (!function_exists("woodkit_save_tool_options")):
/**
 * Save Woodkit tool options - <strong>IMPORTANT</strong> : options which are not in specified $options will be erase for the specief tool
 * @param unknown $tool_slug
 * @param unknown $option_name
 * @param unknown $option_value
 */
function woodkit_save_tool_options($tool_slug, $tool_options){
	woodkit_save_option('tool-'.$tool_slug, $tool_options);
}
endif;

if (!function_exists("woodkit_is_activated_tool")):
/**
 * check if specified tool is activated
* @param string $tool_slug (ex. 'video')
* @return boolean
*/
function woodkit_is_activated_tool($tool_slug, $reload = false) {
	if (!empty($tool_slug)){
		$tool_active = woodkit_get_tool_option($tool_slug, 'active');
		if (!empty($tool_active) && $tool_active == 'on'){
			return true;
		}
	}
	return false;
}
endif;

if (!function_exists("woodkit_activate_tool")):
/**
 * activate specified tool
 * @param unknown $tool_slug
 */
function woodkit_activate_tool($tool_slug){
	$tool = woodkit_get_tool($tool_slug);
	if (is_object($tool) && !woodkit_is_activated_tool($tool_slug)){
		woodkit_save_tool_option($tool_slug, 'active', 'on');
		$tool->activate();
		woodkit_get_activated_tools(true); // reload activated tools
	}else{
		trace_err("woodkit_activate_tool - try to activate null tool");
	}
}
endif;

if (!function_exists("woodkit_deactivate_tool")):
/**
 * deactivate specified tool
 * @param unknown $tool_slug
 */
function woodkit_deactivate_tool($tool_slug){
	$tool = woodkit_get_tool($tool_slug);
	if (is_object($tool) && woodkit_is_activated_tool($tool_slug)){
		woodkit_save_tool_option($tool_slug, 'active', 'off');
		$tool->deactivate();
		woodkit_get_activated_tools(true); // reload activated tools
	}else{
		trace_err("woodkit_deactivate_tool - try to deactivate null tool");
	}
}
endif;

if (!function_exists("woodkit_tools_fire_activation")):
/**
 * Fire activation on all activated tools
 */
function woodkit_tools_fire_activation(){
	$activated_tools = woodkit_get_activated_tools(true);
	if (!empty($activated_tools)){
		foreach ($activated_tools as $tool){
			trace_info("plugin.activate.php - fire activation on tool [{$tool->slug}]");
			$tool->activate();
		}
	}
}
endif;

if (!function_exists("woodkit_tools_fire_deactivation")):
/**
 * Fire deactivation on all activated tools
*/
function woodkit_tools_fire_deactivation(){
	$activated_tools = woodkit_get_activated_tools(true);
	if (!empty($activated_tools)){
		foreach ($activated_tools as $tool){
			trace_info("plugin.deactivate.php - fire deactivation on tool [{$tool->slug}]");
			$tool->deactivate();
		}
	}
}
endif;

if (!function_exists("woodkit_launch_tools")):
/**
 * launch activated tools
*/
function woodkit_launch_tools() {
	$activated_tools = woodkit_get_activated_tools();
	if (!empty($activated_tools)){
		foreach ($activated_tools as $tool){
			$tool->launch();
			do_action("woodkit_tool_launched", $tool->slug);
		}
	}
	do_action("woodkit_tools_launched", $activated_tools);
}
endif;

/**
 * launch activated tools
 */
woodkit_launch_tools();