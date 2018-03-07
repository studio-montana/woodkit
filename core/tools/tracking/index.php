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
define('TRACKING_TOOL_NAME', 'tracking');

/**
 * Tool instance
 */
class WoodkitToolTracking extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(
				'tracking', 								// slug
				__("Tracking", 'woodkit'),					// name
				__("Manage your website tracking (Google Analytics, Google Tag Manager, FaceBook Pixel, ...)", 'woodkit'),	// description
				true,										// has config page
				true,										// add config page in woodkit submenu
				WOODKIT_URL_DOCUMENTATION.'/tracking'		// documentation url
			);
	}
	
	public function get_config_fields(){
		return array(
				'googleanalytics-code',
				'googleanalytics-events',
				'googletagmanager-code',
				'facebook-pixel',
				'facebook-pixel-events'
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'on',
				'googleanalytics-code' => null,
				'googleanalytics-events' => null,
				'googletagmanager-code' => null,
				'facebook-pixel' => null,
				'facebook-pixel-events' => null,
		);
	}
	
	public function display_config_fields(){
		?>
		<div class="section">
			<h2 class="section-title">
				<?php _e("Google Codes", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<div class="section-info"><?php _e("Google Analytics code isn't needed if you use Google Tag Manager", 'woodkit'); ?></div>
				<div class="field">
					<div class="field-content">
						<?php
						$googleanalytics_code = woodkit_get_tool_option($this->slug, 'googleanalytics-code');
						?>
						<label for="googleanalytics-code"><?php _e("Google Analytics code", 'woodkit'); ?></label>
						<input type="text" id="googleanalytics-code" name="googleanalytics-code" value="<?php echo esc_attr($googleanalytics_code); ?>" />
					</div>
				</div>
				<div class="field">
					<div class="field-content">
						<?php
						$googletagmanager_code = woodkit_get_tool_option($this->slug, 'googletagmanager-code');
						?>
						<label for="googletagmanager-code"><?php _e("Google Tag Manager code", 'woodkit'); ?></label>
						<input type="text" id="googletagmanager-code" name="googletagmanager-code" value="<?php echo esc_attr($googletagmanager_code); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="section">
			<h3 class="section-title">
				<?php _e("Google Analytics Event's tracking", 'woodkit'); ?>
			</h3>
			<div class="section-content">
				<?php if (empty($googleanalytics_code)){ ?>
				<div class="section-info" style="color: red;"><?php _e("To use Google Analytics Event manager, please set GA key.", 'woodkit'); ?></div>
				<?php } ?>
				<div class="section-info"><?php _e("You can add some Google Analytics Event rules based on CSS Selector - please don't use them when you are using Google Tag Manager.", 'woodkit'); ?></div>
				<div class="googleanalyticsevents-manager"></div>
				<script type="text/javascript">
					jQuery(document).ready(function($){
						var googleanalyticsevents_manager = $(".googleanalyticsevents-manager").googleanalyticseventsmanager({
								label_add_event : "<?php _e("Add Google Analytics Event", 'woodkit'); ?>",
								label_event_selector : "<?php _e("css selector", 'woodkit'); ?>",
								label_event_name : "<?php _e("event label", 'woodkit'); ?>",
								label_event_action : "<?php _e("action name", 'woodkit'); ?>",
								label_event_category : "<?php _e("category name", 'woodkit'); ?>",
								label_confirm_remove_event : "<?php _e("Do you realy want remove this event ?", 'woodkit'); ?>",
							});
						<?php 
						$events = woodkit_get_tool_option($this->slug, "googleanalytics-events");
						if (!empty($events)){
							$events_js = "{";
							foreach ($events as $k => $event){
								$selector = !empty($event['selector']) ? esc_attr($event['selector']) : "";
								$name = !empty($event['name']) ? esc_attr($event['name']) : "";
								$action = !empty($event['action']) ? esc_attr($event['action']) : "";
								$category = !empty($event['category']) ? esc_attr($event['category']) : "";
								$events_js .= intval($k).":{selector: \"".$selector."\", name:\"".$name."\", action:\"".$action."\", category:\"".$category."\"},";
							}
							$events_js .= "}";
							?>
							googleanalyticsevents_manager.set_data(<?php echo $events_js; ?>);
							<?php
						}
						?>
					});
				</script>
				<div class="section-info"><?php _e("Selector example", 'woodkit'); ?> : <code>body.home .header &gt; a.logo</code></div>
			</div>
		</div>
		<div class="section">
			<h2 class="section-title">
				<?php _e("FaceBook Pixel", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<div class="section-info"><?php _e("You can generate your FB Pixel code from your FB Pub manager. For more informations : ", 'woodkit'); ?><a href="https://www.facebook.com/business/a/facebook-pixel" target="_blank"><?php _e("click here", 'woodkit'); ?></a></div>
				<div class="field textarea">
					<div class="field-content">
						<?php
						$facebook_pixel = str_replace("\\'", "'", str_replace('\\"', '"', woodkit_get_tool_option($this->slug, 'facebook-pixel')));
						?>
						<textarea class="xlarge" style="min-height: 200px;" id="facebook-pixel" name="facebook-pixel" placeholder="<?php echo esc_attr(__("Pixel code", 'woodkit')); ?>"><?php echo $facebook_pixel; ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="section">
			<h2 class="section-title">
				<?php _e("FaceBook Pixel Events", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<?php if (empty($facebook_pixel)){ ?>
					<div class="section-info" style="color: red;"><?php _e("Please setup your Pixel code to use this feature.", 'woodkit'); ?></div>
				<?php } ?>
				<div class="section-info"><?php _e("Set page URL on which you want generate event and choose type of event", 'woodkit'); ?></div>
				<div class="facebookpixelevents-manager"></div>
				<script type="text/javascript">
					jQuery(document).ready(function($){
						var facebookpixelevents_manager = $(".facebookpixelevents-manager").facebookpixeleventsmanager({
								label_add_event : "<?php _e("Add Pixel Event", 'woodkit'); ?>",
								label_event_url : "<?php _e("URL", 'woodkit'); ?>",
								label_event_code : "<?php _e("Event code", 'woodkit'); ?>",
								label_event_parameters : "<?php _e("include url parameters", 'woodkit'); ?>",
								label_confirm_remove_event : "<?php _e("Do you realy want remove this event ?", 'woodkit'); ?>",
							});
						<?php 
						$facebookpixel_events = woodkit_get_tool_option($this->slug, "facebook-pixel-events");
						if (!empty($facebookpixel_events)){
							$facebookpixel_events_js = "{";
							foreach ($facebookpixel_events as $k => $facebookpixel_event){
								$url = !empty($facebookpixel_event['url']) ? esc_attr($facebookpixel_event['url']) : "";
								$code = !empty($facebookpixel_event['code']) ? esc_attr($facebookpixel_event['code']) : "";
								$parameters = !empty($facebookpixel_event['parameters']) ? esc_attr($facebookpixel_event['parameters']) : "";
								$facebookpixel_events_js .= intval($k).":{url: \"".$url."\", code:\"".$code."\", parameters:\"".$parameters."\"},";
							}
							$facebookpixel_events_js .= "}";
							?>
							facebookpixelevents_manager.set_data(<?php echo $facebookpixel_events_js; ?>);
							<?php
						}
						?>
					});
				</script>
				<div class="section-info"><?php _e("Example", 'woodkit'); ?> : <code>url : https://www.yourwebsite.com/presentation - type : Lead</code> <?php _e("will send a 'Lead' event to your FB Pixel when somebody visits your https://www.yourwebsite.com/presentation worpdress page.", 'woodkit'); ?></div>
				<div class="section-info"><?php _e("Note 1 : your theme must integrate the following code just after", 'woodkit'); ?> &lt;head&gt; (header.php) : <code>&lt;?php do_action("wp_start_body"); ?&gt;</code></div>
				<div class="section-info"><?php _e("Note 2 : specified URLs must be served by your Wordpress website.", 'woodkit'); ?></div>
			</div>
		</div>
		<?php
	}
	
	public function save_config_fields($values){
		// -- googleanalytics-code
		if (isset($_POST['googleanalytics-code'])){
			$values['googleanalytics-code'] = woodkit_get_request_param('googleanalytics-code', '');
		}
		
		// -- googletagmanager-code
		if (isset($_POST['googletagmanager-code'])){
			$values['googletagmanager-code'] = woodkit_get_request_param('googletagmanager-code', '');
		}
		
		// -- googleanalytics-events
		$events = array();
		foreach ($_POST as $k => $v){
			if (startsWith($k, "googleanalytics-event-id-")){
				$selector = isset($_POST['googleanalytics-event-selector-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-selector-'.$v]) : "";
				$name = isset($_POST['googleanalytics-event-name-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-name-'.$v]) : "";
				$action = isset($_POST['googleanalytics-event-action-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-action-'.$v]) : "";
				$category = isset($_POST['googleanalytics-event-category-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-category-'.$v]) : "";
				if (!empty($selector)){
					$events[] = array("selector" => $selector, "name" => $name, "action" => $action, "category" => $category);
				}
			}
		}
		$values['googleanalytics-events'] = $events;
		
		// -- facebook-pixel
		if (isset($_POST['facebook-pixel'])){
			$values['facebook-pixel'] = woodkit_get_request_param('facebook-pixel', '', false);
		}
		
		// -- facebook-pixel-events
		$events = array();
		foreach ($_POST as $k => $v){
			if (startsWith($k, "facebookpixel-event-id-")){
				$url = isset($_POST['facebookpixel-event-url-'.$v]) ? sanitize_text_field($_POST['facebookpixel-event-url-'.$v]) : "";
				$code = isset($_POST['facebookpixel-event-code-'.$v]) ? $_POST['facebookpixel-event-code-'.$v] : "";
				$parameters = isset($_POST['facebookpixel-event-parameters-'.$v]) ? sanitize_text_field($_POST['facebookpixel-event-parameters-'.$v]) : "";
				if (!empty($url) && !empty($code)){
					$events[] = array("url" => $url, "code" => $code, "parameters" => $parameters);
				}
			}
		}
		$values['facebook-pixel-events'] = $events;
		
		return $values;
	}
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolTracking();
	return $tools;
});
