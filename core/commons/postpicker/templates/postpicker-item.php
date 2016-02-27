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
<article>
	<?php 
	$has_video = false;
	$has_thumb = false;
	// featured video
	if (woodkit_is_registered_tool('video') && video_has_featured_video(get_the_ID())){
		$has_video = true;
		?>
		<div class="video"><?php echo video_get_featured_video(get_the_ID(), "100%", "100%"); ?></div>
		<?php
	}
	// featured thumbnail
	if (!$has_video){
		if (has_post_thumbnail()){
			$attach_id = get_post_thumbnail_id(get_the_ID());
			if ($attach_id){
				$image = wp_get_attachment_image_src($attach_id, 'full');
				if ($image){
					$style_wrapper = " min-width : 50px;";
					$style_wrapper .= " min-height : 50px;";
					$style = " width: 100%;";
					$style .= " height: 100%;";
					$style .= " background:	url('$image[0]') no-repeat center center;";
					$style .= " -webkit-background-size: cover;";
					$style .= " -moz-background-size: cover;";
					$style .= " -o-background-size: cover;";
					$style .= " -ms-background-size: cover;";
					$style .= " background-size: cover;";
					$style .= " overflow: hidden;";
					$has_thumb = true;
					?>
					<div class="thumb" style="<?php echo $style; ?>"></div>
					<?php
				}
			}
		}
	}
	// excerpt
	if (!$has_video && !$has_thumb){
		?>
		<div class="excerpt"><?php echo get_the_excerpt(); ?></div>
		<?php
	}
	?>
	<h1 class="title"><?php echo get_the_title(); ?></h1>
</article>