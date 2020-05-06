<?php
defined('ABSPATH') or die("Go Away!");

abstract class WKG_REST extends WP_REST_Controller {

	public function __construct($name, $version){
		$this->rest_base = $name;
		$this->namespace = 'wkg/v'.$version;
		add_action('rest_api_init', array($this, 'register_routes'));
	}

	/**
	 * Check if current request is READABLE method
	 * @param WP_REST_Request $request
	 */
	protected function is_method_readable($request){
		return $this->is_method_($request, WP_REST_Server::READABLE);
	}

	/**
	 * Check if current request is CREATABLE method
	 * @param WP_REST_Request $request
	 */
	protected function is_method_creatable($request){
		return $this->is_method_($request, WP_REST_Server::CREATABLE);
	}

	/**
	 * Check if current request is EDITABLE method
	 * @param WP_REST_Request $request
	 */
	protected function is_method_editable($request){
		return $this->is_method_($request, WP_REST_Server::EDITABLE);
	}

	/**
	 * Check if current request is DELETABLE method
	 * @param WP_REST_Request $request
	 */
	protected function is_method_deletable($request){
		return $this->is_method_($request, WP_REST_Server::DELETABLE);
	}

	/**
	 * Check if current request is $handler method
	 * @param WP_REST_Request $request
	 * @param string $handler
	 */
	private function is_method_($request, $handler){
		$method = $request->get_method();
		$rest_methods = explode(',', $handler);
		foreach ($rest_methods as $rest_method){
			if (strtoupper(trim($rest_method)) === strtoupper(trim($method))){
				return true;
			}
		}
		return false;
	}

}
