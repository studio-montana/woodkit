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
 * Enqueue styles for the front end.
 */
function tool_cookies_woodkit_front_enqueue_styles_tools($dependencies) {

	$css_cookies = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.COOKIES_TOOL_NAME.'/css/tool-cookies.css');
	if (!empty($css_cookies))
		wp_enqueue_style('tool-cookies-css', $css_cookies, $dependencies, '1.0');
}
add_action('woodkit_front_enqueue_styles_tools', 'tool_cookies_woodkit_front_enqueue_styles_tools');

/**
 * WP_Footer hook
 *
 * @since Woodkit 1.0
 * @return void
 */
function cookies_wp_footer() {
	$cookies_template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.COOKIES_TOOL_NAME.'/templates/tool-cookies-template-legislation.php');
	if (!empty($cookies_template))
		include($cookies_template);
}
add_action('wp_footer', 'cookies_wp_footer');