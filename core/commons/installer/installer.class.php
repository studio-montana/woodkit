<?php

require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_INSTALLER_FOLDER.'plugin-uploader.class.php');
if (is_admin()){
    new WoodkitPluginUploader(WP_PLUGIN_DIR.'/woodkit/woodkit.php');
}

require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_INSTALLER_FOLDER.'theme-uploader.class.php');
if (is_admin()){
    new WoodkitThemeUploader('woody');
}

?>