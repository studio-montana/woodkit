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
define('META_WALL_DISPLAY_POST_TYPE', 'meta_wall_display_post_type');
define('META_WALL_DISPLAY_IDS', 'meta_wall_display_ids');
define('META_WALL_DISPLAY_POSITION', 'meta_wall_display_position');
define('META_WALL_DISPLAY_TAX', 'meta_wall_display_tax');
define('META_WALL_DISPLAY_TERM_SLUG', 'mate_wall_display_term_slug');
define('META_WALL_DISPLAY_ORDERBY', 'meta_wall_display_orderby');
define('META_WALL_DISPLAY_ORDER', 'meta_wall_display_order');
define('META_WALL_DISPLAY_NUMBER', 'meta_wall_display_number');
define('META_WALL_DISPLAY_PARENT', 'meta_wall_display_parent');
define('META_WALL_DISPLAY_PRESENTATION', 'meta_wall_display_presentation');
define('META_WALL_DISPLAY_PRESENTATION_COLUMNS', 'meta_wall_display_presentation_columns');
define('META_WALL_DISPLAY_PRESENTATION_FILTERING', 'meta_wall_display_presentation_filtering');
define('META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL', 'meta_wall_display_presentation_slider_carousel');
define('META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS', 'meta_wall_display_presentation_slider_carousel_columns');
define('META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH', 'meta_wall_display_presentation_slider_carousel_item_width');
define('META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN', 'meta_wall_display_presentation_slider_carousel_item_margin');
define('META_WALL_DISPLAY_PRESENTATION_SLIDER_AUTOPLAY', 'meta_wall_display_presentation_slider_autoplay');
define('META_WALL_DISPLAY_PRESENTATION_SLIDER_THUMB_NAV', 'meta_wall_display_presentation_slider_thumb_nav');
define('META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT', 'meta_wall_display_presentation_initial_height');
define('META_WALL_DISPLAY_PRESENTATION_FORMAT', 'meta_wall_display_presentation_format');
define('META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH', 'meta_wall_display_presentation_masonry_width');
define('META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH_WOODKITIZED', 'meta_wall_display_presentation_masonry_width_customized');
define('META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT', 'meta_wall_display_presentation_masonry_height');
define('META_WALL_DISPLAY_PRESENTATION_SETUP', 'meta_wall_display_presentation_setup');
define('META_WALL_DISPLAY_PRESENTATION_SETUP_WIDTH_', 'meta_wall_display_presentation_setup_width_');
define('META_WALL_DISPLAY_PRESENTATION_SETUP_HEIGHT_', 'meta_wall_display_presentation_setup_height_');
define('META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_', 'meta_wall_display_presentation_setup_template_');

