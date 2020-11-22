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

class WoodkitPluginUploader {

	private $slug;
	private $package;
	private $pluginData;
	private $pluginFile;
	private $APIResult;

	function __construct($package, $pluginFile) {
		
		$this->package = $package;
		$this->pluginFile = $pluginFile;
		$this->slug = plugin_basename($this->pluginFile);

		if (file_exists($this->pluginFile)){
			add_filter("plugins_api", array( $this, "setPluginInfo" ), 10, 3);
			add_filter('site_transient_update_plugins', array( $this, 'setTransitent'), 10, 1);
			add_filter("pre_set_site_transient_update_plugins", array( $this, "setTransitent" ), 10, 1);
			add_filter("upgrader_post_install", array( $this, "postInstall" ), 10, 3);
		}
	}

	// Get plugin information
	private function initPluginData() {
		$this->pluginData = get_plugin_data($this->pluginFile);
	}

	// Get information regarding our plugin from API
	private function getRepoReleaseInfo() {

		if (!WoodkitInstaller::is_registered())
			return;

		if (!empty($this->APIResult))
			return;

		$reload = true;
		$now = new DateTime();
		$last_update = get_option($this->package.'-last-update-latest-release', null);
		$latestrelease = get_option($this->package.'-latest-release', null);
		if ($last_update != null){
			$last_update->add(new DateInterval(WoodkitInstaller::$API_INTERVAL));
			if ($last_update > $now){
				$reload = false;
			}
		}

		if ($reload){
			$key = woodkit_get_option("key-activation");
			$url = WoodkitInstaller::$API_URL . '/latestrelease';
			$url = add_query_arg(array("package" => $this->package), $url);
			$url = add_query_arg(array("host" => get_site_url()), $url);
			$url = add_query_arg(array("key" => $key), $url);
			$url = add_query_arg(array("version" => $this->pluginData["Version"]), $url);
			// trace_info("WoodkitPluginUploader check latestrelease for package [{$this->slug}] : " . var_export($remote_result, true));
			$remote_result = wp_remote_retrieve_body(wp_remote_get($url));
			// trace_info("Woodkit check latestrelease for package [{$this->package}] : " . var_export($remote_result, true));
			if (!empty($remote_result)) {
				$this->APIResult = @json_decode($remote_result);
				// update release
				update_option($this->package.'-latest-release', $remote_result);
				// update date
				update_option($this->package.'-last-update-latest-release', $now);
			}
		}else{
			$this->APIResult = @json_decode($latestrelease);
		}
	}

	// Push in plugin version information to get the update notification
	public function setTransitent($transient) {
		
		if(empty($transient->checked[$this->slug])) {
			return $transient;
		}

		if(!empty($transient->response[$this->slug])) {
			return $transient;
		}

		if (!is_object($transient)) {
			return $transient;
		}

		if (!WoodkitInstaller::is_registered()) {
			return $transient;
		}

		// Plugin informations
		$this->initPluginData();
		if (!$this->pluginData || is_wp_error($this->pluginData)) {
			// maybe plugin is not installed on this website
			trace_warn("Woodkit Plugin Installer - setTransitent - Plugin [{$this->slug}] not available ");
			return $transient;
		}

		if (!isset($transient->response) || !is_array($transient->response)) {
			$transient->response = array();
		}
		
		// GitHub release informations
		$this->getRepoReleaseInfo();

		// Check the versions if we need to do an update
		$doUpdate = 0;
		if (isset($this->APIResult->error)){
			trace_warn("Woodkit Plugin Installer - setTransitent - APIResult Error : ".var_export($this->APIResult->error, true));
		}else if (empty($this->APIResult)){
			// trace_info("Woodkit Plugin Installer - setTransitent - no release for package[{$this->slug}]");
		}else if (isset($this->APIResult->tag_name) && !empty($this->APIResult)){
			$doUpdate = version_compare($this->APIResult->tag_name, $this->pluginData["Version"]);
		}

		// Update the transient to include our updated plugin data
		if ($doUpdate == 1) {

			$package = $this->APIResult->zipball_url;

			$response = new stdClass();
			$response->id = 0;
			$response->slug = $this->package; // might be woodkit/woodkit.php to get plugin information ligthbox but generate an error on ajax update !
			$response->plugin = $this->slug;
			$response->new_version = $this->APIResult->tag_name;
			$response->upgrade_notice = '';
			$response->url = $this->pluginData["PluginURI"];
			$response->package = $this->APIResult->zipball_url;
			$response->icons = [
					'2x' => WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TEMPLATES_FOLDER.'img/woodkit-logo.svg',
					'1x' => WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TEMPLATES_FOLDER.'img/woodkit-logo.svg',
			];
			$transient->response[$this->slug] = $response;

		}

		return $transient;
	}

