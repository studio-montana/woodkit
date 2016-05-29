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

function tool_secure_is_active($active){
	return true;
}
add_filter("woodkit_is_tool_secure_active", "tool_secure_is_active", 1, 1);

function tool_secure_woodkit_config_default_values($default_values){
	$default_values["tool-secure-captcha-active"] = "on";
	$default_values["tool-secure-failtoban-active"] = "on";
	return $default_values;
}
add_filter("woodkit_config_default_values", "tool_secure_woodkit_config_default_values");

function tool_secure_get_config_options_section_description(){
	echo '<p class="tool-description">'.tool_secure_get_description().'</p>';
}

function tool_secure_get_config_options_section_documentation_url(){
	return WOODKIT_URL_DOCUMENTATION.'/securite';
}

function tool_secure_get_config_options_fields($additional_fields){
	$additional_fields[] = array("slug" => "tool-secure-captcha-active", "callback" => "tool_secure_get_config_options_field_captcha_active", "title" => __("Captcha active", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-failtoban-active", "callback" => "tool_secure_get_config_options_field_failtoban_active", "title" => __("FailToBan active", WOODKIT_PLUGIN_TEXT_DOMAIN));
	return $additional_fields;
}
add_filter("woodkit_config_options_fields_tool_secure", "tool_secure_get_config_options_fields", 1, 1);

function tool_secure_get_config_options_field_captcha_active($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-secure-captcha-active']))
		$value = $options['tool-secure-captcha-active'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-secure-captcha-active]" '.$checked.' />';
	echo '<p class="field-description">'.__('add captcha on login, register and comment forms (Woocommerce supported)', WOODKIT_PLUGIN_TEXT_DOMAIN).'</p>';
}

function tool_secure_get_config_options_field_failtoban_active($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-secure-failtoban-active']))
		$value = $options['tool-secure-failtoban-active'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-secure-failtoban-active]" '.$checked.' />';
	echo '<p class="field-description">'.__('block gross power hacking on login, register and comment forms (Woocommerce supported)', WOODKIT_PLUGIN_TEXT_DOMAIN).'</p>';
}