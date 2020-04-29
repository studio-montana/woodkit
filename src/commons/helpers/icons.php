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

function woodkit_get_fonticons_set () {
	static $fonticons_set = -1;
	if ($fonticons_set == -1) {
		$fonticons_set = array();
		
		/** Load JSONs */
		$json_sources = array(
				'dashicons' => array(
						'file' => WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TEMPLATES_FONTS_FOLDER.'dashicons/icons.json'
				),
				'fontawesome' => array(
						'file' => WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TEMPLATES_FONTS_FOLDER.'fontawesome-free-5.13.0-web/metadata/icons.json',
						'cache_file' => WP_CONTENT_DIR.'/cache/woodkit/fonticons/fontawesome.json',
						'parse_callback' => 'woodkit_parse_fontawesome_icons_json',
				)
		);
		$json_sources = apply_filters('woodkit_fonticons_json_sources', $json_sources);
		if (!empty($json_sources)) {
			foreach ($json_sources as $source) {
				$json_file = isset($source['file']) ? $source['file'] : false;
				$json_cache_file = isset($source['cache_file']) ? $source['cache_file'] : false;
				$parse_callback = isset($source['parse_callback']) ? $source['parse_callback'] : false;
				if ($json_cache_file && file_exists($json_cache_file)) {
					$parse_callback = false;
					$json_file = $json_cache_file;
				}
				if (!$json_file) {
					continue;
				}
				$json_file_content = file_get_contents($json_file);
				if (!$json_file_content) {
					continue;
				}
				$json_data = json_decode($json_file_content, true);
				if (!$json_data) {
					continue;
				}
				if ($parse_callback && function_exists($parse_callback)) {
					$json_data = call_user_func($parse_callback, $json_data);
				}
				if ($json_data) {
					$fonticons_set = array_merge($fonticons_set, $json_data);
					if ($json_cache_file && !file_exists($json_cache_file)) { // mise en cache si nécessaire
						$cache_dir = dirname($json_cache_file);
						$has_dir = is_dir($cache_dir);
						if (!$has_dir) {
							$has_dir = mkdir($cache_dir, 0755, true);
						}
						if ($has_dir) {
							$fp = fopen($json_cache_file, 'w');
							fwrite($fp, json_encode($json_data));
							fclose($fp);
						} else {
							trace_err("Impossible de mettre en cache la police d'icônes car le dossier cible n'existe pas et il n'est impossible de le créer.");
						}
					}
				}
			}
		}
	}
	return $fonticons_set;
}

/**
 * Parse le fichier icons.json de FontAwesome
 * On ne s'emmerde pas avec un parsing manuel, FA nous fournit sont icons.json (dans le zip/metadata/)
 * On le parse pour créer le format qui nous intéresse (et surtout on l'allège)
 * Pour en savoir plus sur ces fichiers : https://fontawesome.com/how-to-use/on-the-web/setup/hosting-font-awesome-yourself
 */
function woodkit_parse_fontawesome_icons_json ($json) {
	$res = array();
	if ($json) {
		$set = array();
		foreach ($json as $icon_slug => $icon) {
			$icon_data = array(
					'value' => $icon_slug,
					'label' => isset($icon['label']) ? $icon['label'] : 'Unknown',
					'search' => isset($icon['search']) && isset($icon['search']['terms']) ? $icon['search']['terms'] : array()
			);
			$styles = isset($icon['styles']) ? $icon['styles'] : array('solid');
			foreach ($styles as $style) {
				if (!isset($set[$style])) {
					$set[$style] = array();
				}
				$set[$style][] = $icon_data;
			}
		}
		foreach ($set as $icons_set_slug => $icons_set) {
			$res[] = array(
					"title" => "FontAwesome {$icons_set_slug}",
					'icons' => $icons_set
			);
		}
	}
	return $res;
}
