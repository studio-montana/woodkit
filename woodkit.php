<?php
/**
 * Plugin Name: Woodkit
 * Plugin URI: http://www.studio-montana.com/product/woodkit
 * Description: Multitool experience for WP | SEO, security, private site, social publication, breadcrumb, ...
 * Version: 2.0.0
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
define('WOODKIT_PLUGIN_FILE', __FILE__);
define('WOODKIT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WOODKIT_PLUGIN_URI', plugin_dir_url(__FILE__));
define('WOODKIT_PLUGIN_WEB_CACHE_VERSION', '2.0.0');

define('WOODKIT_PLUGIN_COMMONS_TOOLS_FOLDER', 'core/commons/tools/');
define('WOODKIT_PLUGIN_COMMONS_INSTALLER_FOLDER', 'core/commons/installer/');
define('WOODKIT_PLUGIN_TEMPLATES_FOLDER', 'core/templates/');
define('WOODKIT_PLUGIN_TEMPLATES_DASHBOARD_FOLDER', 'core/templates/dashboard/');
define('WOODKIT_PLUGIN_TOOLS_FOLDER', 'core/tools/');
define('WOODKIT_PLUGIN_CSS_FOLDER', 'css/');
define('WOODKIT_PLUGIN_JS_FOLDER', 'js/');
define('WOODKIT_PLUGIN_FONTS_FOLDER', 'fonts/');

define('WOODKIT_URL_DOCUMENTATION', 'https://lab.studio-montana.com/documentation/woodkit');

/**
 * Woodkit PLUGIN DEFINITION
*/
if(!class_exists('Woodkit')){

	class Woodkit{
		
		private static $_this;
		public $tools;

		/**
		 * Construct the plugin object
		 */
		public function __construct(){
			
			// Don't allow more than one instance of the class
			if (isset(self::$_this)) {
				wp_die(sprintf(esc_html__( '%s is a singleton class and you cannot create a second instance.', 'woodkit' ), get_class($this)));
			}
			self::$_this = $this;

			/** plugin textdomain */
			load_plugin_textdomain('woodkit', false, dirname( plugin_basename( __FILE__ ) ).'/lang/' );

			do_action("woodkit_before_requires");

			/** utils */
			require_once (WOODKIT_PLUGIN_PATH.'core/commons/session.php');
			require_once (WOODKIT_PLUGIN_PATH.'core/commons/comparators.php');
			require_once (WOODKIT_PLUGIN_PATH.'core/commons/utils.php');

			/** upgrader */
			if (is_admin()){
				require_once (WOODKIT_PLUGIN_PATH.'core/commons/upgrader.php');
			}

			/** installer */
			require_once (WOODKIT_PLUGIN_PATH.'core/commons/installer/installer.class.php');

			/** config */
			require_once (WOODKIT_PLUGIN_PATH.'core/commons/config/config.php');

			/** gutenberg (must be included before tools) */
			require_once (WOODKIT_PLUGIN_PATH.'gutenberg/index.php');

			/** instanciate tools manager */
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_TOOLS_FOLDER.'index.php');
			$this->tools = new ToolsManager();

			do_action("woodkit_after_requires");

			/** plugin install/uninstall hooks */
			register_activation_hook(__FILE__, array($this, 'activate'));
			register_deactivation_hook(__FILE__, array($this, 'deactivate'));

			/** Woodkit init */
			add_action('init', array($this, 'init'), 1);
		}

		/**
		 * Activate the plugin
		 */
		public function activate(){
			$this->tools->plugin_activation();
		}

		/**
		 * Deactivate the plugin
		 */
		public function deactivate(){
			$this->tools->plugin_deactivation();
		}

		public static function get_info($name){
			$plugin_data = get_plugin_data(__FILE__);
			return $plugin_data[$name];
		}

		/**
		 * Init
		 */
		public function init() {
			
			/** start PHP session (maybe used by tools) */
			if (class_exists('WoodkitSession')) {
				WoodkitSession::start();
			}
			
			if (class_exists('WoodkitInstaller')) {
				WoodkitInstaller::init();
			}
			
			if (is_admin()){
				/** save woodkit config */
				if (class_exists("WoodkitConfig")){
					WoodkitConfig::save();
				}
				/** save woodkit tools config */
				$this->tools->save_config();
			}
			
			/** launch activated tools */
			$this->tools->launch();

			do_action("woodkit_before_init");

			require_once (WOODKIT_PLUGIN_PATH.'core/init.php');

			do_action("woodkit_after_init");
		}

	}

}

if(class_exists('Woodkit')){

	// instantiate the plugin class
	$GLOBALS['woodkit'] = new Woodkit();
}