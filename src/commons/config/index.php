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
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_CONFIG_FOLDER.'render.php');

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
		if (!empty($old_options)){
			foreach ($old_options as $old_option_key => $old_option_value){
				if (!array_key_exists($old_option_key, $options)){
					$options[$old_option_key] = $old_option_value;
				}
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

/**
 * Plugin options page & Plugin tool options pages
 */
if (is_admin()){

	/**
	 * Plugin admin links
	 * @param unknown $links
	 * @return string
	 */
	add_filter('plugin_action_links_woodkit/woodkit.php', function ($links) {
		global $pagenow;
		if($pagenow == 'plugins.php'){
			$links[] = '<a href="'.esc_url(get_admin_url(null, 'admin.php?page=woodkit_options')).'">'.__("Setup", 'woodkit').'</a>';
		}
		return $links;
	});

	/**
	 * Add Plugin option page entry to Menu
	 */
	add_action ( 'admin_menu', function () {
		$page_name = __ ( "Woodkit", 'woodkit' );
		$menu_name = __ ( "Woodkit", 'woodkit' );
		add_menu_page ( $page_name, $menu_name, "manage_options", "woodkit_options", "woodkit_plugin_menu_config_callback", get_woodkit_icon('logo-plain', true, true));
	});

	/**
	 * Display plugin option page
	 */
	function woodkit_plugin_menu_config_callback() {
		new WoodkitConfig();
	}
}