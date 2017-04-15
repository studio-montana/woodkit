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
	$gmapstype = "google.maps.MapTypeId.".$gmapstype;
	?>
	<div style="overflow:hidden; width:<?php echo $gmapswidth; ?>; height:<?php echo $gmapsheight; ?>;">
		<div id='<?php echo $gmapsid; ?>' class="googlemaps-canvas" style="width:<?php echo $gmapswidth; ?>; height:<?php echo $gmapsheight; ?>;"></div>
	</div>
	<?php 
	$has_googlemaps_api = false;
	if (function_exists("et_pb_get_google_api_key")){ // Divi API settings
		$googlemap_api_key = et_pb_get_google_api_key();
		$has_googlemaps_api = !empty($googlemap_api_key);
	}else{
		$googlemap_api_key = woodkit_get_option('tool-googlemaps-apikey', '');
		$has_googlemaps_api = !empty($googlemap_api_key);
	}
	if ($has_googlemaps_api){
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			google.maps.event.addDomListener(window, 'load', function(){
				var map = new google.maps.Map(document.getElementById('<?php echo $gmapsid; ?>'), {zoom:<?php echo $gmapszoom; ?>, mapTypeId: <?php echo $gmapstype; ?>, zoomControl:<?php echo $gmapszoomcontrol; ?>, streetViewControl:<?php echo $gmapsstreetviewcontrol; ?>, scaleControl:<?php echo $gmapsscalecontrol; ?>, mapTypeControl:<?php echo $gmapsmaptypecontrol; ?>, rotateControl:<?php echo $gmapsrotatecontrol; ?>, scrollwheel:<?php echo $gmapsscrollwheel; ?>});
				geocode_adress(map, new google.maps.Geocoder(), "<?php echo $gmapsaddress; ?>", "<?php echo $gmapstitle; ?>");
			});
		});
		</script>
	<?php } ?>
</div>