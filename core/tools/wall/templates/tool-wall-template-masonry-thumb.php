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

$ratio = "";
$style = "";
$class = "";
$style_thumb = "width: 100%; height: 100%;";
$has_thumb = false;
$width = $wall_args['meta_wall_display_presentation_masonry_width_customized'];
$height = $wall_args['meta_wall_display_presentation_masonry_height'];
if (has_post_thumbnail(get_the_ID())){
	$thumbnail_id = get_post_thumbnail_id(get_the_ID());
	$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'tool-wall-thumb');
	if ($thumbnail) {
		$has_thumb = true;
		list($thumbnail_src, $thumbnail_width, $thumbnail_height) = $thumbnail;
		$ratio = $thumbnail_height / $thumbnail_width;
		if ($wall_args['meta_wall_display_presentation_masonry_width'] == "customized"){
			$style .= "max-width: ".$width."px;";
			$style .= "width: 100%;";
			$proportional_height = floor(($thumbnail_height*$width)/$thumbnail_width);
			if (!empty($height) && is_numeric($height) && $proportional_height > $height){
				$style .= "height: ".$height."px;";
			}else{
				$style .= "height: ".$proportional_height."px;";
			}
		}else{
			$style .= "width: ".(100/$wall_args['meta_wall_display_presentation_masonry_width'])."%;";
			$temp_width = floor($thumbnail_width * ((100 / $wall_args['meta_wall_display_presentation_masonry_width']) / 100));
			$proportional_height = floor(($thumbnail_height*$temp_width)/$thumbnail_width);
			if (!empty($height) && is_numeric($height) && $proportional_height > $height){
				$style .= "height: ".$height."px;";
			}else{
				$style .= "height: ".$proportional_height."px;";
			}
		}
		$style_thumb .= "background:	url('$thumbnail_src') no-repeat center center;";
		$style_thumb .= "-webkit-background-size: cover;";
		$style_thumb .= "-moz-background-size: cover;";
		$style_thumb .= "-o-background-size: cover;";
		$style_thumb .= "-ms-background-size: cover;";
		$style_thumb .= "background-size: cover;";
		$style_thumb .= "overflow: hidden;";
	}
}
if (!$has_thumb){
	if ($wall_args['meta_wall_display_presentation_masonry_width'] == "customized"){
		$style .= "max-width: ".$wall_args['meta_wall_display_presentation_masonry_width_customized']."px;";
		$style .= "width: 100%;";
	}else{
		$style .= "width: ".(100/$wall_args['meta_wall_display_presentation_masonry_width'])."%;";
	}
	$style .= " max-height: ".$wall_args["meta_wall_display_presentation_masonry_height"]."px;";
	$class .= ' no-thumb';
}else{
	$class .= ' has-thumb';
}
$class = join(' ', get_post_class($class));
$class = wall_sanitize_wall_item_classes($class);
$style .= "padding: 0 0 ".$wall_args['meta_wall_display_presentation_margin_vertical']."px ".$wall_args['meta_wall_display_presentation_margin_horizontal']."px;";

$title = wall_get_wall_item_title(get_the_ID(), $wall_args);
$link = wall_get_wall_item_link(get_the_ID(), $wall_args);
$link_blank = wall_get_wall_item_link_blank(get_the_ID(), $wall_args);
?>
<li class="masonry-item template-thumb <?php echo $class; ?>" style="<?php echo $style; ?>" data-ratio-width-height="<?php echo $ratio; ?>" data-columns="1">
	<?php if (!is_admin()){ ?>
	<a href="<?php echo $link; ?>"<?php if ($link_blank == 'on'){ ?> target="_blank"<?php } ?> title="<?php echo esc_attr(get_the_title()); ?>">
	<?php } ?>
		<div class="inner-item-wrapper" style="width: 100%; height: 100%;">
			<div class="inner-item thumb" style="<?php echo $style_thumb; ?>">
		
				<?php if (function_exists("woodkit_display_badge")) woodkit_display_badge(); ?>
				
				<div class="has-mask">
					<?php echo $title; ?>
				</div>
				<div class="has-infos">
					<?php echo $title; ?>
				</div>
				<?php if (!$has_thumb && is_admin()){ ?><div class="no-content"><i class="fa fa-ban"></i></div><?php } ?>
			</div>
		</div>
	<?php if (!is_admin()){ ?>
	</a>
	<?php }else{
		echo $wall_args['meta_wall_admin_item_code'];
	} ?>
</li>