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
 * Upgrade if necessary Woodkit - this function is only called in admin area
 */
function woodkit_upgrader_admin_init(){
	get_displayed_post_types();
	if (!defined('DOING_AJAX') && !defined('DOING_AUTOSAVE')){
		$upgrader_version = get_option("woodkit-upgrader-version", "0.0.0");
		
		/**
		 * Upgrade to 2.0.0
		 */
		if (version_compare($upgrader_version, "2.0.0") < 0){
			woodkit_upgrader_version_2_0_0();
			update_option("woodkit-upgrader-version", "2.0.0");
		}
	}
}
add_action('admin_init', 'woodkit_upgrader_admin_init');

/**
 * Upgrade to Woodkit 2.0.0
 * IMPORTANT : note that this function maybe already used by woodkit's websites and will not be used again,
 * so any update may not be applyed on their website.
 */
function woodkit_upgrader_version_2_0_0(){
	trace_info("==============================================================");
	trace_info("=================WOODKIT UPGRADE 2.0.0========================");
	
	/**
	 * Tool SEO
	 * Migrate all old tool seo's meta-data to new format
	 * since Gutenberg support which impose meta prefixed by _
	 */
	$meta_parses = array(
			'seo-meta-title' => '_seo_meta_title',
			'seo-meta-description' => '_seo_meta_description',
			'seo-meta-keywords' => '_seo_meta_keywords',
			'seo-meta-og-title' => '_seo_meta_og_title',
			'seo-meta-og-description' => '_seo_meta_og_description',
			// 'seo-meta-og-image' => '_seo_meta_og_image', non pris en charge car avant on enregistrait une URL et maintenant on enregistre un ID attachment
	);
	$available_posttypes = get_displayed_post_types();
	$available_posttypes = apply_filters("tool_seo_available_posttypes", $available_posttypes);
	$posts_args = array(
			'posts_per_page'	=> -1,
			'post_type'			=> $available_posttypes,
			'post_status'		=> 'any',
			'suppress_filters'	=> true,
	);
	$get_posts = new WP_Query;
	$posts = $get_posts->query($posts_args);
	if (!empty($posts)) {
		foreach ($posts as $post) {
			foreach ($meta_parses as $old_key => $new_key) {
				$meta_value = @get_post_meta($post->ID, $old_key, true);
				if (!empty($meta_value)) {
					update_post_meta($post->ID, $new_key, $meta_value);
					delete_post_meta($post->ID, $old_key);
					trace_info("post migrate meta - [{$post->ID}] (".get_post_type($post).") [{$old_key} => {$new_key}]" . $meta_value);
				}
			}
		}
	}

	/**
	 * Tool SEO
	 * Migrate all old tool seo's meta-data to new format
	 * since Gutenberg support which impose meta prefixed by _
	 * in addition, term's SEO meta was saved in wp_options data table instead of wp_term_meta and it was a mistake
	 */
	$taxs = get_taxonomies();
	if (!empty($taxs)) {
		foreach ($taxs as $tax) {
			$terms = get_terms(array('taxonomy' => $tax, 'hide_empty' => false));
			if (!empty($terms)) {
				foreach ($terms as $term) {
					foreach ($meta_parses as $old_key => $new_key) {
						$meta_value = get_option("term_".$term->term_id."_".$old_key);
						if (!empty($meta_value)) {
							update_term_meta($term->term_id, $new_key, $meta_value);
							delete_option("term_".$term->term_id."_".$old_key);
							trace_info("term migrate meta - [{$term->term_id}] ({$tax}) [{$old_key} => {$new_key}]" . $meta_value);
						}
					}
				}
			}
		}
	}
	
	/**
	 * Tool Event
	 * Migrate all old tool event's meta-data to new format
	 * since Gutenberg support which impose meta prefixed by _
	 */
	$meta_parses = array(
			'meta_event_date_begin' => '_event_meta_date_begin',
			'meta_event_date_end' => '_event_meta_date_end',
			'meta_event_locate_address' => '_event_meta_locate_address',
			'meta_event_locate_cp' => '_event_meta_locate_cp',
			'meta_event_locate_city' => '_event_meta_locate_city',
			'meta_event_locate_country' => '_event_meta_locate_country',
	);
	$posts_args = array(
			'posts_per_page'	=> -1,
			'post_type'			=> 'event',
			'post_status'		=> 'any',
			'suppress_filters'	=> true,
	);
	$get_posts = new WP_Query;
	$posts = $get_posts->query($posts_args);
	if (!empty($posts)) {
		foreach ($posts as $post) {
			foreach ($meta_parses as $old_key => $new_key) {
				$meta_value = @get_post_meta($post->ID, $old_key, true);
				if (!empty($meta_value)) {
					update_post_meta($post->ID, $new_key, $meta_value);
					delete_post_meta($post->ID, $old_key);
					trace_info("post migrate meta - [{$post->ID}] (".get_post_type($post).") [{$old_key} => {$new_key}]" . $meta_value);
				}
			}
		}
	}
	
	/**
	 * Tool Breadcrumb
	 * Migrate all old tool breadcrumb's meta-data to new format
	 * since Gutenberg support which impose meta prefixed by _
	 */
	$meta_parses = array(
			'meta_breadcrumb_type' => '_breadcrumb_meta_type',
			'meta_breadcrumb_custom_items' => '_breadcrumb_meta_items',
	);
	$available_posttypes = get_displayed_post_types();
	$available_posttypes = apply_filters("tool_breadcrumb_available_posttypes", $available_posttypes);
	$posts_args = array(
			'posts_per_page'	=> -1,
			'post_type'			=> $available_posttypes,
			'post_status'		=> 'any',
			'suppress_filters'	=> true,
	);
	$get_posts = new WP_Query;
	$posts = $get_posts->query($posts_args);
	if (!empty($posts)) {
		foreach ($posts as $post) {
			foreach ($meta_parses as $old_key => $new_key) {
				$meta_value = @get_post_meta($post->ID, $old_key, true);
				if ($old_key === 'meta_breadcrumb_custom_items' && !empty($meta_value)) {
					$new_value = array();
					$parsed_meta_value = json_decode($meta_value, true);
					if (!empty($parsed_meta_value)){
						$key = 0;
						foreach ($parsed_meta_value as $val){
							$parts = explode("|", $val);
							if (count($parts) == 3){
								$type = $parts[0];
								$type_slug = $parts[1];
								$id = $parts[2];
								$new_value[] = array('type' => $type === 'tax' ? 'term' : $type, 'id' => intval($id), 'key' => intval($key));
								$key ++;
							}
						}
					}
					$meta_value = $new_value;
				}
				if (!empty($meta_value)) {
					update_post_meta($post->ID, $new_key, $meta_value);
					delete_post_meta($post->ID, $old_key);
					trace_info("post migrate meta - [{$post->ID}] (".get_post_type($post).") [{$old_key} => {$new_key}]" . var_export($meta_value, true));
				}
			}
		}
	}

	trace_info("=================END WOODKIT UPGRADE 2.0.0====================");
	trace_info("==============================================================");
}
