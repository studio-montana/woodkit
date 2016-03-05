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

<article id="post-<?php the_ID(); ?>" <?php post_class('tool-event-widget-output-event'); ?>>
	<header class="entry-header">
		<?php if (!post_password_required()){ ?>
			<?php if (function_exists("woodkit_display_thumbnail")){
				woodkit_display_thumbnail(get_the_ID(), '', '', true, false); 
			}else if (has_post_thumbnail(get_the_ID())){
				?><div class="entry-thumbnail"><?php the_post_thumbnail(); ?></div><?php 
			}?>
		<?php } ?>

		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php if (function_exists("woodkit_display_title")) woodkit_display_title(get_the_ID(), true, false, '', ''); else the_title(); ?>
			</a>
			<?php edit_post_link('<i class="fa fa-pencil-square-o"></i>', '<span>', '</span>'); ?>
		</h1>
		
		<?php 
		$date_s = "";
		if (get_post_type() == 'event'){
			$meta_date_begin = get_post_meta(get_the_ID(), "meta_event_date_begin", true);
			$meta_date_begin_s = "";
			$meta_day_begin_s = "";
			$meta_month_begin_s = "";
			$meta_year_begin_s = "";
			if (!empty($meta_date_begin) && is_numeric($meta_date_begin)){
				$meta_day_begin_s = strftime("%d",$meta_date_begin);
				$meta_month_begin_s = get_textual_month($meta_date_begin);
				$meta_date_begin_s = $meta_day_begin_s." ".$meta_month_begin_s;
				$meta_year_begin_s = strftime("%Y",$meta_date_begin);
			}
				
			$meta_date_end = get_post_meta(get_the_ID(), "meta_event_date_end", true);
			$meta_date_end_s = "";
			$meta_day_end_s = "";
			$meta_month_end_s = "";
			$meta_year_end_s = "";
			if (!empty($meta_date_end) && is_numeric($meta_date_end)){
				$meta_day_end_s = strftime("%d",$meta_date_end);
				$meta_month_end_s = get_textual_month($meta_date_end);
				$meta_date_end_s = $meta_day_end_s." ".$meta_month_end_s;
				$meta_year_end_s = strftime("%Y",$meta_date_end);
			}
			
			$date_s = "";
			if ($meta_date_begin_s == $meta_date_end_s){
				$date_s = $meta_day_begin_s." ".$meta_month_begin_s." ".$meta_year_begin_s;
			}else{
				if ($meta_year_begin_s == $meta_year_end_s){
					$date_s = $meta_day_begin_s." ".$meta_month_begin_s." ".__("to", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_day_end_s." ".$meta_month_end_s." ".$meta_year_end_s;
				}else{
					$date_s = $meta_day_begin_s." ".$meta_month_begin_s." ".$meta_year_begin_s." ".__("to", WOODKIT_PLUGIN_TEXT_DOMAIN)." ".$meta_day_end_s." ".$meta_month_end_s." ".$meta_year_end_s;
				}
			}
		}
		if (!empty($date_s)){
			?>
			<div class="entry-date">
				<i class="fa fa-calendar"></i><?php echo $date_s; ?>
			</div>
			<?php 
		}
		?>
		
		<?php
		if (defined("META_DISPLAY_SUBTITLE"))	$subtitle = get_post_meta(get_the_ID(), META_DISPLAY_SUBTITLE, true);
		else $subtitle = '';
		if (!empty($subtitle)){ ?>
			<h2 class="entry-subtitle">
				<?php echo $subtitle; ?>
			</h2>
		<?php } ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	
	<footer class="entry-meta">
		<?php if (comments_open() && ! is_single()) : ?>
			<div class="comments-link">
				<?php woodkit_comments_popup_link('<span class="leave-reply">' . __('Comment', WOODKIT_PLUGIN_TEXT_DOMAIN) . '</span>', __('One comment', WOODKIT_PLUGIN_TEXT_DOMAIN), __('See % comments', WOODKIT_PLUGIN_TEXT_DOMAIN) ); ?>
			</div><!-- .comments-link -->
		<?php endif; // comments_open() ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
