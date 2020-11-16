<?php
file_put_contents('/var/www/html/openWB/ramdisk/wssid',$_POST['ssid']);
file_put_contents('/var/www/html/openWB/ramdisk/wpassword',$_POST['passwort']);
if( !isset($_POST['hidden']) ){
	$_POST['hidden'] = 0;
}
file_put_contents('/var/www/html/openWB/ramdisk/whidden',$_POST['hidden']);

exec('sudo /bin/bash /var/www/html/openWB/runs/wlanconnect.sh');
?>
