<?php
require_once './ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

$myRamdisk->setDataArray(
	array(
		'wssid' => $_POST['ssid'],
		'wpassword' => $_POST['password']
	)
);

exec('sudo /bin/bash /var/www/html/openWB/runs/wlanconnect.sh');
?>
