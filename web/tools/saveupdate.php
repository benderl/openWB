<!DOCTYPE html>
<html lang="de">
	<head>
		<title>Update wird gestartet</title>
	</head>
	<body>
		<p>Einstellungen werden gespeichert...</p>
		<?php
			// receives chosen releasetrain from update-page via POST-request,
			// writes value to config file and start update
			// author: M. Ortenstein

			// get settings
			require_once '../settings/settingsClass.php';
			$mySettings = new openWBSettings();
			$mySettings->setSettings($_POST);
			$mySettings->saveConfigFile();

			// start update
		?>
		<script>window.location.href='./update.php';</script>
	</body>
</html>
