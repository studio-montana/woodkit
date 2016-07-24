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

$class = "";
$style = "width: 100%; height: 100%;";
$class_a= "";
$rel_a= "";

$has_thumb = false;
$thumbnail = null;
$is_attachment = false;
if (has_post_thumbnail(get_the_ID())){
	$thumbnail_id = get_post_thumbnail_id(get_the_ID());
	$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'woodkit-400');
}else if (wall_is_available_attachment_item(get_the_ID())){
	$is_attachment = true;
	$thumbnail_id = get_the_ID();
	$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'woodkit-400');
}
if (!empty($thumbnail)){
	$has_thumb = true;
	list($thumbnail_src, $thumbnail_width, $thumbnail_height) = $thumbnail;
	$style .= "background:	url('$thumbnail_src') no-repeat center center;";
	$style .= "-webkit-background-size: cover;";
	$style .= "-moz-background-size: cover;";
	$style .= "-o-background-size: cover;";
	$style .= "-ms-background-size: cover;";
	$style .= "background-size: cover;";
	$style .= "overflow: hidden;";
	$class .= " has-thumb";
}else{
	$class .= " no-thumb";
}
if ($is_attachment){
	$class_a .= " fancybox";
	$rel_a .= " group-wall";
}

$class = join(' ', get_post_class($class));
$class = wall_sanitize_wall_item_classes($class);

$width = 100/$wall_args['meta_wall_display_presentation_columns']*$wall_args['wall_item_width_selected'];
$height = 250*$wall_args['wall_item_height_selected']; /* override by js */

$style_li = "";
$style_li .= "height: ".$height."px; width: ".$width."%;";
$style_li .= "padding: 0 0 ".$wall_args['meta_wall_display_presentation_margin_vertical']."px ".$wall_args['meta_wall_display_presentation_margin_horizontal']."px;";

$title = wall_get_wall_item_title(get_the_ID(), $wall_args);
$link = wall_get_wall_item_link(get_the_ID(), $wall_args);
$link_blank = wall_get_wall_item_link_blank(get_the_ID(), $wall_args);
?>
<li class="isotope-item template-thumb <?php echo $class; ?>"style="<?php echo $style_li; ?>" data-format="<?php echo $wall_args['meta_wall_display_presentation_format']; ?>" data-columns="<?php echo $wall_args['wall_item_width_selected']; ?>" data-lines="<?php echo $wall_args['wall_item_height_selected']; ?>">
	<?php if (!is_admin()){ ?>
	<a href="<?php echo $link; ?>"<?php if ($link_blank == 'on'){ ?> target="_blank"<?php } ?> class="<?php echo $class_a ?>" rel="<?php echo $rel_a; ?>" title="<?php echo esc_attr(get_the_title()); ?>">
	<?php } ?>
		<div class="inner-item-wrapper" style="width: 100%; height: 100%;">
			<div class="inner-item thumb" style="<?php echo $style; ?>">
		
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
		echo $wall_args["meta_wall_admin_item_code"];
	} ?>
</li>