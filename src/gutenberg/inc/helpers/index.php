<?php
defined('ABSPATH') or die("Go Away!");

/**********************************************************************************************************
	General
**********************************************************************************************************/

/**
 * Merge user defined arguments into defaults array.
 *
 * This function is used throughout WordPress to allow for both string or array
 * to be merged into another array.
 *
 * @since 2.2.0
 * @since 2.3.0 `$args` can now also be an object.
 *
 * @param string|array|object $args     Value to merge with $defaults.
 * @param array               $defaults Optional. Array that serves as the defaults. Default empty.
 * @return array Merged user defined values with defaults.
 */
function wkg_parse_args($args, $defaults = '', $slice_additionnals = false) {
	$args = wp_parse_args($args, $defaults);
	if ($slice_additionnals) {
		$final_args = array();
		foreach ($args as $key => $value) {
			if (isset($defaults[$key])) {
				$final_args[$key] = $value;
			}
		}
		return $final_args;
	}
	return $args;
}

/**********************************************************************************************************
	Posts Options
**********************************************************************************************************/

function wkg_get_all_posts_options () {
	$options = array();
	if (function_exists('get_displayed_post_types')) {
		$available_post_types = get_displayed_post_types(true); // woodkit dependency
		if (!empty($available_post_types)) {
			foreach ($available_post_types as $postype) {
				$posts_options = wkg_get_posts_options($postype);
				if (!empty($posts_options)) {
					$post_type_label = get_post_type_labels(get_post_type_object($postype));
					$options[] = array('value' => $postype, 'label' => $post_type_label->name, 'disabled' => true);
					$options = array_merge($options, $posts_options);
				}
			}
		}
	}
	return $options;
}

/**
 * Retrieve posts options as array
 * @param  string $post_type [description]
 * @return array            [description]
 */
function wkg_get_posts_options ($post_type = 'post') {
	$options = array();
	$args = array(
		'post_type' => $post_type,
		'numberposts' => '-1'
	);
	if (is_post_type_hierarchical($post_type)) {
		$args['post_parent'] = 0;
	}
	$posts = get_posts($args);
	if (!empty($posts)) {
		foreach ($posts as $post) {
			wkg_add_post_option($options, $post);
		}
	}
	return $options;
}

/**
 * Add post option to specified array (including children if hierarchical)
 * @param array  $options [description]
 * @param object  $post    [description]
 * @param integer $level   [description]
 */
function wkg_add_post_option(&$options, $post, $level = 0){
	$level_string = '';
	for ($i = 0; $i < $level ; $i++){
		$level_string .= '-';
	}
	$options[] = array('value' => $post->ID, 'label' => $level_string . ' ' . $post->post_title);
	if (is_post_type_hierarchical(get_post_type($post))){
		$children = get_posts(array('post_type' => get_post_type($post), 'post_parent' => $post->ID, 'numberposts' => '-1'));
		if (!empty($children)){
			$level ++;
			foreach ($children as $child){
				wkg_add_post_option($options, $child, $level);
			}
		}
	}
}

/**********************************************************************************************************
	Terms Options
**********************************************************************************************************/

function wkg_get_all_terms_options () {
	$options = array();
	$taxonomies = get_taxonomies(array('public' => true), 'objects', 'and');
	if (!empty($taxonomies)) {
		foreach ($taxonomies as $tax) {
			$terms_options = wkg_get_terms_options(array('taxonomy' => $tax->name));
			if (!empty($terms_options)) {
				$options[] = array('value' => $tax->name, 'label' => $tax->label, 'disabled' => true);
				$options = array_merge($options, $terms_options);
			}
		}
	}
	return $options;
}

/**
 * Retrieve term options as array
 * @param  array  $args [description]
 * @return array       [description]
 */
