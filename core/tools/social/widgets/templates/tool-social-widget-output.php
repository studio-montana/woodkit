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
<div class="widget-content">

	<?php 
	$social_item_class = "social-item";
	if (!empty($backgrounded) && $backgrounded == 'on'){
		$social_item_class .= " backgrounded";
	}
	?>

	<?php if (!empty($facebook_url)){ ?>
	<div class="<?php echo $social_item_class; ?> facebook-url">
		<a target="_blank" href="<?php echo $facebook_url; ?>" title="<?php echo esc_attr(__("facebook", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-facebook"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($twitter_url)){ ?>
	<div class="<?php echo $social_item_class; ?> twitter-url">
		<a target="_blank" href="<?php echo $twitter_url; ?>" title="<?php echo esc_attr(__("twitter", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-twitter"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($googleplus_url)){ ?>
	<div class="<?php echo $social_item_class; ?> googleplus-url">
		<a target="_blank" href="<?php echo $googleplus_url; ?>" title="<?php echo esc_attr(__("google+", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-google-plus"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($linkedin_url)){ ?>
	<div class="<?php echo $social_item_class; ?> linkedin-url">
		<a target="_blank" href="<?php echo $linkedin_url; ?>" title="<?php echo esc_attr(__("linkedin", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-linkedin"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($behance_url)){ ?>
	<div class="<?php echo $social_item_class; ?> behance-url">
		<a target="_blank" href="<?php echo $behance_url; ?>" title="<?php echo esc_attr(__("behance", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-behance"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($pinterest_url)){ ?>
	<div class="<?php echo $social_item_class; ?> pinterest-url">
		<a target="_blank" href="<?php echo $pinterest_url; ?>" title="<?php echo esc_attr(__("pinterest", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-pinterest-p"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($instagram_url)){ ?>
	<div class="<?php echo $social_item_class; ?> instagram-url">
		<a target="_blank" href="<?php echo $instagram_url; ?>" title="<?php echo esc_attr(__("instagram", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-instagram"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($vimeo_url)){ ?>
	<div class="<?php echo $social_item_class; ?> vimeo-url">
		<a target="_blank" href="<?php echo $vimeo_url; ?>" title="<?php echo esc_attr(__("vimeo", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-vimeo"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($youtube_url)){ ?>
	<div class="<?php echo $social_item_class; ?> youtube-url">
		<a target="_blank" href="<?php echo $youtube_url; ?>" title="<?php echo esc_attr(__("youtube", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-youtube-play"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($dribbble_url)){ ?>
	<div class="<?php echo $social_item_class; ?> dribbble-url">
		<a target="_blank" href="<?php echo $dribbble_url; ?>" title="<?php echo esc_attr(__("dribbble", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-dribbble"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($tumblr_url)){ ?>
	<div class="<?php echo $social_item_class; ?> tumblr-url">
		<a target="_blank" href="<?php echo $tumblr_url; ?>" title="<?php echo esc_attr(__("tumblr", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-tumblr"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($flickr_url)){ ?>
	<div class="<?php echo $social_item_class; ?> flickr-url">
		<a target="_blank" href="<?php echo $flickr_url; ?>" title="<?php echo esc_attr(__("flickr", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-flickr"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($soundcloud_url)){ ?>
	<div class="<?php echo $social_item_class; ?> soundcloud-url">
		<a target="_blank" href="<?php echo $soundcloud_url; ?>" title="<?php echo esc_attr(__("soundcloud", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-soundcloud"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($mail_url)){ ?>
	<div class="<?php echo $social_item_class; ?> mail-url">
		<a target="_blank" href="<?php echo $mail_url; ?>" title="<?php echo esc_attr(__("mail", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-envelope"></i>
		</a>
	</div>
	<?php } ?>
	<?php if (!empty($download_url)){ ?>
	<div class="<?php echo $social_item_class; ?> download-url">
		<a target="_blank" href="<?php echo $download_url; ?>" title="<?php echo esc_attr(__("download", WOODKIT_PLUGIN_TEXT_DOMAIN)); ?>">
			<i class="fa fa-download"></i>
		</a>
	</div>
	<?php } ?>
</div>