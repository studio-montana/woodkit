<?php
/**
 * @package Woodkit
* @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com
* License: GPL2
* Text Domain: woodkit
*
* Copyright 2016 Sébastien Chandonay (email : please contact me from my website)
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("Go Away!");

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

	protected static $native_script_dependencies = array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor', 'wp-api', 'wp-data', 'wp-edit-post');
	protected static $native_css_dependencies = array();
	
	function __construct($slug, $args = array()) {
	
		parent::__construct('wkg/' . $slug, wp_parse_args($args, array(
				'is_dynamic' => true,
				'script_dependencies' => self::$native_script_dependencies,
				'css_dependencies' => self::$native_css_dependencies,
				'before_init' => null,
				'after_init' => null,
				'block_post_types_template' => array(),
				'i18n' => array(
						'domain' => 'woodkit',
						'path' => WOODKIT_PLUGIN_PATH.'lang/'
				),
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

		$build_js = 'build.js';
		if (file_exists($this->path.$build_js)) {
			// build exists - register it
			wp_enqueue_script($this->slug . '-block-editor', $this->uri.$build_js, $this->args['script_dependencies'], filemtime($this->path.$build_js));
			wp_localize_script(
			    $this->slug . '-block-editor',
			    'wkg_data', [
			        	'base_uri'       => $this->uri,
					    'base_path'       => $this->path,
			    ]
			);
			// i18n
			if (function_exists('wp_set_script_translations') && isset($this->args['i18n'])) {
				if (!wp_set_script_translations($this->slug . '-block-editor', $this->args['i18n']['domain'], $this->args['i18n']['path'])) {
					trigger_error("Translation file for WKG_Module_Block {$this->slug} not found !", E_USER_WARNING);
				}
			} else {
				trigger_error("No translation file for WKG_Module_Block {$this->slug}", E_USER_WARNING);
			}
	
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
		} else {
			trace_warn("WKG_Module_Block - no build for block ['{$this->slug}']");
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
