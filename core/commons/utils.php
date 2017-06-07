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

if (!function_exists("woodkit_get_image_id_for_url")):
/**
 * retrieve image id for image url
* @param unknown $image_url
* @return Ambigous <Ambigous <string, NULL>>
*/
function woodkit_get_image_id_for_url($image_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
	if (count($attachment)>0)
		return $attachment[0];
	return null;
}
endif;

if (!function_exists("locate_web_ressource")):
/**
 * Retrieve the URI of the highest priority template file which exists.
*
* Searches in order in :
* 	- STYLESHEET_URI/woodkit/
*	- TEMPLATE_URI/woodkit/
*	- WOODKIT_PLUGIN_URI/
* @return string (empty if template not found)
*/
function locate_web_ressource($ressource_name) {
	$located = '';
	if (!empty($ressource_name)){
		if (file_exists(STYLESHEETPATH . '/woodkit/' . $ressource_name)) {
			$located = get_stylesheet_directory_uri() . '/woodkit/' . $ressource_name;
		} else if (file_exists(TEMPLATEPATH . '/woodkit/' . $ressource_name)) {
			$located = get_template_directory_uri() . '/woodkit/' . $ressource_name;
		} else if (file_exists(WOODKIT_PLUGIN_PATH.'/'. $ressource_name)) {
			$located = WOODKIT_PLUGIN_URI . $ressource_name;
		}
	}
	return $located;
}
endif;

if (!function_exists("locate_ressource")):
/**
 * Retrieve the PATH of the highest priority template file which exists.
*
* Searches in order in :
* 	- STYLESHEET_PATH/woodkit/
*	- TEMPLATE_PATH/woodkit/
*	- WOODKIT_PLUGIN_PATH/
* @return string (empty if template not found)
*/
function locate_ressource($ressource_name) {
	$located = '';
	if (!empty($ressource_name)){
		if (file_exists(STYLESHEETPATH . '/woodkit/' . $ressource_name)) {
			$located = STYLESHEETPATH . '/woodkit/' . $ressource_name;
		} else if (file_exists(TEMPLATEPATH . '/woodkit/' . $ressource_name)) {
			$located = TEMPLATEPATH . '/woodkit/' . $ressource_name;
		} else if (file_exists(WOODKIT_PLUGIN_PATH . '/' . $ressource_name)) {
			$located = WOODKIT_PLUGIN_PATH . $ressource_name;
		}
	}
	return $located;
}
endif;

if (!function_exists("get_displayed_post_types")):
/**
 * Récupère les post_types (exceptés "attachment", "revision", "nav_menu_item")
* @param $sort : alphabetic sorting
* @return array:
*/
function get_displayed_post_types($sort = false, $only_public = true, $exclude = array("attachment", "revision", "nav_menu_item")){
	$displayed_post_types = array();
	foreach (get_post_types() as $post_type){
		if (!in_array($post_type, $exclude)){
			$post_type_object = get_post_type_object($post_type);
			if ($only_public == true){
				if ($post_type_object->public == 1){
					$displayed_post_types[] = $post_type;
				}
			}else{
				$displayed_post_types[] = $post_type;
			}
		}
	}
	if ($sort == true)
		usort($displayed_post_types, "woodkit_cmp_posttypes");
	return $displayed_post_types;
}
endif;

if (!function_exists("is_edit_page")):
/**
 * is_edit_page
* function to check if the current page is a post edit page
*
* @author Ohad Raz <admin@bainternet.info>
*
* @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
* @return boolean
*/
function is_edit_page($new_edit = null){
	global $pagenow;
	//make sure we are on the backend
	if (!is_admin()) return false;


	if($new_edit == "edit")
		return in_array( $pagenow, array( 'post.php',  ) );
	elseif($new_edit == "new") //check for new post page
	return in_array( $pagenow, array( 'post-new.php' ) );
	else //check for either new or edit
		return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}
endif;

if (!function_exists("getDateForDateMeta")):
/**
 * retourne une date PHP à partir d'une date au format préconisé par WP pour les meta_data : YYYYMMJJ (http://codex.wordpress.org/Class_Reference/WP_Query#Woodkit_Field_Parameters)
* @param string $metaDate
* @return DateTime
*/
function getDateForDateMeta($metaDate){
	$date = DateTime::createFromFormat('Ymd', $metaDate);
	return $date;
}
endif;

