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

function get_woodkit_icon($icon_name, $base64 = false, $dataUri = false) {
	$res = '';
	switch ($icon_name) {
		case 'logo-plain':
			$res = '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 99.2 92.1" style="enable-background:new 0 0 99.2 92.1;" xml:space="preserve"><path d="M88.6,21.3l-0.2-0.6c4.2-1.4,7.3-5.4,7.3-10.1C95.7,7.1,90.9,0,85,0c-4,0-7.5,2.2-9.3,5.5C69.5,2.8,60.5,0,49.6,0S29.7,2.8,23.5,5.5C21.7,2.2,18.2,0,14.2,0C8.3,0,3.5,7.1,3.5,10.6c0,4.7,3,8.7,7.3,10.1l-0.2,0.6L0,56.7c0,0,0,24.8,49.6,35.4c49.6-10.6,49.6-35.4,49.6-35.4L88.6,21.3z M57.1,34.5c0.2,0.1,0.4,0.3,0.5,0.6c0.1,0.2,0.1,0.5-0.1,0.8c-0.2,0.4-0.5,0.6-0.9,0.6c-0.2,0-0.3,0-0.4-0.1c-2.5-1.3-5-1.5-7.2-1.4c-1.1,0.1-2.2,0.2-3,0.4c-0.3,0.1-0.6,0.1-0.8,0.2c-0.3,0.1-0.6,0.2-0.8,0.2c-0.1,0-0.2,0.1-0.3,0.1c-0.7,0.2-1.1,0.4-1.1,0.4c-0.5,0.2-1.1,0-1.3-0.4c-0.1-0.1-0.1-0.3-0.1-0.4c0-0.4,0.2-0.8,0.6-1c0.2-0.1,2.8-1.4,6.5-1.6v-4.6c0-2-4.2-2.5-5.8-2.5c-0.1,0-0.2,0-0.3,0c-0.1,0-0.2,0-0.3-0.1c0,0-0.1,0-0.1,0c0,0,0,0,0,0c-0.3-0.2-0.6-0.5-0.6-0.9c0-1.6,0.3-2.9,0.9-4c1.6-3.2,5.1-4.1,7.2-4.1c6.4,0,8.1,5.3,8.1,8.1c0,0.6-0.4,1-1,1c-1.6,0-6.1,0.5-6.1,2.5v4.5C52.6,33,54.9,33.4,57.1,34.5z"/></svg>';
		break;
		case 'seo':
			$res = '<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 85 49.5" style="enable-background:new 0 0 85 49.5;" xml:space="preserve"><g><path d="M60.7,17.4c-4.1,0-7.4,3.3-7.4,6.9c0,4.5,3.3,7.8,7.4,7.8c4.1,0,7.4-3.3,7.4-7.8C68.1,20.7,64.7,17.4,60.7,17.4z"/><path d="M82.4,18.8L63.5,2c-1.4-1.3-3.3-2-5.3-2H7.9C3.5,0,0,3.5,0,7.9v33.6c0,4.4,3.5,7.9,7.9,7.9h50.4c1.9,0,3.8-0.7,5.3-2l18.9-16.8C85.9,27.5,85.9,22,82.4,18.8z M22.5,36c-2,1.7-4.8,2.5-7.4,2.5c-3.3,0-6.5-1.1-9.2-3L8.8,30c1.7,1.5,3.7,2.7,6,2.7c1.6,0,3.3-0.8,3.3-2.6c0-1.9-2.7-2.6-4.1-3C9.8,25.9,7,24.8,7,19.7c0-5.3,3.8-8.8,9-8.8c2.6,0,5.9,0.8,8.2,2.2l-2.7,5.3c-1.2-1-2.8-1.7-4.5-1.7c-1.2,0-2.9,0.7-2.9,2.2c0,1.5,1.8,2.1,3,2.5l1.7,0.5c3.6,1.1,6.5,2.9,6.5,7.1C25.2,31.6,24.6,34.3,22.5,36z M43.3,17.4h-8.1v4.4h7.7v5.8h-7.7V32h8.1v5.8H28.5V11.6h14.9V17.4z M60.7,38.7c-8.4,0-14.5-6-14.5-14.4c0-7.9,6.9-13.5,14.5-13.5c7.5,0,14.5,5.5,14.5,13.5C75.1,32.7,69.1,38.7,60.7,38.7z"/></g></svg>';
		break;
		default: // logo
			$res = '<svg version="1.1" id="woodkit-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 99.2 92.1" style="enable-background:new 0 0 99.2 92.1;" xml:space="preserve"><g><path d="M88.6,21.3l-0.2-0.6c4.2-1.4,7.3-5.4,7.3-10.1C95.7,7.1,90.9,0,85,0c-4,0-7.5,2.2-9.3,5.5C69.5,2.8,60.5,0,49.6,0S29.7,2.8,23.5,5.5C21.7,2.2,18.2,0,14.2,0C8.3,0,3.5,7.1,3.5,10.6c0,4.7,3,8.7,7.3,10.1l-0.2,0.6L0,56.7c0,0,0,24.8,49.6,35.4c49.6-10.6,49.6-35.4,49.6-35.4L88.6,21.3z M49.6,53.1c0,0-21.3,0-17.7-17.7c4.2-21.1,17.7-21.3,17.7-21.3s13.5,0.1,17.7,21.3C70.9,53.1,49.6,53.1,49.6,53.1z"/><path d="M56.7,25.8c0.6,0,1-0.4,1-1c0-2.8-1.7-8.1-8.1-8.1c-2.1,0-5.6,1-7.2,4.1c-0.5,1.1-0.9,2.4-0.9,4c0,0.4,0.2,0.7,0.6,0.9l0,0h0.1c0.1,0,0.2,0.1,0.3,0.1s0.2,0,0.3,0c1.6,0.1,5.8,0.6,5.8,2.5v4.6c-3.7,0.3-6.4,1.5-6.5,1.6c-0.4,0.2-0.6,0.6-0.6,1c0,0.1,0,0.3,0.1,0.4c0.2,0.5,0.8,0.7,1.3,0.4c0,0,0.4-0.2,1.1-0.4c0.1,0,0.2-0.1,0.3-0.1c0.2-0.1,0.5-0.2,0.8-0.2c0.3-0.1,0.5-0.1,0.8-0.2c0.9-0.2,1.9-0.4,3-0.4c2.2-0.1,4.7,0.2,7.2,1.4c0.1,0.1,0.3,0.1,0.4,0.1c0.4,0,0.7-0.2,0.9-0.6c0.1-0.2,0.1-0.5,0.1-0.8c-0.1-0.2-0.3-0.5-0.5-0.6c-2.3-1.1-4.5-1.6-6.5-1.7v-4.5C50.6,26.3,55.1,25.8,56.7,25.8z"/></g></svg>';
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
