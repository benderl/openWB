<?php
require_once '../settings/settingsClass.php';
$mySettings = new openWBSettings();

require_once './ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

$returnPage = "Location: ../display.php";

if (isset($_GET['jetzt'])) {
	if ($_GET['jetzt'] == "1") {
		$config['lademodus'] = '0';
		$myRamdisk->setData('lademodus', 0);
		header($returnPage);
	}
}
if (isset($_GET['minundpv'])) {
	if ($_GET['minundpv'] == "1") {
		$config['lademodus'] = '1';
		$myRamdisk->setData('lademodus', 1);
		header($returnPage);
	}
}
if (isset($_GET['pvuberschuss'])) {
	if ($_GET['pvuberschuss'] == "1") {
		$config['lademodus'] = '2';
		$myRamdisk->setData('lademodus', 2);
		header($returnPage);
	}
}
if (isset($_GET['stop'])) {
	if ($_GET['stop'] == "1") {
		$config['lademodus'] = '3';
		$myRamdisk->setData('lademodus', 3);
		header($returnPage);
	}
}
if (isset($_GET['semistop'])) {
	if ($_GET['semistop'] == "1") {
		$config['lademodus'] = '4';
		$myRamdisk->setData('lademodus', 4);
		header($returnPage);
	}
}
if (isset($_GET['pveinbeziehen'])) {
	if ($_GET['pveinbeziehen'] == "1") {
		$mySettings->setSetting('speicherpveinbeziehen', 1);
	} else {
		$mySettings->setSetting('speicherpveinbeziehen', 0);
	}
	$mySettings->saveConfigFile();
	header($returnPage);
}
/*
if (isset($_GET['sofortlllp1'])) {
	$mySettings->setSetting('sofortll', $_GET['sofortlllp1']);
	$mySettings->saveConfigFile();
	header($returnPage);
}
 */
header($returnPage);
?>
