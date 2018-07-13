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
 * REQUIREMENTS
*/
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.BREADCRUMB_TOOL_NAME.'/custom-fields/breadcrumb.php');

/**
 * Enqueue styles for the back end.
*/
function tool_breadcrumb_woodkit_admin_enqueue_styles_tools($dependencies) {

	$css_breadcrumb = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.BREADCRUMB_TOOL_NAME.'/css/tool-breadcrumb-admin.css');
	if (!empty($css_breadcrumb))
		wp_enqueue_style('tool-breadcrumb-admin-css', $css_breadcrumb, $dependencies, '1.0');

	$js_breadcrumb = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.BREADCRUMB_TOOL_NAME.'/js/tool-breadcrumb-admin.js');
	if (!empty($js_breadcrumb))
		wp_enqueue_script('tool-breadcrumb-admin-js', $js_breadcrumb, array('jquery'), '1.0', true);
}
add_action('woodkit_admin_enqueue_styles_tools', 'tool_breadcrumb_woodkit_admin_enqueue_styles_tools');

function tool_breadcrumb_get_the_title($post_id = null){
	if (empty($post_id))
		$post_id = get_the_ID();
	if (function_exists("woodkit_display_title"))
		return woodkit_display_title($post_id, false, false, '', '');
	else
		return get_the_title($post_id);
}

/**
 * retrieve or display breadcrumb
 * @param array $args {
 *     Optional.
 *     @type string		$seperator		displayed after each breadcrumb element, except the last
 *     @type string		$final			displayed after last breadcrumb item
 *     @type string		$home-item		displayed in place of home's breadcrumb item content
 * }
 * @param string $display : true to display, otherwise return result
 * @return string
 */
