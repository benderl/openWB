<!doctype html>
<html lang="de">
	<head>
		<title>EVSE-Konfiguration</title>
	</head>
	<body>
		<h1>
			Achtung, Experteneinstellung!<br>
			Änderung grundsätzlich nicht nötig!
		</h1>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/openWB/web/tools/ramdiskClass.php';
$myRamdisk = new openWBRamdisk();
?>
		<hr>
		<form action="/openWB/web/tools/changeevseconfig.php" method="post">
			<div class="row bg-info">
				<div class="col-xs-4 text-center bg-info">
					<h2>Ladepunkt 1:</h2>
					<p>
						Stromstärke nach Neustart bis die openWB die Kontrolle übernimmt (Notfall Modus):<br>
						<input type="text" name="lp12000" value="<?php echo $myRamdisk->getData('progevsedinlp12000'); ?>" id="lp12000"><br>
						Maximale hard codierte Stromstärke in der EVSE: <br>Gültige Werte: 0 = Per Widerstand PE/PP festgelegt, 6-32A fix<br>
						<input type="text" name="lp12007" value="<?php echo $myRamdisk->getData('progevsedinlp12007'); ?>" id="lp12007">
					</p>
					<div class="col-xs-2 text-center bg-info">
						<input type="submit" name="evselp1" value="Speichern" >
					</div>
				</div>
			</div>
			<hr>
			<div class="row bg-info">
				<div class="col-xs-4 text-center bg-info">
					<h2>Ladepunkt 2:</h2>
					<p>
						Stromstärke nach Neustart bis die openWB die Kontrolle übernimmt (Notfall Modus):<br>
						<input type="text" name="lp22000" value="<?php echo $myRamdisk->getData('progevsedinlp22000'); ?>" id="lp22000"><br>
						Maximale hard codierte Stromstärke in der EVSE: <br>Gültige Werte: 0 = Per Widerstand PE/PP festgelegt, 6-32A fix<br>
						<input type="text" name="lp22007" value="<?php echo $myRamdisk->getData('progevsedinlp22007'); ?>" id="lp22007">
					</p>
					<div class="col-xs-2 text-center bg-info">
						<input type="submit" name="evselp2" value="Speichern" >
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
