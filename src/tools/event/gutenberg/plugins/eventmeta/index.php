<?php

class WKG_Module_Plugin_eventmeta extends WKG_Module_Plugin {

	/**
	 * NOTE : be sur that custom post type has 'supports' => array(//..., 'custom-fields')
	 */

	function __construct() {
		parent::__construct('eventmeta');
		add_action('init', array($this, 'init'), 10);
	}

	public function init () {
		register_post_meta('', '_event_meta_date_begin', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'number',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_event_meta_date_end', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'number',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_event_meta_locate_address', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_event_meta_locate_cp', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_event_meta_locate_city', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_event_meta_locate_country', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
	}
}
new WKG_Module_Plugin_eventmeta();
