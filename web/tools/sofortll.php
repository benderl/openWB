<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/openWB/web/settings/settingsClass.php';

if(isset($_POST['lademlp1'])) {
	$mySettings = new openWBSettings();
	$mySettings->setSettings($_POST);
	$mySettings->saveConfigFile();
}
print_r($_POST);
header ("Refresh: 10; ../index.php");
//header("Location: ../index.php");
?>
