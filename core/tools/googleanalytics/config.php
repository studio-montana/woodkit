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

function tool_googleanalytics_is_active($active){
	return true;
}
add_filter("woodkit_is_tool_googleanalytics_active", "tool_googleanalytics_is_active", 1, 1);

function tool_googleanalytics_get_config_options_section_description(){
}

function tool_googleanalytics_get_config_options_section_documentation_url(){
	return WOODKIT_URL_DOCUMENTATION.'/google-analytics';
}

function tool_googleanalytics_get_config_options_fields($additional_fields){
	$additional_fields[] = array("slug" => "tool-googleanalytics-code", "callback" => "tool_googleanalytics_get_config_options_field_code", "title" => __("code", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-googleanalytics-googletagmanager-code", "callback" => "tool_googleanalytics_get_config_options_field_googletagmanager_code", "title" => __("Google Tag Manager code", WOODKIT_PLUGIN_TEXT_DOMAIN));
	return $additional_fields;
}
add_filter("woodkit_config_options_fields_tool_googleanalytics", "tool_googleanalytics_get_config_options_fields", 1, 1);

function tool_googleanalytics_get_config_options_field_code($args){
	$options = $args['options'];
	$value = "";
	if (isset($options['tool-googleanalytics-code']))
		$value = $options['tool-googleanalytics-code'];
	echo '<input type="text" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-googleanalytics-code]" value="'.$value.'" placeholder="XX-XXXXXXX-XX" />';
}

function tool_googleanalytics_get_config_options_field_googletagmanager_code($args){
	$options = $args['options'];
	$value = "";
	if (isset($options['tool-googleanalytics-googletagmanager-code']))
		$value = $options['tool-googleanalytics-googletagmanager-code'];
	echo '<input type="text" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-googleanalytics-googletagmanager-code]" value="'.$value.'" placeholder="GTM-XXXX" />';
}