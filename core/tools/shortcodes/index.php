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
 * Constants
 */
define('SHORTCODES_TOOL_NAME', 'shortcodes');

/**
 * Tool instance
 */
class WoodkitToolShortcodes extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(
				'shortcodes', 									// slug
				__("Shortcodes", 'woodkit'),				// name
				__("Add few shortcodes on your html editor: icons, columns, anchors...", 'woodkit'),	// description
				true,											// has config page
				false,											// add config page in woodkit submenu
				WOODKIT_URL_DOCUMENTATION.'/shortcodes'			// documentation url
			);
	}
	
	public function get_config_fields(){
		return array(
				'enable-anchor',
				'enable-columns',
				'enable-exergue',
				'enable-heightspace',
				'enable-icons',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'off',
				'enable-anchor' => 'on',
				'enable-columns' => 'on',
				'enable-exergue' => 'on',
				'enable-heightspace' => 'on',
				'enable-icons' => 'on',
		);
	}
	
	public function display_config_fields(){
		?>
			<div class="section">
				<h2 class="section-title">
					<?php _e("General", 'woodkit'); ?>
				</h2>
				<div class="section-content">
					<div class="field checkbox">
						<div class="field-content">
							<?php
							$value = woodkit_get_tool_option($this->slug, 'enable-anchor');
							$checked = $value == 'on' ? ' checked="checked"' : '';
							?>
							<input type="checkbox" id="enable-anchor" name="enable-anchor" <?php echo $checked; ?> />
							<label for="enable-anchor"><?php _e("Enable shortcode 'anchor'", 'woodkit'); ?></label>
						</div>
					</div>
					<div class="field checkbox">
						<div class="field-content">
							<?php
							$value = woodkit_get_tool_option($this->slug, 'enable-columns');
							$checked = $value == 'on' ? ' checked="checked"' : '';
							?>
							<input type="checkbox" id="enable-columns" name="enable-columns" <?php echo $checked; ?> />
							<label for="enable-columns"><?php _e("Enable shortcode 'columns'", 'woodkit'); ?></label>
						</div>
					</div>
					<div class="field checkbox">
						<div class="field-content">
							<?php
							$value = woodkit_get_tool_option($this->slug, 'enable-exergue');
							$checked = $value == 'on' ? ' checked="checked"' : '';
							?>
							<input type="checkbox" id="enable-exergue" name="enable-exergue" <?php echo $checked; ?> />
							<label for="enable-exergue"><?php _e("Enable shortcode 'exergue'", 'woodkit'); ?></label>
						</div>
					</div>
					<div class="field checkbox">
						<div class="field-content">
							<?php
							$value = woodkit_get_tool_option($this->slug, 'enable-heightspace');
							$checked = $value == 'on' ? ' checked="checked"' : '';
							?>
							<input type="checkbox" id="enable-heightspace" name="enable-heightspace" <?php echo $checked; ?> />
							<label for="enable-heightspace"><?php _e("Enable shortcode 'heightspace'", 'woodkit'); ?></label>
						</div>
					</div>
					<div class="field checkbox">
						<div class="field-content">
							<?php
							$value = woodkit_get_tool_option($this->slug, 'enable-icons');
							$checked = $value == 'on' ? ' checked="checked"' : '';
							?>
							<input type="checkbox" id="enable-icons" name="enable-icons" <?php echo $checked; ?> />
							<label for="enable-icons"><?php _e("Enable shortcode 'icons'", 'woodkit'); ?></label>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolShortcodes();
	return $tools;
});
