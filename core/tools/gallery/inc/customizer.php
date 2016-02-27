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
 * Add GALLERY fields for the Customizer.
 *
 * @since Woodkit GALLERY 1.0
 *
 * @param WP_Customize_Manager $wp_customize_manager Customizer object.
 */
function gallery_customize_register($wp_customize_manager) {

	// ------ background section
	$wp_customize_manager->add_section('gallery_customizer', array(
			'title' => __( 'FancyBox', WOODKIT_PLUGIN_TEXT_DOMAIN),
	) );

	// background image
	$wp_customize_manager->add_setting('gallery_fancybox_state', array('type' => 'theme_mod', 'transport'=>'refresh'));
	$wp_customize_manager->add_control('gallery_fancybox_state',	array(
			'type' => 'checkbox',
			'label' => __('Disable', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'description' => __('disable fancybox on this site', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'section' => 'gallery_customizer',
			'settings'   => 'gallery_fancybox_state',
	)
	);

}
add_action('customize_register', 'gallery_customize_register');