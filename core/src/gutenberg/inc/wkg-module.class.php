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
abstract class WKG_Module {

	protected $slug;
	protected $args;
	protected $uri;
	protected $path;

	function __construct() {
		
		/** calculate class path from child class */
		$rc = new ReflectionClass(get_class($this));
		$this->path = trailingslashit(dirname($rc->getFileName()));
		
		/** calculate class uri from class path (add existing file only to get valid URI) */
		$this->uri = trailingslashit(plugin_dir_url($this->path . 'index.jsx'));
		
	}

	public function implode_styles($styles) {
		array_walk($styles, function (&$v, $k) {
			$v = $k.':'.$v;
		});
		$styles = implode(';', $styles);
		return !empty($styles) ? $styles . ';' : $styles;
	}

	public function implode_tag_attrs($attrs) {
		array_walk($attrs, function (&$v, $k) {
			$v = $k.'="'.$v.'"';
		});
		return implode(' ', $attrs);
	}

}
