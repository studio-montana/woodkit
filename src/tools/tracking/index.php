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
class WK_Tool_Tracking extends WK_Tool{
	
	public function __construct(){
		parent::__construct(array(
				'slug' => 'tracking', 
				'has_config' => true,
				'add_config_in_menu' => true,
				'documentation' => WOODKIT_URL_DOCUMENTATION.'/tracking'
			));
	}
	
	public function get_name() { 
		return __("Tracking", 'woodkit');
	}
	
	public function get_description() { 
		return __("Manage your website tracking (Google Analytics, Google Tag Manager)", 'woodkit');
	}
	
	public function launch() {
		require_once ($this->path.'launch.php');
	}
	
	public function get_config_fields(){
		return array(
				'googleanalytics-code',
				'googleanalytics-events',
				'googletagmanager-code',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'on',
				'googleanalytics-code' => null,
				'googleanalytics-events' => null,
				'googletagmanager-code' => null,
		);
	}
	
	public function display_config_fields(){
		?>
		<div class="wk-panel">
			<h2 class="wk-panel-title">
				<?php _e("Google Codes", 'woodkit'); ?>
			</h2>
			<div class="wk-panel-content">
				<div class="wk-panel-info"><?php _e("Google Analytics code isn't needed if you use Google Tag Manager", 'woodkit'); ?></div>
				<div class="field">
					<div class="field-content">
						<?php
						$googleanalytics_code = $this->get_option('googleanalytics-code');
						?>
						<label for="googleanalytics-code"><?php _e("Google Analytics code", 'woodkit'); ?></label>
						<input type="text" id="googleanalytics-code" name="googleanalytics-code" value="<?php echo esc_attr($googleanalytics_code); ?>" />
					</div>
				</div>
				<div class="field">
					<div class="field-content">
						<?php
						$googletagmanager_code = $this->get_option('googletagmanager-code');
						?>
						<label for="googletagmanager-code"><?php _e("Google Tag Manager code", 'woodkit'); ?></label>
						<input type="text" id="googletagmanager-code" name="googletagmanager-code" value="<?php echo esc_attr($googletagmanager_code); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="wk-panel">
			<h3 class="wk-panel-title">
				<?php _e("Google Analytics Event's tracking", 'woodkit'); ?>
			</h3>
			<div class="wk-panel-content">
				<?php if (empty($googleanalytics_code)){ ?>
				<div class="wk-panel-info" style="color: red;"><?php _e("To use Google Analytics Event manager, please set GA key.", 'woodkit'); ?></div>
				<?php } ?>
				<div class="wk-panel-info"><?php _e("You can add some Google Analytics Event rules based on CSS Selector - please don't use them when you are using Google Tag Manager.", 'woodkit'); ?></div>
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
						$events = $this->get_option("googleanalytics-events");
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
				<div class="wk-panel-info"><?php _e("Selector example", 'woodkit'); ?> : <code>body.home .header &gt; a.logo</code></div>
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
		
		return $values;
	}
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WK_Tool_Tracking();
	return $tools;
});
