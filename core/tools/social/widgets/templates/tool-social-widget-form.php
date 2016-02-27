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

$class_social_item = "";
if (!empty($backgrounded) && $backgrounded == 'on'){
	$class_social_item .= "backgrounded";
}
?>
<table>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-title'); ?>"><?php _e('Title', WOODKIT_PLUGIN_TEXT_DOMAIN); ?> : </label></td>
		<td><input type="text" name="<?php echo $this->get_field_name('social-title'); ?>" id="<?php echo $this->get_field_id('social-title'); ?>" value="<?php echo esc_attr($title); ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-facebook-url'); ?>"><i class="fa fa-facebook"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-facebook-url'); ?>" id="<?php echo $this->get_field_id('social-facebook-url'); ?>" value="<?php echo $facebook_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-twitter-url'); ?>"><i class="fa fa-twitter"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-twitter-url'); ?>" id="<?php echo $this->get_field_id('social-twitter-url'); ?>" value="<?php echo $twitter_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-googleplus-url'); ?>"><i class="fa fa-google-plus"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-googleplus-url'); ?>" id="<?php echo $this->get_field_id('social-googleplus-url'); ?>" value="<?php echo $googleplus_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-linkedin-url'); ?>"><i class="fa fa-linkedin"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-linkedin-url'); ?>" id="<?php echo $this->get_field_id('social-linkedin-url'); ?>" value="<?php echo $linkedin_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-behance-url'); ?>"><i class="fa fa-behance"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-behance-url'); ?>" id="<?php echo $this->get_field_id('social-behance-url'); ?>" value="<?php echo $behance_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-pinterest-url'); ?>"><i class="fa fa-pinterest-p"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-pinterest-url'); ?>" id="<?php echo $this->get_field_id('social-pinterest-url'); ?>" value="<?php echo $pinterest_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-instagram-url'); ?>"><i class="fa fa-instagram"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-instagram-url'); ?>" id="<?php echo $this->get_field_id('social-instagram-url'); ?>" value="<?php echo $instagram_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-vimeo-url'); ?>"><i class="fa fa-vimeo"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-vimeo-url'); ?>" id="<?php echo $this->get_field_id('social-vimeo-url'); ?>" value="<?php echo $vimeo_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-youtube-url'); ?>"><i class="fa fa-youtube-play"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-youtube-url'); ?>" id="<?php echo $this->get_field_id('social-youtube-url'); ?>" value="<?php echo $youtube_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-dribbble-url'); ?>"><i class="fa fa-dribbble"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-dribbble-url'); ?>" id="<?php echo $this->get_field_id('social-dribbble-url'); ?>" value="<?php echo $dribbble_url; ?>" /></td>
	</tr>
		<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-tumblr-url'); ?>"><i class="fa fa-tumblr"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-tumblr-url'); ?>" id="<?php echo $this->get_field_id('social-tumblr-url'); ?>" value="<?php echo $tumblr_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-flickr-url'); ?>"><i class="fa fa-flickr"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-flickr-url'); ?>" id="<?php echo $this->get_field_id('social-flickr-url'); ?>" value="<?php echo $flickr_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-soundcloud-url'); ?>"><i class="fa fa-soundcloud"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-soundcloud-url'); ?>" id="<?php echo $this->get_field_id('social-soundcloud-url'); ?>" value="<?php echo $soundcloud_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-mail-url'); ?>"><i class="fa fa-envelope"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-mail-url'); ?>" id="<?php echo $this->get_field_id('social-mail-url'); ?>" value="<?php echo $mail_url; ?>" /></td>
	</tr>
	<tr>
		<td><label class="<?php echo $class_social_item; ?>" for="<?php echo $this->get_field_id('social-download-url'); ?>"><i class="fa fa-download"></i></label></td>
		<td><input size="35" placeholder="http://www.domain-name.com" type="text" name="<?php echo $this->get_field_name('social-download-url'); ?>" id="<?php echo $this->get_field_id('social-download-url'); ?>" value="<?php echo $download_url; ?>" /></td>
	</tr>
	<tr>
		<td><input class="backgrounded-check" type="checkbox" name="<?php echo $this->get_field_name('social-backgrounded'); ?>" id="<?php echo $this->get_field_id('social-backgrounded'); ?>"<?php if (!empty($backgrounded) && $backgrounded == 'on'){ echo ' checked="checked"'; } ?> /></td>
		<td><label for="<?php echo $this->get_field_id('social-backgrounded'); ?>"><?php _e("backgrounded", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></label></td>
	</tr>
</table>