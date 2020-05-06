<?php
/**
 * Extend this class to register Gutenberg Block or Plugin
 * 
 * You can extends this class outside woodkit plugin context (in theme for examle)
 * 
 * NOTE : please specify one of both 'uri' or 'path' arg when instanciate this class if you are using symbolic link outside woodkit plugin context
 * 
 * @author sebc
 *
 */
abstract class WKG_Module {

	protected $slug;
	protected $args;
	protected $uri;
	protected $path;

	function __construct($slug, $args = array()) {
		
		$this->slug = $slug;
		
		$this->args = wp_parse_args($args, array(
			'path' => null, // optional, only needed if you are using symbolic link outside woodkit plugin context and if you don't specify 'uri' arg
			'uri' => null, // optional, only needed if you are using symbolic link outside woodkit plugin context and if you don't specify 'path' arg
		));
		
		if (!isset($args['path'])) {
			/**
			 * Calculate PATH
			 * NOTE : ReflectionClass render real path to class file (no symbolic link)
			 */
			$rc = new ReflectionClass(get_class($this));
			$this->path = trailingslashit(dirname($rc->getFileName()));
		} else {
			$this->path = $args['path'];
		}
		
		if (!isset($args['uri'])) {
			/** 
			 * Calculate URI from PATH
			 * IMPORTANT : this code does not support symbolic link - it's impossible to calculate URI from PATH if this path is not in WP context
			 * To calculate URI, this code is based on PATH, so the context must be in WP plugins or themes (or directly inside Woodkit plugin)
			 * If you are using symbolic link for any reason, you must specify 'uri' args when you instanciate this class
			 */
			if (startsWith($this->path, WP_PLUGIN_DIR)) {
				$this->uri = trailingslashit(plugin_dir_url(str_replace(WP_PLUGIN_DIR, '', $this->path) . 'index.jsx'));
			} else if (startsWith($this->path, WOODKIT_PLUGIN_PATH)) {
				$this->uri = trailingslashit(plugin_dir_url(str_replace(WOODKIT_PLUGIN_PATH, 'woodkit/', $this->path) . 'index.jsx'));
			} else if (startsWith($this->path, get_template_directory())) {
				$this->uri = trailingslashit(dirname(get_theme_file_uri(str_replace(get_template_directory(), '', $this->path) . 'index.jsx')));
			} else if (startsWith($this->path, get_stylesheet_directory())) {
				$this->uri = trailingslashit(dirname(get_theme_file_uri(str_replace(get_stylesheet_directory(), '', $this->path) . 'index.jsx')));
			} else {
				throw new Exception('URI can not be determined from PATH : WKG_Module must be instanciated in WP plugins or themes (symbolic link not supported excepted inside Woodkit plugin) - you can specify \'uri\' explicitly - actual path : ' . $this->path);
			}
		} else {
			$this->uri = $args['uri'];
		}
		
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