function tool_breadcrumb($args = array(), $display = true){
	
	$id_blog_page = get_option('page_for_posts');
	$id_front_page = get_option('page_on_front');

	$defaults = array(
			'before' => '',
			'after' => '',
			'seperator' => '<li class="separator"><i class="fa fa-caret-right"></i></li>',
			'final' => '<li class="final"></li>',
			'home-item' => __("Home", WOODKIT_PLUGIN_TEXT_DOMAIN)
	);
	$args = wp_parse_args($args, $defaults);

	$separator = $args['seperator'];
	$final = $args['final'];

	$res = $args['before'].'<ul class="tool-breadcrumb">';

	// -------------------- home
	$home_url = esc_url(home_url('/'));
	$home_class = " home";
	if (is_front_page()){ // site home page
		$res .= tool_breadcrumb_post_ancestors(get_the_ID(), $separator, array(get_the_ID()));
		$home_class .= " current";
	}
	$res .= '<li class="breadcrumb-item'.$home_class.'"><a href="'.$home_url.'" title="'.__("Home", WOODKIT_PLUGIN_TEXT_DOMAIN).'">'.$args['home-item'].'</a></li>';

	if (is_front_page()){ // site home page
		$res .= $final;
	}else if (!is_home()){ // site inner page
		$res .= $separator;
	}else { // site inner page
		$res .= $separator;
	}

	// -------------------- inner
	if (!is_front_page()){
		if (is_home() && !empty($id_front_page)) {
			if (!empty($id_blog_page) && is_numeric($id_blog_page)){
				$res .= tool_breadcrumb_post_ancestors($id_blog_page, $separator, array($id_blog_page));
				$res .= '<li class="breadcrumb-item current"><a href="'.get_permalink($id_blog_page).'" title="'.esc_attr(tool_breadcrumb_get_the_title($id_blog_page)).'">'.tool_breadcrumb_get_the_title($id_blog_page).'</a></li>'.$final;
			}
		}else if (is_single()) {
			if (get_post_type() == 'post'){ // blog article - display blog page if is different of front page and if front page is set
				if (!empty($id_blog_page) && is_numeric($id_blog_page) && !empty($id_front_page) && $id_blog_page != $id_front_page){
					$res .= tool_breadcrumb_post_ancestors($id_blog_page, $separator, array($id_blog_page));
					$res .= '<li class="breadcrumb-item current"><a href="'.get_permalink($id_blog_page).'" title="'.esc_attr(tool_breadcrumb_get_the_title($id_blog_page)).'">'.tool_breadcrumb_get_the_title($id_blog_page).'</a></li>'.$separator;
				}
			}
			$res .= tool_breadcrumb_post_ancestors(get_the_ID(), $separator, array(get_the_ID()));
			$res .= '<li class="breadcrumb-item current"><a href="'.get_the_permalink().'" title="'.esc_attr(tool_breadcrumb_get_the_title()).'">'.tool_breadcrumb_get_the_title().'</a></li>'.$final;
		}else if (is_category()) {
			$categories = get_the_category();
			$category_id = $categories[0]->cat_ID;
			$res .= tool_breadcrumb_term_ancestors($category_id, 'category', $separator);
			$res .= '<li class="breadcrumb-item current"><a href="'.get_the_permalink().'" title="'.get_cat_name($category_id).'">'.get_cat_name($category_id).'</a></li>'.$final;
		}else if (is_archive()){
			if (is_tax() || is_category() || is_tag() ){
				$current_term = get_queried_object();
				if (is_tax()){
					$res .= tool_breadcrumb_term_ancestors($current_term->term_id, 'typebancaservice', $separator);
				}else if(is_category()){
					$res .= tool_breadcrumb_term_ancestors($current_term->term_id, 'category', $separator);
				}
				$res .= '<li class="breadcrumb-item current"><a href="'.get_the_permalink().'" title="'.esc_attr($current_term->name).'">'.$current_term->name.'</a></li>'.$final;
			}
		}else if(is_page()) {
			$res .= tool_breadcrumb_post_ancestors(get_the_ID(), $separator, array(get_the_ID()));
			$res .= '<li class="breadcrumb-item current"><a href="'.get_the_permalink().'" title="'.esc_attr(tool_breadcrumb_get_the_title()).'">'.tool_breadcrumb_get_the_title().'</a></li>'.$final;
		}else if(is_404()){
			$res .= '<li class="breadcrumb-item current"><a href="'.get_the_permalink().'" title="'.esc_attr(tool_breadcrumb_get_the_title()).'">404</a></li>'.$final;
		}else if(is_search()){
			$res .= '<li class="breadcrumb-item current"><span title="'.esc_attr(tool_breadcrumb_get_the_title()).'">'.__('search',WOODKIT_PLUGIN_TEXT_DOMAIN).'</span></li>'.$final;
		}else if(is_tag()) {
			single_tag_title();
		}
		else if(is_day()) {
			$res .= '<li class="breadcrumb-item current">'.__('Archive ', WOODKIT_PLUGIN_TEXT_DOMAIN)." "; the_time('F jS, Y'); $res .= '</li>'.$final;
		}
		else if(is_month()) {
			$res .= '<li class="breadcrumb-item current">'.__('Archive ', WOODKIT_PLUGIN_TEXT_DOMAIN)." "; the_time('F, Y'); $res .= '</li>'.$final;
		}
		else if(is_year()) {
			$res .= '<li class="breadcrumb-item current">'.__('Archive ', WOODKIT_PLUGIN_TEXT_DOMAIN)." "; the_time('Y'); $res .= '</li>'.$final;
		}
		else if(is_author()) {
			$res .= '<li class="breadcrumb-item current">'.__('Author', WOODKIT_PLUGIN_TEXT_DOMAIN); $res .= '</li>'.$final;
		}
		else if(isset($_GET['paged']) && !empty($_GET['paged'])) {
			$res .= '<li class="breadcrumb-item current">'.__("Blog archives", WOODKIT_PLUGIN_TEXT_DOMAIN); $res .= '</li>'.$final;
		}
		else if(is_search()) {
			$res .= '<li class="breadcrumb-item current">'.__('Search results', WOODKIT_PLUGIN_TEXT_DOMAIN); $res .= '</li>'.$final;
		}
	}
	$res .= '</ul>'.$args['after'].'<div style="clear: both"></div>';

	if ($display == true){
		echo $res;
	}else{
		return $res;
	}
}

