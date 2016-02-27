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
 * Add LOGO fields for the Customizer.
 *
 * @since Woodkit LOGO 1.0
 *
 * @param WP_Customize_Manager $wp_customize_manager Customizer object.
 */
function logo_customize_register($wp_customize_manager) {
	// ------ background section
	$wp_customize_manager->add_section('logo_customizer', array(
			'title' => __( 'Logo', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	) );

	// logo
	$wp_customize_manager->add_setting('logo_image', array('transport'=>'refresh'));
	$wp_customize_manager->add_control(
			new WP_Customize_Image_Control(
					$wp_customize_manager,
					'woodkit_logo',
					array(
							'section'    => 'logo_customizer',
							'settings'   => 'logo_image'
					)
			)
	);
}
add_action('customize_register', 'logo_customize_register');

if (!function_exists("logo_has")):
/**
 * @return true if has defined logo, false otherwise
 */
function logo_has(){
	$url_logo = get_theme_mod('logo_image');
	return !empty($url_logo);
}
endif;

if (!function_exists("logo_display")):
/**
 * display img html tag to show logo
 * @param array $attrs : attributes to put in img tag (key : attribute name - value : attribute value)
 */
function logo_display($attrs = array()){
	$url_logo = get_theme_mod('logo_image');
	$img = '';
	if (!empty($url_logo)){
		$img .= '<img src="'.$url_logo.'"';
		foreach ($attrs as $k => $v){
			$img .= ' '.$k.'="'.$v.'"';
		}
		$img .= ' />';
	}
	echo $img;
}
endif;

