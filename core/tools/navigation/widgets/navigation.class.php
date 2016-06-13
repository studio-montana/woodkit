<?php 

// Creating the widget
class toolnavigation_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
				// Base ID of your widget
				'toolnavigation',

				// Widget name will appear in UI
				__("Navigation", WOODKIT_PLUGIN_TEXT_DOMAIN),

				// Widget description
				array( 'description' => __("Display contextual navigation", WOODKIT_PLUGIN_TEXT_DOMAIN),)
		);
	}

	// Widget Output
	public function widget($args, $instance) {

		// test if the current post/page has ancestors or children (else nothing to do)
		$current_post_type = get_post_type(get_the_ID());
		if (has_children(get_the_ID()) || has_ancestors(get_the_ID())){

			// orderby
			$orderby = "";
			if (isset($instance['orderby']))
				$orderby = $instance['orderby'];
			// orderby specific
			$field_name = $args['id'].$args['widget_id']."orderby";
			$specific_orderby = get_post_meta(get_the_ID(), $field_name, true);
			if (isset($specific_orderby) && !empty($specific_orderby) && $specific_orderby != 'default')
				$orderby = $specific_orderby;

			// order
			$order = "";
			if (isset($instance['order']))
				$order = $instance['order'];
			// order specific
			$field_name = $args['id'].$args['widget_id']."order";
			$specific_order = get_post_meta(get_the_ID(), $field_name, true);
			if (isset($specific_order) && !empty($specific_order) && $specific_order != 'default')
				$order = $specific_order;

			$id_oldest_ancestor = get_oldest_ancestor(get_the_ID());
			$current_item_ancestors = get_post_ancestors(get_the_ID());
			$current_item_ancestors[] = get_the_ID();

			$title = '<a href="'.get_permalink($id_oldest_ancestor).'" title="'.esc_attr(get_the_title($id_oldest_ancestor)).'">'.apply_filters('widget_title', get_the_title($id_oldest_ancestor)).'</a>';

			echo $args['before_widget'];
			if (!empty($title))
				echo $args['before_title'].$title.$args['after_title'];

			// display tree
			echo '<div class="navigation-tree">';
			toolnavigation_widget::get_navigation_tree($id_oldest_ancestor, $current_item_ancestors, $orderby, $order);
			echo '</div>';
			echo $args['after_widget'];

		}
	}

	// Widget Form
	public function form($instance) {
		// orderby
		$orderby = "";
		if (isset($instance['orderby']))
			$orderby = $instance['orderby'];

		// order
		$order = "";
		if (isset($instance['order']))
			$order = $instance['order'];
			
		include(WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.NAVIGATION_TOOL_NAME.'/widgets/templates/navigation-form.php');
	}

	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags($new_instance['orderby']) : '';
		$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags($new_instance['order']) : '';
		return $instance;
	}

	public static function get_navigation_tree($id_post, $activated = array(), $orderby = null, $order = null){
		$post_type = get_post_type($id_post);

		if (!isset($orderby) || empty($orderby) || $orderby == 'default')
			$orderby = array('menu_order' => 'ASC', 'date' => 'ASC');
		if (!isset($order) || empty($order) || $order == 'default')
			$order = 'DESC';

		$args = array(
				'post_type'=> $post_type,
				'post_parent' => $id_post,
				'orderby' => $orderby,
				'order'     => $order,
				'post_status' => 'publish',

		);
		$query = new WP_Query($args);

		if ($query->have_posts()) {
			echo "<ul>";
			while ($query->have_posts()) {
				$query->the_post();
				$is_active = false;
				if (in_array(get_the_ID(), $activated)){
					$is_active = true;
				}
				$li_class = "child";
				$li_class .= $is_active ? " active" : "";
				echo '<li class="'.$li_class.'">';
				echo '<a href="'.get_permalink().'" title="'.esc_attr(get_the_title()).'">'.get_the_title().'</a>';
				if ($is_active) // display sub tree for active items only
					toolnavigation_widget::get_navigation_tree(get_the_ID(), $activated, $orderby, $order);
				echo '</li>';
			}
			echo '</ul>';
		}
		wp_reset_postdata();
	}
}

// Register and load the widget
function toolnavigation_load_widget() {
	register_widget('toolnavigation_widget');
}
add_action('widgets_init', 'toolnavigation_load_widget');

/**
 * Widget manager form
*/
function tool_widgetmanager_post_widget_form_toolnavigation($post_id, $sidebar_id, $widget_obj){
	include(WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_TOOLS_FOLDER.NAVIGATION_TOOL_NAME.'/widgets/templates/navigation-form-widgetmanager.php');
}
add_action("tool_widgetmanager_post_widget_form_toolnavigation", 'tool_widgetmanager_post_widget_form_toolnavigation', 1, 3);

/**
 * Widget manager save form
*/
function tool_widgetmanager_post_widget_save_form_toolnavigation($post_id, $sidebar_id, $widget_obj){

	// orderby
	$field_name = $sidebar_id.$widget_obj->id."orderby";
	if (isset($_POST[$field_name])){
		update_post_meta($post_id, $field_name, $_POST[$field_name]);
	}else{
		delete_post_meta($post_id, $field_name);
	}

	// order
	$field_name = $sidebar_id.$widget_obj->id."order";
	if (isset($_POST[$field_name])){
		update_post_meta($post_id, $field_name, $_POST[$field_name]);
	}else{
		delete_post_meta($post_id, $field_name);
	}
}
add_action("tool_widgetmanager_post_widget_save_form_toolnavigation", 'tool_widgetmanager_post_widget_save_form_toolnavigation', 1, 3);
