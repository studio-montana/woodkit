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
defined ( 'ABSPATH' ) or die ( "Go Away!" );

define ('SEO_TOOL_META_SEPARATOR', ' - ');
define ('SEO_TOOL_IMAGE_SIZE', 'medium');

/**
 * REQUIREMENTS
 */
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/custom-fields/seo-term.php');
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/xmlsitemap/xmlsitemap.php');
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/gutenberg/plugins/seometa/index.php');

/**
 * Enqueue scripts/styles for the back end.
 */
add_action('admin_enqueue_scripts', function () {
	wp_enqueue_script ( 'tool-seo-seourlsmanager-js', locate_web_ressource ( WOODKIT_PLUGIN_TOOLS_FOLDER . SEO_TOOL_NAME . '/js-seourlsmanager/js/admin-seourlsmanager.js' ), array ('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true );
	wp_enqueue_script ( 'tool-redirectsmanager-js', locate_web_ressource ( WOODKIT_PLUGIN_TOOLS_FOLDER . SEO_TOOL_NAME . '/js-redirectsmanager/js/admin-redirectsmanager.js' ), array ('jquery'), WOODKIT_PLUGIN_WEB_CACHE_VERSION, true );
}, 100);

/**
 * Redirections (301 permanent redirects)
 */
function woodkit_tool_seo_redirects() {
	if (!is_admin()) {
		$redirects = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "options-redirects");
		if (! empty ( $redirects ) && is_array ( $redirects )) {
			usort ( $redirects, "woodkit_cmp_options_sorted" );
			$currentrequest = str_ireplace ( get_option ( 'home' ), '', get_current_url () ); // remove domain
			// $currentrequest = rtrim($currentrequest,'/');
			$do_redirect = '';
			foreach ( $redirects as $redirect ) {
				if (! isset ( $redirect ['disable'] ) || empty ( $redirect ['disable'] ) || $redirect ['disable'] != 'on') {
					$fromurl = ! empty ( $redirect ['fromurl'] ) ? esc_attr ( $redirect ['fromurl'] ) : "";
					$tourl = ! empty ( $redirect ['tourl'] ) ? esc_attr ( $redirect ['tourl'] ) : "";
					$test = ! empty ( $redirect ['test'] ) ? esc_attr ( $redirect ['test'] ) : "";
					if (! empty ( $fromurl ) && ! empty ( $tourl ) && strpos ( $currentrequest, '/wp-login' ) !== 0 && strpos ( $currentrequest, '/wp-admin' ) !== 0 && strpos ( $currentrequest, '/wp-cron' ) !== 0) { // prevents people to accidentally lock themselves out of admin
						if (! empty ( $test ) && $test == 'matches') { // regex
							$fromurl = str_replace ( "@", "\@", $fromurl );
							$fromurl = "@{$fromurl}@i";
							if (preg_match ( $fromurl, $currentrequest, $matches )) {
								$do_redirect = $tourl;
								if (! empty ( $matches ) && count ( $matches ) > 0) { // replace dynamics values
									for($i = 1; $i < count ( $matches ); $i ++) {
										$do_redirect = str_replace ( "$" . $i, $matches [$i], $do_redirect );
									}
								}
								// clear all unreplaced dynamics values
								$do_redirect = preg_replace ( "@[$\d]@i", "", $do_redirect );
							}
						} else if (urldecode ( $currentrequest ) == rtrim ( $fromurl, '/' ) || urldecode ( $currentrequest ) == $fromurl) { // equals
							$do_redirect = $tourl;
						}
					}
				}
				if ($do_redirect !== '' && trim ( $do_redirect, '/' ) !== trim ( $currentrequest, '/' )) { // prevent simple loop
					if (strpos ( $do_redirect, '/' ) === 0) { // add domain if missing
						$do_redirect = home_url () . $do_redirect;
					}
					header ( 'HTTP/1.1 301 Moved Permanently' );
					header ( 'Location: ' . $do_redirect );
					exit ();
				} else {
					unset ( $redirects );
				}
			}
		}
	}
}
add_action ( 'init', 'woodkit_tool_seo_redirects', 100); // 100 => after Woodkit tools 'init'

/**
 * check if there is loop inside redirects - NOTICE : this doesn't matche regexp
*
* @param array $redirects
* @return boolean
*
*/
function seo_has_redirects_loop($redirects = array()) {
	$has_loop = false;
	if (! empty ( $redirects )) {
		foreach ( $redirects as $redirect_to ) {
			if (! isset ( $redirect_to ['disable'] ) || empty ( $redirect_to ['disable'] ) || $redirect_to ['disable'] != 'on') {
				$tourl = ! empty ( $redirect_to ['tourl'] ) ? esc_attr ( $redirect_to ['tourl'] ) : "";
				$fromurl = ! empty ( $redirect_to ['fromurl'] ) ? esc_attr ( $redirect_to ['fromurl'] ) : "";
				if ($tourl == $fromurl) {
					$has_loop = true;
					break;
				} else {
					foreach ( $redirects as $redirect_from ) {
						if (! isset ( $redirect_from ['disable'] ) || empty ( $redirect_from ['disable'] ) || $redirect_from ['disable'] != 'on') {
							$fromurl_2 = ! empty ( $redirect_from ['fromurl'] ) ? esc_attr ( $redirect_from ['fromurl'] ) : "";
							if ($tourl == $fromurl_2) {
								$has_loop = true;
								break;
							}
						}
					}
				}
			}
		}
	}
	return $has_loop;
}

/**
 * Retireve Social Share URL for specified post
*/
function seo_get_social_share_url_for_post($post, $social_network_name = 'facebook') {
	$share_url = '';
	if (!empty($post)){
		$share_url = seo_get_social_share_url($social_network_name, get_the_permalink($post), get_the_title($post), get_the_excerpt($post), get_the_post_thumbnail_url($post, 'woodkit-600'));
	}
	return $share_url;
}

/**
 * Retireve Social Share URL for specified post
*/
function seo_get_social_share_url($social_network_name, $url, $title = '', $resume = '', $img_url = '') {
	$share_url = '';
	if (!empty($url)){
		$url_endoded = urlencode($url);
		$title_encoded = urlencode($title);
		$resume_encoded = urlencode($resume);
		$img_url_encoded = urlencode($img_url);
		switch ($social_network_name){
			case "facebook" :
				$share_url = 'https://www.facebook.com/sharer/sharer.php?u='.$url_endoded;
				break;
			case "linkedin" :
				$share_url = 'https://www.linkedin.com/shareArticle?mini=true&url='.$url_endoded.'&title='.$title_encoded.'&summary='.$resume_encoded.'&source=';
				break;
			case "twitter" :
				$share_url = 'https://twitter.com/home?status='.$url_endoded;
				break;
			case "houzz" :
				$share_url = 'http://www.houzz.com/imageClipperUpload?imageUrl='.$img_url_encoded.'&title='.$title_encoded.'&link='.$url_endoded;
				break;
			case "pinterest" :
				$share_url = 'http://pinterest.com/pin/create/button/?url='.$url_endoded.'&media='.$img_url_encoded.'&description='.$title_encoded;
				break;
			case "googleplus" :
				$share_url = 'https://plus.google.com/share?url='.$url_endoded;
				break;
		}
	}
	return $share_url;
}

/**
 * Filter the site meta title
 * @since WP 4.4
*/
function woodkit_seo_document_title_parts($title_parts) {
	$title = woodkit_seo_get_meta_title();
	if (! empty ( $title )) {
		$title_parts ['title'] = $title;
		if (is_front_page ()) {
			$title_parts ['tagline'] = '';
		}
	}
	return $title_parts;
}
add_filter ('document_title_parts', 'woodkit_seo_document_title_parts', 100, 3);

/**
 * Retrieve Image to use for SEO - Useful for OpenGraph meta tags
 */
function woodkit_seo_get_image () {
	static $res = -1;
	if ($res === -1) {
		$res = null;
		if (is_category () || is_tax () || is_tag()) {
			// Nothing for archive pages - maybe add image meta data in terms custom fields in the future
		} else {
			$_queried_post = get_queried_object ();
			if ($_queried_post && isset($_queried_post->ID)){
				$image = null;
				$image_id = get_post_meta ($_queried_post->ID, '_seo_meta_og_image', true);
				if (!empty($image_id) && is_numeric($image_id)) {
					$image = wp_get_attachment_image_src($image_id, SEO_TOOL_IMAGE_SIZE);
				}
				if (empty($image) && has_post_thumbnail($_queried_post->ID)) {
					$image_id = get_post_thumbnail_id($_queried_post->ID);
					if (!empty($image_id) && is_numeric($image_id)) {
						$image = wp_get_attachment_image_src($image_id, SEO_TOOL_IMAGE_SIZE);
					}
				}
				if (!empty($image)) {
					list($src, $width, $height) = $image;
					$res = array(
							'src' => $src,
							'width' => $width,
							'height' => $height,
							'type' => get_post_mime_type($image_id),
					);
				}
					
			}
		}
	}
	return $res;
}

function woodkit_seo_get_site_name () {
	static $res = -1;
	if ($res === -1) {
		$res = get_bloginfo('name');
	}
	return $res;
}

function woodkit_seo_get_locale () {
	static $res = -1;
	if ($res === -1) {
		$res = get_locale();
	}
	return $res;
}

/**
 * Retrieve title for SEO
 */
function woodkit_seo_get_meta_title () {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		$queried_object = get_queried_object ();
		if (is_category () || is_tax () || is_tag()) {
			if (is_category ()) {
				$categories = get_the_category ();
				$term_id = $categories [0]->cat_ID;
			} else if (is_tax () || is_tag()) {
				$term_id = ( int ) $queried_object->term_id;
			}
			if (! empty ( $term_id )) {
				$meta_data_cat = get_term_meta($term_id, '_seo_meta_title', true);
				if (! empty ( $meta_data_cat )) {
					$res = stripslashes($meta_data_cat);
				}
			}
		} else {
			if ($queried_object){
				// meta title
				if (isset($queried_object->ID)){
					$meta_data = get_post_meta($queried_object->ID, '_seo_meta_title', true);
					if (!empty($meta_data)){
						$res = stripslashes($meta_data);
					}
				}
			}
		}
	}
	return $res;
}

