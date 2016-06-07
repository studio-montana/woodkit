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
 * register JS
*/
function tool_googlemaps_googlemapsgenerator_admin_enqueue_scripts(){
	$googlemapsgenerator_js_file = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.GOOGLEMAPS_TOOL_NAME.'/googlemapsgenerator/googlemapsgenerator.js');
	if (!empty($googlemapsgenerator_js_file)){
		wp_enqueue_script('script-tool-googlemaps-googlemapsgenerator', $googlemapsgenerator_js_file, array('jquery'), "1.0");
		wp_localize_script('script-tool-googlemaps-googlemapsgenerator', 'Googlemapsgenerator', array(
		'doneButtonText' => __("Ok", WOODKIT_PLUGIN_TEXT_DOMAIN),
		)
		);
	}
}
add_action('admin_enqueue_scripts', 'tool_googlemaps_googlemapsgenerator_admin_enqueue_scripts');

