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
	if (!defined('DOING_AJAX') && !defined('DOING_AUTOSAVE')){
		$upgrader_version = get_option("woodkit-upgrader-version", "0.0.0");
		
		/**
		 * Upgrade to 2.0.0
		 */
		if (version_compare($upgrader_version, "2.0.0") < 0){
			woodkitsupport_upgrader_version_2_0_0();
			update_option("woodkit-upgrader-version", "2.0.0");
		}
	}
}
add_action('admin_init', 'woodkit_upgrader_admin_init');

/**
 * Migrate all old tool seo's meta-data to new format
 * since Gutenberg support which impose meta prefixed by _
 */
function woodkitsupport_upgrader_version_2_0_0(){
	trace_info("==============================================================");
	trace_info("=================WOODKIT UPGRADE 2.0.0========================");
	
	/**
	 * Tool SEO
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
					trace_info("post upgrade meta - [{$post->ID}] (".get_post_type($post).") [{$old_key} => {$new_key}]" . $meta_value);
				}
			}
		}
	}

	// TODO update_option => set_term_meta... migration
	
	/**
	 * Tool Event
	 */
	

	trace_info("=================END WOODKIT UPGRADE 2.0.0====================");
	trace_info("==============================================================");
}
