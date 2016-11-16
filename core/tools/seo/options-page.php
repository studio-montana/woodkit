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

// save form values
if (isset($_POST) && !empty($_POST)){
	
}

?>
<div class="woodkit-page-options woodkit-tool-page-options woodkit-tool-seo-page-options">
	<h1>
		<?php _e("SEO settings", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
	</h1>
	<form method="post" action="<?php echo get_current_url(true); ?>">
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

				<div class="sitemap-options-manager">
				TODO SEO xmlsitemap options...
				</div>

			</div>
		</div>
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
