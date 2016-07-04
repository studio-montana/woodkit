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

if (!is_admin()){
	$wall_args = array();
	$wall_args['meta_wall_display_current_post_id'] = get_the_ID();
	$wall_args['meta_wall_display_post_type'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_POST_TYPE, true);
	$wall_args['meta_wall_display_ids'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_IDS, true);
	$wall_args['meta_wall_display_tax'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_TAX, true);
	$wall_args['meta_wall_display_term_slug'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_TERM_SLUG, true);
	$wall_args['meta_wall_display_orderby'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_ORDERBY, true);
	$wall_args['meta_wall_display_order'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_ORDER, true);
	$wall_args['meta_wall_display_number'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_NUMBER, true);
	$wall_args['meta_wall_display_parent'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PARENT, true);
	$wall_args['meta_wall_display_presentation'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION, true);
	$wall_args['meta_wall_display_presentation_columns'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_COLUMNS, true);
	$wall_args['meta_wall_display_presentation_filtering'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_FILTERING, true);
	$wall_args['meta_wall_display_presentation_slider_autoplay'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_SLIDER_AUTOPLAY, true);
	$wall_args['meta_wall_display_presentation_slider_thumb_nav'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_SLIDER_THUMB_NAV, true);
	$wall_args['meta_wall_display_presentation_slider_carousel'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL, true);
	$wall_args['meta_wall_display_presentation_slider_carousel_columns'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_COLUMNS, true);
	$wall_args['meta_wall_display_presentation_slider_carousel_item_width'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_WIDTH, true);
	$wall_args['meta_wall_display_presentation_slider_carousel_item_margin'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_SLIDER_CAROUSEL_ITEM_MARGIN, true);
	$wall_args['meta_wall_display_presentation_initial_height'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_INITIAL_HEIGHT, true);
	$wall_args['meta_wall_display_presentation_format'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_FORMAT, true);
	$wall_args['meta_wall_display_presentation_masonry_width'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH, true);
	$wall_args['meta_wall_display_presentation_masonry_width_customized'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_MASONRY_WIDTH_WOODKITIZED, true);
	$wall_args['meta_wall_display_presentation_masonry_height'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_MASONRY_HEIGHT, true);
	$wall_args['meta_wall_display_presentation_margin_vertical'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_MARGIN_VERTICAL, true);
	$wall_args['meta_wall_display_presentation_margin_horizontal'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_MARGIN_HORIZONTAL, true);
	$wall_args['meta_wall_display_presentation_setup'] = get_post_meta(get_the_ID(), META_WALL_DISPLAY_PRESENTATION_SETUP, true);
}else{
	// $wall_args must be defined by the calling script (same array keys)
}
$wall_args['available_isotope_widths'] = wall_get_available_isotope_widths($wall_args['meta_wall_display_presentation_columns']);
$wall_args['available_isotope_heights'] = wall_get_available_isotope_heights($wall_args['meta_wall_display_presentation_columns']);
$wall_args['available_templates'] = wall_get_available_templates();
$wall_args = wall_securize_meta_values($wall_args);

$posts = array();