/**
 * Retrieve description for SEO
*/
function woodkit_seo_get_meta_description() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		if (is_category () || is_tax () || is_tag()) {
			if (is_category ()) {
				$categories = get_the_category ();
				$term_id = $categories [0]->cat_ID;
			} else if (is_tax () || is_tag()) {
				$queried_object = get_queried_object ();
				$term_id = ( int ) $queried_object->term_id;
			}
			if (! empty ( $term_id )) {
				$meta_data_cat = get_term_meta($term_id, '_seo_meta_description', true);
				if (! empty ( $meta_data_cat )) {
					$res = stripslashes($meta_data_cat);
				}else{
					$term = get_term($term_id);
					if ($term && ! is_wp_error($term) && !empty($term->description)){
						$res = $term->description;
					}
				}
			}
		} else {
			$_queried_post = get_queried_object ();
			if ($_queried_post) {
				if (isset($_queried_post->ID)){
					// meta
					$meta_data = get_post_meta ( $_queried_post->ID, '_seo_meta_description', true );
					if (!empty($meta_data)) {
						$res = stripslashes($meta_data);
					}
					// user defined excerpt
					if (empty($res) && !empty($_queried_post->post_excerpt)){
						$res = get_the_excerpt($_queried_post->post_excerpt);
					}
					// generated excerpt
					if (empty($res)) {
						setup_postdata($_queried_post->ID);
						$res = get_the_excerpt($_queried_post->ID);
						wp_reset_postdata();
					}
				}
			}
		}
		
		// SEO default values
		if (empty($res)){
			$res = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "default-description");
		}
	
		// default value
		if (empty($res)) {
			$res = get_bloginfo ('description', 'display');
		}
		$res = htmlentities2($res);
	}
	return $res;
}

