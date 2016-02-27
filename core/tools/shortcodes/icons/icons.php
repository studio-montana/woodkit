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
 * Register admin scripts on tinymce load
 */
function tool_shortcodes_icons_add_fontawesome($icons = array()) {
	if (! isset($icons['fontawesome']) || empty($icons['fontawesome'])){
		$icons['fontawesome'] = array("fa fa-glass", "fa fa-music", "fa fa-search", "fa fa-envelope-o", "fa fa-heart", "fa fa-star", "fa fa-star-o", "fa fa-user", "fa fa-film", "fa fa-th-large", "fa fa-th", "fa fa-th-list", "fa fa-check", "fa fa-times", "fa fa-search-plus", "fa fa-search-minus", "fa fa-power-off", "fa fa-signal", "fa fa-gear", "fa fa-trash-o", "fa fa-home", "fa fa-file-o", "fa fa-clock-o", "fa fa-road", "fa fa-download", "fa fa-arrow-circle-o-down", "fa fa-arrow-circle-o-up", "fa fa-inbox", "fa fa-play-circle-o", "fa fa-rotate-right", "fa fa-refresh", "fa fa-list-alt", "fa fa-lock", "fa fa-flag", "fa fa-headphones", "fa fa-volume-off", "fa fa-volume-down", "fa fa-volume-up", "fa fa-qrcode", "fa fa-barcode", "fa fa-tag", "fa fa-tags", "fa fa-book", "fa fa-bookmark", "fa fa-print", "fa fa-camera", "fa fa-font", "fa fa-bold", "fa fa-italic", "fa fa-text-height", "fa fa-text-width", "fa fa-align-left", "fa fa-align-center", "fa fa-align-right", "fa fa-align-justify", "fa fa-list", "fa fa-dedent", "fa fa-indent", "fa fa-video-camera", "fa fa-photo", "fa fa-pencil", "fa fa-map-marker", "fa fa-adjust", "fa fa-tint", "fa fa-edit", "fa fa-pencil-square-o", "fa fa-share-square-o", "fa fa-check-square-o", "fa fa-arrows", "fa fa-step-backward", "fa fa-fast-backward", "fa fa-backward", "fa fa-play", "fa fa-pause", "fa fa-stop", "fa fa-forward", "fa fa-fast-forward", "fa fa-step-forward", "fa fa-eject", "fa fa-chevron-left", "fa fa-chevron-right", "fa fa-plus-circle", "fa fa-minus-circle", "fa fa-times-circle", "fa fa-check-circle", "fa fa-question-circle", "fa fa-info-circle", "fa fa-crosshairs", "fa fa-times-circle-o", "fa fa-check-circle-o", "fa fa-ban", "fa fa-arrow-left", "fa fa-arrow-right", "fa fa-arrow-up", "fa fa-arrow-down", "fa fa-share", "fa fa-expand", "fa fa-compress", "fa fa-plus", "fa fa-minus", "fa fa-asterisk", "fa fa-exclamation-circle", "fa fa-gift", "fa fa-leaf", "fa fa-fire", "fa fa-eye", "fa fa-eye-slash", "fa fa-warning", "fa fa-plane", "fa fa-calendar", "fa fa-random", "fa fa-comment", "fa fa-magnet", "fa fa-chevron-up", "fa fa-chevron-down", "fa fa-retweet", "fa fa-shopping-cart", "fa fa-folder", "fa fa-folder-open", "fa fa-arrows-v", "fa fa-arrows-h", "fa fa-bar-chart", "fa fa-twitter-square", "fa fa-facebook-square", "fa fa-camera-retro", "fa fa-key", "fa fa-gears", "fa fa-cogs", "fa fa-comments", "fa fa-thumbs-o-up", "fa fa-thumbs-o-down", "fa fa-star-half", "fa fa-heart-o", "fa fa-sign-out", "fa fa-linkedin-square", "fa fa-thumb-tack", "fa fa-external-link", "fa fa-sign-in", "fa fa-trophy", "fa fa-github-square", "fa fa-upload", "fa fa-lemon-o", "fa fa-phone", "fa fa-square-o", "fa fa-bookmark-o", "fa fa-phone-square", "fa fa-twitter", "fa fa-facebook", "fa fa-github", "fa fa-unlock", "fa fa-credit-card", "fa fa-feed", "fa fa-hdd-o", "fa fa-bullhorn", "fa fa-bell", "fa fa-certificate", "fa fa-hand-o-right", "fa fa-hand-o-left", "fa fa-hand-o-up", "fa fa-hand-o-down", "fa fa-arrow-circle-left", "fa fa-arrow-circle-right", "fa fa-arrow-circle-up", "fa fa-arrow-circle-down", "fa fa-globe", "fa fa-wrench", "fa fa-tasks", "fa fa-filter", "fa fa-briefcase", "fa fa-arrows-alt", "fa fa-group", "fa fa-link", "fa fa-cloud", "fa fa-flask", "fa fa-cut", "fa fa-scissors", "fa fa-copy", "fa fa-paperclip", "fa fa-save", "fa fa-square", "fa fa-bars", "fa fa-list-ul", "fa fa-list-ol", "fa fa-strikethrough", "fa fa-underline", "fa fa-table", "fa fa-magic", "fa fa-truck", "fa fa-pinterest", "fa fa-pinterest-square", "fa fa-google-plus-square", "fa fa-google-plus", "fa fa-money", "fa fa-caret-down", "fa fa-caret-up", "fa fa-caret-left", "fa fa-caret-right", "fa fa-columns", "fa fa-unsorted", "fa fa-sort", "fa fa-sort-desc", "fa fa-sort-asc", "fa fa-envelope", "fa fa-linkedin", "fa fa-undo", "fa fa-legal", "fa fa-dashboard", "fa fa-comment-o", "fa fa-comments-o", "fa fa-flash", "fa fa-sitemap", "fa fa-umbrella", "fa fa-paste", "fa fa-lightbulb-o", "fa fa-exchange", "fa fa-cloud-download", "fa fa-cloud-upload", "fa fa-user-md", "fa fa-stethoscope", "fa fa-suitcase", "fa fa-bell-o", "fa fa-coffee", "fa fa-cutlery", "fa fa-file-text-o", "fa fa-building-o", "fa fa-hospital-o", "fa fa-ambulance", "fa fa-medkit", "fa fa-fighter-jet", "fa fa-beer", "fa fa-h-square", "fa fa-plus-square", "fa fa-angle-double-left", "fa fa-angle-double-right", "fa fa-angle-double-up", "fa fa-angle-double-down", "fa fa-angle-left", "fa fa-angle-right", "fa fa-angle-up", "fa fa-angle-down", "fa fa-desktop", "fa fa-laptop", "fa fa-tablet", "fa fa-mobile", "fa fa-circle-o", "fa fa-quote-left", "fa fa-quote-right", "fa fa-spinner", "fa fa-circle", "fa fa-reply", "fa fa-github-alt", "fa fa-folder-o", "fa fa-folder-open-o", "fa fa-smile-o", "fa fa-frown-o", "fa fa-meh-o", "fa fa-gamepad", "fa fa-keyboard-o", "fa fa-flag-o", "fa fa-flag-checkered", "fa fa-terminal", "fa fa-code", "fa fa-reply-all", "fa fa-star-half-o", "fa fa-location-arrow", "fa fa-crop", "fa fa-code-fork", "fa fa-unlink", "fa fa-question", "fa fa-info", "fa fa-exclamation", "fa fa-superscript", "fa fa-subscript", "fa fa-eraser", "fa fa-puzzle-piece", "fa fa-microphone", "fa fa-microphone-slash", "fa fa-shield", "fa fa-calendar-o", "fa fa-fire-extinguisher", "fa fa-rocket", "fa fa-maxcdn", "fa fa-chevron-circle-left", "fa fa-chevron-circle-right", "fa fa-chevron-circle-up", "fa fa-chevron-circle-down", "fa fa-html5", "fa fa-css3", "fa fa-anchor", "fa fa-unlock-alt", "fa fa-bullseye", "fa fa-ellipsis-h", "fa fa-ellipsis-v", "fa fa-rss-square", "fa fa-play-circle", "fa fa-ticket", "fa fa-minus-square", "fa fa-minus-square-o", "fa fa-level-up", "fa fa-level-down", "fa fa-check-square", "fa fa-pencil-square", "fa fa-external-link-square", "fa fa-share-square", "fa fa-compass", "fa fa-toggle-down", "fa fa-toggle-up", "fa fa-toggle-right", "fa fa-euro", "fa fa-eur", "fa fa-gbp", "fa fa-dollar", "fa fa-usd", "fa fa-rupee", "fa fa-inr", "fa fa-cny", "fa fa-rmb", "fa fa-yen", "fa fa-jpy", "fa fa-ruble", "fa fa-rouble", "fa fa-rub", "fa fa-won", "fa fa-krw", "fa fa-bitcoin", "fa fa-btc", "fa fa-file", "fa fa-file-text", "fa fa-sort-alpha-asc", "fa fa-sort-alpha-desc", "fa fa-sort-amount-asc", "fa fa-sort-amount-desc", "fa fa-sort-numeric-asc", "fa fa-sort-numeric-desc", "fa fa-thumbs-up", "fa fa-thumbs-down", "fa fa-youtube-square", "fa fa-youtube", "fa fa-xing", "fa fa-xing-square", "fa fa-youtube-play", "fa fa-dropbox", "fa fa-stack-overflow", "fa fa-instagram", "fa fa-flickr", "fa fa-adn", "fa fa-bitbucket", "fa fa-bitbucket-square", "fa fa-tumblr", "fa fa-tumblr-square", "fa fa-long-arrow-down", "fa fa-long-arrow-up", "fa fa-long-arrow-left", "fa fa-long-arrow-right", "fa fa-apple", "fa fa-windows", "fa fa-android", "fa fa-linux", "fa fa-dribbble", "fa fa-skype", "fa fa-foursquare", "fa fa-trello", "fa fa-female", "fa fa-male", "fa fa-gittip", "fa fa-gratipay", "fa fa-sun-o", "fa fa-moon-o", "fa fa-archive", "fa fa-bug", "fa fa-vk", "fa fa-weibo", "fa fa-renren", "fa fa-pagelines", "fa fa-stack-exchange", "fa fa-arrow-circle-o-right", "fa fa-arrow-circle-o-left", "fa fa-toggle-left", "fa fa-dot-circle-o", "fa fa-wheelchair", "fa fa-vimeo-square", "fa fa-try", "fa fa-plus-square-o", "fa fa-space-shuttle", "fa fa-slack", "fa fa-envelope-square", "fa fa-wordpress", "fa fa-openid", "fa fa-institution", "fa fa-graduation-cap", "fa fa-yahoo", "fa fa-google", "fa fa-reddit", "fa fa-reddit-square", "fa fa-stumbleupon-circle", "fa fa-stumbleupon", "fa fa-delicious", "fa fa-digg", "fa fa-pied-piper", "fa fa-pied-piper-alt", "fa fa-drupal", "fa fa-joomla", "fa fa-language", "fa fa-fax", "fa fa-building", "fa fa-child", "fa fa-paw", "fa fa-spoon", "fa fa-cube", "fa fa-cubes", "fa fa-behance", "fa fa-behance-square", "fa fa-steam", "fa fa-steam-square", "fa fa-recycle", "fa fa-automobile", "fa fa-car", "fa fa-taxi", "fa fa-tree", "fa fa-spotify", "fa fa-deviantart", "fa fa-soundcloud", "fa fa-database", "fa fa-file-pdf-o", "fa fa-file-word-o", "fa fa-file-excel-o", "fa fa-file-powerpoint-o", "fa fa-file-image-o", "fa fa-file-zip-o", "fa fa-file-archive-o", "fa fa-file-audio-o", "fa fa-file-video-o", "fa fa-file-code-o", "fa fa-vine", "fa fa-codepen", "fa fa-jsfiddle", "fa fa-life-bouy", "fa fa-circle-o-notch", "fa fa-rebel", "fa fa-empire", "fa fa-git-square", "fa fa-git", "fa fa-y-combinator-square", "fa fa-tencent-weibo", "fa fa-qq", "fa fa-wechat", "fa fa-send", "fa fa-send-o", "fa fa-history", "fa fa-circle-thin", "fa fa-header", "fa fa-paragraph", "fa fa-sliders", "fa fa-share-alt", "fa fa-share-alt-square", "fa fa-bomb", "fa fa-soccer-ball-o", "fa fa-tty", "fa fa-binoculars", "fa fa-plug", "fa fa-slideshare", "fa fa-twitch", "fa fa-yelp", "fa fa-newspaper-o", "fa fa-wifi", "fa fa-calculator", "fa fa-paypal", "fa fa-google-wallet", "fa fa-cc-visa", "fa fa-cc-mastercard", "fa fa-cc-discover", "fa fa-cc-amex", "fa fa-cc-paypal", "fa fa-cc-stripe", "fa fa-bell-slash", "fa fa-bell-slash-o", "fa fa-trash", "fa fa-copyright", "fa fa-at", "fa fa-eyedropper", "fa fa-paint-brush", "fa fa-birthday-cake", "fa fa-area-chart", "fa fa-pie-chart", "fa fa-line-chart", "fa fa-lastfm", "fa fa-lastfm-square", "fa fa-toggle-off", "fa fa-toggle-on", "fa fa-bicycle", "fa fa-bus", "fa fa-ioxhost", "fa fa-angellist", "fa fa-cc", "fa fa-shekel", "fa fa-meanpath", "fa fa-buysellads", "fa fa-connectdevelop", "fa fa-dashcube", "fa fa-forumbee", "fa fa-leanpub", "fa fa-sellsy", "fa fa-shirtsinbulk", "fa fa-simplybuilt", "fa fa-skyatlas", "fa fa-cart-plus", "fa fa-cart-arrow-down", "fa fa-diamond", "fa fa-ship", "fa fa-user-secret", "fa fa-motorcycle", "fa fa-street-view", "fa fa-heartbeat", "fa fa-venus", "fa fa-mars", "fa fa-mercury", "fa fa-transgender", "fa fa-transgender-alt", "fa fa-venus-double", "fa fa-mars-double", "fa fa-venus-mars", "fa fa-mars-stroke", "fa fa-mars-stroke-v", "fa fa-mars-stroke-h", "fa fa-neuter", "fa fa-genderless", "fa fa-facebook-official", "fa fa-pinterest-p", "fa fa-whatsapp", "fa fa-server", "fa fa-user-plus", "fa fa-user-times", "fa fa-hotel", "fa fa-viacoin", "fa fa-train", "fa fa-subway", "fa fa-medium", "fa fa-y-combinator", "fa fa-optin-monster", "fa fa-opencart", "fa fa-expeditedssl", "fa fa-battery-full", "fa fa-battery-three-quarters", "fa fa-battery-half", "fa fa-battery-quarter", "fa fa-battery-empty", "fa fa-mouse-pointer", "fa fa-i-cursor", "fa fa-object-group", "fa fa-object-ungroup", "fa fa-sticky-note", "fa fa-sticky-note-o", "fa fa-cc-jcb", "fa fa-cc-diners-club", "fa fa-clone", "fa fa-balance-scale", "fa fa-hourglass-o", "fa fa-hourglass-start", "fa fa-hourglass-half", "fa fa-hourglass-end", "fa fa-hourglass", "fa fa-hand-grab-o", "fa fa-hand-stop-o", "fa fa-hand-scissors-o", "fa fa-hand-lizard-o", "fa fa-hand-spock-o", "fa fa-hand-pointer-o", "fa fa-hand-peace-o", "fa fa-trademark", "fa fa-registered", "fa fa-creative-commons", "fa fa-gg", "fa fa-gg-circle", "fa fa-tripadvisor", "fa fa-odnoklassniki", "fa fa-odnoklassniki-square", "fa fa-get-pocket", "fa fa-wikipedia-w", "fa fa-safari", "fa fa-chrome", "fa fa-firefox", "fa fa-opera", "fa fa-internet-explorer", "fa fa-tv", "fa fa-contao", "fa fa-500px", "fa fa-amazon", "fa fa-calendar-plus-o", "fa fa-calendar-minus-o", "fa fa-calendar-times-o", "fa fa-calendar-check-o", "fa fa-industry", "fa fa-map-pin", "fa fa-map-signs", "fa fa-map-o", "fa fa-map", "fa fa-commenting", "fa fa-commenting-o", "fa fa-houzz", "fa fa-vimeo", "fa fa-black-tie", "fa fa-fonticons");
	}
	if (! isset($icons['dashicons']) || empty($icons['dashicons'])){
		$icons['dashicons'] = array("dashicons dashicons-menu", "dashicons dashicons-admin-site", "dashicons dashicons-dashboard", "dashicons dashicons-admin-media", "dashicons dashicons-admin-page", "dashicons dashicons-admin-comments", "dashicons dashicons-admin-appearance", "dashicons dashicons-admin-plugins", "dashicons dashicons-admin-users", "dashicons dashicons-admin-tools", "dashicons dashicons-admin-settings", "dashicons dashicons-admin-network", "dashicons dashicons-admin-generic", "dashicons dashicons-admin-home", "dashicons dashicons-admin-collapse", "dashicons dashicons-filter", "dashicons dashicons-admin-customizer", "dashicons dashicons-admin-multisite", "dashicons dashicons-admin-links", "dashicons dashicons-format-links", "dashicons dashicons-admin-post", "dashicons dashicons-format-standard", "dashicons dashicons-format-image", "dashicons dashicons-format-gallery", "dashicons dashicons-format-audio", "dashicons dashicons-format-video", "dashicons dashicons-format-chat", "dashicons dashicons-format-status", "dashicons dashicons-format-aside", "dashicons dashicons-format-quote", "dashicons dashicons-welcome-write-blog", "dashicons dashicons-welcome-edit-page", "dashicons dashicons-welcome-add-page", "dashicons dashicons-welcome-view-site", "dashicons dashicons-welcome-widgets-menus", "dashicons dashicons-welcome-comments", "dashicons dashicons-welcome-learn-more", "dashicons dashicons-image-crop", "dashicons dashicons-image-rotate", "dashicons dashicons-image-rotate-left", "dashicons dashicons-image-rotate-right", "dashicons dashicons-image-flip-vertical", "dashicons dashicons-image-flip-horizontal", "dashicons dashicons-image-filter", "dashicons dashicons-undo", "dashicons dashicons-redo", "dashicons dashicons-editor-bold", "dashicons dashicons-editor-italic", "dashicons dashicons-editor-ul", "dashicons dashicons-editor-ol", "dashicons dashicons-editor-quote", "dashicons dashicons-editor-alignleft", "dashicons dashicons-editor-aligncenter", "dashicons dashicons-editor-alignright", "dashicons dashicons-editor-insertmore", "dashicons dashicons-editor-spellcheck", "dashicons dashicons-editor-distractionfree", "dashicons dashicons-editor-expand", "dashicons dashicons-editor-contract", "dashicons dashicons-editor-kitchensink", "dashicons dashicons-editor-underline", "dashicons dashicons-editor-justify", "dashicons dashicons-editor-textcolor", "dashicons dashicons-editor-paste-word", "dashicons dashicons-editor-paste-text", "dashicons dashicons-editor-removeformatting", "dashicons dashicons-editor-video", "dashicons dashicons-editor-woodkitchar", "dashicons dashicons-editor-outdent", "dashicons dashicons-editor-indent", "dashicons dashicons-editor-help", "dashicons dashicons-editor-strikethrough", "dashicons dashicons-editor-unlink", "dashicons dashicons-editor-rtl", "dashicons dashicons-editor-break", "dashicons dashicons-editor-code", "dashicons dashicons-editor-paragraph", "dashicons dashicons-editor-table", "dashicons dashicons-align-left", "dashicons dashicons-align-right", "dashicons dashicons-align-center", "dashicons dashicons-align-none", "dashicons dashicons-lock", "dashicons dashicons-unlock", "dashicons dashicons-calendar", "dashicons dashicons-calendar-alt", "dashicons dashicons-visibility", "dashicons dashicons-hidden", "dashicons dashicons-post-status", "dashicons dashicons-edit", "dashicons dashicons-post-trash", "dashicons dashicons-trash", "dashicons dashicons-sticky", "dashicons dashicons-external", "dashicons dashicons-arrow-up", "dashicons dashicons-arrow-down", "dashicons dashicons-arrow-left", "dashicons dashicons-arrow-right", "dashicons dashicons-arrow-up-alt", "dashicons dashicons-arrow-down-alt", "dashicons dashicons-arrow-left-alt", "dashicons dashicons-arrow-right-alt", "dashicons dashicons-arrow-up-alt2", "dashicons dashicons-arrow-down-alt2", "dashicons dashicons-arrow-left-alt2", "dashicons dashicons-arrow-right-alt2", "dashicons dashicons-leftright", "dashicons dashicons-sort", "dashicons dashicons-randomize", "dashicons dashicons-list-view", "dashicons dashicons-exerpt-view", "dashicons dashicons-excerpt-view", "dashicons dashicons-grid-view", "dashicons dashicons-hammer", "dashicons dashicons-art", "dashicons dashicons-migrate", "dashicons dashicons-performance", "dashicons dashicons-universal-access", "dashicons dashicons-universal-access-alt", "dashicons dashicons-tickets", "dashicons dashicons-nametag", "dashicons dashicons-clipboard", "dashicons dashicons-heart", "dashicons dashicons-megaphone", "dashicons dashicons-schedule", "dashicons dashicons-wordpress", "dashicons dashicons-wordpress-alt", "dashicons dashicons-pressthis", "dashicons dashicons-update", "dashicons dashicons-screenoptions", "dashicons dashicons-cart", "dashicons dashicons-feedback", "dashicons dashicons-cloud", "dashicons dashicons-translation", "dashicons dashicons-tag", "dashicons dashicons-category", "dashicons dashicons-archive", "dashicons dashicons-tagcloud", "dashicons dashicons-text", "dashicons dashicons-media-archive", "dashicons dashicons-media-audio", "dashicons dashicons-media-code", "dashicons dashicons-media-default", "dashicons dashicons-media-document", "dashicons dashicons-media-interactive", "dashicons dashicons-media-spreadsheet", "dashicons dashicons-media-text", "dashicons dashicons-media-video", "dashicons dashicons-playlist-audio", "dashicons dashicons-playlist-video", "dashicons dashicons-controls-play", "dashicons dashicons-controls-pause", "dashicons dashicons-controls-forward", "dashicons dashicons-controls-skipforward", "dashicons dashicons-controls-back", "dashicons dashicons-controls-skipback", "dashicons dashicons-controls-repeat", "dashicons dashicons-controls-volumeon", "dashicons dashicons-controls-volumeoff", "dashicons dashicons-yes", "dashicons dashicons-no", "dashicons dashicons-no-alt", "dashicons dashicons-plus", "dashicons dashicons-plus-alt", "dashicons dashicons-plus-alt2", "dashicons dashicons-minus", "dashicons dashicons-dismiss", "dashicons dashicons-marker", "dashicons dashicons-star-filled", "dashicons dashicons-star-half", "dashicons dashicons-star-empty", "dashicons dashicons-flag", "dashicons dashicons-info", "dashicons dashicons-warning", "dashicons dashicons-share", "dashicons dashicons-share1", "dashicons dashicons-share-alt", "dashicons dashicons-share-alt2", "dashicons dashicons-twitter", "dashicons dashicons-rss", "dashicons dashicons-email", "dashicons dashicons-email-alt", "dashicons dashicons-facebook", "dashicons dashicons-facebook-alt", "dashicons dashicons-networking", "dashicons dashicons-googleplus", "dashicons dashicons-location", "dashicons dashicons-location-alt", "dashicons dashicons-camera", "dashicons dashicons-images-alt", "dashicons dashicons-images-alt2", "dashicons dashicons-video-alt", "dashicons dashicons-video-alt2", "dashicons dashicons-video-alt3", "dashicons dashicons-vault", "dashicons dashicons-shield", "dashicons dashicons-shield-alt", "dashicons dashicons-sos", "dashicons dashicons-search", "dashicons dashicons-slides", "dashicons dashicons-analytics", "dashicons dashicons-chart-pie", "dashicons dashicons-chart-bar", "dashicons dashicons-chart-line", "dashicons dashicons-chart-area", "dashicons dashicons-groups", "dashicons dashicons-businessman", "dashicons dashicons-id", "dashicons dashicons-id-alt", "dashicons dashicons-products", "dashicons dashicons-awards", "dashicons dashicons-forms", "dashicons dashicons-testimonial", "dashicons dashicons-portfolio", "dashicons dashicons-book", "dashicons dashicons-book-alt", "dashicons dashicons-download", "dashicons dashicons-upload", "dashicons dashicons-backup", "dashicons dashicons-clock", "dashicons dashicons-lightbulb", "dashicons dashicons-microphone", "dashicons dashicons-desktop", "dashicons dashicons-tablet", "dashicons dashicons-smartphone", "dashicons dashicons-phone", "dashicons dashicons-smiley", "dashicons dashicons-index-card", "dashicons dashicons-carrot", "dashicons dashicons-building", "dashicons dashicons-store", "dashicons dashicons-album", "dashicons dashicons-palmtree", "dashicons dashicons-tickets-alt", "dashicons dashicons-money", "dashicons dashicons-thumbs-up", "dashicons dashicons-thumbs-down", "dashicons dashicons-layout");
	}
	return $icons;
}
add_filter('tool_shortcodes_icons_add', 'tool_shortcodes_icons_add_fontawesome', 10);

