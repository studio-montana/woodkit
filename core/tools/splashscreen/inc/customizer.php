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
 * Add SPLASHSCREEN fields for the Customizer.
 *
 * @since Woodkit SPLASHSCREEN 1.0
 *
 * @param WP_Customize_Manager $wp_customize_manager Customizer object.
 */
function splashscreen_customize_register($wp_customize_manager) {
	// ------ background section
	$wp_customize_manager->add_section('splashscreen_customizer', array(
			'title' => __('Splash Screen', WOODKIT_PLUGIN_TEXT_DOMAIN ),
	) );
	
	// splashscreen color
	$wp_customize_manager->add_setting('splashscreen_backgroundcolor', array('default' => '#ffffff', 'transport'=>'refresh'));
	$wp_customize_manager->add_control(
			new WP_Customize_Color_Control(
					$wp_customize_manager,
					'woodkit_splashscreen_backgroundcolor',
					array(
							'label'      => __('Background color', WOODKIT_PLUGIN_TEXT_DOMAIN),
							'section'    => 'splashscreen_customizer',
							'settings'   => 'splashscreen_backgroundcolor',
					) )
	);

	// splashscreen image
	$wp_customize_manager->add_setting('splashscreen_image', array('transport'=>'refresh'));
	$wp_customize_manager->add_control(
			new WP_Customize_Image_Control(
					$wp_customize_manager,
					'woodkit_splashscreen_image',
					array(
							'label'      => __('Image', WOODKIT_PLUGIN_TEXT_DOMAIN),
							'section'    => 'splashscreen_customizer',
							'settings'   => 'splashscreen_image'
					)
			)
	);

	// splashscreen image cover
	$wp_customize_manager->add_setting('splashscreen_image_cover', array('type' => 'theme_mod'));
	$wp_customize_manager->add_control('splashscreen_image_cover',	array(
			'type' => 'checkbox',
			'label' => __('Image cover', WOODKIT_PLUGIN_TEXT_DOMAIN ),
			'description' => __('cover background with splashcreen image', WOODKIT_PLUGIN_TEXT_DOMAIN ),
			'section' => 'splashscreen_customizer',
			'settings'   => 'splashscreen_image_cover',
	)
	);

	// splashscreen text
	$wp_customize_manager->add_setting('splashscreen_text', array('default' => bloginfo('name'), 'transport'=>'refresh'));
	$wp_customize_manager->add_control('splashscreen_text', array(
			'label'      => __('Text', WOODKIT_PLUGIN_TEXT_DOMAIN ),
			'section'    => 'splashscreen_customizer',
			'settings'   => 'splashscreen_text',
	));
	
	// splashscreen color
	$wp_customize_manager->add_setting('splashscreen_text_color', array('default' => '#000000', 'transport'=>'refresh'));
	$wp_customize_manager->add_control(
			new WP_Customize_Color_Control(
					$wp_customize_manager,
					'woodkit_splashscreen_text_color',
					array(
							'label'      => __('Text color', WOODKIT_PLUGIN_TEXT_DOMAIN),
							'section'    => 'splashscreen_customizer',
							'settings'   => 'splashscreen_text_color',
					) )
	);
}
add_action('customize_register', 'splashscreen_customize_register');
