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
class WoodkitTool{

	public $slug; // string
	public $name; // string
	public $description; // string
	public $has_config; // boolean
	public $add_config_in_menu; // boolean
	public $documentation_url; // string
	protected $config_nonce_name; // string

	public function __construct($slug, $name, $description = '', $has_config = false, $add_config_in_menu = true, $documentation_url = ''){
		$this->slug = $slug;
		$this->name = $name;
		$this->description = $description;
		$this->has_config = $has_config;
		$this->add_config_in_menu = $add_config_in_menu;
		$this->documentation_url = $documentation_url;
		$this->config_nonce_name = 'woodkit-tool-'.$this->slug.'-config-nonce';
	}
	
	public function launch(){
		require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.$this->slug.'/launch.php');
	}
	
	public function launch_widgets(){
		if (file_exists(WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.$this->slug.'/launch-widgets.php')){
			require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.$this->slug.'/launch-widgets.php');
		}
	}
	
	/**
	 * called when tool is activated
	 */
	public function activate(){}

	/**
	 * called when tool is deactivated
	 */
	public function deactivate(){}
	
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
			<h1>
				<?php echo __("Woodkit tools", 'woodkit'); ?><i class="fa fa-angle-right"></i><?php echo $this->name; ?>
				<a href="<?php menu_page_url("woodkit_options", true); ?>" class="all-tools page-title-action"><?php _e("View all tools", 'woodkit'); ?></a>
			</h1>
			<form method="post" action="<?php echo get_current_url(true); ?>">
				<input type="hidden" name="<?php echo $this->config_nonce_name; ?>" value="<?php echo wp_create_nonce($this->config_nonce_name); ?>" />
				<?php
				$this->display_config_fields();
				?>
				<div class="form-row form-row-submit">
					<button type="submit" class="woodkit-btn primary save">
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
					$values[$field] = null;
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
			$old_options = woodkit_get_tool_options($this->slug);
			$options = $this->save_config_fields(array());
			// IMPORTANT : keep 'active' option - because 'active' is not in tool config form, we must to keep 'active' value
			if (!isset($options['active'])){
				$options['active'] = woodkit_get_tool_option($this->slug, 'active');
			}
			$this->before_save_config($options, $old_options);
			woodkit_save_tool_options($this->slug, $options);
			$this->after_save_config(woodkit_get_tool_options($this->slug), $old_options);
		}
	}
}