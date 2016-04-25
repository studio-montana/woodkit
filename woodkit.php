<?php

/**
 * Plugin Name: Woodkit
 * Plugin URI: http://www.studio-montana.com/product/woodkit
 * Description: Multitool experience for WP | SEO, security, masonry, private site, social publication, ...
 * Version: 1.1.16
 * Author: Studio Montana
 * Author URI: http://www.studio-montana.com/
 * License: GPL2
 * Text Domain: woodkit
 */

/**
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
 * Woodkit PLUGIN CONSTANTS
*/
define('WOODKIT_PLUGIN_NAME', "woodkit");
define('WOODKIT_PLUGIN_FILE', __FILE__);
define('WOODKIT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WOODKIT_PLUGIN_URI', plugin_dir_url(__FILE__));
define('WOODKIT_PLUGIN_SLUG_INSTALLER', 'woodkit');

define('WOODKIT_PLUGIN_TEXT_DOMAIN', 'woodkit');
define('WOODKIT_PLUGIN_CORE_FOLDER', 'core/');
define('WOODKIT_PLUGIN_COMMONS_FOLDER', 'core/commons/');
define('WOODKIT_PLUGIN_CONFIG_FOLDER', 'core/commons/config/');
define('WOODKIT_PLUGIN_INSTALLER_FOLDER', 'core/commons/installer/');
define('WOODKIT_PLUGIN_TEMPLATES_FOLDER', 'core/templates/');
define('WOODKIT_PLUGIN_TEMPLATES_DASHBOARD_FOLDER', 'core/templates/dashboard/');
define('WOODKIT_PLUGIN_TOOLS_FOLDER', 'core/tools/');
define('WOODKIT_PLUGIN_CSS_FOLDER', 'css/');
define('WOODKIT_PLUGIN_JS_FOLDER', 'js/');
define('WOODKIT_PLUGIN_FONTS_FOLDER', 'fonts/');

define('WOODKIT_URL_DOCUMENTATION', 'http://lab.studio-montana.com/documentation/woodkit/');
define('WOODKIT_URL_API', 'http://api.studio-montana.com');
define('WOODKIT_INTERVAL_API', 'PT1H');

/**
 * Woodkit PLUGIN DEFINITION
*/
if(!class_exists('Woodkit')){

	class Woodkit{

		/**
		 * Construct the plugin object
		 */
		public function __construct(){

			load_plugin_textdomain('woodkit', false, dirname( plugin_basename( __FILE__ ) ).'/lang/' );
				
			do_action("woodkit_before_requires");
				
			/** utils */
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'session.php');
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'comparators.php');
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'utils.php');
				
			/** installer */
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_INSTALLER_FOLDER.'installer.class.php');

			/** config */
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_CONFIG_FOLDER.'config.php');
				
			/** woodkit fields */
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'custom-fields.php');
				
			/** pickers */
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'postpicker/postpicker.php');
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'iconpicker/iconpicker.php');
				
			/** tools */
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'tools.php');
				
			do_action("woodkit_after_requires");
				
			add_action("init", array('Woodkit', 'init'));

		}

		/**
		 * Activate the plugin
		 */
		public static function activate(){
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'plugin.activate.php');
		}

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate(){
			require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_COMMONS_FOLDER.'plugin.deactivate.php');
		}
		
		public static function get_info($name){
			$plugin_data = get_plugin_data(__FILE__);
			return $plugin_data[$name];
		}

		/**
		 * Load plugin textdomain.
		 */
		public static function init() {
				
			do_action("woodkit_before_init");
				
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_CORE_FOLDER.'init.php');
				
			do_action("woodkit_after_init");
		}

	}


}

if(class_exists('Woodkit')){

	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Woodkit', 'activate'));
	register_deactivation_hook(__FILE__, array('Woodkit', 'deactivate'));

	// instantiate the plugin class
	$woodkit_plugin = new Woodkit();
}