/**
 * Register admin scripts on tinymce load
 */
function tool_shortcodes_icons_tiny_mce_plugins($plugins) {
	if (tool_shortcodes_icons_has_permissions() && tool_shortcodes_icons_is_edit_screen()) {
		wp_enqueue_script('tool-shortcodes-script-icons', WOODKIT_PLUGIN_URI.WOODKIT_PLUGIN_TOOLS_FOLDER.SHORTCODES_TOOL_NAME.'/icons/icons.js', array('jquery'), '1.0');
	}
	return $plugins;
}
add_filter('tiny_mce_plugins', 'tool_shortcodes_icons_tiny_mce_plugins');

/**
 * Make shortcode
*/
function tool_shortcodes_icons($atts, $content = null, $name='') {
	$atts = shortcode_atts( array(
			"class"	=> '',
			"style"	=> ''
	), $atts );
	$style = sanitize_text_field($atts['style']);
	$class = "shortcode-icons ".sanitize_text_field($atts['class']);
	$output = '<i class="'.$class.'" style="'.$style.'">'.do_shortcode($content).'</i>';
	return $output;
}
add_shortcode('icons', 'tool_shortcodes_icons');

/**
 * Is edit screen
*/
function tool_shortcodes_icons_is_edit_screen() {
	global $pagenow;
	$allowed_screens = apply_filters('cpsh_allowed_screens', array('post-new.php', 'page-new.php', 'post.php', 'page.php'));
	if (in_array($pagenow, $allowed_screens))
		return true;
	return false;
}

