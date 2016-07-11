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
class Woodkit_Divi_Module_Icon_Button extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__('Icon Button', WOODKIT_PLUGIN_TEXT_DOMAIN);
		$this->slug            = 'woodkit_et_pb_icon_button';
		$this->use_row_content = true;
		$this->decode_entities = true;

		$this->whitelisted_fields = array(
				'module_link',
				'module_link_url',
				'module_link_url_blank',
				'module_bgcolor',
				'module_bgcolor_focus',
				'module_color',
				'module_color_focus',
				'module_radius',
				'module_border',
				'module_border_size',
				'module_border_color',
				'module_border_color_focus',
				'module_icon_size',
				'module_icon',
				'module_class'
		);

		$this->fields_defaults = array(
				'module_link_url'			=> array('off'),
				'module_link_url_blank'			=> array('off'),
				'module_color'				=> array('#000000'),
				'module_color_focus'		=> array('#000000'),
				'module_radius'				=> array('3'),
				'module_icon_size'			=> array('50'),
				'module_border'				=> array('off'),
				'module_border_size'		=> array('2'),
				'module_border_color'		=> array('#000000'),
				'module_border_color_focus'	=> array('#000000'),
		);
	}

	function get_fields() {
		$fields = array(
				/* General */
				'module_icon' => array(
						'label'					=> esc_html__('Icon', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'text',
						'option_category'		=> 'configuration',
						'class'					=> array('woodkit-et-pb-icon'),
						'renderer'				=> 'woodkit_pb_get_font_iconpicker',
						'renderer_with_field'	=> true,
				),
				'module_link' => array(
						'label'					=> esc_html__('Link', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'yes_no_button',
						'option_category'		=> 'configuration',
						'options'         => array(
								'off' => esc_html__('No', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'on'  => esc_html__('Yes', WOODKIT_PLUGIN_TEXT_DOMAIN),
						),
						'default'         => 'off',
						'affects' => array(
								'#et_pb_module_link_url',
								'#et_pb_module_link_url_blank',
						),
				),
				'module_link_url' => array(
						'label'					=> esc_html__('URL', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'text',
						'option_category'		=> 'configuration',
						'depends_show_if' => 'on',
				),
				'module_link_url_blank' => array(
						'label'					=> esc_html__('Open in new tab', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'yes_no_button',
						'option_category'		=> 'configuration',
						'options'         => array(
								'off' => esc_html__('No', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'on'  => esc_html__('Yes', WOODKIT_PLUGIN_TEXT_DOMAIN),
						),
						'default'         => 'off',
						'depends_show_if' => 'on',
				),
				'module_icon_size' => array(
						'label'					=> esc_html__('Icon size', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'range',
						'option_category'		=> 'configuration',
						'default'         => '50',
						'range_settings'  => array(
								'min'  => '0',
								'max'  => '200',
								'step' => '1',
						),
				),
				'module_color' => array(
						'label'					=> esc_html__('Icon color', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category' 		=> 'color_option',
						'custom_color'      => true,
						'default'         => '#000000',
				),
				'module_color_focus' => array(
						'label'					=> esc_html__('Icon color on focus', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category'		=> 'color_option',
						'custom_color'      => true,
						'default'         => '#000000',
				),
				/* Advanced */
				'module_bgcolor' => array(
						'label'					=> esc_html__('Background color', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category'		=> 'color_option',
						'custom_color'      => true,
						'tab_slug'          => 'advanced'
				),
				'module_bgcolor_focus' => array(
						'label'					=> esc_html__('Background color on focus', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category'		=> 'color_option',
						'custom_color'      => true,
						'tab_slug'          => 'advanced'
				),
				'module_radius' => array(
						'label'					=> esc_html__('Background radius', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'range',
						'option_category'		=> 'configuration',
						'default'         => '3',
						'range_settings'  => array(
								'min'  => '0',
								'max'  => '100',
								'step' => '1',
						),
						'tab_slug'          => 'advanced'
				),
				'module_border' => array(
						'label'					=> esc_html__('Border', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'yes_no_button',
						'option_category'		=> 'configuration',
						'options'         => array(
								'off' => esc_html__('No', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'on'  => esc_html__('Yes', WOODKIT_PLUGIN_TEXT_DOMAIN),
						),
						'default'         => 'off',
						'affects' => array(
								'#et_pb_module_border_size',
								'#et_pb_module_border_color',
								'#et_pb_module_border_color_focus',
						),
						'tab_slug'          => 'advanced'
				),
				'module_border_size' => array(
						'label'					=> esc_html__('Border size', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'range',
						'option_category'		=> 'configuration',
						'default'         => '2',
						'range_settings'  => array(
								'min'  => '0',
								'max'  => '50',
								'step' => '1',
						),
						'default'         => '1',
						'depends_show_if' => 'on',
						'tab_slug'          => 'advanced'
				),
				'module_border_color' => array(
						'label'					=> esc_html__('Border color', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category'		=> 'configuration',
						'custom_color'      => true,
						'default'         => '#000000',
						'depends_show_if' => 'on',
						'tab_slug'          => 'advanced'
				),
				'module_border_color_focus' => array(
						'label'					=> esc_html__('Border color on focus', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category'		=> 'configuration',
						'custom_color'      => true,
						'default'         => '#000000',
						'depends_show_if' => 'on',
						'tab_slug'          => 'advanced'
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
		$module_link				= $this->shortcode_atts['module_link'];
		$module_link_url			= $this->shortcode_atts['module_link_url'];
		$module_link_url_blank		= $this->shortcode_atts['module_link_url_blank'];
		$module_bgcolor				= $this->shortcode_atts['module_bgcolor'];
		$module_bgcolor_focus		= $this->shortcode_atts['module_bgcolor_focus'];
		$module_color				= $this->shortcode_atts['module_color'];
		$module_color_focus			= $this->shortcode_atts['module_color_focus'];
		$module_radius				= $this->shortcode_atts['module_radius'];
		$module_border				= $this->shortcode_atts['module_border'];
		$module_border_size			= $this->shortcode_atts['module_border_size'];
		$module_border_color		= $this->shortcode_atts['module_border_color'];
		$module_border_color_focus	= $this->shortcode_atts['module_border_color_focus'];
		$module_icon_size			= $this->shortcode_atts['module_icon_size'];
		$module_icon				= $this->shortcode_atts['module_icon'];
		$module_class				= $this->shortcode_atts['module_class'];

		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);

		if ( '' !== $module_bgcolor ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%%.woodkit_et_pb_icon_button',
			'declaration' => sprintf(
			'background-color: %1$s;',
			esc_html( $module_bgcolor )
			),
			) );
		}

		if ('' !== $module_bgcolor_focus ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%%.woodkit_et_pb_icon_button:hover, %%order_class%%.woodkit_et_pb_icon_button:focus, %%order_class%%.woodkit_et_pb_icon_button:active',
			'declaration' => sprintf(
			'background-color: %1$s;',
			esc_html($module_bgcolor_focus)
			),
			) );
		}

		if ('on' === $module_border) {
			if ('' !== $module_border_size && '' !== $module_border_color) {
				ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.woodkit_et_pb_icon_button',
				'declaration' => sprintf(
				'border: %1$s solid %2$s;',
				esc_html( $module_border_size )."px", esc_html( $module_border_color )
				),
				) );
			}
			if ('' !== $module_border_size && '' !== $module_border_color_focus ) {
				ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.woodkit_et_pb_icon_button:hover, %%order_class%%.woodkit_et_pb_icon_button:focus, %%order_class%%.woodkit_et_pb_icon_button:active',
				'declaration' => sprintf(
				'border-color: %1$s;',
				esc_html($module_border_color_focus)
				),
				) );
			}
		}

		if ('' !== $module_color ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%%.woodkit_et_pb_icon_button i',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html( $module_color )
			),
			) );
		}

		if ('' !== $module_color_focus ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%%.woodkit_et_pb_icon_button:hover i, %%order_class%%.woodkit_et_pb_icon_button:focus i, %%order_class%%.woodkit_et_pb_icon_button:active i',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html($module_color_focus)
			),
			) );
		}

		if ('' !== $module_icon_size) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%%.woodkit_et_pb_icon_button i',
			'declaration' => sprintf(
			'font-size: %1$s;',
			esc_html( $module_icon_size )."px"
					),
			) );
		}

		if ('' !== $module_radius ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%%.woodkit_et_pb_icon_button',
			'declaration' => sprintf(
			'border-radius: %1$s; -webkit-border-radius: %1$s; -moz-border-radius: %1$s;',
			esc_html($module_radius)."%"
					),
			) );
		}

		$this->shortcode_content = et_builder_replace_code_content_entities($this->shortcode_content);

		$output = '<div class="woodkit_et_pb_icon_button_wrapper">';

		if ('on' === $module_link){
			$target = "";
			if ('on' === $module_link_url_blank)
				$target = 'target="_blank"';
			$output .= '<a href="'.$module_link_url.'" '.$target.' class="woodkit_et_pb_icon_button '.esc_attr($module_class).'">';
		}else{
			$output .= '<div class="woodkit_et_pb_icon_button '.esc_attr($module_class).'">';
		}
		$output .= '<i class="'.$module_icon.'">'.$this->shortcode_content.'</i>';
		if ('on' === $module_link){
			$output .= '</a>';
		}else{
			$output .= '</div>';
		}

		$output .= '</div>';

		return $output;
	}
}
new Woodkit_Divi_Module_Icon_Button;