if (post_type_exists($wall_args['meta_wall_display_post_type'])){ // dynamic list
	$args = array("post_type" => $wall_args['meta_wall_display_post_type'], "orderby" => $wall_args['meta_wall_display_orderby'], "order" => $wall_args['meta_wall_display_order']);
	if (!empty($wall_args['meta_wall_display_tax']) && !empty($wall_args['meta_wall_display_term_slug']) && $wall_args['meta_wall_display_term_slug'] != '0'){
		$selected_terms = $wall_args['meta_wall_display_term_slug']; // structure like tax-slug|term-slug
		$selected_terms_array = explode("|", $wall_args['meta_wall_display_term_slug']);
		if (!empty($selected_terms_array) && count($selected_terms_array) > 1){
			$selected_terms = $selected_terms_array[1];
		}
		$args['tax_query'] = array(
				array(
						'taxonomy' => $wall_args['meta_wall_display_tax'],
						'field'    => 'slug',
						'terms'    => $selected_terms,
				),
		);
	}
	if (!empty($wall_args['meta_wall_display_number']) && is_numeric($wall_args['meta_wall_display_number']))
		$args['numberposts'] = $wall_args['meta_wall_display_number'];
	else
		$args['numberposts'] = -1;
	if (is_numeric($wall_args['meta_wall_display_parent']) && $wall_args['meta_wall_display_parent'] != -1)
		$args['post_parent'] = $wall_args['meta_wall_display_parent'];
	// exclude current post-type
	$args['exclude'] = array($wall_args['meta_wall_display_current_post_id']);
	$args['suppress_filters'] = FALSE; // WPML support
	$posts = get_posts($args);
}else if($wall_args['meta_wall_display_post_type'] == "-1"){ // static list
	$ids = $wall_args['meta_wall_display_ids'];
	if (!empty($ids)){
		$ids_tab = explode(",", $ids);
		if(($key = array_search($wall_args['meta_wall_display_current_post_id'], $ids_tab)) !== false) {
			unset($ids_tab[$key]);
		}
		if (!empty($ids_tab)){
			$args = array("posts_per_page" => -1, "post_type" => "any", "post__in" => $ids_tab, "orderby" => "post__in", "suppress_filters" => FALSE);
			$get_any_posts = new WP_Query;
			$posts = $get_any_posts->query($args);
		}
	}
}

