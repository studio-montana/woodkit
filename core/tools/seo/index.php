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
define('SEO_TOOL_NAME', 'seo');

/**
 * Tool instance
 */
class WoodkitToolSEO extends WoodkitTool{
	
	public function __construct(){
		parent::__construct(
				'seo', 								// slug
				__("SEO", 'woodkit'),					// name
				__("Optimize your site SEO and manage your social publications", 'woodkit'),	// description
				true,										// has config page
				true,										// add config page in woodkit submenu
				WOODKIT_URL_DOCUMENTATION.'/seo-referencement'		// documentation url
			);
	}
	
	public function get_config_fields(){
		return array(
				'opengraph-active',
				'xmlsitemap-active',
				'xmlsitemap-notification-active',
				'default-description',
				'default-keywords',
				'options-sitemap-urls',
				'options-redirects',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'on',
				'opengraph-active' => 'on',
				'xmlsitemap-active' => 'on',
				'xmlsitemap-notification-active' => 'on',
				'default-description' => null,
				'default-keywords' => null,
				'options-sitemap-urls' => null,
				'options-redirects' => null,
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
						$value = woodkit_get_tool_option($this->slug, 'opengraph-active');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						}
						?>
						<input type="checkbox" id="opengraph-active" name="opengraph-active" <?php echo $checked; ?> />
						<label for="opengraph-active"><?php _e("Opengraph active", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e('Social network publication management', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></p>
				</div>
				<div class="field checkbox">
					<div class="field-content">
						<?php
						$value = woodkit_get_tool_option($this->slug, 'xmlsitemap-active');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						}
						?>
						<input type="checkbox" id="xmlsitemap-active" name="xmlsitemap-active" <?php echo $checked; ?> />
						<label for="xmlsitemap-active"><?php _e("Enable sitemap.xml generator", 'woodkit'); ?></label>
					</div>
					<p class="description"><a href="<?php echo woodkit_seo_get_xmlsitemap_url(); ?>" target="_blank"><?php _e('view your sitemap.xml', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></a></p>
				</div>
				<div class="field checkbox">
					<div class="field-content">
						<?php
						$value = woodkit_get_tool_option($this->slug, 'xmlsitemap-notification-active');
						$checked = '';
						if ($value == 'on'){
							$checked = ' checked="checked"';
						}
						?>
						<input type="checkbox" id="xmlsitemap-notification-active" name="xmlsitemap-notification-active" <?php echo $checked; ?> />
						<label for="xmlsitemap-notification-active"><?php _e("Enable search engine notifications", 'woodkit'); ?></label>
					</div>
					<p class="description"><?php _e("Notify Google, Yahoo, Bing, Ask when your sitemap.xml is updated", 'woodkit');?></p>
				</div>
			</div>
		</div>
		<div class="section">
			<h2 class="section-title">
				<?php _e("Default values", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
			</h2>
			<div class="section-content">
				<div class="field" data-type="text">
					<div class="field-content">
						<?php
						$value = woodkit_get_tool_option($this->slug, 'default-description');
						?>
						<label for="default-description"><?php _e("Default description", 'woodkit'); ?></label>
						<input type="text" class="xlarge" id="default-description" name="default-description" value="<?php echo esc_attr($value); ?>" />
					</div>
					<p class="description"><?php _e("Used as default meta description in your website", 'woodkit');?></p>
				</div>
				<div class="field" data-type="text">
					<div class="field-content">
						<?php
						$value = woodkit_get_tool_option($this->slug, 'default-keywords');
						?>
						<label for="default-keywords"><?php _e("Default keywords", 'woodkit'); ?></label>
						<input type="text" class="xlarge" id="default-keywords" name="default-keywords" value="<?php echo esc_attr($value); ?>" />
					</div>
					<p class="description"><?php _e("Used as default meta keywords in your website", 'woodkit');?></p>
				</div>
			</div>
		</div>
		
		<?php 
		$xmlsitemap_active = woodkit_get_tool_option($this->slug, "xmlsitemap-active");
		if ($xmlsitemap_active == "on"){
			?>
			<div class="section">
				<h3 class="section-title">
					<?php _e("Sitemap options", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
				</h3>
				<div class="section-content">
					<div class="section-info"><?php _e("Your sitemap.xml is automaticaly generated, however you can add URLs manualy  or exclude generated URLs.", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>&nbsp;<a href="<?php echo woodkit_seo_get_xmlsitemap_url(); ?>" target="_blank"><?php _e('View sitemap.xml', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></a></div>
					<div class="seourls-manager"></div>
					<script type="text/javascript">
						jQuery(document).ready(function($){
							var seourls_manager = $(".seourls-manager").seourlsmanager({
									label_add_item : "<?php _e("Add sitemap rule", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
									label_confirm_remove_item : "<?php _e("Do you realy want remove this url ?", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
									label_url : "<?php _e("http://www.website.com", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
									label_url_exclude : "<?php _e("exclude", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
									label_action_add : "<?php _e("add", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
									label_action_exclude_if_equals : "<?php _e("exclude if equals", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
									label_action_exclude_if_contains : "<?php _e("exclude if contains", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
									label_action_exclude_if_regexp : "<?php _e("exclude if matches regexp", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								});
							<?php 
							$urls = woodkit_get_tool_option($this->slug, "options-sitemap-urls");
							if (!empty($urls)){
								$urls_js = "{";
								foreach ($urls as $k => $item){
									$id = !empty($item['id']) ? esc_attr($item['id']) : 1;
									$url = !empty($item['url']) ? esc_attr($item['url']) : "";
									$action = !empty($item['action']) ? esc_attr($item['action']) : "";
									$urls_js .= intval($k).":{id: \"".$id."\", url: \"".$url."\", action:\"".$action."\"},";
								}
								$urls_js .= "}";
								?>
								seourls_manager.set_data(<?php echo $urls_js; ?>);
								<?php
							}
							?>
						});
					</script>
	
				</div>
			</div>
			<?php 
		} ?>
		
		<div class="section">
			<h3 class="section-title">
				<?php _e("301 Redirects", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
			</h3>
			<?php
			$redirects = woodkit_get_tool_option($this->slug, "options-redirects");
			$has_redirect_loop = seo_has_redirects_loop($redirects);
			if ($has_redirect_loop == true){ ?>
			<h4 style="background-color: #ECA400; color: #fff; padding: 12px;"><?php _e("WARNING : one or more rules may generate loop - this may crash your website", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></h4>
			<?php } ?>
			<div class="section-content">
				<div class="section-info"><?php _e("Here you can add your 301 permanent redirects and order theme by drag & drop.", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>&nbsp;<a href="https://blog.hubspot.com/blog/tabid/6307/bid/7430/what-is-a-301-redirect-and-why-should-you-care.aspx" target="_blank"><?php _e("What is a 301 permanent redirect ?", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></a></div>

				<div class="redirects-manager"></div>
				
				<script type="text/javascript">
					jQuery(document).ready(function($){
						var redirects_manager = $(".redirects-manager").redirectsmanager({
								label_add_item : "<?php _e("Add redirection", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								label_confirm_remove_item : "<?php _e("Do you realy want remove this redirection ?", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								label_disable : "<?php _e("disable", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								label_to : "<?php _e("redirects to", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								label_from_url : "<?php _e("/my-old-page", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								label_to_url : "<?php _e("/my-new-page", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								label_test_equals : "<?php _e("URL that equals", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
								label_test_matches : "<?php _e("URL that matches (regexp)", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							});
						<?php 
						if (!is_array($redirects))
							$redirects = array();
						if (!empty($redirects)){
							usort($redirects, "woodkit_cmp_options_sorted");
							$redirects_js = "{";
							foreach ($redirects as $k => $item){
								$id = !empty($item['id']) ? esc_attr($item['id']) : 1;
								$fromurl = !empty($item['fromurl']) ? esc_attr($item['fromurl']) : "";
								$tourl = !empty($item['tourl']) ? esc_attr($item['tourl']) : "";
								$test = !empty($item['test']) ? esc_attr($item['test']) : "equals";
								$disable = !empty($item['disable']) ? esc_attr($item['disable']) : "";
								$redirects_js .= intval($k).":{id: \"".$id."\", fromurl: \"".$fromurl."\", tourl: \"".$tourl."\", test:\"".$test."\", disable:\"".$disable."\"},";
							}
							$redirects_js .= "}";
							?>
							redirects_manager.set_data(<?php echo $redirects_js; ?>);
							<?php
						}
						?>
					});
				</script>

			</div>
		</div>
		<?php
	}
	
	public function save_config_fields($values){
		// -- general
		$opengraph_active = isset($_POST['opengraph-active']) ? sanitize_text_field($_POST['opengraph-active']) : 'off';
		$xmlsitemap_active = isset($_POST['xmlsitemap-active']) ? sanitize_text_field($_POST['xmlsitemap-active']) : 'off';
		$xmlsitemap_notification_active = isset($_POST['xmlsitemap-notification-active']) ? sanitize_text_field($_POST['xmlsitemap-notification-active']) : 'off';
		$values['opengraph-active'] = $opengraph_active;
		$values['xmlsitemap-active'] = $xmlsitemap_active;
		$values['xmlsitemap-notification-active'] = $xmlsitemap_notification_active;
		
		// -- default SEO values
		$default_description = isset($_POST['default-description']) ? sanitize_text_field($_POST['default-description']) : '';
		$default_keywords = isset($_POST['default-keywords']) ? sanitize_text_field($_POST['default-keywords']) : '';
		$values['default-description'] = $default_description;
		$values['default-keywords'] = $default_keywords;
			
		// -- save sitemap urls
		$urls = array();
		foreach ($_POST as $k => $v){
			if (startsWith($k, "sitemap-url-id-")){
				$url = isset($_POST['sitemap-url-'.$v]) ? sanitize_text_field($_POST['sitemap-url-'.$v]) : "";
				$action = isset($_POST['sitemap-url-action-'.$v]) ? sanitize_text_field($_POST['sitemap-url-action-'.$v]) : "add";
				if (!empty($url)){
					$urls[] = array("id" => $v, "url" => $url, "action" => $action);
				}
			}
		}
		//highlight_string("var : " . var_export($urls, true)."\n");
		$values['options-sitemap-urls'] = $urls;
			
		// -- save redirects
		$redirects = array();
		$redirects_error = array();
		foreach ($_POST as $k => $v){
			if (startsWith($k, "redirect-id-")){
				$fromurl = isset($_POST['redirect-fromurl-'.$v]) ? sanitize_text_field($_POST['redirect-fromurl-'.$v]) : "";
				$tourl = isset($_POST['redirect-tourl-'.$v]) ? sanitize_text_field($_POST['redirect-tourl-'.$v]) : "";
				$test = isset($_POST['redirect-test-'.$v]) ? sanitize_text_field($_POST['redirect-test-'.$v]) : "equals";
				$disable = isset($_POST['redirect-disable-'.$v]) ? sanitize_text_field($_POST['redirect-disable-'.$v]) : "";
				$rank = isset($_POST['redirect-rank-'.$v]) ? sanitize_text_field($_POST['redirect-rank-'.$v]) : "1";
				if (!empty($fromurl) && !empty($tourl) && !empty($test)){
					$redirects[] = array("id" => $v, "fromurl" => $fromurl, "tourl" => $tourl, "test" => $test, "disable" => $disable, "rank" => $rank);
				}
			}
		}
		//highlight_string("var : " . var_export($redirects, true)."\n");
		$values['options-redirects'] = $redirects;
		
		return $values;
	}
}
add_filter("woodkit-register-tool", function($tools){
	$tools[] = new WoodkitToolSEO();
	return $tools;
});
