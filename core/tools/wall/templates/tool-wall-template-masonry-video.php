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
if (video_has_featured_video(get_the_ID())){
	if (empty($wall_args["meta_wall_display_presentation_masonry_height"]) || !is_numeric($wall_args["meta_wall_display_presentation_masonry_height"])){
		$style .= " height: auto;";
	}else{
		$style .= " max-height: ".$wall_args["meta_wall_display_presentation_masonry_height"]."px;";
	}
	$class .= ' has-video';
}else{
	$class .= ' no-video';
}
$class = join(' ', get_post_class($class));
$class = wall_sanitize_wall_item_classes($class);
?>
<li class="masonry-item template-video <?php echo $class; ?>" style="<?php echo $style; ?>" data-columns="1">
	<div class="inner-item-wrapper">
		<div class="inner-item video" style="width: 100%; height: 100%;">
		
			<?php if (function_exists("woodkit_display_badge")) woodkit_display_badge(); ?>
				
			<?php
			if (video_has_featured_video(get_the_ID())){
				 echo video_get_featured_video(get_the_ID(), "100%", "100%");
			}else if(is_admin()){
				?>
				<div class="no-content"	><i class="fa fa-ban"></i></div>
				<?php
			}
			?>
			<?php if (!is_admin()){ ?>
			<div class="has-more"><a class="post-link" href="<?php the_permalink(); ?>" title="<?php echo esc_attr(__("more", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>"><?php _e("more", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></a></div>
			<?php } ?>
		</div>
	</div>
	<?php if (is_admin()){
		echo $wall_args['meta_wall_admin_item_code'];
	} ?>
</li>
