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

define('CUSTOMFIELDS_NONCE_ACTION', 'customfields_action');

if (!function_exists("customfields_admin_init")):
/**
 * Hooks the WP admin_init action to add metaboxe customfields on post-type
*
* @return void
*/
function customfields_admin_init() {
	$customfields_posttypes_available = get_displayed_post_types();
	$customfields_posttypes_available = apply_filters("woodkit_customfields_available_posttypes", $customfields_posttypes_available);
	$metabox_position = $key = woodkit_get_option("metabox-position");
	if (empty($metabox_position))
		$metabox_position = "default";
	foreach ($customfields_posttypes_available as $post_type){
		add_meta_box('woodkit-customfields', '<i class="fa fa-rocket" style="margin-right: 6px; font-size: 1.3rem;"></i>'.__('Page options', WOODKIT_PLUGIN_TEXT_DOMAIN), 'customfields_add_inner_meta_boxes', $post_type, 'normal', $metabox_position);
	}
}
add_action('admin_init', 'customfields_admin_init');
endif;

if (!function_exists("customfields_add_inner_meta_boxes")):
/**
 * include customfields template
* @param unknown $post
*/
function customfields_add_inner_meta_boxes($post) {
	?>
	<input type="hidden" name="<?php echo CUSTOMFIELDS_NONCE_ACTION; ?>" value="<?php echo wp_create_nonce(CUSTOMFIELDS_NONCE_ACTION);?>" />
	<?php
	do_action("customfields_add_inner_meta_boxes", $post);
}
endif;

if (!function_exists("customfields_save_post")):
/**
 * save BACKGROUNDIMAGE fields on post type
* @param unknown $post_id
*/
function customfields_save_post($post_id){
	$customfields_posttypes_available = get_displayed_post_types();

	// verify if this is an auto save routine.
	// If it is our form has not been submitted, so we dont want to do anything
	if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	// verify if this post-type is available and editable.
	$is_post_available = false;
	$post_type = null;
	if (isset($_POST['post_type']) && !empty($_POST['post_type']) && in_array($_POST['post_type'], $customfields_posttypes_available)){
		$post_type = $_POST['post_type'];
	}
	if (empty($post_type))
		return;
	if ($post_type == 'page') {
		if (!current_user_can('edit_page', $post_id))
			return;
	} else {
		if (!current_user_can('edit_post', $post_id ))
			return;
	}
	if (!isset($_POST[CUSTOMFIELDS_NONCE_ACTION]) || !wp_verify_nonce($_POST[CUSTOMFIELDS_NONCE_ACTION], CUSTOMFIELDS_NONCE_ACTION))
		return;

	do_action("customfields_save_post", $post_id);
}
add_action('save_post', 'customfields_save_post');
endif;