	// Push in plugin version information to display in the details lightbox
	public function setPluginInfo( $false, $action, $response ) {
		// Get plugin & GitHub release information
		$this->initPluginData();
		$this->getRepoReleaseInfo();

		// If nothing is found, do nothing
		if ( empty( $response->slug ) || $response->slug != $this->slug ) {
			return false;
		}

		// Add our plugin information
		$response->last_updated = $this->APIResult->published_at;
		$response->slug = $this->slug;
		$response->name  = $this->pluginData["Name"];
		$response->plugin_name  = $this->pluginData["Name"];
		$response->version = $this->APIResult->tag_name;
		$response->author = $this->pluginData["AuthorName"];
		$response->homepage = $this->pluginData["PluginURI"];

		// This is our release download zip file
		$downloadLink = $this->APIResult->zipball_url;

		// Include the access token for private GitHub repos
		if ( !empty( $this->accessToken ) ) {
			$downloadLink = add_query_arg(
					array( "access_token" => $this->accessToken ),
					$downloadLink
			);
		}
		$response->download_link = $downloadLink;

		// We're going to parse the GitHub markdown release notes, include the parser
		require_once( plugin_dir_path( __FILE__ ) . "parsedown.class.php" );

		// Create tabs in the lightbox
		$response->sections = array(
				'description' => $this->pluginData["Description"],
				'changelog' => class_exists( "Parsedown" )
				? Parsedown::instance()->parse( $this->APIResult->body )
				: $this->APIResult->body
		);

		// Gets the required version of WP if available
		$matches = null;
		preg_match( "/requires:\s([\d\.]+)/i", $this->APIResult->body, $matches );
		if ( !empty( $matches ) ) {
			if ( is_array( $matches ) ) {
				if ( count( $matches ) > 1 ) {
					$response->requires = $matches[1];
				}
			}
		}

		// Gets the tested version of WP if available
		$matches = null;
		preg_match( "/tested:\s([\d\.]+)/i", $this->APIResult->body, $matches );
		if ( !empty( $matches ) ) {
			if ( is_array( $matches ) ) {
				if ( count( $matches ) > 1 ) {
					$response->tested = $matches[1];
				}
			}
		}

		return $response;
	}

	/**
	 * Perform additional actions to successfully install our plugin
	 */
	public function postInstall($true, $hook_extra, $result) {
		// Get plugin information
		$this->initPluginData();

		// check if updated plugin is our plugin - name like : studio-montana-THEMENAME-HASH
		if (isset($result['destination_name']) && strpos($result['destination_name'], WoodkitInstaller::$API_ZIP_PACKAGE_BASE.'-'.$this->package.'-') !== false){

			// Remember if our plugin was previously activated
			$wasActivated = is_plugin_active($this->slug);

			// Since we are hosted in GitHub, our plugin folder would have a dirname of
			// reponame-tagname change it to our original one:
			global $wp_filesystem;
			$pluginFolder = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.dirname($this->slug);
			$wp_filesystem->move( $result['destination'], $pluginFolder );
			$result['destination'] = $pluginFolder;

			// Re-activate plugin if needed
			if ($wasActivated) {
				$activate = activate_plugin($this->slug);
			}
			
			$plugin_data = get_plugin_data($this->pluginFile);
			
			WoodkitInstaller::after_auto_update($this->package, $plugin_data["Version"]);
		}

		return $result;
	}
}