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
 * Extend this class to register Gutenberg Plugin
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

		parent::__construct('wkg-plugins-' . $slug, wp_parse_args($args, array(
			'script_dependencies' => array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor', 'wp-api', 'wp-data', 'wp-plugins', 'wp-edit-post'),
			'css_dependencies' => array(),
			'post_types' => array(),
		)));

		add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
	}

	public function enqueue_block_editor_assets () {
		// Skip block registration if Gutenberg is not enabled/merged.
		if (!function_exists('register_block_type')) {
			return;
		}
		
		$enqueue = false;
		if (!empty($this->args['post_types'])) {
			$screen = get_current_screen();
			if (is_array($this->args['post_types'])) {
				foreach ($this->args['post_types'] as $post_type) {
					if ($screen->post_type === $post_type) {
						$enqueue = true;
					}
				}
			} else {
				if ($screen->post_type === $this->args['post_types']) {
					$enqueue = true;
				}
			}
		} else {
			$enqueue = true;
		}
		if (!$enqueue) {
			return;
		}
		
		// before hook
		$this->before_enqueue();
		
		// enqueue style
		$style_css = 'style.css';
		wp_enqueue_style($this->slug . '-style', $this->uri.$style_css, $this->args['css_dependencies'], filemtime($this->path.$style_css), 'all');

		// enqueue script
		$build_js = 'build.js';
		if (file_exists($this->path.$build_js)) {
			wp_enqueue_script($this->slug . '-build', $this->uri.$build_js, $this->args['script_dependencies'], filemtime($this->path.$build_js));
		} else {
			trace_err("WKG_Module_Plugin - no build for plugin ['{$this->slug}']");
		}
		
		// after hook
		$this->after_enqueue();
	}

	protected function before_enqueue () {}

	protected function after_enqueue () {}

}