function wkg_get_terms_options ($args = array()) {
	$options = array();
	if (isset($args['post_type'])) {
		$taxonomies = get_object_taxonomies($args['post_type'], 'objects');
		if (!empty($taxonomies)) {
			foreach ($taxonomies as $tax) {
				$options[] = array('value' => $tax->name, 'label' => $tax->label, 'disabled' => true);
				wkg_add_taxonomy_terms_options($options, $tax->name, 1);
			}
		}
	} else if (isset($args['taxonomy'])) {
		wkg_add_taxonomy_terms_options($options, $args['taxonomy']);
	}
	return $options;
}

/**
 * Add taxonomy terms options to specified array (including children if hierarchical)
 * @param array  $options [description]
 * @param object  $term    [description]
 * @param integer $level   [description]
 */
function wkg_add_taxonomy_terms_options(&$options, $taxonomy, $level = 0){
	$term_args = array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
	);
	if (is_taxonomy_hierarchical($taxonomy)){
		$term_args['parent'] = 0;
	}
	$terms = get_terms($term_args);
	if (!empty($terms)) {
		foreach ($terms as $term) {
			wkg_add_term_option($options, $term, $level);
		}
	}
}

/**
 * Add term option to specified array (including children if hierarchical)
 * @param array  $options [description]
 * @param object  $term    [description]
 * @param integer $level   [description]
 */
function wkg_add_term_option(&$options, $term, $level = 0){
	$level_string = '';
	for ($i = 0; $i < $level ; $i++){
		$level_string .= '-';
	}
	$options[] = array('value' => $term->term_id, 'label' => $level_string . ' ' . $term->name);
	if (is_taxonomy_hierarchical($term->taxonomy)){
		$children = get_terms(array('taxonomy' => $term->taxonomy, 'hide_empty' => false, 'parent' => $term->term_id));
		if (!empty($children)){
			$level ++;
			foreach ($children as $child){
				wkg_add_term_option($options, $child, $level);
			}
		}
	}
}

/**********************************************************************************************************
	Icons
**********************************************************************************************************/

