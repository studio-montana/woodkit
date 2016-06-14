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
 * register JS
*/
function columnspicker_ajax_admin_enqueue_scripts(){
	$columnspicker_ajax_js_file = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SHORTCODES_TOOL_NAME.'/columns/columnspicker/columnspicker.js');
	if (!empty($columnspicker_ajax_js_file)){
		wp_enqueue_script('columnspicker-ajax', $columnspicker_ajax_js_file, array('jquery'), "1.0");
		wp_localize_script('columnspicker-ajax', 'Columnspicker', array(
		'doneButtonText' => __("Close", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'title' => __("Columns", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'style' => __("Style", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one' => __("one", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_half' => __("one half", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_half_last' => __("one half last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_third' => __("one third", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_third_last' => __("one third last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_fourth' => __("one fourth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_fourth_last' => __("one fourth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_two_third' => __("two third", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_two_third_last' => __("two third last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_three_fourth' => __("three fourth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_three_fourth_last' => __("three fourth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_fifth' => __("one fifth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_fifth_last' => __("one fifth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_two_fifth' => __("two fifth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_two_fifth_last' => __("two fifth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_three_fifth' => __("three fifth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_three_fifth_last' => __("three fifth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_four_fifth' => __("four fifth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_four_fifth_last' => __("four fifth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_sixth' => __("one sixth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_one_sixth_last' => __("one sixth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_five_sixth' => __("five sixth", WOODKIT_PLUGIN_TEXT_DOMAIN),
		'col_five_sixth_last' => __("five sixth last", WOODKIT_PLUGIN_TEXT_DOMAIN),
		)
		);
	}
}
add_action('admin_enqueue_scripts', 'columnspicker_ajax_admin_enqueue_scripts');