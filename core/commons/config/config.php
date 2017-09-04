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
define('WOODKIT_CONFIG_GET_KEY_URL', 'http://lab.studio-montana.com/contact/');

/**
 * GLOBALS
*/
global $woodkit_config_default_values;
global $woodkit_config_values;
global $woodkit_config_ac;
global $woodkit_install_notif;

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
				if (defined('WOODKIT_INTERVAL_API'))
					$last_update->add(new DateInterval(WOODKIT_INTERVAL_API));
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
				$url = WOODKIT_URL_API;
				$url = add_query_arg(array("api-action" => "active"), $url);
				$url = add_query_arg(array("api-key-package" => WOODKIT_PLUGIN_NAME), $url);
				$url = add_query_arg(array("api-key-host" => get_site_url()), $url);
				$url = add_query_arg(array("api-key" => $key), $url);
				$request_body = wp_remote_retrieve_body(wp_remote_get($url));
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

if (!function_exists("woodkit_on_admin_init")):
/**
 * woodkit admin init
* @return boolean
*/
function woodkit_on_admin_init(){
	if (!defined('DOING_AJAX') && !defined('DOING_AUTOSAVE')){
		global $woodkit_install_notif;
		if(!isset($woodkit_install_notif)){
			$woodkit_install_notif = false;
			$notif = get_option("woodkit-init-notification", null);
			$plugin_data = get_plugin_data(WP_PLUGIN_DIR.'/woodkit/woodkit.php');
			$website_notif = hash('md5', get_site_url().$plugin_data["Version"]);
			if (!empty($notif) && $notif == $website_notif){
				$woodkit_install_notif = true;
			}
			if (!$woodkit_install_notif){
				$url = WOODKIT_URL_API;
				$url = add_query_arg(array("api-action" => "install"), $url);
				$url = add_query_arg(array("api-package" => WOODKIT_PLUGIN_NAME), $url);
				$url = add_query_arg(array("api-host" => get_site_url()), $url);
				$url = add_query_arg(array("api-version" => $plugin_data["Version"]), $url);
				$request_body = wp_remote_retrieve_body(wp_remote_get($url));
				if (!empty($request_body)) {
					$request_body = @json_decode($request_body);
					if (isset($request_body->install) && $request_body->install == true){
						$woodkit_install_notif = true;
						delete_option('woodkit-init-notification');
						add_option('woodkit-init-notification', $website_notif);
					}
				}
			}
		}
	}
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
* @return multiple : option values - null if doesn't exists
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

if (!function_exists("woodkit_get_option_default_value")):
/**
 * retrieve woodkit option default value for slug
* @return multiple : option value - null if doesn't exists
*/
function woodkit_get_option_default_value($slug){
	$default = null;
	$defaults = woodkit_get_option_default_values();
	if (isset($defaults[$slug]))
		$default = $defaults[$slug];
	return $default;
}
endif;

if (!function_exists("woodkit_after_auto_update")):
/**
 * woodkit after auto update
* @return boolean
*/
function woodkit_after_auto_update($package, $version){
	$url = WOODKIT_URL_API;
	$url = add_query_arg(array("api-action" => "update"), $url);
	$url = add_query_arg(array("api-package" => $package), $url);
	$url = add_query_arg(array("api-host" => get_site_url()), $url);
	$url = add_query_arg(array("api-version" => $version), $url);
	wp_remote_get($url);
}
endif;

/**
 * Plugin options page & Plugin tool options pages
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
			$links[] = '<a href="'.esc_url(get_admin_url(null, 'options-general.php?page=woodkit_options')).'">'.__("Setup", WOODKIT_PLUGIN_TEXT_DOMAIN).'</a>';
		}
		return $links;
	}
	add_filter('plugin_action_links_woodkit/woodkit.php', 'woodkit_plugin_action_links');
	endif;

	if (!function_exists("woodkit_plugin_action_admin_menu")):
	/**
	 * Load plugin tools options page on Woodkit submenu
	*/
	function woodkit_plugin_action_admin_menu_config() {
		$tools = woodkit_get_registered_tools();
		if (!empty($tools)){
			foreach ($tools as $tool) {
				$tool_config_page_path = WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.$tool['slug'].'/options.php';
				if (file_exists($tool_config_page_path)){
					require_once $tool_config_page_path;
					$page_name = apply_filters("tool_".$tool['slug']."_get_page_options_name", "No Page Name");
					$menu_name = '<i class="fa fa-caret-right"></i> '.apply_filters("tool_".$tool['slug']."_get_page_options_menu_name", "No Menu Name");
					$callback = "tool_".$tool['slug']."_get_page_options_callback_function";
					if (function_exists($callback)){
						do_action("woodkit_tool_config_page_before_menu_add", $tool['slug']);
						add_submenu_page("woodkit_options", $page_name, $menu_name, "manage_options", "woodkit_options_tool_".$tool['slug'], $callback);
						do_action("woodkit_tool_config_page_after_menu_add", $tool['slug']);
					}
				};
			}
		}
	}
	add_action('admin_menu', 'woodkit_plugin_action_admin_menu_config');
	endif;

}