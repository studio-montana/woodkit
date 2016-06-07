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
	<script type="text/javascript">
		google.maps.event.addDomListener(window, 'load', function(){
			var map = new google.maps.Map(document.getElementById('<?php echo $gmapsid; ?>'), {zoom:<?php echo $gmapszoom; ?>, mapTypeId: <?php echo $gmapstype; ?>});
			geocode_adress(map, new google.maps.Geocoder(), "<?php echo $gmapsaddress; ?>", "<?php echo $gmapstitle; ?>");
		});
	</script>

</div>