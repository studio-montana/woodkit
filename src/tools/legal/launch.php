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

/**
 * REQUIREMENTS
*/
require_once (WOODKIT_PLUGIN_PATH.WOODKIT_PLUGIN_TOOLS_FOLDER.COOKIES_TOOL_NAME.'/inc/customizer.php');

/**
 * WP_Footer hook
 *
 * @since Woodkit 1.0
 * @return void
 */
function legal_wp_footer() {
	ob_start(); ?>
	<div id="tool-legal-box" class="tool-legal-box" style="display: none;">
		<div class="legal-box-content">
			<span>
				<?php 
				$has_privacy_policy = false;
				$link_target = '_blank';
				$link_url = woodkit_customizer_get_value('legal_link_url', '');
				if (empty($link_url)){
					$privacy_policy = get_option("wp_page_for_privacy_policy", 0);
					if (!empty($privacy_policy)){
						$has_privacy_policy = true;
						$link_target = "_self";
						$link_url = get_the_permalink($privacy_policy);
					}
				}
				$text_link = woodkit_customizer_get_value('legal_link_text', '');
				if (empty($text_link)){
					if ($has_privacy_policy){
						$text_link = __("Read our privacy policy.", 'woodkit');
					}else{
						$text_link = __("More details here.", 'woodkit');
					}
				}
				$text_content = woodkit_customizer_get_value('legal_text', '');
				if (empty($text_content)){
					if ($has_privacy_policy){
						$text_content = __("By continuing to visit our website, you are agreeing to our privacy policy, the use of cookies and similar technology.", 'woodkit');
					}else{
						$text_content = __("By continuing to visit our website, you are agreeing to the use of cookies and similar technology.", 'woodkit');
					}
				}
				if (empty(!$link_url)){
					$text_content .= '&nbsp;<a href="'.esc_url($link_url).'" target="'.$link_target.'">'.$text_link.'</a>';
				}
				echo apply_filters("woodkit_tool_legal_text", $text_content);
				?>
			</span>
			<button class="accept">
				<?php 
				$button_text = woodkit_customizer_get_value('legal_button_text', '');
				if (empty($button_text)){
					$button_text = 'OK';
				}
				echo apply_filters("woodkit_tool_legal_button", $button_text);
				?>
			</button>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			if (!checkCookie('legal-cookies-accepted', '1')) {
				$("#tool-legal-box").fadeIn();
				$("#tool-legal-box .accept").on("click", function(e){
					setCookie('legal-cookies-accepted', '1');
					$("#tool-legal-box").fadeOut();
				});
			}
		});
	</script>
	<?php $out = ob_get_clean();
	echo apply_filters("woodkit_tool_legal_out", $out);
}
add_action('wp_footer', 'legal_wp_footer', 50);