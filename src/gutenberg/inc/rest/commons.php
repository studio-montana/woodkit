<?php
defined('ABSPATH') or die("Go Away!");

class WKG_REST_Commons extends WKG_REST {

	public function __construct(){
		parent::__construct('commons', 1);
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/posts_options', array(
				array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_posts_options' ),
						'permission_callback' => array( $this, 'get_posts_options_permissions_check' ),
						'args'                => $this->get_collection_params(),
				)
		) );
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/terms_options', array(
				array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_terms_options' ),
						'permission_callback' => array( $this, 'get_terms_options_permissions_check' ),
						'args'                => $this->get_collection_params(),
				)
		) );
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/icons', array(
				array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_icons' ),
						'permission_callback' => array( $this, 'get_icons_permissions_check' ),
						'args'                => $this->get_collection_params(),
				)
		) );
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/schema', array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_public_item_schema' ),
		) );
	}

	/**
	 * Check if a given request has access
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_posts_options_permissions_check( $request ) {
		return current_user_can('edit_posts');
	}

	/**
	 * Check if a given request has access
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_terms_options_permissions_check( $request ) {
		return current_user_can('edit_posts');
	}

	/**
	 * Check if a given request has access
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_icons_permissions_check( $request ) {
		return current_user_can('edit_posts');
	}

	/**
	 * Get posts options
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_posts_options( $request ) {
		$params = $request->get_params();
		if (isset($params['post_type']) && !empty($params['post_type'])) {
			$options = wkg_get_all_posts_options(explode(',', sanitize_text_field($params['post_type'])));
		} else {
			$options = wkg_get_all_posts_options();
		}
		return new WP_REST_Response( $options, 200 );
	}

	/**
	 * Get terms options
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_terms_options( $request ) {
		$params = $request->get_params();
		if (isset($params['taxonomies']) && !empty($params['taxonomies'])) {
			$options = wkg_get_all_terms_options(explode(',', sanitize_text_field($params['taxonomies'])));
		} else {
			$options = wkg_get_all_terms_options();
		}
		return new WP_REST_Response( $options, 200 );
	}

	/**
	 * Get icons
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_icons( $request ) {
		$icons = woodkit_get_fonticons_set();
		return new WP_REST_Response( $icons, 200 );
	}
}
new WKG_REST_Commons();
