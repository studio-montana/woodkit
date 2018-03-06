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
define('SPLASHSCREEN_TOOL_NAME', 'splashscreen');

/**
 * Tool instance
 */
class WoodkitToolSplashscreen extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(
				'splashscreen', 								// slug
				__("Splashscreen", 'woodkit'),				// name
				__("Add loading page to your site", 'woodkit'),	// description
				true,										// has config page
				false,										// add config page in woodkit submenu
				WOODKIT_URL_DOCUMENTATION.'/splashscreen'		// documentation url
			);
	}
	
	public function get_config_fields(){
		return array(
				'fadeoutspeed',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'off',
				'fadeoutspeed' => '300',
		);
	}
	
	public function display_config_fields(){
		?>
		<div class="section">
			<h2 class="section-title">
				<?php _e("General", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<div class="field">
					<div class="field-content">
						<?php
						$value = woodkit_get_tool_option($this->slug, 'fadeoutspeed');
						?>
						<label for="fadeoutspeed"><?php _e("Fadeout speed", 'woodkit'); ?></label>
						<input type="text" id="fadeoutspeed" name="fadeoutspeed" value="<?php echo esc_attr($value); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="section">
			<h2 class="section-title">
				<?php _e("Integration", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<div class="section-info">
					<?php _e('insert this code in your theme templates :', WOODKIT_PLUGIN_TEXT_DOMAIN); ?><br /><code style="font-size: 0.7rem;">&lt;?php woodkit_splashscreen(); ?&gt;</code>
				</div>
			</div>
		</div>
		<?php
	}
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolSplashscreen();
	return $tools;
});
