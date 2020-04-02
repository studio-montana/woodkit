<?php
/**
 * Use this class to register Gutenberg Block
 *
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 *
 * @author sebc
 *
 */
abstract class WKG_Module_Plugin extends WKG_Module {

	function __construct ($slug, $args = array()) {

		parent::__construct();

		// determine slug with base
		$this->slug = 'wkg-plugins-' . $slug;

		// parse args
		$this->args = wp_parse_args($args, array(
			'script_dependencies' => array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor', 'wp-api', 'wp-data', 'wp-plugins', 'wp-edit-post'),
			'css_dependencies' => array(),
			'before_init' => null,
			'after_init' => null,
			'post_types' => array(),
		));

		add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
	}

	public function enqueue_block_editor_assets () {
		$enqueue = false;
		if (!empty($this->args['post_types'])) {
			$screen = get_current_screen();
			foreach ($this->args['post_types'] as $post_type) {
				if ($screen->post_type === $post_type) {
					$enqueue = true;
				}
			}
		} else {
			$enqueue = true;
		}
		if ($enqueue) {
			// before hook
			$this->before_enqueue();
			$index_js = 'build.js';
			wp_enqueue_script($this->slug . '-build',
				$this->uri.$index_js,
				$this->args['script_dependencies'],
				filemtime($this->path.$index_js)
			);
			// after hook
			$this->after_enqueue();
		}
	}

	protected function before_enqueue () {}

	protected function after_enqueue () {}

}
