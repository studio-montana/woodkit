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

function tool_display_get_config_options_section_description(){
	echo '<p class="tool-description">'.tool_display_get_description().'</p>';
}

function tool_display_get_config_options_section_documentation_url(){
	return WOODKIT_URL_DOCUMENTATION.'/options-generales-daffichage';
}

function tool_display_is_active($active){
	$active_option = woodkit_get_option('tool-display-active');
	if (!empty($active_option) && $active_option == "on")
		$active = true;
	return $active;
}
add_filter("woodkit_is_tool_display_active", "tool_display_is_active", 1, 1);

function tool_display_woodkit_config_default_values($default_values){
	$default_values["tool-display-active"] = "off";
	return $default_values;
}
add_filter("woodkit_config_default_values", "tool_display_woodkit_config_default_values");

function tool_display_get_config_options_fields($additional_fields){
	$additional_fields[] = array("slug" => "tool-display-active", "callback" => "tool_display_get_config_options_field_active", "title" => __("active", WOODKIT_PLUGIN_TEXT_DOMAIN));
	return $additional_fields;
}
add_filter("woodkit_config_options_fields_tool_display", "tool_display_get_config_options_fields", 1, 1);

function tool_display_get_config_options_field_active($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-display-active']))
		$value = $options['tool-display-active'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-display-active]" '.$checked.' />';
	echo '<p class="field-description">'.__('use these codes in your theme templates :', WOODKIT_PLUGIN_TEXT_DOMAIN).'<br /><code style="font-size: 0.7rem;">&lt;?php woodkit_display_title(); ?&gt;</code><br /><code style="font-size: 0.7rem;">&lt;?php woodkit_display_subtitle(); ?&gt;</code><br /><code style="font-size: 0.7rem;">&lt;?php woodkit_display_thumbnail() ?&gt;</code><br /><code style="font-size: 0.7rem;">&lt;?php woodkit_display_badge(); ?&gt;</code></p>';
}