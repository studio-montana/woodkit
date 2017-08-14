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
<div id="tool-media-display-media" class="custom-fields-section">
	<header class="custom-fields-section-header">
		<h3><?php _e('Wordpress Gallery', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></h3>
	</header>
	<div class="custom-fields-section-content">
		<table class="fields">
			<tr valign="top">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION; ?>"><?php _e('Presentation', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION, true); ?>
					<select id="<?php echo META_MEDIA_PRESENTATION; ?>" name="<?php echo META_MEDIA_PRESENTATION; ?>">
						<option value="classic" <?php if (empty($meta) || $meta == 'classic'){ echo 'selected="selected"'; }?>><?php _e("classic", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
						<option value="slider" <?php if (!empty($meta) && $meta == 'slider'){ echo 'selected="selected"'; }?>><?php _e("slider", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
						<option value="masonry" <?php if (!empty($meta) && $meta == 'masonry'){ echo 'selected="selected"'; }?>><?php _e("masonry", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
						<option value="grid" <?php if (!empty($meta) && $meta == 'grid'){ echo 'selected="selected"'; }?>><?php _e("random grid", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
					</select>
				</td>
				<td valign="middle"></td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-slider-options">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_SLIDER_AUTOPLAY; ?>"><?php _e('Autoplay', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_SLIDER_AUTOPLAY, true); ?> 
					<input type="checkbox" id="<?php echo META_MEDIA_PRESENTATION_SLIDER_AUTOPLAY; ?>" name="<?php echo META_MEDIA_PRESENTATION_SLIDER_AUTOPLAY; ?>" <?php if (!empty($meta) && $meta == 'on'){ echo ' checked="checked"'; } ?> />
				</td>
				<td valign="middle"></td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-slider-options display-media-slider-options-thumb-nav">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_SLIDER_THUMB_NAV; ?>"><?php _e('Thumb navigation', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_SLIDER_THUMB_NAV, true); ?> 
					<input type="checkbox" id="<?php echo META_MEDIA_PRESENTATION_SLIDER_THUMB_NAV; ?>" name="<?php echo META_MEDIA_PRESENTATION_SLIDER_THUMB_NAV; ?>" <?php if (!empty($meta) && $meta == 'on'){ echo ' checked="checked"'; } ?> />
				</td>
				<td valign="middle"></td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-slider-options">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL; ?>"><?php _e('Carousel', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_SLIDER_CAROUSEL, true); ?> 
					<input type="checkbox" id="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL; ?>" name="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL; ?>" <?php if (!empty($meta) && $meta == 'on'){ echo ' checked="checked"'; } ?> />
				</td>
				<td valign="middle"></td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-slider-options display-media-slider-options-carousel">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH; ?>"><?php _e('Carousel item width', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH, true); 
					if (empty($meta) || !is_numeric($meta))
						$meta = "250";
					?>
					<input type="text" size="4" id="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH; ?>" name="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH; ?>" value="<?php echo $meta; ?>" />
				</td>
				<td valign="middle">px</td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-slider-options display-media-slider-options-carousel">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN; ?>"><?php _e('Carousel item margin', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN, true); 
					if (empty($meta) || !is_numeric($meta))
						$meta = "5";
					?>
					<input type="text" size="4" id="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN; ?>" name="<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN; ?>" value="<?php echo $meta; ?>" />
				</td>
				<td valign="middle">px</td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-slider-options">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_HEIGHT; ?>"><?php _e('Height', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_HEIGHT, true); 
					if (empty($meta) || !is_numeric($meta))
						$meta = "250";
					?>
					<input type="text" size="4" id="<?php echo META_MEDIA_HEIGHT; ?>" name="<?php echo META_MEDIA_HEIGHT; ?>" value="<?php echo $meta; ?>" />
				</td>
				<td valign="middle">px</td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-classic-options display-media-grid-options">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_FORMAT; ?>"><?php _e('Format', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_FORMAT, true); ?>
					<select id="<?php echo META_MEDIA_PRESENTATION_FORMAT; ?>" name="<?php echo META_MEDIA_PRESENTATION_FORMAT; ?>">
						<option value="square" <?php if (empty($meta) || $meta == 'square'){ echo 'selected="selected"'; }?>><?php _e("square", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
						<option value="portrait" <?php if (!empty($meta) && $meta == 'portrait'){ echo 'selected="selected"'; }?>><?php _e("portrait", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
						<option value="landscape" <?php if (!empty($meta) && $meta == 'landscape'){ echo 'selected="selected"'; }?>><?php _e("landscape", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
					</select>
				</td>
				<td valign="middle"></td>
				<td valign="middle"></td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-specific-options display-media-masonry-options">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_MASONRY_WIDTH; ?>"><?php _e('Max width', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_MASONRY_WIDTH, true); ?>
					<select id="<?php echo META_MEDIA_PRESENTATION_MASONRY_WIDTH; ?>" name="<?php echo META_MEDIA_PRESENTATION_MASONRY_WIDTH; ?>">
						<option value="fully-responsive" <?php if (empty($meta) && $meta == 'fully-responsive'){ echo 'selected="selected"'; }?>><?php _e("fully responsive", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
						<option value="customized" <?php if (!empty($meta) && $meta == 'customized'){ echo 'selected="selected"'; }?>><?php _e("customized", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></option>
					</select>
				</td>
				<td valign="middle" class="display-media-masonry-options-customized-width">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_MASONRY_WIDTH_WOODKITIZED, true); 
					if (empty($meta) || !is_numeric($meta))
						$meta = "250";
					?>
					<input type="number" size="4" id="<?php echo META_MEDIA_PRESENTATION_MASONRY_WIDTH_WOODKITIZED; ?>" name="<?php echo META_MEDIA_PRESENTATION_MASONRY_WIDTH_WOODKITIZED; ?>" value="<?php echo $meta; ?>" />
				</td>
				<td valign="middle" class="display-media-masonry-options-customized-width">px</td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-masonry-options">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_MASONRY_HEIGHT; ?>"><?php _e('Max height', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_MASONRY_HEIGHT, true); 
					if (empty($meta) || !is_numeric($meta))
						$meta = "";
					?>
					<input type="checkbox" id="display-media-masonry-auto-height" <?php if (empty($meta)){ echo ' checked="checked"'; } ?> />&nbsp;<label for="display-media-masonry-auto-height"><?php _e("Auto", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></label>					
				</td>
				<td valign="middle" class="display-media-masonry-options-customized-height">
					<input type="text" size="4" id="<?php echo META_MEDIA_PRESENTATION_MASONRY_HEIGHT; ?>" name="<?php echo META_MEDIA_PRESENTATION_MASONRY_HEIGHT; ?>" value="<?php echo $meta; ?>" />
				</td>
				<td valign="middle" class="display-media-masonry-options-customized-height">px</td>
			</tr>
			
			<tr valign="top" class="display-media-options display-media-classic-options display-media-grid-options display-media-masonry-options">
				<th class="metabox_label_column" align="left" valign="middle"><label
					for="<?php echo META_MEDIA_PRESENTATION_MARGIN_HORIZONTAL; ?>"><?php _e('Margins', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label>
				</th>
				<td valign="middle">
					<i class="fa fa-arrows-h"></i>
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_MARGIN_HORIZONTAL, true); 
					if (empty($meta) || !is_numeric($meta))
						$meta = "0";
					?>
					<input type="number" size="4" id="<?php echo META_MEDIA_PRESENTATION_MARGIN_HORIZONTAL; ?>" name="<?php echo META_MEDIA_PRESENTATION_MARGIN_HORIZONTAL; ?>" value="<?php echo $meta; ?>" />
					px
				</td>
				<td valign="middle">
					<i class="fa fa-arrows-v"></i>
					<?php $meta = get_post_meta(get_the_ID(), META_MEDIA_PRESENTATION_MARGIN_VERTICAL, true); 
					if (empty($meta) || !is_numeric($meta))
						$meta = "0";
					?>
					<input type="number" size="4" id="<?php echo META_MEDIA_PRESENTATION_MARGIN_VERTICAL; ?>" name="<?php echo META_MEDIA_PRESENTATION_MARGIN_VERTICAL; ?>" value="<?php echo $meta; ?>" />
					px
				</td>
				<td valign="middle"></td>
			</tr>
		</table>
		<script type="text/javascript">
		(function($) {
			$(document).ready(function(){
				// presentation 
				$("#<?php echo META_MEDIA_PRESENTATION; ?>").on("change", function(e){
					update_media_presentation_setup();
					update_media_masonry_options();
					update_media_slider_options();
				});
				// masonry width 
				$("#<?php echo META_MEDIA_PRESENTATION_MASONRY_WIDTH; ?>").on("change", function(e){
					update_media_masonry_options();
				});
				// masonry auto height 
				$("#display-media-masonry-auto-height").on("click", function(e){
					update_media_masonry_options();
				});
				// slider carousel 
				$("#<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL; ?>").on("click", function(e){
					update_media_slider_options();
				});
				// init 
				update_media_presentation_setup();
				update_media_masonry_options();
				update_media_slider_options();
			});
			function update_media_masonry_options(){
				if ($("#<?php echo META_MEDIA_PRESENTATION; ?>").val() == "masonry"){
					$(".display-media-masonry-options-customized-width").fadeOut(0);
					if ($("#<?php echo META_MEDIA_PRESENTATION_MASONRY_WIDTH; ?>").val() == 'customized'){
						$(".display-media-masonry-options-customized-width").fadeIn();
					}
					$(".display-media-masonry-options-customized-height").fadeOut(0);
					if ($("#display-media-masonry-auto-height").is(":checked")){
						$("*[name='<?php echo META_MEDIA_PRESENTATION_MASONRY_HEIGHT; ?>']").val("");
					}else{
						$(".display-media-masonry-options-customized-height").fadeIn();
						if ($("*[name='<?php echo META_MEDIA_PRESENTATION_MASONRY_HEIGHT; ?>']").val() == ""){
							$("*[name='<?php echo META_MEDIA_PRESENTATION_MASONRY_HEIGHT; ?>']").val("250");
						}
					}
				}
			}
			function update_media_slider_options(){
				if ($("#<?php echo META_MEDIA_PRESENTATION; ?>").val() == "slider"){
					$(".display-media-slider-options-carousel").fadeOut(0);
					$(".display-media-slider-options-thumb-nav").fadeOut(0);
					if ($("#<?php echo META_MEDIA_PRESENTATION_SLIDER_CAROUSEL; ?>").is(":checked")){
						$(".display-media-slider-options-carousel").fadeIn();
					}else{
						$(".display-media-slider-options-thumb-nav").fadeIn();
					}
				}
			}
			function update_media_presentation_setup(){
				$(".display-media-options").fadeOut(0);
				$(".display-media-"+$("#<?php echo META_MEDIA_PRESENTATION; ?>").val()+"-options").fadeIn();
			}
		})(jQuery);
		</script>
	</div>
</div>
