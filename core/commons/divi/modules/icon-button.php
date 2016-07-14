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
				'module_content',
				'module_title_orientation',
				'module_text_orientation',
				'module_title',
				'module_text',
				'module_title_color',
				'module_title_color_focus',
				'module_text_color',
				'module_text_color_focus',
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
				'module_class',
				'admin_label',
		);

		$this->fields_defaults = array(
				'module_link_url'				=> array('off'),
				'module_link_url_blank'			=> array('off'),
				'module_color'					=> array('#000000'),
				'module_color_focus'			=> array('#000000'),
				'module_content'				=> array('off'),
				'module_title_orientation'		=> array('center'),
				'module_text_orientation'		=> array('center'),
				'module_title_color'			=> array('#000000'),
				'module_title_color_focus'		=> array('#000000'),
				'module_text_color'				=> array('#000000'),
				'module_text_color_focus'		=> array('#000000'),
				'module_radius'					=> array('3'),
				'module_icon_size'				=> array('50'),
				'module_border'					=> array('off'),
				'module_border_size'			=> array('2'),
				'module_border_color'			=> array('#000000'),
				'module_border_color_focus'		=> array('#000000'),
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
				'module_content' => array(
						'label'					=> esc_html__('Content', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'yes_no_button',
						'option_category'		=> 'configuration',
						'options'         => array(
								'off' => esc_html__('No', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'on'  => esc_html__('Yes', WOODKIT_PLUGIN_TEXT_DOMAIN),
						),
						'default'         => 'off',
						'affects' => array(
								'#et_pb_module_title',
								'#et_pb_module_title_color',
								'#et_pb_module_title_color_focus',
								'#et_pb_module_title_orientation',
								'#et_pb_module_text',
								'#et_pb_module_text_color',
								'#et_pb_module_text_color_focus',
								'#et_pb_module_text_orientation',
						),
				),
				'module_title' => array(
						'label'           => esc_html__('Title', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'            => 'text',
						'option_category' => 'configuration',
						'depends_show_if' => 'on',
				),
				'module_title_orientation' => array(
						'label'             => esc_html__('Title Orientation', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'              => 'select',
						'option_category'   => 'configuration',
						'options'           => array(
								'left'   => esc_html__('Left', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'center' => esc_html__('Center', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'right'  => esc_html__('Right', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'justify'  => esc_html__('Justify', WOODKIT_PLUGIN_TEXT_DOMAIN),
						),
						'depends_show_if' => 'on',
				),
				'module_title_color' => array(
						'label'					=> esc_html__('Title color', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category' 		=> 'color_option',
						'custom_color'      => true,
						'default'         => '#000000',
						'depends_show_if' => 'on',
				),
				'module_title_color_focus' => array(
						'label'					=> esc_html__('Title color on focus', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category' 		=> 'color_option',
						'custom_color'      => true,
						'default'         => '#000000',
						'depends_show_if' => 'on',
				),
				'module_text' => array(
						'label'           => esc_html__('Text', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'            => 'textarea',
						'option_category' => 'configuration',
						'depends_show_if' => 'on',
				),
				'module_text_orientation' => array(
						'label'             => esc_html__('Text Orientation', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'              => 'select',
						'option_category'   => 'configuration',
						'options'           => array(
								'left'   => esc_html__('Left', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'center' => esc_html__('Center', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'right'  => esc_html__('Right', WOODKIT_PLUGIN_TEXT_DOMAIN),
								'justify'  => esc_html__('Justify', WOODKIT_PLUGIN_TEXT_DOMAIN),
						),
						'depends_show_if' => 'on',
				),
				'module_text_color' => array(
						'label'					=> esc_html__('Text color', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category' 		=> 'color_option',
						'custom_color'      => true,
						'default'         => '#000000',
						'depends_show_if' => 'on',
				),
				'module_text_color_focus' => array(
						'label'					=> esc_html__('Text color on focus', WOODKIT_PLUGIN_TEXT_DOMAIN),
						'type'					=> 'color-alpha',
						'option_category' 		=> 'color_option',
						'custom_color'      => true,
						'default'         => '#000000',
						'depends_show_if' => 'on',
				),
				'admin_label' => array(
						'label'       => esc_html__( 'Admin Label', 'et_builder' ),
						'type'        => 'text',
						'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
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
		$module_content				= $this->shortcode_atts['module_content'];
		$module_title_orientation	= $this->shortcode_atts['module_title_orientation'];
		$module_text_orientation	= $this->shortcode_atts['module_text_orientation'];
		$module_title				= $this->shortcode_atts['module_title'];
		$module_text				= $this->shortcode_atts['module_text'];
		$module_title_color			= $this->shortcode_atts['module_title_color'];
		$module_title_color_focus	= $this->shortcode_atts['module_title_color_focus'];
		$module_text_color			= $this->shortcode_atts['module_text_color'];
		$module_text_color_focus	= $this->shortcode_atts['module_text_color_focus'];
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

		// icon background
		if ( '' !== $module_bgcolor ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button',
			'declaration' => sprintf(
			'background-color: %1$s;',
			esc_html( $module_bgcolor )
			),
			) );
		}

		// icon background focus
		if ('' !== $module_bgcolor_focus ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container:hover .woodkit_et_pb_icon_button, %%order_class%% .woodkit_et_pb_icon_button_container:focus .woodkit_et_pb_icon_button, %%order_class%% .woodkit_et_pb_icon_button_container:active .woodkit_et_pb_icon_button',
			'declaration' => sprintf(
			'background-color: %1$s;',
			esc_html($module_bgcolor_focus)
			),
			) );
		}

		// icon border
		if ('on' === $module_border) {
			if ('' !== $module_border_size && '' !== $module_border_color) {
				ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button',
				'declaration' => sprintf(
				'border: %1$s solid %2$s;',
				esc_html( $module_border_size )."px", esc_html( $module_border_color )
				),
				) );
			}
			if ('' !== $module_border_size && '' !== $module_border_color_focus ) {
				ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container:hover .woodkit_et_pb_icon_button, %%order_class%% .woodkit_et_pb_icon_button_container:focus .woodkit_et_pb_icon_button, %%order_class%% .woodkit_et_pb_icon_button_container:active .woodkit_et_pb_icon_button',
				'declaration' => sprintf(
				'border-color: %1$s;',
				esc_html($module_border_color_focus)
				),
				) );
			}
		}

		// icon color
		if ('' !== $module_color ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button i',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html( $module_color )
			),
			) );
		}

		// icon color focus
		if ('' !== $module_color_focus ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container:hover .woodkit_et_pb_icon_button i, %%order_class%% .woodkit_et_pb_icon_button_container:focus .woodkit_et_pb_icon_button i, %%order_class%% .woodkit_et_pb_icon_button_container:active .woodkit_et_pb_icon_button i',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html($module_color_focus)
			),
			) );
		}

		// icon size
		if ('' !== $module_icon_size) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button i',
			'declaration' => sprintf(
			'font-size: %1$s;',
			esc_html( $module_icon_size )."px"
					),
			) );
		}

		// icon radius
		if ('' !== $module_radius ) {
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button',
			'declaration' => sprintf(
			'border-radius: %1$s; -webkit-border-radius: %1$s; -moz-border-radius: %1$s;',
			esc_html($module_radius)."%"
					),
			) );
		}

		// title color
		if ('on' === $module_content && '' !== $module_title && '' !== $module_title_color){
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button_content .title',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html( $module_title_color )
			),
			) );
		}

		// title color focus
		if ('on' === $module_content && '' !== $module_title && '' !== $module_title_color_focus){
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container:hover .woodkit_et_pb_icon_button_content .title, %%order_class%% .woodkit_et_pb_icon_button_container:focus .woodkit_et_pb_icon_button_content .title, %%order_class%% .woodkit_et_pb_icon_button_container:active .woodkit_et_pb_icon_button_content .title',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html( $module_title_color_focus )
			),
			) );
		}
		
		// title orientation
		if ('' !== $module_title_orientation){
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button_content .title',
			'declaration' => sprintf(
			'text-align: %1$s;',
			esc_html( $module_title_orientation )
			),
			) );
		}

		// text color
		if ('on' === $module_content && '' !== $module_text && '' !== $module_text_color){
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button_content .text',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html( $module_text_color )
			),
			) );
		}

		// text color focus
		if ('on' === $module_content && '' !== $module_text && '' !== $module_text_color_focus){
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container:hover .woodkit_et_pb_icon_button_content .text, %%order_class%% .woodkit_et_pb_icon_button_container:focus .woodkit_et_pb_icon_button_content .text, %%order_class%% .woodkit_et_pb_icon_button_container:active .woodkit_et_pb_icon_button_content .text',
			'declaration' => sprintf(
			'color: %1$s;',
			esc_html( $module_text_color_focus )
			),
			) );
		}
		
		// text orientation
		if ('' !== $module_text_orientation){
			ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .woodkit_et_pb_icon_button_container .woodkit_et_pb_icon_button_content .text',
			'declaration' => sprintf(
			'text-align: %1$s;',
			esc_html( $module_text_orientation )
			),
			) );
		}

		$this->shortcode_content = et_builder_replace_code_content_entities($this->shortcode_content);

		$output = '<div class="woodkit_et_pb_icon_button_wrapper '.esc_attr($module_class).'">';

		if ('on' === $module_link){
			$target = "";
			if ('on' === $module_link_url_blank)
				$target = 'target="_blank"';
			$output .= '<a href="'.$module_link_url.'" '.$target.' class="woodkit_et_pb_icon_button_container">';
		}else{
			$output .= '<div class="woodkit_et_pb_icon_button_container">';
		}

		$output .= '<div class="woodkit_et_pb_icon_button"><i class="'.$module_icon.'">'.$this->shortcode_content.'</i></div>';

		if ('on' === $module_content && ('' !== $module_text || '' !== $module_title)) {
			$output .= '<div class="woodkit_et_pb_icon_button_content">';
			if ('' !== $module_title) {
				$output .= '<h2 class="title">'.$module_title.'</h2>';
			}
			if ('' !== $module_text) {
				$output .= '<div class="text">'.$module_text.'</div>';
			}
			$output .= '</div>';
		}

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