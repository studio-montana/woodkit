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
 * Comparator for post_types string
*/
function woodkit_cmp_posttypes($post_type_1, $post_type_2) {
	$current_post_type_label_1 = get_post_type_labels(get_post_type_object($post_type_1));
	$current_post_type_label_2 = get_post_type_labels(get_post_type_object($post_type_2));
	return strcmp($current_post_type_label_1->name, $current_post_type_label_2->name);
}
endif;