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
	
	$default_values["tool-secure-headers-nosniff"] = "on";
	$default_values["tool-secure-headers-xss"] = "on";
	$default_values["tool-secure-headers-frame"] = "on";
	$default_values["tool-secure-headers-referrer"] = "no-referrer-when-downgrade";
	$default_values["tool-secure-headers-poweredby"] = "on";
	
	/* - have to uncomment in next version
	$default_values["tool-secure-headers-hsts-time"] = "";
	$default_values["tool-secure-headers-hsts-subdomains"] = "";
	$default_values["tool-secure-headers-hsts-preload"] = "";
	
	$default_values["tool-secure-headers-hpkp-key1"] = "";
	$default_values["tool-secure-headers-hpkp-key2"] = "";
	$default_values["tool-secure-headers-hpkp-key3"] = "";
	$default_values["tool-secure-headers-hpkp-time"] = "";
	$default_values["tool-secure-headers-hpkp-subdomains"] = "";
	$default_values["tool-secure-headers-hpkp-uri"] = "";
	*/
	
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
	
	$additional_fields[] = array("slug" => "tool-secure-headers-nosniff", "callback" => "tool_secure_get_config_options_field_nosniff", "title" => __("No sniff", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-xss", "callback" => "tool_secure_get_config_options_field_xss", "title" => __("XSS protection", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-frame", "callback" => "tool_secure_get_config_options_field_frame", "title" => __("Restrict framing", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-referrer", "callback" => "tool_secure_get_config_options_field_referrer", "title" => __("Referrer policy", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-poweredby", "callback" => "tool_secure_get_config_options_field_poweredby", "title" => __("Hide powered by", WOODKIT_PLUGIN_TEXT_DOMAIN));
	
	/* - have to uncomment in next version
	$additional_fields[] = array("slug" => "tool-secure-headers-hsts-time", "callback" => "tool_secure_get_config_options_field_hsts_time", "title" => __("HSTS Time to live (seconds)", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-hsts-subdomains", "callback" => "tool_secure_get_config_options_field_hsts_subdomains", "title" => __("HSTS to include subdomains", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-hsts-preload", "callback" => "tool_secure_get_config_options_field_hsts_preload", "title" => __("HSTS include site in preload list", WOODKIT_PLUGIN_TEXT_DOMAIN));
	
	$additional_fields[] = array("slug" => "tool-secure-headers-hpkp-key1", "callback" => "tool_secure_get_config_options_field_hpkp_key1", "title" => __("HPKP first key", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-hpkp-key2", "callback" => "tool_secure_get_config_options_field_hpkp_key2", "title" => __("HPKP backup key", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-hpkp-key3", "callback" => "tool_secure_get_config_options_field_hpkp_key3", "title" => __("HPKP optional backup key", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-hpkp-time", "callback" => "tool_secure_get_config_options_field_hpkp_time", "title" => __("HPKP Time to live (seconds)", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-hpkp-subdomains", "callback" => "tool_secure_get_config_options_field_hpkp_subdomains", "title" => __("HPKP to include subdomains", WOODKIT_PLUGIN_TEXT_DOMAIN));
	$additional_fields[] = array("slug" => "tool-secure-headers-hpkp-uri", "callback" => "tool_secure_get_config_options_field_hpkp_uri", "title" => __("HPKP Reporting URI", WOODKIT_PLUGIN_TEXT_DOMAIN));
	*/
	
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

function tool_secure_get_config_options_field_nosniff($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-secure-headers-nosniff']))
		$value = $options['tool-secure-headers-nosniff'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-secure-headers-nosniff]" '.$checked.' />';
	echo '<p class="field-description">'.__('Disable content sniffing.', WOODKIT_PLUGIN_TEXT_DOMAIN).' - HEADER : X-Content-Type-Options: nosniff</p>';
}

function tool_secure_get_config_options_field_xss($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-secure-headers-xss']))
		$value = $options['tool-secure-headers-xss'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-secure-headers-xss]" '.$checked.' />';
	echo '<p class="field-description">'.__('Enabled web broswer XSS protection.', WOODKIT_PLUGIN_TEXT_DOMAIN).' - HEADER : X-XSS-Protection: 1; mode=block</p>';
}

function tool_secure_get_config_options_field_frame($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-secure-headers-frame']))
		$value = $options['tool-secure-headers-frame'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-secure-headers-frame]" '.$checked.' />';
	echo '<p class="field-description">'.__('Enabled clickjacking protection.', WOODKIT_PLUGIN_TEXT_DOMAIN).' - HEADER : X-Frame-Options SAMEORIGIN</p>';
}

function tool_secure_get_config_options_field_poweredby($args){
	$options = $args['options'];
	$active = false;
	$value = "off";
	if (isset($options['tool-secure-headers-poweredby']))
		$value = $options['tool-secure-headers-poweredby'];
	$checked = '';
	if ($value == 'on')
		$checked = ' checked="checked"';
	echo '<input type="checkbox" name="'.WOODKIT_CONFIG_OPTIONS.'[tool-secure-headers-poweredby]" '.$checked.' />';
	echo '<p class="field-description">'.__('Hide powered by info (php version).', WOODKIT_PLUGIN_TEXT_DOMAIN).' - HEADER : X-Powered-By: unknown</p>';
}

function tool_secure_get_config_options_field_referrer($args){
	$options = $args['options'];
	$active = false;
	$value = "no-referrer-when-downgrade";
	if (isset($options['tool-secure-headers-referrer']))
		$value = $options['tool-secure-headers-referrer'];
	echo '<select name="'.WOODKIT_CONFIG_OPTIONS.'[tool-secure-headers-referrer]">';
	$selected = (!empty($value) && $value == 'no-referrer' ? 'selected="selected"' : '');
	echo '<option value="no-referrer" '.$selected.'>'.__("Omit entirely", 'woodkit').'</option>';
	$selected = (empty($value) || $value == 'no-referrer-when-downgrade' ? 'selected="selected"' : '');
	echo '<option value="no-referrer-when-downgrade" '.$selected.'>'.__("(Browser default) omit referrer on downgrade to HTTP", 'woodkit').'</option>';
	$selected = (!empty($value) && $value == 'origin' ? 'selected="selected"' : '');
	echo '<option value="origin" '.$selected.'>'.__("Only send the origin ( https://www.example.com/ )", 'woodkit').'</option>';
	$selected = (!empty($value) && $value == 'origin-when-cross-origin' ? 'selected="selected"' : '');
	echo '<option value="origin-when-cross-origin" '.$selected.'>'.__("Full URL to current origin, but just origin to other sites", 'woodkit').'</option>';
	$selected = (!empty($value) && $value == 'same-origin' ? 'selected="selected"' : '');
	echo '<option value="same-origin" '.$selected.'>'.__("Omit referrer for cross origin requests", 'woodkit').'</option>';
	$selected = (!empty($value) && $value == 'strict-origin' ? 'selected="selected"' : '');
	echo '<option value="strict-origin" '.$selected.'>'.__("Send only the origin, or nothing on downgrade (HTTPS->HTTP)", 'woodkit').'</option>';
	$selected = (!empty($value) && $value == 'strict-origin-when-cross-origin' ? 'selected="selected"' : '');
	echo '<option value="strict-origin-when-cross-origin" '.$selected.'>'.__("Omit on downgrade, just origin on cross-origin, and full to current origin", 'woodkit').'</option>';
	$selected = (!empty($value) && $value == 'unsafe-url' ? 'selected="selected"' : '');
	echo '<option value="unsafe-url" '.$selected.'>'.__("Always send the whole URL", 'woodkit').'</option>';
	echo '</select>';
	echo '<p class="field-description">'.__('Set referrer policy option.', WOODKIT_PLUGIN_TEXT_DOMAIN).' - HEADER : Referrer-Policy: no-referrer-when-downgrade</p>';
}