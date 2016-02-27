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

define('SEO_DEFAULT_METATITLE', 'seo-default-metatitle');
define('SEO_DEFAULT_METADESCRIPTION', 'seo-default-metadescription');
define('SEO_DEFAULT_METAKEYWORDS', 'seo-default-metakeywords');


if (!function_exists("seo_document_title_parts")):
/**
 * Filter the site meta title.
*/
function seo_document_title_parts($title) {
	$queried_object = get_queried_object();
	if (is_category() || is_tax()){
		if (is_category()){
			$categories = get_the_category();
			$term_id = $categories[0]->cat_ID;
		}else if(is_tax()){
			$term_id =  (int) $queried_object->term_id;
		}
		if (!empty($term_id)){
			$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_METATITLE));
			if (!empty($meta_data_cat)){
				$title['title'] = $meta_data_cat;
			}
		}
	}
	else{
		if ($queried_object){
			// meta title
			$meta_data = get_post_meta($queried_object->ID, SEO_CUSTOMFIELD_METATITLE, true);
			if (!empty($meta_data)){
				$title['title'] = $meta_data;
			}
		}
	}
	return $title;
}
add_filter('document_title_parts', 'seo_document_title_parts', 100, 3);
endif;


if (!function_exists("seo_wp_title")):
/**
 * Filter the site meta title.
*/
function seo_wp_title($title, $sep, $seplocation) {
	return seo_get_metatitle($sep, false);
}
add_filter('wp_title', 'seo_wp_title', 100, 3);
endif;

if (!function_exists("seo_get_metatitle")):
/**
 * seo_get_metatitle
*/
function seo_get_metatitle($sep = " | ", $display = true) {
	global $paged, $page;
	$title = "";
	$prefix = " $sep ";
	$queried_object = get_queried_object();
	$blogname = get_bloginfo('name');
	if (is_category() || is_tax()){
		if (is_category()){
			$categories = get_the_category();
			$term_id = $categories[0]->cat_ID;
		}else if(is_tax()){
			$term_id =  (int) $queried_object->term_id;
		}
		if (!empty($term_id)){
			$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_METATITLE));
			if (!empty($meta_data_cat)){
				$title = $meta_data_cat;
			}
		}
	}
	else{
		if ($queried_object){
			// meta title
			$meta_data = get_post_meta($queried_object->ID, SEO_CUSTOMFIELD_METATITLE, true);
			if (!empty($meta_data)){
				$title = $meta_data;
			}
			// post title
			else{
				$post_title = get_the_title($queried_object->ID);
				if (!empty($post_title)){
					$title = $post_title;
				}
			}
		}
	}
	// default value
	if (empty($title)){
		$title = $blogname;
	}else{
		$title .= "$sep$blogname";
	}
	// Add a page number if necessary.
	if ($paged >= 2 || $page >= 2 )
		$title = "$title$sep" . sprintf( __( 'page %s', WOODKIT_PLUGIN_TEXT_DOMAIN ), max( $paged, $page ) );
	// result
	if ($display)
		echo $title;
	else
		return $title;
}
add_action("get_metatitle", "seo_get_metatitle");
endif;

if (!function_exists("woodkit_seo_get_metadescription")):
/**
 * woodkit_seo_get_metadescription
*/
function woodkit_seo_get_metadescription($display = true) {
	$description = '';
	if (is_category() || is_tax()){
		if (is_category()){
			$categories = get_the_category();
			$term_id = $categories[0]->cat_ID;
		}else if(is_tax()){
			$queried_object = get_queried_object();
			$term_id =  (int) $queried_object->term_id;
		}
		if (!empty($term_id)){
			$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_METADESCRIPTION));
			if (!empty($meta_data_cat)){
				$description = $meta_data_cat;
			}
		}
	}else{
		$_queried_post = get_queried_object();
		if ($_queried_post){
			$meta_data = get_post_meta($_queried_post->ID, SEO_CUSTOMFIELD_METADESCRIPTION, true);
			if (!empty($meta_data)){
				$description = $meta_data;
			}
		}
	}

	// default value
	if (empty($description)){
		$description = get_bloginfo('description', 'display');
	}

	// result
	if ($display)
		echo esc_attr($description);
	else
		return esc_attr($description);
}
add_action("woodkit_seo_get_metadescription", "woodkit_seo_get_metadescription");
endif;

