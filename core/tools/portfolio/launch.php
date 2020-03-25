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
 * ajoute le post-type 'portfolio'
*/
function add_portfolio_post_type(){
	// woodkit post type
	$labels = array(
			'name'               => __('Portfolios', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'singular_name'      => __('Portfolio', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'add_new_item'       => __('Add Portfolio', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'edit_item'          => __('Edit Portfolio', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'new_item'           => __('New Portfolio', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'all_items'          => __('Portfolios', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'view_item'          => __('Look Portfolio', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'search_items'       => __('Search Portfolios', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'not_found'          => __('No Portfolio found', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'not_found_in_trash' => __('No Portfolio found in trash', WOODKIT_PLUGIN_TEXT_DOMAIN)
	);
	$args = array(
			'labels'             => $labels,
			'exclude_from_search' => false,
			'public' => true,
			'show_ui' => true,
			'menu_icon' => 'dashicons-format-gallery',
			'show_in_menu' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields', 'excerpt'),
			'rewrite'           => array('slug' => _x('portfolio', 'URL slug', WOODKIT_PLUGIN_TEXT_DOMAIN)),
			'show_in_rest' => true,
			'rest_base' => '',
	);
	register_post_type('portfolio', $args);

	// woodkit taxonomy
	$labels = array(
			'name'              => __('Portfolio Types', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'singular_name'     => __('Portfolio Type', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'search_items'      => __('Search Portfolio Type', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'all_items'         => __('All Portfolio Types', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'parent_item'       => __("Portfolio Type's parent", WOODKIT_PLUGIN_TEXT_DOMAIN),
			'parent_item_colon' => __("Portfolio Type's parent", WOODKIT_PLUGIN_TEXT_DOMAIN),
			'edit_item'         => __('Edit Portfolio Type', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'update_item'       => __('Update Portfolio Type', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'add_new_item'      => __('Add Portfolio Type', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'new_item_name'     => __('Name', WOODKIT_PLUGIN_TEXT_DOMAIN),
			'menu_name'         => __('Portfolio Type', WOODKIT_PLUGIN_TEXT_DOMAIN)
	);
	$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => _x('portfolio-type', 'URL slug', WOODKIT_PLUGIN_TEXT_DOMAIN)),
			"meta_box_cb" 		=> true,
			"show_in_rest" 		=> true,
	);
	register_taxonomy('portfoliotype', array( 'portfolio' ), $args);
}
add_action('init', 'add_portfolio_post_type', 100); // 100 => after Woodkit tools 'init'

if (!function_exists("define_portfolio_columns")):
/**
 * woodkit listing columns
*/
function define_portfolio_columns($columns){
	$columns["portfolio-thumb"] = __("Thumb", WOODKIT_PLUGIN_TEXT_DOMAIN);
	return $columns;
}
add_filter('manage_edit-portfolio_columns', 'define_portfolio_columns' );
endif;

if (!function_exists("build_portfolio_columns")):
/**
 * woodkit listing columns content
*/
function build_portfolio_columns($column, $post_id){
	switch($column){
		case "portfolio-thumb":
			if(has_post_thumbnail($post_id)){
				echo get_the_post_thumbnail($post_id, array("80", "120"));
			}
			break;
	}
}
add_action( 'manage_portfolio_posts_woodkit_column' , 'build_portfolio_columns', 10, 2 );
endif;

/**
 * renvoi les post-type portfolio
 * @param string $meta_args : permet de filtrer sur les post_meta
 * @return array
 */
function get_portfolio_post_types($meta_args = null, $args=array()){
	return get_post_types_by_type('portfolio', $meta_args, $args);
}

/**
 * construit les options (html) avec les portfolios existants
 * @param string $id_selected
 * @return string
 */
function get_portfolio_options($id_selected = null){
	$portfolios = get_portfolio_post_types(array(), array('post_parent' => 0));
	foreach ($portfolios as $portfolio){
		$res .= get_portfolio_option($portfolio, $id_selected, 0);
	}
	return $res;
}

/**
 * construit l'options (html) du portfolio spécifié et ses fils
 * @param unknown $portfolio
 * @param string $id_selected
 * @param number $level
 * @return string
 */
function get_portfolio_option($portfolio, $id_selected = null, $level = 0){
	$res = '';
	if ($id_selected == $portfolio->ID)
		$selected = ' selected="selected"';
	else
		$selected = '';
	$level_string = '';
	for ($i = 0; $i < $level ; $i++){
		$level_string .= '-';
	}
	$res .= '<option value="'.$portfolio->ID.'"'.$selected.'>'.$level_string.$portfolio->post_title.'</option>';
	$children = get_portfolio_post_types(array(), array('post_parent' => $portfolio->ID));
	if (!empty($children)){
		$level ++;
		foreach ($children as $child){
			$res .= get_portfolio_option($child, $id_selected, $level);
		}
	}
	return $res;
}