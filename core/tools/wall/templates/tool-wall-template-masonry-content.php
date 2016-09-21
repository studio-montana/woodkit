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

$style = "";
$class = "";
if ($wall_args['meta_wall_display_presentation_masonry_width'] == "customized"){
	$style .= "max-width: ".$wall_args['meta_wall_display_presentation_masonry_width_customized']."px;";
	$style .= "width: 100%;";
}else{
	$style .= "width: ".(100/$wall_args['meta_wall_display_presentation_masonry_width'])."%;";
}
$style .= " height: auto;";
$style .= "padding: 0 0 ".$wall_args['meta_wall_display_presentation_margin_vertical']."px ".$wall_args['meta_wall_display_presentation_margin_horizontal']."px;";
$class = join(' ', get_post_class($class));
$class = wall_sanitize_wall_item_classes($class);

$title = wall_get_wall_item_title(get_the_ID(), $wall_args);
$link = wall_get_wall_item_link(get_the_ID(), $wall_args);
$link_blank = wall_get_wall_item_link_blank(get_the_ID(), $wall_args);
?>
<li class="masonry-item template-content <?php echo $class; ?>" style="<?php echo $style; ?>" data-autoresponsive="true" data-columns="1">
	<?php if (!is_admin()){ ?>
	<a href="<?php echo $link; ?>"<?php if ($link_blank == 'on'){ ?> target="_blank"<?php } ?> title="<?php echo esc_attr(get_the_title()); ?>">
	<?php } ?>
		<div class="inner-item-wrapper" style="width: 100%; height: 100%;">
			<div class="inner-item content" style="width: 100%; height: 100%;">
		
				<?php if (function_exists("woodkit_display_badge")) woodkit_display_badge(); ?>
				
				<div class="has-mask">
					<?php if (function_exists("woodkit_display_thumbnail")){
						woodkit_display_thumbnail(get_the_ID(), $wall_args['image_size'], '', true, false, '<div class="thumb">', '</div>'); 
					}else if (has_post_thumbnail(get_the_ID())){
						?><div class="thumb"><?php the_post_thumbnail($wall_args['image_size']); ?></div><?php 
					}?>
					<?php echo $title; ?>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
				<div class="has-infos">
					<?php if (function_exists("woodkit_display_thumbnail")){
						woodkit_display_thumbnail(get_the_ID(), $wall_args['image_size'], '', true, false, '<div class="thumb">', '</div>'); 
					}else if (has_post_thumbnail(get_the_ID())){
						?><div class="thumb"><?php the_post_thumbnail($wall_args['image_size']); ?></div><?php 
					}?>
					<?php echo $title; ?>
					<div class="excerpt"><?php the_excerpt(); ?></div>
				</div>
			</div>
		</div>
	<?php if (!is_admin()){ ?>
	</a>
	<?php }else{
		echo $wall_args['meta_wall_admin_item_code'];
	} ?>
</li>