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

if (empty($postypes)){
	$postypes = get_displayed_post_types(true, true, array("revision", "nav_menu_item"));
	$postypes = apply_filters("woodkit_postpicker_available_posttypes", $postypes);
}
global $post;

if (!empty($postypes)){
	?>
	<div class="results">
		<div class="column column-left">
			<?php
			foreach ($postypes as $postype){
				?>
				<div class="post-type-selector" data-type="<?php echo $postype; ?>">					
					<?php
					$post_type_label = get_post_type_labels(get_post_type_object($postype));
					echo $post_type_label->name;
					?>
				</div>
				<?php
			}
			?>
		</div>
		<div class="column column-right">
			<?php
			foreach ($postypes as $postype){
				$posts = get_posts(array('post_type' => $postype, "numberposts" => -1, "exclude" => $exclude, "suppress_filters" => FALSE));
				?>
				<div class="postype-section" data-type="<?php echo $postype; ?>" style="display: none;">
					<?php if (empty($posts)){ ?>
						<h2><?php _e("No entry", WOODKIT_PLUGIN_TEXT_DOMAIN); ?></h2>
					<?php }else{ ?>
						<ul>
							<?php
							foreach ($posts as $post){
								setup_postdata($post);
								$available = true;
								if (get_post_type() == "attachment" && !startsWith(get_post_mime_type(), 'image')){ // only attachment images
									$available = false;
								}
								if ($available == true){
									?>
									<li class="post-item" data-id="<?php echo get_the_ID()?>">
										<?php 
										$postpick_item_template = locate_ressource(WOODKIT_PLUGIN_COMMONS_FOLDER.'/postpicker/templates/postpicker-item.php');
										if (!empty($postpick_item_template))
											include($postpick_item_template);
										?>
										<div class="selected-box">
											<i class="fa fa-check added"></i>
											<i class="fa fa-minus remove"></i>
										</div>
										<div class="selectable-area"></div>
									</li>
									<?php
								}
								wp_reset_postdata();
							} ?>
						</ul>
					<?php } ?>
					<div style="clear: both;"></div>
				</div>
				<?php 
			}
			?>
		</div>
		<script type="text/javascript">
		(function($) {
			$(document).ready(function(){
				// post-types management 
				var first_type = $("#postpicker-content .postype-section:first-child").data("type");
				$("#postpicker-content .postype-section[data-type='"+first_type+"']").fadeIn(0);
				$("#postpicker-content .post-type-selector[data-type='"+first_type+"']").addClass("selected");
				$("#postpicker-content .post-type-selector").on("click", function(e){
					var type = $(this).data("type");
					$("#postpicker-content .postype-section").fadeOut(0);
					$("#postpicker-content .post-type-selector").removeClass("selected");
					$("#postpicker-content .postype-section[data-type='"+type+"']").fadeIn(0);
					$("#postpicker-content .post-type-selector[data-type='"+type+"']").addClass("selected");
				});
			});
		})(jQuery);
		</script>
	</div>
<?php
}
?>