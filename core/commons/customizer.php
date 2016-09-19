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

global $woodkit_customizer_langs;

/**
 * Simplify customizer adding control for each used languages (WPML support)
 * @param unknown $customizer_obj
 * @param unknown $control_slug
 * @param unknown $settings_args
 * @param unknown $control_args
 * @param string $multilingual
 */
function woodkit_customizer_add_add_control($customizer_obj, $control_slug, $settings_args = array(), $control_args = array(), $multilingual = true){
	if ($multilingual){
		$langs = woodkit_customizer_get_langs();
		if (!empty($langs)){
			foreach ($langs as $lang){
				$control_args['settings'] = $control_slug.$lang;
				$control_args['label'] = $control_args['label']." [".$lang."]";
				$customizer_obj->add_setting($control_slug.$lang, $settings_args);
				$customizer_obj->add_control($control_slug.$lang, $control_args);
			}
		}else{
			$customizer_obj->add_setting($control_slug, $settings_args);
			$customizer_obj->add_control($control_slug, $control_args);
		}
	}else{
		$customizer_obj->add_setting($control_slug, $settings_args);
		$customizer_obj->add_control($control_slug, $control_args);
	}
}

/**
 * Retrieve customizer value for slug, if lang is empty and multilingual true, function use current lang
 * @param unknown $control_slug
 * @param unknown $default
 * @param string $lang
 */
function woodkit_customizer_get_value($slug, $default = '', $multilingual = true, $lang = ''){
	if ($multilingual){
		if (empty($lang)){
			$lang = get_current_lang();
		}
		return get_theme_mod($slug.$lang, $default);
	}else{
		return get_theme_mod($slug, $default);
	}
}

/**
 * Retrieve used languages (WPML support)
 * @return Ambigous <unknown, multitype:string >
 */
function woodkit_customizer_get_langs(){
	global $woodkit_customizer_langs;
	if (empty($woodkit_customizer_langs)){
		$woodkit_customizer_langs = array();
		if (function_exists("icl_get_languages")){
			$wpml_langs =  icl_get_languages();
			foreach ($wpml_langs as $code => $al) {
				$woodkit_customizer_langs[] = strtolower($code);
			}
		}else{
			$woodkit_customizer_langs[] = strtolower(get_current_lang());
		}
	}
	return $woodkit_customizer_langs;
}