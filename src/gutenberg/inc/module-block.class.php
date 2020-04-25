<?php
/**
 * Extend this class to register Gutenberg Block
 *
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 *
 * @author sebc
 *
 */
abstract class WKG_Module_Block extends WKG_Module {

	function __construct($slug, $args = array()) {

		parent::__construct('wkg/' . $slug, wp_parse_args($args, array(
			'is_dynamic' => true,
			'script_dependencies' => array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor', 'wp-api', 'wp-data', 'wp-edit-post'),
			'css_dependencies' => array(),
			'before_init' => null,
			'after_init' => null,
			'block_post_types_template' => array(),
		)));
		
		// init
		add_action('init', array($this, 'init'), 10);
	}

	public function init () {
		// Skip block registration if Gutenberg is not enabled/merged.
		if (!function_exists('register_block_type')) {
			return;
		}

		// before init hook
		$this->before_init();

		$index_js = 'build.js';
		wp_register_script($this->slug . '-block-editor',
			$this->uri.$index_js,
			$this->args['script_dependencies'],
			filemtime($this->path.$index_js)
		);

		$editor_css = 'editor.css';
		wp_register_style($this->slug . '-block-editor', $this->uri.$editor_css, $this->args['css_dependencies'], filemtime($this->path.$editor_css));

		$style_css = 'style.css';
		wp_register_style($this->slug . '-block', $this->uri.$style_css, $this->args['css_dependencies'], filemtime($this->path.$style_css));

		$block_type_args = [
				'editor_script'   => $this->slug . '-block-editor',
				'editor_style'    => $this->slug . '-block-editor',
				'style'           => $this->slug . '-block',
				'attributes'      => [
						'content'  => ['type' => 'string'],
						'title'    => ['type' => 'string'],
						'color'    => ['type' => 'string', 'default' => '#000'],
						'mediaID'  => ['type' => 'string'],
						'mediaURL' => ['type' => 'string'],
				]
		];
		if ($this->args['is_dynamic']) {
			$block_type_args['render_callback'] = array($this, 'render');
		}

		register_block_type($this->slug, $block_type_args);

		/**
		 * Register block on template for specified post-types
		 * doc : https://developer.wordpress.org/block-editor/tutorials/metabox/meta-block-5-finishing/
		 */
		if (!empty($this->args['block_post_types_template'])) {
			foreach ($this->args['block_post_types_template'] as $post_type) {
				$post_type_object = get_post_type_object($post_type);
		    	$post_type_object->template = array(
			        array($this->slug),
			    );
			}
		}

		// after init hook
		$this->after_init();
	}

	protected function before_init () {}

	protected function after_init () {}

	public function getFrontClasses($adds = array()) {
		$classes = array_merge(array('wkg-front', 'wkg-block', 'wp-block-' . str_replace('/', '-', $this->slug)), $adds);
		return implode(' ', $classes);
	}

	public function render(array $attributes, $content) {
		return <<<HTML
    <h2>Please override this render method when using dynamic block</h2>
HTML;

	}

}