function wkg_get_icons ($icons_set= array()) {
	$icons_set[] = array(
		"title" => "Dashicons",
		"icons" => array(
			array("value" => 'dashicons dashicons-menu', "label" => 'menu'),
			array("value" => 'dashicons dashicons-admin-site', "label" => 'admin-site'),
			array("value" => 'dashicons dashicons-dashboard', "label" => 'dashboard'),
			array("value" => 'dashicons dashicons-admin-media', "label" => 'admin-media'),
			array("value" => 'dashicons dashicons-admin-page', "label" => 'admin-page'),
			array("value" => 'dashicons dashicons-admin-comments', "label" => 'admin-comments'),
			array("value" => 'dashicons dashicons-admin-appearance', "label" => 'admin-appearance'),
			array("value" => 'dashicons dashicons-admin-plugins', "label" => 'admin-plugins'),
			array("value" => 'dashicons dashicons-admin-users', "label" => 'admin-users'),
			array("value" => 'dashicons dashicons-admin-tools', "label" => 'admin-tools'),
			array("value" => 'dashicons dashicons-admin-settings', "label" => 'admin-settings'),
			array("value" => 'dashicons dashicons-admin-network', "label" => 'admin-network'),
			array("value" => 'dashicons dashicons-admin-generic', "label" => 'admin-generic'),
			array("value" => 'dashicons dashicons-admin-home', "label" => 'admin-home'),
			array("value" => 'dashicons dashicons-admin-collapse', "label" => 'admin-collapse'),
			array("value" => 'dashicons dashicons-filter', "label" => 'filter'),
			array("value" => 'dashicons dashicons-admin-customizer', "label" => 'admin-customizer'),
			array("value" => 'dashicons dashicons-admin-multisite', "label" => 'admin-multisite'),
			array("value" => 'dashicons dashicons-admin-links', "label" => 'admin-links'),
			array("value" => 'dashicons dashicons-format-links', "label" => 'format-links'),
			array("value" => 'dashicons dashicons-admin-post', "label" => 'admin-post'),
			array("value" => 'dashicons dashicons-format-standard', "label" => 'format-standard'),
			array("value" => 'dashicons dashicons-format-image', "label" => 'format-image'),
			array("value" => 'dashicons dashicons-format-gallery', "label" => 'format-gallery'),
			array("value" => 'dashicons dashicons-format-audio', "label" => 'format-audio'),
			array("value" => 'dashicons dashicons-format-video', "label" => 'format-video'),
			array("value" => 'dashicons dashicons-format-chat', "label" => 'format-chat'),
			array("value" => 'dashicons dashicons-format-status', "label" => 'format-status'),
			array("value" => 'dashicons dashicons-format-aside', "label" => 'format-aside'),
			array("value" => 'dashicons dashicons-format-quote', "label" => 'format-quote'),
			array("value" => 'dashicons dashicons-welcome-write-blog', "label" => 'welcome-write-blog'),
			array("value" => 'dashicons dashicons-welcome-edit-page', "label" => 'welcome-edit-page'),
			array("value" => 'dashicons dashicons-welcome-add-page', "label" => 'welcome-add-page'),
			array("value" => 'dashicons dashicons-welcome-view-site', "label" => 'welcome-view-site'),
			array("value" => 'dashicons dashicons-welcome-widgets-menus', "label" => 'welcome-widgets-menus'),
			array("value" => 'dashicons dashicons-welcome-comments', "label" => 'welcome-comments'),
			array("value" => 'dashicons dashicons-welcome-learn-more', "label" => 'welcome-learn-more'),
			array("value" => 'dashicons dashicons-image-crop', "label" => 'image-crop'),
			array("value" => 'dashicons dashicons-image-rotate', "label" => 'image-rotate'),
			array("value" => 'dashicons dashicons-image-rotate-left', "label" => 'image-rotate-left'),
			array("value" => 'dashicons dashicons-image-rotate-right', "label" => 'image-rotate-right'),
			array("value" => 'dashicons dashicons-image-flip-vertical', "label" => 'image-flip-vertical'),
			array("value" => 'dashicons dashicons-image-flip-horizontal', "label" => 'image-flip-horizontal'),
			array("value" => 'dashicons dashicons-image-filter', "label" => 'image-filter'),
			array("value" => 'dashicons dashicons-undo', "label" => 'undo'),
			array("value" => 'dashicons dashicons-redo', "label" => 'redo'),
			array("value" => 'dashicons dashicons-editor-bold', "label" => 'editor-bold'),
			array("value" => 'dashicons dashicons-editor-italic', "label" => 'editor-italic'),
			array("value" => 'dashicons dashicons-editor-ul', "label" => 'editor-ul'),
			array("value" => 'dashicons dashicons-editor-ol', "label" => 'editor-ol'),
			array("value" => 'dashicons dashicons-editor-quote', "label" => 'editor-quote'),
			array("value" => 'dashicons dashicons-editor-alignleft', "label" => 'editor-alignleft'),
			array("value" => 'dashicons dashicons-editor-aligncenter', "label" => 'editor-aligncenter'),
			array("value" => 'dashicons dashicons-editor-alignright', "label" => 'editor-alignright'),
			array("value" => 'dashicons dashicons-editor-insertmore', "label" => 'editor-insertmore'),
			array("value" => 'dashicons dashicons-editor-spellcheck', "label" => 'editor-spellcheck'),
			array("value" => 'dashicons dashicons-editor-distractionfree', "label" => 'editor-distractionfree'),
			array("value" => 'dashicons dashicons-editor-expand', "label" => 'editor-expand'),
			array("value" => 'dashicons dashicons-editor-contract', "label" => 'editor-contract'),
			array("value" => 'dashicons dashicons-editor-kitchensink', "label" => 'editor-kitchensink'),
			array("value" => 'dashicons dashicons-editor-underline', "label" => 'editor-underline'),
			array("value" => 'dashicons dashicons-editor-justify', "label" => 'editor-justify'),
			array("value" => 'dashicons dashicons-editor-textcolor', "label" => 'editor-textcolor'),
			array("value" => 'dashicons dashicons-editor-paste-word', "label" => 'editor-paste-word'),
			array("value" => 'dashicons dashicons-editor-paste-text', "label" => 'editor-paste-text'),
			array("value" => 'dashicons dashicons-editor-removeformatting', "label" => 'editor-removeformatting'),
			array("value" => 'dashicons dashicons-editor-video', "label" => 'editor-video'),
			array("value" => 'dashicons dashicons-editor-woodkitchar', "label" => 'editor-woodkitchar'),
			array("value" => 'dashicons dashicons-editor-outdent', "label" => 'editor-outdent'),
			array("value" => 'dashicons dashicons-editor-indent', "label" => 'editor-indent'),
			array("value" => 'dashicons dashicons-editor-help', "label" => 'editor-help'),
			array("value" => 'dashicons dashicons-editor-strikethrough', "label" => 'editor-strikethrough'),
			array("value" => 'dashicons dashicons-editor-unlink', "label" => 'editor-unlink'),
			array("value" => 'dashicons dashicons-editor-rtl', "label" => 'editor-rtl'),
			array("value" => 'dashicons dashicons-editor-break', "label" => 'editor-break'),
			array("value" => 'dashicons dashicons-editor-code', "label" => 'editor-code'),
			array("value" => 'dashicons dashicons-editor-paragraph', "label" => 'editor-paragraph'),
			array("value" => 'dashicons dashicons-editor-table', "label" => 'editor-table'),
			array("value" => 'dashicons dashicons-align-left', "label" => 'align-left'),
			array("value" => 'dashicons dashicons-align-right', "label" => 'align-right'),
			array("value" => 'dashicons dashicons-align-center', "label" => 'align-center'),
			array("value" => 'dashicons dashicons-align-none', "label" => 'align-none'),
			array("value" => 'dashicons dashicons-lock', "label" => 'lock'),
			array("value" => 'dashicons dashicons-unlock', "label" => 'unlock'),
			array("value" => 'dashicons dashicons-calendar', "label" => 'calendar'),
			array("value" => 'dashicons dashicons-calendar-alt', "label" => 'calendar-alt'),
			array("value" => 'dashicons dashicons-visibility', "label" => 'visibility'),
			array("value" => 'dashicons dashicons-hidden', "label" => 'hidden'),
			array("value" => 'dashicons dashicons-post-status', "label" => 'post-status'),
			array("value" => 'dashicons dashicons-edit', "label" => 'edit'),
			array("value" => 'dashicons dashicons-post-trash', "label" => 'post-trash'),
			array("value" => 'dashicons dashicons-trash', "label" => 'trash'),
			array("value" => 'dashicons dashicons-sticky', "label" => 'sticky'),
			array("value" => 'dashicons dashicons-external', "label" => 'external'),
			array("value" => 'dashicons dashicons-arrow-up', "label" => 'arrow-up'),
			array("value" => 'dashicons dashicons-arrow-down', "label" => 'arrow-down'),
			array("value" => 'dashicons dashicons-arrow-left', "label" => 'arrow-left'),
			array("value" => 'dashicons dashicons-arrow-right', "label" => 'arrow-right'),
			array("value" => 'dashicons dashicons-arrow-up-alt', "label" => 'arrow-up-alt'),
			array("value" => 'dashicons dashicons-arrow-down-alt', "label" => 'arrow-down-alt'),
			array("value" => 'dashicons dashicons-arrow-left-alt', "label" => 'arrow-left-alt'),
			array("value" => 'dashicons dashicons-arrow-right-alt', "label" => 'arrow-right-alt'),
			array("value" => 'dashicons dashicons-arrow-up-alt2', "label" => 'arrow-up-alt2'),
			array("value" => 'dashicons dashicons-arrow-down-alt2', "label" => 'arrow-down-alt2'),
			array("value" => 'dashicons dashicons-arrow-left-alt2', "label" => 'arrow-left-alt2'),
			array("value" => 'dashicons dashicons-arrow-right-alt2', "label" => 'arrow-right-alt2'),
			array("value" => 'dashicons dashicons-leftright', "label" => 'leftright'),
			array("value" => 'dashicons dashicons-sort', "label" => 'sort'),
			array("value" => 'dashicons dashicons-randomize', "label" => 'randomize'),
			array("value" => 'dashicons dashicons-list-view', "label" => 'list-view'),
			array("value" => 'dashicons dashicons-exerpt-view', "label" => 'exerpt-view'),
			array("value" => 'dashicons dashicons-excerpt-view', "label" => 'excerpt-view'),
			array("value" => 'dashicons dashicons-grid-view', "label" => 'grid-view'),
			array("value" => 'dashicons dashicons-hammer', "label" => 'hammer'),
			array("value" => 'dashicons dashicons-art', "label" => 'art'),
			array("value" => 'dashicons dashicons-migrate', "label" => 'migrate'),
			array("value" => 'dashicons dashicons-performance', "label" => 'performance'),
			array("value" => 'dashicons dashicons-universal-access', "label" => 'universal-access'),
			array("value" => 'dashicons dashicons-universal-access-alt', "label" => 'universal-access-alt'),
			array("value" => 'dashicons dashicons-tickets', "label" => 'tickets'),
			array("value" => 'dashicons dashicons-nametag', "label" => 'nametag'),
			array("value" => 'dashicons dashicons-clipboard', "label" => 'clipboard'),
			array("value" => 'dashicons dashicons-heart', "label" => 'heart'),
			array("value" => 'dashicons dashicons-megaphone', "label" => 'megaphone'),
			array("value" => 'dashicons dashicons-schedule', "label" => 'schedule'),
			array("value" => 'dashicons dashicons-wordpress', "label" => 'wordpress'),
			array("value" => 'dashicons dashicons-wordpress-alt', "label" => 'wordpress-alt'),
			array("value" => 'dashicons dashicons-pressthis', "label" => 'pressthis'),
			array("value" => 'dashicons dashicons-update', "label" => 'update'),
			array("value" => 'dashicons dashicons-screenoptions', "label" => 'screenoptions'),
			array("value" => 'dashicons dashicons-cart', "label" => 'cart'),
			array("value" => 'dashicons dashicons-feedback', "label" => 'feedback'),
			array("value" => 'dashicons dashicons-cloud', "label" => 'cloud'),
			array("value" => 'dashicons dashicons-translation', "label" => 'translation'),
			array("value" => 'dashicons dashicons-tag', "label" => 'tag'),
			array("value" => 'dashicons dashicons-category', "label" => 'category'),
			array("value" => 'dashicons dashicons-archive', "label" => 'archive'),
			array("value" => 'dashicons dashicons-tagcloud', "label" => 'tagcloud'),
			array("value" => 'dashicons dashicons-text', "label" => 'text'),
			array("value" => 'dashicons dashicons-media-archive', "label" => 'media-archive'),
			array("value" => 'dashicons dashicons-media-audio', "label" => 'media-audio'),
			array("value" => 'dashicons dashicons-media-code', "label" => 'media-code'),
			array("value" => 'dashicons dashicons-media-default', "label" => 'media-default'),
			array("value" => 'dashicons dashicons-media-document', "label" => 'media-document'),
			array("value" => 'dashicons dashicons-media-interactive', "label" => 'media-interactive'),
			array("value" => 'dashicons dashicons-media-spreadsheet', "label" => 'media-spreadsheet'),
			array("value" => 'dashicons dashicons-media-text', "label" => 'media-text'),
			array("value" => 'dashicons dashicons-media-video', "label" => 'media-video'),
			array("value" => 'dashicons dashicons-playlist-audio', "label" => 'playlist-audio'),
			array("value" => 'dashicons dashicons-playlist-video', "label" => 'playlist-video'),
			array("value" => 'dashicons dashicons-controls-play', "label" => 'controls-play'),
			array("value" => 'dashicons dashicons-controls-pause', "label" => 'controls-pause'),
			array("value" => 'dashicons dashicons-controls-forward', "label" => 'controls-forward'),
			array("value" => 'dashicons dashicons-controls-skipforward', "label" => 'controls-skipforward'),
			array("value" => 'dashicons dashicons-controls-back', "label" => 'controls-back'),
			array("value" => 'dashicons dashicons-controls-skipback', "label" => 'controls-skipback'),
			array("value" => 'dashicons dashicons-controls-repeat', "label" => 'controls-repeat'),
			array("value" => 'dashicons dashicons-controls-volumeon', "label" => 'controls-volumeon'),
			array("value" => 'dashicons dashicons-controls-volumeoff', "label" => 'controls-volumeoff'),
			array("value" => 'dashicons dashicons-yes', "label" => 'yes'),
			array("value" => 'dashicons dashicons-no', "label" => 'no'),
			array("value" => 'dashicons dashicons-no-alt', "label" => 'no-alt'),
			array("value" => 'dashicons dashicons-plus', "label" => 'plus'),
			array("value" => 'dashicons dashicons-plus-alt', "label" => 'plus-alt'),
			array("value" => 'dashicons dashicons-plus-alt2', "label" => 'plus-alt2'),
			array("value" => 'dashicons dashicons-minus', "label" => 'minus'),
			array("value" => 'dashicons dashicons-dismiss', "label" => 'dismiss'),
			array("value" => 'dashicons dashicons-marker', "label" => 'marker'),
			array("value" => 'dashicons dashicons-star-filled', "label" => 'star-filled'),
			array("value" => 'dashicons dashicons-star-half', "label" => 'star-half'),
			array("value" => 'dashicons dashicons-star-empty', "label" => 'star-empty'),
			array("value" => 'dashicons dashicons-flag', "label" => 'flag'),
			array("value" => 'dashicons dashicons-info', "label" => 'info'),
			array("value" => 'dashicons dashicons-warning', "label" => 'warning'),
			array("value" => 'dashicons dashicons-share', "label" => 'share'),
			array("value" => 'dashicons dashicons-share1', "label" => 'share1'),
			array("value" => 'dashicons dashicons-share-alt', "label" => 'share-alt'),
			array("value" => 'dashicons dashicons-share-alt2', "label" => 'share-alt2'),
			array("value" => 'dashicons dashicons-twitter', "label" => 'twitter'),
			array("value" => 'dashicons dashicons-rss', "label" => 'rss'),
			array("value" => 'dashicons dashicons-email', "label" => 'email'),
			array("value" => 'dashicons dashicons-email-alt', "label" => 'email-alt'),
			array("value" => 'dashicons dashicons-facebook', "label" => 'facebook'),
			array("value" => 'dashicons dashicons-facebook-alt', "label" => 'facebook-alt'),
			array("value" => 'dashicons dashicons-networking', "label" => 'networking'),
			array("value" => 'dashicons dashicons-googleplus', "label" => 'googleplus'),
			array("value" => 'dashicons dashicons-location', "label" => 'location'),
			array("value" => 'dashicons dashicons-location-alt', "label" => 'location-alt'),
			array("value" => 'dashicons dashicons-camera', "label" => 'camera'),
			array("value" => 'dashicons dashicons-images-alt', "label" => 'images-alt'),
			array("value" => 'dashicons dashicons-images-alt2', "label" => 'images-alt2'),
			array("value" => 'dashicons dashicons-video-alt', "label" => 'video-alt'),
			array("value" => 'dashicons dashicons-video-alt2', "label" => 'video-alt2'),
			array("value" => 'dashicons dashicons-video-alt3', "label" => 'video-alt3'),
			array("value" => 'dashicons dashicons-vault', "label" => 'vault'),
			array("value" => 'dashicons dashicons-shield', "label" => 'shield'),
			array("value" => 'dashicons dashicons-shield-alt', "label" => 'shield-alt'),
			array("value" => 'dashicons dashicons-sos', "label" => 'sos'),
			array("value" => 'dashicons dashicons-search', "label" => 'search'),
			array("value" => 'dashicons dashicons-slides', "label" => 'slides'),
			array("value" => 'dashicons dashicons-analytics', "label" => 'analytics'),
			array("value" => 'dashicons dashicons-chart-pie', "label" => 'chart-pie'),
			array("value" => 'dashicons dashicons-chart-bar', "label" => 'chart-bar'),
			array("value" => 'dashicons dashicons-chart-line', "label" => 'chart-line'),
			array("value" => 'dashicons dashicons-chart-area', "label" => 'chart-area'),
			array("value" => 'dashicons dashicons-groups', "label" => 'groups'),
			array("value" => 'dashicons dashicons-businessman', "label" => 'businessman'),
			array("value" => 'dashicons dashicons-id', "label" => 'id'),
			array("value" => 'dashicons dashicons-id-alt', "label" => 'id-alt'),
			array("value" => 'dashicons dashicons-products', "label" => 'products'),
			array("value" => 'dashicons dashicons-awards', "label" => 'awards'),
			array("value" => 'dashicons dashicons-forms', "label" => 'forms'),
			array("value" => 'dashicons dashicons-testimonial', "label" => 'testimonial'),
			array("value" => 'dashicons dashicons-portfolio', "label" => 'portfolio'),
			array("value" => 'dashicons dashicons-book', "label" => 'book'),
			array("value" => 'dashicons dashicons-book-alt', "label" => 'book-alt'),
			array("value" => 'dashicons dashicons-download', "label" => 'download'),
			array("value" => 'dashicons dashicons-upload', "label" => 'upload'),
			array("value" => 'dashicons dashicons-backup', "label" => 'backup'),
			array("value" => 'dashicons dashicons-clock', "label" => 'clock'),
			array("value" => 'dashicons dashicons-lightbulb', "label" => 'lightbulb'),
			array("value" => 'dashicons dashicons-microphone', "label" => 'microphone'),
			array("value" => 'dashicons dashicons-desktop', "label" => 'desktop'),
			array("value" => 'dashicons dashicons-tablet', "label" => 'tablet'),
			array("value" => 'dashicons dashicons-smartphone', "label" => 'smartphone'),
			array("value" => 'dashicons dashicons-phone', "label" => 'phone'),
			array("value" => 'dashicons dashicons-smiley', "label" => 'smiley'),
			array("value" => 'dashicons dashicons-index-card', "label" => 'index-card'),
			array("value" => 'dashicons dashicons-carrot', "label" => 'carrot'),
			array("value" => 'dashicons dashicons-building', "label" => 'building'),
			array("value" => 'dashicons dashicons-store', "label" => 'store'),
			array("value" => 'dashicons dashicons-album', "label" => 'album'),
			array("value" => 'dashicons dashicons-palmtree', "label" => 'palmtree'),
			array("value" => 'dashicons dashicons-tickets-alt', "label" => 'tickets-alt'),
			array("value" => 'dashicons dashicons-money', "label" => 'money'),
			array("value" => 'dashicons dashicons-thumbs-up', "label" => 'thumbs-up'),
			array("value" => 'dashicons dashicons-thumbs-down', "label" => 'thumbs-down'),
			array("value" => 'dashicons dashicons-layout', "label" => 'layout'),
		),
	);
	return apply_filters('wkg_icons_set', $icons_set);
}
