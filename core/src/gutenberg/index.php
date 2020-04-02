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

if (!class_exists('WOODKITGUTEN')) {

	define('WOODKITGUTEN_SRC_PATH', WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_GUTENBERG_FOLDER);
	define('WOODKITGUTEN_SRC_URI', WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_GUTENBERG_FOLDER);

	/**
	 * This class is Gutenberg Woodkit support entry point,
	 * it enables and improves tool's Gutenberg modules developments
	 */
	class WOODKITGUTEN{
		
		/**
		 * woodkitguten : zone Gutenberg pour Woodkit
		 * Namespace : wkg
		 * Prefix : wkg_
		 */

		public function __construct(){

			/** Helpers */
			require_once (WOODKITGUTEN_SRC_PATH.'inc/helpers/index.php');

			/** Rest api */
			require_once (WOODKITGUTEN_SRC_PATH.'inc/rest/index.php');

			/** Main classes */
			require_once (WOODKITGUTEN_SRC_PATH.'inc/wkg-module.class.php');
			require_once (WOODKITGUTEN_SRC_PATH.'inc/wkg-module-block.class.php');
			require_once (WOODKITGUTEN_SRC_PATH.'inc/wkg-module-plugin.class.php');

			/** admin scripts / styles */
			add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
		}

		public function admin_scripts () {
			// Skip if Gutenberg is not enabled/merged.
			if (!function_exists('register_block_type')) {
				return;
			}
			$stores_uri = WOODKITGUTEN_SRC_URI . 'stores/build.js';
			$stores_path = WOODKITGUTEN_SRC_PATH . 'stores/build.js';
			wp_enqueue_script('wkg-general-stores', $stores_uri, array(), filemtime($stores_path));
			$style_uri = WOODKITGUTEN_SRC_URI . 'assets-css/editor.css';
			$style_path = WOODKITGUTEN_SRC_PATH . 'assets-css/editor.css';
			wp_enqueue_style('wkg-general-editor', $style_uri, array(), filemtime($style_path));
		}
	}

	/**
	 * Instantiate
	 */
	$GLOBALS['wkg'] = new WOODKITGUTEN();
}
