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
?>
<div id="tool-widgetmanager-general" class="custom-fields-section">
	<header class="custom-fields-section-header">
		<h3><?php _e("Widget manager", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></h3>
	</header>
	<div class="custom-fields-section-content">
		<?php 
		$available_sidebar_ids = tool_widgetmanager_get_available_sidebar_ids();
		$sidebars_widgets = wp_get_sidebars_widgets();
		foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar_id => $sidebar_args){
			if (in_array($sidebar_id, $available_sidebar_ids)){
				$widgets = array();
				if (isset($sidebars_widgets[$sidebar_id]) & !empty($sidebars_widgets[$sidebar_id])){
					$widgets = $sidebars_widgets[$sidebar_id];
				}
				?>
				<div class="widgets-area-item">
					<div class="section-title"><?php echo $sidebar_args['name']; ?></div>
					<div class="widget-items">
						<?php 
						foreach ($widgets as $widget_id){
							$widget = $GLOBALS['wp_registered_widgets'][$widget_id];
							$widget_obj = $widget['callback'][0];
							// IMPORTANT - I don't why $widget_obj->id not always good id (in case of two same declaratino widget : the id is the last id...)
							$widget_obj->id = $widget_id;
							$hide_field_name = TOOL_WIDGETMANAGER_HIDE_WIDGET_.$sidebar_id.$widget_obj->id;
							$hide_field_value = @get_post_meta($post->ID, $hide_field_name, true);
							$checked = '';
							if (isset($hide_field_value) && $hide_field_value == 'on'){
								$checked = ' checked="checked"';
							}
							?>
							<div class="widget-item">
								<div class="widget-name"><?php echo __("Widget").' "'.$widget_obj->name; ?><i class="fa fa-caret-down control open"></i><i class="fa fa-caret-up control close"></i></div>
								<div class="widget-item-options">
									<table>
										<tr>
											<td>
												<label for="<?php echo $hide_field_name; ?>"><?php echo __("hide", WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
											</td>
											<td>
												<input<?php echo $checked; ?> type="checkbox" id="<?php echo $hide_field_name; ?>" name="<?php echo $hide_field_name; ?>" />
											</td>
										</tr>
									</table>
									<?php
									// EXTERNAL FORM
									do_action("tool_widgetmanager_post_widget_form_".$widget_obj->id_base, $post->ID,  $sidebar_id, $widget_obj);								
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".widget-item .widget-name .control.close").fadeOut(0);
		$(".widget-item .widget-item-options").fadeOut(0);
		$(document).on("click", ".widget-item .widget-name", function() {
			windgetmanager_toogle_widget_options($(this).parent());
		});
		function windgetmanager_toogle_widget_options($item){
			if ($item.find('.widget-item-options').is(':visible')){
				$item.find('.widget-item-options').fadeOut();
				$item.find('.widget-name .open').fadeIn();
				$item.find('.widget-name .close').fadeOut();
			}else{
				$item.find('.widget-item-options').fadeIn();
				$item.find('.widget-name .open').fadeOut();
				$item.find('.widget-name .close').fadeIn();
			}
		}
	});
	</script>
</div>