if (!function_exists("woodkit_seo_get_metakeywords")):
/**
 * woodkit_seo_get_metakeywords
*/
function woodkit_seo_get_metakeywords($display = true) {
	$keywords = '';
	if (is_category() || is_tax()){
		if (is_category()){
			$categories = get_the_category();
			$term_id = $categories[0]->cat_ID;
		}else if(is_tax()){
			$queried_object = get_queried_object();
			$term_id =  (int) $queried_object->term_id;
		}
		if (!empty($term_id)){
			$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_METAKEYWORDS));
			if (!empty($meta_data_cat)){
				$keywords = $meta_data_cat;
			}
		}
	}else {
		$_queried_post = get_queried_object();
		if ($_queried_post){
			$meta_data = get_post_meta($_queried_post->ID, SEO_CUSTOMFIELD_METAKEYWORDS, true);
			if (!empty($meta_data)){
				$keywords = $meta_data;
			}
		}
	}

	// default value
	if (empty($keywords)){
		// none
	}

	// result
	if ($display)
		echo esc_attr($keywords);
	else
		return esc_attr($keywords);
}
add_action("woodkit_seo_get_metakeywords", "woodkit_seo_get_metakeywords");
endif;

if (!function_exists("woodkit_seo_get_meta_publication_type")):
/**
 * woodkit_seo_get_meta_publication_type
*/
function woodkit_seo_get_meta_publication_type($display = true) {
	$opengraph_content = '';

	if (is_home() || is_front_page()){
		$opengraph_content = "website";
	}else{
		$opengraph_content = "article";
	}

	// result
	if ($display)
		echo esc_attr($opengraph_content);
	else
		return esc_attr($opengraph_content);
}
add_action("woodkit_seo_get_meta_publication_type", "woodkit_seo_get_meta_publication_type");
endif;

if (!function_exists("woodkit_seo_get_meta_publication_card")):
/**
 * woodkit_seo_get_meta_publication_card
*/
function woodkit_seo_get_meta_publication_card($display = true) {
	$opengraph_content = 'summary';

	// result
	if ($display)
		echo esc_attr($opengraph_content);
	else
		return esc_attr($opengraph_content);
}
add_action("woodkit_seo_get_meta_publication_card", "woodkit_seo_get_meta_publication_card");
endif;

if (!function_exists("woodkit_seo_get_meta_publication_url")):
/**
 * woodkit_seo_get_meta_publication_url
*/
function woodkit_seo_get_meta_publication_url($display = true) {
	$opengraph_content = get_current_url(true);

	// result
	if ($display)
		echo esc_attr($opengraph_content);
	else
		return esc_attr($opengraph_content);
}
add_action("woodkit_seo_get_meta_publication_url", "woodkit_seo_get_meta_publication_url");
endif;

if (!function_exists("woodkit_seo_get_meta_publication_title")):
/**
 * woodkit_seo_get_meta_publication_title
*/
function woodkit_seo_get_meta_publication_title($display = true) {
	$opengraph_content = '';
	$sep = " | ";
	if (is_category() || is_tax()){
		if (is_category()){
			$categories = get_the_category();
			$term_id = $categories[0]->cat_ID;
		}else if(is_tax()){
			$queried_object = get_queried_object();
			$term_id =  (int) $queried_object->term_id;
		}
		if (!empty($term_id)){
			$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE));
			if (!empty($meta_data_cat)){
				$opengraph_content = $meta_data_cat;
			}else{ // default
				$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_METATITLE));
				if (!empty($meta_data_cat)){
					$opengraph_content = $meta_data_cat;
				}
			}
		}
	}else{
		$_queried_post = get_queried_object();
		if ($_queried_post){
			$meta_data = get_post_meta($_queried_post->ID, SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE, true);
			if (!empty($meta_data)){
				$opengraph_content = $meta_data;
			}else{ // default
				$meta_data = get_post_meta($_queried_post->ID, SEO_CUSTOMFIELD_METATITLE, true);
				if (!empty($meta_data)){
					$opengraph_content = $meta_data;
				}
			}
		}
	}
	// default
	if (empty($opengraph_content)){
		$opengraph_content = seo_get_metatitle($sep, false);
	}else{
		$blogname = get_bloginfo('name');
		if (!empty($blogname))
			$opengraph_content .= $sep.$blogname;
	}

	// result
	if ($display)
		echo esc_attr($opengraph_content);
	else
		return esc_attr($opengraph_content);
}
add_action("woodkit_seo_get_meta_publication_title", "woodkit_seo_get_meta_publication_title");
endif;

