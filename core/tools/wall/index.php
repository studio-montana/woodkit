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
define('WALL_TOOL_NAME', 'wall');

/**
 * Tool instance
 */
class WoodkitToolWall extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(
				'wall', 								// slug
				__("Wall", 'woodkit'),				// name
				__("Create multi-content galleries", 'woodkit'),	// description
				true,										// has config page
				false,										// add config page in woodkit submenu
				WOODKIT_URL_DOCUMENTATION.'/wall'		// documentation url
			);
	}
	
	public function get_config_fields(){
		return array(
				'imagesize',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'off',
				'imagesize' => 'woodkit-600',
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
						$value = woodkit_get_tool_option($this->slug, 'imagesize');
						$available_sizes = Woodkit::get_image_sizes();
						?>
						<label for="imagesize"><?php _e("Thumbnails size", 'woodkit'); ?></label>
						<select id="imagesize" name="imagesize">
						<?php if (!empty($available_sizes)){
							$first = true;
							foreach ($available_sizes as $size_slug => $size_args){
								$selected = "";
								if ((empty($value) && $first) || $value == $size_slug){
									$selected = 'selected="selected"';
								} ?>
								<option value="<?php echo $size_slug; ?>" <?php echo $selected; ?>><?php echo $size_args['label']; ?></option>
								<?php $first = false;
							}
						}
						?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolWall();
	return $tools;
});
