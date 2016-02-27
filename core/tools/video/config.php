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

function tool_video_is_active($active){
	$active_option = woodkit_get_option('tool-video-active');
	if (!empty($active_option) && $active_option == "on")
		$active = true;
	return $active;
}
add_filter("woodkit_is_tool_video_active", "tool_video_is_active", 1, 1);

function tool_video_woodkit_config_default_values($default_values){
	$default_values["tool-video-active"] = "on";
	$default_values["tool-video-auto-insert"] = "on";
	$default_values["tool-video-default-width"] = "100%";
	$default_values["tool-video-default-height"] = "320px";
	return $default_values;
}
add_filter("woodkit_config_default_values", "tool_video_woodkit_config_default_values");

function tool_video_get_config_options_section_description(){
	echo '<p class="tool-description">'.tool_video_get_description().'</p>';
}

function tool_video_get_config_options_section_documentation_url(){
	return WOODKIT_DOCUMENTATION_URL.'#video';
}

function tool_video_get_config_options_fields($additional_fields){
	$additional_fields[] = array("slug" => "tool-video-active", "callback" => "tool_video_get_config_options_field_active", "title" => __("active", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-video-auto-insert", "callback" => "tool_video_get_config_options_field_auto_insert", "title" => __("auto insert", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-video-default-width", "callback" => "tool_video_get_config_options_field_default_width", "title" => __("default width", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-video-default-height", "callback" => "tool_video_get_config_options_field_default_height", "title" => __("default height", WOODKIT_PLUGIN_TEXT_DOMAIN));
	return $additional_fields;
}
add_filter("woodkit_config_options_fields_tool_video", "tool_video_get_config_options_fields", 1, 1);

function tool_video_get_config_options_field_active($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-video-active']))
		$value = $options['tool-video-active'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-video-active]" '.$checked.' />';
}

function tool_video_get_config_options_field_auto_insert($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-video-auto-insert']))
		$value = $options['tool-video-auto-insert'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-video-auto-insert]" '.$checked.' />';
	echo '<p class="field-description">'.__('replace featured image if exists, otherwise, you can insert this code directly in your theme templates :', WOODKIT_PLUGIN_TEXT_DOMAIN).'<br /><code style="font-size: 0.7rem;">&lt;?php video_get_featured_video(); ?&gt;</code></p>';
}

function tool_video_get_config_options_field_default_width($args){
	$options = $args['options'];
	$active = false;
	$value = "";
	if (isset($options['tool-video-default-width']))
		$value = $options['tool-video-default-width'];
	echo '<input type="text" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-video-default-width]" value="'.$value.'" placeholder="auto, 100%, 320px, ..." />';
}

function tool_video_get_config_options_field_default_height($args){
	$options = $args['options'];
	$active = false;
	$value = "";
	if (isset($options['tool-video-default-height']))
		$value = $options['tool-video-default-height'];
	echo '<input type="text" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-video-default-height]" value="'.$value.'" placeholder="auto, 100%, 320px, ..." />';
}