<?php
/**
 * Plugin Name: Woodkit
 * Plugin URI: http://www.studio-montana.com/product/woodkit
 * Description: Multitool experience for WP | SEO, security, masonry, private site, social publication, ...
 * Version: 1.3.12
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
define('WOODKIT_PLUGIN_WEB_CACHE_VERSION', '1.3.11');

define('WOODKIT_PLUGIN_TEXT_DOMAIN', 'woodkit');
define('WOODKIT_PLUGIN_CORE_FOLDER', 'core/');
define('WOODKIT_PLUGIN_COMMONS_FOLDER', 'core/commons/');
define('WOODKIT_PLUGIN_COMMONS_TOOLS_FOLDER', 'core/commons/tools/');
define('WOODKIT_PLUGIN_COMMONS_CONFIG_FOLDER', 'core/commons/config/');
define('WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER', 'core/commons/divi/');
define('WOODKIT_PLUGIN_COMMONS_LOCALSTORAGE_FOLDER', 'core/commons/localstorage/');
define('WOODKIT_PLUGIN_COMMONS_INSTALLER_FOLDER', 'core/commons/installer/');
define('WOODKIT_PLUGIN_TEMPLATES_FOLDER', 'core/templates/');
define('WOODKIT_PLUGIN_TEMPLATES_DASHBOARD_FOLDER', 'core/templates/dashboard/');
define('WOODKIT_PLUGIN_TOOLS_FOLDER', 'core/tools/');
define('WOODKIT_PLUGIN_CSS_FOLDER', 'css/');
define('WOODKIT_PLUGIN_JS_FOLDER', 'js/');
define('WOODKIT_PLUGIN_FONTS_FOLDER', 'fonts/');

define('WOODKIT_URL_DOCUMENTATION', 'https://lab.studio-montana.com/documentation/woodkit');
define('WOODKIT_URL_API', 'https://api.studio-montana.com');
define('WOODKIT_GITHUB_BASE_PACKAGE', 'studio-montana');
define('WOODKIT_INTERVAL_API', 'PT1H');

/**
 * Woodkit PLUGIN DEFINITION
*/
if(!class_exists('Woodkit')){

	class Woodkit{
		
		private static $_this;

		/**
		 * Construct the plugin object
		 */
		public function __construct(){
			
			// Don't allow more than one instance of the class
			if (isset(self::$_this)) {
				wp_die(sprintf(esc_html__( '%s is a singleton class and you cannot create a second instance.', WOODKIT_PLUGIN_TEXT_DOMAIN ), get_class($this)));
			}
			self::$_this = $this;

			load_plugin_textdomain('woodkit', false, dirname( plugin_basename( __FILE__ ) ).'/lang/' );

			do_action("woodkit_before_requires");

			/** utils */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'session.php');
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'comparators.php');
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'utils.php');

			/** upgrader */
			if (is_admin()){
				require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'upgrader.php');
			}

			/** installer */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_INSTALLER_FOLDER.'installer.class.php');

			/** config */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_CONFIG_FOLDER.'config.php');

			/** customizer tools */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'customizer.php');

			/** custom fields */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'custom-fields.php');

			/** pickers */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'postpicker/postpicker.php');
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'iconpicker/iconpicker.php');

			/** embed */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'embed.php');

			/** tools */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_TOOLS_FOLDER.'tools.php');

			/** localstorage */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_LOCALSTORAGE_FOLDER.'localstorage.php');

			/** divi */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_DIVI_FOLDER.'divi.php');

			do_action("woodkit_after_requires");

			/** Woodkit init
			 * @priority: 1 - important to be launch before other plugins init action hook (like Contact Form 7)
			 */
			add_action('init', array('Woodkit', 'init'), 1); // All Tool 'init' add_action must be greater than 1

		}

		/**
		 * Activate the plugin
		 */
		public static function activate(){
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'plugin.activate.php');
		}

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate(){
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'plugin.deactivate.php');
		}

		public static function get_info($name){
			$plugin_data = get_plugin_data(__FILE__);
			return $plugin_data[$name];
		}

		/**
		 * Init
		 */
		public static function init() {
			
			if (is_admin()){
				/** save woodkit options (always before 'launch woodkit tools') */
				if (class_exists("WoodkitOptions")){
					WoodkitOptions::save();
				}
				/** save woodkit tools options (always before 'launch woodkit tools') */
				if (function_exists("woodkit_plugin_tools_config_save")){
					woodkit_plugin_tools_config_save();
				}
			}
			
			/** launch activated tools (always after 'save woodkit options') */
			if (function_exists("woodkit_launch_tools")){
				woodkit_launch_tools();
			}
			
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_FOLDER.'plugin.init.php');

			do_action("woodkit_before_init");
				
			Woodkit::set_image_sizes();

			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_CORE_FOLDER.'init.php');

			do_action("woodkit_after_init");
		}

		public static function set_image_sizes(){
			$sizes = Woodkit::get_image_sizes();
			if (!empty($sizes)){
				foreach ($sizes as $size_slug => $size_args){
					add_image_size($size_slug, $size_args['width'], $size_args['height'], $size_args['crop']);
				}
			}
		}

		public static function get_image_sizes(){
			$sizes = array();
			$sizes['woodkit-1200'] = array(
					"label" => __("1200px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 1200,
					"height" => 0,
					"crop" => true);
			$sizes['woodkit-1024'] = array(
					"label" => __("1024px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 1024,
					"height" => 0,
					"crop" => true);
			$sizes['woodkit-800'] = array(
					"label" => __("800px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 800,
					"height" => 0,
					"crop" => true);
			$sizes['woodkit-600'] = array(
					"label" => __("600px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 600,
					"height" => 0,
					"crop" => true);
			$sizes['woodkit-400'] = array(
					"label" => __("400px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 400,
					"height" => 0,
					"crop" => true);
			$sizes['woodkit-300'] = array(
					"label" => __("300px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 300,
					"height" => 0,
					"crop" => true);
			$sizes['woodkit-100'] = array(
					"label" => __("100px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 300,
					"height" => 0,
					"crop" => false);
			$sizes['woodkit-150-150'] = array(
					"label" => __("150x150px", WOODKIT_PLUGIN_TEXT_DOMAIN),
					"width" => 150,
					"height" => 150,
					"crop" => true);
			return $sizes;
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