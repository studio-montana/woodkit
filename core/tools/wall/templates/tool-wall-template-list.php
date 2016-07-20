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

$title = wall_get_wall_item_title(get_the_ID(), $wall_args);
$link = wall_get_wall_item_link(get_the_ID(), $wall_args);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('wall-template-list'); ?>>
	<header class="entry-header">
	
		<?php 
		if (wall_is_available_attachment_item(get_the_ID())){
			?>
			<div class="entry-attachment">
				<a href="<?php $link; ?>" class="fancybox" rel="group-wall" title="<?php echo esc_attr($title); ?>">
					<?php echo wp_get_attachment_image(get_the_ID(), 'post-thumbnail'); ?>
				</a>
			</div>
			<?php
		}else if (!post_password_required()){
			if (function_exists('woodkit_display_thumbnail')){
				woodkit_display_thumbnail(get_the_ID(), 'post-thumbnail', '' , true, false, '<div class="entry-thumbnail"><a href="'.$link.'" title="'.esc_attr($title).'">', '</a></div>');
			}else if (has_post_thumbnail()){
				?>
				<div class="entry-thumbnail">
					<a href="<?php $link; ?>" title="<?php echo esc_attr($title); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
				</div>
			<?php }
		} ?>

		<h1 class="entry-title"><a href="<?php $link; ?>" title="<?php echo esc_attr($title); ?>"><?php $title; ?></a></h1>
		
		<?php
		if (function_exists('woodkit_display_subtitle')){
			woodkit_display_subtitle();
		} ?>

		<div class="entry-meta">
			<?php
			if (function_exists('woodlands_entry_meta')){
				woodlands_entry_meta();
			} ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post -->
