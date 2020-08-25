<?php
require_once './ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

$result = '';

if (filter_var($_POST['emailAddress'], FILTER_VALIDATE_EMAIL) && strlen($_POST['debugMessage'])>20) {
	$result = $_POST['debugMessage'] . "\n" . $_POST['emailAddress'] . "\n";
	$myRamdisk->setData('debuguser', $result);
	header("Location: ./debugredirect.html");
} else {
	header ("Refresh: 10; ../index.php");
	?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<title>Weiterleitung</title>
	</head>
	<body>
		<h1>Keine gültige Email angegeben oder Fehlerbeschreibung zu kurz</h1>
		<p>Weiterleitung in 10 Sekunden...</p>
	</body>
</html>
	<?php
}
?>
