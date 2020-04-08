<?php

class WKG_Module_Plugin__blank_ extends WKG_Module_Plugin {

	/**
	 * NOTE : be sur that custom post type has 'supports' => array(//..., 'custom-fields')
	 */
	private $post_types = array('post', 'page');

	function __construct() {
		parent::__construct(
			'_blank_',
			array(
				'post_types' => $this->post_types,
			)
		);
		add_action('init', array($this, 'init'), 10);
	}

	public function init () {
		foreach ($this->post_types as $post_type) {
			register_post_meta($post_type, '_custom_meta_name', array(
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
}
new WKG_Module_Plugin__blank_();
