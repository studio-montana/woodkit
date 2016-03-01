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
 * Add FAVICON fields for the Customizer.
 *
 * @since Woodkit FAVICON 1.0
 *
 * @param WP_Customize_Manager $wp_customize_manager Customizer object.
 */
function favicon_customize_register($wp_customize_manager) {
	// ------ background section
	$wp_customize_manager->add_section('favicon_customizer', array(
			'title' => __( 'Favicon', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	) );

	// favicon
	$wp_customize_manager->add_setting('favicon_image', array('transport'=>'refresh'));
	$wp_customize_manager->add_control(
			new WP_Customize_Image_Control(
					$wp_customize_manager,
					'woodkit_favicon',
					array(
							'section'    => 'favicon_customizer',
							'settings'   => 'favicon_image'
					)
			)
	);
}
add_action('customize_register', 'favicon_customize_register');

if (!function_exists("woodkit_favicon_has")):
/**
 * @return true if has defined favicon, false otherwise
 */
function woodkit_favicon_has(){
	$url_favicon = get_theme_mod('favicon_image');
	return !empty($url_favicon);
}
endif;

if (!function_exists("woodkit_favicon_get_url")):
/**
 * display img html tag to show favicon
 * @param array $attrs : attributes to put in img tag (key : attribute name - value : attribute value)
 */
function woodkit_favicon_get_url($attrs = array()){
	$url_favicon = get_theme_mod('favicon_image');
	$res = '';
	if (!empty($url_favicon)){
		$res = $url_favicon;
	}
	return $res;
}
endif;

