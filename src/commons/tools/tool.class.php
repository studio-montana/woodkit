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
 * Tool class - must be overriden by each tool
 * @author sebc
 */
abstract class WK_Tool{

	public $slug; // string
	public $has_config; // boolean
	public $add_config_in_menu; // boolean
	public $customizer; // boolean|string - see : https://gist.github.com/slushman/6f08885853d4a7ef31ebceafd9e0c180
	public $documentation_url; // string
	public $is_core;  // boolean
	public $context;  // string
	protected $config_nonce_name; // string
	protected $path;
	protected $uri;

	public function __construct($args){
		$args = wp_parse_args($args, array(
				'path' => null, // optional, only needed if you are using symbolic link outside woodkit plugin context and if you don't specify 'uri' arg
				'uri' => null, // optional, only needed if you are using symbolic link outside woodkit plugin context and if you don't specify 'path' arg
				'slug' => '',
				'has_config' => false,
				'add_config_in_menu' => false,
				'customizer' => false,
				'documentation' => '',
				'context' => '',
		));
		$this->slug = $args['slug'];
		$this->has_config = $args['has_config'];
		$this->add_config_in_menu = $args['add_config_in_menu'];
		$this->customizer = $args['customizer'];
		$this->documentation_url = $args['documentation'];
		$this->context = $args['context'];
		$this->config_nonce_name = 'woodkit-tool-'.$this->slug.'-config-nonce';

		if (!isset($args['path'])) {
			/**
			 * Calculate PATH
			 * NOTE : ReflectionClass render real path to class file (not a symbolic link)
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
				throw new Exception('URI can not be determined from PATH : WK_Tool must be instanciated in WP plugins or themes (symbolic link not supported excepted inside Woodkit plugin) - you can specify \'uri\' explicitly - actual path : ' . $this->path);
			}
		} else {
			$this->uri = $args['uri'];
		}

		/** calculate if it's core source (path comparison) */
		$this->is_core = startsWith($this->path, WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER);
	}

	public function get_path () {
		return $this->path;
	}

	/**
	 * Called when tool is lauched (if activated)
	 */
	public abstract function launch();

	/**
	 * Tool name must be get by function to support i18n
	 * --> because of contructor is called before any filters which load textdomain - ex. : for tool's theme support
	 */
	public abstract function get_name();


	/**
	 * Tool description must be get by function to support i18n
	 * --> because of contructor is called before any filters which load textdomain - ex. : for tool's theme support
	 */
	public abstract function get_description();

	/**
	 * Proceed to tool activation
	 */
	public function activate(){
		$this->set_option('active', 'on');
		$this->on_activate();
	}

	/**
	 * Proceed to tool deactivation
	 */
	public function deactivate(){
		$this->set_option('active', 'off');
		$this->on_deactivate();
	}

	/**
	 * Called when tool is activated
	 */
	protected function on_activate(){}

	/**
	 * Called when tool is deactivated
	 */
	protected function on_deactivate(){}

	/**
	 * Check if tool is activated - based on woodkit tool option
	 * @return boolean
	 */
	public function is_activated(){
		$tool_active = $this->get_option('active');
		return !empty($tool_active) && $tool_active == 'on';
	}

	public function get_options () {
		return woodkit_get_option('tool-'.$this->slug);
	}

	/**
	 * Retrieve tool's option for specified name
	 * @param string $name
	 * @param any $default
	 * @return any
	 */
	public function get_option ($name, $default = null) {
		$options = $this->get_options();
		if (is_array($options) && array_key_exists($name, $options)){
			return $options[$name];
		}
		$default_value = $this->get_config_default_value($name);
		return $default_value != null ? $default_value : $default;
	}

	/**
	 * Set tool's option
	 * @param string $name
	 * @param any $value
	 */
	public function set_option ($name, $value) {
		$options = $this->get_options();
		if (empty($options) || !is_array($options)){
			$options = array();
		}
		$options[$name] = $value;
		woodkit_save_option('tool-'.$this->slug, $options);
	}

	/**
	 * Set tool's options
	 * @param string $name
	 * @param any $value
	 */

	/**
	 * Set tool's options
	 * @param array $options
	 * @param boolean $keep_existings - keep existings options if they are not set in specified $options
	 */
	public function set_options ($options, $keep_existings = true) {
		if ($keep_existings) {
			$existings = $this->get_options();
			$options = wp_parse_args($options, $existings);
		}
		woodkit_save_option('tool-'.$this->slug, $options);
	}

	/**
	 * retrieve all config fields<br />
	 * <strong>IMPORTANT</strong> : never add 'active' field by this way - 'active' field is used to set active tools and it's automaticaly managed by Woodkit - tools don't have to do that
	 * @return array
	 */
	public function get_config_fields(){
		return array();
	}

	/**
	 * retrieve all config default values
	 * @return array
	 */
	public function get_config_default_values(){
		return array();
	}

	/**
	 * retrieve specific config default value
	 * @return any
	 */
	private function get_config_default_value($name){
		$defaults = $this->get_config_default_values();
		return !empty($defaults) && isset($defaults[$name]) ? $defaults[$name] : null;
	}

	/**
	 * display config fields
	 */
	public function display_config_fields(){}

	/**
	 * display config page
	 * IMPORTANT : you don't have to override this method
	 */
	public function render_config(){
		?>
		<div class="wrap woodkit-page-options woodkit-tool-page-options woodkit-tool-<?php echo $this->slug; ?>-page-options">

			<div class="wk-panel">
			<div class="woodkit-credits">
				<div class="logo"><?php echo get_woodkit_icon('paw'); ?></div>
				<div class="text">
					<h1 class="title"><?php _e("Woodkit"); ?><sup class="copy"> &copy;</sup></h1>
					<p class="desc"><?php _e("Un outil robuste complétant Wordpress en terme de SEO, de sécurité et d'outils sur-mesure dédiés à votre site Web."); ?><br />L'idée est qu'un outil simple, répondant uniquement aux besoins essentiels, dure dans le temps.</p>
					<p class="credit">Développé et maintenu depuis 2016 par <a href="https://www.seb-c.com" target="_blank">Sébastien Chandonay</a> & <a href="https://www.cyriltissot.com" target="_blank">Cyril Tissot</a> pour <a href="https://www.studio-montana.com" target="_blank">Studio Montana</a></p>
				</div>
			</div>
		</div>

			<h1>
				<?php echo __("Woodkit tools", 'woodkit'); ?><i class="fa fa-angle-right"></i><?php echo $this->get_name(); ?>
				<a href="<?php menu_page_url("woodkit_options", true); ?>" class="all-tools page-title-action"><?php _e("View all tools", 'woodkit'); ?></a>
			</h1>
			<form method="post" action="<?php echo get_current_url(true); ?>">
				<input type="hidden" name="<?php echo $this->config_nonce_name; ?>" value="<?php echo wp_create_nonce($this->config_nonce_name); ?>" />
				<?php
				$this->display_config_fields();
				?>
				<div class="form-row form-row-submit">
					<button type="submit" class="wk-btn primary save">
						<?php _e("Save", 'woodkit'); ?>
					</button>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Retrieve all specified config fields and their values from Form - you can override this method
	 * @param unknown $values
	 * @return NULL
	 */
	public function save_config_fields($values){
		$fields = $this->get_config_fields();
		if (!empty($fields)){
			foreach ($fields as $field){
				if (isset($_POST[$field])){
					if (is_array($_POST[$field])){
						$values[$field] = woodkit_get_request_param($field, null, false);
					}else{
						$values[$field] = woodkit_get_request_param($field, null, true);
					}
				}else{
					$values[$field] = null; // for unchecked checkboxes
				}
			}
		}
		return $values;
	}

	/**
	 * Called before save (only when form is submited)
	 * @param array $options
	 */
	public function before_save_config($new_options, $old_options){}

	/**
	 * Called after save (only when form is submited)
	 * @param array $options
	 */
	public function after_save_config($new_options, $old_options){}

	/**
	 * Save tool's options - <strong>IMPORTANT</strong> : override all current tool's options
	 * IMPORTANT : you don't have to override this method
	 */
	public function save_config(){
		if (isset($_POST) && !empty($_POST) && isset($_POST[$this->config_nonce_name]) && wp_verify_nonce($_POST[$this->config_nonce_name], $this->config_nonce_name)){
			$old_options = $this->get_options();
			$options = $this->save_config_fields(array());
			$this->before_save_config($options, $old_options);
			$this->set_options($options);
			$this->after_save_config($this->get_options(), $old_options);
		}
	}
}
