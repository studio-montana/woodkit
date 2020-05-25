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
defined ( 'ABSPATH' ) or die ( "Go Away!" );

class WoodkitConfig {

	public static $nonce_name = 'woodkit-config-nonce';
	private $options;
	private $self_url;
	private $nonce_action;
	private $site_registered;

	/**
	 * Start up
	 */
	public function __construct(){
		// Self URL
		$this->self_url = menu_page_url('woodkit_options', false);
		
		// Nonce
		$this->nonce_action = wp_create_nonce(self::$nonce_name);
		
		// set options
		$this->options = woodkit_get_options(true);
		
		// is registered
		$this->site_registered = WoodkitInstaller::is_registered();
		
		// display page
		$this->display();
		
	}
	
	/**
	 * This method is called by 'init' hook action (before this Class is intanciated) - be careful to check correct nonce
	 * (called in woodkit.php on 'init' action)
	 */
	public static function save(){
		// woodkit main form (note: tool's setups are managed separatly)
		if (isset($_POST) && !empty($_POST) && isset($_POST[self::$nonce_name]) && wp_verify_nonce($_POST[self::$nonce_name], self::$nonce_name)){
			if (isset($_POST[WOODKIT_CONFIG_OPTIONS]) && !empty($_POST[WOODKIT_CONFIG_OPTIONS]) && is_array($_POST[WOODKIT_CONFIG_OPTIONS])){
				$new_options = array();
				$form_options = woodkit_get_request_param(WOODKIT_CONFIG_OPTIONS, array(), false);
				foreach ($form_options as $k => $v){
					$new_options[$k] = sanitize_text_field($v);
				}
				woodkit_save_options($new_options);
			}
		}
		// tool activation / deactivation
		if (isset($_GET) && !empty($_GET) && isset($_GET[self::$nonce_name]) && wp_verify_nonce($_GET[self::$nonce_name], self::$nonce_name)){
			if (isset($_GET['action']) && !empty($_GET['action']) && isset($_GET['tool']) && !empty($_GET['tool'])){
				$action = woodkit_get_request_param('action');
				$tool_slug = woodkit_get_request_param('tool');
				if ($action == 'activate'){
					$GLOBALS['woodkit']->tools->activate_tool($tool_slug);
				}else if ($action == 'deactivate'){
					$GLOBALS['woodkit']->tools->deactivate_tool($tool_slug);
				}
			}
		}
	}
	
