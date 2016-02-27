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

define('SEO_NONCE_SEO_ACTION', 'seo_action');
define('SEO_OPTIONS_NAME', 'seo-options');

define('SEO_CUSTOMFIELD_METATITLE', 'seo-meta-title');
define('SEO_CUSTOMFIELD_METADESCRIPTION', 'seo-meta-description');
define('SEO_CUSTOMFIELD_METAKEYWORDS', 'seo-meta-keywords');
define('SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE', 'seo-meta-og-title');
define('SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION', 'seo-meta-og-description');
define('SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE', 'seo-meta-og-image');

if (!function_exists("seo_add_inner_meta_boxes")):
/**
 * This action is called by Woodkit when metabox is display on post-type
* @param unknown $post
*/
function seo_add_inner_meta_boxes($post){
	$available_posttypes = get_displayed_post_types();
	$available_posttypes = apply_filters("tool_seo_available_posttypes", $available_posttypes);
	if (in_array(get_post_type($post), $available_posttypes)){
		include(locate_ressource('/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/custom-fields/templates/seo.php'));
	}
}
add_action("customfields_add_inner_meta_boxes", "seo_add_inner_meta_boxes", 1000);
endif;

if (!function_exists("seo_save_post")):
/**
 * This action is called by Woodkit when post-type is saved
* @param int $post_id
*/
function seo_save_post($post_id){
	$available_posttypes = get_displayed_post_types();
	$available_posttypes = apply_filters("tool_seo_available_posttypes", $available_posttypes);
	if (in_array($_POST['post_type'], $available_posttypes)){
		// SEO_CUSTOMFIELD_METATITLE
		if (!empty($_POST[SEO_CUSTOMFIELD_METATITLE])){
			update_post_meta($post_id, SEO_CUSTOMFIELD_METATITLE, sanitize_text_field($_POST[SEO_CUSTOMFIELD_METATITLE]));
		}else{
			delete_post_meta($post_id, SEO_CUSTOMFIELD_METATITLE);
		}
		
		// SEO_CUSTOMFIELD_METADESCRIPTION
		if (!empty($_POST[SEO_CUSTOMFIELD_METADESCRIPTION])){
			update_post_meta($post_id, SEO_CUSTOMFIELD_METADESCRIPTION, sanitize_text_field($_POST[SEO_CUSTOMFIELD_METADESCRIPTION]));
		}else{
			delete_post_meta($post_id, SEO_CUSTOMFIELD_METADESCRIPTION);
		}
		
		// SEO_CUSTOMFIELD_METAKEYWORDS
		if (!empty($_POST[SEO_CUSTOMFIELD_METAKEYWORDS])){
			update_post_meta($post_id, SEO_CUSTOMFIELD_METAKEYWORDS, sanitize_text_field($_POST[SEO_CUSTOMFIELD_METAKEYWORDS]));
		}else{
			delete_post_meta($post_id, SEO_CUSTOMFIELD_METAKEYWORDS);
		}
		
		// SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE
		if (!empty($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE])){
			update_post_meta($post_id, SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE, sanitize_text_field($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE]));
		}else{
			delete_post_meta($post_id, SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE);
		}
		
		// SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION
		if (!empty($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION])){
			update_post_meta($post_id, SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION, sanitize_text_field($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION]));
		}else{
			delete_post_meta($post_id, SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION);
		}
		
		// SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE
		if (!empty($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE])){
			update_post_meta($post_id, SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE, sanitize_text_field($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE]));
		}else{
			delete_post_meta($post_id, SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE);
		}
	}
}
add_action("customfields_save_post", "seo_save_post");
endif;


if (!function_exists("seo_add_taxonomy_fields")):
/**
 * Hooks the WP taxonomyname_edit_fields action to add metaboxe seo on term
*
* @return void
*/
function seo_add_taxonomy_fields($term) {
	include(locate_ressource('/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/custom-fields/templates/seo-term.php'));
}
endif;

if (!function_exists("seo_save_taxonomy_fields")):
/**
 * save seo category extra fields
*/
function seo_save_taxonomy_fields($term_id) {
	// SEO_CUSTOMFIELD_METATITLE
	if (!empty($_POST[SEO_CUSTOMFIELD_METATITLE])){
		update_option("term_".$term_id."_".SEO_CUSTOMFIELD_METATITLE, sanitize_text_field($_POST[SEO_CUSTOMFIELD_METATITLE]));
	}else{
		delete_option("term_".$term_id."_".SEO_CUSTOMFIELD_METATITLE);
	}
	// SEO_CUSTOMFIELD_METADESCRIPTION
	if (!empty($_POST[SEO_CUSTOMFIELD_METADESCRIPTION])){
		update_option("term_".$term_id."_".SEO_CUSTOMFIELD_METADESCRIPTION, sanitize_text_field($_POST[SEO_CUSTOMFIELD_METADESCRIPTION]));
	}else{
		delete_option("term_".$term_id."_".SEO_CUSTOMFIELD_METADESCRIPTION);
	}
	// SEO_CUSTOMFIELD_METAKEYWORDS
	if (!empty($_POST[SEO_CUSTOMFIELD_METAKEYWORDS])){
		update_option("term_".$term_id."_".SEO_CUSTOMFIELD_METAKEYWORDS, sanitize_text_field($_POST[SEO_CUSTOMFIELD_METAKEYWORDS]));
	}else{
		delete_option("term_".$term_id."_".SEO_CUSTOMFIELD_METAKEYWORDS);
	}
	// SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE
	if (!empty($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE])){
		update_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE, sanitize_text_field($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE]));
	}else{
		delete_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_TITLE);
	}
	// SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION
	if (!empty($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION])){
		update_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION, sanitize_text_field($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION]));
	}else{
		delete_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_DESCRIPTION);
	}
	// SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE
	if (!empty($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE])){
		update_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE, sanitize_text_field($_POST[SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE]));
	}else{
		delete_option("term_".$term_id."_".SEO_CUSTOMFIELD_META_OPENGRAPH_IMAGE);
	}
}
endif;

if (!function_exists("seo_registered_taxonomy")):
/**
 * add seo on woodkit taxonomy extra fields
 */
function seo_registered_taxonomy($taxonomy){
	$seo_exludes_taxonomies = array("post_tag", "nav_menu", "link_category", "post_format");
	if (!in_array($taxonomy, $seo_exludes_taxonomies)){
		add_action($taxonomy.'_edit_form_fields', 'seo_add_taxonomy_fields');
		add_action('edited_'.$taxonomy, 'seo_save_taxonomy_fields');
	}
}
add_action('registered_taxonomy', 'seo_registered_taxonomy');
endif;
