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

$style_ul = "";
$style_li = "";
if (!empty($meta_media_presentation_margin_horizontal) && is_numeric($meta_media_presentation_margin_horizontal) && !empty($meta_media_presentation_margin_vertical) && is_numeric($meta_media_presentation_margin_vertical)){
	$style_ul .= "margin: 0 0 -".$meta_media_presentation_margin_vertical."px -".$meta_media_presentation_margin_horizontal."px;";
	$style_li .= "padding: 0 0 ".$meta_media_presentation_margin_vertical."px ".$meta_media_presentation_margin_horizontal."px;";
}

if ($meta_media_presentation == 'slider'){
	$display_slider_nav = false;
	if (empty($meta_media_presentation_slider_carousel) || $meta_media_presentation_slider_carousel != 'on'){ // no thumb navigation in carousel mode
		if (!empty($meta_media_presentation_slider_thumb_nav) && $meta_media_presentation_slider_thumb_nav == 'on'){
			$display_slider_nav = true;
		}
	}
	?>
	<div class="gallery-wrapper tool-media slider-wrapper" id="slider-wrapper-<?php echo $media_post_count; ?>" style="display: none;">
		<ul id="slider-gallery-<?php echo $media_post_count; ?>" class="gallery tool-media slider<?php if (!empty($meta_media_presentation_slider_carousel) && $meta_media_presentation_slider_carousel == 'on'){ echo " slider-carousel"; } ?>" data-wall-columns="<?php echo $columns; ?>">
			<?php
			foreach ($attachments as $id => $attachment) {
				$img = wp_get_attachment_image_src($id, apply_filters('woodkit-gallery-slider-image-size', 'woodkit-1200'));
				$class = ' attachment attachment-'.$id;
				$height = $meta_media_presentation_height;
				$style = "width: 100%; height: ".$height."px;";
				$style .= "background:	url('$img[0]') no-repeat center center;";
				$style .= " -webkit-background-size: cover;";
				$style .= " -moz-background-size: cover;";
				$style .= " -o-background-size: cover;";
				$style .= " -ms-background-size: cover;";
				$style .= " background-size: cover;";
				$style .= "overflow: hidden;";
				$a_class = "";
				$data_fancybox_title = "";
				if (woodkit_is_activated_tool('fancybox')){
					$a_class .= " fancybox";
					if (!empty($attachment->post_title)){
						$data_fancybox_title .= "<h1>".$attachment->post_title."</h1>";
					}
					if (!empty($attachment->post_excerpt)){
						$data_fancybox_title .= "<div>".$attachment->post_excerpt."</div>";
					}
				}
				?>
				<li class="slider-item wp-gallery-item<?php echo $class; ?>" style="height: auto; width: auto;">
					<a class="<?php echo $a_class; ?>" rel="group-<?php echo $media_post_count; ?>" data-fancybox="group-<?php echo $media_post_count; ?>" href="<?php echo $img[0]; ?>" title="<?php echo esc_attr($attachment->post_title); ?>" data-fancybox-title="<?php echo esc_attr($data_fancybox_title); ?>">
						<div class="inner-item thumb" style="<?php echo $style; ?>">
							<div class="has-mask">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
							<div class="has-infos">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
						</div>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<?php if ($display_slider_nav){ ?>
		<div id="slider-gallery-thumb-nav-wrapper-<?php echo $media_post_count; ?>" class="slider-thumb-nav-wrapper" style="display: none;">
			<div class="slider-thumb-nav-control slider-thumb-nav-prev"><i class="fa fa-chevron-left"></i></div>
			<div id="slider-gallery-thumb-nav-<?php echo $media_post_count; ?>" class="slider-thumb-nav">
				<?php
				$cp_attachment = 0;
				foreach ($attachments as $id => $attachment) {
					$img = wp_get_attachment_image_src($id, 'woodkit-150-150');
					$class = ' attachment attachment-'.$id;
					$style = "background: url('$img[0]') no-repeat center center;";
					$style .= " -webkit-background-size: cover;";
					$style .= " -moz-background-size: cover;";
					$style .= " -o-background-size: cover;";
					$style .= " -ms-background-size: cover;";
					$style .= " background-size: cover;";
					$style .= "overflow: hidden;";
					?>
					<a class="slider-thumb-nav-item" data-slide-index="<?php echo $cp_attachment; ?>" href="#" style="<?php echo $style; ?>"><div class="has-mask"></div></a>
					<?php 
					$cp_attachment++;
				}
				?>
			</div>
			<div class="slider-gallery-nav-control slider-thumb-nav-next"><i class="fa fa-chevron-right"></i></div>
		</div>
		<?php 
		}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#slider-wrapper-<?php echo $media_post_count; ?>').fadeIn();
				$('#slider-gallery-<?php echo $media_post_count; ?>').bxSlider({
						onSliderLoad: function(){
							<?php if ($display_slider_nav){ ?>
							$("#slider-gallery-thumb-nav-wrapper-<?php echo $media_post_count; ?>").fadeIn();
								$("#slider-gallery-thumb-nav-wrapper-<?php echo $media_post_count; ?>").woodkit_slider_thumb_nav({
									items_container_selector : '#slider-gallery-thumb-nav-<?php echo $media_post_count; ?>',
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
						<?php if (!empty($meta_media_presentation_slider_autoplay) && $meta_media_presentation_slider_autoplay == 'on'){ ?>
							auto: true,
						<?php } ?>
						<?php if (!empty($meta_media_presentation_slider_carousel) && $meta_media_presentation_slider_carousel == 'on'){ ?>
							minSlides: parseInt(<?php echo $columns; ?>),
							maxSlides: parseInt(<?php echo $columns; ?>),
							slideWidth: parseInt(<?php echo $meta_media_presentation_slider_carousel_item_width; ?>),
							slideMargin: parseInt(<?php echo $meta_media_presentation_slider_carousel_item_margin; ?>),
							moveSlides: 1,
						<?php }
						if ($display_slider_nav){ ?>
							pagerCustom: '#slider-gallery-thumb-nav-<?php echo $media_post_count; ?>',
						<?php } ?>
					});
			});
		</script>
	</div>
	<?php
}else if ($meta_media_presentation == 'masonry'){?>
	<div class="gallery-wrapper tool-media masonry-wrapper">
		<?php 
		$data_columns = "";
		if ($meta_media_presentation_masonry_width != "customized"){
			$data_columns ='data-wall-columns="'.$columns.'"';
		}
		?>
		<ul id="masonry-gallery-<?php echo $media_post_count; ?>" class="gallery tool-media masonry" <?php echo $data_columns; ?> style="<?php echo $style_ul; ?>">
			<?php
			foreach ($attachments as $id => $attachment) {
				$ratio = "";
				$style = "";
				$style_thumb = "";
				$class = "";
				$a_class = "";
				$data_fancybox_title = "";
				
				// attachement
				$img = wp_get_attachment_image_src($id, apply_filters('woodkit-gallery-masonry-image-full-size', 'full'));
				$thumb = wp_get_attachment_image_src($id, apply_filters('woodkit-gallery-masonry-image-thumb-size', 'woodkit-400'));
				list($img_src, $img_width, $img_height) = $img;
				list($thumb_src, $thumb_width, $thumb_height) = $thumb;
				$ratio = $thumb_height / $thumb_width;
				
				// sizes
				$width = $meta_media_presentation_masonry_width_customized;
				$height = $meta_media_presentation_masonry_height;				
				if ($meta_media_presentation_masonry_width == "customized"){
					$style .= "max-width: ".$width."px;";
					$style .= "width: 100%;";
					$proportional_height = floor(($thumb_height*$width)/$thumb_width);
					if (!empty($height) && is_numeric($height) && $proportional_height > $height){
						$style .= "height: ".$height."px;";
					}else{
						$style .= "height: ".$proportional_height."px;";
					}
				}else{
					$style .= "width: ".(100/$columns)."%;";
					$temp_width = floor($thumb_width * ((100 / $columns) / 100));
					$proportional_height = floor(($thumb_height*$temp_width)/$thumb_width);
					if (!empty($height) && is_numeric($height) && $proportional_height > $height){
						$style .= "height: ".$height."px;";
					}else{
						$style .= "height: ".$proportional_height."px;";
					}
				}
				
				// styles
				$style_thumb .= "width: 100%; height: 100%;";
				$style_thumb .= "background: url('$thumb_src') no-repeat center center;";
				$style_thumb .= " -webkit-background-size: cover;";
				$style_thumb .= " -moz-background-size: cover;";
				$style_thumb .= " -o-background-size: cover;";
				$style_thumb .= " -ms-background-size: cover;";
				$style_thumb .= " background-size: cover;";
				$style_thumb .= "overflow: hidden;";
				
				// classes / data
				$class .= " attachment attachment-$id";
				if (woodkit_is_activated_tool('fancybox')){
					$a_class .= " fancybox";
					if (!empty($attachment->post_title)){
						$data_fancybox_title .= "<h1>".$attachment->post_title."</h1>";
					}
					if (!empty($attachment->post_excerpt)){
						$data_fancybox_title .= "<div>".$attachment->post_excerpt."</div>";
					}
				}
				$style_li .= $style;
				?>
				<li class="masonry-item wp-gallery-item<?php echo $class; ?>" style="<?php echo $style_li; ?>" data-ratio-width-height="<?php echo $ratio; ?>" data-wall-columns="1">
					<a class="<?php echo $a_class; ?>" rel="group-<?php echo $media_post_count; ?>" data-fancybox="group-<?php echo $media_post_count; ?>" href="<?php echo $img_src; ?>" title="<?php echo esc_attr($attachment->post_title); ?>" data-fancybox-title="<?php echo esc_attr($data_fancybox_title); ?>">
						<div class="inner-item thumb" style="<?php echo $style_thumb; ?>">
							<div class="has-mask">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
							<div class="has-infos">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
						</div>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($){

				// isotope apply after trigger by woodkit-media.js 
				var $masonry = $('#masonry-gallery-<?php echo $media_post_count; ?>');

				// trigger on media-isotope-ready event (use by woodkit-media.js)
				$(document).trigger('gallery-isotope-ready', [$masonry, '.masonry-item']);
			});
		</script>
	</div>
<?php
}else if ($meta_media_presentation == 'grid'){ ?>
	<div class="gallery-wrapper tool-media isotope-wrapper">
		<ul id="isotope-gallery-<?php echo $media_post_count; ?>" class="gallery tool-media isotope" data-wall-columns="<?php echo $columns; ?>" style="<?php echo $style_ul; ?>">
			<?php
			foreach ($attachments as $id => $attachment) {
				$img = wp_get_attachment_image_src($id, apply_filters('woodkit-gallery-grid-image-full-size', 'full'));
				$thumb = wp_get_attachment_image_src($id, apply_filters('woodkit-gallery-grid-image-thumb-size', 'woodkit-400'));
				// sizes (random - values can only be double from initial setup)
				$rand_columns = rand(1, 2);
				$width = (100/$columns)*$rand_columns;
				$rand_lines = rand(1, 2);
				$height = $meta_media_presentation_height * $rand_lines;
				// styles
				$class = ' attachment attachment-'.$id;
				$style = "width: 100%; height: 100%;";
				$style .= "background:	url('$thumb[0]') no-repeat center center;";
				$style .= " -webkit-background-size: cover;";
				$style .= " -moz-background-size: cover;";
				$style .= " -o-background-size: cover;";
				$style .= " -ms-background-size: cover;";
				$style .= " background-size: cover;";
				$style .= "overflow: hidden;";
				$a_class = "";
				$data_fancybox_title = "";
				if (woodkit_is_activated_tool('fancybox')){
					$a_class .= " fancybox";
					if (!empty($attachment->post_title)){
						$data_fancybox_title .= "<h1>".$attachment->post_title."</h1>";
					}
					if (!empty($attachment->post_excerpt)){
						$data_fancybox_title .= "<div>".$attachment->post_excerpt."</div>";
					}
				}
				$style_li .= "height: ".$height."px; width: ".$width."%;";
				?>
				<li class="isotope-item wp-gallery-item<?php echo $class; ?>" style="<?php echo $style_li; ?>" data-wall-format="<?php echo $meta_media_presentation_format; ?>" data-wall-columns="<?php echo $rand_columns; ?>" data-wall-lines="<?php echo $rand_lines; ?>" data-width="" data-height="<?php echo $height; ?>" >
					<a class="<?php echo $a_class; ?>" rel="group-<?php echo $media_post_count; ?>" data-fancybox="group-<?php echo $media_post_count; ?>" href="<?php echo $img[0]; ?>" title="<?php echo esc_attr($attachment->post_title); ?>" data-fancybox-title="<?php echo esc_attr($data_fancybox_title); ?>">
						<div class="inner-item thumb" style="<?php echo $style; ?>">
							<div class="has-mask">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
							<div class="has-infos">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
						</div>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($){

				// isotope apply after trigger by woodkit-media.js 
				var $isotope = $('#isotope-gallery-<?php echo $media_post_count; ?>');

				// trigger on media-isotope-ready event (use by woodkit-media.js)
				$(document).trigger('gallery-isotope-ready', [$isotope, '.isotope-item']);
			});
		</script>
	</div>
	<?php
}else{ ?>
	<div class="gallery-wrapper tool-media classic-wrapper">
		<ul id="classic-gallery-<?php echo $media_post_count; ?>" class="gallery tool-media classic" data-wall-columns="<?php echo $columns; ?>" style="<?php echo $style_ul; ?>">
			<?php
			foreach ($attachments as $id => $attachment) {
				$img = wp_get_attachment_image_src($id, apply_filters('woodkit-gallery-image-full-size', 'full'));
				$thumb = wp_get_attachment_image_src($id, apply_filters('woodkit-gallery-image-thumb-size', 'woodkit-400'));
				$class = ' attachment attachment-'.$id;
				$width = 100 / $columns;
				$style = "width: 100%; height: 100%;";
				$style .= "background:	url('$thumb[0]') no-repeat center center;";
				$style .= " -webkit-background-size: cover;";
				$style .= " -moz-background-size: cover;";
				$style .= " -o-background-size: cover;";
				$style .= " -ms-background-size: cover;";
				$style .= " background-size: cover;";
				$style .= "overflow: hidden;";
				$a_class = "";
				$data_fancybox_title = "";
				if (woodkit_is_activated_tool('fancybox')){
					$a_class .= " fancybox";
					if (!empty($attachment->post_title)){
						$data_fancybox_title .= "<h1>".$attachment->post_title."</h1>";
					}
					if (!empty($attachment->post_excerpt)){
						$data_fancybox_title .= "<div>".$attachment->post_excerpt."</div>";
					}
				}
				$style_li .= "width: ".$width."%;";
				?>
				<li class="classic-item wp-gallery-item<?php echo $class; ?>" style="<?php echo $style_li; ?>" data-wall-columns="1" data-wall-format="<?php echo $meta_media_presentation_format; ?>">
					<a class="<?php echo $a_class; ?>" rel="group-<?php echo $media_post_count; ?>" data-fancybox="group-<?php echo $media_post_count; ?>" href="<?php echo $img[0]; ?>" title="<?php echo esc_attr($attachment->post_title); ?>" data-fancybox-title="<?php echo esc_attr($data_fancybox_title); ?>">
						<div class="inner-item thumb" style="<?php echo $style; ?>">
							<div class="has-mask">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
							<div class="has-infos">
								<?php if (!empty($attachment->post_title)){ ?>
									<div class="title"><?php echo $attachment->post_title; ?></div>
								<?php } ?>
								<?php if (!empty($attachment->post_excerpt)){ ?>
									<div class="caption"><?php echo $attachment->post_excerpt; ?></div>
								<?php } ?>
							</div>
						</div>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				// set data-width and data-height attributes (used to calculate propotional height by responsive javascript)
				$('#classic-gallery-<?php echo $media_post_count; ?> .classic-item').each(function(i){
					$(this).attr('data-width', $(this).width());
					$(this).css('height', $(this).width()+"px"); // square présentation 
					$(this).attr('data-height', $(this).height());
				});
				// isotope apply after trigger by woodkit-media.js 
				var $classic = $('#classic-gallery-<?php echo $media_post_count; ?>');
				
				// trigger on media-classic-ready event (use by woodkit-media.js) 
				$(document).trigger('gallery-classic-ready', [$classic, '.classic-item']);
			});
		</script>
	</div>
<?php
}
?>