if (!function_exists("getDateMeta")):
/**
 * retourne une chaine de caractère représentant une date au format préconisé par WP pour les meta_data : YYYYMMJJ (http://codex.wordpress.org/Class_Reference/WP_Query#Woodkit_Field_Parameters)
* @param DateTime $date
* @return string
*/
function getDateMeta($date){
	if ($date)
		return $date->format('Ymd');
	return "";
}
endif;

if (!function_exists("getDateMetaForFormat")):
/**
 * retourne une chaine de caractère représentant une date au format préconisé par WP pour les meta_data : YYYYMMJJ (http://codex.wordpress.org/Class_Reference/WP_Query#Woodkit_Field_Parameters)
* @param string $sdate
* @param string $format : format d'origine de la date
* @return string
*/
function getDateMetaForFormat($sdate, $format){
	$date = DateTime::createFromFormat($format, $sdate);
	return getDateMeta($date);
}
endif;

if (!function_exists("trace_err")):
/**
 * write error log trace in log file's theme
* @param string $content
*/
function trace_err($content){
	trace("ERROR - ".$content);
}
endif;

if (!function_exists("trace_warn")):
/**
 * write warning log trace in log file's theme
* @param string $content
*/
function trace_warn($content){
	trace("WARNING - ".$content);
}
endif;

if (!function_exists("trace_info")):
/**
 * write info log trace in log file's theme
* @param string $content
*/
function trace_info($content){
	trace("INFO - ".$content);
}
endif;

if (!function_exists("trace")):
/**
 * write log trace in log file's theme
* @param string $content
*/
function trace($content){
	$success = false;
	$content = date("Y/m/d G:i:s").' - '.$content;
	$trace_path = WOODKIT_PLUGIN_PATH.'/log/';
	$trace_file = 'log.log';
	$trace_file_path = $trace_path.$trace_file;
	if (!file_exists($trace_path)){
		if (!@mkdir($trace_path)){
			// ERROR on create log folder
			// TODO try write by FTP (fopen("ftp://user:password@example.com/log.log", "w");)
		}
	}
	if (@file_put_contents($trace_file_path, "\n - ".$content, FILE_APPEND)){
		$success = true;
	}else{
		// ERROR on write log file
		// TODO try write by FTP (fopen("ftp://user:password@example.com/log.log", "w");)
	}
	return $success;
}
endif;

if (!function_exists("startsWith")):
/**
 * test if $haystack start with $needle
* @param string $haystack
* @param string $needle
* @return boolean
*/
function startsWith($haystack, $needle){
	return $needle === "" || strpos($haystack, $needle) === 0;
}
endif;

if (!function_exists("endsWith")):
/**
 * test if $haystack end with $needle
* @param string $haystack
* @param string $needle
* @return boolean
*/
function endsWith($haystack, $needle){
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}
endif;

if (!function_exists("get_current_url")):
/**
 * get the current URL
*/
function get_current_url($with_parameters = false){
	if ($with_parameters){
		$protocol = get_protocol();
		return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}else{
		$uri_parts = explode('?', $_SERVER['REQUEST_URI']);
		$protocol = get_protocol();
		return $protocol . $_SERVER['HTTP_HOST'] . $uri_parts[0];
	}
}
endif;

if (!function_exists("get_current_url_parameters")):
/**
 * get the current URL parameters
*/
function get_current_url_parameters(){
	$res = "";
	$uri_parts = explode('?', $_SERVER['REQUEST_URI']);
	if (count($uri_parts) > 1){
		$res = $uri_parts[1];
	}
	return $res;
}
endif;

if (!function_exists("get_host")):
/**
 * get the host
*/
function get_host(){
	$host = '';
	if (isset($_SERVER['HTTP_HOST'])) {
		$host = $_SERVER['HTTP_HOST'];
	}
	return $host;
}
endif;

if (!function_exists("get_protocol")):
/**
 * get the current Protocol (http || https)
*/
function get_protocol(){
	if (is_ssl()) {
		$protocol = 'https://';
	}
	else {
		$protocol = 'http://';
	}
	return $protocol;
}
endif;

if (!function_exists("get_http_response_code")):
/**
 * Check http request return CODE
* @param string $url
* @return string
*/
function get_http_response_code($url) {
	$headers = get_headers($url);
	return substr($headers[0], 9, 3);
}
endif;

