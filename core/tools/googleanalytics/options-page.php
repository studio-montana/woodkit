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

if (isset($_POST) && !empty($_POST) && isset($_POST['tool-googleanalytics-options-nonce']) && wp_verify_nonce($_POST['tool-googleanalytics-options-nonce'], 'tool-googleanalytics-options-nonce')){
	
	// -- save events
	$events = array();
	foreach ($_POST as $k => $v){
		if (startsWith($k, "googleanalytics-event-id-")){
			$selector = isset($_POST['googleanalytics-event-selector-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-selector-'.$v]) : "";
			$name = isset($_POST['googleanalytics-event-name-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-name-'.$v]) : "";
			$action = isset($_POST['googleanalytics-event-action-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-action-'.$v]) : "";
			$category = isset($_POST['googleanalytics-event-category-'.$v]) ? sanitize_text_field($_POST['googleanalytics-event-category-'.$v]) : "";
			$events[] = array("selector" => $selector, "name" => $name, "action" => $action, "category" => $category);
		}
	}
	if (empty($events)){
		delete_option("woodkit-tool-googleanalytics-options-events");
	}else{
		update_option("woodkit-tool-googleanalytics-options-events", $events);
	}
}

?>
<div class="woodkit-page-options woodkit-tool-page-options woodkit-tool-googleanalytics-page-options">
	<h1>
		<?php _e("Google Analytics settings", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
	</h1>
	<form method="post" action="<?php echo get_current_url(true); ?>">
		<input type="hidden" name="<?php echo 'tool-googleanalytics-options-nonce'; ?>" value="<?php echo wp_create_nonce('tool-googleanalytics-options-nonce'); ?>" />
		<div class="form-row form-row-submit">
			<button type="submit">
				<?php _e("Save", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
			</button>
		</div>

		<div class="section">
			<h3 class="section-title">
				<?php _e("Sitemap options", 'woodvehicles'); ?>
			</h3>
			<div class="section-content">

				<div class="googleanalyticsevents-manager"></div>
				
				<script type="text/javascript">
				jQuery(document).ready(function($){
					var googleanalyticsevents_manager = $(".googleanalyticsevents-manager").googleanalyticseventsmanager({
							label_add_event : "<?php _e("Add Google Analytics Event", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_event_selector : "<?php _e("css selector", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_event_name : "<?php _e("event label", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_event_action : "<?php _e("action name", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_event_category : "<?php _e("category name", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_confirm_remove_event : "<?php _e("Do you realy want remove this event ?", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
						});
					<?php 
					$events = get_option("woodkit-tool-googleanalytics-options-events", array());
					if (!empty($events)){
						$events_js = "{";
						foreach ($events as $k => $event){
							$selector = !empty($event['selector']) ? str_replace('"', '\"', str_replace('\\\\', '', $event['selector'])) : "";
							$name = !empty($event['name']) ? str_replace('"', '\"', str_replace('\\\\', '', $event['name'])) : "";
							$action = !empty($event['action']) ? str_replace('"', '\"', str_replace('\\\\', '', $event['action'])) : "";
							$category = !empty($event['category']) ? str_replace('"', '\"', str_replace('\\\\', '', $event['category'])) : "";
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

			</div>
		</div>

		<div class="form-row form-row-submit">
			<button type="submit">
				<?php _e("Save", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
			</button>
		</div>
	</form>
</div>
