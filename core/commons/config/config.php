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
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_CONFIG_FOLDER.'config-render.php');

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

if (!function_exists("woodkit_is_registered")):
/**
 * woodkit registration
* @return boolean
*/
function woodkit_is_registered($force_reload = false){
	global $woodkit_config_ac;
	if(!isset($woodkit_config_ac) || $force_reload){
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
	// TODO on seb-c.com get_plugin_data call get "call undefined function" - I don't know WHY !!!
	if (!defined('DOING_AJAX') && !defined('DOING_AUTOSAVE') && function_exists("get_plugin_data")){
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

if (!function_exists("woodkit_save_options")):
/**
 * save woodkit options
* @param array $options - woodkit options
* @param boolean $merge - merge old option with newest - default is true
* @param boolean $reload - clear woodkit options cache after save - default is true
*/
function woodkit_save_options($options, $merge = true, $reload = true){
	if ($merge){
		$old_options = woodkit_get_options();
		foreach ($old_options as $old_option_key => $old_option_value){
			if (!array_key_exists($old_option_key, $options)){
				$options[$old_option_key] = $old_option_value;
			}
		}
		update_option(WOODKIT_CONFIG_OPTIONS, $options);
	}else{
		// IMPORTANT : erase old options which are not in the new options set
		update_option(WOODKIT_CONFIG_OPTIONS, $options);
	}
	if ($reload){ // reload options (clear option global cache)
		woodkit_get_options(true);
	}
}
endif;

if (!function_exists("woodkit_save_option")):
/**
 * retrieve woodkit options values
* @return multiple : option value - null if doesn't exists
*/
function woodkit_save_option($option_name, $option_value){
	$options = woodkit_get_options();
	$options[$option_name] = $option_value;
	woodkit_save_options($options);
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
		$woodkit_config_values = get_option(WOODKIT_CONFIG_OPTIONS);
		if (!isset($woodkit_config_values))
			$woodkit_config_values = array();
		$default_values = woodkit_get_option_default_values();
		foreach ($default_values as $id => $value){
			if (!isset($woodkit_config_values[$id])){
				$woodkit_config_values[$id] = $value;
			}
		}
	}
	return $woodkit_config_values;
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

	/**
	 * Add Plugin option page entry to Menu
	 */
	function woodkit_plugin_add_menu_config() {
		$page_name = __ ( "Woodkit", 'po' );
		$menu_name = __ ( "Woodkit", 'po' );
		add_menu_page ( $page_name, $menu_name, "manage_options", "woodkit_options", "woodkit_plugin_menu_config_callback", 'none');
	}
	add_action ( 'admin_menu', 'woodkit_plugin_add_menu_config' );
	
	/**
	 * Display plugin option page
	 */
	function woodkit_plugin_menu_config_callback() {
		$woodkit_options = new WoodkitOptions();
	}
}