if (!function_exists("get_emails_from_string")):
/**
 * retourne un tableau d'e-mail. Si il n'y a qu'un seul email dans la chaine, la méthode retourne tout de même un tableau avec cet email
* <strong>Note : </strong> cette méthode ne renvoit que des emails valides, les autres sont ignorés
* @param unknown $string : chaine contenant les emails séparés par des ';' (point-virgule)
* @return array
*/
function get_emails_from_string($string){
	$res = array();
	if (!empty($string)){
		$emails = explode(";", $string);
		foreach ($emails as $email){
			$email = trim($email);
			if (is_email($email))
				array_push($res, $email);
		}
	}
	return $res;
}
endif;

if (!function_exists("get_post_types_by_type")):
/**
 * retrieve specified post-types
* @param string $meta_args : permet de filtrer sur les post_meta
* @return array
*/
function get_post_types_by_type($type, $meta_args = null, $args=array()){
	$posts = array();
	// parse args array and set default values
	$args['post_type'] = $type;
	if (empty($args['orderby']))
		$args['orderby'] = "title";
	if (empty($args['order']))
		$args['order'] = 'ASC';
	if (empty($args['numberposts']))
		$args['numberposts'] = -1;
	if (empty($args['suppress_filters']))
		$args['suppress_filters'] = FALSE; // pour n'avoir que les items de la langue courante (compatibilité WPML)

	$posts = array_merge($posts, get_posts($args));
	$posts_fin = array();

	// meta filters
	if ($meta_args && count($meta_args)>0){
		foreach ($posts as $post){
			$add = true;
			foreach ($meta_args as $meta_key => $meta_value){
				if (get_post_meta($post->ID, $meta_key, true) != $meta_value){
					$add = false;
				}
			}
			if ($add == true){
				array_push($posts_fin, $post);
			}
		}
	}else{
		$posts_fin = $posts;
	}

	return $posts_fin;
}
endif;

if (!function_exists("get_timestamp_from_mysql")):
/**
 * Converts a mysql datetime value into a unix timestamp
* @param $mysqlDateTime The in the mysql datetime format
* @return int The time in seconds
*/
function get_timestamp_from_mysql($mysqlDateTime) {
	list($date, $hours) = explode(' ', $mysqlDateTime);
	list($year, $month, $day) = explode('-', $date);
	list($hour, $min, $sec) = explode(':', $hours);
	return mktime(intval($hour), intval($min), intval($sec), intval($month), intval($day), intval($year));
}
endif;

if (!function_exists("has_children")):
/**
 * Check if post/page... is hierarchical and has children
*/
function has_children($id_post){
	$post_type = get_post_type($id_post);
	$hierarchical_post_types = get_post_types(array('hierarchical' => true));
	if (in_array($post_type, $hierarchical_post_types) && count(get_pages(array('post_type'=> $post_type, 'parent' => $id_post)))>0)
		return true;
	return false;
}
endif;

if (!function_exists("has_ancestors")):
/**
 * Check if post/page... is hierarchical and has ancestors
*/
function has_ancestors($id_post){
	$post_type = get_post_type($id_post);
	$hierarchical_post_types = get_post_types(array('hierarchical' => true));
	if (in_array($post_type, $hierarchical_post_types) && count(get_post_ancestors($id_post))>0)
		return true;
	return false;
}
endif;

if (!function_exists("get_oldest_ancestor")):
/**
 * Get the oldest ancestor of this post/page...
*/
function get_oldest_ancestor($id_post){
	if (is_page($id_post)){
		$post = get_page($id_post);
	}else{
		$post = get_post($id_post);
	}
	if (has_ancestors($id_post)){
		return get_oldest_ancestor($post->post_parent);
	}else{
		return $id_post;
	}
}
endif;

if (!function_exists('get_current_lang')) :
/**
 * woodkit_get_current_lang
*
* @since Woodkit 1.0
* @return void
*/
function get_current_lang() {
	// on interroge WPML
	if (defined('ICL_LANGUAGE_CODE')){
		return ICL_LANGUAGE_CODE;
	}
	// on interroge WP
	$wp_locale = get_locale();
	if (!empty($wp_locale)){
		if (strlen($wp_locale)>4)
			return substr($wp_locale, 0, 2);
		else return $wp_locale;
	}
	// inconnu
	return "";
}
endif;

