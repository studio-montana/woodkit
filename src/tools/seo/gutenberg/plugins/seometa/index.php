<?php

class WKG_Module_Plugin_seometa extends WKG_Module_Plugin {

	/**
	 * NOTE : be sur that custom post type has 'supports' => array(//..., 'custom-fields')
	 */

	function __construct() {
		parent::__construct('seometa');
		add_action('init', array($this, 'init'), 10);
	}

	public function init () {
		register_post_meta('', '_seo_meta_title', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_seo_meta_description', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_seo_meta_keywords', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_seo_meta_og_title', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_seo_meta_og_description', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
		register_post_meta('', '_seo_meta_og_image', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'integer',
			'auth_callback' => function() {
				return current_user_can('edit_posts');
			}
		));
	}
}
new WKG_Module_Plugin_seometa();