/**
 * Retrieve keywords for SEO
*/
function woodkit_seo_get_meta_keywords() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		if (is_category () || is_tax () || is_tag()) {
			if (is_category ()) {
				$categories = get_the_category ();
				$term_id = $categories [0]->cat_ID;
			} else if (is_tax () || is_tag()) {
				$queried_object = get_queried_object ();
				$term_id = ( int ) $queried_object->term_id;
			}
			if (! empty ( $term_id )) {
				$meta_data_cat = get_term_meta($term_id, '_seo_meta_keywords', true);
				if (! empty ( $meta_data_cat )) {
					$res = stripslashes($meta_data_cat);
				}
			}
		} else {
			$_queried_post = get_queried_object ();
			if ($_queried_post) {
				if (isset($_queried_post->ID)){
					$meta_data = get_post_meta ( $_queried_post->ID, '_seo_meta_keywords', true );
					if (! empty ( $meta_data )) {
						$res = stripslashes($meta_data);
					}
				}
			}
		}
		if (empty($res)){
			$res = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "default-keywords");
		}
		$res = htmlentities2($res);
	}
	return $res;
}

/**
 * Retrieve publication's type for social SEO
*/
function woodkit_seo_get_meta_publication_type() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		if (is_home () || is_front_page ()) {
			$res = "website";
		} else if (is_category () || is_tax () || is_tag()) {
			$res = "article:tag";	
		} else {
			$res = "article";
		}
	}
	return $res;
}

