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
 * WIDGETS
 */
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SOCIAL_TOOL_NAME.'/widgets/tool-social-widget.class.php');

/**
 * Enqueue styles for the front end.
 */
function tool_social_woodkit_front_enqueue_styles_tools($dependencies) {

	$css_social = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SOCIAL_TOOL_NAME.'/css/tool-social.css');
	if (!empty($css_social))
		wp_enqueue_style('tool-social-css', $css_social, $dependencies, '1.0');
}
add_action('woodkit_front_enqueue_styles_tools', 'tool_social_woodkit_front_enqueue_styles_tools');

/**
 * Enqueue styles for the back end.
 */
function tool_social_woodkit_admin_enqueue_styles_tools($dependencies) {

	$css_social = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SOCIAL_TOOL_NAME.'/css/tool-social-admin.css');
	if (!empty($css_social))
		wp_enqueue_style('tool-social-css', $css_social, $dependencies, '1.0');
}
add_action('woodkit_admin_enqueue_styles_tools', 'tool_social_woodkit_admin_enqueue_styles_tools');

/**
 * Enqueue scripts for the back end.
 */
function tool_social_woodkit_admin_enqueue_scripts_tools($dependencies) {

	$js_tool_social = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SOCIAL_TOOL_NAME.'/js/tool-social.js');
	if (!empty($js_tool_social))
		wp_enqueue_script('tool-social-script', $js_tool_social, $dependencies, '1.0', true);
}
add_action('woodkit_admin_enqueue_scripts_tools', 'tool_social_woodkit_admin_enqueue_scripts_tools');