if (!function_exists("wall_add_inner_meta_boxes")):
/**
 * This action is called by Woodkit when metabox is displayed on post-type
* @param unknown $post
*/
function wall_add_inner_meta_boxes($post){
	$id_blog_page = get_option('page_for_posts');
	if ($id_blog_page != get_the_ID()){
		$available_posttypes = get_displayed_post_types();
		$available_posttypes = apply_filters("tool_wall_available_posttypes", $available_posttypes);
		if (in_array(get_post_type($post), $available_posttypes)){
			include(locate_ressource('/'.WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/custom-fields/templates/display-wall.php'));
		}
	}
}
add_action("customfields_add_inner_meta_boxes", "wall_add_inner_meta_boxes");
endif;

if (!function_exists("wall_save_post")):
/**
 * This action is called by Woodkit when post-type is saved
* @param int $post_id
*/
function wall_save_post($post_id){
	$available_posttypes = get_displayed_post_types();
	$available_posttypes = apply_filters("tool_wall_available_posttypes", $available_posttypes);
	if (in_array(get_post_type($post_id), $available_posttypes)){
		// META_WALL_DISPLAY_POST_TYPE
		if (!empty($_POST[META_WALL_DISPLAY_POST_TYPE])){
			update_post_meta($post_id, META_WALL_DISPLAY_POST_TYPE, sanitize_text_field($_POST[META_WALL_DISPLAY_POST_TYPE]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_POST_TYPE);
		}
		// META_WALL_DISPLAY_IDS
		if (!empty($_POST[META_WALL_DISPLAY_IDS])){
			update_post_meta($post_id, META_WALL_DISPLAY_IDS, sanitize_text_field($_POST[META_WALL_DISPLAY_IDS]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_IDS);
		}
		// META_WALL_DISPLAY_POSITION
		if (!empty($_POST[META_WALL_DISPLAY_POSITION])){
			update_post_meta($post_id, META_WALL_DISPLAY_POSITION, sanitize_text_field($_POST[META_WALL_DISPLAY_POSITION]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_POSITION);
		}
		// META_WALL_DISPLAY_TAX
		if (!empty($_POST[META_WALL_DISPLAY_TAX])){
			update_post_meta($post_id, META_WALL_DISPLAY_TAX, sanitize_text_field($_POST[META_WALL_DISPLAY_TAX]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_TAX);
		}
		// META_WALL_DISPLAY_TERM_SLUG
		if (!empty($_POST[META_WALL_DISPLAY_TERM_SLUG])){
			update_post_meta($post_id, META_WALL_DISPLAY_TERM_SLUG, sanitize_text_field($_POST[META_WALL_DISPLAY_TERM_SLUG]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_TERM_SLUG);
		}
		// META_WALL_DISPLAY_ORDERBY
		if (!empty($_POST[META_WALL_DISPLAY_ORDERBY])){
			update_post_meta($post_id, META_WALL_DISPLAY_ORDERBY, sanitize_text_field($_POST[META_WALL_DISPLAY_ORDERBY]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_ORDERBY);
		}
		// META_WALL_DISPLAY_ORDER
		if (!empty($_POST[META_WALL_DISPLAY_ORDER])){
			update_post_meta($post_id, META_WALL_DISPLAY_ORDER, sanitize_text_field($_POST[META_WALL_DISPLAY_ORDER]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_ORDER);
		}
		// META_WALL_DISPLAY_NUMBER
		if (!empty($_POST[META_WALL_DISPLAY_NUMBER]) && is_numeric($_POST[META_WALL_DISPLAY_NUMBER])){
			update_post_meta($post_id, META_WALL_DISPLAY_NUMBER, sanitize_text_field($_POST[META_WALL_DISPLAY_NUMBER]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_NUMBER);
		}
		// META_WALL_DISPLAY_PARENT
		if (isset($_POST[META_WALL_DISPLAY_PARENT])){
			update_post_meta($post_id, META_WALL_DISPLAY_PARENT, sanitize_text_field($_POST[META_WALL_DISPLAY_PARENT]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PARENT);
		}
		// META_WALL_DISPLAY_PRESENTATION_COLUMNS
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_COLUMNS]) && is_numeric($_POST[META_WALL_DISPLAY_PRESENTATION_COLUMNS])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_COLUMNS, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_COLUMNS]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_COLUMNS, 3);
		}
		// META_WALL_DISPLAY_PRESENTATION_FILTERING
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_FILTERING])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_FILTERING, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_FILTERING]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_FILTERING);
		}
		// META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL);
		}
		// META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS]) && is_numeric($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS, 3);
		}
		// META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH]) && is_numeric($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH, "250");
		}
		// META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN]) && is_numeric($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN, "5");
		}
		// META_WALL_DISPLAY_PRESENTATION_SLIDER_AUTOPLAY
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_AUTOPLAY])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_AUTOPLAY, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_AUTOPLAY]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_AUTOPLAY);
		}
		// META_WALL_DISPLAY_PRESENTATION_SLIDER_THUMB_NAV
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_THUMB_NAV])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_THUMB_NAV, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_SLIDER_THUMB_NAV]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SLIDER_THUMB_NAV);
		}
		// META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT]) && is_numeric($_POST[META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT, 250);
		}
		// META_WALL_DISPLAY_PRESENTATION_FORMAT
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_FORMAT])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_FORMAT, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_FORMAT]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_FORMAT, "square");
		}
		// META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH, 4);
		}
		// META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH_WOODKITIZED
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH_WOODKITIZED])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH_WOODKITIZED, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH_WOODKITIZED]));
		}else{
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH_WOODKITIZED, "250");
		}
		// META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT]) && is_numeric($_POST[META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT);
		}
		// META_WALL_DISPLAY_PRESENTATION
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION, sanitize_text_field($_POST[META_WALL_DISPLAY_PRESENTATION]));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION);
		}
		// META_WALL_DISPLAY_PRESENTATION_SETUP
		if (!empty($_POST[META_WALL_DISPLAY_PRESENTATION_SETUP])){
			update_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SETUP, sanitize_text_field(html_entity_decode($_POST[META_WALL_DISPLAY_PRESENTATION_SETUP])));
		}else{
			delete_post_meta($post_id, META_WALL_DISPLAY_PRESENTATION_SETUP);
		}
	}
}
add_action("customfields_save_post", "wall_save_post");
endif;