if (!empty($posts)){
	if ($wall_args['meta_wall_display_presentation'] == 'list'){
		?>
		<div <?php if (is_admin()){ echo 'id="admin-list-wall"'; }else{ echo 'id="list-wall"'; } ?> class="wall tool-wall list <?php echo $wall_args['meta_wall_display_presentation']; ?>">
			<?php
			global $post;
			foreach ($posts as $post){
				setup_postdata($post);
				get_template_part('content', 'resume');
				wp_reset_postdata();
			} ?>
		</div>
		<?php
	}else if ($wall_args['meta_wall_display_presentation'] == 'slider'){
		$display_slider_nav = false;
		if (empty($wall_args['meta_wall_display_presentation_slider_carousel']) || $wall_args['meta_wall_display_presentation_slider_carousel'] != 'on'){ // no thumb navigation in carousel mode
			if (!empty($wall_args['meta_wall_display_presentation_slider_thumb_nav']) && $wall_args['meta_wall_display_presentation_slider_thumb_nav'] == 'on'){
				$display_slider_nav = true;
			}
		}
		?>
		<div class="wall tool-wall slider-wrapper <?php if (is_admin()){ echo ' admin'; } ?>" id="slider-wrapper-<?php echo get_the_ID(); ?>" <?php if (!is_admin()){ ?>style="display: none;"<?php } ?>>
			<ul <?php if (is_admin()){ echo 'id="admin-slider-wall-'.get_the_ID().'"'; }else{ echo 'id="slider-wall-'.get_the_ID().'"'; } ?> class="wall tool-wall slider <?php echo $wall_args['meta_wall_display_presentation']; ?><?php if (is_admin()){ echo ' admin'; } ?>">
				<?php
				global $post;
				foreach ($posts as $post){
					setup_postdata($post);
					
					// template
					$template_selected = wall_get_default_template(get_the_ID());
					if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()])&& in_array($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()], $wall_args['available_templates']))
						$template_selected = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()];
					
					// template
					if (is_admin()){
						ob_start();
						?>
						<table class="wall-item-setup">
							<tr>
								<td class="field-icon"><i class="fa fa-laptop"></i></td>
								<td class="field">
									<select style="width: 100%;" class="wall-presentation-template save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID(); ?>">
									<?php foreach ($wall_args['available_templates'] as $available_template){
										$selected = "";
										if ($available_template == $template_selected)
											$selected = 'selected="selected"';
										?>
										<option value="<?php echo $available_template; ?>" <?php echo $selected; ?>><?php echo $available_template; ?></option>
										<?php
									} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="field-icon"><i class="fa fa-link"></i></td>
								<td class="field custom-link">
									<?php 
									$link = "";
									if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()]))
										$link = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()];
									?>
									<input type="text" style="width: 100%;" class="wall-presentation-link save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID(); ?>" value="<?php echo esc_url($link); ?>" placeholder="<?php _e("customized link", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>" />
									<i class="fa fa-share"></i>
									<?php 
									$link_blank = "";
									if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()]))
										$link_blank = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()];
									?>
									<input type="checkbox" class="wall-presentation-link-blank save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID(); ?>" <?php if ($link_blank == 'on'){ ?> checked="checked"<?php } ?> />
								</td>
							</tr>
						</table>
						<?php
						$wall_args["meta_wall_admin_item_code"] = ob_get_contents();
						ob_end_clean();
					}
					$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-template-slider-'.$template_selected.'.php');
					if (!empty($template))
						include($template);
					wp_reset_postdata();
				} ?>
			</ul>
			<?php
			if ($display_slider_nav){ ?>
				<div id="slider-wall-thumb-nav-wrapper-<?php echo get_the_ID(); ?>" class="slider-thumb-nav-wrapper" <?php if (!is_admin()){ ?>style="display: none;"<?php } ?>>
					<div class="slider-thumb-nav-control slider-thumb-nav-prev"><i class="fa fa-chevron-left"></i></div>
					<div <?php if (is_admin()){ echo 'id="admin-slider-wall-thumb-nav-'.get_the_ID().'"'; }else{ echo 'id="slider-wall-thumb-nav-'.get_the_ID().'"'; } ?> class="wall tool-wall slider-thumb-nav<?php if (is_admin()){ echo ' admin'; } ?>">
						<?php
						$cp_post = 0;
						global $post;
						foreach ($posts as $post){
							setup_postdata($post);
							$has_thumbnail = false;
							$class = '';
							$img = '';
							$style = '';
							if (has_post_thumbnail(get_the_ID())){
								$thumbnail_id = get_post_thumbnail_id(get_the_ID());
								$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'tool-wall-slider-nav-thumb');
								if ($thumbnail) {
									$has_thumbnail = true;
									list($thumbnail_src, $thumbnail_width, $thumbnail_height) = $thumbnail;
									$style .= "background:	url('$thumbnail_src') no-repeat center center;";
									$style .= "-webkit-background-size: cover;";
									$style .= "-moz-background-size: cover;";
									$style .= "-o-background-size: cover;";
									$style .= "-ms-background-size: cover;";
									$style .= "background-size: cover;";
									$style .= "overflow: hidden;";
								}
							}
							if ($has_thumbnail == true){
								$class .= ' has-thumb';
							}else{
								$class .= ' no-thumb';
							}
							?>
							<a class="slider-thumb-nav-item" data-slide-index="<?php echo $cp_post; ?>" href="#" style="<?php echo $style; ?>" class="<?php echo $class; ?>"><div class="has-mask"></div></a>
							<?php
							$cp_post++;
							wp_reset_postdata();
						}
						?>
					</div>
					<div class="slider-thumb-nav-control slider-thumb-nav-next"><i class="fa fa-chevron-right"></i></div>
				</div>
			<?php 
			}
			?>
		</div>
		<?php if (!is_admin()){ ?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#slider-wrapper-<?php echo get_the_ID(); ?>').fadeIn();
					$('#slider-wall-<?php echo get_the_ID(); ?>').bxSlider({
							onSliderLoad: function(){
								<?php if ($display_slider_nav){ ?>
								$("#slider-wall-thumb-nav-wrapper-<?php echo get_the_ID(); ?>").fadeIn();
									$("#slider-wall-thumb-nav-wrapper-<?php echo get_the_ID(); ?>").woodkit_slider_thumb_nav({
										items_container_selector : '#slider-wall-thumb-nav-<?php echo get_the_ID(); ?>',
										item_selector : '.slider-thumb-nav-item',
										prev_control_selector : '.slider-thumb-nav-prev',
										next_control_selector : '.slider-thumb-nav-next'
									});
									<?php 
								}
								?>
							},
							autoHover : true,
							prevText : '',
							nextText : '',
							<?php if (!empty($wall_args['meta_wall_display_presentation_slider_autoplay']) && $wall_args['meta_wall_display_presentation_slider_autoplay'] == 'on'){ ?>
								auto: true,
							<?php } ?>
							<?php if (!empty($wall_args['meta_wall_display_presentation_slider_carousel']) && $wall_args['meta_wall_display_presentation_slider_carousel'] == 'on'){ ?>
								minSlides: parseInt(<?php echo $wall_args['meta_wall_display_presentation_slider_carousel_columns']; ?>),
								maxSlides: parseInt(<?php echo $wall_args['meta_wall_display_presentation_slider_carousel_columns']; ?>),
								slideWidth: parseInt(<?php echo $wall_args['meta_wall_display_presentation_slider_carousel_item_width']; ?>),
								slideMargin: parseInt(<?php echo $wall_args['meta_wall_display_presentation_slider_carousel_item_margin']; ?>),
								moveSlides: 1,
							<?php }
							if ($display_slider_nav){ ?>
								pagerCustom: '#slider-wall-thumb-nav-<?php echo get_the_ID(); ?>',
							<?php } ?>
						});
				});
			</script>
		<?php } ?>
		<?php
	}else if($wall_args['meta_wall_display_presentation'] == 'masonry'){ // masonry
		?>
		<div class="wall tool-wall masonry-wrapper <?php if (is_admin()){ echo ' admin'; } ?>">
			<?php
			if ($wall_args['meta_wall_display_presentation_filtering'] == 'tax'){
				$taxonomies = array();
				$tax_terms = array();
				foreach ($posts as $post){
					$taxonomies = get_post_taxonomies($post);
				}
				foreach ($taxonomies as $tax){
					$terms = get_terms($tax);
					if (!empty($terms))
						$tax_terms[$tax] = get_terms($tax);
				}
				if (!empty($tax_terms)){ ?>
					<ul <?php if (is_admin()){ echo 'id="admin-masonry-wall-filter"'; }else{ echo 'id="masonry-wall-filter-'.get_the_ID().'"'; } ?> class="masonry-wall-filters">
						<li class="masonry-filter active" data-filter="*"><?php _e('All', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></li>
						<?php foreach ($tax_terms as $tax => $terms){ ?>
							<?php foreach ($terms as $term){ ?>
								<li class="masonry-filter" data-filter=".<?php echo $tax; ?>-<?php echo $term->slug; ?>" id="<?php echo $term->slug; ?>"><?php echo $term->name; ?></li>
							<?php } ?>
						<?php } ?>
					</ul>
				<?php }
			}else if($wall_args['meta_wall_display_presentation_filtering'] == 'search'){
				?>
				<div class="masonry-wall-search-field-wrapper">
					<input type="search" class="masonry-wall-search-field" <?php if (is_admin()){ echo 'id="admin-masonry-wall-search-field"'; }else{ echo 'id="masonry-wall-search-field-'.get_the_ID().'"'; } ?> placeholder="<?php _e('Search', WOODKIT_PLUGIN_TEXT_DOMAIN); ?>" />
				</div>
				<?php
			}
			
			$data_columns = "";
			if ($wall_args['meta_wall_display_presentation_masonry_width']  != "customized"){
				$data_columns ='data-columns="'.$wall_args['meta_wall_display_presentation_masonry_width'].'"';
			}
			
			$style = "";
			$style .= "margin: 0 0 0 -".$wall_args['meta_wall_display_presentation_margin_horizontal']."px";
			
			?>
			<ul <?php if (is_admin()){ echo 'id="admin-masonry-wall"'; }else{ echo 'id="masonry-wall-'.get_the_ID().'"'; } ?> class="wall tool-wall masonry <?php echo $wall_args['meta_wall_display_presentation']; ?><?php if (is_admin()){ echo ' admin'; } ?>"  <?php echo $data_columns; ?> style="<?php echo $style;?>">
				<?php
				global $post;
				foreach ($posts as $post){
					setup_postdata($post);
					// template
					$template_selected = wall_get_default_template(get_the_ID());
					if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()])&& in_array($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()], $wall_args['available_templates']))
						$template_selected = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()];
					
					// template
					if (is_admin()){
						ob_start();
						?>
						<table class="wall-item-setup">
							<tr>
								<td class="field-icon"><i class="fa fa-laptop"></i></td>
								<td class="field">
									<select style="width: 100%;" class="wall-presentation-template save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID(); ?>">
									<?php foreach ($wall_args['available_templates'] as $available_template){
										$selected = "";
										if ($available_template == $template_selected)
											$selected = 'selected="selected"';
										?>
										<option value="<?php echo $available_template; ?>" <?php echo $selected; ?>><?php echo $available_template; ?></option>
										<?php
									} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="field-icon"><i class="fa fa-link"></i></td>
								<td class="field custom-link">
									<?php 
									$link = "";
									if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()]))
										$link = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()];
									?>
									<input type="text" style="width: 100%;" class="wall-presentation-link save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID(); ?>" value="<?php echo esc_url($link); ?>" placeholder="<?php _e("customized link", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>" />
									<i class="fa fa-share"></i>
									<?php 
									$link_blank = "";
									if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()]))
										$link_blank = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()];
									?>
									<input type="checkbox" class="wall-presentation-link-blank save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID(); ?>" <?php if ($link_blank == 'on'){ ?> checked="checked"<?php } ?> />
								</td>
							</tr>
						</table>
						<?php
						$wall_args["meta_wall_admin_item_code"] = ob_get_contents();
						ob_end_clean();
					}
					$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-template-masonry-'.$template_selected.'.php');
					if (!empty($template))
						include($template);
					wp_reset_postdata();
				} ?>
			</ul>
		</div>
		<?php if (!is_admin()){ ?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
	
					// isotope apply after trigger by woodkit-gallery.js 
					var $masonry = $('#masonry-wall-<?php echo get_the_ID(); ?>');
					
					// filtres 
					<?php
					if ($wall_args['meta_wall_display_presentation_filtering'] == 'tax'){
					?>
					$('#masonry-wall-filter-<?php echo get_the_ID(); ?> li').click(function() {
						var selector = $(this).attr('data-filter');
						$masonry.isotope({
							filter : selector
						});
						$('#masonry-wall-filter-<?php echo get_the_ID(); ?> li').removeClass('active');
						$(this).addClass('active');
						return false;
					});
					<?php 
					}else if ($wall_args['meta_wall_display_presentation_filtering'] == 'search'){
					?>
					$('#masonry-wall-search-field-<?php echo get_the_id(); ?>').keyup(function(e){
						if (e.which == 13 || e.keyCode == 13){ // enter key haven't to submit any form
							e.preventDefault();
							return false; 
						}
						woodkit_search_debounce(e, $(this), function(e, $field) {
							var qsRegex = new RegExp($field.val(), 'gi');
							$masonry.isotope({
								filter: function() {
									return qsRegex ? $(this).text().match(qsRegex) : true;
								}
							})},200);
					});
					<?php 
					}
					?>

					// trigger on gallery-isotope-ready event (use by woodkit-gallery.js)
					$(document).trigger('gallery-isotope-ready', [$masonry, '.masonry-item']);
				});
			</script>
		<?php }
	}else if($wall_args['meta_wall_display_presentation'] == 'isotope'){ // isotope
		?>
		<div class="wall tool-wall isotope-wrapper <?php if (is_admin()){ echo ' admin'; } ?>">
			<?php
			if ($wall_args['meta_wall_display_presentation_filtering'] == 'tax'){
				$taxonomies = array();
				$tax_terms = array();
				foreach ($posts as $post){
					$taxonomies = get_post_taxonomies($post);
				}
				foreach ($taxonomies as $tax){
					$terms = get_terms($tax);
					if (!empty($terms))
						$tax_terms[$tax] = get_terms($tax);
				}
				if (!empty($tax_terms)){ ?>
					<ul <?php if (is_admin()){ echo 'id="admin-isotope-wall-filter"'; }else{ echo 'id="isotope-wall-filter-'.get_the_ID().'"'; } ?> class="isotope-wall-filters">
						<li class="isotope-filter active" data-filter="*"><?php _e('All', WOODKIT_PLUGIN_TEXT_DOMAIN); ?></li>
						<?php foreach ($tax_terms as $tax => $terms){ ?>
							<?php foreach ($terms as $term){ ?>
								<li class="isotope-filter" data-filter=".<?php echo $tax; ?>-<?php echo $term->slug; ?>" id="<?php echo $term->slug; ?>"><?php echo $term->name; ?></li>
							<?php } ?>
						<?php } ?>
					</ul>
				<?php }
			}else if($wall_args['meta_wall_display_presentation_filtering'] == 'search'){
				?>
				<div class="isotope-wall-search-field-wrapper">
					<input type="search" class="isotope-wall-search-field" <?php if (is_admin()){ echo 'id="admin-isotope-wall-search-field"'; }else{ echo 'id="isotope-wall-search-field-'.get_the_ID().'"'; } ?> placeholder="<?php _e('Search', WOODKIT_PLUGIN_TEXT_DOMAIN); ?>" />
				</div>
				<?php
			}
			
			$style = "";
			$style .= "margin: 0 0 0 -".$wall_args['meta_wall_display_presentation_margin_horizontal']."px";
			
			?>
			<ul <?php if (is_admin()){ echo 'id="admin-isotope-wall"'; }else{ echo 'id="isotope-wall-'.get_the_ID().'"'; } ?> class="wall tool-wall isotope <?php echo $wall_args['meta_wall_display_presentation']; ?><?php if (is_admin()){ echo ' admin'; } ?>" data-columns="<?php echo $wall_args['meta_wall_display_presentation_columns']; ?>" style="<?php echo $style;?>">
				<?php
				global $post;
				foreach ($posts as $post){
					setup_postdata($post);
					// template
					$template_selected = wall_get_default_template(get_the_ID());
					if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()]) && in_array($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()], $wall_args['available_templates']))
						$template_selected = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID()];
					
					// width_selected
					$width_selected = "1";
					if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_WIDTH_.get_the_ID()]) && in_array($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_WIDTH_.get_the_ID()], $wall_args['available_isotope_widths'])){
						$width_selected = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_WIDTH_.get_the_ID()];
					}
					$wall_args['wall_item_width_selected'] = $width_selected;

					// height_selected
					$height_selected = "1";
					if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_HEIGHT_.get_the_ID()]) && in_array($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_HEIGHT_.get_the_ID()], $wall_args['available_isotope_heights'])){
						$height_selected = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_HEIGHT_.get_the_ID()];
					}
					$wall_args['wall_item_height_selected'] = $height_selected;
					
					// template
					if (is_admin()){
						ob_start();
						?>
						<table class="wall-item-setup">
							<tr>
								<td class="field-icon"><i class="fa fa-arrows-h"></i></td>
								<td class="field">
									<select style="width: 100%;" class="wall-presentation-width save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_WIDTH_.get_the_ID(); ?>">
									<?php foreach ($wall_args['available_isotope_widths'] as $available_isotope_width){
										$selected = "";
										if ($available_isotope_width == $width_selected)
											$selected = 'selected="selected"';
										?>
										<option value="<?php echo $available_isotope_width; ?>" <?php echo $selected; ?>><?php echo $available_isotope_width; ?></option>
										<?php
									} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="field-icon"><i class="fa fa-arrows-v"></i></td>
								<td class="field">
									<select style="width: 100%;" class="wall-presentation-height save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_HEIGHT_.get_the_ID(); ?>">
									<?php foreach ($wall_args['available_isotope_heights'] as $available_isotope_height){
										$selected = "";
										if ($available_isotope_height == $height_selected)
											$selected = 'selected="selected"';
										?>
										<option value="<?php echo $available_isotope_height; ?>" <?php echo $selected; ?>><?php echo $available_isotope_height; ?></option>
										<?php
									} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="field-icon"><i class="fa fa-laptop"></i></td>
								<td class="field">
									<select style="width: 100%;" class="wall-presentation-template save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_TEMPLATE_.get_the_ID(); ?>">
									<?php foreach ($wall_args['available_templates'] as $available_template){
										$selected = "";
										if ($available_template == $template_selected)
											$selected = 'selected="selected"';
										?>
										<option value="<?php echo $available_template; ?>" <?php echo $selected; ?>><?php echo $available_template; ?></option>
										<?php
									} ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="field-icon"><i class="fa fa-link"></i></td>
								<td class="field custom-link">
									<?php 
									$link = "";
									if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()]))
										$link = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID()];
									?>
									<input type="text" style="width: 100%;" class="wall-presentation-link save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_.get_the_ID(); ?>" value="<?php echo esc_url($link); ?>" placeholder="<?php _e("customized link", WOODKIT_PLUGIN_TEXT_DOMAIN); ?>" />
									<i class="fa fa-share"></i>
									<?php 
									$link_blank = "";
									if (isset($wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()]))
										$link_blank = $wall_args['meta_wall_display_presentation_setup'][META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID()];
									?>
									<input type="checkbox" class="wall-presentation-link-blank save-presentation-setup" name="<?php echo META_WALL_DISPLAY_PRESENTATION_SETUP_LINK_BLANK_.get_the_ID(); ?>" <?php if ($link_blank == 'on'){ ?> checked="checked"<?php } ?> />
								</td>
							</tr>
						</table>
						<?php
						$wall_args["meta_wall_admin_item_code"] = ob_get_contents();
						ob_end_clean();
					}
					
					$template = locate_ressource(WOODKIT_PLUGIN_TOOLS_FOLDER.WALL_TOOL_NAME.'/templates/tool-wall-template-isotope-'.$template_selected.'.php');
					if (!empty($template))
						include($template);
					wp_reset_postdata();
				} ?>
			</ul>
		</div>
		<?php if (!is_admin()){ ?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					
					// isotope apply after trigger by woodkit-gallery.js 
					var $isotope = $('#isotope-wall-<?php echo get_the_ID(); ?>');

					// filtres 
					<?php
					if ($wall_args['meta_wall_display_presentation_filtering'] == 'tax'){
					?>
					$('#isotope-wall-filter-<?php echo get_the_ID(); ?> li').click(function() {
						var selector = $(this).attr('data-filter');
						$isotope.isotope({
							filter : selector
						});
						$('#isotope-wall-filter-<?php echo get_the_ID(); ?> li').removeClass('active');
						$(this).addClass('active');
						return false;
					});
					<?php 
					}else if ($wall_args['meta_wall_display_presentation_filtering'] == 'search'){
					?>
					$('#isotope-wall-search-field-<?php echo get_the_id(); ?>').keyup(function(e){
						if (e.which == 13 || e.keyCode == 13){ // enter key haven't to submit any form
							e.preventDefault();
							return false; 
						}
						woodkit_search_debounce(e, $(this), function(e, $field) {
							var qsRegex = new RegExp($field.val(), 'gi');
							$isotope.isotope({
								filter: function() {
									return qsRegex ? $(this).text().match(qsRegex) : true;
								}
							})},200);
					});
					<?php 
					}
					?>

					// trigger on gallery-isotope-ready event (use by woodkit-gallery.js)
					$(document).trigger('gallery-isotope-ready', [$isotope, '.isotope-item']);
				});
			</script>
		<?php } ?>
	<?php }else{ ?>
		<h3><?php echo WALL_TOOL_NAME." tool : ".__("No presentation found !", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></h3>
	<?php } ?>
<?php } ?>