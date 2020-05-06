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

class WoodkitInstaller {
	
	public static $API_URL = 'https://lab.studio-montana.com/woodapi';
	public static $API_ZIP_PACKAGE_BASE = 'studio-montana';
	public static $API_INTERVAL = 'PT1H'; // 1h : PT1H - 5sec : PT5S
	
	public static function init () {
		if (is_admin()) {
			self::admin_init();
		}
	}
	
	private static function admin_init () {
		/**
		 * Plugin uploader
		 * IMPORTANT : do not check !is_defined('DOING_AJAX') or !is_defined('AUTOSAVE') => it breaks plugin rename after update
		 */
		require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_INSTALLER_FOLDER.'plugin-uploader.class.php');
		new WoodkitPluginUploader('woodkit', WP_PLUGIN_DIR.'/woodkit/woodkit.php');
		new WoodkitPluginUploader('woodmanager', WP_PLUGIN_DIR.'/woodmanager/woodmanager.php');
		
		/**
		 * Theme uploader
		 * IMPORTANT : do not check !is_defined('DOING_AJAX') or !is_defined('AUTOSAVE') => it breaks theme rename after update
		 */
		require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_COMMONS_INSTALLER_FOLDER.'theme-uploader.class.php');
		new WoodkitThemeUploader('woody');
		new WoodkitThemeUploader('wooden');
		
		/**
		 * Plugin install
		 */
		static $install = -1;
		if ($install === -1 && !defined('DOING_AJAX') && !defined('DOING_AUTOSAVE') && function_exists("get_plugin_data")){
			$install = false;
			$notif = get_option("woodkit-init-notification", null);
			$plugin_data = get_plugin_data(WP_PLUGIN_DIR.'/woodkit/woodkit.php');
			$website_notif = hash('md5', get_site_url().$plugin_data["Version"]);
			if (!empty($notif) && $notif == $website_notif){
				$install = true;
			}
			if (!$install){
				$url = self::$API_URL . '/install';
				$url = add_query_arg(array("package" => 'woodkit'), $url);
				$url = add_query_arg(array("host" => get_site_url()), $url);
				$url = add_query_arg(array("version" => $plugin_data["Version"]), $url);
				$request_body = wp_remote_retrieve_body(wp_remote_get($url));
				if (!empty($request_body)) {
					$request_body = @json_decode($request_body);
					if (isset($request_body->install) && $request_body->install == true){
						$install = true;
						update_option('woodkit-init-notification', $website_notif);
					}
				}
			}
		}
	}
	
	public static function is_registered ($force_reload = false) {
		static $ac = -1;
		if ($ac === -1 || $force_reload) {
			$ac = false;
			$reload = true;
			$already_activated = false;
			$key_changed = false;
			$last_update = get_option('woodkit-activated-update', null);
			$now = new DateTime();
			if ($last_update != null){
				$last_update->add(new DateInterval(self::$API_INTERVAL));
				if ($last_update > $now){
					$already_activated = true;
				}
			}
			$key = woodkit_get_option("key-activation", "");
			$old_key = get_option('woodkit-old-key-activation', null);
			if (empty($old_key) || $old_key != $key){
				$key_changed = true;
			}
			if (!$key_changed && $already_activated){
				$reload = false;
			}
			if ($reload){
				$ac = false;
				$url = self::$API_URL . '/active';
				$url = add_query_arg(array("package" => 'woodkit'), $url);
				$url = add_query_arg(array("host" => get_site_url()), $url);
				$url = add_query_arg(array("api-key" => $key), $url);
				$request_body = wp_remote_retrieve_body(wp_remote_get($url));
				if (!empty($request_body)) {
					$request_body = @json_decode($request_body);
					if (isset($request_body->active) && $request_body->active == true)
						$ac = true;
				}
				if ($last_update != null){
					delete_option('woodkit-activated-update');
				}
				if ($ac) {
					add_option('woodkit-activated-update', $now, '', 'no');
				}
				if ($old_key != null) {
					delete_option('woodkit-old-key-activation');
				}
				add_option('woodkit-old-key-activation', $key, '', 'no');
			}else{
				$ac = $already_activated;
			}
		}
		return $ac;
	}
	
	public static function after_auto_update ($package, $version) {
		$url = self::$API_URL . '/update';
		$url = add_query_arg(array("package" => $package), $url);
		$url = add_query_arg(array("host" => get_site_url()), $url);
		$url = add_query_arg(array("version" => $version), $url);
		wp_remote_get($url);
	}
	
}