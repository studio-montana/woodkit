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

function seo_auto_update_xmlsitemap(){
	$availables_post_types = get_displayed_post_types();
	seo_update_xmlsitemap($availables_post_types);
}
add_action("save_post", "seo_auto_update_xmlsitemap");
add_action("deleted_post", "seo_auto_update_xmlsitemap");

function seo_get_xmlsitemap_url($params = ""){
	return get_bloginfo('url').'/sitemap.xml'.$params;
}

/**
 * Xml site Map generator
 * @param array $availables_post_types
 * @return true if success, false otherwise
 */
function seo_update_xmlsitemap($availables_post_types){
	$success = false;
	
	// $xmlsitemappath = trailingslashit(get_home_path()) . "sitemap.xml"; makes error with woocommerce payplug/paypal purchase method
	$xmlsitemappath = trailingslashit(ABSPATH) . "sitemap.xml";
	
	if(($fp = @fopen($xmlsitemappath, 'w')) !== FALSE){
		$xml_sitemap = "";
		$xml_sitemap.='<?xml version="1.0" encoding="UTF-8"?>';
		$xsl = locate_web_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SEO_TOOL_NAME.'/xmlsitemap/xmlsitemap.xsl');
		if (!empty($xsl))
			$xml_sitemap.="\n".'<?xml-stylesheet type="text/xsl" href="'.$xsl.'"?>';
		$xml_sitemap.="\n".'<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

		// root
		$lm = intval(get_timestamp_from_mysql(get_lastpostmodified('GMT')));
		$date = date('Y-m-d\TH:i:s+00:00', $lm);
		$xml_sitemap .= "\n\t".'<url>';
		$xml_sitemap .= "\n\t\t".'<loc>'.get_bloginfo('url').'</loc>';
		$xml_sitemap .= "\n\t\t".'<lastmod>'. $date .'</lastmod>';
		$xml_sitemap .= "\n\t\t".'<changefreq>weekly</changefreq>';
		$xml_sitemap .= "\n\t\t".'<priority>1.0</priority>';
		$xml_sitemap .= "\n\t".'</url>';

		if ($availables_post_types){
			// posts
			$posts = get_posts(array(
					'numberposts' => -1,
					'orderby' => 'modified',
					'order'    => 'DESC',
					'post_type' => $availables_post_types,
					'suppress_filters' => true // pour avoir tous les post, y compris les traductions (WPML compatibility)
			));
			foreach($posts as $post) {
				$lm = intval(get_timestamp_from_mysql($post->post_modified_gmt));
				$date = date('Y-m-d\TH:i:s+00:00', $lm);
				$xml_sitemap .= "\n\t".'<url>';
				$xml_sitemap .= "\n\t\t".'<loc>'.get_permalink($post->ID).'</loc>';
				$xml_sitemap .= "\n\t\t".'<lastmod>'.$date.'</lastmod>';
				$xml_sitemap .= "\n\t\t".'<changefreq>weekly</changefreq>';
				$xml_sitemap .= "\n\t\t".'<priority>0.6</priority>';
				$xml_sitemap .= "\n\t".'</url>';
			}
		}

		$xml_sitemap.="\n".'</urlset>';

		// ecriture du fichier
		fwrite($fp, $xml_sitemap);
		fclose($fp);
		$success = true;
	}else{
		trace_err("Impossible d'écrire le fichier : ".trailingslashit(get_home_path())."sitemap.xml");
	}

	return $success;
}