if (!function_exists("wall_filter_the_content")):
function wall_filter_the_content($content){
	$meta_wall_display_position = get_post_meta(get_the_ID(), META_WALL_DISPLAY_POSITION, true);
	if (($meta_wall_display_position == "before-content" || $meta_wall_display_position == "after-content") && in_array(get_post_type(get_the_ID()), get_displayed_post_types()) && (is_single(get_the_ID()) || is_page(get_the_ID()))){ // never for search, listing, ...
		$meta_wall_display_post_type = get_post_meta(get_the_ID(), META_WALL_DISPLAY_POST_TYPE, true);
		if (!empty($meta_wall_display_post_type) && $meta_wall_display_post_type != '0'){
			$content = '<div class="content-with-wall-wrapper"><div class="content-with-wall">'.$content.'</div></div>';
			ob_start();
			$wall_template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-display.php');
			if (!empty($wall_template))
				include($wall_template);
			if (empty($meta_wall_display_position) || $meta_wall_display_position == 'before-content')
				$content = ob_get_contents() . $content;
			else if ($meta_wall_display_position == 'after-content')
				$content = $content . ob_get_contents();
			ob_end_clean();
		}
	}
	return $content;
}
add_filter('the_content','wall_filter_the_content', 99); // make sur it the last called filter, otherwise : you'll get WP Gallery like "[gallery ids="12,11,10,9,8,7,6,5"]",
endif;

/**
 * Make shortcode
 */
function tool_wall_use_shortcode($atts, $content = null, $name='') {
	$output = '<div class="wall-shortcode">';
	$atts = shortcode_atts(array(), $atts);
	$meta_wall_display_position = get_post_meta(get_the_ID(), META_WALL_DISPLAY_POSITION, true);
	if ($meta_wall_display_position == "use-shortcode" && in_array(get_post_type(get_the_ID()), get_displayed_post_types()) && (is_single(get_the_ID()) || is_page(get_the_ID()))){ // never for search, listing, ...
		$meta_wall_display_post_type = get_post_meta(get_the_ID(), META_WALL_DISPLAY_POST_TYPE, true);
		if (!empty($meta_wall_display_post_type) && $meta_wall_display_post_type != '0'){
			ob_start();
			$wall_template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-display.php');
			if (!empty($wall_template))
				include($wall_template);
			$output .= ob_get_contents();
			ob_end_clean();
		}
	}
	$output .= '</div>';
	return $output;
}
add_shortcode('woodkit_wall', 'tool_wall_use_shortcode');

