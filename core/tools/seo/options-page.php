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
	
	// -- save urls
	$urls = array();
	foreach ($_POST as $k => $v){
		if (startsWith($k, "seo-sitemap-url-id-")){
			$url = isset($_POST['seo-sitemap-url-'.$v]) ? sanitize_text_field($_POST['seo-sitemap-url-'.$v]) : "";
			if (!empty($url)){
				$action = isset($_POST['seo-sitemap-url-action-'.$v]) ? sanitize_text_field($_POST['seo-sitemap-url-action-'.$v]) : "";
				$urls[] = array("url" => $url, "action" => $action);
			}
		}
	}
	// trace
	//highlight_string("var : " . var_export($urls, true)."\n");
	if (empty($urls)){
		delete_option("woodkit-tool-seo-options-sitemap-urls");
	}else{
		update_option("woodkit-tool-seo-options-sitemap-urls", $urls);
	}
	// regenerate sitemap.xml
	do_action("tool_xmlsitemap_update");
}

?>
<div class="woodkit-page-options woodkit-tool-page-options woodkit-tool-seo-page-options">
	<h1>
		<?php _e("SEO settings", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
	</h1>
	<form method="post" action="<?php echo get_current_url(true); ?>">
		<input type="hidden" name="<?php echo 'tool-seo-options-nonce'; ?>" value="<?php echo wp_create_nonce('tool-seo-options-nonce'); ?>" />
		<div class="form-row form-row-submit">
			<button type="submit">
				<?php _e("Save", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
			</button>
		</div>

		<?php 
		$xmlsitemap_active = woodkit_get_option("tool-seo-xmlsitemap-active");
		if ($xmlsitemap_active == "on"){
		?>
		<div class="section">
			<h3 class="section-title">
				<?php _e("Sitemap options", 'woodvehicles'); ?>
			</h3>
			<div class="section-content">
				<div class="section-info"><?php _e("Your sitemap.xml is automaticaly generated, however you can add URLs manualy  or exclude generated URLs.", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>&nbsp;<a href="<?php echo woodkit_seo_get_xmlsitemap_url(); ?>" target="_blank"><?php _e('View sitemap.xml', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></a></div>

				<div class="seourls-manager"></div>
				
				<script type="text/javascript">
				jQuery(document).ready(function($){
					var seourls_manager = $(".seourls-manager").seourlsmanager({
							label_add_url : "<?php _e("Add sitemap rule", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_url : "<?php _e("http://www.website.com", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_url_exclude : "<?php _e("exclude", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
							label_confirm_remove_url : "<?php _e("Do you realy want remove this url ?", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>",
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
							$url = !empty($item['url']) ? esc_attr($item['url']) : "";
							$action = !empty($item['action']) ? esc_attr($item['action']) : "";
							$urls_js .= intval($k).":{url: \"".$url."\", action:\"".$action."\"},";
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
		}else{
			?>
			<p><?php _e("To manage URLs on your sitemap.xml, you have to activate sitemap.xml in Woodkit settings.", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></p>
			<?php
		}
		?>

		<div class="form-row form-row-submit">
			<button type="submit">
				<?php _e("Save", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
			</button>
		</div>
	</form>
</div>
