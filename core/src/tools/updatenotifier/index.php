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
define('UPDATENOTIFIER_TOOL_NAME', 'updatenotifier');

/**
 * Tool instance
 */
class WoodkitToolUpdateNotifier extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(array(
				'slug' => 'updatenotifier',
				'name' => __("Update Notifier", 'woodkit'),
				'description' => __("[COMING SOON] - Get notification when something, themes, plugins, has to be updated. It's very useful to keep your website up to date and improve security.", 'woodkit'),
				'has_config' => true,
				'add_config_in_menu' => false,
				'documentation' => WOODKIT_URL_DOCUMENTATION.'/notification-mise-a-jour',
			));
	}
	
	public function on_activate(){
		/**
		 * Add CRON (if not exists)
		 */
		$currentSchedule = wp_get_schedule('woodkit_tool_updatenotifier_cron_daily');
		if (empty($currentSchedule)){
			// trace_info("tool_updatenotifier_activate - Add cron");
			wp_schedule_event( time(), 'daily', 'woodkit_tool_updatenotifier_cron_daily');
		}else{
			// trace_info("tool_updatenotifier_activate - Cron already exists");
		}
	}
	
	public function on_deactivate(){
		/**
		 * Remove CRON
		 */
		wp_clear_scheduled_hook('woodkit_tool_updatenotifier_cron_daily');
		// trace_info("tool_updatenotifier_activate - Cron already exists");
	}
	
	public function get_config_fields(){
		return array(
				'emails',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'on',
				'emails' => null,
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
						$value = $this->get_option('emails');
						?>
						<label for="emails"><?php _e("Send email to", 'woodkit'); ?></label>
						<input type="text" class="xlarge" id="emails" name="emails" value="<?php echo esc_attr($value); ?>" />
					</div>
					<p class="description"><?php _e("Send by default to Administrator. To send notification to multiple emails, please separate emails by coma", 'woodkit');?></p>
				</div>
			</div>
		</div>
		<div class="section">
			<h2 class="section-title">
				<?php _e("Integration", 'woodkit'); ?>
			</h2>
			<div class="section-content">
				<div class="section-info">
					<?php _e('insert this code in your theme templates :', 'woodkit'); ?><br /><code style="font-size: 0.7rem;">&lt;?php woodkit_updatenotifier(); ?&gt;</code>
				</div>
			</div>
		</div>
		<?php
	}
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolUpdateNotifier();
	return $tools;
});
