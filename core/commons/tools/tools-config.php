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
 * Add activated tools config page to Woodkit submenu
 */
function woodkit_plugin_tools_config_menu() {
	$tools = woodkit_get_activated_tools(false, true);
	if (!empty($tools)){
		foreach ($tools as $tool) {
			if ($tool->has_config){
				if ($tool->add_config_in_menu){
					add_submenu_page("woodkit_options", $tool->name, '<i class="fa fa-caret-right" style="margin-right: 2px;"></i>'.$tool->name, "manage_options", "woodkit_options_tool_".$tool->slug, array($tool, 'render_config'));
				}else{
					add_submenu_page(null, $tool->name, $tool->name, "manage_options", "woodkit_options_tool_".$tool->slug, array($tool, 'render_config'));
				}
			}
		}
	}
}
add_action('admin_menu', 'woodkit_plugin_tools_config_menu');

/**
 * Save tools config forms
 */
function woodkit_plugin_tools_config_save(){
	$tools = woodkit_get_activated_tools(false, true);
	if (!empty($tools)){
		foreach ($tools as $tool) {
			if ($tool->has_config){
				$tool->save_config();
			}
		}
	}
}