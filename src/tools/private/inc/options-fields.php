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

function tool_private_get_node($post_type, $posts, $is_hierarchical = false){
	$go_private = get_option(TOOL_PRIVATE_OPTIONS_GO_PRIVATE, "0");
	global $post;
	?>
	<ul class="tool-private-box post-type-<?php echo $post_type; ?>">
	<?php
	foreach ($posts as $post){
		setup_postdata($post);
		?>
		<li>
			<input class="tool-private-item" type="checkbox" id="tool-private-item-<?php the_ID(); ?>" name="tool-private-item-<?php the_ID(); ?>" <?php if (tool_private_is_private_post(get_the_ID()) && !empty($go_private) && $go_private == "2"){ ?> checked="checked"<?php } ?> />
			<label for="tool-private-item-<?php the_ID(); ?>"><?php the_title(); ?></label>
		</li>
		<?php
		if ($is_hierarchical){
			$sub_posts = get_pages(array("post_type" => $post_type, 'numberposts' => -1, "orderby" => "name", "order" => "ASC", "parent" => get_the_ID(), "suppress_filters" => false));
			if (!empty($sub_posts)){
				tool_private_get_node($post_type, $sub_posts, $is_hierarchical);
			}
		}
		wp_reset_postdata();
	}
	?>
	</ul>
	<?php
}
?>

<div id="tool-private-settings" class="woodkit-settings-section">
	<header class="woodkit-settings-section-header">
		<h3><?php _e("Private settings", 'woodkit'); ?></h3>
	</header>
	<div class="woodkit-settings-section-content">
		<table class="settings">
			<tr valign="top">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo TOOL_PRIVATE_OPTIONS_GO_PRIVATE; ?>"><?php _e('You want to', 'woodkit'); ?> : </label>
				</th>
				<td valign="middle">
					<?php 
					$meta = get_option(TOOL_PRIVATE_OPTIONS_GO_PRIVATE, "0");
					?>
					<select id="<?php echo TOOL_PRIVATE_OPTIONS_GO_PRIVATE; ?>" name="<?php echo TOOL_PRIVATE_OPTIONS_GO_PRIVATE; ?>">
						<option value="0" <?php if (empty($meta) || $meta == "0"){ echo ' selected="selected"'; } ?>><?php _e("do nothing", 'woodkit'); ?></option>
						<option value="1"<?php if (!empty($meta) && $meta == "1"){ echo ' selected="selected"'; } ?>><?php _e("go private this site", 'woodkit'); ?></option>
						<option value="2"<?php if (!empty($meta) && $meta == "2"){ echo ' selected="selected"'; } ?>><?php _e("go private few elements", 'woodkit'); ?></option>
					</select>
				</td>
				<td valign="middle"></td>
			</tr>
			<tr valign="top" class="private-options private-options-1 private-options-2">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo TOOL_PRIVATE_OPTIONS_MESSAGE."-".woodkit_get_current_lang(); ?>"><?php _e("Message", 'woodkit'); ?> : </label>
				</th>
				<td valign="middle">
					<?php 
					$meta = get_option(TOOL_PRIVATE_OPTIONS_MESSAGE."-".woodkit_get_current_lang(), "");
					?>
					<input type="text" id="<?php echo TOOL_PRIVATE_OPTIONS_MESSAGE."-".woodkit_get_current_lang(); ?>" name="<?php echo TOOL_PRIVATE_OPTIONS_MESSAGE."-".get_current_lang(); ?>" value="<?php echo esc_attr($meta); ?>" size="40" placeholder="<?php _e("Private area"); ?>..." />
				</td>
				<td valign="middle"></td>
			</tr>
			<tr valign="top" class="private-options private-options-2">
				<th class="metabox_label_column" align="left" valign="middle"></th>
				<td valign="middle">
					<?php
					$available_posttypes = apply_filters("private_available_posttypes", get_displayed_post_types(true));
					foreach ($available_posttypes as $post_type){
						$is_hierarchical = is_post_type_hierarchical($post_type);
						if ($is_hierarchical)
							$posts = get_pages(array("post_type" => $post_type, 'numberposts' => -1, "orderby" => "name", "order" => "ASC", "parent" => 0, "suppress_filters" => false));
						else
							$posts = get_posts(array("post_type" => $post_type, 'numberposts' => -1, "orderby" => "name", "order" => "ASC", "suppress_filters" => false));
						if (!empty($posts)){
							$current_post_type_label = get_post_type_labels(get_post_type_object($post_type));
							?>
							<h3 class="sitemap-title post-type-<?php echo $post_type; ?>"><?php echo $current_post_type_label->name; ?></h3>
							<?php tool_private_get_node($post_type, $posts, $is_hierarchical); ?>
							<?php
						}
					}
					?>
				</td>
				<td valign="middle"></td>
			</tr>
		</table>
		<script type="text/javascript">
		(function($) {
			$(document).ready(function(){
				// init 
				$(".private-options").fadeOut(0);
				$(".private-options-"+$("select[name='<?php echo TOOL_PRIVATE_OPTIONS_GO_PRIVATE; ?>']").val()).fadeIn(0);
				$(".tool-private-item").each(function(i){
					$next = $(this).parent().next();
					if ($next.prop('tagName') == "UL"){
						if ($(this).is(":checked")){
							$next.find(".tool-private-item").prop('checked', true);
							$next.find(".tool-private-item").prop('disabled', true);
						}
					}
				});

				// events 
				$("select[name='<?php echo TOOL_PRIVATE_OPTIONS_GO_PRIVATE; ?>']").on("change", function(e){
					$(".private-options").fadeOut(0);
					$(".private-options-"+$(this).val()).fadeIn();
				});
				$(".tool-private-item").on("change", function(e){
					$next = $(this).parent().next();
					if ($next.prop('tagName') == "UL"){
						if ($(this).is(":checked")){
							$next.find(".tool-private-item").prop('checked', true);
							$next.find(".tool-private-item").prop('disabled', true);
						}else{
							$next.find(".tool-private-item").prop('checked', false);
							$next.find(".tool-private-item").prop('disabled', false);
						}
					}
				});
			});
		})(jQuery);
		</script>
	</div>
</div>