/**
 * has permissions
 */
function tool_shortcodes_icons_has_permissions() {
	if (current_user_can('edit_posts') && current_user_can('edit_pages'))
		return true;
	return false;
}

/**
 * Add buttons to TimyMCE
 */
function tool_shortcodes_icons_add_editor_buttons() {
	if (!tool_shortcodes_icons_has_permissions() || !tool_shortcodes_icons_is_edit_screen())
		return false;
	add_action('media_buttons', 'tool_shortcodes_icons_add_button', 100);
}
add_action('admin_init', 'tool_shortcodes_icons_add_editor_buttons');

/**
 * Add shortcode button to TimyMCE
*/
function tool_shortcodes_icons_add_button($id_editor = null) {
	?>
<span class="tool-shortcodes-insert-shortcode tool-shortcodes-icons-insert-shortcode button"
	title="<?php _e('Icons', WOODKIT_PLUGIN_TEXT_DOMAIN); ?>"
	data-id-editor="<?php echo $id_editor; ?>">
	<i class="fa fa-flag"></i>
</span>
<div id="tool-shortcodes-icons-box-<?php echo $id_editor; ?>" class="tool-shortcodes-icons-box">
	<h1><?php _e("Icons shortcodes", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></h1>
	<i class="tool-shortcodes-icons-box-close fa fa-times" data-id-editor="<?php echo $id_editor; ?>"></i>
	<?php 
	$icons = apply_filters("tool_shortcodes_icons_add", array());
	foreach ($icons as $familly => $icon){
		?>
		<div class="tool-shortcodes-icons-box-familly">
			<div class="tool-shortcodes-icons-box-familly-title"><i class="opened fa fa-caret-down" style="margin-right: 6px;"></i><i class="closed fa fa-caret-right" style="margin-right: 6px;"></i><?php echo $familly; ?></div>
			<div class="tool-shortcodes-icons-box-familly-content">
				<?php 
				foreach ($icons[$familly] as $icon){
					?>
					<span class="button tool-shortcodes-icons-insert-action" data-icon="<?php echo $icon; ?>" data-id-editor="<?php echo $id_editor; ?>"><i class="<?php echo $icon; ?>"></i></span>
					<?php
				} ?>
			</div>
			<hr />
		</div>
		<?php
	}
	?>
</div>
<?php
}
