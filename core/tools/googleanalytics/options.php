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

function tool_googleanalytics_get_page_options_name($name){
	return __("Google Analytics", WOODKIT_PLUGIN_TEXT_DOMAIN);
}
add_filter("tool_googleanalytics_get_page_options_name", "tool_googleanalytics_get_page_options_name");

function tool_googleanalytics_get_page_options_menu_name($name){
	return __("Google Analytics", WOODKIT_PLUGIN_TEXT_DOMAIN);
}
add_filter("tool_googleanalytics_get_page_options_menu_name", "tool_googleanalytics_get_page_options_menu_name");

function tool_googleanalytics_get_page_options_callback_function($name){
	require_once(WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.GOOGLEANALYTICS_TOOL_NAME.'/options-page.php');
}




