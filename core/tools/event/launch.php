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
 * CONSTANTS
*/
define('EVENT_NONCE_ACTION', 'event_nonce_action');

/**
 * WIDGETS
*/
require_once (WOODKIT_PLUGIN_PATH.'/'.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.EVENT_TOOL_NAME.'/widgets/tool-event-widget.class.php');

/**
 * This action is called by Woodkit when metabox is display on post-type
 * @param unknown $post
*/
function tool_event_add_inner_meta_boxes($post){
	$id_blog_page = get_option('page_for_posts');
	if ($id_blog_page != get_the_ID()){
		if (get_post_type($post) == 'event'){
			include(locate_ressource('/'.WOODKIT_PLUGIN_TOOLS_FOLDER.EVENT_TOOL_NAME.'/templates/template-event-fields.php'));
		}
	}
}
add_action("customfields_add_inner_meta_boxes_top", "tool_event_add_inner_meta_boxes", 1);

if (!function_exists("add_event_post_type")):
/**
 * ajoute le post-type 'event'
*/
function add_event_post_type(){

	// woodkit post type
	$labels = array(
			'name'               => __('Events', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'singular_name'      => __('Event', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'add_new_item'       => __('Add Event', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'edit_item'          => __('Edit Event', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'new_item'           => __('New Event', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'all_items'          => __('Events', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'view_item'          => __('Look Event', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'search_items'       => __('Search Events', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'not_found'          => __('No Event found', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'not_found_in_trash' => __('No Event found in trash', WOODKIT_PLUGIN_TEXT_DOMAIN)
	);
	$args = array(
			'labels'             => $labels,
			'exclude_from_search' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_icon' => 'dashicons-calendar-alt',
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'rewrite'           => array('slug' => _x('events', 'URL slug', WOODKIT_PLUGIN_TEXT_DOMAIN))
	);
	register_post_type('event', $args);

	// woodkit taxonomy
	$labels = array(
			"name"              => __("Event Types", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"singular_name"     => __("Event Type", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"search_items"      => __("Search Event Type", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"all_items"         => __("All Event Types", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"parent_item"       => __("Event Type's parent", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"parent_item_colon" => __("Event Type's parent", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"edit_item"         => __("Edit Event Type", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"update_item"       => __("Update Event Type", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"add_new_item"      => __("Add Event Type", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"new_item_name"     => __("Name", WOODKIT_PLUGIN_TEXT_DOMAIN),
			"menu_name"         => __("Event Type", WOODKIT_PLUGIN_TEXT_DOMAIN)
	);
	$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => _x('evenement-type', 'URL slug', WOODKIT_PLUGIN_TEXT_DOMAIN))
	);
	register_taxonomy('eventtype', array( 'event' ), $args);
	
	do_action("tool_event_add_post_type_after", "event");
	
}
add_action('init', 'add_event_post_type', 100); // 100 => after tool config saved
endif;

/**
 * This action is called by Woodkit when post-type is saved
 * @param int $post_id
 */
function tool_event_save_post($post_id){
	if ($_POST['post_type'] == 'event'){
		// meta_event_date_begin
		if (isset($_POST["meta_event_date_begin"]) && !empty($_POST["meta_event_date_begin"])){
			if (isset($_POST["meta_event_hour_begin"]) && !empty($_POST["meta_event_hour_begin"])){
				$hour_begin = $_POST["meta_event_hour_begin"];
			}else{
				$hour_begin = "08";
			}
			if (isset($_POST["meta_event_minute_begin"]) && !empty($_POST["meta_event_minute_begin"])){
				$minute_begin = $_POST["meta_event_minute_begin"];
			}else{
				$minute_begin = "00";
			}
			// transform date to timestamp
			$date_begin = DateTime::createFromFormat('d/m/Y H:i', $_POST["meta_event_date_begin"]." ".$hour_begin.":".$minute_begin);
			if ($date_begin)
				update_post_meta($post_id, "meta_event_date_begin", $date_begin->getTimestamp());
			else
				delete_post_meta($post_id, "meta_event_date_begin");
		}else{
			delete_post_meta($post_id, "meta_event_date_begin");
		}
		// meta_event_date_end
		if (isset($_POST["meta_event_date_end"]) && !empty($_POST["meta_event_date_end"])){
			if (isset($_POST["meta_event_hour_end"]) && !empty($_POST["meta_event_hour_end"])){
				$hour_end = $_POST["meta_event_hour_end"];
			}else{
				$hour_end = "18";
			}
			if (isset($_POST["meta_event_minute_end"]) && !empty($_POST["meta_event_minute_end"])){
				$minute_end = $_POST["meta_event_minute_end"];
			}else{
				$minute_end = "00";
			}
			// transform date to timestamp
			$date_end = DateTime::createFromFormat('d/m/Y H:i', $_POST["meta_event_date_end"]." ".$hour_end.":".$minute_end);
			if ($date_end)
				update_post_meta($post_id, "meta_event_date_end", $date_end->getTimestamp());
			else
				delete_post_meta($post_id, "meta_event_date_end");
		}else{
			delete_post_meta($post_id, "meta_event_date_end");
		}
		// meta_event_locate_address
		if (isset($_POST["meta_event_locate_address"]) && !empty($_POST["meta_event_locate_address"])){
			update_post_meta($post_id, "meta_event_locate_address", sanitize_text_field($_POST["meta_event_locate_address"]));
		}else{
			delete_post_meta($post_id, "meta_event_locate_address");
		}
		// meta_event_locate_cp
		if (isset($_POST["meta_event_locate_cp"]) && !empty($_POST["meta_event_locate_cp"])){
			update_post_meta($post_id, "meta_event_locate_cp", sanitize_text_field($_POST["meta_event_locate_cp"]));
		}else{
			delete_post_meta($post_id, "meta_event_locate_cp");
		}
		// meta_event_locate_city
		if (isset($_POST["meta_event_locate_city"]) && !empty($_POST["meta_event_locate_city"])){
			update_post_meta($post_id, "meta_event_locate_city", sanitize_text_field($_POST["meta_event_locate_city"]));
		}else{
			delete_post_meta($post_id, "meta_event_locate_city");
		}
		// meta_event_locate_country
		if (isset($_POST["meta_event_locate_country"]) && !empty($_POST["meta_event_locate_country"])){
			update_post_meta($post_id, "meta_event_locate_country", sanitize_text_field($_POST["meta_event_locate_country"]));
		}else{
			delete_post_meta($post_id, "meta_event_locate_country");
		}
		
		// others
		do_action("woodkit_event_save_after", $post_id);
	}
}
add_action("customfields_save_post", "tool_event_save_post");

if (!function_exists("define_event_columns")):
/**
 * woodkit listing columns
*/
function define_event_columns($columns){
	$columns["event-date-begin"] = __("Begin", WOODKIT_PLUGIN_TEXT_DOMAIN);
	$columns["event-date-end"] = __("End", WOODKIT_PLUGIN_TEXT_DOMAIN);
	return $columns;
}
add_filter('manage_edit-event_columns', 'define_event_columns');
endif;

if (!function_exists("build_event_columns")):
/**
 * woodkit listing columns content
*/
function build_event_columns($column, $post_id){
	switch($column){
		case "event-date-begin":
			$meta_date_begin = get_post_meta($post_id, "meta_event_date_begin", true);
			$meta_date_begin_s = "";
			if (!empty($meta_date_begin) && is_numeric($meta_date_begin)){
				$meta_date_begin = new DateTime("@".$meta_date_begin);
				if ($meta_date_begin)
					echo $meta_date_begin->format("d")."/".$meta_date_begin->format("m")."/".$meta_date_begin->format("Y")." ".$meta_date_begin->format("H").":".$meta_date_begin->format("i");
				else
					echo '-';
			}else{
				echo '-';
			}
			break;
		case "event-date-end":
			$meta_date_end = get_post_meta($post_id, "meta_event_date_end", true);
			$meta_date_end_s = "";
			if (!empty($meta_date_end) && is_numeric($meta_date_end)){
				$meta_date_end = new DateTime("@".$meta_date_end);
				if ($meta_date_end)
					echo $meta_date_end->format("d")."/".$meta_date_end->format("m")."/".$meta_date_end->format("Y")." ".$meta_date_end->format("H").":".$meta_date_end->format("i");
				else
					echo '-';
			}else{
				echo '-';
			}
			break;
	}
}
add_action( 'manage_event_posts_custom_column' , 'build_event_columns', 10, 2 );
endif;

/**
 * retieve upcomping events (from date_from to date_to)
 * @param int $date_from : null for now
 * @param int $date_to : null for 100 years after date_from
 * @param string $meta_args
 * @param unknown $args
 * @return array of upcomping events
 */
function get_event_post_types_upcoming($date_from = null, $date_to = null, $meta_args = null, $args=array(), $check_date_begin = true, $check_date_end = true, $operator = 'OR'){
	if (!isset($date_from) || empty($date_from)){
		$date_from = time();
	}
	if (!isset($date_to) || empty($date_to)){
		$date_to = $date_from + ((((365*100)*60)*60)*24);
	}
	$args['orderby'] = 'meta_value_num';
	$args['meta_key'] = 'meta_event_date_begin';
	$args['order'] = 'ASC';

	if ($check_date_begin && $check_date_end){
		$args['meta_query'] = array(
				'relation' => $operator,
				array(
						'key' => 'meta_event_date_begin',
						'value' => array($date_from, $date_to),
						'compare' => 'BETWEEN'
				),
				array(
						'key' => 'meta_event_date_end',
						'value' => array($date_from, $date_to),
						'compare' => 'BETWEEN'
				)
		);
	}else if($check_date_end){
		$args['meta_query'] = array(
				array(
						'key' => 'meta_event_date_end',
						'value' => array($date_from, $date_to),
						'compare' => 'BETWEEN'
				)
		);
	}else{
		$args['meta_query'] = array(
				array(
						'key' => 'meta_event_date_begin',
						'value' => array($date_from, $date_to),
						'compare' => 'BETWEEN'
				)
		);
	}
	return get_event_post_types($meta_args, $args);
}

/**
 * renvoi les post-type event
 * @param string $meta_args : permet de filtrer sur les post_meta
 * @return array
 */
function get_event_post_types($meta_args = null, $args=array()){
	return get_post_types_by_type('event', $meta_args, $args);
}

/**
 * construit les options (html) avec les event existants
 * @param string $id_selected
 * @return string
 */
function get_event_options($id_selected = null){
	$events = get_event_post_types();
	foreach ($events as $event){
		if ($id_selected == $event->ID)
			$selected = ' selected="selected"';
		else
			$selected = '';
		$res .= '<option value="'.$event->ID.'"'.$selected.'>'.$event->post_title.'</option>';
	}
	return $res;
}

/**
 * Retrieve pretty event date
 * @param string $event or get current post if null
 */
function get_event_date_pretty($event = null, $display_hours = true){
	$res = '';
	if (is_object($event))
		$event = $event->ID;
	if (empty($event) || ! is_numeric($event)){
		$event = get_the_ID();
	}
	if (get_post_type($event) == 'event'){
		$date_s = "";
		if (get_post_type() == 'event'){
			$meta_date_begin = get_post_meta($event, "meta_event_date_begin", true);
			$meta_date_begin_s = "";
			$meta_day_begin_s = "";
			$meta_month_begin_s = "";
			$meta_year_begin_s = "";
			if (!empty($meta_date_begin) && is_numeric($meta_date_begin)){
				$meta_day_begin_s = strftime("%d",$meta_date_begin);
				$meta_month_begin_s = get_textual_month($meta_date_begin);
				$meta_date_begin_s = $meta_day_begin_s." ".$meta_month_begin_s;
				$meta_year_begin_s = strftime("%Y",$meta_date_begin);
				$meta_date_hour_begin = strftime("%H",$meta_date_begin);
				$meta_date_minute_begin = strftime("%M",$meta_date_begin);
			}
			$meta_date_hour_begin_s = "";
			if (!empty($meta_date_hour_begin) && !empty($meta_date_minute_begin))
				$meta_date_hour_begin_s = $meta_date_hour_begin.":".$meta_date_minute_begin;

			$meta_date_end = get_post_meta($event, "meta_event_date_end", true);
			$meta_date_end_s = "";
			$meta_day_end_s = "";
			$meta_month_end_s = "";
			$meta_year_end_s = "";
			if (!empty($meta_date_end) && is_numeric($meta_date_end)){
				$meta_day_end_s = strftime("%d",$meta_date_end);
				$meta_month_end_s = get_textual_month($meta_date_end);
				$meta_date_end_s = $meta_day_end_s." ".$meta_month_end_s;
				$meta_year_end_s = strftime("%Y",$meta_date_end);
				$meta_date_hour_end = strftime("%H",$meta_date_end);
				$meta_date_minute_end = strftime("%M",$meta_date_end);
			}
			$meta_date_hour_end_s = "";
			if (!empty($meta_date_hour_end) && !empty($meta_date_minute_end))
				$meta_date_hour_end_s = $meta_date_hour_end.":".$meta_date_minute_end;

			$date_s = "";
			if ($meta_date_begin_s == $meta_date_end_s){
				if ($meta_date_hour_begin_s != $meta_date_hour_end_s){
					$hour_s = " ".__("from (hour)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_date_hour_begin_s." ".__("to (hour)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_date_hour_end_s;
				}else{
					$hour_s = " ".__("at (hour)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_date_hour_begin_s;
				}
				if (!$display_hours){
					$hour_s = "";
				}
				$date_s = $meta_day_begin_s." ".$meta_month_begin_s." ".$meta_year_begin_s.$hour_s;
			}else{
				$hour_begin_s = " ".__("at (hour)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_date_hour_begin_s;
				$hour_end_s = " ".__("at (hour)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_date_hour_end_s;
				if (!$display_hours){
					$hour_begin_s = "";
					$hour_end_s = "";
				}
				if ($meta_year_begin_s == $meta_year_end_s){
					$date_s = __("from (date)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_day_begin_s." ".$meta_month_begin_s.$hour_begin_s." ".__("to (date)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_day_end_s." ".$meta_month_end_s." ".$meta_year_end_s.$hour_end_s;
				}else{
					$date_s = __("from (date)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_day_begin_s." ".$meta_month_begin_s.$meta_year_begin_s." ".$hour_begin_s." ".__("to (date)", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_day_end_s." ".$meta_month_end_s." ".$meta_year_end_s.$hour_end_s;
				}
			}
		}
		$res = $date_s;
	}
	return $res;
}

