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

if (empty($postypes)){
	$postypes = get_displayed_post_types(true);
}
global $post;

if (!empty($postypes)){
	?>
	<div class="results">
		<div class="column column-left">
			<h1 class="title">
				<?php _e("Icons shortcodes", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>
			</h1>
			<!-- TODO search field ! -->
		</div>
		<div class="column column-right">
			<div class="icons-box">
				<div class="icons-box-container">
					<?php 
					$icons = apply_filters("iconpicker_icons_add", array());
					foreach ($icons as $familly => $icons){
						?>
					<div class="icons-box-familly">
						<div class="icons-box-familly-title">
							<h2><?php echo $familly; ?></h2>
						</div>
						<div class="icons-box-familly-content">
							<?php foreach ($icons as $icon){ 
								foreach ($icon as $class => $name){
									?>
									<span class="button icon-item" data-icon-name="<?php echo esc_attr($name); ?>" data-icon-class="<?php echo esc_attr($class); ?>"><i class="<?php echo esc_attr($class); ?>"></i></span>
									<?php 
								}
							} ?>
						</div>
						<hr />
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>