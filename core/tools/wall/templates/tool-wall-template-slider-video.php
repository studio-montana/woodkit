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
if (video_has_featured_video(get_the_ID())){
	$class .= ' has-video';
}else{
	$class .= ' no-video';
}
$class = join(' ', get_post_class($class));
$class = wall_sanitize_wall_item_classes($class);

$width = 100;
$height = $wall_args['meta_wall_display_presentation_initial_height'];

$link = "";
if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()])){
	$link = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()];
}
if (empty($link)){
	$link = get_the_permalink();
}
$link_blank = "";
if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()])){
	$link_blank = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()];
}
?>
<li class="slider-item template-video <?php echo $class; ?>" style="height: <?php echo $height; ?>px; width: <?php echo $width; ?>%;">
	<div class="inner-item-wrapper">
		<div class="inner-item video" style="width: 100%; height: 100%;">
		
			<?php 
			/** since 1.2 inner template can be override */
			$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-template-slider-video-inner.php');
			if (!empty($template)){
				include($template);
			}else{
				?>
				<?php if (function_exists("woodkit_display_badge")) woodkit_display_badge(); ?>
				<?php
				if (video_has_featured_video(get_the_ID())){
					 echo video_get_featured_video(get_the_ID(), "100%", "100%");
				}else if(is_admin()){
					?>
					<div class="no-content" style="min-height: 150px;"><i class="fa fa-ban"></i></div>
					<?php
				}
				?>
				<?php if (!is_admin()){ ?>
				<div class="has-more"><a class="post-link" href="<?php echo $link; ?>"<?php if ($link_blank == 'on'){ ?> target="_blank"<?php } ?> title="<?php echo esc_attr(__("more", 'woodkit')); ?>"><?php _e("more", 'woodkit'); ?></a></div>
				<?php } ?>
				<?php 
			}
			?>
		
			
		</div>
	</div>
	<?php if (is_admin()){
		echo $wall_args["meta_wall_admin_item_code"];
	} ?>
</li>