/**
 * Retrieve publication's card for social SEO
*/
function woodkit_seo_get_meta_publication_card() {
	static $res = -1;
	if ($res === -1) {
		$res = 'summary';
	}
	return $res;
}

/**
 * Retrieve publication's URL for social SEO
*/
function woodkit_seo_get_meta_publication_url() {
	static $res = -1;
	if ($res === -1) {
		$res = get_current_url ( true );
	}
	return $res;
}

/**
 * Retrieve publication's title for social SEO
*/
function woodkit_seo_get_meta_publication_title() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		if (is_category () || is_tax () || is_tag()) {
			if (is_category ()) {
				$categories = get_the_category ();
				$term_id = $categories [0]->cat_ID;
			} else if (is_tax () || is_tag()) {
				$queried_object = get_queried_object ();
				$term_id = ( int ) $queried_object->term_id;
			}
			if (! empty ( $term_id )) {
				$meta_data_cat = get_term_meta($term_id, '_seo_meta_og_title', true);
				if (! empty ( $meta_data_cat )) {
					$res = stripslashes($meta_data_cat);
				}
			}
		} else {
			$_queried_post = get_queried_object ();
			if ($_queried_post) {
				$meta_data = get_post_meta($_queried_post->ID, '_seo_meta_og_title', true);
				if (! empty ( $meta_data )) {
					$res = stripslashes($meta_data);
				}
			}
		}
		if (empty($res)) {
			$res = woodkit_seo_get_meta_title();
		} else {
			$blogname = get_bloginfo ( 'name' );
			if (! empty ( $blogname )) {
				$res .= SEO_TOOL_META_SEPARATOR . $blogname;
			}
		}
	}
	return $res;
}

/**
 * Retrieve publication's description for social SEO
*/
function woodkit_seo_get_meta_publication_description() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		if (is_category () || is_tax () || is_tag()) {
			if (is_category ()) {
				$categories = get_the_category ();
				$term_id = $categories [0]->cat_ID;
			} else if (is_tax () || is_tag()) {
				$queried_object = get_queried_object ();
				$term_id = ( int ) $queried_object->term_id;
			}
			if (! empty ( $term_id )) {
				$meta_data_cat = get_term_meta($term_id, '_seo_meta_og_description', true);
				if (! empty ( $meta_data_cat )) {
					$res = stripslashes($meta_data_cat);
				}
			}
		} else {
			$_queried_post = get_queried_object ();
			if ($_queried_post) {
				if (isset($_queried_post->ID)){
					$meta_data = get_post_meta ( $_queried_post->ID, '_seo_meta_og_description', true );
					if (! empty ( $meta_data )) {
						$res = stripslashes($meta_data);
					}
				}
			}
		}
		if (empty ( $res )) {
			$res = woodkit_seo_get_meta_description();
		}
		if (empty ( $res )) {
			$res = get_bloginfo('description', 'display');
		}
	}
	return $res;
}
add_action ( "woodkit_seo_get_meta_publication_description", "woodkit_seo_get_meta_publication_description" );

/**
 * Retrieve publication's image for social SEO
*/
function woodkit_seo_get_meta_publication_image() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		$image = woodkit_seo_get_image();
		$res = !empty($image) && isset($image['src']) ? $image['src'] : '';
	}
	return $res;
}

/**
 * Retrieve publication's image type for social SEO
*/
function woodkit_seo_get_meta_publication_image_type() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		$image = woodkit_seo_get_image();
		$res = !empty($image) && isset($image['type']) ? $image['type'] : '';
	}
	return $res;
}

/**
 * Retrieve publication's image width for social SEO
*/
function woodkit_seo_get_meta_publication_image_width() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		$image = woodkit_seo_get_image();
		$res = !empty($image) && isset($image['width']) ? $image['width'] : '';
	}
	return $res;
}

