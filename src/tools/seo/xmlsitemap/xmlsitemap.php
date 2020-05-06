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

function woodkit_seo_get_xmlsitemap_url($params = ""){
	return get_bloginfo('url').'/sitemap.xml'.$params;
}

function woodkit_seo_auto_update_xmlsitemap(){
	$availables_post_types = get_displayed_post_types();
	woodkit_seo_update_xmlsitemap($availables_post_types);
}
add_action("save_post", "woodkit_seo_auto_update_xmlsitemap");
add_action("deleted_post", "woodkit_seo_auto_update_xmlsitemap");
add_action("tool_xmlsitemap_update", "woodkit_seo_auto_update_xmlsitemap");

/**
 * Xml site Map generator
 * @param array $availables_post_types
 * @return true if success, false otherwise
*/
function woodkit_seo_update_xmlsitemap($availables_post_types){
	$success = false;

	$xmlsitemap_active = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "xmlsitemap-active");
	if ($xmlsitemap_active == "on"){

		// xmlsitemap urls options (additionals or excluded)
		$sitemap_urls = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "options-sitemap-urls");
		$additional_urls = array();
		$excluded_if_equals_urls = array();
		$excluded_if_contains_urls = array();
		$excluded_if_regexp_urls = array();
		if (!empty($sitemap_urls)){
			foreach ($sitemap_urls as $k => $item){
				$url = !empty($item['url']) ? esc_attr($item['url']) : "";
				$action = !empty($item['action']) ? esc_attr($item['action']) : "";
				if (!empty($url) && $action == 'add'){
					$additional_urls[] = $url;
				}else if(!empty($url) && $action == 'exclude_if_equals'){
					$excluded_if_equals_urls[] = $url;
				}else if(!empty($url) && $action == 'exclude_if_contains'){
					$excluded_if_contains_urls[] = $url;
				}else if(!empty($url) && $action == 'exclude_if_regexp'){
					$excluded_if_regexp_urls[] = $url;
				}
			}
		}


		// --- URLs
		$urls = array();

		// root
		$lm = intval(get_timestamp_from_mysql(get_lastpostmodified('GMT')));
		$date = date('Y-m-d\TH:i:s+00:00', $lm);
		$urls[] = array('loc' => get_bloginfo('url'), 'lastmod' => $date, 'changefreq' => 'weekly', 'priority' => '1.0');

		// posts
		if ($availables_post_types){
			$posts = get_posts(array(
					'numberposts' => -1,
					'orderby' => 'modified',
					'order'    => 'DESC',
					'post_type' => $availables_post_types,
					'suppress_filters' => true // WPML compatibility to include all posts
			));
			foreach($posts as $post) {
				$lm = intval(get_timestamp_from_mysql($post->post_modified_gmt));
				$date = date('Y-m-d\TH:i:s+00:00', $lm);
				$urls[] = array('loc' => get_permalink($post->ID), 'lastmod' => $date, 'changefreq' => 'weekly', 'priority' => '0.6');
			}
		}

		// sitemap adds
		if (!empty($additional_urls)){
			foreach ($additional_urls as $url){
				if (!woodkit_seo_is_excluded_url($url, $excluded_if_equals_urls, $excluded_if_contains_urls, $excluded_if_regexp_urls)){
					$date = date('Y-m-d\TH:i:s+00:00');
					$urls[] = array('loc' => $url, 'lastmod' => $date, 'changefreq' => 'weekly', 'priority' => '0.6');
				}
			}
		}



		// $xmlsitemappath = trailingslashit(get_home_path()) . "sitemap.xml"; makes error with woocommerce payplug/paypal purchase method
		$xmlsitemappath = trailingslashit(ABSPATH) . "sitemap.xml";

		if(($fp = @fopen($xmlsitemappath, 'w')) !== FALSE){
			$xml_sitemap = "";
			$xml_sitemap.='<?xml version="1.0" encoding="UTF-8"?>';
			$xsl = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/xmlsitemap/xmlsitemap.xsl');
			if (!empty($xsl))
				$xml_sitemap.="\n".'<?xml-stylesheet type="text/xsl" href="'.$xsl.'"?>';
			$xml_sitemap.="\n".'<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

			// loop for urls and test
			if (!empty($urls)){
				foreach ($urls as $url){
					if (!woodkit_seo_is_excluded_url($url['loc'], $excluded_if_equals_urls, $excluded_if_contains_urls, $excluded_if_regexp_urls)){
						$xml_sitemap .= "\n\t".'<url>';
						$xml_sitemap .= "\n\t\t".'<loc>'.$url['loc'].'</loc>';
						$xml_sitemap .= "\n\t\t".'<lastmod>'. $url['lastmod'] .'</lastmod>';
						$xml_sitemap .= "\n\t\t".'<changefreq>'. $url['changefreq'] .'</changefreq>';
						$xml_sitemap .= "\n\t\t".'<priority>'. $url['priority'] .'</priority>';
						$xml_sitemap .= "\n\t".'</url>';
					}
				}
			}

			$xml_sitemap.="\n".'</urlset>';

			// ecriture du fichier
			fwrite($fp, $xml_sitemap);
			fclose($fp);
			$success = true;

			woodkit_seo_notify_searchengines();

		}else{
			trace_err("Impossible d'écrire le fichier : ".trailingslashit(get_home_path())."sitemap.xml");
		}
	}
	return $success;
}

