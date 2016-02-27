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
require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.LOGIN_TOOL_NAME.'/inc/customizer.php');


if (!function_exists("tool_login_enqueue_styles_tools")):
/**
 * login template styles
*/
function tool_login_enqueue_styles_tools(){
	$css_login = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.LOGIN_TOOL_NAME.'/css/tool-login.css');
	if (!empty($css_login))
		wp_enqueue_style('tool-login-css', $css_login, array(), '1.0');
}
add_action("woodkit_login_enqueue_styles_tools", "tool_login_enqueue_styles_tools");
endif;

if (!function_exists("tool_login_enqueue_scripts_tools")):
/**
 * login template scripts
*/
function tool_login_enqueue_scripts_tools(){
	$js_login = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.LOGIN_TOOL_NAME.'/js/tool-login.js');
	if (!empty($js_login)){
		wp_enqueue_script('tool-login-script', $js_login, array('jquery'), '1.0', true );
		wp_localize_script('tool-login-script', 'ToolLogin', array('url_title' => get_bloginfo( 'name' ), 'url_site' => get_site_url(), 'message' => '', 'placeholder_login' => __("login", WOODKIT_PLUGIN_TEXT_DOMAIN), 'placeholder_password' => __("password", WOODKIT_PLUGIN_TEXT_DOMAIN), 'placeholder_email' => __("email", WOODKIT_PLUGIN_TEXT_DOMAIN)));
	}
}
add_action("woodkit_login_enqueue_scripts_tools", "tool_login_enqueue_scripts_tools");
endif;

if (!function_exists('woodkit_login_filter_register_link')):
function woodkit_login_filter_register_link($registration_url){
	$registration_url = sprintf('<a class="registration-url" href="%s">%s</a>', esc_url(wp_registration_url()), __('Register'));
	return $registration_url;
}
add_filter('register', 'woodkit_login_filter_register_link', 1, 1);
endif;

if (!function_exists("tool_login_display_background")):
/**
 * add background image div before #page element
*/
function tool_login_display_background(){
	$url_background = get_theme_mod("login_backgroundimage");
	
	if (empty($url_background) && woodkit_is_registered_tool("backgroundimage")){
		// $url_background = get_theme_mod('backgroundimage_image');
	}

	if (!empty($url_background)){
		?>
<div id="tool-login-background" style="background: url('<?php echo $url_background; ?>') no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			-ms-background-size: cover;
			background-size: cover;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: -100;"></div>
<?php
	}
}
add_action('login_footer', 'tool_login_display_background');
endif;

