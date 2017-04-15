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
class tool_googlemaps_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
				// Base ID of your widget
				'toolgooglemaps',

				// Widget name will appear in UI
				__("Google Maps", WOODKIT_PLUGIN_TEXT_DOMAIN),

				// Widget description
				array( 'description' => __("Show Google Maps", WOODKIT_PLUGIN_TEXT_DOMAIN),)
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		
		$gmapsid = $this->get_field_id('gmaps');

		if (isset( $instance['title'] ))
			$title = $instance['title'];
		else
			$title = "";

		if (isset( $instance['gmapsaddress'] ))
			$gmapsaddress = $instance['gmapsaddress'];
		else
			$gmapsaddress = '';

		if (isset( $instance['gmapstitle'] ))
			$gmapstitle = $instance['gmapstitle'];
		else
			$gmapstitle = '';

		if (isset( $instance['gmapszoom'] ))
			$gmapszoom = $instance['gmapszoom'];
		else
			$gmapszoom = '12';

		if (isset( $instance['gmapstype'] ))
			$gmapstype = $instance['gmapstype'];
		else
			$gmapstype = 'ROADMAP';

		if (isset( $instance['gmapswidth'] ))
			$gmapswidth = $instance['gmapswidth'];
		else
			$gmapswidth = '100%';

		if (isset( $instance['gmapsheight'] ))
			$gmapsheight = $instance['gmapsheight'];
		else
			$gmapsheight = '200px';
		
		if (isset( $instance['gmapszoomcontrol'] ))
			$gmapszoomcontrol = $instance['gmapszoomcontrol'];
		else
			$gmapszoomcontrol = 'true';
		
		if (isset( $instance['gmapsstreetviewcontrol'] ))
			$gmapsstreetviewcontrol = $instance['gmapsstreetviewcontrol'];
		else
			$gmapsstreetviewcontrol = 'false';
		
		if (isset( $instance['gmapsscalecontrol'] ))
			$gmapsscalecontrol = $instance['gmapsscalecontrol'];
		else
			$gmapsscalecontrol = 'false';
		
		if (isset( $instance['gmapsmaptypecontrol'] ))
			$gmapsmaptypecontrol = $instance['gmapsmaptypecontrol'];
		else
			$gmapsmaptypecontrol = 'true';
		
		if (isset( $instance['gmapsrotatecontrol'] ))
			$gmapsrotatecontrol = $instance['gmapsrotatecontrol'];
		else
			$gmapsrotatecontrol = 'false';
		
		if (isset( $instance['gmapsscrollwheel'] ))
			$gmapsscrollwheel = $instance['gmapsscrollwheel'];
		else
			$gmapsscrollwheel = 'true';

		echo $args['before_widget'];

		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];

		$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.GOOGLEMAPS_TOOL_NAME.'/widgets/templates/tool-googlemaps-widget-output.php');
		if (!empty($template))
			include($template);

		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		
		if ( isset( $instance['title'] ))
			$title = $instance['title'];
		else
			$title = __("Google Maps", WOODKIT_PLUGIN_TEXT_DOMAIN);

		if (isset( $instance['gmapsaddress'] ))
			$gmapsaddress = $instance['gmapsaddress'];
		else
			$gmapsaddress = '';

		if (isset( $instance['gmapstitle'] ))
			$gmapstitle = $instance['gmapstitle'];
		else
			$gmapstitle = '';

		if (isset( $instance['gmapszoom'] ))
			$gmapszoom = $instance['gmapszoom'];
		else
			$gmapszoom = '12';

		if (isset( $instance['gmapstype'] ))
			$gmapstype = $instance['gmapstype'];
		else
			$gmapstype = 'ROADMAP';

		if (isset( $instance['gmapswidth'] ))
			$gmapswidth = $instance['gmapswidth'];
		else
			$gmapswidth = '100%';

		if (isset( $instance['gmapsheight'] ))
			$gmapsheight = $instance['gmapsheight'];
		else
			$gmapsheight = '200px';
		
		if (isset( $instance['gmapszoomcontrol'] ))
			$gmapszoomcontrol = $instance['gmapszoomcontrol'];
		else
			$gmapszoomcontrol = 'true';
		
		if (isset( $instance['gmapsstreetviewcontrol'] ))
			$gmapsstreetviewcontrol = $instance['gmapsstreetviewcontrol'];
		else
			$gmapsstreetviewcontrol = 'false';
		
		if (isset( $instance['gmapsscalecontrol'] ))
			$gmapsscalecontrol = $instance['gmapsscalecontrol'];
		else
			$gmapsscalecontrol = 'false';
		
		if (isset( $instance['gmapsmaptypecontrol'] ))
			$gmapsmaptypecontrol = $instance['gmapsmaptypecontrol'];
		else
			$gmapsmaptypecontrol = 'true';
		
		if (isset( $instance['gmapsrotatecontrol'] ))
			$gmapsrotatecontrol = $instance['gmapsrotatecontrol'];
		else
			$gmapsrotatecontrol = 'false';
		
		if (isset( $instance['gmapsscrollwheel'] ))
			$gmapsscrollwheel = $instance['gmapsscrollwheel'];
		else
			$gmapsscrollwheel = 'true';

		// Widget admin form
		$template = locate_ressource('/'.WOODKIT_PLUGIN_TOOLS_FOLDER.GOOGLEMAPS_TOOL_NAME.'/widgets/templates/tool-googlemaps-widget-form.php');
		if (!empty($template))
			include($template);
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['gmapsaddress'] = ( ! empty( $new_instance['gmapsaddress'] ) ) ? strip_tags( $new_instance['gmapsaddress'] ) : '';
		$instance['gmapstitle'] = ( ! empty( $new_instance['gmapstitle'] ) ) ? strip_tags( $new_instance['gmapstitle'] ) : '';
		$instance['gmapszoom'] = ( ! empty( $new_instance['gmapszoom'] ) ) ? strip_tags( $new_instance['gmapszoom'] ) : '';
		$instance['gmapstype'] = ( ! empty( $new_instance['gmapstype'] ) ) ? strip_tags( $new_instance['gmapstype'] ) : '';
		$instance['gmapswidth'] = ( ! empty( $new_instance['gmapswidth'] ) ) ? strip_tags( $new_instance['gmapswidth'] ) : '';
		$instance['gmapsheight'] = ( ! empty( $new_instance['gmapsheight'] ) ) ? strip_tags( $new_instance['gmapsheight'] ) : '';
		$instance['gmapszoomcontrol'] = ( ! empty( $new_instance['gmapszoomcontrol'] ) ) ? strip_tags( $new_instance['gmapszoomcontrol'] ) : '';
		$instance['gmapsstreetviewcontrol'] = ( ! empty( $new_instance['gmapsstreetviewcontrol'] ) ) ? strip_tags( $new_instance['gmapsstreetviewcontrol'] ) : '';
		$instance['gmapsscalecontrol'] = ( ! empty( $new_instance['gmapsscalecontrol'] ) ) ? strip_tags( $new_instance['gmapsscalecontrol'] ) : '';
		$instance['gmapsmaptypecontrol'] = ( ! empty( $new_instance['gmapsmaptypecontrol'] ) ) ? strip_tags( $new_instance['gmapsmaptypecontrol'] ) : '';
		$instance['gmapsrotatecontrol'] = ( ! empty( $new_instance['gmapsrotatecontrol'] ) ) ? strip_tags( $new_instance['gmapsrotatecontrol'] ) : '';
		$instance['gmapsscrollwheel'] = ( ! empty( $new_instance['gmapsscrollwheel'] ) ) ? strip_tags( $new_instance['gmapsscrollwheel'] ) : '';
		return $instance;
	}
}

// Register and load the widget
function tool_googlemaps_load_widget() {
	register_widget('tool_googlemaps_widget');
}
add_action( 'widgets_init', 'tool_googlemaps_load_widget');