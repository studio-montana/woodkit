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
 *  Icon Button Module
*/
class Woodkit_Divi_Module_Fullwidth_Wall extends ET_Builder_Module {
	function init() {
		$this->name				= esc_html__('Woodkit Wall Fullwidth', WOODKIT_PLUGIN_TEXT_DOMAIN);
		$this->slug				= 'woodkit_et_pb_fullwidth_wall';
		$this->fullwidth  		= true;
		$this->custom_css_tab	= false;

		$this->whitelisted_fields = array(
				'admin_label'
		);

		$this->fields_defaults = array();
	}

	function get_fields() {

		$fields = array(
				/* General */
				'admin_label' => array(
						'label'       => esc_html__('Admin Label', 'et_builder'),
						'type'        => 'text',
						'description' => esc_html__('Woodkit Wall - please setup your wall under Divi Builder Generator, in Woodkit Wall section', WOODKIT_PLUGIN_TEXT_DOMAIN),
				),

		);

		return $fields;
	}

	function shortcode_callback($atts, $content = null, $function_name) {
		
		$module_class = "";
		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);

		$output = '<div class="woodkit_et_pb_fullwidth_wall_wrapper">';
		$output .= '<div class="woodkit_et_pb_fullwidth_wall '.esc_attr($module_class).'">';
		$output .= woodkit_wall_get_wall();
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}
new Woodkit_Divi_Module_Fullwidth_Wall;