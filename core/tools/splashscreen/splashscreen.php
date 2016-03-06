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
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SPLASHSCREEN_TOOL_NAME.'/inc/customizer.php');

if (!function_exists("tool_splashscreen_woodkit_front_enqueue_styles_tools")):
/**
 * Enqueue styles for the front end.
*/
function tool_splashscreen_woodkit_front_enqueue_styles_tools($dependencies) {
	$css_splashscreen = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SPLASHSCREEN_TOOL_NAME.'/css/tool-splashscreen.css');
	if (!empty($css_splashscreen))
		wp_enqueue_style('tool-splashscreen-css', $css_splashscreen, $dependencies, '1.0');
}
add_action('woodkit_front_enqueue_styles_tools', 'tool_splashscreen_woodkit_front_enqueue_styles_tools');
endif;

if (!function_exists("tool_splashscreen_woodkit_front_enqueue_scripts_tools")):
/**
 * Enqueue scripts for the front end.
*/
function tool_splashscreen_woodkit_front_enqueue_scripts_tools($dependencies) {

	$js_tool_splashscreen = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SPLASHSCREEN_TOOL_NAME.'/js/tool-splashscreen.js');
	if (!empty($js_tool_splashscreen))
		wp_enqueue_script('tool-splashscreen-script', $js_tool_splashscreen, $dependencies, '1.0', true);
}
add_action('woodkit_front_enqueue_scripts_tools', 'tool_splashscreen_woodkit_front_enqueue_scripts_tools');
endif;

if (!function_exists("woodkit_splashscreen")):
/**
 * Display background image/color/opacity
* @param boolean $auto_insert : boolean - do not specify true if you use this method manualy in your template theme
*/
function woodkit_splashscreen(){
	$splashscreen_style = "";
	$splashscreen_backgroundcolor = get_theme_mod('splashscreen_backgroundcolor');
	if (!empty($splashscreen_backgroundcolor)){
		$splashscreen_style .= "background-color: $splashscreen_backgroundcolor;";
	}else{
		$splashscreen_style .= "background-color: #fff;";
	}
	$splashscreen_image = get_theme_mod('splashscreen_image');
	if (!empty($splashscreen_image)){
		$splashscreen_style .= "background-image: url('$splashscreen_image');";
		$splashscreen_image_cover = get_theme_mod('splashscreen_image_cover');
		if ($splashscreen_image_cover == 'on'){
			$splashscreen_style .= "-webkit-background-size: cover;";
			$splashscreen_style .= "-moz-background-size: cover;";
			$splashscreen_style .= "-o-background-size: cover;";
			$splashscreen_style .= "-ms-background-size: cover;";
			$splashscreen_style .= "background-size: cover;";
		}
	}

	$splashscreen_text = get_theme_mod('splashscreen_text');
	if (!empty($splashscreen_text)){
		$splashscreen_text_style = "";
		$splashscreen_text_color = get_theme_mod('splashscreen_text_color');
		if (!empty($splashscreen_text_color))
			$splashscreen_text_style .= "color: $splashscreen_text_color;";
		$splashscreen_text = '<div id="splashscreen-text" style="'.$splashscreen_text_style.'">'.$splashscreen_text.'</div>';
	}
	echo '<div id="splashscreen" style="'.$splashscreen_style.'">'.$splashscreen_text.'</div>';
}
endif;