if (!function_exists("woodkit_seo_get_meta_publication_description")):
/**
 * woodkit_seo_get_meta_publication_description
*/
function woodkit_seo_get_meta_publication_description($display = true) {
	$opengraph_content = '';
	if (is_category() || is_tax()){
		if (is_category()){
			$categories = get_the_category();
			$term_id = $categories[0]->cat_ID;
		}else if(is_tax()){
			$queried_object = get_queried_object();
			$term_id =  (int) $queried_object->term_id;
		}
		if (!empty($term_id)){
			$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION));
			if (!empty($meta_data_cat)){
				$opengraph_content = $meta_data_cat;
			}else{ // default
				$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_METADESCRIPTION));
				if (!empty($meta_data_cat)){
					$opengraph_content = $meta_data_cat;
				}
			}
		}
	}else{
		$_queried_post = get_queried_object();
		if ($_queried_post){
			$meta_data = get_post_meta($_queried_post->ID, SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION, true);
			if (!empty($meta_data)){
				$opengraph_content = $meta_data;
			}else{ // default
				$meta_data = get_post_meta($_queried_post->ID, SEO_CUSTOMFIELD_METADESCRIPTION, true);
				if (!empty($meta_data)){
					$opengraph_content = $meta_data;
				}
			}
		}
	}
	// default
	if (empty($opengraph_content)){
		$opengraph_content = get_bloginfo('description', 'display');
	}

	// result
	if ($display)
		echo esc_attr($opengraph_content);
	else
		return esc_attr($opengraph_content);
}
add_action("woodkit_seo_get_meta_publication_description", "woodkit_seo_get_meta_publication_description");
endif;

if (!function_exists("woodkit_seo_get_meta_publication_image")):
/**
 * woodkit_seo_get_meta_publication_image
*/
function woodkit_seo_get_meta_publication_image($display = true) {
	$opengraph_content = '';
	if (is_category() || is_tax()){
		if (is_category()){
			$categories = get_the_category();
			$term_id = $categories[0]->cat_ID;
		}else if(is_tax()){
			$queried_object = get_queried_object();
			$term_id =  (int) $queried_object->term_id;
		}
		if (!empty($term_id)){
			$meta_data_cat = stripslashes(get_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE));
			if (!empty($meta_data_cat)){
				$opengraph_content = $meta_data_cat;
			}
		}
	}else{
		$_queried_post = get_queried_object();
		if ($_queried_post){
			$meta_data = get_post_meta($_queried_post->ID, SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE, true);
			if (!empty($meta_data)){
				$opengraph_content = $meta_data;
			}else{ // default (post thumbnail)
				if (has_post_thumbnail($_queried_post->ID)){
					$thumb_id = get_post_thumbnail_id($_queried_post->ID);
					$thumb = wp_get_attachment_image_src($thumb_id, 'tool-seo-thumb');
					if ($thumb) {
						list($thumb_src, $thumb_width, $thumb_height) = $thumb;
						if (!empty($thumb_src)){
							$opengraph_content = $thumb_src;
						}
					}
				}
			}
		}
	}

	if (empty($opengraph_content)){
		$url_logo = get_theme_mod('logo_image'); // site-logo
		if (!empty($url_logo)){
			$opengraph_content = $url_logo;
		}else{ // default (theme screenshot)
			if (file_exists(get_stylesheet_directory().'/screenshot.png'))
				$opengraph_content = get_stylesheet_directory_uri().'/screenshot.png';
			else if (file_exists(get_template_directory().'/screenshot.png'))
				$opengraph_content = get_template_directory_uri().'/screenshot.png';
		}
	}

	// result
	if ($display)
		echo esc_attr($opengraph_content);
	else
		return esc_attr($opengraph_content);
}
add_action("woodkit_seo_get_meta_publication_image", "woodkit_seo_get_meta_publication_image");
endif;

function seo_header(){
	?>
<meta
	name="description"
	content="<?php do_action('woodkit_seo_get_metadescription', true); ?>">
<meta
	name="keywords"
	content="<?php do_action('woodkit_seo_get_metakeywords', true); ?>">
<meta
	property="og:type"
	content="<?php do_action('woodkit_seo_get_meta_publication_type', true); ?>">
<meta
	property="og:url"
	content="<?php do_action('woodkit_seo_get_meta_publication_url', true); ?>">
<meta
	property="og:title"
	content="<?php do_action('woodkit_seo_get_meta_publication_title', true); ?>">
<meta
	property="og:description"
	content="<?php do_action('woodkit_seo_get_meta_publication_description', true); ?>">
<meta
	property="og:image"
	content="<?php do_action('woodkit_seo_get_meta_publication_image', true); ?>">
<meta
	name="twitter:card"
	content="<?php do_action('woodkit_seo_get_meta_publication_card', true); ?>">
<meta
	name="twitter:url"
	content="<?php do_action('woodkit_seo_get_meta_publication_url', true); ?>">
<meta
	name="twitter:title"
	content="<?php do_action('woodkit_seo_get_meta_publication_title', true); ?>">
<meta
	name="twitter:description"
	content="<?php do_action('woodkit_seo_get_meta_publication_description', true); ?>">
<meta
	name="twitter:image"
	content="<?php do_action('woodkit_seo_get_meta_publication_image', true); ?>">
<?php
}
add_action('wp_head', 'seo_header');