if (!function_exists("get_video_embed_code")):
/**
 * @param string $url
* @param string $width
* @param string $height
* @return string embed video code for specified url
*/
function get_video_embed_code($url, $width = "", $height="", $args = array()){
	$res = '';
	if (!empty($url)){
		if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
			$res = '<p class="video-invalid-url">'.__("Invalid URL...", WOODKIT_PLUGIN_TEXT_DOMAIN).'</p>';
		}else{

			$defaults = array(
					'vine' => array("quality" => "hd"),
					'dailymotion' => array(),
					'youtube' =>  array("wmode" => "transparent", "modestbranding" => "1", "autohide" => "1", "rel" => "0"),
					'vimeo' =>  array("portrait" => "0", "byline" => "0", "title" => "0")
			);
			foreach ($defaults as $default_brand => $default_values){
				if (!isset($args[$default_brand]) || empty($args[$default_brand])){
					$args[$default_brand] = $default_values;
				}else{
					foreach ($default_values as $k => $v){
						if (!isset($args[$default_brand][$k]) || empty($args[$default_brand][$k]))
							$args[$default_brand][$k] = $v;
					}
				}
			}

			$regs = array(
					array("brand" => "vine", "regex" => "/vine\.co\/v\/([\w\-.]+)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//vine.co/v/$1/embed/simple"),
					array("brand" => "dailymotion", "regex" => "/dai\.ly\/([\w\-.]+)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//www.dailymotion.com/embed/video/$1"),
					array("brand" => "dailymotion", "regex" => "/dailymotion\.com\/video\/([\w\-.]+)_(.*)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//www.dailymotion.com/embed/video/$1"),
					array("brand" => "youtube", "regex" => "/youtu\.be\/([\w\-.]+)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//www.youtube.com/embed/$1"),
					array("brand" => "youtube", "regex" => "/youtube\.com(.+)v=([^&]+)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//www.youtube.com/embed/$2"),
					array("brand" => "youtube", "regex" => "/youtube\.com\/([0-9|a-z|A-Z]+)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//www.youtube.com/embed/$1"),
					array("brand" => "vimeo", "regex" => "/vimeo\.com\/([0-9]+)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//player.vimeo.com/video/$1"),
					array("brand" => "vimeo", "regex" => "/vimeo\.com\/(.*)\/([0-9]+)/", "type" => "iframe", "width" => 425, "height" => 350, "url" => "//player.vimeo.com/video/$2")
			);
			$url_embed = '';
			$embed = '';
			foreach ($regs as $reg){
				$matches = null;
				preg_match($reg['regex'], $url, $matches);
				if (!empty($matches)){
					$url_embed = $reg['url'];
					if(isset($matches[1]))
						$url_embed = str_replace("$1", $matches[1], $url_embed);
					if(isset($matches[2]))
						$url_embed = str_replace("$2", $matches[2], $url_embed);
					if(isset($matches[3]))
						$url_embed = str_replace("$3", $matches[3], $url_embed);

					if ($reg['type'] == 'iframe'){
						if (empty($width))
							$width = $reg['width'];
						if (empty($height))
							$height = $reg['height'];
						$url_args = "";
						if (isset($args) && !empty($args)){
							if (isset($args[$reg['brand']]) && !empty($args[$reg['brand']])){
								$type_args = $args[$reg['brand']];
								foreach ($type_args as $k => $v){
									if (empty($url_args))
										$url_args .= "?";
									else
										$url_args .= "&";
									$url_args .= ''.$k.'='.urlencode($v).'';
								}
							}
						}
						$embed = '<iframe src="'.$url_embed.$url_args.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
					}
					break;
				}
			}
			if (!empty($embed)){
				$res = $embed;
			}else{
				$res = '<p class="video-invalid-format">'.__("Invalid Format...", WOODKIT_PLUGIN_TEXT_DOMAIN).'</p><ul><li>youtube</li><li>vimeo</li><li>dailymotion</li><li>vine</li></ul><p>'.__("are supported", WOODKIT_PLUGIN_TEXT_DOMAIN).'</p>';
			}
		}
	}
	return $res;
}
endif;

if (!function_exists("get_textual_month")):
/**
 * @param int $timestamp : date timestamp in millisecond
*/
function get_textual_month($timestamp){
	$res = "";
	if (!empty($timestamp) && is_numeric($timestamp)){
		$month = date("m", $timestamp);
		if ($month == "1")
			$res = __("january", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "2")
			$res = __("february", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "3")
			$res = __("march", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "4")
			$res = __("april", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "5")
			$res = __("may", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "6")
			$res = __("june", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "7")
			$res = __("july", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "8")
			$res = __("august", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "9")
			$res = __("september", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "10")
			$res = __("october", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "11")
			$res = __("november", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "12")
			$res = __("december", WOODKIT_PLUGIN_TEXT_DOMAIN);
	}
	return $res;
}
endif;

