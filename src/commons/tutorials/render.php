<?php
/**
Author: S. Chandonay - C. Tissot
Author URI: https://www.seb-c.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
defined('ABSPATH') or die("Go Away!");

class WK_Tutorials {

	private $internal_base_url;

	public function __construct(){
		$this->internal_base_url = apply_filters('woodkit_tutorials_base_url', WP_CONTENT_URL . '/tutorials/');
		$this->display();
	}

	private function display() { ?>
		<div class="fw-page woodkit-tool-page-options">

			<div class="wk-panel">
				<div class="woodkit-credits">
					<div class="logo"><?php echo get_woodkit_icon('paw', false, false, array('style' => 'fill: '.woodkit_get_admin_color().';')); ?></div>
					<div class="text">
						<h1 class="title"><?php _e("Studio Montana"); ?><sup class="copy"> &copy;</sup></h1>
						<p class="desc"><?php _e("Studio Montana vous propose une série de vidéos tutoriels."); ?><br />Avec ça vous ne pouvez que booster votre site Web !</p>
						<p class="credit"><a href="https://www.seb-c.com" target="_blank">Sébastien Chandonay</a> & <a href="https://www.cyriltissot.com" target="_blank">Cyril Tissot</a> pour <a href="https://www.studio-montana.com" target="_blank">Studio Montana</a></p>
					</div>
				</div>
			</div>

			<div class="wk-panel">
				<h1><span class="dashicons dashicons-welcome-learn-more"></span><?php _e('Tutorials', 'woodkit'); ?></h1>
			</div>

			<?php $sections = array(
					array(
						'title' => "Découverte de Gutenberg",
						'icon' => 'dashicons dashicons-format-video',
						'tutos' => array(
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/jBvTd2tReRs', 'title' => "Présentation de Gutenberg, l'éditeur de Wordpress", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/TCxGArEcTmA', 'title' => "Le bloc <em>colonnes</em>", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/ypxwQ-Duquw', 'title' => "Le bloc <em>paragraphe</em>", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/G3h_bRuexpQ', 'title' => "Le bloc <em>image</em>", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/X5A_YkApd60', 'title' => "Le bloc <em>titre</em>", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/xbjaNX5Cwn0', 'title' => "Le bloc <em>contenu embarqué</em>", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/LQicyHITOBU', 'title' => "Le bloc <em>galerie</em>", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/ADwjI9g4-MA', 'title' => "Le bloc <em>groupe</em>", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/2CxoRFwKYSE', 'title' => "Les blocs réutilisables", 'profil' => 'confirmé'),
					)),
					array(
						'title' => "SEO - optimisation du référencement (Woodkit)",
						'icon' => 'dashicons dashicons-format-video',
						'tutos' => array(
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/8Sjb3mXz4_Q', 'title' => "Améliorer le référencement naturel de votre site", 'profil' => 'débutant'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/UvpIXhB3-d8', 'title' => "Gérer les redirections 301", 'profil' => 'confirmé'),
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/C65V0pn_VEE', 'title' => "Gérer le sitemap.xml", 'profil' => 'confirmé'),
					)),
					array(
						'title' => "Sécurité (Woodkit)</em>",
						'icon' => 'dashicons dashicons-format-video',
						'tutos' => array(
							array('target' => 'embed', 'url' => 'https://www.youtube.com/embed/MIHwxnrxpAs', 'title' => "réglages principaux", 'profil' => 'confirmé'),
					)),
			);
			$sections = apply_filters('woodkit_tutorials', $sections, $this->internal_base_url);
			if (!empty($sections)) {
				foreach ($sections as $section) {
					$this->display_section($section);
				}
			} ?>

			<script type="text/javascript">
			(function($) {
				$(document).ready(function(){
					$(".tuto.internal a").on('click', function(e){
						e.preventDefault();
						var video_width = $(window).width()-24;
						if (video_width > 1000){
							video_width = 1000;
						}
						$.wk_modalbox.open({content : '<video width="'+video_width+'" height="'+(video_width / 1.618)+'" controls><source src="'+$(this).attr('href')+'" type="video/mp4"></video>'});
						return false;
					});
					$(".tuto.embed a").on('click', function(e){
						e.preventDefault();
						$.wk_modalbox.open({content : '<iframe width="700" height="400" src="'+$(this).attr('href')+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'});
						return false;
					});
				});
			})(jQuery);
			</script>
		</div>
	<?php }

	private function display_section($section) { ?>
		<div class="wk-panel">
			<h3 class="wk-panel-title">
				<?php if (isset($section['icon'])) { ?><span class="<?php echo esc_attr($section['icon']); ?>" style="margin-right: 6px;"></span><?php } ?>
				<?php echo $section['title']; ?>
			</h3>
			<div class="wk-panel-content">
				<ul class="tutorials">
					<?php if (isset($section['tutos'])){
						foreach ($section['tutos'] as $tuto) { ?>
							<li class="tuto <?php echo esc_attr($tuto['target']); ?>">
								<a href="<?php echo esc_attr($tuto['url']); ?>" target="_blank">
									<?php echo $tuto['title']; ?>
									<?php if (isset($tuto['profil'])) { ?> <em style="font-size: 10px;">(<?php echo $tuto['profil']; ?>)</em><?php } ?>
									<?php if (isset($tuto['date'])){ ?><span class="date"><?php _e('posted on', 'woodkit'); ?> <?php echo $tuto['date']; ?></span><?php } ?>
									<?php if (isset($tuto['new'])){ ?><span class="new"><i class="dashicons dashicons-flag"></i>NEW</span><?php } ?>
								</a>
							</li>
						<?php }
					} ?>
				</ul>
			</div>
		</div>
	<?php }
}
