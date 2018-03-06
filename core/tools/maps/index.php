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
define('MAPS_TOOL_NAME', 'maps');

/**
 * Tool instance
 */
class WoodkitToolMaps extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(
				'maps', 								// slug
				__("Maps", 'woodkit'),				// name
				__("Add a Google Maps shortcode & widget", 'woodkit'),	// description
				true,										// has config page
				true,										// add config page in woodkit submenu
				WOODKIT_URL_DOCUMENTATION.'/maps'		// documentation url
			);
	}
	
	public function get_config_fields(){
		return array(
				'googlemaps-apikey',
				'googlemaps-enqueueapi',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'googlemaps-active' => 'off',
				'googlemaps-enqueueapi' => 'on',
		);
	}
	
	public function display_config_fields(){
		?>
		<div class="section">
			<h2 class="section-title">
				<?php _e("Google Maps", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<div class="field">
					<div class="field-content">
						<?php
						$value = woodkit_get_tool_option($this->slug, 'googlemaps-apikey');
						?>
						<label for="googlemaps-apikey"><?php _e("API KEY", 'woodkit'); ?></label>
						<input type="text" id="googlemaps-apikey" name="googlemaps-apikey" value="<?php echo esc_attr($value); ?>" />
						<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"><?php _e("Get google maps API KEY", 'woodkit'); ?></a>
					</div>
				</div>
				<div class="field checkbox">
					<div class="field-content">
						<?php
						$value = woodkit_get_tool_option($this->slug, 'googlemaps-enqueueapi');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						}
						?>
						<input type="checkbox" id="googlemaps-enqueueapi" name="googlemaps-enqueueapi" <?php echo $checked; ?> />
						<label for="googlemaps-enqueueapi"><?php _e("Enqueue Google Maps API", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('enqueue googlemaps api script (disable when you use other plugin which enqueues this api)', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></p>
				</div>
			</div>
		</div>
		<div class="section">
			<h2 class="section-title">
				<?php _e("Integration", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<div class="section-info">
					<?php _e('shortcode :', WOODKIT_PLUGIN_TEXT_DOMAIN); ?><br /><code style="font-size: 0.7rem;">&lt;?php echo do_shortcode(\'[googlemaps id="gmaps1465" adress="" title="" type="ROADMAP" width="100%" height="400px" style="" /]\'); ?&gt;</code>
				</div>
			</div>
		</div>
		<?php
	}
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolMaps();
	return $tools;
});
