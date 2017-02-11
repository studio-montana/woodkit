<?php

class WoodkitThemeUploader {

	private $slug; // theme slug
	private $themeData; // theme data
	private $APIResult; // holds data

	function __construct($package) {

		$this->slug = $package;

		add_filter('site_transient_update_themes', array( $this, 'setTransitent'), 10, 1);
		add_filter("pre_set_site_transient_update_themes", array( $this, "setTransitent" ), 10, 1);
		add_filter("upgrader_post_install", array( $this, "postInstall" ), 10, 3);
	}

	// Push in theme version information to get the update notification
	public function setTransitent( $transient ) {

		// trace_info("Woody - ThemeInstaller - transient : ".var_export($transient, true));
		// return $transient; // TODO disable

		if(empty($transient->checked[WOODY_THEME_NAME]))
			return $transient;

		if (!is_object($transient))
			return $transient;

		// if (!woody_is_registered())
		// return $transient;

		if (!isset($transient->response) || !is_array($transient->response))
			$transient->response = array();

		// Get plugin & GitHub release information
		$this->initThemeData();
		$this->getRepoReleaseInfo();

		// Check the versions if we need to do an update
		$doUpdate = 0;
		if (isset($this->APIResult->error)){
			trace_err("Woody - ThemeInstaller - APIResult Error : ".var_export($this->APIResult->error, true));
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

			// trace_info("---- Woody - ThemeInstaller - transient UPDATE NOTIFICATION : ".var_export($transient, true));

		}

		return $transient;
	}

	// Get information regarding our plugin from WordPress
	private function initThemeData() {
		$this->themeData = wp_get_theme($this->slug);
		$this->themeData->get('Version');
	}

	// Get information regarding our plugin from API
	private function getRepoReleaseInfo() {

		//if (!woody_is_registered())
		//return;

		if (!empty($this->APIResult))
			return;

		$reload = true;
		$now = new DateTime();
		$last_update = get_option('woody-last-update-latest-release', null);
		$latestrelease = get_option('woody-latest-release', null);
		if ($last_update != null){
			if (defined('WOODY_THEME_INTERVAL_API'))
				$last_update->add(new DateInterval(WOODY_THEME_INTERVAL_API));
			if ($last_update > $now){
				$reload = false;
			}
		}
		$reload = true;

		if ($reload){
			$url = WOODY_URL_API;
			$url = add_query_arg(array("api-action" => "latestrelease"), $url);
			$url = add_query_arg(array("api-package" => WOODY_THEME_NAME), $url);
			$url = add_query_arg(array("api-host" => get_site_url()), $url);
			$remote_result = wp_remote_retrieve_body(wp_remote_get($url));
			if (!empty($remote_result)) {
				$this->APIResult = @json_decode($remote_result);
				// update release
				if ($latestrelease != null)
					delete_option('woody-latest-release');
				add_option('woody-latest-release', $remote_result);
				// update date
				if ($last_update != null)
					delete_option('woody-last-update-latest-release');
				add_option('woody-last-update-latest-release', $now);
			}
		}else{
			$this->APIResult = @json_decode($latestrelease);
		}
	}

	// Perform additional actions to successfully install our plugin
	public function postInstall( $true, $hook_extra, $result ) {

		// trace_info("Woody - ThemeInstaller - postInstall : ".var_export($result, true));

		// TODO if theme is activated -> re-activate it !

		// Get theme information
		$this->initThemeData();

		// Since we are hosted in GitHub, our plugin folder would have a dirname of
		// reponame-tagname change it to our original one:
		global $wp_filesystem;
		$pluginFolder = get_theme_root() . DIRECTORY_SEPARATOR . $this->slug;

		// trace_info("Woody - ThemeInstaller - postInstall - $pluginFolder : ".$pluginFolder);

		$wp_filesystem->move( $result['destination'], $pluginFolder );
		$result['destination'] = $pluginFolder;
		$result['remote_destination'] = $pluginFolder;
		$result['destination_name'] = $this->slug;

		// trace_info("Woody - ThemeInstaller - post postInstall : ".var_export($result, true));

		return $result;
	}
}