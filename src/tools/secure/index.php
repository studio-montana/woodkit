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
define('SECURE_TOOL_NAME', 'secure');

/**
 * Tool instance
 */
class WK_Tool_Secure extends WK_Tool{
	
	public function __construct(){
		parent::__construct(array(
				'slug' => 'secure', 
				'has_config' => true,
				'add_config_in_menu' => true,
				'documentation' => WOODKIT_URL_DOCUMENTATION.'/secure'
			));
	}
	
	public function get_name() { 
		return __("Security", 'wooden');
	}
	
	public function get_description() { 
		return __("Secures your website", 'wooden');
	}
	
	public function launch() {
		require_once ($this->path.'launch.php');
	}
	
	public function get_config_fields(){
		return array(
				'captcha-active',
				'captcha-type',
				'captcha-google-key-public',
				'captcha-google-key-private',
				'failtoban-active',
				'headers-nosniff',
				'headers-xss',
				'headers-frame',
				'headers-referrer',
				'headers-poweredby',
				'headers-server',
				'headers-corswhitelist',
				/* - have to add these options in next version
				 'headers-hsts-time',
				 'headers-hsts-subdomains',
				 'headers-hsts-preload',
				 'headers-hpkp-key1',
				 'headers-hpkp-key2',
				 'headers-hpkp-key3',
				 'headers-hpkp-time',
				 'headers-hpkp-subdomains',
				 'headers-hpkp-uri',
				 */
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => "on",
				'captcha-active' => "on",
				'captcha-type' => "numeric",
				'failtoban-active' => "on",
				'headers-nosniff' => "on",
				'headers-xss' => "on",
				'headers-frame' => "on",
				'headers-referrer' => "no-referrer-when-downgrade",
				'headers-poweredby' => "on",
				'headers-server' => "on",
				'headers-corswhitelist' => "",
		);
	}
	
