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

$style = "width: 100%; height: 100%;";
$class = "";
$has_thumb = false;
$thumbnail = null;
$is_attachment = false;
if (has_post_thumbnail(get_the_ID())){
	$thumbnail_id = get_post_thumbnail_id(get_the_ID());
	$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'woodkit-1200');
}else if (wall_is_available_attachment_item(get_the_ID())){
	$is_attachment = true;
	$thumbnail_id = get_the_ID();
	$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'woodkit-1200');
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
}
if ($has_thumb){
	$class .= ' has-thumb';
}else{
	$class .= ' no-thumb';
}
$class = join(' ', get_post_class($class));
$class = wall_sanitize_wall_item_classes($class);

$width = 100;
$height = $wall_args['meta_wall_display_presentation_initial_height'];

$title = wall_get_wall_item_title(get_the_ID(), $wall_args);
$link = wall_get_wall_item_link(get_the_ID(), $wall_args);
$link_blank = wall_get_wall_item_link_blank(get_the_ID(), $wall_args);

?>
<li class="slider-item template-thumb <?php echo $class; ?>" style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>%;">
	<?php if (!is_admin()){ ?> <a href="<?php echo $link; ?>"
	<?php if ($link_blank == 'on'){ ?> target="_blank" <?php } ?>
	title="<?php echo esc_attr(get_the_title()); ?>"> <?php } ?>
		<div class="inner-item-wrapper" style="width: 100%; height: 100%;">
			<div class="inner-item thumb" style="<?php echo $style; ?>">

				<?php 
				/** since 1.2 inner template can be override */
				$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-template-slider-thumb-inner.php');
				if (!empty($template)){
					include($template);
				}else{
					?>
					<?php if (function_exists("woodkit_display_badge")) woodkit_display_badge(); ?>
					<div class="has-mask">
						<?php echo $title; ?>
					</div>
					<div class="has-infos">
						<?php echo $title; ?>
					</div>
					<?php if (!$has_thumb && is_admin()){ ?>
					<div class="no-content">
						<i class="fa fa-ban"></i>
					</div>
					<?php } ?>
					<?php 
				}
				?>

			</div>
		</div> <?php if (!is_admin()){ ?>
</a> <?php }else{
	echo $wall_args["meta_wall_admin_item_code"];
	} ?>
</li>