function woodkit_seo_notify_searchengines(){
	$xmlsitemap_active = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "xmlsitemap-active");
	if ($xmlsitemap_active == "on"){
		$notify_searchengines = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "xmlsitemap-notification-active");
		if ($notify_searchengines == "on"){
			$sitemap_url = woodkit_seo_get_xmlsitemap_url();
			$success = true;
			if (!empty($sitemap_url)){
				$curl_req = array();
				$urls = array();
				// below are the SEs that we will be pining
				$urls[] = "http://www.google.com/webmasters/tools/ping?sitemap=".urlencode($sitemap_url);
				$urls[] = "http://www.bing.com/webmaster/ping.aspx?siteMap=".urlencode($sitemap_url);
				$urls[] = "http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=YahooDemo&amp;url=".urlencode($sitemap_url);
				$urls[] = "http://submissions.ask.com/ping?sitemap=".urlencode($sitemap_url);

				foreach ($urls as $url){
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURL_HTTP_VERSION_1_1, 1);
					$curl_req[] = $curl;
				}

				//initiating multi handler
				$multiHandle = curl_multi_init();

				// adding all the single handler to a multi handler
				foreach($curl_req as $key => $curl){
					curl_multi_add_handle($multiHandle,$curl);
				}
				$isactive = null;
				do{
					$multi_curl = curl_multi_exec($multiHandle, $isactive);
				}while ($isactive || $multi_curl == CURLM_CALL_MULTI_PERFORM);

				$success = true;
				foreach($curl_req as $curlO){
					if(curl_errno($curlO) != CURLE_OK){
						$success = false;
					}
				}
				curl_multi_close($multiHandle);
			}
			return $success;
		}
	}
	return false;
}

function woodkit_seo_is_excluded_url($url, $excluded_if_equals_urls = array(), $excluded_if_contains_urls = array(), $excluded_if_regexp_urls = array()){
	$excluded = false;

	// equals
	if (!empty($excluded_if_equals_urls)){
		foreach ($excluded_if_equals_urls as $equals){
			if ($url == $equals){
				$excluded = true;
				break;
			}
		}
	}

	// contains
	if (!empty($excluded_if_contains_urls) && !$excluded){
		foreach ($excluded_if_contains_urls as $contains){
			if (strpos($url, $contains) !== false) {
				$excluded = true;
				break;
			}
		}
	}

	// regexp
	if (!empty($excluded_if_regexp_urls) && !$excluded){
		foreach ($excluded_if_regexp_urls as $regexp){
			if (preg_match($regexp, $url)) {
				$excluded = true;
				break;
			}
		}
	}

	return $excluded;
}