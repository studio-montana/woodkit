<?php

require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_INSTALLER_FOLDER.'uploader.class.php');
if (is_admin()){
    new WoodkitPluginUploader(WP_PLUGIN_DIR."/woodkit/woodkit.php", "woodkit");
    // new WoodkitPluginUploader(WP_PLUGIN_DIR."/woodcars/woodcars.php", "woodcars");
}

?>