if (!function_exists("get_textual_shortmonth")):
/**
 * @param int $timestamp : date timestamp in millisecond
*/
function get_textual_shortmonth($timestamp){
	$res = "";
	if (!empty($timestamp) && is_numeric($timestamp)){
		$month = date("m", $timestamp);
		if ($month == "1")
			$res = __("jan", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "2")
			$res = __("feb", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "3")
			$res = __("mar", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "4")
			$res = __("apr", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "5")
			$res = __("may", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "6")
			$res = __("jun", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "7")
			$res = __("jul", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "8")
			$res = __("aug", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "9")
			$res = __("sept", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "10")
			$res = __("oct", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "11")
			$res = __("nov", WOODKIT_PLUGIN_TEXT_DOMAIN);
		if ($month == "12")
			$res = __("dec", WOODKIT_PLUGIN_TEXT_DOMAIN);
	}
	return $res;
}
endif;

if (!function_exists("truncate")):
/**
 * Truncates string with specified length.
*
* @param string $string
* @param int $length
* @param string $etc
* @param bool $break_words
* @param bool $middle
* @return string
*/
function truncate($string, $length = 80, $etc = '&#133;', $break_words = false, $middle = false) {
	if ($length == 0)
		return '';

	if (strlen($string) > $length) {
		$length -= min($length, strlen($etc));
		if (!$break_words && !$middle) {
			$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
		}
		if(!$middle) {
			return substr($string, 0, $length) . $etc;
		} else {
			return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
		}
	} else {
		return $string;
	}
}
endif;

if (!function_exists("get_dates_period")):
/**
 * retrieve DatePeriod object wich contains all day between specified two dates
* @param string $date_from : php format Y/m/d
* @param string $date_to : php format Y/m/d
*/
function get_dates_period($date_from, $date_to) {
	$date_from = \DateTime::createFromFormat('Y/m/d', $date_from);
	$date_to = \DateTime::createFromFormat('Y/m/d', $date_to);
	return new \DatePeriod(
			$date_from,
			new \DateInterval('P1D'),
			$date_to->modify('+1 day')
	);
}
endif;

if (!function_exists("hex_to_rgb")):
/**
 * Convert a hexa decimal color code to its RGB equivalent
*
* @param string $hexStr (hexadecimal color value)
* @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
* @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
* @return array or string (depending on second parameter. Returns False if invalid hex color value)
*/
function hex_to_rgb($hexStr, $returnAsString = false, $seperator = ',') {
	$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
	$rgbArray = array();
	if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
		$colorVal = hexdec($hexStr);
		$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
		$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
		$rgbArray['blue'] = 0xFF & $colorVal;
	} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
		$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
		$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
		$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	} else {
		return false; //Invalid hex color code
	}
	return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}
endif;

/**
 * retrieve posts options
 * @param string $id_selected
 * @param string $available_posttypes
 * @param string $available_taxonomies
 * @param string $only_public
 * @return string
 */