function tool_breadcrumb_post_ancestors($id_post, $separator, $existing_ids_in_breadcrumb = array()){
	$output = '';
	$breadcrumb_type = get_post_meta($id_post, META_BREADCRUMB_TYPE, true);
	if (!empty($breadcrumb_type) && $breadcrumb_type == 'customized'){
		$output .= tool_breadcrumb_customized_post_ancestors($id_post, $separator, $existing_ids_in_breadcrumb);
	}else{
		// classic breadcrumb
		$id_post_parent = wp_get_post_parent_id($id_post);
		if ($id_post_parent && is_numeric($id_post_parent) && !in_array($id_post_parent, $existing_ids_in_breadcrumb)){
			$existing_ids_in_breadcrumb[] = $id_post_parent;
			$output .= tool_breadcrumb_post_ancestors($id_post_parent, $separator, $existing_ids_in_breadcrumb);
			$output .= '<li class="breadcrumb-item"><a href="'.get_permalink($id_post_parent).'" title="'.esc_attr(tool_breadcrumb_get_the_title($id_post_parent)).'">'.tool_breadcrumb_get_the_title($id_post_parent).'</a></li>'.$separator;
		}
	}
	return $output;
}

function tool_breadcrumb_customized_post_ancestors($id_post, $separator, $existing_ids_in_breadcrumb = array()){
	$output = '';
	$breadcrumb_items = get_post_meta($id_post, META_BREADCRUMB_CUSTOM_ITEMS, true);
	if (!empty($breadcrumb_items)){
		$breadcrumb_items = json_decode($breadcrumb_items, true);
		if (!empty($breadcrumb_items)){
			foreach ($breadcrumb_items as $breadcrumb_item){
				$parts = explode("|", $breadcrumb_item);
				if (count($parts) == 3){
					$type = $parts[0];
					$type_slug = $parts[1];
					$id = $parts[2];
					if (!in_array($id, $existing_ids_in_breadcrumb)){
						if (!empty($type) && !empty($type_slug) && !empty($id) && is_numeric($id)){
							if ($type == 'post'){
								$post = get_post($id);
								if ($post){
									$existing_ids_in_breadcrumb[] = $id;
									$output .= tool_breadcrumb_post_ancestors($id, $separator, $existing_ids_in_breadcrumb);
									$output .= '<li class="breadcrumb-item"><a href="'.get_the_permalink($post).'">'.get_the_title($post).'</a></li>'.$separator;
								}
							}else if ($type == 'tax'){
								$term = get_term($id);
								if ($term){
									$output .= tool_breadcrumb_term_ancestors($id, $type_slug, $separator);
									$output .= '<li class="breadcrumb-item"><a href="'.get_term_link($term).'">'.$term->name.'</a></li>'.$separator;
								}
							}
						}
					}
				}
			}
		}
	}
	return $output;
}

function tool_breadcrumb_term_ancestors($id, $taxonomy, $separator){
	$output = '';
	$ancestors = get_ancestors($id, $taxonomy);
	if ($ancestors){
		sort($ancestors, -1);
		foreach ($ancestors as $ancestor ) {
			$term = get_term($ancestor, $taxonomy);
			$output .= '<li class="breadcrumb-item"><a href="'.get_term_link($term, $taxonomy).'" title="'.esc_attr($term->name).'">'.$term->name.'</a></li>'.$separator;
		}
	}
	return $output;
}

/**
 * Retrieve Breadcrumb Items Object relative to specified $id
 * @param int $id
 * @param string $type : 'post' | 'term' | 'tax'
 * @param array $breadcrumb_items
 * @param array $in_array_ids
 * @return array of BreadcrumbItem
 */
