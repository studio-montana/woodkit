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
 * Add WIP fields for the Customizer.
 *
 * @since Woodkit WIP 1.0
 *
 * @param WP_Customize_Manager $wp_customize_manager Customizer object.
 */
function wip_customize_register($wp_customize_manager) {

	// ------ wip section
	$wp_customize_manager->add_section('wip_customizer', array(
			'title' => __( 'Work In Progress', 'woodkit' ),
	) );

	// wip message
	$wp_customize_manager->add_setting('wip_message', array('type' => 'theme_mod'));
	$wp_customize_manager->add_control('wip_message', array(
			'type'     		=> 'text',
			'label'      	=> __('Message', 'woodkit' ),
			'section'    	=> 'wip_customizer',
			'settings'   	=> 'wip_message',
			'description'	=> 'Display this message for unlogged visitors <br> (only if there is no specific page)',
	));

	// wip message
	$wp_customize_manager->add_setting('wip_page', array('type' => 'theme_mod', 'sanitize_callback' => 'absint'));
	$wp_customize_manager->add_control('wip_page', array(
			'type'     		=> 'dropdown-pages',
			'label'      	=> __('Specific page', 'woodkit' ),
			'section'    	=> 'wip_customizer',
			'settings'   	=> 'wip_page',
			'description'	=> 'Display this page for unlogged visitors',
	));

}
add_action('customize_register', 'wip_customize_register');
