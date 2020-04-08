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
	$today_timestamp = time();
	$today_timestamp_more_two_years = time() + ((((365*2)*60)*60)*24);
	$events = get_event_post_types(array(), array(
			'orderby'   => 'meta_value_num',
			'meta_key'  => 'meta_event_date_begin',
			'posts_per_page' => $nb,
			'order' => 'ASC',
			'meta_query' => array(
					array(
							'key' => 'meta_event_date_begin',
							'value' => array($today_timestamp, $today_timestamp_more_two_years),
							'compare' => 'BETWEEN'
					)
			)
	));
	if (!empty($events)){
		?>
		<ul class="list-events">
			<?php 
			global $post;
			foreach ($events as $post){
				setup_postdata($post);
				?>
				<li class="event">
					<?php 
					$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.EVENT_TOOL_NAME.'/widgets/templates/tool-event-widget-output-event.php');
					if (!empty($template))
						include($template);
					?>
				</li>
				<?php	
				wp_reset_postdata();
			}
			?>
		</ul>
		<div style="clear: both;"></div>
		<?php 
	}else{
		?>
		<div class="no-content"><?php _e("No upcoming event", 'woodkit'); ?></div>
		<?php
	}	
	?>

</div>