function tool_breadcrumb_get_items($id, $type = 'post', $breadcrumb_items = array(), $in_array_ids = array()) {
	if ($type === 'post' && !empty($id)) {
		$item_breadcrumb_type = get_post_meta ( $id, META_BREADCRUMB_TYPE, true );
		if (! empty ( $item_breadcrumb_type ) && $item_breadcrumb_type == 'customized') {
			$item_breadcrumb_items = get_post_meta($id, META_BREADCRUMB_CUSTOM_ITEMS, true);
			if (!empty($item_breadcrumb_items)){
				$item_breadcrumb_items = json_decode($item_breadcrumb_items, true);
				if (!empty($item_breadcrumb_items)){
					foreach ($item_breadcrumb_items as $item_breadcrumb_item){
						$parts = explode("|", $item_breadcrumb_item);
						if (count($parts) > 2){
							list($item_type, $item_type_slug, $item_id) = $parts;
							if (!in_array($item_breadcrumb_item, $in_array_ids)){
								$in_array_ids[] = $item_breadcrumb_item;
								if (!empty($item_type) && !empty($item_type_slug) && !empty($item_id) && is_numeric($item_id)){
									if ($item_type == 'post'){
										$post = get_post($item_id);
										if ($post){
											$breadcrumb_items = tool_breadcrumb_get_items($item_id, $item_type, $breadcrumb_items, $in_array_ids);
										}
									}else if ($item_type === 'tax' || $item_type === 'term'){
										$term = get_term($item_id);
										if ($term){
											$breadcrumb_items = tool_breadcrumb_get_items($item_id, $item_type, $breadcrumb_items, $in_array_ids);
										}
									}
								}
							}
						}
					}
				}
			}
		}else{
			$id_post_parent = wp_get_post_parent_id($id);
			if (!empty($id_post_parent)){
				$post_parent_breadcrumb_item = 'post|'.get_post_type($id_post_parent).'|'.$id_post_parent;
				if (!in_array($post_parent_breadcrumb_item, $in_array_ids)){
					$in_array_ids[] = $post_parent_breadcrumb_item;
					$post = get_post($id_post_parent);
					if ($post && !empty($id_post_parent)){
						$breadcrumb_items = tool_breadcrumb_get_items($id_post_parent, 'post', $breadcrumb_items, $in_array_ids);
					}
				}
			}
		}
		$breadcrumb_items[] = new BreadcrumbItem(get_post($id));
		
	} else if (($type === 'tax' || $type === 'term') && !empty($id)) {
		$term = WP_Term::get_instance($id);
		$ancestors = get_ancestors($id, $term->taxonomy);
		if ($ancestors){
			sort($ancestors, -1);
			foreach ($ancestors as $ancestor ) {
				$term = WP_Term::get_instance($ancestor, $term->taxonomy);
				if ($term){
					$breadcrumb_items[] = new BreadcrumbItem($term);
				}
			}
		}
		$breadcrumb_items[] = new BreadcrumbItem($term);
	}
	return $breadcrumb_items;
}

class BreadcrumbItem {

	public $id;
	public $slug;
	public $title;
	public $type;
	public $term_type;
	public $post_type;
	public $post;
	public $term;
	public $type_id;
	public $permalink;

	function __construct($wp_object){
		if (is_a($wp_object, 'WP_Term')){
			$this->id = $wp_object->term_id;
			$this->slug = $wp_object->slug;
			$this->title = $wp_object->name;
			$this->type = 'term';
			$this->term_type = $wp_object->taxonomy;
			$this->term = $wp_object;
			$this->type_id = 'term_'.$this->id;
			$this->permalink = get_term_link($this->term);
		}else if (is_a($wp_object, 'WP_Post')){
			$this->id = $wp_object->ID;
			$this->slug = $wp_object->post_name;
			$this->title = get_the_title($wp_object->ID);
			$this->type = 'post';
			$this->post_type = $wp_object->post_type;
			$this->post = $wp_object;
			$this->type_id = 'post_'.$this->id;
			$this->permalink = get_the_permalink($this->post);
		}
	}
}