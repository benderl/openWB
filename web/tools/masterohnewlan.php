<?php
exec("sudo /var/www/html/openWB/runs/masterohnewlan.sh");

require_once '../settings/settingsClass.php';
$mySettings = new openWBSettings();
$mySettings->setSetting("displayconfigured", 1);
$mySettings->saveConfigFile();
?>
