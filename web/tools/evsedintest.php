<?php
require_once './ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

if(isset($_POST["testlp1"])) {
	$myRamdisk->setData('evsedintestlp1', 'ausstehend');
}
if(isset($_POST["testlp2"])) {
	$myRamdisk->setData('evsedintestlp2', 'ausstehend');
}
if(isset($_POST["testlp3"])) {
	$myRamdisk->setData('evsedintestlp3', 'ausstehend');
}

header("Location: ../status/status.php");
?>
