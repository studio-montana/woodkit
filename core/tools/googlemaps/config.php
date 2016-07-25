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

function tool_googlemaps_is_active($active){
	$active_option = woodkit_get_option('tool-googlemaps-active');
	if (!empty($active_option) && $active_option == "on")
		$active = true;
	return $active;
}
add_filter("woodkit_is_tool_googlemaps_active", "tool_googlemaps_is_active", 1, 1);

function tool_googlemaps_woodkit_config_default_values($default_values){
	$default_values["tool-googlemaps-active"] = "on";
	return $default_values;
}
add_filter("woodkit_config_default_values", "tool_googlemaps_woodkit_config_default_values");

function tool_googlemaps_get_config_options_section_description(){
	echo '<p class="tool-description">'.tool_googlemaps_get_description().'</p>';
}

function tool_googlemaps_get_config_options_section_documentation_url(){
	return WOODKIT_URL_DOCUMENTATION.'/googlemaps';
}

function tool_googlemaps_get_config_options_fields($additional_fields){
	$additional_fields[] = array("slug" => "tool-googlemaps-active", "callback" => "tool_googlemaps_get_config_options_field_active", "title" => __("active", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-googlemaps-apikey", "callback" => "tool_googlemaps_get_config_options_field_apikey", "title" => __("API KEY", WOODKIT_PLUGIN_TEXT_DOMAIN));
	return $additional_fields;
}
add_filter("woodkit_config_options_fields_tool_googlemaps", "tool_googlemaps_get_config_options_fields", 1, 1);

function tool_googlemaps_get_config_options_field_active($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-googlemaps-active']))
		$value = $options['tool-googlemaps-active'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-googlemaps-active]" '.$checked.' />';
}

function tool_googlemaps_get_config_options_field_apikey($args){
	$options = $args['options'];
	$value = "";
	if (isset($options['tool-googlemaps-apikey']))
		$value = $options['tool-googlemaps-apikey'];
	echo '<input type="text" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-googlemaps-apikey]" value="'.$value.'" /><a class="button primary get-a-key google-maps-key" style="margin-left: 12px;" href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">'.__("Get google maps API KEY", WOODKIT_PLUGIN_TEXT_DOMAIN).'</a>';
	echo '<p class="field-description">'.__('shortcode in your theme templates :', WOODKIT_PLUGIN_TEXT_DOMAIN).'<br /><code style="font-size: 0.7rem;">&lt;?php echo do_shortcode(\'[googlemaps id="gmaps1465" adress="" title="" type="ROADMAP" width="100%" height="400px" style="" /]\'); ?&gt;</code></p>';
}