if (!function_exists("wall_get_post_types_options")):
/**
 * construit les options (html) avec les portfolios existants
* @param int $id_selected
* @param int $current_post_id : post in loop
* @return string
*/
function wall_get_post_types_options($post_types = array(), $id_selected = 0, $current_post_id = 0){
	if (empty($post_types))
		$post_types = get_displayed_post_types();
	foreach ($post_types as $post_type){
		$posts = get_post_types_by_type($post_type, array(), array('post_parent' => 0));
		if (!empty($posts)){
			$post_type_label = get_post_type_labels(get_post_type_object($post_type));
			$res .= '<optgroup label="'.esc_attr($post_type_label->name).'">';
			foreach ($posts as $post){
				$res .= wall_get_post_types_option($post, $id_selected, $current_post_id, 0);
			}
			$res .= '</optgroup>';
		}
	}
	return $res;
}
endif;

if (!function_exists("wall_get_post_types_option")):
/**
 * construit l'options (html) du post spécifié et ses fils
* @param object $post
* @param int $id_selected
* @param int $current_post_id : post in loop
* @param number $level
* @return string
*/
function wall_get_post_types_option($post, $id_selected = 0, $current_post_id = 0, $level = 0){
	$res = '';
	if ($id_selected == $post->ID)
		$selected = ' selected="selected"';
	else
		$selected = '';
	$level_string = '';
	for ($i = 0; $i < $level ; $i++){
		$level_string .= '-';
	}
	$info = '';
	if ($current_post_id == $post->ID){
		$post_type_label = get_post_type_labels(get_post_type_object(get_post_type($post)));
		$info = ' (current '.$post_type_label->singular_name.')';
	}
	$res .= '<option data-post-type="'.get_post_type($post).'" value="'.$post->ID.'"'.$selected.'>'.$level_string.$post->post_title.$info.'</option>';
	if (is_post_type_hierarchical(get_post_type($post))){
		$children = get_post_types_by_type(get_post_type($post), array(), array('post_parent' => $post->ID));
		if (!empty($children)){
			$level ++;
			foreach ($children as $child){
				$res .= wall_get_post_types_option($child, $id_selected, $current_post_id, $level);
			}
		}
	}
	return $res;
}
endif;


if (!function_exists("wall_get_available_isotope_widths")):
/**
 * retrieve available grid widths for presentation format specified (used by isotope)
* @param int $presentation_columns
*/
function wall_get_available_isotope_widths($presentation_columns){
	$available_widths = array();
	if ($presentation_columns == 2){
		$available_widths = array("1", "2");
	}else if ($presentation_columns == 3){
		$available_widths = array("1", "2", "3");
	}else if ($presentation_columns == 4){
		$available_widths = array("1", "2", "3", "4");
	}else if ($presentation_columns == 5){
		$available_widths = array("1", "2", "3", "4", "5");
	}else if ($presentation_columns == 6){
		$available_widths = array("1", "2", "3", "4", "5", "6");
	}else {
		$available_widths = array("1");
	}
	return $available_widths;
}
endif;

if (!function_exists("wall_get_available_isotope_heights")):
/**
 * retrieve available grid heights for presentation format specified (used by isotope)
* @param unknown $presentation_columns
*/
function wall_get_available_isotope_heights($presentation_columns){
	$available_heights = array();
	if ($presentation_columns == 2){
		$available_heights = array("1", "2");
	}else if ($presentation_columns == 3){
		$available_heights = array("1", "2", "3");
	}else if ($presentation_columns == 4){
		$available_heights = array("1", "2", "3", "4");
	}else if ($presentation_columns == 5){
		$available_heights = array("1", "2", "3", "4", "5");
	}else if ($presentation_columns == 6){
		$available_heights = array("1", "2", "3", "4", "5", "6");
	}else {
		$available_heights = array("1");
	}
	return $available_heights;
}
endif;

if (!function_exists("wall_get_available_templates")):
/**
 * retrieve available templates
*/
function wall_get_available_templates(){
	$templates = array("thumb", "content");
	if (woodkit_is_registered_tool('video'))
		$templates[] = "video";
	$templates = apply_filters("woodkit-tool-wall-available-templates", $templates);
	return $templates;
}
endif;

