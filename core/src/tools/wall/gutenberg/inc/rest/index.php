<?php
defined('ABSPATH') or die("Go Away!");

class WKG_REST_wall extends WKG_REST {

	public function __construct(){
		parent::__construct('wall', 1);
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/items', array(
				array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_items' ),
						'permission_callback' => array( $this, 'get_items_permissions_check' ),
						'args'                => $this->get_collection_params(),
				)
		) );
		register_rest_route( $this->namespace, '/' . $this->rest_base . '/schema', array(
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_public_item_schema' ),
		) );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_items_permissions_check( $request ) {
		return current_user_can('edit_posts');
	}

	/**
	 * Get wall items and other things...
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_items( $request ) {
		//get parameters from request - and remove unused
		$params = $request->get_params();
		$args = wkg_parse_args($params, array(
			'post_type' => 'post',
			'orderby' => 'date',
			'order' => 'desc',
			'numberposts' => '-1',
			'terms' => '',
			'post_parent' => -1
		), true);
		// retrieves data
		$items = wkg_wall_get_items($args, isset($params['thumbsize']) ? $params['thumbsize'] : 'thumbnail');
		$items_parents = wkg_wall_get_items_parents_options($args);
		$items_terms = wkg_wall_get_items_terms_options($args);
		$res = array('items' => $items, 'items_parents' => $items_parents, 'items_terms' => $items_terms);
		// error_log('/wkg/v1/wall/items/ res : ' . var_export($res, true));
		// return new WP_Error('cant-get', __( 'Impossible de récupérer les items du wall.', 'wkg' ) );
		return new WP_REST_Response( $res, 200 );
	}
}
new WKG_REST_wall();