	private function display(){
		?>
		<div class="wrap woodkit-page-options woodkit-tool-page-options">
    		
    		<div class="wk-panel">
				<div class="woodkit-credits">
					<div class="logo"><?php echo get_woodkit_icon("logo"); ?></div>
					<div class="text">
						<h1 class="title"><?php _e("Woodkit"); ?><sup class="copy"> &copy;</sup></h1>
						<p class="desc"><?php _e("Un outil robuste complétant Wordpress en terme de SEO, de sécurité et d'outils sur-mesure dédiés à votre site Web."); ?><br />L'idée est qu'un outil simple, répondant uniquement aux besoins essentiels, dure dans le temps.</p>
						<p class="credit">Développé et maintenu depuis 2016 par <a href="https://www.seb-c.com" target="_blank">Sébastien Chandonay</a> & <a href="https://www.cyriltissot.com" target="_blank">Cyril Tissot</a> pour <a href="https://www.studio-montana.com" target="_blank">Studio Montana</a></p>
					</div>
				</div>
			</div>
    		
    		<form method="post" action="<?php echo $this->self_url; ?>">
    			<input type="hidden" name="<?php echo self::$nonce_name; ?>" value="<?php echo $this->nonce_action; ?>" />
	    		<div class="wk-panel">
					<h2 class="wk-panel-title"><?php _e("Activation", 'woodkit'); ?></h2>
					<div class="wk-panel-content">
						<div class="field">
							<div class="field-content">
								<?php 
								$value = "";
								if (isset($this->options['key-activation'])){
									$value = $this->options['key-activation'];
								}
								?>
								<label for="key-activation"><?php _e("Woodkit key activation", 'woodkit'); ?></label>
								<input placeholder="<?php _e("YOUR KEY", 'woodkit'); ?>" type="password" id="key-activation" name="<?php echo WOODKIT_CONFIG_OPTIONS.'[key-activation]'; ?>" value="<?php echo esc_attr($value); ?>" />
								<?php if (!$this->site_registered){ ?>
									<span class="invalid-key"><i class="fa fa-times"></i><?php _e("Your key is invalid", 'woodkit'); ?></span>
									<a href="<?php echo esc_url(WOODKIT_CONFIG_GET_KEY_URL); ?>" target="_blank"><?php _e('Get key', 'woodkit'); ?></a>
								<?php }else{ ?>
									<span class="valid-key"><i class="fa fa-check"></i><?php _e("Your site is registered", 'woodkit'); ?></span>
								<?php }	?>
							</div>
							<p class="description"><?php _e("Setup your key to get woodkit updates", 'woodkit'); ?></p>
						</div>
					</div>
					<button type="submit" class="wk-btn primary save">
						<?php _e("Save", 'woodkit'); ?>
					</button>
				</div>
    		</form>
    		
    		
    		<div class="wk-panel">
				<h2 class="wk-panel-title"><?php _e("Outils", 'woodkit'); ?></h2>
				<div class="wk-panel-content">
    				<table class="wp-list-table widefat plugins">
						<thead>
							<tr>
								<td id="cb" class="manage-column column-cb check-column"></td>
								<th scope="col" id="name" class="manage-column column-name column-primary"><?php _e("Tool name", 'woodkit'); ?></th>
								<th scope="col" id="description" class="manage-column column-description"><?php _e("Description", 'woodkit'); ?></th>
								<th scope="col" id="source" class="manage-column column-source"><?php _e("Source", 'woodkit'); ?></th>
								<th scope="col" id="documentation" class="manage-column column-documentation"><?php _e("Doc.", 'woodkit'); ?></th>
							</tr>
						</thead>
						<tbody id="the-list">
							<?php $tools = $GLOBALS['woodkit']->tools->get_tools();
							foreach ($tools as $tool){
								$active = $tool->is_activated(); ?>
								<tr class="<?php echo $active == true ? 'active' : 'inactive'?>">
									<th scope="row" class="check-column"></th>
									<td class="plugin-title column-primary">
										<strong><?php echo $tool->name; ?></strong>
										<div class="row-actions visible">
											<span class="0">
												<?php if ($active == true && $tool->has_config){ ?>
												<a href="<?php echo menu_page_url("woodkit_options_tool_".$tool->slug, false); ?>"><?php _e("Setup", 'woodkit'); ?></a> |
												<?php } ?> 
											</span>
											<?php 
											if ($active == true){
												?>
												<span class="deactivate">
													<?php $deactivate_url = $this->self_url.'&action=deactivate&tool='.$tool->slug.'&'.self::$nonce_name.'='.$this->nonce_action.'&time='.time(); ?>
													<a href="<?php echo $deactivate_url; ?>" aria-label="<?php echo esc_attr(__("Deactivate", 'woodkit')); ?>"><?php _e("Deactivate", 'woodkit'); ?></a>
												</span>
												<?php
											}else{
												?>
												<span class="activate">
													<?php $activate_url = $this->self_url.'&action=activate&tool='.$tool->slug.'&'.self::$nonce_name.'='.$this->nonce_action.'&time='.time(); ?>
													<a href="<?php echo $activate_url; ?>" aria-label="<?php echo esc_attr(__("Activate", 'woodkit')); ?>"><?php _e("Activate", 'woodkit'); ?></a>
												</span>
												<?php
											}
											?>
										</div>
									</td>
									<td class="column-description desc">
										<div class="plugin-description">
											<p><?php echo $tool->description; ?></p>
										</div>
									</td>
									<td class="column-source">
										<div class="plugin-source">
											<?php if (!$tool->is_core) {
												echo !empty($tool->context) ? 'addons (' . $tool->context . ')' : 'addons (unknown)';
											} else {
												echo !empty($tool->context) ? 'Woodkit (' . $tool->context . ')' : 'Woodkit';
											} ?>
										</div>
									</td>
									<td class="column-documentation">
										<div class="plugin-documentation">
											<a class="tool-documentation" href="<?php echo esc_url($tool->documentation_url); ?>" target="_blank">
												<i class="fa fa-info-circle"></i>
											</a>
										</div>
									</td>
								</tr>
								<?php 
							} ?>
						</tbody>
						<tfoot>
							<tr>
								<td class="manage-column column-cb check-column"></td>
								<th scope="col" class="manage-column column-name column-primary"><?php _e("Tool name", 'woodkit'); ?></th>
								<th scope="col" class="manage-column column-description"><?php _e("Description", 'woodkit'); ?></th>
								<th scope="col" class="manage-column column-source"><?php _e("Source", 'woodkit'); ?></th>
								<th scope="col" class="manage-column column-documentation"><?php _e("Doc.", 'woodkit'); ?></th>
							</tr>
						</tfoot>
					</table>
    			</div>
    		</div>
		</div>
		<?php
	}
}