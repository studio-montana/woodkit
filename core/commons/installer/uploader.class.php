<?php

class WoodkitPluginUploader {

	private $slug; // plugin slug
	private $pluginData; // plugin data
	private $repo;
	private $pluginFile; // __FILE__ of our plugin
	private $APIResult; // holds data

	function __construct($pluginFile, $package) {

		$this->pluginFile = $pluginFile;
		$this->repo = $package;

		if (file_exists($this->pluginFile)){
			add_filter("plugins_api", array( $this, "setPluginInfo" ), 10, 3);
			add_filter('site_transient_update_plugins', array( $this, 'setTransitent'), 10, 1);
			add_filter("pre_set_site_transient_update_plugins", array( $this, "setTransitent" ), 10, 1);
			add_filter("upgrader_post_install", array( $this, "postInstall" ), 10, 3);
		}
	}

	// Get information regarding our plugin from WordPress
	private function initPluginData() {
		$this->slug = plugin_basename($this->pluginFile);
		$this->pluginData = get_plugin_data( $this->pluginFile );
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
			$url = add_query_arg(array("api-package" => WOODKIT_PLUGIN_NAME), $url);
			$url = add_query_arg(array("api-host" => get_site_url()), $url);
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

	// Push in plugin version information to get the update notification
	public function setTransitent( $transient ) {

		if (!is_object($transient))
			return $transient;

		if (!woodkit_is_registered())
			return $transient;

		if (!isset($transient->response) || !is_array($transient->response))
			$transient->response = array();

		// Get plugin & GitHub release information
		$this->initPluginData();
		$this->getRepoReleaseInfo();

		// Check the versions if we need to do an update
		$doUpdate = 0;
		if (!empty($this->APIResult))
			$doUpdate = version_compare($this->APIResult->tag_name, $this->pluginData["Version"]);

		// Update the transient to include our updated plugin data
		if ( $doUpdate == 1 ) {

			$package = $this->APIResult->zipball_url;

			$response = new stdClass();
			$response->id = 0;
			$response->slug = $this->slug; // might be woodkit/woodkit.php to get plugin information ligthbox but generate an error on ajax update !
			$response->plugin = $this->slug;
			$response->new_version = $this->APIResult->tag_name;
			$response->upgrade_notice = '';
			$response->url = $this->pluginData["PluginURI"];
			$response->package = $package;
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

	// Perform additional actions to successfully install our plugin
	public function postInstall( $true, $hook_extra, $result ) {
		// Get plugin information
		$this->initPluginData();

		// Remember if our plugin was previously activated
		$wasActivated = is_plugin_active( $this->slug );

		// Since we are hosted in GitHub, our plugin folder would have a dirname of
		// reponame-tagname change it to our original one:
		global $wp_filesystem;
		$pluginFolder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname( $this->slug );
		$wp_filesystem->move( $result['destination'], $pluginFolder );
		$result['destination'] = $pluginFolder;

		// Re-activate plugin if needed
		if ($wasActivated) {
			$activate = activate_plugin($this->slug);
		}

		return $result;
	}
}