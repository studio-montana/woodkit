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

<div id="cookies-legislation-box" class="cookies-legislation-container" style="display: none; z-index: 10000;">
	<div class="cookies-legislation-content">
		<span><?php _e("By continuing your visit to this site, you accept the use of cookies or other tracers", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>.&nbsp;<a href="http://www.cnil.fr/vos-obligations/sites-web-cookies-et-autres-traceurs/que-dit-la-loi/" target="_blank"><?php _e("More about", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></a></span>
		<button id="cookies-accept-condition"><?php _e('Ok', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></button>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		if ($.cookie('cookies-accept-condition') != 'true'){
			$("#cookies-legislation-box").fadeIn();
			$("#cookies-accept-condition").on("click", function(e){
				$.cookie('cookies-accept-condition', 'true', {path: '/'});
				$("#cookies-legislation-box").fadeOut();
			});
		}
	});
</script>