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
 * Extend this class to register Gutenberg Store
 *
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 *
 * @author sebc
 *
 */
abstract class WKG_Module_Store extends WKG_Module {

	function __construct ($slug, $args = array()) {

		parent::__construct('wkg-store-' . $slug, wp_parse_args($args, array(
				'post_types' => array(),
				'script_dependencies' => array()
		)));
		
		add_action('admin_enqueue_scripts', array($this, 'enqueue_store'));
	}

	public function enqueue_store () {
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
		
		// enqueue script
		$build_js = 'build.js';
		if (file_exists($this->path.$build_js)) {
			wp_enqueue_script($this->slug . '-build', $this->uri.$build_js, $this->args['script_dependencies'], filemtime($this->path.$build_js));
		} else {
			trace_warn("WKG_Module_Store - no build for store ['{$this->slug}']");
		}
		
		// after hook
		$this->after_enqueue();
	}

	protected function before_enqueue () {}

	protected function after_enqueue () {}

}
