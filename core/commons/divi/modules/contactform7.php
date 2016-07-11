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
class Woodkit_Divi_Module_ContactForm7 extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__('Contact Form 7', WOODKIT_PLUGIN_TEXT_DOMAIN);
		$this->slug            = 'woodkit_et_pb_contactform7';
		$this->use_row_content = true;
		$this->decode_entities = true;

		$this->whitelisted_fields = array(
				'module_form_id',
				'module_class'
		);

		$this->fields_defaults = array(
				'module_form_id'	=> '0',
		);
	}

	function get_fields() {

		/* form options */
		$forms_options = array("0" => __("no selection", WOODKIT_PLUGIN_TEXT_DOMAIN));
		$forms = get_posts(array("post_type" => "wpcf7_contact_form", 'numberposts' => -1, 'suppress_filters' => false));
		if (!empty($forms)){
			foreach ($forms as $form){
				$forms_options[$form->ID] = esc_html($form->post_title);
			}
		}

		$fields = array(
				/* General */
				'module_form_id' => array(
						'label'					=> esc_html__('Form', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'select',
						'option_category'		=> 'configuration',
						'options'				=> $forms_options,
						'default'				=> '0',
				),
				// Custom CSS
				'module_class' => array(
						'label'           => esc_html__('CSS Class', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'            => 'text',
						'option_category' => 'configuration',
						'tab_slug'        => 'custom_css',
						'option_class'    => 'et_pb_custom_css_regular',
				),

		);

		return $fields;
	}

	function shortcode_callback($atts, $content = null, $function_name) {
		$module_form_id				= $this->shortcode_atts['module_form_id'];
		$module_class				= $this->shortcode_atts['module_class'];

		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);

		$output = '<div class="woodkit_et_pb_contactform7_wrapper">';
		$output .= '<div class="woodkit_et_pb_contactform7 '.esc_attr($module_class).'">';
		if (!empty($module_form_id) && is_numeric($module_form_id) && "0" != $module_form_id){
			$output .= do_shortcode('[contact-form-7 id="'.$module_form_id.'"]');
		}
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}
new Woodkit_Divi_Module_ContactForm7;