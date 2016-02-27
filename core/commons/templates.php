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

if (!function_exists('woodkit_entry_meta') ) :
/**
 * Woodkit entry-meta
*
* @since Woodkit 1.0
* @return void
*/
function woodkit_entry_meta() {
	if (is_sticky() && is_home() && ! is_paged())
		echo '<span class="featured-post">' . __('Sticky', WOODKIT_PLUGIN_TEXT_DOMAIN) . '</span>';

	if (!has_post_format('link') && 'post' == get_post_type() )
		woodkit_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __(', ', WOODKIT_PLUGIN_TEXT_DOMAIN));
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list('', __(', ', WOODKIT_PLUGIN_TEXT_DOMAIN) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ('post' == get_post_type() ) {
		printf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta('ID') ) ),
		esc_attr( sprintf( __('View all posts by %s', WOODKIT_PLUGIN_TEXT_DOMAIN), get_the_author() ) ),
		get_the_author()
		);
	}
}
endif;

if (!function_exists('woodkit_entry_date')) :
/**
 * Woodkit entry-date
*
* @since Woodkit 1.0
* @return void
*/
function woodkit_entry_date($echo = true) {
	if (has_post_format( array('chat', 'status')))
		$format_prefix = _x('%1$s on %2$s', '1: post format name. 2: date', WOODKIT_PLUGIN_TEXT_DOMAIN);
	else
		$format_prefix = '%2$s';

	$date = sprintf('<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
			esc_url( get_permalink() ),
			esc_attr( sprintf( __('Permalink to %s', WOODKIT_PLUGIN_TEXT_DOMAIN), the_title_attribute('echo=0') ) ),
			esc_attr( get_the_date('c') ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

function woodkit_mini_excerpt_length( $length ) {
	return 10;
}


function woodkit_small_inter_excerpt_length( $length ) {
	return 20;
}


function woodkit_small_excerpt_length( $length ) {
	return 30;
}


function woodkit_normal_excerpt_length( $length ) {
	return 60;
}

function set_normal_excerpt_lenght(){
	add_filter( 'excerpt_length', 'woodkit_normal_excerpt_length', 999 );
}

function set_small_excerpt_lenght(){
	add_filter( 'excerpt_length', 'woodkit_small_excerpt_length', 999 );
}

function set_small_inter_excerpt_lenght(){
	add_filter( 'excerpt_length', 'woodkit_small_inter_excerpt_length', 999 );
}

function set_mini_excerpt_lenght(){
	add_filter( 'excerpt_length', 'woodkit_mini_excerpt_length', 999 );
}

function woodkit_new_excerpt_more( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'woodkit_new_excerpt_more');