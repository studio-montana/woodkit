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

function get_woodkit_icon($icon_name = '', $base64 = false, $dataUri = false, $args = array()) {
	$res = '';
	switch ($icon_name) {
		case 'bear':
			$res = '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 114" style="enable-background:new 0 0 120 114;'.(isset($args['style']) ? ' '.$args['style'] : '').'" xml:space="preserve"><g><path d="M107.1,25.7l-0.2-0.7c5.1-1.7,8.8-6.5,8.8-12.1C115.7,8.6,110,0,102.9,0c-4.9,0-9,2.7-11.2,6.7C84.1,3.4,73.2,0,60,0S35.9,3.4,28.4,6.7C26.2,2.7,22,0,17.1,0C10,0,4.3,8.6,4.3,12.9c0,5.7,3.7,10.4,8.8,12.1l-0.2,0.7L0,68.6c0,0,0,32.6,60,45.4c60-12.9,60-45.4,60-45.4L107.1,25.7z M60,64.3c0,0-25.7,0-21.4-21.5C43.7,17.3,60,17.1,60,17.1s16.3,0.2,21.4,25.8C85.7,64.3,60,64.3,60,64.3z"/><path d="M69.1,41.8c-2.7-1.4-5.4-1.9-7.9-2v-5.5c0-2.5,5.5-3.1,7.4-3.1c0.7,0,1.2-0.5,1.2-1.2c0-3.4-2-9.8-9.8-9.8c-3.4,0-9.8,2-9.8,9.8c0,0.7,0.5,1.2,1.2,1.2c1.9,0,7.4,0.6,7.4,3.1v5.5c-4.5,0.3-7.7,1.9-7.9,2c-0.6,0.3-0.8,1-0.5,1.6s1,0.8,1.6,0.5c0.1,0,8.2-4,16.1,0c0.2,0.1,0.4,0.1,0.5,0.1c0.4,0,0.9-0.2,1.1-0.7C70,42.8,69.7,42.1,69.1,41.8z"/></g></svg>';
		break;
		case 'bear-plain':
			$res = '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 114" style="enable-background:new 0 0 120 114;'.(isset($args['style']) ? ' '.$args['style'] : '').'" xml:space="preserve"><path d="M107.1,25.7l-0.2-0.7c5.1-1.7,8.8-6.5,8.8-12.1C115.7,8.6,110,0,102.9,0c-4.9,0-9,2.7-11.2,6.7C84.1,3.4,73.2,0,60,0S35.9,3.4,28.4,6.7C26.2,2.7,22,0,17.1,0C10,0,4.3,8.6,4.3,12.9c0,5.7,3.7,10.4,8.8,12.1l-0.2,0.7L0,68.6c0,0,0,32.6,60,45.4c60-12.9,60-45.4,60-45.4L107.1,25.7z M69.6,43.4c-0.2,0.4-0.6,0.7-1.1,0.7c-0.2,0-0.4,0-0.5-0.1c-7.9-4-16,0-16.1,0c-0.6,0.3-1.3,0.1-1.6-0.5s-0.1-1.3,0.5-1.6c0.2-0.1,3.4-1.7,7.9-2v-5.5c0-2.6-5.8-3.1-7.4-3.1c-0.7,0-1.2-0.5-1.2-1.2c0-7.7,6.4-9.8,9.8-9.8c7.7,0,9.8,6.4,9.8,9.8c0,0.7-0.5,1.2-1.2,1.2c-1.9,0-7.4,0.6-7.4,3.1v5.5c2.6,0,5.3,0.5,8,1.9C69.7,42.1,69.9,42.8,69.6,43.4z"/></svg>';
		break;
		default: // logo
			$res = '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" style="enable-background:new 0 0 120 120;'.(isset($args['style']) ? ' '.$args['style'] : '').'" xml:space="preserve"><path d="M60.1,0c-33.1,0-60,26.9-60,60c0,33.1,26.9,60,60,60s60-26.9,60-60C120.1,26.9,93.2,0,60.1,0z M103.8,36.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C101.8,39.9,102.7,36.9,103.8,36.9z M88.4,19.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C86.3,22.9,87.3,19.9,88.4,19.9z M77.1,41.5c1.1-6,5.8-13.2,10.8-12.4c5,0.9,7.2,9.5,6.2,15.5c-1.1,6-6.7,9.9-11.7,9.1C77.4,52.9,76,47.6,77.1,41.5z M60.1,9.1c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1S58,14.4,58,13.2C58,12.1,58.9,9.1,60.1,9.1z M60.1,19.9c5.1,0,9.3,10,9.3,15.8s-4.1,10.5-9.3,10.5s-9.3-4.7-9.3-10.5S55,19.9,60.1,19.9z M31.8,19.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C29.7,22.9,30.6,19.9,31.8,19.9z M32.3,29.2c5-0.9,9.7,6.3,10.8,12.4c1.1,6-0.3,11.3-5.3,12.2c-5,0.9-10.6-2.9-11.7-9C25,38.7,27.2,30.1,32.3,29.2z M16.3,36.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C14.2,39.9,15.2,36.9,16.3,36.9z M11.9,62.4c-1.6-4.5,0.3-13.9,4.3-15.4c4-1.5,8.3,7,9.9,11.5c1.6,4.5,1.5,7.3-2.5,8.8C19.6,68.8,13.5,66.9,11.9,62.4z M78.6,101.8c-6.2,0-9.3-3.3-18.5-3.3s-12.4,3.3-18.5,3.3c-9.3,0-17-6.2-17-15.4C24.5,74,38.5,57,60.1,57c21.6,0,35.5,17,35.5,29.4C95.6,95.6,87.9,101.8,78.6,101.8z M96.6,67.3c-4-1.5-4.2-4.3-2.5-8.8c1.6-4.5,5.9-13,9.9-11.5c4,1.5,5.9,10.9,4.3,15.4C106.6,66.9,100.6,68.8,96.6,67.3z"/></svg>';
		break;
	}

	if ($base64) {
		$res = base64_encode($res);
	}
	if ($dataUri) {
		$res = 'data:image/svg+xml;base64,' . $res;
	}
	return $res;
}

function woodkit_get_fonticons_set ($families = null) {
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

		if ($families && !empty($families)) {
			$json_sources = array_filter($json_sources, function ($source_key) use ($families) {
				return in_array($source_key, $families);
			}, ARRAY_FILTER_USE_KEY);
		}

		trace_info("families : " . var_export($families, true));
		trace_info("json_sources : " . var_export($json_sources, true));

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
							trace_warn("Impossible de mettre en cache la police d'icônes car le dossier cible n'existe pas et il n'est impossible de le créer.");
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
					'value' => 'fa-'.$icon_slug,
					'label' => isset($icon['label']) ? $icon['label'] : 'Unknown',
					'search' => isset($icon['search']) && isset($icon['search']['terms']) ? $icon['search']['terms'] : array()
			);
			$styles = isset($icon['styles']) ? $icon['styles'] : array('solid');
			foreach ($styles as $style) {
				if (!isset($set[$style])) {
					$set[$style] = array();
				}
				if ($style == 'brands') {
					$icon_data['value'] = 'fab fa-'.$icon_slug;
				} else if ($style == 'regular') {
					$icon_data['value'] = 'far fa-'.$icon_slug;
				} else if ($style == 'solid') {
					$icon_data['value'] = 'fas fa-'.$icon_slug;
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