function woodkit_get_posts_options($id_selected = null, $available_posttypes = null, $available_taxonomies = null, $only_public = true){
	$options = '';
	// post-types
	$selectable_posttypes = get_displayed_post_types(false, $only_public);
	if (!is_array($available_posttypes)){
		$selectable_posttypes = apply_filters("woodkit_get_posts_options_selectable_posttypes", $selectable_posttypes);
	}
	if (!empty($selectable_posttypes)){
		foreach ($selectable_posttypes as $posttype){
			$valid = false;
			if (!is_array($available_posttypes)){
				$valid = true;
			}else{
				if (in_array($posttype, $available_posttypes))
					$valid = true;
			}
			if ($valid == true){
				$args = array(
						'posts_per_page'   => -1,
						'orderby'          => 'title',
						'order'            => 'DESC',
						'post_type'        => $posttype,
						'suppress_filters' => false,
						'post_parent'	   => 0
				);
				$posts = get_posts($args);
				if (!empty($posts)){
					$options .= '<optgroup label="'.esc_attr($posttype).'">';
					foreach ($posts as $post){
						$selected = !empty($id_selected) && $id_selected == esc_attr('post|'.$posttype.'|'.$post->ID) ? 'selected="selected"' : '';
						$options .= '<option value="'.esc_attr('post|'.$posttype.'|'.$post->ID).'" '.$selected.'>'.$post->post_title.'</option>';
						$options .= woodkit_get_posts_options_children($id_selected, $post->ID, $posttype, 1);
					}
					$options .= '</optgroup>';
				}
			}
		}
	}
	// taxonomies
	$taxonomies = get_taxonomies(array('public' => true), 'objects', 'and');
	if (!is_array($available_taxonomies))
		$taxonomies = apply_filters("woodkit_get_posts_options_selectable_taxonomies", $taxonomies);
	if (!empty($taxonomies)) {
		foreach ($taxonomies  as $tax) {
			$valid = false;
			if (!is_array($available_taxonomies)){
				$valid = true;
			}else{
				if (in_array($tax->name, $available_taxonomies))
					$valid = true;
			}
			if ($valid == true){
				$terms = get_terms($tax->name);
				if (!empty($terms)){
					$tax_labels = get_taxonomy_labels($tax);
					$options .= '<optgroup label="'.esc_attr($tax_labels->name).'">';
					foreach ($terms as $term){
						$selected = !empty($id_selected) && $id_selected == esc_attr('tax|'.$tax->name.'|'.$term->term_id) ? 'selected="selected"' : '';
						$options .= '<option value="'.esc_attr('tax|'.$tax->name.'|'.$term->term_id).'" '.$selected.'>'.$term->name.'</option>';
					}
					$options .= '</optgroup>';
				}
			}
		}
	}
	return $options;
}

function woodkit_get_posts_options_children($id_selected = null, $id_post_parent, $posttype, $level = 0){
	$options = '';
	$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'title',
			'order'            => 'DESC',
			'post_type'        => $posttype,
			'suppress_filters' => false,
			'post_parent'	   => $id_post_parent
	);
	$posts = get_posts($args);
	if (!empty($posts)){
		foreach ($posts as $post){
			$title = $post->post_title;
			for ($cp_level = 0; $cp_level < $level ; $cp_level++){
				$title = "- ".$title;
			}
			$selected = !empty($id_selected) && $id_selected == esc_attr('post|'.$posttype.'|'.$post->ID) ? 'selected="selected"' : '';
			$options .= '<option value="'.esc_attr('post|'.$posttype.'|'.$post->ID).'" '.$selected.'>'.$title.'</option>';
			$options .= woodkit_get_posts_options_children($id_selected, $post->ID, $posttype, ($level+1));
		}
	}
	return $options;
}

function woodkit_is_light_color($hex){
	$hex = str_replace("#", "", $hex);
	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));

	$contrast = sqrt(
			$r * $r * .241 +
			$g * $g * .691 +
			$b * $b * .068
	);

	if($contrast > 130){
		return true;
	}
	return false;
}