if (!function_exists("wall_get_default_template")):
/**
 * retrieve default templates for specified post
* @param number $post_id
* @return string
*/
function wall_get_default_template($post_id = null){
	if ($post_id == null)
		$post_id = get_the_ID();
	$template = "content";
	if (woodkit_is_registered_tool('video') && video_has_featured_video($post_id)){
		$template = "video";
	}else if (has_post_thumbnail($post_id)){
		$template = "thumb";
	}
	$template = apply_filters("woodkit-tool-wall-default-template", $template, $post_id);
	return $template;
}
endif;

if (!function_exists("wall_secure_meta_values")):
/**
 * securize all wall meta values
* @param string $template_name
*/
function wall_securize_meta_values($values = array()){
	if (!isset($values['meta_wall_display_presentation_format']))
		$values['meta_wall_display_presentation_format'] = "square";
	if (!isset($values['meta_wall_display_presentation_initial_height']) || !is_numeric($values['meta_wall_display_presentation_initial_height']))
		$values['meta_wall_display_presentation_initial_height'] = 250;
	if (!isset($values['meta_wall_display_presentation_slider_carousel_item_width']) || !is_numeric($values['meta_wall_display_presentation_slider_carousel_item_width']))
		$values['meta_wall_display_presentation_slider_carousel_item_width'] = 250;
	if (!isset($values['meta_wall_display_presentation_slider_carousel_item_margin']) || !is_numeric($values['meta_wall_display_presentation_slider_carousel_item_margin']))
		$values['meta_wall_display_presentation_slider_carousel_item_margin'] = 5;
	if (!isset($values['meta_wall_display_presentation_slider_carousel_columns']) || !is_numeric($values['meta_wall_display_presentation_slider_carousel_columns']))
		$values['meta_wall_display_presentation_slider_carousel_columns'] = 3;
	if (!isset($values['meta_wall_display_presentation_columns']) || !is_numeric($values['meta_wall_display_presentation_columns']))
		$values['meta_wall_display_presentation_columns'] = 3;
	if (!isset($values['meta_wall_display_presentation_masonry_width']) || ($values['meta_wall_display_presentation_masonry_width'] != 'customized' && !is_numeric($values['meta_wall_display_presentation_masonry_width'])))
		$values['meta_wall_display_presentation_masonry_width'] = 4;
	if (isset($values['meta_wall_display_presentation_setup']) && !empty($values['meta_wall_display_presentation_setup'])){
		$values['meta_wall_display_presentation_setup'] = stripslashes($values['meta_wall_display_presentation_setup']);
		$values['meta_wall_display_presentation_setup'] = json_decode($values['meta_wall_display_presentation_setup'], true);
	}
	// old version support
	if (!empty($wall_args['meta_wall_display_presentation_filtering']) && $wall_args['meta_wall_display_presentation_filtering'] == 'on'){
		$wall_args['meta_wall_display_presentation_filtering'] = 'tax';
	}
	return $values;
}
endif;

if (!function_exists("wall_secure_meta_values")):
/**
 * sanitize post classes for a wall item (used by each wall item) - delete 'post' / 'hentry' classes
* @param string $classes - sainitized classes
*/
function wall_sanitize_wall_item_classes($classes){
	$classes = str_replace("post", " ", $classes);
	$classes = str_replace("hentry", " ", $classes);
	return $classes;
}
endif;

add_action('vc_before_init', 'tool_wall_visual_composer_support' );
/**
 * Visual Composer Wall shortcode support
*/
function tool_wall_visual_composer_support() {
	vc_map( array(
		"name" => __("Woodkit Wall", WOODKIT_PLUGIN_TEXT_DOMAIN),
		"base" => "woodkit_wall",
		"description" => __("Insert defined wall for this content", WOODKIT_PLUGIN_TEXT_DOMAIN),
		"class" => "",
		"category" => __("Content", WOODKIT_PLUGIN_TEXT_DOMAIN)
	) );
}

