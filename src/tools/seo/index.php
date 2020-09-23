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
class WK_Tool_SEO extends WK_Tool{
	
	public function __construct(){
		parent::__construct(array(
				'slug' => 'seo', 
				'has_config' => true,
				'add_config_in_menu' => true,
				'documentation' => WOODKIT_URL_DOCUMENTATION.'/seo-referencement'
			));
	}
	
	public function get_name() { 
		return __("SEO", 'woodkit');
	}
	
	public function get_description() { 
		return __("Optimize your site SEO and manage your social publications", 'woodkit');
	}
	
	public function launch() {
		require_once ($this->path.'launch.php');
	}
	
	public function get_config_fields(){
		return array(
				'default-description',
				'default-keywords',
				'xmlsitemap-excluded-posttypes',
				'xmlsitemap-excluded-taxonomies',
				'options-redirects',
		);
	}
	
	public function get_config_default_values(){
		return array(
				'active' => 'on',
				'default-description' => null,
				'default-keywords' => null,
				'xmlsitemap-excluded-posttypes' => array(),
				'xmlsitemap-excluded-taxonomies' => array(),
				'options-redirects' => null,
		);
	}
	
	public function display_config_fields(){
		?>
		<div class="wk-panel">
			<h2 class="wk-panel-title">
				<span class="dashicons dashicons-format-video" style="margin-right: 6px;"></span><?php _e("Tutorials", 'woodkit'); ?>
			</h2>
			<div class="wk-panel-content">
				<a href="<?php echo esc_url(get_admin_url(null, 'admin.php?page=woodkit-tutorials-page&video=woodkit-seo')); ?>"><?php _e("See video tutorial and learn more about SEO management.", 'woodkit'); ?></a>
			</div>
		</div>
		<div class="wk-panel">
			<h2 class="wk-panel-title">
				<?php _e("Default values", 'woodkit'); ?>
			</h2>
			<div class="wk-panel-content">
				<div class="field" data-type="text">
					<div class="field-content">
						<?php
						$value = $this->get_option('default-description');
						?>
						<label for="default-description"><?php _e("Default description", 'woodkit'); ?></label>
						<input type="text" class="xlarge" id="default-description" name="default-description" value="<?php echo esc_attr($value); ?>" />
					</div>
					<p class="description"><?php _e("Used as default meta description in your website", 'woodkit');?></p>
				</div>
				<div class="field" data-type="text">
					<div class="field-content">
						<?php
						$value = $this->get_option('default-keywords');
						?>
						<label for="default-keywords"><?php _e("Default keywords", 'woodkit'); ?></label>
						<input type="text" class="xlarge" id="default-keywords" name="default-keywords" value="<?php echo esc_attr($value); ?>" />
					</div>
					<p class="description"><?php _e("Used as default meta keywords in your website", 'woodkit');?></p>
				</div>
			</div>
		</div>
		
		<?php /* Since WP 5.5, sitemap is automatically generated */ ?>
		<div class="wk-panel">
			<h3 class="wk-panel-title">
				<?php _e("XML sitemap options", 'woodkit'); ?>
			</h3>
			<div class="wk-panel-content">
				<div class="wk-panel-info"><?php _e("Wordpress generate automatically your website's XML sitemap, you can setup some features.", 'woodkit'); ?>&nbsp;<a href="<?php echo get_sitemap_url('index'); ?>" target="_blank"><?php _e("View your website's XML sitemap", 'woodkit'); ?></a></div>
				
				<h4><?php _e('Excluded providers'); ?></h4>
				<div class="wk-panel-info"><?php _e("Select providers you want to exclude from XML sitemap.", 'woodkit'); ?></div>
				<?php $xmlsitemap_excluded_providers = $this->get_option("xmlsitemap-excluded-providers");
				// il aurait été pas mal de faire une boucle générique sur wp_get_sitemap_providers() mais l'attribut 'name' de la class WP_Sitemaps_Provider est protected, donc impossible !
				$providers = array(
						array('name' => 'posts', 'label' => 'Post types'), // WP_Sitemaps_Posts
						array('name' => 'taxonomies', 'label' => 'Taxonomies'), // WP_Sitemaps_Taxonomies
						array('name' => 'users', 'label' => 'Utilisateurs'), // WP_Sitemaps_Users
				);
				if (!empty($providers)) {
					foreach ($providers as $provider) {
						$checked = (is_array($xmlsitemap_excluded_providers) && isset($xmlsitemap_excluded_providers[$provider['name']]) && $xmlsitemap_excluded_providers[$provider['name']] == 'on') ? ' checked="checked"' : ''; ?>
						<div class="field" data-type="checkbox">
							<div class="field-content">
								<label><input type="checkbox" class="" name="xmlsitemap-excluded-providers[<?php echo $provider['name']; ?>]"<?php echo $checked; ?> /><span><?php echo $provider['label']; ?></span></label>
							</div>
						</div>
					<?php }
				} ?>
				
				<h4><?php _e('Excluded post types'); ?></h4>
				<div class="wk-panel-info"><?php _e("Select post types you want to exclude from XML sitemap.", 'woodkit'); ?></div>
				<?php $xmlsitemap_excluded_posttypes = $this->get_option("xmlsitemap-excluded-posttypes");
				$post_types = get_post_types(array(
						'public' => true,
				), 'objects');
				if (!empty($post_types)) {
					foreach ($post_types as $post_type) {
						$checked = (is_array($xmlsitemap_excluded_posttypes) && isset($xmlsitemap_excluded_posttypes[$post_type->name]) && $xmlsitemap_excluded_posttypes[$post_type->name] == 'on') ? ' checked="checked"' : ''; ?>
						<div class="field" data-type="checkbox">
							<div class="field-content">
								<label><input type="checkbox" class="" name="xmlsitemap-excluded-posttypes[<?php echo $post_type->name; ?>]"<?php echo $checked; ?> /><span><?php echo $post_type->label; ?></span></label>
							</div>
						</div>
					<?php }
				} ?>
				
				<h4><?php _e('Excluded taxonomies'); ?></h4>
				<div class="wk-panel-info"><?php _e("Select taxonomies you want to exclude from XML sitemap.", 'woodkit'); ?></div>
				<?php $xmlsitemap_excluded_taxonomies = $this->get_option("xmlsitemap-excluded-taxonomies");
				$taxonomies = get_taxonomies(array(
						'public' => true,
				), 'objects');
				if (!empty($taxonomies)) {
					foreach ($taxonomies as $taxonomy) {
						$checked = (is_array($xmlsitemap_excluded_taxonomies) && isset($xmlsitemap_excluded_taxonomies[$taxonomy->name]) && $xmlsitemap_excluded_taxonomies[$taxonomy->name] == 'on') ? ' checked="checked"' : ''; ?>
						<div class="field" data-type="checkbox">
							<div class="field-content">
								<label><input type="checkbox" class="" name="xmlsitemap-excluded-taxonomies[<?php echo $taxonomy->name; ?>]"<?php echo $checked; ?> /><span><?php echo $taxonomy->label; ?></span></label>
							</div>
						</div>
					<?php }
				} ?>
			</div>
		</div>
			
		<div class="wk-panel">
			<h3 class="wk-panel-title">
				<?php _e("301 Redirects", 'woodkit'); ?>
			</h3>
			<?php
			$redirects = $this->get_option("options-redirects");
			$has_redirect_loop = seo_has_redirects_loop($redirects);
			if ($has_redirect_loop == true){ ?>
			<h4 style="background-color: #ECA400; color: #fff; padding: 12px;"><?php _e("WARNING : one or more rules may generate loop - this may crash your website", 'woodkit'); ?></h4>
			<?php } ?>
			<div class="wk-panel-content">
				<div class="wk-panel-info"><?php _e("Here you can add your 301 permanent redirects and order theme by drag & drop.", 'woodkit'); ?>&nbsp;<a href="https://blog.hubspot.com/blog/tabid/6307/bid/7430/what-is-a-301-redirect-and-why-should-you-care.aspx" target="_blank"><?php _e("What is a 301 permanent redirect ?", 'woodkit'); ?></a></div>

				<div class="redirects-manager"></div>
				
				<script type="text/javascript">
					jQuery(document).ready(function($){
						var redirects_manager = $(".redirects-manager").redirectsmanager({
								label_add_item : "<?php _e("Add redirection", 'woodkit'); ?>",
								label_confirm_remove_item : "<?php _e("Do you realy want remove this redirection ?", 'woodkit'); ?>",
								label_disable : "<?php _e("disable", 'woodkit'); ?>",
								label_to : "<?php _e("redirects to", 'woodkit'); ?>",
								label_from_url : "<?php _e("/my-old-page", 'woodkit'); ?>",
								label_to_url : "<?php _e("/my-new-page", 'woodkit'); ?>",
								label_test_equals : "<?php _e("URL that equals", 'woodkit'); ?>",
								label_test_matches : "<?php _e("URL that matches (regexp)", 'woodkit'); ?>",
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
		$xmlsitemap_active = isset($_POST['xmlsitemap-active']) ? sanitize_text_field($_POST['xmlsitemap-active']) : 'off';
		$xmlsitemap_notification_active = isset($_POST['xmlsitemap-notification-active']) ? sanitize_text_field($_POST['xmlsitemap-notification-active']) : 'off';
		$values['xmlsitemap-active'] = $xmlsitemap_active;
		$values['xmlsitemap-notification-active'] = $xmlsitemap_notification_active;
		
		// -- default SEO values
		$default_description = isset($_POST['default-description']) ? sanitize_text_field($_POST['default-description']) : '';
		$default_keywords = isset($_POST['default-keywords']) ? sanitize_text_field($_POST['default-keywords']) : '';
		$values['default-description'] = $default_description;
		$values['default-keywords'] = $default_keywords;
		
		// -- XML sitemap excluded items
		$xmlsitemap_excluded_posttypes = isset($_POST['xmlsitemap-excluded-posttypes']) ? $_POST['xmlsitemap-excluded-posttypes'] : '';
		$xmlsitemap_excluded_taxonomies = isset($_POST['xmlsitemap-excluded-taxonomies']) ? $_POST['xmlsitemap-excluded-taxonomies'] : '';
		$xmlsitemap_excluded_providers = isset($_POST['xmlsitemap-excluded-providers']) ? $_POST['xmlsitemap-excluded-providers'] : '';
		$values['xmlsitemap-excluded-posttypes'] = $xmlsitemap_excluded_posttypes;
		$values['xmlsitemap-excluded-taxonomies'] = $xmlsitemap_excluded_taxonomies;
		$values['xmlsitemap-excluded-providers'] = $xmlsitemap_excluded_providers;
			
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
	$tools[] = new WK_Tool_SEO();
	return $tools;
});