function woodkit_get_departments_fr(){
	$dep = array();
	$dep['01'] = array("label" => "Ain");
	$dep['02'] = array("label" => "Aisne");
	$dep['03'] = array("label" => "Allier");
	$dep['04'] = array("label" => "Alpes-de-Haute-Provence");
	$dep['05'] = array("label" => "Hautes-Alpes");
	$dep['06'] = array("label" => "Alpes-Maritimes");
	$dep['07'] = array("label" => "Ardèche");
	$dep['08'] = array("label" => "Ardennes");
	$dep['09'] = array("label" => "Ariège");
	$dep['10'] = array("label" => "Aube");
	$dep['11'] = array("label" => "Aude");
	$dep['12'] = array("label" => "Aveyron");
	$dep['13'] = array("label" => "Bouches-du-Rhône");
	$dep['14'] = array("label" => "Calvados");
	$dep['15'] = array("label" => "Cantal");
	$dep['16'] = array("label" => "Charente");
	$dep['17'] = array("label" => "Charente-Maritime");
	$dep['18'] = array("label" => "Cher");
	$dep['19'] = array("label" => "Corrèze");
	$dep['2A'] = array("label" => "Corse-du-Sud");
	$dep['2B'] = array("label" => "Haute-Corse");
	$dep['21'] = array("label" => "Côte-d'Or");
	$dep['22'] = array("label" => "Côtes-d'Armor");
	$dep['23'] = array("label" => "Creuse");
	$dep['24'] = array("label" => "Dordogne");
	$dep['25'] = array("label" => "Doubs");
	$dep['26'] = array("label" => "Drôme");
	$dep['27'] = array("label" => "Eure");
	$dep['28'] = array("label" => "Eure-et-Loir");
	$dep['29'] = array("label" => "Finistère");
	$dep['30'] = array("label" => "Gard");
	$dep['31'] = array("label" => "Haute-Garonne");
	$dep['32'] = array("label" => "Gers");
	$dep['34'] = array("label" => "Hérault");
	$dep['35'] = array("label" => "Ille-et-Vilaine");
	$dep['36'] = array("label" => "Indre");
	$dep['37'] = array("label" => "Indre-et-Loire");
	$dep['38'] = array("label" => "Isère");
	$dep['39'] = array("label" => "Jura");
	$dep['40'] = array("label" => "Landes");
	$dep['41'] = array("label" => "Loir-et-Cher");
	$dep['42'] = array("label" => "Loire");
	$dep['43'] = array("label" => "Haute-Loire");
	$dep['44'] = array("label" => "Loire-Atlantique");
	$dep['45'] = array("label" => "Loiret");
	$dep['46'] = array("label" => "Lot");
	$dep['47'] = array("label" => "Lot-et-Garonne");
	$dep['48'] = array("label" => "Lozère");
	$dep['49'] = array("label" => "Maine-et-Loire");
	$dep['50'] = array("label" => "Manche");
	$dep['51'] = array("label" => "Marne");
	$dep['52'] = array("label" => "Haute-Marne");
	$dep['53'] = array("label" => "Mayenne");
	$dep['54'] = array("label" => "Meurthe-et-Moselle");
	$dep['55'] = array("label" => "Meuse");
	$dep['56'] = array("label" => "Morbihan");
	$dep['57'] = array("label" => "Moselle");
	$dep['58'] = array("label" => "Nièvre");
	$dep['59'] = array("label" => "Nord");
	$dep['60'] = array("label" => "Oise");
	$dep['61'] = array("label" => "Orne");
	$dep['62'] = array("label" => "Pas-de-Calais");
	$dep['63'] = array("label" => "Puy-de-Dôme");
	$dep['64'] = array("label" => "Pyrénées-Atlantiques");
	$dep['65'] = array("label" => "Hautes-Pyrénées");
	$dep['66'] = array("label" => "Pyrénées-Orientales");
	$dep['67'] = array("label" => "Bas-Rhin");
	$dep['68'] = array("label" => "Haut-Rhin");
	$dep['69'] = array("label" => "Rhône");
	$dep['70'] = array("label" => "Haute-Saône");
	$dep['71'] = array("label" => "Saône-et-Loire");
	$dep['72'] = array("label" => "Sarthe");
	$dep['73'] = array("label" => "Savoie");
	$dep['74'] = array("label" => "Haute-Savoie");
	$dep['75'] = array("label" => "Paris");
	$dep['76'] = array("label" => "Seine-Maritime");
	$dep['77'] = array("label" => "Seine-et-Marne");
	$dep['78'] = array("label" => "Yvelines");
	$dep['79'] = array("label" => "Deux-Sèvres");
	$dep['80'] = array("label" => "Somme");
	$dep['81'] = array("label" => "Tarn");
	$dep['82'] = array("label" => "Tarn-et-Garonne");
	$dep['83'] = array("label" => "Var");
	$dep['84'] = array("label" => "Vaucluse");
	$dep['85'] = array("label" => "Vendée");
	$dep['86'] = array("label" => "Vienne");
	$dep['87'] = array("label" => "Haute-Vienne");
	$dep['88'] = array("label" => "Vosges");
	$dep['89'] = array("label" => "Yonne");
	$dep['90'] = array("label" => "Territoire de Belfort");
	$dep['91'] = array("label" => "Essonne");
	$dep['92'] = array("label" => "Hauts-de-Seine");
	$dep['93'] = array("label" => "Seine-Saint-Denis");
	$dep['94'] = array("label" => "Val-de-Marne");
	$dep['95'] = array("label" => "Val-d'Oise");
	$dep['971'] = array("label" => "Guadeloupe");
	$dep['972'] = array("label" => "Martinique");
	$dep['973'] = array("label" => "Guyane");
	$dep['974'] = array("label" => "La Réunion");
	$dep['975'] = array("label" => "Saint-Pierre et Miquelon");
	$dep['976'] = array("label" => "Mayotte");
	return $dep;
}