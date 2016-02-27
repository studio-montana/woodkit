<?php

require_once (WOODKIT_PLUGIN_PATH.'/'.WOODKIT_PLUGIN_INSTALLER_FOLDER.'uploader.class.php');
if (is_admin()){
    new WoodkitUploader(WOODKIT_PLUGIN_FILE, WOODKIT_PLUGIN_NAME);
}

?>