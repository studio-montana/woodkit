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

if (!function_exists("woodkit_cmp_posttypes")):
/**
 * Comparator for post_types string by their label
*/
function woodkit_cmp_posttypes($post_type_1, $post_type_2) {
	$current_post_type_label_1 = get_post_type_labels(get_post_type_object($post_type_1));
	$current_post_type_label_2 = get_post_type_labels(get_post_type_object($post_type_2));
	return strcmp($current_post_type_label_1->name, $current_post_type_label_2->name);
}
endif;

/**
 * options sorted comparator (used in usort function based on 'rank' property)
 * @param array $item_1 : must have 'rank' property
 * @param array $item_2 : must have 'rank' property
 * @return number
 */
function woodkit_cmp_options_sorted($item_1, $item_2){
	$name_1 = "";
	if (isset($item_1['rank']) && !empty($item_1['rank']))
		$name_1 = $item_1['rank'];
	$name_2 = "";
	if (isset($item_2['rank']) && !empty($item_2['rank']))
		$name_2 = $item_2['rank'];

	if ($name_1 == $name_2) {
		return 0;
	}
	return ($name_1 < $name_2) ? -1 : 1;
}

/**
 * options sorted comparator (used in usort function based on 'rank' property)
 * @param array $item_1 : must have 'rank' property
 * @param array $item_2 : must have 'rank' property
 * @return number
 */
function woodkit_cmp_tools_by_name($tool_1, $tool_2){
	$tool_1_name = !empty($tool_1->get_name()) ? woodkit_remove_accent($tool_1->get_name()) : '';
	$tool_2_name = !empty($tool_2->get_name()) ? woodkit_remove_accent($tool_2->get_name()) : '';
	return strcmp($tool_1_name, $tool_2_name);
}