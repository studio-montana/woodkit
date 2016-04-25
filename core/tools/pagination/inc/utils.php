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

if (!function_exists("pagination")):
/**
 * construct HTML link of previous and next posts from current post
* @param array $args : wp_query arguments
* @param string $display : echo result, return result otherwise
* @param string $before_links : displayed before tags
* @param string $after_links : displayed after tags
* @param string $text_link_previous : replace post title in previous link
* @param string $text_link_next : replace post title in next link
* @param string $before_previous_link : displayed before previous a tag
* @param string $after_previous_link : displayed after previous a tag
* @param string $before_next_link : displayed before next a tag
* @param string $after_next_link : displayed after next a tag
* @return string : HTML link
*/
function woodkit_pagination($args = array(), $display = true, $before_links = '', $after_links = '', $text_link_previous = '', $text_link_next = '', $before_previous_link = '', $after_previous_link = '', $before_next_link = '', $after_next_link = ''){
	$meta_display_pagination = get_post_meta(get_the_ID(), META_PAGINATION_DISPLAY_PAGINATION, true);
	if (empty($meta_display_pagination) || $meta_display_pagination == 'on'){
		
		// content args
		$content_args = array();
		$content_args['before_links'] = $before_links;
		$content_args['after_links'] = $after_links;
		$content_args['text_link_previous'] = $text_link_previous;
		$content_args['text_link_next'] = $text_link_next;
		$content_args['before_previous_link'] = $before_previous_link;
		$content_args['after_previous_link'] = $after_previous_link;
		$content_args['before_next_link'] = $before_next_link;
		$content_args['after_next_link'] = $after_next_link;
		$content_args = apply_filters("woodkit_pagination_content_args", $content_args);
		$before_links = $content_args['before_links'];
		$after_links = $content_args['after_links'];
		$text_link_previous = $content_args['text_link_previous'];
		$text_link_next = $content_args['text_link_next'];
		$before_previous_link = $content_args['before_previous_link'];
		$after_previous_link = $content_args['after_previous_link'];
		$before_next_link = $content_args['before_next_link'];
		$after_next_link = $content_args['after_next_link'];
		
		$res = '';
		$type = get_post_type();
		if (!empty($type)){

			$args['post_type'] = $type;
			if (empty($args['orderby']))
				$args['orderby'] = "date";
			if (empty($args['order']))
				$args['order'] = 'DESC';
			if (empty($args['numberposts']))
				$args['numberposts'] = -1;
			if (empty($args['suppress_filters']))
				$args['suppress_filters'] = FALSE; // keep current language posts (WPML compatibility)
			$args['post_parent'] = wp_get_post_parent_id(get_the_ID()); // keep hierarchical context... navigate only in brothers

			$post_types = get_posts($args);
			$prev = null;
			$next = null;
			$stop = false;
			$first = null;
			$last = null;
			foreach ($post_types as $p){
				if ($first == null)
					$first = $p;
				if (!$stop){
					if (get_the_ID() == $p->ID)
						$stop = true;
					else
						$prev = $p;
				}else{
					if ($next == null)
						$next = $p;
				}
				$last = $p;
			}

			if ($prev == null && $last != null && $last->ID != get_the_ID()){
				$prev = $last;
			}
			if ($prev != null){
				$res .= $before_previous_link.'<a class="pagination pagination-previous" href="'.get_the_permalink($prev->ID).'">';
				if (!empty($text_link_previous)){
					$res .= $text_link_previous;
				}else{
					$res .= $prev->post_title;
				}
				$res .= '</a>'.$after_previous_link;
			}

			if ($next == null && $first != null && $first->ID != get_the_ID()){
				$next = $first;
			}
			if ($next != null){
				$res .= $before_next_link.'<a class="pagination pagination-next" href="'.get_the_permalink($next->ID).'">';
				if (!empty($text_link_next)){
					$res .= $text_link_next;
				}else{
					$res .= $next->post_title;
				}
				$res .= '</a>'.$after_next_link;
			}
		}

		$res = $before_links.$res.$after_links;

		if ($display)
			echo $res;
		else
			return $res;
	}
}
endif;