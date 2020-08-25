<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/openWB/web/tools/ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

if(isset($_POST["evselp1"])) {
	$dataArray = array(
		"progevsedinlp1" => 1,
		"progevsedinlp12000" => $_POST['lp12000'],
		"progevsedinlp12007" => $_POST['lp12007']
	);
	$myRamdisk->setDataArray($dataArray);
}
if(isset($_POST["evselp2"])) {
	$dataArray = array(
		"progevsedinlp2" => 1,
		"progevsedinlp22000" => $_POST['lp22000'],
		"progevsedinlp22007" => $_POST['lp22007']
	);
	$myRamdisk->setDataArray($dataArray);
}
header("Location: ../index.php");
?>
