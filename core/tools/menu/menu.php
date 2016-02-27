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
 * Enqueue scripts for the front end.
*/
function tool_menu_woodkit_front_enqueue_scripts_tools($dependencies) {

	/**
	 * enqueue menu-hightlight javascript file
	 */
	$js_tool_menu_hightlight = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.MENU_TOOL_NAME.'/js/tool-menu-hightlight.js');
	if (!empty($js_tool_menu_hightlight)){
		if (is_multisite()){
			$home_url = get_site_url(BLOG_ID_CURRENT_SITE);
			$home_minisite_url = get_site_url(get_current_blog_id());
		}else{
			$home_url = home_url('/');
			$home_minisite_url = "";
		}
		$id_blog_page = get_option('page_for_posts');
		if (!empty($id_blog_page) && is_numeric($id_blog_page)){
			$blog_url = get_permalink($id_blog_page);
		}else{
			$blog_url = "";
		}
		if (is_single() && get_post_type() == 'post'){
			$is_post = "1";
		}else{
			$is_post = "0";
		}
		$current_url = get_current_url();
		wp_enqueue_script('tool-menu-script-menu-hightlight', $js_tool_menu_hightlight, $dependencies, '1.0', true);
		wp_localize_script('tool-menu-script-menu-hightlight', 'ToolMenu', array(
			'current_url' => $current_url,
			'home_url' => $home_url,
			'home_minisite_url' => $home_minisite_url,
			'blog_url' => $blog_url,
			'is_post' => $is_post
		));
	}
	/**
	 * enqueue menu-toggle javascript file
	 */
	$js_tool_menu_toggle = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.MENU_TOOL_NAME.'/js/tool-menu-toggle.js');
	if (!empty($js_tool_menu_toggle)){
		wp_enqueue_script('tool-menu-script-menu-toggle', $js_tool_menu_toggle, $dependencies, '1.0', true);
	}
	/**
	 * enqueue menu-fixed-on-scroll javascript file
	 */
	$js_tool_menu_fixed_on_scroll = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.MENU_TOOL_NAME.'/js/tool-menu-fixed-on-scroll.js');
	if (!empty($js_tool_menu_fixed_on_scroll)){
		wp_enqueue_script('tool-menu-script-fixed-on-scroll', $js_tool_menu_fixed_on_scroll, $dependencies, '1.0', true);
	}
}
add_action('woodkit_front_enqueue_scripts_tools', 'tool_menu_woodkit_front_enqueue_scripts_tools');