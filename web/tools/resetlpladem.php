<?php
require_once './ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

if($_POST['action'] == 'resetlp1') {
	$myRamdisk->setData('gelrlp1', 0);
	$myRamdisk->setData('aktgeladen', 0);
}
if($_POST['action'] == 'resetlp2') {
	$myRamdisk->setData('gelrlp2', 0);
	$myRamdisk->setData('aktgeladens1', 0);
}
if($_POST['action'] == 'resetlp3') {
	$myRamdisk->setData('gelrlp3', 0);
	$myRamdisk->setData('aktgeladens2', 0);
}
?>