	public function display_config_fields(){
		?>
		<div class="wk-panel">
			<div class="wk-panel-content">
				<h3><?php _e("Captcha", 'woodkit'); ?></h3>
				<div class="field checkbox">
					<div class="field-content">
						<?php $value = $this->get_option('captcha-active');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						} ?>
						<input type="checkbox" id="captcha-active" name="captcha-active" <?php echo $checked; ?> />
						<label for="captcha-active"><?php _e("Captcha active", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Add captcha on login, register and comment forms (Woocommerce/ContactForm7 supported)', 'woodkit'); ?></p>
				</div>
				<div class="field select" data-config="captcha-type" style="display: none;">
					<div class="field-content">
						<label for="captcha-type"><?php _e("Captcha type", 'woodkit'); ?></label>
						<?php $value = $this->get_option('captcha-type'); ?>
						<select id="captcha-type" name="captcha-type">
							<?php $selected = (empty($value) || $value == 'numeric' ? 'selected="selected"' : ''); ?>
							<option value="numeric" <?php echo $selected; ?>><?php _e("Numeric", 'woodkit'); ?></option>
							<?php $selected = (!empty($value) && $value == 'google-v2' ? 'selected="selected"' : ''); ?>
							<option value="google-v2" <?php echo $selected; ?>><?php _e("Google Recaptcha V2", 'woodkit'); ?></option>
						</select>
					</div>
				</div>
				<div class="field text" data-config="captcha-google-key" style="display: none;">
					<div class="field-content">
						<?php $value = $this->get_option('captcha-google-key-public'); ?>
						<label for="captcha-google-key-public"><?php _e("Google Recaptcha public key", 'woodkit'); ?></label>
						<input type="text" id="captcha-google-key-public" name="captcha-google-key-public" value="<?php echo $value; ?>" />
					</div>
				</div>
				<div class="field text" data-config="captcha-google-key" style="display: none;">
					<div class="field-content">
						<?php $value = $this->get_option('captcha-google-key-private'); ?>
						<label for="captcha-google-key-private"><?php _e("Google Recaptcha private key", 'woodkit'); ?></label>
						<input type="text" id="captcha-google-key-private" name="captcha-google-key-private" value="<?php echo $value; ?>" />
					</div>
					<p class="description"><?php _e('To get these keys, please visit : ', 'woodkit'); ?><a href="https://www.google.com/recaptcha/admin/" target="_blank">Google Recaptcha admin</a></p>
				</div>
				<hr />
				<h3><?php _e("Blocking", 'woodkit'); ?></h3>
				<div class="field checkbox">
					<div class="field-content">
						<?php $value = $this->get_option('failtoban-active');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						} ?>
						<input type="checkbox" id="failtoban-active" name="failtoban-active" <?php echo $checked; ?> />
						<label for="failtoban-active"><?php _e("Failtoban active", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Block gross power hacking on login, register and comment forms (Woocommerce supported)', 'woodkit'); ?></p>
				</div>
				<hr />
				<h3><?php _e("Headers", 'woodkit'); ?></h3>
				<div class="field checkbox">
					<div class="field-content">
						<?php $value = $this->get_option('headers-nosniff');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						} ?>
						<input type="checkbox" id="headers-nosniff" name="headers-nosniff" <?php echo $checked; ?> />
						<label for="headers-nosniff"><?php _e("No sniff", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Disable content sniffing', 'woodkit'); ?></p>
				</div>
				<div class="field checkbox">
					<div class="field-content">
						<?php $value = $this->get_option('headers-xss');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						} ?>
						<input type="checkbox" id="headers-xss" name="headers-xss" <?php echo $checked; ?> />
						<label for="headers-xss"><?php _e("XSS protection", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Enabled web broswer XSS protection', 'woodkit'); ?></p>
				</div>
				<div class="field checkbox">
					<div class="field-content">
						<?php $value = $this->get_option('headers-frame');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						} ?>
						<input type="checkbox" id="headers-frame" name="headers-frame" <?php echo $checked; ?> />
						<label for="headers-frame"><?php _e("Restrict framing", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Enabled clickjacking protection', 'woodkit'); ?></p>
				</div>
				<div class="field checkbox">
					<div class="field-content">
						<?php $value = $this->get_option('headers-poweredby');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						} ?>
						<input type="checkbox" id="headers-poweredby" name="headers-poweredby" <?php echo $checked; ?> />
						<label for="headers-poweredby"><?php _e("Hide 'powered by' info", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Hide powered by info (php version)', 'woodkit'); ?></p>
				</div>
				<div class="field checkbox">
					<div class="field-content">
						<?php $value = $this->get_option('headers-server');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						} ?>
						<input type="checkbox" id="headers-server" name="headers-server" <?php echo $checked; ?> />
						<label for="headers-server"><?php _e("Hide 'Server' info", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Hide server info (server name/version)', 'woodkit'); ?></p>
				</div>
				<div class="field select">
					<div class="field-content">
						<?php $value = $this->get_option('headers-referrer'); ?>
						<select id="headers-referrer" name="headers-referrer">
							<?php $selected = (!empty($value) && $value == 'no-referrer' ? 'selected="selected"' : ''); ?>
							<option value="no-referrer" <?php echo $selected; ?>><?php _e("Omit entirely", 'woodkit'); ?></option>
							<?php $selected = (empty($value) || $value == 'no-referrer-when-downgrade' ? 'selected="selected"' : ''); ?>
							<option value="no-referrer-when-downgrade" <?php echo $selected; ?>><?php _e("(Browser default) omit referrer on downgrade to HTTP", 'woodkit'); ?></option>
							<?php $selected = (!empty($value) && $value == 'origin' ? 'selected="selected"' : ''); ?>
							<option value="origin" <?php echo $selected; ?>><?php _e("Only send the origin ( https://www.example.com/ )", 'woodkit'); ?></option>
							<?php $selected = (!empty($value) && $value == 'origin-when-cross-origin' ? 'selected="selected"' : ''); ?>
							<option value="origin-when-cross-origin" <?php echo $selected; ?>><?php _e("Full URL to current origin, but just origin to other sites", 'woodkit'); ?></option>
							<?php $selected = (!empty($value) && $value == 'same-origin' ? 'selected="selected"' : ''); ?>
							<option value="same-origin" <?php echo $selected; ?>><?php _e("Omit referrer for cross origin requests", 'woodkit'); ?></option>
							<?php $selected = (!empty($value) && $value == 'strict-origin' ? 'selected="selected"' : ''); ?>
							<option value="strict-origin" <?php echo $selected; ?>><?php _e("Send only the origin, or nothing on downgrade (HTTPS->HTTP)", 'woodkit'); ?></option>
							<?php $selected = (!empty($value) && $value == 'strict-origin-when-cross-origin' ? 'selected="selected"' : ''); ?>
							<option value="strict-origin-when-cross-origin" <?php echo $selected; ?>><?php _e("Omit on downgrade, just origin on cross-origin, and full to current origin", 'woodkit'); ?></option>
							<?php $selected = (!empty($value) && $value == 'unsafe-url' ? 'selected="selected"' : ''); ?>
							<option value="unsafe-url" <?php echo $selected; ?>><?php _e("Always send the whole URL", 'woodkit'); ?></option>
						</select>
					</div>
					<p class="description"><?php _e('Set referrer policy option', 'woodkit'); ?></p>
				</div>
				<div class="field select">
					<div class="field-content">
						<?php $value = $this->get_option('headers-corswhitelist'); ?>
						<textarea id="headers-corswhitelist" name="headers-corswhitelist" rows="10" placeholder="<?php echo esc_attr(__("CORS domains whitelist", 'woodkit')); ?>"><?php echo $value; ?></textarea>
					</div>
					<p class="description"><?php _e('Set CORS whitelist - one domain per line', 'woodkit'); ?></p>
				</div>
				<div class="wk-panel-info"><?php _e("You can view your headers and evaluate your website security", 'woodkit'); ?> : <a href="https://securityheaders.io/" target="_blank">https://securityheaders.io/</a></div>
			</div>
			<script type="text/javascript">
			(function($) {
				$(document).ready(function(){
					// -----------------------------------------------------
					// Captcha UI controllers
					function tool_secure_option__captcha_ctrl_() {
						tool_secure_option__captcha_type();
						tool_secure_option__captcha_google_key();
					}
					function tool_secure_option__captcha_type() {
						if ($("input[name='captcha-active']").is(':checked')) {
							$("*[data-config='captcha-type']").fadeIn(0);
						} else {
							$("*[data-config='captcha-type']").fadeOut(0);
						}
					}
					function tool_secure_option__captcha_google_key() {
						if ($("input[name='captcha-active']").is(':checked')) {
							if ($("select[name='captcha-type']").val() === 'google-v2') {
								$("*[data-config='captcha-google-key']").fadeIn(0);
							} else {
								$("*[data-config='captcha-google-key']").fadeOut(0);
							}
						} else {
							$("*[data-config='captcha-google-key']").fadeOut(0);
						}
					}
					tool_secure_option__captcha_ctrl_();
					$("input[name='captcha-active']").on("change", function(e){ tool_secure_option__captcha_ctrl_(); });
					$("select[name='captcha-type']").on("change", function(e){ tool_secure_option__captcha_ctrl_(); });
					// -----------------------------------------------------
				});
			})(jQuery);
			</script>
		</div>
		<?php
	}
	
	public function save_config_fields($values){
		$fields = $this->get_config_fields();
		if (!empty($fields)){
			foreach ($fields as $field){
				if (isset($_POST[$field])){
					if (is_array($_POST[$field]) || $field === 'headers-corswhitelist'){
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
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WK_Tool_Secure();
	return $tools;
});
