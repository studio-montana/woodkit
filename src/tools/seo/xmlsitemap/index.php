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
 * Since WP 5.5, XML sitemap is automatically generated
 */

/**
 * Filters the list of post object sub types available within the sitemap.
 * @link https://developer.wordpress.org/reference/hooks/wp_sitemaps_post_types/
 */
add_filter('wp_sitemaps_post_types', function ($post_types){
	$filtered_post_types = array();
	$xmlsitemap_excluded_posttypes = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "xmlsitemap-excluded-posttypes");
	if (!empty($post_types)) {
		foreach ($post_types as $post_type_slug => $post_type) {
			if (empty($xmlsitemap_excluded_posttypes) || !isset($xmlsitemap_excluded_posttypes[$post_type_slug]) || $xmlsitemap_excluded_posttypes[$post_type_slug] != 'on') {
				$filtered_post_types[$post_type_slug] = $post_type;
			}
		}
	}
	return $filtered_post_types;
});

/**
 * Filter the list of taxonomy object subtypes available within the sitemap.
 * @link https://developer.wordpress.org/reference/hooks/wp_sitemaps_taxonomies/
 */
add_filter('wp_sitemaps_taxonomies', function ($taxonomies){
	$filtered_taxonomies = array();
	$xmlsitemap_excluded_taxonomies = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "xmlsitemap-excluded-taxonomies");
	if (!empty($taxonomies)) {
		foreach ($taxonomies as $taxonomy_slug => $taxonomy) {
			if (empty($xmlsitemap_excluded_taxonomies) || !isset($xmlsitemap_excluded_taxonomies[$taxonomy_slug]) || $xmlsitemap_excluded_taxonomies[$taxonomy_slug] != 'on') {
				$filtered_taxonomies[$taxonomy_slug] = $taxonomy;
			}
		}
	}
	return $filtered_taxonomies;
});

/**
 * Filters the sitemap provider before it is added.
 * #link https://developer.wordpress.org/reference/hooks/wp_sitemaps_add_provider/
 */
add_filter('wp_sitemaps_add_provider', function ($provider, $name){
	$xmlsitemap_excluded_providers = $GLOBALS['woodkit']->tools->get_tool_option(SEO_TOOL_NAME, "xmlsitemap-excluded-providers");
	if (!empty($xmlsitemap_excluded_providers) && isset($xmlsitemap_excluded_providers[$name]) && $xmlsitemap_excluded_providers[$name] == 'on') {
		return false;
	}
	return $provider;
}, 20, 2);

/**
 * Filters whether XML Sitemaps are enabled or not.
 * When XML Sitemaps are disabled via this filter, rewrite rules are still in place to ensure a 404 is returned.
 * @link https://developer.wordpress.org/reference/hooks/wp_sitemaps_enabled/
 */
add_filter('wp_sitemaps_enabled', function ($is_enabled){
	return $is_enabled;
});

/**
 * Filters the maximum number of URLs displayed on a sitemap.
 * @link https://developer.wordpress.org/reference/hooks/wp_sitemaps_max_urls/
 */
add_filter('wp_sitemaps_max_urls', function ($max_urls){
	return $max_urls;
});