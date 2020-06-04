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
 * Add Legal fields for the Customizer.
 *
 * @since Woodkit Legal 1.0
 *
 * @param WP_Customize_Manager $wp_customize_manager Customizer object.
*/
function legal_customize_register($wp_customize_manager) {

	// ------ legal section
	$wp_customize_manager->add_section('legal_customizer', array(
			'title' => __('Legal', 'woodkit' ),
	));

	// legal more link text
	woodkit_customizer_add_control($wp_customize_manager, 'legal_text', array('default' => '', 'transport'=>'theme_mod'), array(
			'label'      => __('Text', 'woodkit' ),
			'settings'   => 'legal_text',
			'section'    => 'legal_customizer',
	));

	// legal text
	woodkit_customizer_add_control($wp_customize_manager, 'legal_link_text', array('default' => '', 'transport'=>'theme_mod'), array(
			'label'      => __('\'Read more\' link text', 'woodkit' ),
			'section'    => 'legal_customizer',
			'settings'   => 'legal_link_text',
	));

	// legal more link url
	woodkit_customizer_add_control($wp_customize_manager, 'legal_link_url', array('default' => '', 'transport'=>'theme_mod'), array(
			'label'      => __('\'Read more\' link URL', 'woodkit' ),
			'section'    => 'legal_customizer',
			'settings'   => 'legal_link_url',
			'description' => __('Display GDPR link by default.', 'woodkit'),
	));

	// legal button text
	woodkit_customizer_add_control($wp_customize_manager, 'legal_button_text', array('default' => '', 'transport'=>'theme_mod'), array(
			'label'      => __('Button text', 'woodkit' ),
			'section'    => 'legal_customizer',
			'settings'   => 'legal_button_text',
	));
}
add_action('customize_register', 'legal_customize_register');
