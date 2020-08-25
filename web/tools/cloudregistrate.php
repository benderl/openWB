<?php
require_once '../settings/settingsClass.php';
$mySettings = new openWBSettings();

if (isset($_POST['email'])) {
	# Our new data
	$data = array(
		'username' => $_POST['username'],
		'email' => $_POST['email']
	);
	# Create a connection
	$url = 'https://web.openwb.de/php/localregistrate.php';
	$ch = curl_init($url);
	# Form data string
	$postString = http_build_query($data)."\n";
	# Setting our options
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	# Get the response
	$response = curl_exec($ch);
	curl_close($ch);
} else {
	$response = $_POST['username'].','.$_POST['cloudpass'];
}
if ( $response == "nomail" ) {
	$message = "Keine gültige Email angegeben, Weiterleitung erfolgt in 10 Sekunden...";
	header( "refresh:10;url='../settings/cloudconfig.php" );
} elseif ( $response == "maildoesnotexist" ) {
	$message = "Keine Email angegeben, dies ist eine Pflichtangabe! Weiterleitung erfolgt in 10 Sekunden...";
	header( "refresh:10;url='../settings/cloudconfig.php" );
} elseif ( $response == "usernamenotvalid" ) {
	echo "Kein gültiger Benutzername, dieser darf nur Buchstaben enthalten, keine -,. Zahlen oder Leerzeichen. Weiterleitung erfolgt in 10 Sekunden...";
	header( "refresh:10;url='../settings/cloudconfig.php" );
} elseif ( $response == "usernameempty" ) {
	$message = "Kein Benutzername angegeben. Weiterleitung erfolgt in 10 Sekunden...";
	header( "refresh:10;url='../settings/cloudconfig.php" );
} else {
	$upass = explode(',', $response);
	$clouduser = $upass[0];
	$cloudpw = $upass[1];

	$mySettings->setSettings(
		array(
			"clouduser" => $clouduser,
			"cloudpw" => $clouduser
		)
	);
	$mySettings->saveConfigFile();

	$url = $_SERVER['HTTP_HOST'].'/openWB/web/tools/savemqtt.php?bridge=cloud';
	$data = array(
		'ConnectionName' => 'cloud',
		'bridgeEnabled' => '1',
		'RemoteAddress' => 'web.openwb.de:1883',
		'RemoteUser' => $clouduser,
		'RemotePass' => $cloudpw,
		'RemotePrefix' => $clouduser.'/',
		'mqttProtocol' => 'mqttv311',
		'tlsProtocol' => 'tlsv1.2',
		'exportStatus' => 'true',
		'exportGraph' => 'true',
		'subscribeConfigs' => 'true',
		'username' => $_POST['username']
	);
	$ch = curl_init($url);
	# Form data string
	$postString = http_build_query($data)."\n";
	# Setting our options
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	# Get the response
	$response = curl_exec($ch);
	curl_close($ch);
	$message = 'Account angelegt, Weiterleitung erfolgt automatisch';
	header( "refresh:5;url='../settings/cloudconfig.php" );
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
	<title>openWB Cloud Account</title>
</head>
<body>
	<p>
		<?php echo $message; ?>
	</p>
</body>
</html>
