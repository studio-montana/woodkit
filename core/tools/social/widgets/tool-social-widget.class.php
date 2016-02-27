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

// Creating the widget
class tool_social_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
				// Base ID of your widget
				'tool-social',

				// Widget name will appear in UI
				__("Social", WOODKIT_PLUGIN_TEXT_DOMAIN),

				// Widget description
				array('description' => __("Show socials links", WOODKIT_PLUGIN_TEXT_DOMAIN),)
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		if (isset( $instance['social-title'] ))
			$title = $instance['social-title'];
		else
			$title = "";
			
		if ( isset( $instance['social-facebook-url'] ))
			$facebook_url = $instance['social-facebook-url'];
		else
			$facebook_url = "";

		if ( isset( $instance['social-twitter-url'] ))
			$twitter_url = $instance['social-twitter-url'];
		else
			$twitter_url = "";

		if ( isset( $instance['social-mail-url'] ))
			$mail_url = $instance['social-mail-url'];
		else
			$mail_url = "";

		if ( isset( $instance['social-download-url'] ))
			$download_url = $instance['social-download-url'];
		else
			$download_url = "";

		if ( isset( $instance['social-instagram-url'] ))
			$instagram_url = $instance['social-instagram-url'];
		else
			$instagram_url = "";

		if ( isset( $instance['social-pinterest-url'] ))
			$pinterest_url = $instance['social-pinterest-url'];
		else
			$pinterest_url = "";

		if ( isset( $instance['social-vimeo-url'] ))
			$vimeo_url = $instance['social-vimeo-url'];
		else
			$vimeo_url = "";

		if ( isset( $instance['social-youtube-url'] ))
			$youtube_url = $instance['social-youtube-url'];
		else
			$youtube_url = "";

		if ( isset( $instance['social-dribbble-url'] ))
			$dribbble_url = $instance['social-dribbble-url'];
		else
			$dribbble_url = "";

		if ( isset( $instance['social-googleplus-url'] ))
			$googleplus_url = $instance['social-googleplus-url'];
		else
			$googleplus_url = "";

		if ( isset( $instance['social-linkedin-url'] ))
			$linkedin_url = $instance['social-linkedin-url'];
		else
			$linkedin_url = "";

		if ( isset( $instance['social-behance-url'] ))
			$behance_url = $instance['social-behance-url'];
		else
			$behance_url = "";

		if ( isset( $instance['social-tumblr-url'] ))
			$tumblr_url = $instance['social-tumblr-url'];
		else
			$tumblr_url = "";

		if ( isset( $instance['social-flickr-url'] ))
			$flickr_url = $instance['social-flickr-url'];
		else
			$flickr_url = "";

		if ( isset( $instance['social-soundcloud-url'] ))
			$soundcloud_url = $instance['social-soundcloud-url'];
		else
			$soundcloud_url = "";

		if ( isset( $instance['social-backgrounded'] ) && $instance['social-backgrounded'] == 'on')
			$backgrounded = "on";
		else
			$backgrounded = "";

		echo $args['before_widget'];

		if (!empty($title)){
			echo $args['before_title'];
			echo $title;
			echo $args['after_title'];
		}

		$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.SOCIAL_TOOL_NAME.'/widgets/templates/tool-social-widget-output.php');
		if (!empty($template))
			include($template);

		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		if (isset( $instance['social-title'] ))
			$title = $instance['social-title'];
		else
			$title = "";
			
		if ( isset( $instance['social-facebook-url'] ))
			$facebook_url = $instance['social-facebook-url'];
		else
			$facebook_url = "";

		if ( isset( $instance['social-twitter-url'] ))
			$twitter_url = $instance['social-twitter-url'];
		else
			$twitter_url = "";

		if ( isset( $instance['social-mail-url'] ))
			$mail_url = $instance['social-mail-url'];
		else
			$mail_url = "";

		if ( isset( $instance['social-download-url'] ))
			$download_url = $instance['social-download-url'];
		else
			$download_url = "";

		if ( isset( $instance['social-instagram-url'] ))
			$instagram_url = $instance['social-instagram-url'];
		else
			$instagram_url = "";

		if ( isset( $instance['social-pinterest-url'] ))
			$pinterest_url = $instance['social-pinterest-url'];
		else
			$pinterest_url = "";

		if ( isset( $instance['social-vimeo-url'] ))
			$vimeo_url = $instance['social-vimeo-url'];
		else
			$vimeo_url = "";

		if ( isset( $instance['social-youtube-url'] ))
			$youtube_url = $instance['social-youtube-url'];
		else
			$youtube_url = "";

		if ( isset( $instance['social-dribbble-url'] ))
			$dribbble_url = $instance['social-dribbble-url'];
		else
			$dribbble_url = "";

		if ( isset( $instance['social-googleplus-url'] ))
			$googleplus_url = $instance['social-googleplus-url'];
		else
			$googleplus_url = "";

		if ( isset( $instance['social-linkedin-url'] ))
			$linkedin_url = $instance['social-linkedin-url'];
		else
			$linkedin_url = "";

		if ( isset( $instance['social-behance-url'] ))
			$behance_url = $instance['social-behance-url'];
		else
			$behance_url = "";

		if ( isset( $instance['social-tumblr-url'] ))
			$tumblr_url = $instance['social-tumblr-url'];
		else
			$tumblr_url = "";

		if ( isset( $instance['social-flickr-url'] ))
			$flickr_url = $instance['social-flickr-url'];
		else
			$flickr_url = "";

		if ( isset( $instance['social-soundcloud-url'] ))
			$soundcloud_url = $instance['social-soundcloud-url'];
		else
			$soundcloud_url = "";

		if ( isset( $instance['social-backgrounded'] ) && $instance['social-backgrounded'] == 'on')
			$backgrounded = "on";
		else
			$backgrounded = "";

		// Widget admin form
		$template = locate_ressource('/'.WOODKIT_PLUGIN_TOOLS_FOLDER.SOCIAL_TOOL_NAME.'/widgets/templates/tool-social-widget-form.php');
		if (!empty($template))
			include($template);
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['social-title'] = ( ! empty( $new_instance['social-title'] ) ) ? strip_tags( $new_instance['social-title'] ) : '';
		$instance['social-backgrounded'] = ( ! empty( $new_instance['social-backgrounded'] ) ) ? strip_tags( $new_instance['social-backgrounded'] ) : '';
		$instance['social-facebook-url'] = ( ! empty( $new_instance['social-facebook-url'] ) ) ? $new_instance['social-facebook-url'] : '';
		$instance['social-twitter-url'] = ( ! empty( $new_instance['social-twitter-url'] ) ) ? strip_tags( $new_instance['social-twitter-url'] ) : '';
		$instance['social-mail-url'] = ( ! empty( $new_instance['social-mail-url'] ) ) ? strip_tags( $new_instance['social-mail-url'] ) : '';
		$instance['social-download-url'] = ( ! empty( $new_instance['social-download-url'] ) ) ? strip_tags( $new_instance['social-download-url'] ) : '';
		$instance['social-instagram-url'] = ( ! empty( $new_instance['social-instagram-url'] ) ) ? strip_tags( $new_instance['social-instagram-url'] ) : '';
		$instance['social-pinterest-url'] = ( ! empty( $new_instance['social-pinterest-url'] ) ) ? strip_tags( $new_instance['social-pinterest-url'] ) : '';
		$instance['social-vimeo-url'] = ( ! empty( $new_instance['social-vimeo-url'] ) ) ? strip_tags( $new_instance['social-vimeo-url'] ) : '';
		$instance['social-youtube-url'] = ( ! empty( $new_instance['social-youtube-url'] ) ) ? strip_tags( $new_instance['social-youtube-url'] ) : '';
		$instance['social-dribbble-url'] = ( ! empty( $new_instance['social-dribbble-url'] ) ) ? strip_tags( $new_instance['social-dribbble-url'] ) : '';
		$instance['social-googleplus-url'] = ( ! empty( $new_instance['social-googleplus-url'] ) ) ? strip_tags( $new_instance['social-googleplus-url'] ) : '';
		$instance['social-linkedin-url'] = ( ! empty( $new_instance['social-linkedin-url'] ) ) ? strip_tags( $new_instance['social-linkedin-url'] ) : '';
		$instance['social-behance-url'] = ( ! empty( $new_instance['social-behance-url'] ) ) ? strip_tags( $new_instance['social-behance-url'] ) : '';
		$instance['social-tumblr-url'] = ( ! empty( $new_instance['social-tumblr-url'] ) ) ? strip_tags( $new_instance['social-tumblr-url'] ) : '';
		$instance['social-flickr-url'] = ( ! empty( $new_instance['social-flickr-url'] ) ) ? strip_tags( $new_instance['social-flickr-url'] ) : '';
		$instance['social-soundcloud-url'] = ( ! empty( $new_instance['social-soundcloud-url'] ) ) ? strip_tags( $new_instance['social-soundcloud-url'] ) : '';
		$instance['social-backgrounded'] = ( ! empty( $new_instance['social-backgrounded'] ) ) ? strip_tags( $new_instance['social-backgrounded'] ) : '';
		return $instance;
	}
}

// Register and load the widget
function tool_social_load_widget() {
	register_widget('tool_social_widget');
}
add_action( 'widgets_init', 'tool_social_load_widget');
