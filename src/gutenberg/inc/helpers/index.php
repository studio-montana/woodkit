<?php
defined('ABSPATH') or die("Go Away!");

/**********************************************************************************************************
	General
**********************************************************************************************************/

/**
 * Merge user defined arguments into defaults array.
 *
 * This function is used throughout WordPress to allow for both string or array
 * to be merged into another array.
 *
 * @since 2.2.0
 * @since 2.3.0 `$args` can now also be an object.
 *
 * @param string|array|object $args     Value to merge with $defaults.
 * @param array               $defaults Optional. Array that serves as the defaults. Default empty.
 * @return array Merged user defined values with defaults.
 */
function wkg_parse_args($args, $defaults = '', $slice_additionnals = false) {
	$args = wp_parse_args($args, $defaults);
	if ($slice_additionnals) {
		$final_args = array();
		foreach ($args as $key => $value) {
			if (isset($defaults[$key])) {
				$final_args[$key] = $value;
			}
		}
		return $final_args;
	}
	return $args;
}

/**********************************************************************************************************
	Posts Options
**********************************************************************************************************/

function wkg_get_all_posts_options () {
	$options = array();
	if (function_exists('get_displayed_post_types')) {
		$available_post_types = get_displayed_post_types(true); // woodkit dependency
		if (!empty($available_post_types)) {
			foreach ($available_post_types as $postype) {
				$posts_options = wkg_get_posts_options($postype);
				if (!empty($posts_options)) {
					$post_type_label = get_post_type_labels(get_post_type_object($postype));
					$options[] = array('value' => $postype, 'label' => $post_type_label->name, 'disabled' => true);
					$options = array_merge($options, $posts_options);
				}
			}
		}
	}
	return $options;
}

/**
 * Retrieve posts options as array
 * @param  string $post_type [description]
 * @return array            [description]
 */
function wkg_get_posts_options ($post_type = 'post') {
	$options = array();
	$args = array(
		'post_type' => $post_type,
		'numberposts' => '-1'
	);
	if (is_post_type_hierarchical($post_type)) {
		$args['post_parent'] = 0;
	}
	$posts = get_posts($args);
	if (!empty($posts)) {
		foreach ($posts as $post) {
			wkg_add_post_option($options, $post);
		}
	}
	return $options;
}

/**
 * Add post option to specified array (including children if hierarchical)
 * @param array  $options [description]
 * @param object  $post    [description]
 * @param integer $level   [description]
 */
function wkg_add_post_option(&$options, $post, $level = 0){
	$level_string = '';
	for ($i = 0; $i < $level ; $i++){
		$level_string .= '-';
	}
	$options[] = array('value' => $post->ID, 'label' => $level_string . ' ' . $post->post_title);
	if (is_post_type_hierarchical(get_post_type($post))){
		$children = get_posts(array('post_type' => get_post_type($post), 'post_parent' => $post->ID, 'numberposts' => '-1'));
		if (!empty($children)){
			$level ++;
			foreach ($children as $child){
				wkg_add_post_option($options, $child, $level);
			}
		}
	}
}

/**********************************************************************************************************
	Terms Options
**********************************************************************************************************/

function wkg_get_all_terms_options () {
	$options = array();
	$taxonomies = get_taxonomies(array('public' => true), 'objects', 'and');
	if (!empty($taxonomies)) {
		foreach ($taxonomies as $tax) {
			$terms_options = wkg_get_terms_options(array('taxonomy' => $tax->name));
			if (!empty($terms_options)) {
				$options[] = array('value' => $tax->name, 'label' => $tax->label, 'disabled' => true);
				$options = array_merge($options, $terms_options);
			}
		}
	}
	return $options;
}

/**
 * Retrieve term options as array
 * @param  array  $args [description]
 * @return array       [description]
 */
function wkg_get_terms_options ($args = array()) {
	$options = array();
	if (isset($args['post_type'])) {
		$taxonomies = get_object_taxonomies($args['post_type'], 'objects');
		if (!empty($taxonomies)) {
			foreach ($taxonomies as $tax) {
				$options[] = array('value' => $tax->name, 'label' => $tax->label, 'disabled' => true);
				wkg_add_taxonomy_terms_options($options, $tax->name, 1);
			}
		}
	} else if (isset($args['taxonomy'])) {
		wkg_add_taxonomy_terms_options($options, $args['taxonomy']);
	}
	return $options;
}

/**
 * Add taxonomy terms options to specified array (including children if hierarchical)
 * @param array  $options [description]
 * @param object  $term    [description]
 * @param integer $level   [description]
 */
function wkg_add_taxonomy_terms_options(&$options, $taxonomy, $level = 0){
	$term_args = array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
	);
	if (is_taxonomy_hierarchical($taxonomy)){
		$term_args['parent'] = 0;
	}
	$terms = get_terms($term_args);
	if (!empty($terms)) {
		foreach ($terms as $term) {
			wkg_add_term_option($options, $term, $level);
		}
	}
}

/**
 * Add term option to specified array (including children if hierarchical)
 * @param array  $options [description]
 * @param object  $term    [description]
 * @param integer $level   [description]
 */
function wkg_add_term_option(&$options, $term, $level = 0){
	$level_string = '';
	for ($i = 0; $i < $level ; $i++){
		$level_string .= '-';
	}
	$options[] = array('value' => $term->term_id, 'label' => $level_string . ' ' . $term->name);
	if (is_taxonomy_hierarchical($term->taxonomy)){
		$children = get_terms(array('taxonomy' => $term->taxonomy, 'hide_empty' => false, 'parent' => $term->term_id));
		if (!empty($children)){
			$level ++;
			foreach ($children as $child){
				wkg_add_term_option($options, $child, $level);
			}
		}
	}
}
