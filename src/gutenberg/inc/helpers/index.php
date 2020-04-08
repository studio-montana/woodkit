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
	$icons_set[] = array(
		"title" => "Icomoon",
		"icons" => array(
			array("value" => "icomoon-home", "label" => "home"),
			array("value" => "icomoon-home2", "label" => "home2"),
			array("value" => "icomoon-home3", "label" => "home3"),
			array("value" => "icomoon-office", "label" => "office"),
			array("value" => "icomoon-newspaper", "label" => "newspaper"),
			array("value" => "icomoon-pencil", "label" => "pencil"),
			array("value" => "icomoon-pencil2", "label" => "pencil2"),
			array("value" => "icomoon-quill", "label" => "quill"),
			array("value" => "icomoon-pen", "label" => "pen"),
			array("value" => "icomoon-blog", "label" => "blog"),
			array("value" => "icomoon-eyedropper", "label" => "eyedropper"),
			array("value" => "icomoon-droplet", "label" => "droplet"),
			array("value" => "icomoon-paint-format", "label" => "paint-format"),
			array("value" => "icomoon-image", "label" => "image"),
			array("value" => "icomoon-images", "label" => "images"),
			array("value" => "icomoon-camera", "label" => "camera"),
			array("value" => "icomoon-headphones", "label" => "headphones"),
			array("value" => "icomoon-music", "label" => "music"),
			array("value" => "icomoon-play", "label" => "play"),
			array("value" => "icomoon-film", "label" => "film"),
			array("value" => "icomoon-video-camera", "label" => "video-camera"),
			array("value" => "icomoon-dice", "label" => "dice"),
			array("value" => "icomoon-pacman", "label" => "pacman"),
			array("value" => "icomoon-spades", "label" => "spades"),
			array("value" => "icomoon-clubs", "label" => "clubs"),
			array("value" => "icomoon-diamonds", "label" => "diamonds"),
			array("value" => "icomoon-bullhorn", "label" => "bullhorn"),
			array("value" => "icomoon-connection", "label" => "connection"),
			array("value" => "icomoon-podcast", "label" => "podcast"),
			array("value" => "icomoon-feed", "label" => "feed"),
			array("value" => "icomoon-mic", "label" => "mic"),
			array("value" => "icomoon-book", "label" => "book"),
			array("value" => "icomoon-books", "label" => "books"),
			array("value" => "icomoon-library", "label" => "library"),
			array("value" => "icomoon-file-text", "label" => "file-text"),
			array("value" => "icomoon-profile", "label" => "profile"),
			array("value" => "icomoon-file-empty", "label" => "file-empty"),
			array("value" => "icomoon-files-empty", "label" => "files-empty"),
			array("value" => "icomoon-file-text2", "label" => "file-text2"),
			array("value" => "icomoon-file-picture", "label" => "file-picture"),
			array("value" => "icomoon-file-music", "label" => "file-music"),
			array("value" => "icomoon-file-play", "label" => "file-play"),
			array("value" => "icomoon-file-video", "label" => "file-video"),
			array("value" => "icomoon-file-zip", "label" => "file-zip"),
			array("value" => "icomoon-copy", "label" => "copy"),
			array("value" => "icomoon-paste", "label" => "paste"),
			array("value" => "icomoon-stack", "label" => "stack"),
			array("value" => "icomoon-folder", "label" => "folder"),
			array("value" => "icomoon-folder-open", "label" => "folder-open"),
			array("value" => "icomoon-folder-plus", "label" => "folder-plus"),
			array("value" => "icomoon-folder-minus", "label" => "folder-minus"),
			array("value" => "icomoon-folder-download", "label" => "folder-download"),
			array("value" => "icomoon-folder-upload", "label" => "folder-upload"),
			array("value" => "icomoon-price-tag", "label" => "price-tag"),
			array("value" => "icomoon-price-tags", "label" => "price-tags"),
			array("value" => "icomoon-barcode", "label" => "barcode"),
			array("value" => "icomoon-qrcode", "label" => "qrcode"),
			array("value" => "icomoon-ticket", "label" => "ticket"),
			array("value" => "icomoon-cart", "label" => "cart"),
			array("value" => "icomoon-coin-dollar", "label" => "coin-dollar"),
			array("value" => "icomoon-coin-euro", "label" => "coin-euro"),
			array("value" => "icomoon-coin-pound", "label" => "coin-pound"),
			array("value" => "icomoon-coin-yen", "label" => "coin-yen"),
			array("value" => "icomoon-credit-card", "label" => "credit-card"),
			array("value" => "icomoon-calculator", "label" => "calculator"),
			array("value" => "icomoon-lifebuoy", "label" => "lifebuoy"),
			array("value" => "icomoon-phone", "label" => "phone"),
			array("value" => "icomoon-phone-hang-up", "label" => "phone-hang-up"),
			array("value" => "icomoon-address-book", "label" => "address-book"),
			array("value" => "icomoon-envelop", "label" => "envelop"),
			array("value" => "icomoon-pushpin", "label" => "pushpin"),
			array("value" => "icomoon-location", "label" => "location"),
			array("value" => "icomoon-location2", "label" => "location2"),
			array("value" => "icomoon-compass", "label" => "compass"),
			array("value" => "icomoon-compass2", "label" => "compass2"),
			array("value" => "icomoon-map", "label" => "map"),
			array("value" => "icomoon-map2", "label" => "map2"),
			array("value" => "icomoon-history", "label" => "history"),
			array("value" => "icomoon-clock", "label" => "clock"),
			array("value" => "icomoon-clock2", "label" => "clock2"),
			array("value" => "icomoon-alarm", "label" => "alarm"),
			array("value" => "icomoon-bell", "label" => "bell"),
			array("value" => "icomoon-stopwatch", "label" => "stopwatch"),
			array("value" => "icomoon-calendar", "label" => "calendar"),
			array("value" => "icomoon-printer", "label" => "printer"),
			array("value" => "icomoon-keyboard", "label" => "keyboard"),
			array("value" => "icomoon-display", "label" => "display"),
			array("value" => "icomoon-laptop", "label" => "laptop"),
			array("value" => "icomoon-mobile", "label" => "mobile"),
			array("value" => "icomoon-mobile2", "label" => "mobile2"),
			array("value" => "icomoon-tablet", "label" => "tablet"),
			array("value" => "icomoon-tv", "label" => "tv"),
			array("value" => "icomoon-drawer", "label" => "drawer"),
			array("value" => "icomoon-drawer2", "label" => "drawer2"),
			array("value" => "icomoon-box-add", "label" => "box-add"),
			array("value" => "icomoon-box-remove", "label" => "box-remove"),
			array("value" => "icomoon-download", "label" => "download"),
			array("value" => "icomoon-upload", "label" => "upload"),
			array("value" => "icomoon-floppy-disk", "label" => "floppy-disk"),
			array("value" => "icomoon-drive", "label" => "drive"),
			array("value" => "icomoon-database", "label" => "database"),
			array("value" => "icomoon-undo", "label" => "undo"),
			array("value" => "icomoon-redo", "label" => "redo"),
			array("value" => "icomoon-undo2", "label" => "undo2"),
			array("value" => "icomoon-redo2", "label" => "redo2"),
			array("value" => "icomoon-forward", "label" => "forward"),
			array("value" => "icomoon-reply", "label" => "reply"),
			array("value" => "icomoon-bubble", "label" => "bubble"),
			array("value" => "icomoon-bubbles", "label" => "bubbles"),
			array("value" => "icomoon-bubbles2", "label" => "bubbles2"),
			array("value" => "icomoon-bubble2", "label" => "bubble2"),
			array("value" => "icomoon-bubbles3", "label" => "bubbles3"),
			array("value" => "icomoon-bubbles4", "label" => "bubbles4"),
			array("value" => "icomoon-user", "label" => "user"),
			array("value" => "icomoon-users", "label" => "users"),
			array("value" => "icomoon-user-plus", "label" => "user-plus"),
			array("value" => "icomoon-user-minus", "label" => "user-minus"),
			array("value" => "icomoon-user-check", "label" => "user-check"),
			array("value" => "icomoon-user-tie", "label" => "user-tie"),
			array("value" => "icomoon-quotes-left", "label" => "quotes-left"),
			array("value" => "icomoon-quotes-right", "label" => "quotes-right"),
			array("value" => "icomoon-hour-glass", "label" => "hour-glass"),
			array("value" => "icomoon-spinner", "label" => "spinner"),
			array("value" => "icomoon-spinner2", "label" => "spinner2"),
			array("value" => "icomoon-spinner3", "label" => "spinner3"),
			array("value" => "icomoon-spinner4", "label" => "spinner4"),
			array("value" => "icomoon-spinner5", "label" => "spinner5"),
			array("value" => "icomoon-spinner6", "label" => "spinner6"),
			array("value" => "icomoon-spinner7", "label" => "spinner7"),
			array("value" => "icomoon-spinner8", "label" => "spinner8"),
			array("value" => "icomoon-spinner9", "label" => "spinner9"),
			array("value" => "icomoon-spinner10", "label" => "spinner10"),
			array("value" => "icomoon-spinner11", "label" => "spinner11"),
			array("value" => "icomoon-binoculars", "label" => "binoculars"),
			array("value" => "icomoon-search", "label" => "search"),
			array("value" => "icomoon-zoom-in", "label" => "zoom-in"),
			array("value" => "icomoon-zoom-out", "label" => "zoom-out"),
			array("value" => "icomoon-enlarge", "label" => "enlarge"),
			array("value" => "icomoon-shrink", "label" => "shrink"),
			array("value" => "icomoon-enlarge2", "label" => "enlarge2"),
			array("value" => "icomoon-shrink2", "label" => "shrink2"),
			array("value" => "icomoon-key", "label" => "key"),
			array("value" => "icomoon-key2", "label" => "key2"),
			array("value" => "icomoon-lock", "label" => "lock"),
			array("value" => "icomoon-unlocked", "label" => "unlocked"),
			array("value" => "icomoon-wrench", "label" => "wrench"),
			array("value" => "icomoon-equalizer", "label" => "equalizer"),
			array("value" => "icomoon-equalizer2", "label" => "equalizer2"),
			array("value" => "icomoon-cog", "label" => "cog"),
			array("value" => "icomoon-cogs", "label" => "cogs"),
			array("value" => "icomoon-hammer", "label" => "hammer"),
			array("value" => "icomoon-magic-wand", "label" => "magic-wand"),
			array("value" => "icomoon-aid-kit", "label" => "aid-kit"),
			array("value" => "icomoon-bug", "label" => "bug"),
			array("value" => "icomoon-pie-chart", "label" => "pie-chart"),
			array("value" => "icomoon-stats-dots", "label" => "stats-dots"),
			array("value" => "icomoon-stats-bars", "label" => "stats-bars"),
			array("value" => "icomoon-stats-bars2", "label" => "stats-bars2"),
			array("value" => "icomoon-trophy", "label" => "trophy"),
			array("value" => "icomoon-gift", "label" => "gift"),
			array("value" => "icomoon-glass", "label" => "glass"),
			array("value" => "icomoon-glass2", "label" => "glass2"),
			array("value" => "icomoon-mug", "label" => "mug"),
			array("value" => "icomoon-spoon-knife", "label" => "spoon-knife"),
			array("value" => "icomoon-leaf", "label" => "leaf"),
			array("value" => "icomoon-rocket", "label" => "rocket"),
			array("value" => "icomoon-meter", "label" => "meter"),
			array("value" => "icomoon-meter2", "label" => "meter2"),
			array("value" => "icomoon-hammer2", "label" => "hammer2"),
			array("value" => "icomoon-fire", "label" => "fire"),
			array("value" => "icomoon-lab", "label" => "lab"),
			array("value" => "icomoon-magnet", "label" => "magnet"),
			array("value" => "icomoon-bin", "label" => "bin"),
			array("value" => "icomoon-bin2", "label" => "bin2"),
			array("value" => "icomoon-briefcase", "label" => "briefcase"),
			array("value" => "icomoon-airplane", "label" => "airplane"),
			array("value" => "icomoon-truck", "label" => "truck"),
			array("value" => "icomoon-road", "label" => "road"),
			array("value" => "icomoon-accessibility", "label" => "accessibility"),
			array("value" => "icomoon-target", "label" => "target"),
			array("value" => "icomoon-shield", "label" => "shield"),
			array("value" => "icomoon-power", "label" => "power"),
			array("value" => "icomoon-switch", "label" => "switch"),
			array("value" => "icomoon-power-cord", "label" => "power-cord"),
			array("value" => "icomoon-clipboard", "label" => "clipboard"),
			array("value" => "icomoon-list-numbered", "label" => "list-numbered"),
			array("value" => "icomoon-list", "label" => "list"),
			array("value" => "icomoon-list2", "label" => "list2"),
			array("value" => "icomoon-tree", "label" => "tree"),
			array("value" => "icomoon-menu", "label" => "menu"),
			array("value" => "icomoon-menu2", "label" => "menu2"),
			array("value" => "icomoon-menu3", "label" => "menu3"),
			array("value" => "icomoon-menu4", "label" => "menu4"),
			array("value" => "icomoon-cloud", "label" => "cloud"),
			array("value" => "icomoon-cloud-download", "label" => "cloud-download"),
			array("value" => "icomoon-cloud-upload", "label" => "cloud-upload"),
			array("value" => "icomoon-cloud-check", "label" => "cloud-check"),
			array("value" => "icomoon-download2", "label" => "download2"),
			array("value" => "icomoon-upload2", "label" => "upload2"),
			array("value" => "icomoon-download3", "label" => "download3"),
			array("value" => "icomoon-upload3", "label" => "upload3"),
			array("value" => "icomoon-sphere", "label" => "sphere"),
			array("value" => "icomoon-earth", "label" => "earth"),
			array("value" => "icomoon-link", "label" => "link"),
			array("value" => "icomoon-flag", "label" => "flag"),
			array("value" => "icomoon-attachment", "label" => "attachment"),
			array("value" => "icomoon-eye", "label" => "eye"),
			array("value" => "icomoon-eye-plus", "label" => "eye-plus"),
			array("value" => "icomoon-eye-minus", "label" => "eye-minus"),
			array("value" => "icomoon-eye-blocked", "label" => "eye-blocked"),
			array("value" => "icomoon-bookmark", "label" => "bookmark"),
			array("value" => "icomoon-bookmarks", "label" => "bookmarks"),
			array("value" => "icomoon-sun", "label" => "sun"),
			array("value" => "icomoon-contrast", "label" => "contrast"),
			array("value" => "icomoon-brightness-contrast", "label" => "brightness-contrast"),
			array("value" => "icomoon-star-empty", "label" => "star-empty"),
			array("value" => "icomoon-star-half", "label" => "star-half"),
			array("value" => "icomoon-star-full", "label" => "star-full"),
			array("value" => "icomoon-heart", "label" => "heart"),
			array("value" => "icomoon-heart-broken", "label" => "heart-broken"),
			array("value" => "icomoon-man", "label" => "man"),
			array("value" => "icomoon-woman", "label" => "woman"),
			array("value" => "icomoon-man-woman", "label" => "man-woman"),
			array("value" => "icomoon-happy", "label" => "happy"),
			array("value" => "icomoon-happy2", "label" => "happy2"),
			array("value" => "icomoon-smile", "label" => "smile"),
			array("value" => "icomoon-smile2", "label" => "smile2"),
			array("value" => "icomoon-tongue", "label" => "tongue"),
			array("value" => "icomoon-tongue2", "label" => "tongue2"),
			array("value" => "icomoon-sad", "label" => "sad"),
			array("value" => "icomoon-sad2", "label" => "sad2"),
			array("value" => "icomoon-wink", "label" => "wink"),
			array("value" => "icomoon-wink2", "label" => "wink2"),
			array("value" => "icomoon-grin", "label" => "grin"),
			array("value" => "icomoon-grin2", "label" => "grin2"),
			array("value" => "icomoon-cool", "label" => "cool"),
			array("value" => "icomoon-cool2", "label" => "cool2"),
			array("value" => "icomoon-angry", "label" => "angry"),
			array("value" => "icomoon-angry2", "label" => "angry2"),
			array("value" => "icomoon-evil", "label" => "evil"),
			array("value" => "icomoon-evil2", "label" => "evil2"),
			array("value" => "icomoon-shocked", "label" => "shocked"),
			array("value" => "icomoon-shocked2", "label" => "shocked2"),
			array("value" => "icomoon-baffled", "label" => "baffled"),
			array("value" => "icomoon-baffled2", "label" => "baffled2"),
			array("value" => "icomoon-confused", "label" => "confused"),
			array("value" => "icomoon-confused2", "label" => "confused2"),
			array("value" => "icomoon-neutral", "label" => "neutral"),
			array("value" => "icomoon-neutral2", "label" => "neutral2"),
			array("value" => "icomoon-hipster", "label" => "hipster"),
			array("value" => "icomoon-hipster2", "label" => "hipster2"),
			array("value" => "icomoon-wondering", "label" => "wondering"),
			array("value" => "icomoon-wondering2", "label" => "wondering2"),
			array("value" => "icomoon-sleepy", "label" => "sleepy"),
			array("value" => "icomoon-sleepy2", "label" => "sleepy2"),
			array("value" => "icomoon-frustrated", "label" => "frustrated"),
			array("value" => "icomoon-frustrated2", "label" => "frustrated2"),
			array("value" => "icomoon-crying", "label" => "crying"),
			array("value" => "icomoon-crying2", "label" => "crying2"),
			array("value" => "icomoon-point-up", "label" => "point-up"),
			array("value" => "icomoon-point-right", "label" => "point-right"),
			array("value" => "icomoon-point-down", "label" => "point-down"),
			array("value" => "icomoon-point-left", "label" => "point-left"),
			array("value" => "icomoon-warning", "label" => "warning"),
			array("value" => "icomoon-notification", "label" => "notification"),
			array("value" => "icomoon-question", "label" => "question"),
			array("value" => "icomoon-plus", "label" => "plus"),
			array("value" => "icomoon-minus", "label" => "minus"),
			array("value" => "icomoon-info", "label" => "info"),
			array("value" => "icomoon-cancel-circle", "label" => "cancel-circle"),
			array("value" => "icomoon-blocked", "label" => "blocked"),
			array("value" => "icomoon-cross", "label" => "cross"),
			array("value" => "icomoon-checkmark", "label" => "checkmark"),
			array("value" => "icomoon-checkmark2", "label" => "checkmark2"),
			array("value" => "icomoon-spell-check", "label" => "spell-check"),
			array("value" => "icomoon-enter", "label" => "enter"),
			array("value" => "icomoon-exit", "label" => "exit"),
			array("value" => "icomoon-play2", "label" => "play2"),
			array("value" => "icomoon-pause", "label" => "pause"),
			array("value" => "icomoon-stop", "label" => "stop"),
			array("value" => "icomoon-previous", "label" => "previous"),
			array("value" => "icomoon-next", "label" => "next"),
			array("value" => "icomoon-backward", "label" => "backward"),
			array("value" => "icomoon-forward2", "label" => "forward2"),
			array("value" => "icomoon-play3", "label" => "play3"),
			array("value" => "icomoon-pause2", "label" => "pause2"),
			array("value" => "icomoon-stop2", "label" => "stop2"),
			array("value" => "icomoon-backward2", "label" => "backward2"),
			array("value" => "icomoon-forward3", "label" => "forward3"),
			array("value" => "icomoon-first", "label" => "first"),
			array("value" => "icomoon-last", "label" => "last"),
			array("value" => "icomoon-previous2", "label" => "previous2"),
			array("value" => "icomoon-next2", "label" => "next2"),
			array("value" => "icomoon-eject", "label" => "eject"),
			array("value" => "icomoon-volume-high", "label" => "volume-high"),
			array("value" => "icomoon-volume-medium", "label" => "volume-medium"),
			array("value" => "icomoon-volume-low", "label" => "volume-low"),
			array("value" => "icomoon-volume-mute", "label" => "volume-mute"),
			array("value" => "icomoon-volume-mute2", "label" => "volume-mute2"),
			array("value" => "icomoon-volume-increase", "label" => "volume-increase"),
			array("value" => "icomoon-volume-decrease", "label" => "volume-decrease"),
			array("value" => "icomoon-loop", "label" => "loop"),
			array("value" => "icomoon-loop2", "label" => "loop2"),
			array("value" => "icomoon-infinite", "label" => "infinite"),
			array("value" => "icomoon-shuffle", "label" => "shuffle"),
			array("value" => "icomoon-arrow-up-left", "label" => "arrow-up-left"),
			array("value" => "icomoon-arrow-up", "label" => "arrow-up"),
			array("value" => "icomoon-arrow-up-right", "label" => "arrow-up-right"),
			array("value" => "icomoon-arrow-right", "label" => "arrow-right"),
			array("value" => "icomoon-arrow-down-right", "label" => "arrow-down-right"),
			array("value" => "icomoon-arrow-down", "label" => "arrow-down"),
			array("value" => "icomoon-arrow-down-left", "label" => "arrow-down-left"),
			array("value" => "icomoon-arrow-left", "label" => "arrow-left"),
			array("value" => "icomoon-arrow-up-left2", "label" => "arrow-up-left2"),
			array("value" => "icomoon-arrow-up2", "label" => "arrow-up2"),
			array("value" => "icomoon-arrow-up-right2", "label" => "arrow-up-right2"),
			array("value" => "icomoon-arrow-right2", "label" => "arrow-right2"),
			array("value" => "icomoon-arrow-down-right2", "label" => "arrow-down-right2"),
			array("value" => "icomoon-arrow-down2", "label" => "arrow-down2"),
			array("value" => "icomoon-arrow-down-left2", "label" => "arrow-down-left2"),
			array("value" => "icomoon-arrow-left2", "label" => "arrow-left2"),
			array("value" => "icomoon-circle-up", "label" => "circle-up"),
			array("value" => "icomoon-circle-right", "label" => "circle-right"),
			array("value" => "icomoon-circle-down", "label" => "circle-down"),
			array("value" => "icomoon-circle-left", "label" => "circle-left"),
			array("value" => "icomoon-tab", "label" => "tab"),
			array("value" => "icomoon-move-up", "label" => "move-up"),
			array("value" => "icomoon-move-down", "label" => "move-down"),
			array("value" => "icomoon-sort-alpha-asc", "label" => "sort-alpha-asc"),
			array("value" => "icomoon-sort-alpha-desc", "label" => "sort-alpha-desc"),
			array("value" => "icomoon-sort-numeric-asc", "label" => "sort-numeric-asc"),
			array("value" => "icomoon-sort-numberic-desc", "label" => "sort-numberic-desc"),
			array("value" => "icomoon-sort-amount-asc", "label" => "sort-amount-asc"),
			array("value" => "icomoon-sort-amount-desc", "label" => "sort-amount-desc"),
			array("value" => "icomoon-command", "label" => "command"),
			array("value" => "icomoon-shift", "label" => "shift"),
			array("value" => "icomoon-ctrl", "label" => "ctrl"),
			array("value" => "icomoon-opt", "label" => "opt"),
			array("value" => "icomoon-checkbox-checked", "label" => "checkbox-checked"),
			array("value" => "icomoon-checkbox-unchecked", "label" => "checkbox-unchecked"),
			array("value" => "icomoon-radio-checked", "label" => "radio-checked"),
			array("value" => "icomoon-radio-checked2", "label" => "radio-checked2"),
			array("value" => "icomoon-radio-unchecked", "label" => "radio-unchecked"),
			array("value" => "icomoon-crop", "label" => "crop"),
			array("value" => "icomoon-make-group", "label" => "make-group"),
			array("value" => "icomoon-ungroup", "label" => "ungroup"),
			array("value" => "icomoon-scissors", "label" => "scissors"),
			array("value" => "icomoon-filter", "label" => "filter"),
			array("value" => "icomoon-font", "label" => "font"),
			array("value" => "icomoon-ligature", "label" => "ligature"),
			array("value" => "icomoon-ligature2", "label" => "ligature2"),
			array("value" => "icomoon-text-height", "label" => "text-height"),
			array("value" => "icomoon-text-width", "label" => "text-width"),
			array("value" => "icomoon-font-size", "label" => "font-size"),
			array("value" => "icomoon-bold", "label" => "bold"),
			array("value" => "icomoon-underline", "label" => "underline"),
			array("value" => "icomoon-italic", "label" => "italic"),
			array("value" => "icomoon-strikethrough", "label" => "strikethrough"),
			array("value" => "icomoon-omega", "label" => "omega"),
			array("value" => "icomoon-sigma", "label" => "sigma"),
			array("value" => "icomoon-page-break", "label" => "page-break"),
			array("value" => "icomoon-superscript", "label" => "superscript"),
			array("value" => "icomoon-subscript", "label" => "subscript"),
			array("value" => "icomoon-superscript2", "label" => "superscript2"),
			array("value" => "icomoon-subscript2", "label" => "subscript2"),
			array("value" => "icomoon-text-color", "label" => "text-color"),
			array("value" => "icomoon-pagebreak", "label" => "pagebreak"),
			array("value" => "icomoon-clear-formatting", "label" => "clear-formatting"),
			array("value" => "icomoon-table", "label" => "table"),
			array("value" => "icomoon-table2", "label" => "table2"),
			array("value" => "icomoon-insert-template", "label" => "insert-template"),
			array("value" => "icomoon-pilcrow", "label" => "pilcrow"),
			array("value" => "icomoon-ltr", "label" => "ltr"),
			array("value" => "icomoon-rtl", "label" => "rtl"),
			array("value" => "icomoon-section", "label" => "section"),
			array("value" => "icomoon-paragraph-left", "label" => "paragraph-left"),
			array("value" => "icomoon-paragraph-center", "label" => "paragraph-center"),
			array("value" => "icomoon-paragraph-right", "label" => "paragraph-right"),
			array("value" => "icomoon-paragraph-justify", "label" => "paragraph-justify"),
			array("value" => "icomoon-indent-increase", "label" => "indent-increase"),
			array("value" => "icomoon-indent-decrease", "label" => "indent-decrease"),
			array("value" => "icomoon-share", "label" => "share"),
			array("value" => "icomoon-new-tab", "label" => "new-tab"),
			array("value" => "icomoon-embed", "label" => "embed"),
			array("value" => "icomoon-embed2", "label" => "embed2"),
			array("value" => "icomoon-terminal", "label" => "terminal"),
			array("value" => "icomoon-share2", "label" => "share2"),
			array("value" => "icomoon-mail", "label" => "mail"),
			array("value" => "icomoon-mail2", "label" => "mail2"),
			array("value" => "icomoon-mail3", "label" => "mail3"),
			array("value" => "icomoon-mail4", "label" => "mail4"),
			array("value" => "icomoon-amazon", "label" => "amazon"),
			array("value" => "icomoon-google", "label" => "google"),
			array("value" => "icomoon-google2", "label" => "google2"),
			array("value" => "icomoon-google3", "label" => "google3"),
			array("value" => "icomoon-google-plus", "label" => "google-plus"),
			array("value" => "icomoon-google-plus2", "label" => "google-plus2"),
			array("value" => "icomoon-google-plus3", "label" => "google-plus3"),
			array("value" => "icomoon-hangouts", "label" => "hangouts"),
			array("value" => "icomoon-google-drive", "label" => "google-drive"),
			array("value" => "icomoon-facebook", "label" => "facebook"),
			array("value" => "icomoon-facebook2", "label" => "facebook2"),
			array("value" => "icomoon-instagram", "label" => "instagram"),
			array("value" => "icomoon-whatsapp", "label" => "whatsapp"),
			array("value" => "icomoon-spotify", "label" => "spotify"),
			array("value" => "icomoon-telegram", "label" => "telegram"),
			array("value" => "icomoon-twitter", "label" => "twitter"),
			array("value" => "icomoon-vine", "label" => "vine"),
			array("value" => "icomoon-vk", "label" => "vk"),
			array("value" => "icomoon-renren", "label" => "renren"),
			array("value" => "icomoon-sina-weibo", "label" => "sina-weibo"),
			array("value" => "icomoon-rss", "label" => "rss"),
			array("value" => "icomoon-rss2", "label" => "rss2"),
			array("value" => "icomoon-youtube", "label" => "youtube"),
			array("value" => "icomoon-youtube2", "label" => "youtube2"),
			array("value" => "icomoon-twitch", "label" => "twitch"),
			array("value" => "icomoon-vimeo", "label" => "vimeo"),
			array("value" => "icomoon-vimeo2", "label" => "vimeo2"),
			array("value" => "icomoon-lanyrd", "label" => "lanyrd"),
			array("value" => "icomoon-flickr", "label" => "flickr"),
			array("value" => "icomoon-flickr2", "label" => "flickr2"),
			array("value" => "icomoon-flickr3", "label" => "flickr3"),
			array("value" => "icomoon-flickr4", "label" => "flickr4"),
			array("value" => "icomoon-dribbble", "label" => "dribbble"),
			array("value" => "icomoon-behance", "label" => "behance"),
			array("value" => "icomoon-behance2", "label" => "behance2"),
			array("value" => "icomoon-deviantart", "label" => "deviantart"),
			array("value" => "icomoon-500px", "label" => "500px"),
			array("value" => "icomoon-steam", "label" => "steam"),
			array("value" => "icomoon-steam2", "label" => "steam2"),
			array("value" => "icomoon-dropbox", "label" => "dropbox"),
			array("value" => "icomoon-onedrive", "label" => "onedrive"),
			array("value" => "icomoon-github", "label" => "github"),
			array("value" => "icomoon-npm", "label" => "npm"),
			array("value" => "icomoon-basecamp", "label" => "basecamp"),
			array("value" => "icomoon-trello", "label" => "trello"),
			array("value" => "icomoon-wordpress", "label" => "wordpress"),
			array("value" => "icomoon-joomla", "label" => "joomla"),
			array("value" => "icomoon-ello", "label" => "ello"),
			array("value" => "icomoon-blogger", "label" => "blogger"),
			array("value" => "icomoon-blogger2", "label" => "blogger2"),
			array("value" => "icomoon-tumblr", "label" => "tumblr"),
			array("value" => "icomoon-tumblr2", "label" => "tumblr2"),
			array("value" => "icomoon-yahoo", "label" => "yahoo"),
			array("value" => "icomoon-yahoo2", "label" => "yahoo2"),
			array("value" => "icomoon-tux", "label" => "tux"),
			array("value" => "icomoon-appleinc", "label" => "appleinc"),
			array("value" => "icomoon-finder", "label" => "finder"),
			array("value" => "icomoon-android", "label" => "android"),
			array("value" => "icomoon-windows", "label" => "windows"),
			array("value" => "icomoon-windows8", "label" => "windows8"),
			array("value" => "icomoon-soundcloud", "label" => "soundcloud"),
			array("value" => "icomoon-soundcloud2", "label" => "soundcloud2"),
			array("value" => "icomoon-skype", "label" => "skype"),
			array("value" => "icomoon-reddit", "label" => "reddit"),
			array("value" => "icomoon-hackernews", "label" => "hackernews"),
			array("value" => "icomoon-wikipedia", "label" => "wikipedia"),
			array("value" => "icomoon-linkedin", "label" => "linkedin"),
			array("value" => "icomoon-linkedin2", "label" => "linkedin2"),
			array("value" => "icomoon-lastfm", "label" => "lastfm"),
			array("value" => "icomoon-lastfm2", "label" => "lastfm2"),
			array("value" => "icomoon-delicious", "label" => "delicious"),
			array("value" => "icomoon-stumbleupon", "label" => "stumbleupon"),
			array("value" => "icomoon-stumbleupon2", "label" => "stumbleupon2"),
			array("value" => "icomoon-stackoverflow", "label" => "stackoverflow"),
			array("value" => "icomoon-pinterest", "label" => "pinterest"),
			array("value" => "icomoon-pinterest2", "label" => "pinterest2"),
			array("value" => "icomoon-xing", "label" => "xing"),
			array("value" => "icomoon-xing2", "label" => "xing2"),
			array("value" => "icomoon-flattr", "label" => "flattr"),
			array("value" => "icomoon-foursquare", "label" => "foursquare"),
			array("value" => "icomoon-yelp", "label" => "yelp"),
			array("value" => "icomoon-paypal", "label" => "paypal"),
			array("value" => "icomoon-chrome", "label" => "chrome"),
			array("value" => "icomoon-firefox", "label" => "firefox"),
			array("value" => "icomoon-IE", "label" => "IE"),
			array("value" => "icomoon-edge", "label" => "edge"),
			array("value" => "icomoon-safari", "label" => "safari"),
			array("value" => "icomoon-opera", "label" => "opera"),
			array("value" => "icomoon-file-pdf", "label" => "file-pdf"),
			array("value" => "icomoon-file-openoffice", "label" => "file-openoffice"),
			array("value" => "icomoon-file-word", "label" => "file-word"),
			array("value" => "icomoon-file-excel", "label" => "file-excel"),
			array("value" => "icomoon-libreoffice", "label" => "libreoffice"),
			array("value" => "icomoon-html-five", "label" => "html-five"),
			array("value" => "icomoon-html-five2", "label" => "html-five2"),
			array("value" => "icomoon-css3", "label" => "css3"),
			array("value" => "icomoon-git", "label" => "git"),
			array("value" => "icomoon-codepen", "label" => "codepen"),
			array("value" => "icomoon-svg", "label" => "svg"),
			array("value" => "icomoon-IcoMoon", "label" => "IcoMoon"),
		),
	);
	return apply_filters('wkg_icons_set', $icons_set);
}
