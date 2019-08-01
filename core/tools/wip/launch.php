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
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.WIP_TOOL_NAME.'/inc/customizer.php');

/**
 * check if wip mode is active
 * @return boolean
 */
function tool_wip_is_wip(){
	$wip = get_theme_mod('wip_state');
	if (!is_user_logged_in() && !empty($wip) && $wip == 1){
		return true;
	}
	return false;
}

if (!function_exists("wip_template_include")):
/**
 * template_include filter (allow to override template hierarchy)
* @since WIP 1.0
* @return template path
*/
function wip_template_include($template) {
	$wip_template = '';
	if (tool_wip_is_wip()){
		$wip_page_id = get_theme_mod('wip_page', 0);
		if (empty($wip_page_id) || get_the_ID() != $wip_page_id){
			$wip_template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WIP_TOOL_NAME.'/templates/tool-wip-page.php');
		}
	}
	if (!empty($wip_template))
		return $wip_template;
	else
		return $template;
}
add_filter('template_include', 'wip_template_include', 2000); // more than private tool (1000)
endif;

/**
 * Redirect 302
 */
if (!function_exists("woodkit_tool_wip_redirect")) :
function woodkit_tool_wip_redirect(){
	if (!is_admin() && tool_wip_is_wip()) {
		$wip_page_id = get_theme_mod('wip_page', 0);
		if (!empty($wip_page_id) && get_the_ID() != $wip_page_id){
			header('HTTP/1.1 302 Found');
			header('Location: '.get_the_permalink($wip_page_id));
			exit();
		}
	}
}
add_action('template_redirect', 'woodkit_tool_wip_redirect');
endif;