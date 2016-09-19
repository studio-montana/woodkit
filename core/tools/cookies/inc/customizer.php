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
 * Add Cookies fields for the Customizer.
 *
 * @since Woodkit Cookies 1.0
 *
 * @param WP_Customize_Manager $wp_customize_manager Customizer object.
*/
function cookies_customize_register($wp_customize_manager) {

	// ------ cookies section
	$wp_customize_manager->add_section('cookies_customizer', array(
			'title' => __('Cookies', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	));

	// cookies more link text
	woodkit_customizer_add_add_control($wp_customize_manager, 'cookies_text', array('default' => '', 'transport'=>'theme_mod'), array(
	'label'      => __('Text', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	'settings'   => 'cookies_text',
	'section'    => 'cookies_customizer',
	));

	// cookies text
	woodkit_customizer_add_add_control($wp_customize_manager, 'cookies_link_text', array('default' => '', 'transport'=>'theme_mod'), array(
	'label'      => __('More link Text', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	'section'    => 'cookies_customizer',
	'settings'   => 'cookies_link_text',
	));

	// cookies more link url
	woodkit_customizer_add_add_control($wp_customize_manager, 'cookies_link_url', array('default' => '', 'transport'=>'theme_mod'), array(
	'label'      => __('More link URL', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	'section'    => 'cookies_customizer',
	'settings'   => 'cookies_link_url',
	));

	// cookies button text
	woodkit_customizer_add_add_control($wp_customize_manager, 'cookies_button_text', array('default' => '', 'transport'=>'theme_mod'), array(
	'label'      => __('Button text', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	'section'    => 'cookies_customizer',
	'settings'   => 'cookies_button_text',
	));
}
add_action('customize_register', 'cookies_customize_register');
