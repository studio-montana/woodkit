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
 * CONSTANTS
*/
define('WOODKIT_CONFIG_OPTIONS', 'woodkit_config_options');
define('WOODKIT_CONFIG_GET_KEY_URL', 'http://api.studio-montana.com/?action=getkey&package=woodkit');

/**
 * GLOBALS
*/
global $woodkit_config_default_values;
global $woodkit_config_values;
global $woodkit_config_ac;

if (!function_exists("woodkit_load_tools_config")):
/**
 * load tools configuration file
*/
function woodkit_load_tools_config(){
	if (is_dir(WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER)){
		$tools_folders = scandir(WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER);
		if ($tools_folders){
			foreach ($tools_folders as $tool_folder){
				if ($tool_folder != '.' && $tool_folder != '..'){
					$tool_path = WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.$tool_folder.'/config.php';
					if (file_exists($tool_path)){
						require_once $tool_path;
						do_action("woodkit_tool_config_loaded", $tool_folder);
					}
				}
			}
		}
	}
}
woodkit_load_tools_config();
endif;

if (!function_exists("woodkit_is_registered")):
/**
 * woodkit registration
* @return boolean
*/
function woodkit_is_registered(){
	global $woodkit_config_ac;
	if(!isset($woodkit_config_ac)){
		$woodkit_config_ac = false;
		$key = woodkit_get_option("key-activation");
		if (!empty($key)){
			$reload = true;
			$already_activated = false;
			$key_changed = false;
			$old_key = get_option('woodkit-old-key-activation', null);
			$last_update = get_option('woodkit-activated-update', null);
			$now = new DateTime();
			if ($last_update != null){
				$last_update->add(new DateInterval('PT1H'));
				if ($last_update > $now){
					$already_activated = true;
				}
			}
			if (empty($old_key) || $old_key != $key){
				$key_changed = true;
			}
			if (!$key_changed && $already_activated){
				$reload = false;
			}
			if ($reload){
				$woodkit_config_ac = false;
				$url = WOODKIT_API_URL;
				$url = add_query_arg(array("api-action" => "active"), $url);
				$url = add_query_arg(array("api-package" => WOODKIT_PLUGIN_NAME), $url);
				$url = add_query_arg(array("api-host" => get_site_url()), $url);
				$url = add_query_arg(array("api-key" => $key), $url);
				$request_body = wp_remote_retrieve_body( wp_remote_get( $url ) );
				if (!empty($request_body)) {
					$request_body = @json_decode($request_body);
					if (isset($request_body->active) && $request_body->active == true)
						$woodkit_config_ac = true;
				}
				if ($last_update != null)
					delete_option('woodkit-activated-update');
				if ($woodkit_config_ac)
					add_option('woodkit-activated-update', $now, '', false);
				if ($old_key != null)
					delete_option('woodkit-old-key-activation');
				add_option('woodkit-old-key-activation', $key, '', false);
			}else{
				$woodkit_config_ac = $already_activated;
			}
		}
	}
	return $woodkit_config_ac;
}
endif;

if (!function_exists("woodkit_get_options")):
/**
 * retrieve woodkit options values
* @return multiple : option value - null if doesn't exists
*/
function woodkit_get_options($reload = false){
	global $woodkit_config_values;
	if ($reload || !isset($woodkit_config_values)){
		$options = get_option(WOODKIT_CONFIG_OPTIONS);
		if (!isset($options))
			$options = array();
		$default_values = woodkit_get_option_default_values();
		foreach ($default_values as $id => $value){
			if (!isset($options[$id])){
				$options[$id] = $value;
			}
		}
	}
	return $options;
}
endif;

if (!function_exists("woodkit_get_option")):
/**
 * retrieve woodkit option value
* @param string $id : option id
* @return multiple : option value - null if doesn't exists
*/
function woodkit_get_option($slug, $default = null){
	$res = $default;
	$options = woodkit_get_options();
	if (!empty($options)){
		foreach ($options as $value) {
			if (isset($options[$slug])) {
				$res = $options[$slug];
			}
		}
	}
	return $res;
}
endif;

if (!function_exists("woodkit_get_option_default_values")):
/**
 * retrieve woodkit option default values
* @return multiple : option value - null if doesn't exists
*/
function woodkit_get_option_default_values(){
	global $woodkit_config_default_values;
	if (!isset($woodkit_config_default_values)){
		$woodkit_config_default_values = array();
		$woodkit_config_default_values = apply_filters("woodkit_config_default_values", $woodkit_config_default_values);
	}
	return $woodkit_config_default_values;
}
endif;

/**
 * Plugin options page
 */
if (is_admin()){

	require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_CONFIG_FOLDER.'config-options.php');

	if (!function_exists("woodkit_plugin_action_links")):
	/**
	 * Plugin admin links
	* @param unknown $links
	* @return string
	*/
	function woodkit_plugin_action_links( $links ) {
		global $pagenow;
		if($pagenow == 'plugins.php'){
			if (woodkit_is_registered()){
				$links[] = '<a href="'.esc_url(get_admin_url(null, 'options-general.php?page=woodkit_options')).'">'.__("Setup", WOODKIT_PLUGIN_TEXT_DOMAIN).'</a>';
			}else{
				$links[] = '<a href="'.esc_url(get_admin_url(null, 'options-general.php?page=woodkit_options')).'">'.__("Register", WOODKIT_PLUGIN_TEXT_DOMAIN).'</a>';
				$links[] = '<a href="'.esc_url(WOODKIT_CONFIG_GET_KEY_URL).'" target="_blank">'.__("Get key", WOODKIT_PLUGIN_TEXT_DOMAIN).'</a>';
			}
		}
		return $links;
	}
	add_filter('plugin_action_links_woodkit/woodkit.php', 'woodkit_plugin_action_links');
	endif;
}