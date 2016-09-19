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
		<span>
			<?php 
			$text_content = woodkit_customizer_get_value('cookies_text', '');
			if (empty($text_content))
				$text_content = __("By continuing to visit our site, you are agreeing to the use of cookies and similar technology.", WOODKIT_PLUGIN_TEXT_DOMAIN);
			$text_link = woodkit_customizer_get_value('cookies_link_text', '');
			if (empty($text_link))
				$text_link = __("More details here.", WOODKIT_PLUGIN_TEXT_DOMAIN);
			$link_url = woodkit_customizer_get_value('cookies_link_url', '');
			if (empty($link_url))
				$link_url = "http://www.cnil.fr/vos-obligations/sites-web-cookies-et-autres-traceurs/que-dit-la-loi/";
			echo apply_filters("woodkit_tool_cookies_text_content", $text_content.'&nbsp;<a href="'.esc_url($link_url).'" target="_blank">'.$text_link.'</a>');
			?>
		</span>
		<button id="cookies-accept-condition">
			<?php 
			$button_text = woodkit_customizer_get_value('cookies_button_text', '');
			if (empty($button_text))
				$button_text = '<i class="fa fa-check"></i>';
			echo apply_filters("woodkit_tool_cookies_button_content", $button_text);
			?>
		</button>
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