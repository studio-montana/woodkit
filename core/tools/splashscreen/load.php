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
define('SPLASHSCREEN_TOOL_NAME', 'splashscreen');

function tool_splashscreen_get_name($tool_name = ""){
	return __("Splash Screen", WOODKIT_PLUGIN_TEXT_DOMAIN);
}
add_filter("woodkit_get_tool_name_".SPLASHSCREEN_TOOL_NAME, "tool_splashscreen_get_name", 1, 1);

function tool_splashscreen_get_description($tool_description = ""){
	return __("Add loading page to your site", WOODKIT_PLUGIN_TEXT_DOMAIN);
}
add_filter("woodkit_get_tool_description_".SPLASHSCREEN_TOOL_NAME, "tool_splashscreen_get_description", 1, 1);

function tool_splashscreen_activate(){
	require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SPLASHSCREEN_TOOL_NAME.'/'.SPLASHSCREEN_TOOL_NAME.'.php');
}
add_action("woodkit_tool_activate_".SPLASHSCREEN_TOOL_NAME, "tool_splashscreen_activate");