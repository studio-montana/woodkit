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

define('TOOL_WIDGETMANAGER_HIDE_WIDGET_', 'tool-widgetmanager-hide-widget-');

if (!function_exists("widgetmanager_add_inner_meta_boxes")):
/**
 * This action is called by Woodkit when metabox is display on post-type
* @param unknown $post
*/
function widgetmanager_add_inner_meta_boxes($post){
	$available_posttypes = get_displayed_post_types();
	$available_posttypes = apply_filters("tool_widgetmanager_available_posttypes", $available_posttypes);
	if (in_array(get_post_type($post), $available_posttypes)){
		include(locate_ressource('/'.WOODKIT_PLUGIN_TOOLS_FOLDER.WIDGETMANAGER_TOOL_NAME.'/custom-fields/templates/widgetmanager.php'));
	}
}
add_action("customfields_add_inner_meta_boxes", "widgetmanager_add_inner_meta_boxes", 1000);
endif;

if (!function_exists("widgetmanager_save_post")):
/**
 * This action is called by Woodkit when post-type is saved
* @param int $post_id
*/
function widgetmanager_save_post($post_id){
	$available_posttypes = get_displayed_post_types();
	$available_posttypes = apply_filters("tool_widgetmanager_available_posttypes", $available_posttypes);
	if (in_array($_POST['post_type'], $available_posttypes)){

		// SAVE sidebars widgets forms (hide and external)
		$available_sidebar_ids = tool_widgetmanager_get_available_sidebar_ids();
		$sidebars_widgets = wp_get_sidebars_widgets();
		foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar_id => $sidebar_args){
			if (in_array($sidebar_id, $available_sidebar_ids)){
				$widgets = array();
				if (isset($sidebars_widgets[$sidebar_id]) & !empty($sidebars_widgets[$sidebar_id])){
					$widgets = $sidebars_widgets[$sidebar_id];
				}
				foreach ($widgets as $widget_id){
					$widget = $GLOBALS['wp_registered_widgets'][$widget_id];
					$widget_obj = $widget['callback'][0];
					// IMPORTANT - I don't why $widget_obj->id not always good id (in case of two same declaratino widget : the id is the last id...) - I fixe it strongly
					$widget_obj->id = $widget_id;
					// HIDE
					if (isset($_POST[TOOL_WIDGETMANAGER_HIDE_WIDGET_.$sidebar_id.$widget_obj->id])){
						update_post_meta($post_id, TOOL_WIDGETMANAGER_HIDE_WIDGET_.$sidebar_id.$widget_obj->id, sanitize_text_field($_POST[TOOL_WIDGETMANAGER_HIDE_WIDGET_.$sidebar_id.$widget_obj->id]));
					}else{
						delete_post_meta($post_id, TOOL_WIDGETMANAGER_HIDE_WIDGET_.$sidebar_id.$widget_obj->id);
					}
					// EXTERNAL
					do_action("tool_widgetmanager_post_widget_save_form_".$widget_obj->id_base, $post_id,  $sidebar_id, $widget_obj);
				}
			}
		}
	}
}
add_action("customfields_save_post", "widgetmanager_save_post");
endif;
