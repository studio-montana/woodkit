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

if (isset($_POST) && !empty($_POST) && isset($_POST['tool-seo-options-nonce']) && wp_verify_nonce($_POST['tool-seo-options-nonce'], 'tool-seo-options-nonce')){
	
	// -- save sitemap urls
	$urls = array();
	foreach ($_POST as $k => $v){
		if (startsWith($k, "seo-sitemap-url-id-")){
			$url = isset($_POST['seo-sitemap-url-'.$v]) ? sanitize_text_field($_POST['seo-sitemap-url-'.$v]) : "";
			$action = isset($_POST['seo-sitemap-url-action-'.$v]) ? sanitize_text_field($_POST['seo-sitemap-url-action-'.$v]) : "add";
			if (!empty($url)){
				$urls[] = array("id" => $v, "url" => $url, "action" => $action);
			}
		}
	}
	//highlight_string("var : " . var_export($urls, true)."\n");
	if (empty($urls)){
		delete_option("woodkit-tool-seo-options-sitemap-urls");
	}else{
		update_option("woodkit-tool-seo-options-sitemap-urls", $urls);
	}
	do_action("tool_xmlsitemap_update"); // regenerate sitemap.xml
	
	// -- save redirects
	$redirects = array();
	$redirects_error = array();
	foreach ($_POST as $k => $v){
		if (startsWith($k, "seo-redirect-id-")){
			$fromurl = isset($_POST['seo-redirect-fromurl-'.$v]) ? sanitize_text_field($_POST['seo-redirect-fromurl-'.$v]) : "";
			$tourl = isset($_POST['seo-redirect-tourl-'.$v]) ? sanitize_text_field($_POST['seo-redirect-tourl-'.$v]) : "";
			$test = isset($_POST['seo-redirect-test-'.$v]) ? sanitize_text_field($_POST['seo-redirect-test-'.$v]) : "equals";
			$disable = isset($_POST['seo-redirect-disable-'.$v]) ? sanitize_text_field($_POST['seo-redirect-disable-'.$v]) : "";
			$rank = isset($_POST['seo-redirect-rank-'.$v]) ? sanitize_text_field($_POST['seo-redirect-rank-'.$v]) : "1";
			if (!empty($fromurl) && !empty($tourl) && !empty($test)){
				$redirects[] = array("id" => $v, "fromurl" => $fromurl, "tourl" => $tourl, "test" => $test, "disable" => $disable, "rank" => $rank);
			}
		}
	}
	//highlight_string("var : " . var_export($redirects, true)."\n");
	if (empty($redirects)){
		delete_option("woodkit-tool-seo-options-redirects");
	}else{
		update_option("woodkit-tool-seo-options-redirects", $redirects);
	}
}

?>
<div class="woodkit-page-options woodkit-tool-page-options woodkit-tool-seo-page-options">
	<h1>
		<?php _e("SEO settings", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
	</h1>
	<?php 
	$xmlsitemap_active = woodkit_get_option("tool-seo-xmlsitemap-active");
	if ($xmlsitemap_active == "on"){
		?>
		<form method="post" action="<?php echo get_current_url(true); ?>">
			<input type="hidden" name="<?php echo 'tool-seo-options-nonce'; ?>" value="<?php echo wp_create_nonce('tool-seo-options-nonce'); ?>" />
			<div class="form-row form-row-submit">
				<button type="submit">
					<?php _e("Save", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
				</button>
			</div>
			
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
							$urls = get_option("woodkit-tool-seo-options-sitemap-urls", array());
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
			
			<div class="section">
				<h3 class="section-title">
					<?php _e("301 Redirects", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
				</h3>
				<?php
				$redirects = get_option("woodkit-tool-seo-options-redirects", array());
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
	
			<div class="form-row form-row-submit">
				<button type="submit">
					<?php _e("Save", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
				</button>
			</div>
		</form>
		<?php 
	}else{
		?>
		<h3><?php _e("To manage URLs on your sitemap.xml, you have to activate SEO &gt; sitemap.xml in Woodkit settings.", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></h3>
		<?php
	}
	?>
</div>
