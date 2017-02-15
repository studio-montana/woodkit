<?php

class WoodkitThemeUploader {

	private $slug; // theme slug
	private $themeData; // theme data
	private $APIResult; // holds data

	function __construct($package) {

		$this->slug = $package;

		$theme = wp_get_theme($this->slug);
		if ($theme->exists()){
			add_filter('site_transient_update_themes', array($this, 'setTransitent'), 10, 1);
			add_filter('pre_set_site_transient_update_themes', array($this, 'setTransitent'), 10, 1);
			add_filter('upgrader_post_install', array($this, 'postInstall'), 10, 3); // move folder for theme name
			add_filter('upgrader_process_complete', array($this, 'upgraderProcessComplete'), 10, 0); // re-activate theme
		}
	}

	// Get information regarding our plugin from WordPress
	private function initThemeData() {
		$this->themeData = wp_get_theme($this->slug);
	}

	// Get information regarding our plugin from API
	private function getRepoReleaseInfo() {

		if (!woodkit_is_registered())
			return;

		if (!empty($this->APIResult))
			return;

		$reload = true;
		$now = new DateTime();
		$last_update = get_option($this->slug.'-last-update-latest-release', null);
		$latestrelease = get_option($this->slug.'-latest-release', null);
		if ($last_update != null){
			if (defined('WOODKIT_INTERVAL_API'))
				$last_update->add(new DateInterval(WOODKIT_INTERVAL_API));
			if ($last_update > $now){
				$reload = false;
			}
		}

		if ($reload){
			$key = woodkit_get_option("key-activation");
			$url = WOODKIT_URL_API;
			$url = add_query_arg(array("api-action" => "latestrelease"), $url);
			$url = add_query_arg(array("api-package" => $this->slug), $url);
			$url = add_query_arg(array("api-key-host" => get_site_url()), $url);
			$url = add_query_arg(array("api-key-package" => 'woodkit'), $url); // depends woodkit
			$url = add_query_arg(array("api-key" => $key), $url);
			$remote_result = wp_remote_retrieve_body(wp_remote_get($url));
			if (!empty($remote_result)) {
				$this->APIResult = @json_decode($remote_result);
				// update release
				if ($latestrelease != null)
					delete_option($this->slug.'-latest-release');
				add_option($this->slug.'-latest-release', $remote_result);
				// update date
				if ($last_update != null)
					delete_option($this->slug.'-last-update-latest-release');
				add_option($this->slug.'-last-update-latest-release', $now);
			}
		}else{
			$this->APIResult = @json_decode($latestrelease);
		}
	}

	// Push in theme version information to get the update notification
	public function setTransitent($transient) {

		if(empty($transient->checked[$this->slug]))
			return $transient;

		if (!is_object($transient))
			return $transient;

		if (!woodkit_is_registered())
			return $transient;

		if (!isset($transient->response) || !is_array($transient->response))
			$transient->response = array();

		// Get plugin & GitHub release information
		$this->initThemeData();
		$this->getRepoReleaseInfo();

		// Check the versions if we need to do an update
		$doUpdate = 0;
		if (isset($this->APIResult->error)){
			trace_err("Woodkit Theme Installer - setTransitent - APIResult Error : ".var_export($this->APIResult->error, true));
		}else if (isset($this->APIResult->tag_name) && !empty($this->APIResult)){
			$doUpdate = version_compare($this->APIResult->tag_name, $this->themeData->get('Version'));
		}

		// Update the transient to include our updated plugin data
		if ($doUpdate == 1) {

			$response = array();
			$response['new_version'] = $this->APIResult->tag_name;
			$response['upgrade_notice'] = '';
			$response['url'] = $this->themeData->get('ThemeURI');
			$response['package'] = $this->APIResult->zipball_url;
			$transient->response[$this->slug] = $response;

		}

		return $transient;
	}

	/**
	 * Perform additional actions to successfully install our plugin
	 */
	public function postInstall($true, $hook_extra, $result) {

		// Get theme information
		$this->initThemeData();

		// check if updated theme is our theme - name like : studio-montana-THEMENAME-HASH
		if (isset($result['destination_name']) && strpos($result['destination_name'], WOODKIT_GITHUB_BASE_PACKAGE.'-'.$this->slug.'-') !== false){
			// Since we are hosted in GitHub, our plugin folder would have a dirname of
			// reponame-tagname change it to our original one:
			global $wp_filesystem;
			$pluginFolder = get_theme_root() . DIRECTORY_SEPARATOR . $this->slug;

			$wp_filesystem->move($result['destination'], $pluginFolder);
			$result['destination'] = $pluginFolder;
			$result['remote_destination'] = $pluginFolder;
			$result['destination_name'] = $this->slug;
		}

		return $result;
	}

	/**
	 * Perform additional actions after upgrader complete
	 */
	public function upgraderProcessComplete(){

		// Get theme information
		$this->initThemeData();

		$activated_theme = wp_get_theme();

		// check if current theme is our update theme - name like : studio-montana-THEMENAME-HASH
		if (strpos($activated_theme->get('Name'), WOODKIT_GITHUB_BASE_PACKAGE.'-'.$this->slug.'-') !== false){
			switch_theme($this->slug);
		}
		
		woodkit_after_auto_update($this->slug, $this->themeData->get('Version'));

	}
}