/**
 * Retrieve publication's image height for social SEO
*/
function woodkit_seo_get_meta_publication_image_height() {
	static $res = -1;
	if ($res === -1) {
		$res = '';
		$image = woodkit_seo_get_image();
		$res = !empty($image) && isset($image['height']) ? $image['height'] : '';
	}
	return $res;
}

/**
 * Retrieve author for SEO
*/
function woodkit_seo_get_meta_author() {
	static $res = -1;
	if ($res === -1) {
		$res = get_bloginfo ('name');
	}
	return $res;
}

/**
 * Retrieve created date for SEO
*/
function woodkit_seo_get_meta_created($display = false) {
	static $res = -1;
	if ($res === -1) {
		$res = get_the_date('Y-m-d').'T'.get_the_date('H:i:s').'+00:00';
	}
	return $res;
}

/**
 * Retrieve updated date for SEO
*/
function woodkit_seo_get_meta_updated($display = false) {
	static $res = -1;
	if ($res === -1) {
		$res = get_the_modified_date('Y-m-d').'T'.get_the_modified_date('H:i:s').'+00:00';
	}
	return $res;
}

/**
 * Retrieve robots's meta follow
 */
function woodkit_seo_get_robots() {
	global $post;
	static $res = -1;
	if ($res === -1) {
		$res = '';
		$values = array(
				'index' => 'index',
				'follow' => 'follow',
				'archive' => 'noarchive',
				'max-snippet' => 'max-snippet:-1',
				'max-image-preview' => 'max-image-preview:standard',
				'max-video-preview' => 'max-video-preview:-1'
		);
		// Post status
		if (is_object($post)) {
			if ('private' === $post->post_status) {
				$values['index'] = 'noindex';
			}
		} else {
			// Special archives
			if (is_search() || is_404()) {
				$values['index'] = 'noindex';
			}
		}
		// Force override to respect the WP settings.
		if ('0' !== (string) get_option('blog_public') || isset($_GET['replytocom'])){
			$values['index'] = 'noindex';
		}
		$res = implode(',', $values);
	}
	return $res;
}

/**
 * Display SEO metadata in website head
 */
add_action('wp_head', function () {

	// ---- ROBOTS
	$value = woodkit_seo_get_robots(); if (!empty($value)) { 						?><meta name="robots" content="<?php echo esc_attr($value); ?>"><?php }
	
	// ---- META DATA
	$value = woodkit_seo_get_meta_description(); if (!empty($value)) { 				?><meta name="description" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_keywords(); if (!empty($value)) { 				?><meta name="keywords" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_author(); if (!empty($value)) { 					?><meta name="author" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_created(); if (!empty($value)) { 					?><meta name="created" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_updated(); if (!empty($value)) { 					?><meta name="updated" content="<?php echo esc_attr($value); ?>"><?php }
	
	// ---- OPEN GRAPH
	$value = woodkit_seo_get_site_name(); if (!empty($value)) { 					?><meta name="og:site_name" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_type(); if (!empty($value)) { 		?><meta name="og:type" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_locale(); if (!empty($value)) { 						?><meta name="og:locale" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_url(); if (!empty($value)) { 			?><meta name="og:url" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_title(); if (!empty($value)) { 		?><meta name="og:title" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_description(); if (!empty($value)) { 	?><meta name="og:description" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_image(); if (!empty($value)) { 		?><meta name="og:image" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_image_type(); if (!empty($value)) { 	?><meta name="og:image:type" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_image_width(); if (!empty($value)) { 	?><meta name="og:image:width" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_image_height(); if (!empty($value)) { ?><meta name="og:image:height" content="<?php echo esc_attr($value); ?>"><?php }
	
	// ---- TWITTER
	$value = woodkit_seo_get_site_name(); if (!empty($value)) { 					?><meta name="twitter:site" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_card(); if (!empty($value)) { 		?><meta name="twitter:card" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_url(); if (!empty($value)) { 			?><meta name="twitter:url" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_title(); if (!empty($value)) { 		?><meta name="twitter:title" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_description(); if (!empty($value)) { 	?><meta name="twitter:description" content="<?php echo esc_attr($value); ?>"><?php }
	// ----
	$value = woodkit_seo_get_meta_publication_image(); if (!empty($value)) { 		?><meta name="twitter:image" content="<?php echo esc_attr($value); ?>"><?php }
});

