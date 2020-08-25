<!DOCTYPE html>
<html lang="de">

	<head>
		<base href="/openWB/web/">

		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>openWB Einstellungen</title>
		<meta name="description" content="Control your charge" />
		<meta name="author" content="Michael Ortenstein" />
		<!-- Favicons (created with http://realfavicongenerator.net/)-->
		<link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-touch-icon-60x60.png">
		<link rel="icon" type="image/png" href="img/favicons/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="img/favicons/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="manifest.json">
		<link rel="shortcut icon" href="img/favicons/favicon.ico">
		<meta name="msapplication-TileColor" content="#00a8ff">
		<meta name="msapplication-config" content="img/favicons/browserconfig.xml">
		<meta name="theme-color" content="#ffffff">

		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap-4.4.1/bootstrap.min.css">
		<!-- Normalize -->
		<link rel="stylesheet" type="text/css" href="css/normalize-8.0.1.css">
		<!-- include settings-style -->
		<link rel="stylesheet" type="text/css" href="settings/settings_style.css">

		<!-- important scripts to be loaded -->
		<script src="js/jquery-3.4.1.min.js"></script>
		<script src="js/bootstrap-4.4.1/bootstrap.bundle.min.js"></script>
	</head>

	<body>

		<?php
			include $_SERVER['DOCUMENT_ROOT'].'/openWB/web/settings/navbar.php';

			// get settings
			require_once $_SERVER['DOCUMENT_ROOT'].'/openWB/web/settings/settingsClass.php';
			$mySettings = new openWBSettings();

			function getFolders($modulesDir){
				foreach( array_diff(scandir($modulesDir),array('.','..') ) as $subDir ) {
					if ( is_dir($modulesDir.'/'.$subDir) ) {
						$dirList[] = $subDir;
					}
				}
				return $dirList;
			}

			function loadModules($modulesDir){
				$dirList = getFolders($modulesDir);
				$modules = array();
				foreach( $dirList as $subDir ) {
					$moduleClassFile = $modulesDir.'/'.$subDir.'/'.$subDir.'.class.php';
					$className = "openWBModule_".$subDir;
					if( file_exists( $moduleClassFile ) ) {
						require_once $moduleClassFile;
						if( class_exists("openWBModule_".$subDir) ) {
							$modules[$className] = new $className();
						}
					}
				}
				return $modules;
			}

			function printDebugInfo(){
				global $myModules;
				echo "<pre>\n";
				//print_r( $myModules );
				foreach( $myModules as $moduleName => $module ){
					echo $moduleName.": ".$module->getName()." (".$module->getId().")\n";
				}
				echo "</pre>\n";
			}
			$myModules = loadModules($_SERVER['DOCUMENT_ROOT'].'/openWB/modules');
		?>

		<div role="main" class="container" style="margin-top:20px">
			<div class="col-sm-12">
				<?php printDebugInfo(); ?>
				<form action="settings/savepostsettings.php" method="POST">
					<div class="row">
						<div class="col">
							<h1> Erster Ladepunkt </h1>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<b><label for="lp1name">Name Ladepunkt 1:</label></b>
							<input type="text" name="lp1name" id="lp1name" value="<?php echo $mySettings->getSetting('lp1name') ?>">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<b><label for="evsecon">Anbindung Ladepunkt 1:</label></b>
							<select name="evsecon" id="evsecon">
								<option <?php if($mySettings->getSetting('evsecon') == "modbusevse" && !($mySettings->getSetting('ladeleistungmodul') == "mpm3pmll" && $mySettings->getSetting('mpm3pmllsource') == "/dev/ttyUSB0" && ($mySettings->getSetting('mpm3pmllid') == "5" || $mySettings->getSetting('mpm3pmllid') == "105"))) echo "selected" ?> value="modbusevse">Modbusevse</option>
								<option <?php if($mySettings->getSetting('evsecon') == "dac") echo "selected" ?> value="dac">DAC</option>
								<option <?php if($mySettings->getSetting('evsecon') == "simpleevsewifi") echo "selected" ?> value="simpleevsewifi">SimpleEVSEWifi</option>
								<option <?php if($mySettings->getSetting('evsecon') == "goe") echo "selected" ?> value="goe">Go-e</option>
								<option <?php if($mySettings->getSetting('evsecon') == "nrgkick") echo "selected" ?> value="nrgkick">NRGKick + Connect</option>
								<option <?php if($mySettings->getSetting('evsecon') == "masterethframer") echo "selected" ?> value="masterethframer">openWB Ladepunkt in Verbindung mit Standalone</option>
								<option <?php if($mySettings->getSetting('evsecon') == "twcmanager") echo "selected" ?> value="twcmanager">Tesla TWC mit TWCManager</option>
								<option <?php if($mySettings->getSetting('evsecon') == "keba") echo "selected" ?> value="keba">Keba</option>
								<option <?php if($mySettings->getSetting('evsecon') == "modbusevse" && $mySettings->getSetting('ladeleistungmodul') == "mpm3pmll" && $mySettings->getSetting('mpm3pmllsource') == "/dev/ttyUSB0" && $mySettings->getSetting('mpm3pmllid') == "5") echo "selected" ?> value="openwb12">openWB series1/2</option>
								<option <?php if($mySettings->getSetting('evsecon') == "modbusevse" && $mySettings->getSetting('ladeleistungmodul') == "mpm3pmll" && $mySettings->getSetting('mpm3pmllsource') == "/dev/ttyUSB0" && $mySettings->getSetting('mpm3pmllid') == "105") echo "selected" ?> value="openwb12mid">openWB series1/2 mit geeichtem Zähler</option>
								<option <?php if($mySettings->getSetting('evsecon') == "ipevse") echo "selected" ?> value="ipevse">openWB Satellit </option>
							</select>
						</div>
					</div>
					<div id="evseconmastereth">
						<div class="row bg-success">
							Keine Konfiguration erforderlich.
						</div>
					</div>
					<div id="openwb12">
						<div class="row bg-success">
							Keine Konfiguration erforderlich.<br>
							Dies ist die richtige Option, sowohl für Bausatz als auch für fertige openWB series1 oder series2.
						</div>
					</div>
					<div id="openwb12mid">
						<div class="row bg-success">
							Keine Konfiguration erforderlich.<br>
							Dies ist die richtige Option, sowohl für Bausatz als auch für fertige openWB series1 oder series2 mit geeichtem Zähler.
						</div>
					</div>
					<div id="evsecondac">
						<div class="row bg-success">
							<b><label for="dacregister">Dacregister:</label></b>
							<input type="text" name="dacregister" id="dacregister" value="<?php echo $mySettings->getSetting('dacregister') ?>"><br>
							Gültige Werte 0-99. Bei EVSE Anbindung per DAC (MCP 4725) Standardwert meist 62, oft auch 60 oder 48. Abhängig vom verbauten MCP<br>
							Der benötigte Wert sollte <a href="../ramdisk/i2csearch">HIER</a> zu finden sein.<br>
							Alternativ rauszufinden bei angeschlossenem MCP auf der shell mit dem Befehl: "sudo i2cdetect -y 1"
						</div>
					</div>
					<div id="evseconswifi">
						<div class="row bg-info">
							<div class="col">
								<b><label for="evsewifiiplp1">Simple EVSE Wifi IP Adressee:</label></b>
								<input type="text" name="evsewifiiplp1" id="evsewifiiplp1" value="<?php echo $mySettings->getSetting('evsewifiiplp1') ?>">
							</div>
						</div>
						<div class="row bg-info">
							<div class="col">
								Gültige Werte IP Adresse im Format: 192.168.0.12
							</div>
						</div>
						<div class="row bg-info">
							<div class="col">
								<b><label for="evsewifitimeoutlp1">Simple EVSE Wifi Timeout:</label></b>
								<input type="text" name="evsewifitimeoutlp1" id="evsewifitimeoutlp1" value="<?php echo $mySettings->getSetting('evsewifitimeoutlp1') ?>">
							</div>
						</div>
						<div class="row bg-info">
							<div class="col">
								Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort der Simple EVSE gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
								Zulange Wartezeit zieht einen Verzug der Regellogik von openWB mit sich wenn die SimpleEVSE z.B. gerade unterwegs genutzt wird.
							</div>
						</div>
					</div>
					<div id="evseconmod">
						<div class="row bg-info">
							<b><label for="modbusevsesource">EVSE Source:</label></b>
							<input type="text" name="modbusevsesource" id="modbusevsesource" value="<?php echo $mySettings->getSetting('modbusevsesource') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte /dev/ttyUSB0, /dev/virtualcom0. Serieller Port an dem der Modbus der EVSE angeschlossen ist.
						</div>
						<div class="row bg-info">
							<b><label for="modbusevseid">EVSE ID:</label></b>
							<input type="text" name="modbusevseid" id="modbusevseid" value="<?php echo $mySettings->getSetting('modbusevseid') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID der EVSE.
						</div>
						<div class="row bg-info">
							<b><label for="modbusevselanip">RS485/Lan-Konverter IP:</label></b>
							<input type="text" name="modbusevselanip" id="modbusevselanip" value="<?php echo $mySettings->getSetting('modbusevselanip') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP. IP Adresse des Modbus/Lan Konverter. Vermutlich gleich der IP des SDM Zählers in der WB.
						</div>
					</div>
					<div id="evseconipevse">
						<div class="row bg-info">
							<b><label for="evseiplp1">IP Adresse:</label></b>
							<input type="text" name="evseiplp1" id="evseiplp1" value="<?php echo $mySettings->getSetting('evseiplp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP. Aufgedruckt auf dem Label der openWB.
						</div>
						<div class="row bg-info">
							<b><label for="evseidlp1">EVSE ID:</label></b>
							<input type="text" name="evseidlp1" id="evseidlp1" value="<?php echo $mySettings->getSetting('evseidlp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Aufgedruckt auf dem Label der openWB.
						</div>
					</div>
					<div id="evseconkeba">
						<div class="row bg-info">
							<b><label for="kebaiplp1">Keba IP Adresse:</label></b>
							<input type="text" name="kebaiplp1" id="kebaiplp1" value="<?php echo $mySettings->getSetting('kebaiplp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse im Format: 192.168.0.12<br>
							Erforder eine Keba C- oder X- Series. Die Smart Home Funktion (UDP Schnittstelle) muss per DIP Switch in der Keba aktiviert sein!
						</div>
					</div>
					<div id="evsecontwcmanager">
						<div class="row bg-info">
							<b><label for="twcmanagerlp1ip">TWCManager IP Adresse:</label></b>
							<input type="text" name="twcmanagerlp1ip" id="twcmanagerlp1ip" value="<?php echo $mySettings->getSetting('twcmanagerlp1ip') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse im Format: 192.168.0.12
						</div>
						<div class="row bg-info">
							<b><label for="twcmanagerlp1phasen">TWCManager Anzahl Phasen:</label></b>
							<input type="text" name="twcmanagerlp1phasen" id="twcmanagerlp1phasen" value="<?php echo $mySettings->getSetting('twcmanagerlp1phasen') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte Zahl. Definiert die genutzte Anzahl der Phasen zur korrekten Errechnung der Ladeleistung (BETA)
						</div>
					</div>
					<div id="evsecongoe">
						<div class="row bg-info">
							<b><label for="goeiplp1">Go-e IP Adresse:</label></b>
							<input type="text" name="goeiplp1" id="goeiplp1" value="<?php echo $mySettings->getSetting('goeiplp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse im Format: 192.168.0.12
						</div>
						<div class="row bg-info">
							<b><label for="goetimeoutlp1">Go-e Timeout:</label></b>
							<input type="text" name="goetimeoutlp1" id="goetimeoutlp1" value="<?php echo $mySettings->getSetting('goetimeoutlp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort des Go-echargers gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
							Eine zu große Wartezeit zieht einen Verzug der Regellogik von openWB mit sich, wenn der Go-echarger z.B. gerade unterwegs genutzt wird.
						</div>
					</div>
					<div id="evseconnrgkick">
						<div class="row bg-info">
							<b><label for="nrgkickiplp1">NRGKick IP Adresse:</label></b>
							<input type="text" name="nrgkickiplp1" id="nrgkickiplp1" value="<?php echo $mySettings->getSetting('nrgkickiplp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse im Format: 192.168.0.12 Zu finden in der NRGKick App unter Einstellungen -> Info -> NRGkick Connect Infos.
						</div>
						<div class="row bg-info">
							<b><label for="nrgkicktimeoutlp1">NRGKick Timeout:</label></b>
							<input type="text" name="nrgkicktimeoutlp1" id="nrgkicktimeoutlp1" value="<?php echo $mySettings->getSetting('nrgkicktimeoutlp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort des NRGKick Connect gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
							Zulange Wartezeit zieht einen Verzug der Regellogik von openWB mit sich wenn die Go-e z.B. gerade unterwegs genutzt wird.
						</div>
						<div class="row bg-info">
							<b><label for="nrgkickmaclp1">NRGKick MAC Adresse:</label></b>
							<input type="text" name="nrgkickmaclp1" id="nrgkickmaclp1" value="<?php echo $mySettings->getSetting('nrgkickmaclp1') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte MAC Adresse im Format: 11:22:33:AA:BB:CC. Zu finden In der NRGKick App unter Einstellungen -> BLE-Mac.
						</div>
						<div class="row bg-info">
							<b><label for="nrgkickpwlp1">NRGKick PW:</label></b>
							<input type="text" name="nrgkickpwlp1" id="nrgkickpwlp1" value="<?php echo $mySettings->getSetting('nrgkickpwlp1') ?>">
						</div>
						<div class="row bg-info">
							Password welches in der NRGKick App festgelegt wurde.
						</div>
					</div>

					<script>
						function display_lp1() {
							$('#evsecondac').hide();
							$('#evseconmod').hide();
							$('#evseconswifi').hide();
							$('#llmodullp1').hide();
							$('#evsecongoe').hide();
							$('#evseconnrgkick').hide();
							$('#evseconmastereth').hide();
							$('#evseconkeba').hide();
							$('#openwb12').hide();
							$('#openwb12mid').hide();
							$('#evsecontwcmanager').hide();
							$('#evseconipevse').hide();
							if($('#evsecon').val() == 'ipevse') {
								$('#evseconipevse').show();
								$('#llmodullp1').show();
							}
							if($('#evsecon').val() == 'dac') {
								$('#evsecondac').show();
								$('#llmodullp1').show();
							}
							if($('#evsecon').val() == 'modbusevse') {
								$('#evseconmod').show();
								$('#llmodullp1').show();
							}
							if($('#evsecon').val() == 'simpleevsewifi') {
								$('#evseconswifi').show();
							}
							if($('#evsecon').val() == 'goe') {
								$('#evsecongoe').show();
							}
							if($('#evsecon').val() == 'masterethframer') {
								$('#evseconmastereth').show();
							}
							if($('#evsecon').val() == 'nrgkick') {
								$('#evseconnrgkick').show();
							}
							if($('#evsecon').val() == 'keba') {
								$('#evseconkeba').show();
							}
							if($('#evsecon').val() == 'twcmanager') {
								$('#evsecontwcmanager').show();
							}
							if($('#evsecon').val() == 'openwb12') {
								$('#openwb12').show();
							}
							if($('#evsecon').val() == 'openwb12mid') {
								$('#openwb12mid').show();
							}
							if($('#evsecon').val() == 'ipevse') {
								$('#evseconipevse').show();
							}
						}

						$(function() {
							display_lp1();
							$('#evsecon').change(function(){
								display_lp1();
							})
						});
					</script>

					<div id="llmodullp1">
						<div class="row">
							<b><label for="ladeleistungmodul">Ladeleistungmodul:</label></b>
							<select name="ladeleistungmodul" id="ladeleistungmodul">
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "none") echo "selected" ?> value="none">Nicht vorhanden</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "sdm630modbusll") echo "selected" ?> value="sdm630modbusll">SDM 630 Modbus</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "smaemd_ll") echo "selected" ?> value="smaemd_ll">SMA Energy Meter</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "sdm120modbusll") echo "selected" ?> value="sdm120modbusll">SDM 120 Modbus</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "simpleevsewifi") echo "selected" ?> value="simpleevsewifi">Simple EVSE Wifi</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "mpm3pmll") echo "selected" ?> value="mpm3pmll">MPM3PM</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "fsm63a3modbusll") echo "selected" ?> value="fsm63a3modbusll">FSM63A3 Modbus</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "httpll") echo "selected" ?> value="httpll">HTTP</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "mpm3pmtripple") echo "selected" ?> value="mpm3pmtripple">openWB Tripple</option>
								<option <?php if($mySettings->getSetting('ladeleistungmodul') == "mpm3pmlllp1") echo "selected" ?> value="mpm3pmlllp1">openWB Satellit</option>
							</select>
						</div>
						<div id="mpm3pmlllp1div">
							<div class="row bg-info">
								<b><label for="mpmlp1ip">MPM3PM Modbus Ladeleistung IP:</label></b>
								<input type="text" name="mpmlp1ip" id="mpmlp1ip" value="<?php echo $mySettings->getSetting('mpmlp1ip') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP Adresse des Modbus Ethernet Konverters.
							</div>
							<div class="row bg-info">
								<b><label for="mpmlp1id">MPM3PM Modbus Ladeleistung ID:</label></b>
								<input type="text" name="mpmlp1id" id="mpmlp1id" value="<?php echo $mySettings->getSetting('mpmlp1id') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID des MPM3PM.
							</div>
						</div>

						<div id="llmnone">
						</div>
						<div id="httpll">
							<div class="row bg-info" >
								<b><label for="httpll_w_url">Vollständige URL für die Ladeleistungs Watt</label></b>
								<input type="text" name="httpll_w_url" id="httpll_w_url" value="<?php echo htmlspecialchars($mySettings->getSetting('httpll_w_url')) ?>">
							</div>
							<div class="row bg-info" >
								Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als wird der Wert auf null gesetzt. Der Wert muss in Watt sein.
							</div>
							<div class="row bg-info" >
								<b><label for="httpll_kwh_url">Vollständige URL für die Ladeleistungszählerstand in kWh</label></b>
								<input type="text" name="httpll_kwh_url" id="httpll_kwh_url" value="<?php echo htmlspecialchars($mySettings->getSetting('httpll_kwh_url')) ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als wird der Wert auf null gesetzt. Der Wert muss in kWh sein als Trennstelle wird ein Punkt genutzt.
							</div>
							<div class="row bg-info" >
								<b><label for="httpll_a1_url">Vollständige URL für die Ladeleistungs Ampere Phase 1</label></b>
								<input type="text" name="httpll_a1_url" id="httpll_a1_url" value="<?php echo htmlspecialchars($mySettings->getSetting('httpll_a1_url')) ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als wird der Wert auf null gesetzt. Der Wert muss in Ampere sein als Trennstelle wird ein Punkt genutzt.
							</div>
							<div class="row bg-info" >
								<b><label for="httpll_a2_url">Vollständige URL für die Ladeleistungs Ampere Phase 2</label></b>
								<input type="text" name="httpll_a2_url" id="httpll_a2_url" value="<?php echo htmlspecialchars($mySettings->getSetting('httpll_a2_url')) ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als wird der Wert auf null gesetzt. Der Wert muss in Ampere sein als Trennstelle wird ein Punkt genutzt.
							</div>
							<div class="row bg-info" >
								<b><label for="httpll_a3_url">Vollständige URL für die Ladeleistungs Ampere Phase 3</label></b>
								<input type="text" name="httpll_a3_url" id="httpll_a3_url" value="<?php echo htmlspecialchars($mySettings->getSetting('httpll_a3_url')) ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als wird der Wert auf null gesetzt. Der Wert muss in Ampere sein als Trennstelle wird ein Punkt genutzt.
							</div>
						</div>
						<div id="llmpm3pm">
								<div class="row bg-info">
								<b><label for="mpm3pmllsource">MPM3PM Modbus Ladeleistung Source:</label></b>
								<input type="text" name="mpm3pmllsource" id="mpm3pmllsource" value="<?php echo $mySettings->getSetting('mpm3pmllsource') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der MPM3PM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
								Nach Ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich.
							</div>
							<div class="row bg-info">
								<b><label for="mpm3pmllid">MPM3PM Modbus Ladeleistung ID:</label></b>
								<input type="text" name="mpm3pmllid" id="mpm3pmllid" value="<?php echo $mySettings->getSetting('mpm3pmllid') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID des MPM3PM.
							</div>
						</div>
						<div id="llmfsm">
							<div class="row bg-info">
								<b><label for="fsm63a3modbusllsource">Zähler Source:</label></b>
								<input type="text" name="fsm63a3modbusllsource" id="fsm63a3modbusllsource" value="<?php echo $mySettings->getSetting('fsm63a3modbusllsource') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der fsm63a3 in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
								Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich.
							</div>
							<div class="row bg-info">
								<b><label for="fsm63a3modbusllid">Zähler ID:</label></b>
								<input type="text" name="fsm63a3modbusllid" id="fsm63a3modbusllid" value="<?php echo $mySettings->getSetting('fsm63a3modbusllid') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID des fsm63a3.
							</div>
						</div>
						<div id="llmsdm">
							<div class="row bg-info">
								<b><label for="sdm630modbusllsource">Zähler Source:</label></b>
								<input type="text" name="sdm630modbusllsource" id="sdm630modbusllsource" value="<?php echo $mySettings->getSetting('sdm630modbusllsource') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der SDM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
								Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich.
							</div>
							<div class="row bg-info">
								<b><label for="sdm630modbusllid">Zähler ID:</label></b>
								<input type="text" name="sdm630modbusllid" id="sdm630modbusllid" value="<?php echo $mySettings->getSetting('sdm630modbusllid') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID des SDM. Für SDM230 & SDM630v2.
							</div>
						</div>
						<div id="sdm120div">
							<div class="row bg-info">
								<b><label for="sdm120modbusllsource">Zähler Source:</label></b>
								<input type="text" name="sdm120modbusllsource" id="sdm120modbusllsource" value="<?php echo $mySettings->getSetting('sdm120modbusllsource') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der SDM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
								Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich.
							</div>

							<div class="row bg-info">
								<b><label for="sdm120modbusllid1">SDM 120 Zähler 1 ID:</label></b>
								<input type="text" name="sdm120modbusllid1" id="sdm120modbusllid1" value="<?php echo $mySettings->getSetting('sdm120modbusllid1') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID des Ladepunkt 1 SDM Zählers in der WB.
							</div>
							<div class="row bg-info">
								<b><label for="sdm120modbusllid2">SDM 120 Zähler 2 ID:</label></b>
								<input type="text" name="sdm120modbusllid2" id="sdm120modbusllid2" value="<?php echo $mySettings->getSetting('sdm120modbusllid2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID des Ladepunkt 1 SDM Zählers 2 in der WB.  Ist keine zweite Phase / SDM120 vorhanden bitte none eintragen.
							</div>
							<div class="row bg-info">
								<b><label for="sdm120modbusllid3">SDM 120 Zähler 3 ID:</label></b>
								<input type="text" name="sdm120modbusllid3" id="sdm120modbusllid3" value="<?php echo $mySettings->getSetting('sdm120modbusllid3') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID des Ladepunkt 1 SDM Zählers 3 in der WB. Ist keine dritte Phase / SDM120 vorhanden bitte none eintragen.
							</div>
						</div>
						<div id="rs485lanlp1">
							<div class="row bg-info">
								<b><label for="sdm630modbuslllanip">RS485/Lan-Konverter IP:</label></b>
								<input type="text" name="sdm630modbuslllanip" id="sdm630modbuslllanip" value="<?php echo $mySettings->getSetting('sdm630modbuslllanip') ?>">
							</div>
							<div class="row bg-info">
								Ist nur von Belang, wenn die Source auf /dev/virtualcomX steht. Ansonsten irrelevant.<br>
								Gültige Werte: IPs. Wenn ein LAN Konverter genutzt wird, muss die Source auf /dev/virtualcomx (z.B. /dev/virtualcom0) gesetzt werden.

							</div>
						</div>
						<div id="llswifi">
							<div class="row">
								Keine Konfiguration erforderlich.
							</div>
						</div>
						<div id="llsma">
							<div class="row">
								<b><label for="smaemdllid">Seriennummer des SMA Energy Meter</label></b>
								<input type="text" name="smaemdllid" id="smaemdllid" value="<?php echo $mySettings->getSetting('smaemdllid'); ?>">
							</div>
							<div class="row">
								Gültige Werte: Seriennummer. Hier die Seriennummer des SMA Meter für die Ladeleistung angeben<br>
								Infos zum SMA Energy Meter <a href="https://github.com/snaptec/openWB#extras">HIER</a>

							</div>
						</div>
					</div>

					<script>
						function display_llmp1() {
							$('#llmnone').hide();
							$('#llmsdm').hide();
							$('#llmpm3pm').hide();
							$('#llswifi').hide();
							$('#llsma, #sdm120div').hide();
							$('#rs485lanlp1').hide();
							$('#llmfsm').hide();
							$('#httpll').hide();
							$('#mpm3pmlllp1div').hide();


							if($('#ladeleistungmodul').val() == 'mpm3pmlllp1') {
								$('#mpm3pmlllp1div').show();
								$('#rs485lanlp1').hide();

							}
							if($('#ladeleistungmodul').val() == 'none') {
								$('#llmnone').show();
							}
							if($('#ladeleistungmodul').val() == 'mpm3pmtripple') {
								$('#llmnone').show();
							}

							if($('#ladeleistungmodul').val() == 'httpll') {
								$('#httpll').show();
							}

							if($('#ladeleistungmodul').val() == 'sdm630modbusll') {
								$('#llmsdm').show();
								$('#rs485lanlp1').show();
							}
							if($('#ladeleistungmodul').val() == 'smaemd_ll') {
								$('#llsma').show();
							}
							if($('#ladeleistungmodul').val() == 'sdm120modbusll') {
								$('#sdm120div').show();
								$('#rs485lanlp1').show();
							}
							if($('#ladeleistungmodul').val() == 'simpleevsewifi') {
								$('#llswifi').show();
							}
							if($('#ladeleistungmodul').val() == 'mpm3pmll') {
								$('#llmpm3pm').show();
								$('#rs485lanlp1').show();
							}
							if($('#ladeleistungmodul').val() == 'fsm63a3modbusll') {
								$('#rs485lanlp1').show();
								$('#llmfsm').show();
							}
						}

						$(function() {
							display_llmp1();
							$('#ladeleistungmodul').change(function(){
								display_llmp1();
							});
						});
					</script>

					<div class="row">
						<b><label for="socmodul">SOC Modul:</label></b>
						<select name="socmodul" id="socmodul">
							<option <?php if($mySettings->getSetting('socmodul') == "none") echo "selected" ?> value="none">Nicht vorhanden</option>
							<?php
							foreach( $myModules as $module ){
								if( $module->getCapabilities()["Ladepunkt SoC"] === true ){
									?>
							<option <?php if($mySettings->getSetting('socmodul') == $module->getId()) echo "selected" ?> value="<?php echo $module->getId(); ?>"><?php echo $module->getName(); ?></option>
									<?php
								}
							}
							?>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_http") echo "selected" ?> value="soc_http">SoC HTTP</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_leaf") echo "selected" ?> value="soc_leaf">SoC Nissan Leaf</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_i3") echo "selected" ?> value="soc_i3">SoC BMW i3</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_zoe") echo "selected" ?> value="soc_zoe">SoC Renault Zoe alt</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_myrenault") echo "selected" ?> value="soc_myrenault">SoC Renault Zoe MyRenault</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_evnotify") echo "selected" ?> value="soc_evnotify">SoC EVNotify</option>
							<!-- <option <?php if($mySettings->getSetting('socmodul') == "soc_tesla") echo "selected" ?> value="soc_tesla">SoC Tesla</option> -->
							<option <?php if($mySettings->getSetting('socmodul') == "soc_carnet") echo "selected" ?> value="soc_carnet">SoC VW Carnet</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_zerong") echo "selected" ?> value="soc_zerong">SoC Zero NG</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_audi") echo "selected" ?> value="soc_audi">SoC Audi</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_mqtt") echo "selected" ?> value="soc_mqtt">MQTT</option>
							<option <?php if($mySettings->getSetting('socmodul') == "soc_bluelink") echo "selected" ?> value="soc_bluelink">Hyundai Bluelink</option>
						</select>
					</div>
					<b><label for="stopsocnotpluggedlp1">SoC nur Abfragen wenn Auto angesteckt:</label></b>
					<select name="stopsocnotpluggedlp1" id="stopsocnotpluggedlp1">
						<option <?php if($mySettings->getSetting('stopsocnotpluggedlp1') == "0") echo "selected" ?> value="0">Nein</option>
						<option <?php if($mySettings->getSetting('stopsocnotpluggedlp1') == "1") echo "selected" ?> value="1">Ja</option>
					</select>
					<div class="row bg-info">
						Wenn Ja gewählt wird der SoC nur abgefragt während ein Auto angesteckt ist.<br>
						Bei Nein wird immer entsprechend der SoC Modul Konfiguration abgefragt.<br>
						Funktioniert nur wenn der "steckend" Status korrekt angezeigt wird.
					</div>
					<div id="socmqtt">
							<div class="row">Keine Konfiguration erforderlich</div>
							<div class="row">Per MQTT zu schreiben:</div>
							<div class="row"><b>"openWB/set/lp/1/%Soc"</b></div>
							<div class="row">Ladezustand in %, int, 0-100</div>
					</div>
					<div id="socmnone">
					</div>
					<?php
					foreach( $myModules as $module ){
						if( $module->getCapabilities()["Ladepunkt SoC"] === true ){
							?>
					<div id="socm_lp1_<?php echo $module->getId(); ?>">
							<?php
							$socSettings = $module->getLadepunktSoCSettingsDefinition();
							foreach( $socSettings as $setting ){
								?>
						<div class="row bg-info">
							<p>
								<?php if( !is_null($setting['inputtype'])) { ?>
								<label style="font-weight: bold;" for="<?php echo $setting['id']; ?>_lp1"><?php echo $setting['label'] ?>: </label>
								<input type="<?php echo $setting['inputtype'] ?>" name="<?php echo $setting['id']; ?>_lp1" id="<?php echo $setting['id']; ?>_lp1" value="<?php echo $mySettings->getSetting($setting['configId']) ?>"><br>
								<?php } ?>
								<?php echo $setting['description']; ?>
							</p>
						</div>
								<?php
							}
							?>
					</div>
							<?php
						}
					}
					?>
					<!--
					<div id="socmtesla">
						<div class="row bg-info">
						</div>
						<div class="row bg-info">
							<b><label for="teslasocuser">Tesla Benutzername:</label></b>
							<input type="text" name="teslasocuser" id="teslasocuser" value="<?php echo $mySettings->getSetting('socteslausername') ?>">
						</div>
						<div class="row bg-info">
							Email Adresse des Tesla Logins
						</div>
						<div class="row bg-info">
							<b><label for="teslasocpw">Tesla Passwort:</label></b>
							<input type="password" name="teslasocpw" id="teslasocpw" value="<?php echo $mySettings->getSetting('socteslapw') ?>">
						</div>
						<div class="row bg-info">
							Password des Tesla Logins
						</div>
						<div class="row bg-info">
							<b><label for="teslasoccarnumber">Auto im Account:</label></b>
							<input type="text" name="teslasoccarnumber" id="teslasoccarnumber" value="<?php echo $mySettings->getSetting('socteslacarnumber') ?>">
						</div>
						<div class="row bg-info">
							Im Normalfall hier 0 eintragen. Sind mehrere Teslas im Account für den zweiten Tesla eine 1 eintragen.
						</div>
						<div class="row bg-info">
							<b><label for="teslasocintervall">Abfrageintervall Standby:</label></b>
							<input type="text" name="teslasocintervall" id="teslasocintervall" value="<?php echo $mySettings->getSetting('socteslaintervall') ?>">
						</div>
						<div class="row bg-info">
							Wie oft der Tesla abgefragt wird wenn nicht geladen wird. Angabe in Minuten.
						</div>
						<div class="row bg-info">
							<b><label for="teslasocintervallladen">Abfrageintervall Laden:</label></b>
							<input type="text" name="teslasocintervallladen" id="teslasocintervallladen" value="<?php echo $mySettings->getSetting('socteslaintervallladen') ?>">
						</div>
						<div class="row bg-info">
							Wie oft der Tesla abgefragt wird während geladen wird. Angabe in Minuten.
						</div>
					</div>
					-->
					<div id="socmbluelink">
						<div class="row bg-info">
						</div>
						<div class="row bg-info">
							<b><label for="soc_bluelink_email">Email Adresse:</label></b>
							<input type="text" name="soc_bluelink_email" id="soc_bluelink_email" value="<?php echo $soc_bluelink_emailold ?>">
						</div>
						<div class="row bg-info">
							Email Adresse des Hyundai Bluelink Logins
						</div>
						<div class="row bg-info">
							<b><label for="soc_bluelink_password">Passwort:</label></b>
							<input type="password" name="soc_bluelink_password" id="soc_bluelink_password" value="<?php echo $soc_bluelink_passwordold ?>">
						</div>
						<div class="row bg-info">
							Password des Logins
						</div>
						<div class="row bg-info">
							<b><label for="soc_bluelink_pin">PIN:</label></b>
							<input type="text" name="soc_bluelink_pin" id="soc_bluelink_pin" value="<?php echo $soc_bluelink_pinold ?>">
						</div>
						<div class="row bg-info">
							PIN des Accounts.
						</div>
						<div class="row bg-info">
							<b><label for="soc_bluelink_interval">Abfrageintervall:</label></b>
							<input type="text" name="soc_bluelink_interval" id="soc_bluelink_interval" value="<?php echo $soc_bluelink_intervalold ?>">
						</div>
						<div class="row bg-info">
							Wie oft abgefragt wird. Angabe in Minuten.
						</div>
					</div>

					<div id="socmzerong">
						<div class="row bg-info">
						</div>
						<div class="row bg-info">
							<b><label for="soc_zerong_username">Zero Benutzername:</label></b>
							<input type="text" name="soc_zerong_username" id="soc_zerong_username" value="<?php echo $mySettings->getSetting('soc_zerong_username') ?>">
						</div>
						<div class="row bg-info">
							Email Adresse des Zero Logins
						</div>
						<div class="row bg-info">
							<b><label for="soc_zerong_password">Zero Passwort:</label></b>
							<input type="password" name="soc_zerong_password" id="soc_zerong_password" value="<?php echo $mySettings->getSetting('soc_zerong_password') ?>">
						</div>
						<div class="row bg-info">
							Password des Zero Logins
						</div>

						<div class="row bg-info">
							<b><label for="soc_zerong_intervall">Abfrageintervall Standby:</label></b>
							<input type="text" name="soc_zerong_intervall" id="soc_zerong_intervall" value="<?php echo $mySettings->getSetting('soc_zerong_intervall') ?>">
						</div>
						<div class="row bg-info">
							Wie oft die Zero abgefragt wird wenn nicht geladen wird. Angabe in Minuten.
						</div>
						<div class="row bg-info">
							<b><label for="soc_zerong_intervallladen">Abfrageintervall Laden:</label></b>
							<input type="text" name="soc_zerong_intervallladen" id="soc_zerong_intervallladen" value="<?php echo $mySettings->getSetting('soc_zerong_intervallladen') ?>">
						</div>
						<div class="row bg-info">
							Wie oft die Zero abgefragt wird während geladen wird. Angabe in Minuten.
						</div>
					</div>
					<div id="socmaudi">
						<div class="row bg-info">
						</div>
						<div class="row bg-info">
							<b><label for="soc_audi_username">Audi Benutzername:</label></b>
							<input type="text" name="soc_audi_username" id="soc_audi_username" value="<?php echo $mySettings->getSetting('soc_audi_username') ?>">
						</div>
						<div class="row bg-info">
							Email Adresse des Audi Logins
						</div>
						<div class="row bg-info">
							<b><label for="soc_audi_passwort">Audi Passwort:</label></b>
							<input type="password" name="soc_audi_passwort" id="soc_audi_passwort" value="<?php echo $mySettings->getSetting('soc_audi_passwort') ?>">
						</div>
						<div class="row bg-info">
							Password des Audi Logins
						</div>
					</div>
					<div id="socmhttp">
						<div class="row bg-info">
						</div>
						<div class="row bg-info">
							<b><label for="hsocip">SOC Http Abfrage URL:</label></b>
							<input type="text" name="hsocip" id="hsocip" value="<?php echo htmlspecialchars($mySettings->getSetting('hsocip')) ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte none, "url". URL für die Abfrage des Soc, Antwort muss der reine Zahlenwert sein.
						</div>
					</div>
					<div id="soczoe">
						<div class="row bg-info">
							<b><label for="zoeusername">Benutzername:</label></b>
							<input type="text" name="zoeusername" id="zoeusername" value="<?php echo $mySettings->getSetting('zoeusername') ?>">
						</div>
						<div class="row bg-info">
							Renault Zoe Benutzername
						</div>
						<div class="row bg-info">
							<b><label for="zoepasswort">Passwort:</label></b>
							<input type="password" name="zoepasswort" id="zoepasswort" value="<?php echo $mySettings->getSetting('zoepasswort') ?>">
						</div>
						<div class="row bg-info">
							Renault Zoe Passwort
						</div>
						<b><label for="wakeupzoelp1">Zoe Remote wecken wenn sie eingeschlafen ist:</label></b>
						<select name="wakeupzoelp1" id="wakeupzoelp1">
							<option <?php if($mySettings->getSetting('wakeupzoelp1') == "0") echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('wakeupzoelp1') == "1") echo "selected" ?> value="1">Ja</option>
						</select>
						<div class="row bg-info">
							Erfordert einen openWB Ladepunkt, Go-e oder Keba. Nicht kompatibel mit EVSE Wifi und SimpleEVSE WB (mit DAC).
						</div>
					</div>
					<div id="socmyrenault">
						<div class="row bg-info">
							<b><label for="myrenault_userlp1">Benutzername:</label></b>
							<input type="text" name="myrenault_userlp1" id="myrenault_userlp1" value="<?php echo $mySettings->getSetting('myrenault_userlp1') ?>">
						</div>
						<div class="row bg-info">
							MyRenault Benutzername
						</div>
						<div class="row bg-info">
							<b><label for="myrenault_passlp1">Passwort:</label></b>
							<input type="password" name="myrenault_passlp1" id="myrenault_passlp1" value="<?php echo $mySettings->getSetting('myrenault_passlp1') ?>">
						</div>
						<div class="row bg-info">
							MyRenault Passwort
						</div>
						<div class="row bg-info">
							<b><label for="myrenault_locationlp1">Standort:</label></b>
							<input type="text" name="myrenault_locationlp1" id="myrenault_locationlp1" value="<?php echo $mySettings->getSetting('myrenault_locationlp1') ?>">
						</div>
						<div class="row bg-info">
							MyRenault Standort, z.B. de_DE
						</div>
						<div class="row bg-info">
							<b><label for="myrenault_countrylp1">Land:</label></b>
							<input type="text" name="myrenault_countrylp1" id="myrenault_countrylp1" value="<?php echo $mySettings->getSetting('myrenault_countrylp1') ?>">
						</div>
						<div class="row bg-info">
							MyRenault Land, z.B. CH, AT, DE
						</div>
						<b><label for="wakeupmyrenaultlp1">Zoe Remote wecken wenn sie eingeschlafen ist:</label></b>
						<select name="wakeupmyrenaultlp1" id="wakeupmyrenaultlp1">
							<option <?php if($mySettings->getSetting('wakeupmyrenaultlp1') == "0") echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('wakeupmyrenaultlp1') == "1") echo "selected" ?> value="1">Ja</option>
						</select>
						<div class="row bg-info">
							Erfordert einen openWB Ladepunkt, Go-e oder Keba. Nicht kompatibel mit EVSE Wifi und SimpleEVSE WB (mit DAC).
						</div>
					</div>
					<div id="socevnotify">
						<div class="row bg-info">
							<b><label for="evnotifyakey">Akey:</label></b>
							<input type="text" name="evnotifyakey" id="evnotifyakey" value="<?php echo $mySettings->getSetting('evnotifyakey') ?>">
						</div>
						<div class="row bg-info">
							Akey des EVNotify Kontos
						</div>
						<div class="row bg-info">
							<b><label for="evnotifytoken">Token:</label></b>
							<input type="text" name="evnotifytoken" id="evnotifytoken" value="<?php echo $mySettings->getSetting('evnotifytoken') ?>">
						</div>
						<div class="row bg-info">
							Token des Kontos
						</div>
					</div>
					<div id="socleaf">
						<div class="row bg-info">
							<b><label for="leafusername">Benutzername:</label></b>
							<input type="text" name="leafusername" id="leafusername" value="<?php echo $mySettings->getSetting('leafusername') ?>">
						</div>
						<div class="row bg-info">
							Nissan Connect Benutzername
						</div>
						<div class="row bg-info">
							<b><label for="leafpasswort">Passwort:</label></b>
							<input type="password" name="leafpasswort" id="leafpasswort" value="<?php echo $mySettings->getSetting('leafpasswort') ?>">
						</div>
						<div class="row bg-info">
							Nissan Connect Passwort
						</div>
					</div>
					<div id="soci3">
						<div class="row bg-info">
							<b><label for="i3username">Benutzername:</label></b>
							<input type="text" name="i3username" id="i3username" value="<?php echo $mySettings->getSetting('i3username') ?>">
						</div>
						<div class="row bg-info">
							BMW Services Benutzername
						</div>
						<div class="row bg-info">
							<b><label for="i3passwort">Passwort:</label></b>
							<input type="password" name="i3passwort" id="i3passwort" value="<?php echo $mySettings->getSetting('i3passwort') ?>">
						</div>
						<div class="row bg-info">
							BMW Services Passwort
						</div>
						<div class="row bg-info">
							<b><label for="i3vin">VIN:</label></b>
							<input type="text" name="i3vin" id="i3vin" value="<?php echo $mySettings->getSetting('i3vin') ?>">
						</div>
						<div class="row bg-info">
							BMW i3 VIN. Sie ist in voller Länge anzugeben.
						</div>
						<div class="row bg-info">
							<b><label for="soci3intervall">Verkürztes Intervall beim Laden:</label></b>
							<input type="text" name="soci3intervall" id="soci3intervall" value="<?php echo $mySettings->getSetting('soci3intervall') ?>">
						</div>
						<div class="row bg-info">
							Verkürzt das Abfrageintervall beim Laden auf xx Minuten
						</div>
					</div>
					<div id="soccarnet">
						<div class="row bg-info">
							<b><label for="carnetuser">Benutzername:</label></b>
							<input type="text" name="carnetuser" id="carnetuser" value="<?php echo $mySettings->getSetting('carnetuser') ?>">
						</div>
						<div class="row bg-info">
							VW Carnet Benutzername.<br>
							Wenn der SoC nicht korrekt angezeigt wird, z.B. weil AGB von VW geändert wurden, ist es nötig sich auf https://www.portal.volkswagen-we.com anzumelden
						</div>
						<div class="row bg-info">
							<b><label for="carnetpass">Passwort:</label></b>
							<input type="password" name="carnetpass" id="carnetpass" value="<?php echo $mySettings->getSetting('carnetpass') ?>">
						</div>
						<div class="row bg-info">
							VW Carnet Passwort
						</div>
						<div class="row bg-info">
							<b><label for="soccarnetintervall">Verkürztes Intervall beim Laden:</label></b>
							<input type="text" name="soccarnetintervall" id="soccarnetintervall" value="<?php echo $mySettings->getSetting('soccarnetintervall') ?>">
						</div>
						<div class="row bg-info">
							Verkürzt das Abfrageintervall beim Laden auf xx Minuten
						</div>
					</div>

					<script>
						function display_socmodul() {
							<?php
							foreach( $myModules as $module ){
								if( $module->getCapabilities()["Ladepunkt SoC"] === true ){
									?>
							$('#<?php echo "socm_lp1_".$module->getId(); ?>').hide();
									<?php
								}
							}
							?>
							$('#socmnone').hide();
							$('#socmhttp').hide();
							$('#socleaf').hide();
							$('#soci3').hide();
							$('#soczoe').hide();
							$('#socevnotify').hide();
							//$('#socmtesla').hide();
							$('#soccarnet').hide();
							$('#socmzerong').hide();
							$('#socmaudi').hide();
							$('#socmqtt').hide();
							$('#socmbluelink').hide();

							$('#socmyrenault').hide();

							<?php
							foreach( $myModules as $module ){
								if( $module->getCapabilities()["Ladepunkt SoC"] === true ){
									?>
							if($('#socmodul').val() == '<?php echo $module->getId(); ?>') {
								$('#<?php echo "socm_lp1_".$module->getId(); ?>').show();
							}
									<?php
								}
							}
							?>
							if($('#socmodul').val() == 'soc_mqtt') {
								$('#socmqtt').show();
							}
							if($('#socmodul').val() == 'soc_bluelink') {
								$('#socmbluelink').show();
							}

							if($('#socmodul').val() == 'soc_audi') {
								$('#socmaudi').show();
							}
							if($('#socmodul').val() == 'soc_myrenault') {
								$('#socmyrenault').show();
							}

							if($('#socmodul').val() == 'none') {
								$('#socmnone').show();
							}
							if($('#socmodul').val() == 'soc_http') {
								$('#socmhttp').show();
							}
							if($('#socmodul').val() == 'soc_zerong') {
								$('#socmzerong').show();
							}

							if($('#socmodul').val() == 'soc_leaf') {
								$('#socleaf').show();
							}
							if($('#socmodul').val() == 'soc_i3') {
								$('#soci3').show();
							}
							if($('#socmodul').val() == 'soc_zoe') {
								$('#soczoe').show();
							}
							if($('#socmodul').val() == 'soc_evnotify') {
								$('#socevnotify').show();
							}
							//if($('#socmodul').val() == 'soc_tesla') {
							//	$('#socmtesla').show();
							//}
							if($('#socmodul').val() == 'soc_carnet') {
								$('#soccarnet').show();
							}
						}

						$(function() {
							display_socmodul();
							$('#socmodul').change( function(){
								display_socmodul();
							});
						});
					</script>

					<hr>
					<div class="row">
						<h4>
							<b><label for="lastmanagement">Zweiter Ladepunkt:</label></b>
							<select name="lastmanagement" id="lastmanagement">
								<option <?php if($mySettings->getSetting('lastmanagement') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('lastmanagement') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>
					<div id="lastmmaus">
					</div>
					<div id="lastmman" style="margin:5em;">

						<div class="row">
						</div>
						<div class="row">
							<b><label for="lp2name">Name Ladepunkt 2:</label></b>
							<input type="text" name="lp2name" id="lp2name" value="<?php echo $mySettings->getSetting('lp2name') ?>">
						</div>
						<div class="row">
							<b><label for="evsecons1">Anbindung der EVSE an Ladepunkt 2:</label></b>
							<select name="evsecons1" id="evsecons1">
								<option <?php if($mySettings->getSetting('evsecons1') == "slaveeth") echo "selected" ?> value="slaveeth">openWB Slave</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "modbusevse" && !($mySettings->getSetting('ladeleistungs1modul') == "mpm3pmlls1" && $mySettings->getSetting('mpm3pmlls1source') == "/dev/ttyUSB1" && $mySettings->getSetting('mpm3pmlls1id') == "6")) echo "selected" ?> value="modbusevse">Modbus</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "dac") echo "selected" ?> value="dac">DAC</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "simpleevsewifi") echo "selected" ?> value="simpleevsewifi">SimpleEVSEWifi</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "goe") echo "selected" ?> value="goe">Go-e</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "nrgkick") echo "selected" ?> value="nrgkick">NRGKick + Connect</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "keba") echo "selected" ?> value="keba">Keba</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "modbusevse" && $mySettings->getSetting('ladeleistungs1modul') == "mpm3pmlls1" && $mySettings->getSetting('mpm3pmlls1source') == "/dev/ttyUSB1" && $mySettings->getSetting('mpm3pmlls1id') == "6") echo "selected" ?> value="openwb12s1">openWB series1/2 Duo</option>
								<option <?php if($mySettings->getSetting('evsecons1') == "ipevse") echo "selected" ?> value="ipevse">openWB Satellit</option>
							</select>
						</div>
						<div id="evseconipevselp2">
							<div class="row bg-info">
								<b><label for="evseiplp2">IP Adresse:</label></b>
								<input type="text" name="evseiplp2" id="evseiplp2" value="<?php echo $mySettings->getSetting('evseiplp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP. Aufgedruckt auf dem Label der openWB.
							</div>
							<div class="row bg-info">
								<b><label for="evseidlp2">EVSE ID:</label></b>
								<input type="text" name="evseidlp2" id="evseidlp2" value="<?php echo $mySettings->getSetting('evseidlp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Aufgedruckt auf dem Label der openWB.
							</div>
						</div>
						<div id="openwb12s1">
							<div class="row bg-success">
								Keine Konfiguration erforderlich.<br>
								Dies ist die richtige Option sowohl für Bausatz als auch fertige openWB series1 oder series2.
							</div>
						</div>
						<div id="evseconnrgkicks1">
							<div class="row bg-info">
								<b><label for="nrgkickiplp2">NRGKick IP Adresse:</label></b>
								<input type="text" name="nrgkickiplp2" id="nrgkickiplp2" value="<?php echo $mySettings->getSetting('nrgkickiplp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP Adresse im Format: 192.168.0.12 Zu finden in der NRGKick App unter Einstellungen -> Info -> NRGkick Connect Infos.
							</div>
							<div class="row bg-info">
								<b><label for="nrgkicktimeoutlp2">NRGKick Timeout:</label></b>
								<input type="text" name="nrgkicktimeoutlp2" id="nrgkicktimeoutlp2" value="<?php echo $mySettings->getSetting('nrgkicktimeoutlp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort des NRGKick Connect gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
								Zulange Wartezeit zieht einen Verzug der Regellogik von openWB mit sich wenn die Go-e z.B. gerade unterwegs genutzt wird.
							</div>
							<div class="row bg-info">
								<b><label for="nrgkickmaclp2">NRGKick MAC Adresse:</label></b>
								<input type="text" name="nrgkickmaclp2" id="nrgkickmaclp2" value="<?php echo $mySettings->getSetting('nrgkickmaclp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte MAC Adresse im Format: 11:22:33:AA:BB:CC. Zu finden In der NRGKick App unter Einstellungen -> BLE-Mac.
							</div>
							<div class="row bg-info">
								<b><label for="nrgkickpwlp2">NRGKick PW:</label></b>
								<input type="text" name="nrgkickpwlp2" id="nrgkickpwlp2" value="<?php echo $mySettings->getSetting('nrgkickpwlp2') ?>">
							</div>
							<div class="row bg-info">
								Password welches in der NRGKick App festgelegt wurde.
							</div>
						</div>
						<div id="evseconkebas1">
							<div class="row bg-info">
								<b><label for="kebaiplp2">Keba IP Adresse:</label></b>
								<input type="text" name="kebaiplp2" id="kebaiplp2" value="<?php echo $mySettings->getSetting('kebaiplp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP Adresse im Format: 192.168.0.12<br>
								Erforder eine Keba C- oder X- Series. Die Smart Home Funktion (UDP Schnittstelle) muss per DIP Switch in der Keba aktiviert sein!
							</div>
						</div>
						<div id="evseconmbs1">
							<div class="row">
								Modbus für EVSE DIN. Auf der EVSE muss Register 2003 auf 1 gesetzt werden (Deaktivierung analog Eingang), sonst kein beschreiben möglich
							</div>
							<div class="row bg-info">
								<b><label for="evsesources1">EVSE Source:</label></b>
								<input type="text" name="evsesources1" id="evsesources1" value="<?php echo $mySettings->getSetting('evsesources1') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte /dev/ttyUSB0, /dev/virtualcom0. Serieller Port an dem der Modbus der EVSE angeschlossen ist.<br>
								Ist nur von belang wenn die Source auf /dev/virtualcomX steht. Ansonsten irrelevant
							</div>
							<div class="row bg-info">
								<b><label for="evseids1">EVSE ID:</label></b>
								<input type="text" name="evseids1" id="evseids1" value="<?php echo $mySettings->getSetting('evseids1') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Modbus ID der Slave 1 EVSE.
							</div>
							<div class="row bg-info">
								<b><label for="evselanips1">RS485/Lan-Konverter IP:</label></b>
								<input type="text" name="evselanips1" id="evselanips1" value="<?php echo $mySettings->getSetting('evselanips1') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP. Ist die source "virtualcomX" wird automatisch ein Lan Konverter genutzt, ansonsten ist diese Option irrelevant.
							</div>
						</div>
						<div id="evsecondacs1">
							<div class="row bg-success">
								<b><label for="dacregisters1">Dacregister:</label></b>
								<input type="text" name="dacregisters1" id="dacregisters1" value="<?php echo $mySettings->getSetting('dacregisters1') ?>">
							</div>
							<div class="row bg-success">
								Gültige Werte 0-99. Bei EVSE Anbindung per DAC (MCP 4725) Standardwert meist 62, oft auch 60 oder 48. Abhängig vom verbauten MCP<br>
								Rauszufinden bei angeschlossenem MCP auf der shell mit dem Befehl: "sudo i2cdetect -y 1". Muss sich bei Nutzung von zweimal DAC zum ersten unterscheiden!
							</div>
						</div>
						<div id="evsecoslaveeth">
							<div class="row bg-success">
								Keine Konfiguration erforderlich.
							</div>
						</div>
						<div id="evseconswifis1">
							<div class="row bg-info">
								<b><label for="evsewifiiplp2">Simple EVSE Wifi IP Adressee:</label></b>
								<input type="text" name="evsewifiiplp2" id="evsewifiiplp2" value="<?php echo $mySettings->getSetting('evsewifiiplp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP Adresse im Format: 192.168.0.12
							</div>
							<div class="row bg-info">
								<b><label for="evsewifitimeoutlp2">Simple EVSE Wifi Timeout:</label></b>
								<input type="text" name="evsewifitimeoutlp2" id="evsewifitimeoutlp2" value="<?php echo $mySettings->getSetting('evsewifitimeoutlp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort der Simple EVSE gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
								Zulange Wartezeit zieht einen Verzug der Regellogik von openWB mit sich wenn die SimpleEVSE z.B. gerade unterwegs genutzt wird.
							</div>
						</div>
						<div id="evsecongoes1">
							<div class="row bg-info">
								<b><label for="goeiplp2">Go-e IP Adressee:</label></b>
								<input type="text" name="goeiplp2" id="goeiplp2" value="<?php echo $mySettings->getSetting('goeiplp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP Adresse im Format: 192.168.0.12
							</div>
							<div class="row bg-info">
								<b><label for="goetimeoutlp2">Go-e Timeout:</label></b>
								<input type="text" name="goetimeoutlp2" id="goetimeoutlp2" value="<?php echo $mySettings->getSetting('goetimeoutlp2') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort der Go-e gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
								Zulange Wartezeit zieht einen Verzug der Regellogik von openWB mit sich wenn die Go-e z.B. gerade unterwegs genutzt wird.
							</div>
						</div>

						<script>
							function display_lp2() {
								$('#evsecondacs1').hide();
								$('#evseconmbs1').hide();
								$('#evseconswifis1').hide();
								$('#llmodullp2').hide();
								$('#evsecongoes1').hide();
								$('#evsecoslaveeth').hide();
								$('#evseconkebas1').hide();
								$('#evseconnrgkicks1').hide();
								$('#openwb12s1').hide();
								$('#evseconipevselp2').hide();
								if($('#evsecons1').val() == 'ipevse') {
									$('#evseconipevselp2').show();
									$('#llmodullp2').show();
								}
								if($('#evsecons1').val() == 'dac') {
									$('#evsecondacs1').show();
									$('#llmodullp2').show();
								}
								if($('#evsecons1').val() == 'modbusevse') {
									$('#evseconmbs1').show();
									$('#llmodullp2').show();
								}
								if($('#evsecons1').val() == 'simpleevsewifi') {
									$('#evseconswifis1').show();
								}
								if($('#evsecons1').val() == 'goe') {
									$('#evsecongoes1').show();
								}
								if($('#evsecons1').val() == 'slaveeth') {
									$('#evsecoslaveeth').show();
								}
								if($('#evsecons1').val() == 'keba') {
									$('#evseconkebas1').show();
								}
								if($('#evsecons1').val() == 'nrgkick') {
									$('#evseconnrgkicks1').show();
								}
								if($('#evsecon').val() == 'openwb12s1') {
									$('#openwb12s1').show();
								}
							}

							$(function() {
								display_lp2();
								$('#evsecons1').change( function(){
									display_lp2();
								});
							});
						</script>

						<div id="llmodullp2">
							<div class="row">
								<b><label for="ladeleistungs1modul">Ladeleistungsmodul für Ladepunkt 2:</label></b>
								<select name="ladeleistungs1modul" id="ladeleistungs1modul">
									<option <?php if($mySettings->getSetting('ladeleistungs1modul') == "sdm630modbuslls1") echo "selected" ?> value="sdm630modbuslls1">SDM 630 Modbus</option>
									<option <?php if($mySettings->getSetting('ladeleistungs1modul') == "sdm120modbuslls1") echo "selected" ?> value="sdm120modbuslls1">SDM 120 Modbus</option>
									<option <?php if($mySettings->getSetting('ladeleistungs1modul') == "simpleevsewifis1") echo "selected" ?> value="simpleevsewifis1">Simple EVSE Wifi</option>
									<option <?php if($mySettings->getSetting('ladeleistungs1modul') == "mpm3pmlls1") echo "selected" ?> value="mpm3pmlls1">MPM3PM Modbus</option>
									<option <?php if($mySettings->getSetting('ladeleistungs1modul') == "goelp2") echo "selected" ?> value="goelp2">Go-e</option>
									<option <?php if($mySettings->getSetting('ladeleistungs1modul') == "mpm3pmtripplelp2") echo "selected" ?> value="mpm3pmtripplelp2">openWB Tripple</option>
									<option <?php if($mySettings->getSetting('ladeleistungs1modul') == "mpm3pmlllp2") echo "selected" ?> value="mpm3pmlllp2">openWB Satelit</option>
								</select>
							</div>
							<div class="row">
								Modul zur Messung der Ladeleistung des zweiten Ladepunktes.
							</div>
							<div id="mpm3pmlllp2div">
								<div class="row bg-info">
									<b><label for="mpmlp2ip">MPM3PM Modbus Ladeleistung IP:</label></b>
									<input type="text" name="mpmlp2ip" id="mpmlp2ip" value="<?php echo $mySettings->getSetting('mpmlp2ip') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte IP Adresse des Modbus Ethernet Konverters.
								</div>
								<div class="row bg-info">
									<b><label for="mpmlp2id">MPM3PM Modbus Ladeleistung ID:</label></b>
									<input type="text" name="mpmlp2id" id="mpmlp2id" value="<?php echo $mySettings->getSetting('mpmlp2id') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des MPM3PM.
								</div>
							</div>
							<div id="mpm3pmlls1div">
								<div class="row bg-info">
									<b><label for="mpm3pmlls1source">MPM3PM Modbus Ladeleistung Source:</label></b>
									<input type="text" name="mpm3pmlls1source" id="mpm3pmlls1source" value="<?php echo $mySettings->getSetting('mpm3pmlls1source') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der MPM3PM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
									Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich
								</div>
								<div class="row bg-info">
									<b><label for="mpm3pmlls1id">MPM3PM Modbus Ladeleistung ID:</label></b>
									<input type="text" name="mpm3pmlls1id" id="mpm3pmlls1id" value="<?php echo $mySettings->getSetting('mpm3pmlls1id') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des MPM3PM.
								</div>
							</div>
							<div id="sdm630s1div">
								<div class="row bg-info">
									<b><label for="sdm630lp2source">Zähler Source:</label></b>
									<input type="text" name="sdm630lp2source" id="sdm630lp2source" value="<?php echo $mySettings->getSetting('sdm630lp2source') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der MPM3PM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
									Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich
								</div>
								<div class="row bg-info">
									<b><label for="sdmids1">Zähler ID:</label></b>
									<input type="text" name="sdmids1" id="sdmids1" value="<?php echo $mySettings->getSetting('sdmids1') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 2 Zählers in der WB.
								</div>
							</div>
							<div id="swifis1div">
								<div class="row">
								Keine Konfiguration erforderlich.
								</div>
							</div>
							<div id="sdm120s1div">
								<div class="row bg-info">
									<b><label for="sdm120lp2source">Zähler Source:</label></b>
									<input type="text" name="sdm120lp2source" id="sdm120lp2source" value="<?php echo $mySettings->getSetting('sdm120lp2source') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der MPM3PM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
									Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich
								</div>
								<div class="row bg-info">
									<b><label for="sdm120modbusllid1s1">SDM 120 Zähler 1 ID:</label></b>
									<input type="text" name="sdm120modbusllid1s1" id="sdm120modbusllid1s1" value="<?php echo $mySettings->getSetting('sdm120modbusllid1s1') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 2 SDM Zählers in der WB.
								</div>
								<div class="row bg-info">
									<b><label for="sdm120modbusllid2s1">SDM Zähler 2 ID:</label></b>
									<input type="text" name="sdm120modbusllid2s1" id="sdm120modbusllid2s1" value="<?php echo $mySettings->getSetting('sdm120modbusllid2s1') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 2 SDM Zählers 2 in der WB.  Ist keine zweite Phase / SDM120 vorhanden bitte none eintragen.
								</div>
								<div class="row bg-info">
									<b><label for="sdm120modbusllid3s1">SDM Zähler 3 ID:</label></b>
									<input type="text" name="sdm120modbusllid3s1" id="sdm120modbusllid3s1" value="<?php echo $mySettings->getSetting('sdm120modbusllid3s1') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 2 SDM Zählers 3 in der WB. Ist keine dritte Phase / SDM120 vorhanden bitte none eintragen.
								</div>
							</div>
							<div id="rs485lanlp2">
								<div class="row bg-info">
									<b><label for="lllaniplp2">RS485/Lan-Konverter IP:</label></b>
									<input type="text" name="lllaniplp2" id="lllaniplp2" value="<?php echo $mySettings->getSetting('lllaniplp2') ?>">
								</div>
								<div class="row bg-info">
									Ist nur von belang wenn die Source auf /dev/virtualcomX steht. Ansonsten irrelevant<br>
									Gültige Werte IP. Wenn ein LAN Konverter genutzt wird muss die Source auf /dev/virtualcomx (z.B. /dev/virtualcom0) gesetzt werden.
								</div>
							</div>
						</div>

						<div class="row">
							<b><label for="socmodul1">SOC Modul für Ladepunkt 2:</label></b>
							<select name="socmodul1" id="socmodul1">
								<option <?php if($mySettings->getSetting('socmodul1') == "none") echo "selected" ?> value="none">Nicht vorhanden</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_http1") echo "selected" ?> value="soc_http1">SoC HTTP</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_leafs1") echo "selected" ?> value="soc_leafs1">SoC Nissan Leaf</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_i3s1") echo "selected" ?> value="soc_i3s1">SoC BMW i3</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_evnotifys1") echo "selected" ?> value="soc_evnotifys1">SoC EVNotify</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_zoelp2") echo "selected" ?> value="soc_zoelp2">SoC Zoe alt</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_myrenaultlp2") echo "selected" ?> value="soc_myrenaultlp2">SoC MyRenault</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_teslalp2") echo "selected" ?> value="soc_teslalp2">SoC Tesla</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_carnetlp2") echo "selected" ?> value="soc_carnetlp2">SoC VW Carnet</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_zeronglp2") echo "selected" ?> value="soc_zeronglp2">SoC Zero NG</option>
								<option <?php if($mySettings->getSetting('socmodul1') == "soc_mqtt") echo "selected" ?> value="soc_mqtt">MQTT</option>
							</select>
						</div>
						<div id="socmqtt1">
							<div class="row">Keine Konfiguration erforderlich</div>
							<div class="row">Per MQTT zu schreiben:</div>
							<div class="row"><b>"openWB/set/lp/2/%Soc"</b></div>
							<div class="row">Ladezustand in %, int, 0-100</div>
						</div>
						<div id="socmnone1">
						</div>
						<div id="socmzeronglp2">
							<div class="row bg-info">
							</div>
							<div class="row bg-info">
								<b><label for="soc_zeronglp2_username">Zero Benutzername:</label></b>
								<input type="text" name="soc_zeronglp2_username" id="soc_zeronglp2_username" value="<?php echo $mySettings->getSetting('soc_zeronglp2_username') ?>">
							</div>
							<div class="row bg-info">
								Email Adresse des Zero Logins
							</div>
							<div class="row bg-info">
								<b><label for="soc_zeronglp2_password">Zero Passwort:</label></b>
								<input type="password" name="soc_zeronglp2_password" id="soc_zeronglp2_password" value="<?php echo $mySettings->getSetting('soc_zeronglp2_password') ?>">
							</div>
							<div class="row bg-info">
								Password des Zero Logins
							</div>
							<div class="row bg-info">
								<b><label for="soc_zeronglp2_intervall">Abfrageintervall Standby:</label></b>
								<input type="text" name="soc_zeronglp2_intervall" id="soc_zeronglp2_intervall" value="<?php echo $mySettings->getSetting('soc_zeronglp2_intervall') ?>">
							</div>
							<div class="row bg-info">
								Wie oft die Zero abgefragt wird wenn nicht geladen wird. Angabe in Minuten.
							</div>
							<div class="row bg-info">
								<b><label for="soc_zeronglp2_intervallladen">Abfrageintervall Laden:</label></b>
								<input type="text" name="soc_zeronglp2_intervallladen" id="soc_zeronglp2_intervallladen" value="<?php echo $mySettings->getSetting('soc_zeronglp2_intervallladen') ?>">
							</div>
							<div class="row bg-info">
								Wie oft die Zero abgefragt wird während geladen wird. Angabe in Minuten.
							</div>
						</div>
						<div id="socmteslalp2">
							<div class="row bg-info">
							</div>
							<div class="row bg-info">
								<b><label for="teslasoclp2user">Tesla Benutzername:</label></b>
								<input type="text" name="teslasoclp2user" id="teslasoclp2user" value="<?php echo $mySettings->getSetting('socteslalp2username') ?>">
							</div>
							<div class="row bg-info">
								Email Adresse des Tesla Logins
							</div>
							<div class="row bg-info">
								<b><label for="teslasoclp2pw">Tesla Passwort:</label></b>
								<input type="password" name="teslasoclp2pw" id="teslasoclp2pw" value="<?php echo $mySettings->getSetting('socteslalp2pw') ?>">
							</div>
							<div class="row bg-info">
								Password des Tesla Logins
							</div>
							<div class="row bg-info">
								<b><label for="teslasoclp2carnumber">Auto im Account:</label></b>
								<input type="text" name="teslasoclp2carnumber" id="teslasoclp2carnumber" value="<?php echo $mySettings->getSetting('socteslalp2carnumber') ?>">
							</div>
							<div class="row bg-info">
								Im Normalfall hier 0 eintragen. Sind mehrere Teslas im Account für den zweiten Tesla eine 1 eintragen.
							</div>
							<div class="row bg-info">
								<b><label for="teslasoclp2intervall">Abfrageintervall Standby:</label></b>
								<input type="text" name="teslasoclp2intervall" id="teslasoclp2intervall" value="<?php echo $mySettings->getSetting('socteslalp2intervall') ?>">
							</div>
							<div class="row bg-info">
								Wie oft der Tesla abgefragt wird wenn nicht geladen wird. Angabe in Minuten.
							</div>
							<div class="row bg-info">
								<b><label for="teslasoclp2intervallladen">Abfrageintervall Laden:</label></b>
								<input type="text" name="teslasoclp2intervallladen" id="teslasoclp2intervallladen" value="<?php echo $mySettings->getSetting('socteslalp2intervallladen') ?>">
							</div>
							<div class="row bg-info">
								Wie oft der Tesla abgefragt wird während geladen wird. Angabe in Minuten.
							</div>
						</div>
						<div id="soccarnetlp2">
							<div class="row bg-info">
								<b><label for="carnetlp2user">Benutzername:</label></b>
								<input type="text" name="carnetlp2user" id="carnetlp2user" value="<?php echo $mySettings->getSetting('carnetlp2user') ?>">
							</div>
							<div class="row bg-info">
								VW Carnet Benutzername
							</div>
							<div class="row bg-info">
								<b><label for="carnetlp2pass">Passwort:</label></b>
								<input type="password" name="carnetlp2pass" id="carnetlp2pass" value="<?php echo $mySettings->getSetting('carnetlp2pass') ?>">
							</div>
							<div class="row bg-info">
								VW Carnet Passwort
							</div>
							<div class="row bg-info">
								<b><label for="soccarnetlp2intervall">Verkürztes Intervall beim Laden:</label></b>
								<input type="text" name="soccarnetlp2intervall" id="soccarnetlp2intervall" value="<?php echo $mySettings->getSetting('soccarnetlp2intervall') ?>">
							</div>
							<div class="row bg-info">
								Verkürzt das Abfrageintervall beim Laden auf xx Minuten
							</div>
						</div>
						<div id="soczoelp2">
							<div class="row bg-info">
								<b><label for="zoelp2username">Benutzername:</label></b>
								<input type="text" name="zoelp2username" id="zoelp2username" value="<?php echo $mySettings->getSetting('zoelp2username') ?>">
							</div>
							<div class="row bg-info">
								Renault Zoe Benutzername
							</div>
							<div class="row bg-info">
								<b><label for="zoelp2passwort">Passwort:</label></b>
								<input type="password" name="zoelp2passwort" id="zoelp2passwort" value="<?php echo $mySettings->getSetting('zoelp2passwort') ?>">
							</div>
							<div class="row bg-info">
								Renault Zoe Passwort
							</div>
							<b><label for="wakeupzoelp2">Zoe Remote wecken wenn sie eingeschlafen ist:</label></b>
							<select name="wakeupzoelp2" id="wakeupzoelp2">
								<option <?php if($mySettings->getSetting('wakeupzoelp2') == "0") echo "selected" ?> value="0">Nein</option>
								<option <?php if($mySettings->getSetting('wakeupzoelp2') == "1") echo "selected" ?> value="1">Ja</option>
							</select>
							<div class="row bg-info">
								Erfordert einen openWB Ladepunkt, Go-e oder Keba. Nicht kompatibel mit EVSE Wifi und SimpleEVSE WB (mit DAC).
							</div>
						</div>
						<div id="socmyrenaultlp2">
							<div class="row bg-info">
								<b><label for="myrenault_userlp2">Benutzername:</label></b>
								<input type="text" name="myrenault_userlp2" id="myrenault_userlp2" value="<?php echo $mySettings->getSetting('myrenault_userlp2') ?>">
							</div>
							<div class="row bg-info">
								MyRenault Benutzername
							</div>
							<div class="row bg-info">
								<b><label for="myrenault_passlp2">Passwort:</label></b>
								<input type="password" name="myrenault_passlp2" id="myrenault_passlp2" value="<?php echo $mySettings->getSetting('myrenault_passlp2') ?>">
							</div>
							<div class="row bg-info">
								MyRenault Passwort
							</div>
							<div class="row bg-info">
								<b><label for="myrenault_locationlp2">Standort:</label></b>
								<input type="text" name="myrenault_locationlp2" id="myrenault_locationlp2" value="<?php echo $mySettings->getSetting('myrenault_locationlp2') ?>">
							</div>
							<div class="row bg-info">
								MyRenault Standort, z.B. de_DE
							</div>
							<div class="row bg-info">
								<b><label for="myrenault_countrylp2">Land:</label></b>
								<input type="text" name="myrenault_countrylp2" id="myrenault_countrylp2" value="<?php echo $mySettings->getSetting('myrenault_countrylp2') ?>">
							</div>
							<div class="row bg-info">
								MyRenault Land, z.B. CH, AT, DE
							</div>
							<b><label for="wakeupmyrenaultlp2">Zoe Remote wecken wenn sie eingeschlafen ist:</label></b>
							<select name="wakeupmyrenaultlp2" id="wakeupmyrenaultlp2">
								<option <?php if($mySettings->getSetting('wakeupmyrenaultlp2') == "0") echo "selected" ?> value="0">Nein</option>
								<option <?php if($mySettings->getSetting('wakeupmyrenaultlp2') == "1") echo "selected" ?> value="1">Ja</option>
							</select>
							<div class="row bg-info">
								Erfordert einen openWB Ladepunkt, Go-e oder Keba. Nicht kompatibel mit EVSE Wifi und SimpleEVSE WB (mit DAC).
							</div>
						</div>
						<div id="socevnotifylp2">
							<div class="row bg-info">
								<b><label for="evnotifyakeylp2">Akey:</label></b>
								<input type="text" name="evnotifyakeylp2" id="evnotifyakeylp2" value="<?php echo $mySettings->getSetting('evnotifyakeylp2') ?>">
							</div>
							<div class="row bg-info">
								Akey des EVNotify Kontos
							</div>
							<div class="row bg-info">
								<b><label for="evnotifytokenlp2">Token:</label></b>
								<input type="text" name="evnotifytokenlp2" id="evnotifytokenlp2" value="<?php echo $mySettings->getSetting('evnotifytokenlp2') ?>">
							</div>
							<div class="row bg-info">
								Token des Kontos
							</div>
						</div>
						<div id="socmhttp1">
							<div class="row">
								Gültige Werte none, soc_http. Wenn nicht vorhanden auf none setzen!
							</div>
							<div class="row bg-info">
								<b><label for="hsocip1">SOC zweiter Ladepunkt Http Abfrage URL:</label></b>
								<input type="text" name="hsocip1" id="hsocip1" value="<?php echo $mySettings->getSetting('hsocip1') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte none, "url". URL für die Abfrage des Soc der zweiten WB, Antwort muss der reine Zahlenwert sein.
							</div>
						</div>
						<div id="socleaf1">
							<div class="row bg-info">
								<b><label for="leafusernames1">Benutzername:</label></b>
								<input type="text" name="leafusernames1" id="leafusernames1" value="<?php echo $mySettings->getSetting('leafusernames1') ?>">
							</div>
							<div class="row bg-info">
								Nissan Connect Benutzername
							</div>
							<div class="row bg-info">
								<b><label for="leafpassworts1">Passwort:</label></b>
								<input type="password" name="leafpassworts1" id="leafpassworts1" value="<?php echo $mySettings->getSetting('leafpassworts1') ?>">
							</div>
							<div class="row bg-info">
								Nissan Connect Passwort
							</div>
						</div>
						<div id="soci31">
							<div class="row bg-info">
								<b><label for="i3usernames1">Benutzername:</label></b>
								<input type="text" name="i3usernames1" id="i3usernames1" value="<?php echo $mySettings->getSetting('i3usernames1') ?>">
							</div>
							<div class="row bg-info">
								BMW Services Benutzername
							</div>
							<div class="row bg-info">
								<b><label for="i3passworts1">Passwort:</label></b>
								<input type="password" name="i3passworts1" id="i3passworts1" value="<?php echo $mySettings->getSetting('i3passworts1') ?>">
							</div>
							<div class="row bg-info">
								BMW Services Passwort
							</div>
							<div class="row bg-info">
								<b><label for="i3vins1">VIN:</label></b>
								<input type="text" name="i3vins1" id="i3vins1" value="<?php echo $mySettings->getSetting('i3vins1') ?>">
							</div>
							<div class="row bg-info">
								BMW i3 VIN nötig. Es ist die vollständige aus dem Fzg-Schein anzugeben.
							</div>
							<div class="row bg-info">
								<b><label for="soci3intervall1">Verkürztes Intervall beim Laden:</label></b>
								<input type="text" name="soci3intervall1" id="soci3intervall1" value="<?php echo $mySettings->getSetting('soci3intervall1') ?>">
							</div>
							<div class="row bg-info">
								Verkürzt das Abfrageintervall beim Laden auf xx Minuten
							</div>
						</div>

						<script>
							function display_llmp2() {
								$('#sdm630s1div').hide();
								$('#sdm120s1div').hide();
								$('#swifis1div').hide();
								$('#mpm3pmlls1div').hide();
								$('#rs485lanlp2').hide();
								$('#mpm3pmlllp2div').hide();
								if($('#ladeleistungs1modul').val() == 'sdm630modbuslls1') {
									$('#sdm630s1div').show();
									$('#rs485lanlp2').show();
								}
								if($('#ladeleistungs1modul').val() == 'sdm120modbuslls1') {
									$('#sdm120s1div').show();
									$('#rs485lanlp2').show();
								}
								if($('#ladeleistungs1modul').val() == 'simpleevsewifis1') {
									$('#swifis1div').show();
								}
								if($('#ladeleistungs1modul').val() == 'goelp2') {
									$('#swifis1div').show();
								}
								if($('#ladeleistungs1modul').val() == 'mpm3pmlllp2') {
									$('#mpm3pmlllp2div').show();
									$('#rs485lanlp2').hide();
								}

								if($('#ladeleistungs1modul').val() == 'mpm3pmlls1') {
									$('#mpm3pmlls1div').show();
									$('#rs485lanlp2').show();
								}
							}

							$(function() {
								display_llmp2 ();
								$('#ladeleistungs1modul').change( function(){
									display_llmp2();
								});
							});

							function display_socmodul1() {
								$('#socmqtt1').hide();
								$('#socmnone1').hide();
								$('#socmhttp1').hide();
								$('#socleaf1').hide();
								$('#soci31').hide();
								$('#socevnotifylp2').hide();
								$('#soczoelp2').hide();
								$('#socmteslalp2').hide();
								$('#socmyrenaultlp2').hide();
								$('#soccarnetlp2').hide();
								$('#socmzeronglp2').hide();
								if($('#socmodul1').val() == 'soc_mqtt') {
									$('#socmqtt1').show();
								}

								if($('#socmodul1').val() == 'none') {
									$('#socmnone1').hide();
								}
								if($('#socmodul1').val() == 'soc_http1') {
									$('#socmhttp1').show();
								}
								if($('#socmodul1').val() == 'soc_leafs1') {
									$('#socleaf1').show();
								}
								if($('#socmodul1').val() == 'soc_myrenaultlp2') {
									$('#socmyrenaultlp2').show();
								}

								if($('#socmodul1').val() == 'soc_i3s1') {
									$('#soci31').show();
								}
								if($('#socmodul1').val() == 'soc_evnotifys1') {
									$('#socevnotifylp2').show();
								}
								if($('#socmodul1').val() == 'soc_zoelp2') {
							 		$('#soczoelp2').show();
								}
								if($('#socmodul1').val() == 'soc_carnetlp2') {
									$('#soccarnetlp2').show();
								}
								if($('#socmodul1').val() == 'soc_teslalp2') {
									$('#socmteslalp2').show();
								}
								if($('#socmodul1').val() == 'soc_zeronglp2') {
									$('#socmzeronglp2').show();
								}

							}
							$(function() {
								display_socmodul1();
								$('#socmodul1').change( function(){
									display_socmodul1();
								});
							});
						</script>

					</div>

					<script>
						function display_lastmanagement() {
							if($('#lastmanagement').val() == '0') {
								$('#lastmmaus').show();
								$('#lastmman').hide();
								$('#durchslp2').hide();
								$('#nachtls1div').hide();
							}
							else {
								$('#lastmmaus').hide();
								$('#lastmman').show();
								$('#durchslp2').show();
								$('#nachtls1div').show();
							}
						}

						$(function() {
							display_lastmanagement();
							$('#lastmanagement').change( function(){
								display_lastmanagement();
							 } );
						});
					</script>

					<div class="row">
						<h4>
							<b><label for="lastmanagements2">Dritter Ladepunkt:</label></b>
							<select name="lastmanagements2" id="lastmanagements2">
								<option <?php if($mySettings->getSetting('lastmanagements2') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('lastmanagements2') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>
					<div class="row">
					</div>
					<div id="lasts2mmaus">
					</div>
					<div id="lasts2mman" style="margin:5em;">
						<div class="row">
						</div>
						<div class="row">
							<b><label for="lp3name">Name Ladepunkt 3:</label></b>
							<input type="text" name="lp3name" id="lp3name" value="<?php echo $mySettings->getSetting('lp3name') ?>">
						</div>

						<div class="row">
							<b><label for="evsecons2">Anbindung der EVSE an Ladepunkt 3:</label></b>
							<select name="evsecons2" id="evsecons2">
								<option <?php if($mySettings->getSetting('evsecons2') == "thirdeth") echo "selected" ?> value="thirdeth">openWB dritter Ladepunkte</option>
								<option <?php if($mySettings->getSetting('evsecons2') == "modbusevse") echo "selected" ?> value="modbusevse">Modbus</option>
								<option <?php if($mySettings->getSetting('evsecons2') == "dac") echo "selected" ?> value="dac">DAC</option>
								<option <?php if($mySettings->getSetting('evsecons2') == "simpleevsewifi") echo "selected" ?> value="simpleevsewifi">SimpleEVSEWifi</option>
								<option <?php if($mySettings->getSetting('evsecons2') == "goe") echo "selected" ?> value="goe">Go-e</option>
								<option <?php if($mySettings->getSetting('evsecons2') == "ipevse") echo "selected" ?> value="ipevse">openWB Satellit</option>
							</select>
						</div>
						<div id="evseconipevselp3">
							<div class="row bg-info">
								<b><label for="evseiplp3">IP Adresse:</label></b>
								<input type="text" name="evseiplp3" id="evseiplp3" value="<?php echo $mySettings->getSetting('evseiplp3') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP. Aufgedruckt auf dem Label der openWB.
							</div>
							<div class="row bg-info">
								<b><label for="evseidlp3">EVSE ID:</label></b>
								<input type="text" name="evseidlp3" id="evseidlp3" value="<?php echo $mySettings->getSetting('evseidlp3') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte 1-254. Aufgedruckt auf dem Label der openWB.
							</div>
						</div>
							<div id="evseconmbs2">
								<div class="row">
									Modbus nur mit EVSE DIN getestet. Auf der EVSE muss Register 2003 auf 1 gesetzt werden (Deaktivierung analog Eingang), sonst kein beschreiben möglich<br>
									Zudem gibt es einen Bug das die EVSE ID der EVSE DIN sich nicht verstellen und speichern lässt!
								</div>
								<div class="row bg-info">
									<b><label for="evsesources2">EVSE Source:</label></b>
									<input type="text" name="evsesources2" id="evsesources2" value="<?php echo $mySettings->getSetting('evsesources2') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte /dev/ttyUSB0, /dev/virtualcom0. Serieller Port an dem der Modbus der EVSE angeschlossen ist.
								</div>
								<div class="row bg-info">
									<b><label for="evseids2">EVSE ID:</label></b>
									<input type="text" name="evseids2" id="evseids2" value="<?php echo $mySettings->getSetting('evseids2') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID der Slave 2 EVSE.
								</div>
								<div class="row bg-info">
									<b><label for="evselanips2">RS485/Lan-Konverter IP:</label></b>
									<input type="text" name="evselanips2" id="evselanips2" value="<?php echo $mySettings->getSetting('evselanips2') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte IP. Ist die source "virtualcomX" wird automatisch ein Lan Konverter genutzt, ansonsten ist diese Option irrelevant.
								</div>
							</div>
							<div id="evsecondacs2">
								<div class="row bg-success">
									<b><label for="dacregisters2">Dacregister:</label></b>
									<input type="text" name="dacregisters2" id="dacregisters2" value="<?php echo $mySettings->getSetting('dacregisters2') ?>">
								</div>
								<div class="row bg-success">
									Gültige Werte 0-99. Bei EVSE Anbindung per DAC (MCP 4725) Standardwert meist 62, oft auch 60 oder 48. Abhängig vom verbauten MCP<br>
									Rauszufinden bei angeschlossenem MCP auf der shell mit dem Befehl: "sudo i2cdetect -y 1". Muss sich von bei Nutzung von zweimal DAC zum ersten unterscheiden!
								</div>
							</div>
							<div id="evseconswifis2">
								<div class="row bg-info">
									<b><label for="evsewifiiplp3">Simple EVSE Wifi IP Adressee:</label></b>
									<input type="text" name="evsewifiiplp3" id="evsewifiiplp3" value="<?php echo $mySettings->getSetting('evsewifiiplp3') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte IP Adresse im Format: 192.168.0.12
								</div>
								<div class="row bg-info">
									<b><label for="evsewifitimeoutlp3">Simple EVSE Wifi Timeout:</label></b>
									<input type="text" name="evsewifitimeoutlp3" id="evsewifitimeoutlp3" value="<?php echo $mySettings->getSetting('evsewifitimeoutlp3') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort der Simple EVSE gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
									Zulange Wartezeit zieht einen Verzug der Regellogik von openWB mit sich wenn die SimpleEVSE z.B. gerade unterwegs genutzt wird.
								</div>
							</div>
						<div id="evsecongoes2">
							<div class="row bg-info">
								<b><label for="goeiplp3">Go-e IP Adressee:</label></b>
								<input type="text" name="goeiplp3" id="goeiplp3" value="<?php echo $mySettings->getSetting('goeiplp3') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte IP Adresse im Format: 192.168.0.12
							</div>
							<div class="row bg-info">
								<b><label for="goetimeoutlp3">Go-e Timeout:</label></b>
								<input type="text" name="goetimeoutlp3" id="goetimeoutlp3" value="<?php echo $mySettings->getSetting('goetimeoutlp3') ?>">
							</div>
							<div class="row bg-info">
								Gültige Werte Zahl. Gibt die Zeit in Sekunden an wie lange auf Antwort der Go-e gewartet wird. Bei gutem Wlan reichen 2 Sekunden aus.<br>
								Zulange Wartezeit zieht einen Verzug der Regellogik von openWB mit sich wenn die Go-e z.B. gerade unterwegs genutzt wird.
							</div>
						</div>

						<script>
							function display_lp3 () {
								$('#evsecondacs2').hide();
								$('#evseconmbs2').hide();
								$('#evseconswifis2').hide();
								$('#llmodullp3').hide();
								$('#evsecongoes2').hide();
								$('#evseconipevselp3').hide();


								if($('#evsecons2').val() == 'dac') {
									$('#evsecondacs2').show();
									$('#llmodullp3').show();
								}
								if($('#evsecons2').val() == 'modbusevse') {
									$('#evseconmbs2').show();
									$('#llmodullp3').show();
								}
								if($('#evsecons2').val() == 'simpleevsewifi') {
									$('#evseconswifis2').show();
								}
								if($('#evsecons2').val() == 'goe') {
									$('#evsecongoes2').show();
								}
								if($('#evsecons2').val() == 'ipevse') {
									$('#evseconipevselp3').show();
									$('#llmodullp3').show();
								}
							}

							$(function() {
								display_lp3();
								$('#evsecons2').change( function(){
									display_lp3();
								});
							});
						</script>

						<div id="llmodullp3">
							<div class="row">
								<b><label for="ladeleistungss2modul">Ladeleistungsmodul für Ladepunkt 3:</label></b>
								<select name="ladeleistungs2modul" id="ladeleistungss2modul">
									<option <?php if($mySettings->getSetting('ladeleistungs2modul') == "sdm630modbuslls2") echo "selected" ?> value="sdm630modbuslls2">SDM 630 Modbus</option>
									<option <?php if($mySettings->getSetting('ladeleistungs2modul') == "sdm120modbuslls2") echo "selected" ?> value="sdm120modbuslls2">SDM 120 Modbus</option>
									<option <?php if($mySettings->getSetting('ladeleistungs2modul') == "mpm3pmlls2") echo "selected" ?> value="mpm3pmlls2">MPM3PM Modbus</option>
									<option <?php if($mySettings->getSetting('ladeleistungs2modul') == "simpleevsewifis2") echo "selected" ?> value="simpleevsewifis2">Simple EVSE Wifi</option>
									<option <?php if($mySettings->getSetting('ladeleistungs2modul') == "goelp3") echo "selected" ?> value="goelp3">Go-E</option>
									<option <?php if($mySettings->getSetting('ladeleistungs2modul') == "mpm3pmtripplelp3") echo "selected" ?> value="mpm3pmtripplelp3">openWB Tripple</option>
									<option <?php if($mySettings->getSetting('ladeleistungs2modul') == "mpm3pmlllp3") echo "selected" ?> value="mpm3pmlllp3">openWB Satellit</option>
								</select>
							</div>
							<div class="row">
								Modul zur Messung der Ladeleistung des dritten Ladepunktes.
							</div>
							<div id="mpm3pmlllp3div">
								<div class="row bg-info">
									<b><label for="mpmlp3ip">MPM3PM Modbus Ladeleistung IP:</label></b>
									<input type="text" name="mpmlp3ip" id="mpmlp3ip" value="<?php echo $mySettings->getSetting('mpmlp3ip') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte IP Adresse des Modbus Ethernet Konverters.
								</div>
								<div class="row bg-info">
									<b><label for="mpmlp3id">MPM3PM Modbus Ladeleistung ID:</label></b>
									<input type="text" name="mpmlp3id" id="mpmlp3id" value="<?php echo $mySettings->getSetting('mpmlp3id') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des MPM3PM.
								</div>
							</div>
							<div id="swifis2div">
								<div class="row">
									Keine Konfiguration erforderlich.
								</div>
							</div>
							<div id="mpm3pmlls2div">
								<div class="row bg-info">
									<b><label for="mpm3pmlls2source">MPM3PM Modbus Ladeleistung Source:</label></b>
									<input type="text" name="mpm3pmlls2source" id="mpm3pmlls2source" value="<?php echo $mySettings->getSetting('mpm3pmlls2source') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der MPM3PM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
									Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich
								</div>
								<div class="row bg-info">
									<b><label for="mpm3pmlls2id">MPM3PM Modbus Ladeleistung ID:</label></b>
									<input type="text" name="mpm3pmlls2id" id="mpm3pmlls2id" value="<?php echo $mySettings->getSetting('mpm3pmlls2id') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des MPM3PM.
								</div>
							</div>
							<div id="sdm630s2div">
								<div class="row bg-info">
									<b><label for="sdm630lp3source">Zähler Source:</label></b>
									<input type="text" name="sdm630lp3source" id="sdm630lp3source" value="<?php echo $mySettings->getSetting('sdm630lp3source') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte /dev/ttyUSB0, /dev/virtualcom0. Serieller Port an dem der Modbus des Zählers angeschlossen ist.
								</div>
								<div class="row bg-info">
									<b><label for="sdmids2">SDM 630 Zähler ID:</label></b>
									<input type="text" name="sdmids2" id="sdmids2" value="<?php echo $mySettings->getSetting('sdmids2') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 3 SDM Zählers in der WB.
								</div>
							</div>
							<div id="sdm120s2div">
								<div class="row bg-info">
									<b><label for="sdm120lp3source">Zähler Source:</label></b>
									<input type="text" name="sdm120lp3source" id="sdm120lp3source" value="<?php echo $mySettings->getSetting('sdm120lp3source') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte /dev/ttyUSB0, /dev/virtualcom0. Serieller Port an dem der Modbus des Zählers angeschlossen ist.
								</div>
								<div class="row bg-info">
									<b><label for="sdm120modbusllid1s2">SDM Zähler 1 ID:</label></b>
									<input type="text" name="sdm120modbusllid1s2" id="sdm120modbusllid1s2" value="<?php echo $mySettings->getSetting('sdm120modbusllid1s2') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 3 SDM Zählers in der WB.
								</div>
								<div class="row bg-info">
									<b><label for="sdm120modbusllid2s2">SDM Zähler 2 ID:</label></b>
									<input type="text" name="sdm120modbusllid2s2" id="sdm120modbusllid2s2" value="<?php echo $mySettings->getSetting('sdm120modbusllid2s2') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 3 SDM Zählers 2 in der WB.  Ist keine zweite Phase / SDM120 vorhanden bitte none eintragen.
								</div>
								<div class="row bg-info">
									<b><label for="sdm120modbusllid3s2">SDM Zähler 3 ID:</label></b>
									<input type="text" name="sdm120modbusllid3s2" id="sdm120modbusllid3s2" value="<?php echo $mySettings->getSetting('sdm120modbusllid3s2') ?>">
								</div>
								<div class="row bg-info">
									Gültige Werte 1-254. Modbus ID des Ladepunkt 3 SDM Zählers 3 in der WB. Ist keine dritte Phase / SDM120 vorhanden bitte none eintragen.
								</div>
							</div>
							<div id="rs485lanlp3">
								<div class="row bg-info">
									<b><label for="lllaniplp3">RS485/Lan-Konverter IP:</label></b>
									<input type="text" name="lllaniplp3" id="lllaniplp3" value="<?php echo $mySettings->getSetting('lllaniplp3') ?>">
								</div>
								<div class="row bg-info">
									Ist nur von belang wenn die Source auf /dev/virtualcomX steht. Ansonsten irrelevant<br>
									Gültige Werte IP. Wenn ein LAN Konverter genutzt wird muss die Source auf /dev/virtualcomx (z.B. /dev/virtualcom0) gesetzt werden.
								</div>
							</div>
						</div>
					</div>

					<script>
						function display_llmp3 () {
							$('#sdm630s2div').hide();
							$('#sdm120s2div').hide();
							$('#swifis2div').hide();
							$('#rs485lanlp3').hide();
							$('#mpm3pmlls2div').hide();
							$('#mpm3pmlllp3div').hide();


							if($('#ladeleistungss2modul').val() == 'mpm3pmlllp3') {
								$('#mpm3pmlllp3div').show();
								$('#rs485lanlp3').show();
							}

							if($('#ladeleistungss2modul').val() == 'sdm630modbuslls2') {
								$('#sdm630s2div').show();
								$('#rs485lanlp3').show();
							}
							if($('#ladeleistungss2modul').val() == 'sdm120modbuslls2') {
								$('#sdm120s2div').show();
								$('#rs485lanlp3').show();
							}
							if($('#ladeleistungss2modul').val() == 'simpleevsewifis2') {
								$('#swifis2div').show();
							}
							if($('#ladeleistungss2modul').val() == 'goelp3') {
								$('#swifis2div').show();
							}
							if($('#ladeleistungss2modul').val() == 'mpm3pmlls2') {
								$('#mpm3pmlls2div').show();
								$('#rs485lanlp3').show();
							}

						}

						$(function() {
							display_llmp3 ();
							$('#ladeleistungss2modul').change( function(){
								display_llmp3();
							});
						});

						function display_lastmanagement2() {
							if($('#lastmanagements2').val() == '0') {
								$('#lasts2mmaus').show();
								$('#lasts2mman').hide();
								$('#durchslp3').hide();
							}
							else {
								$('#lasts2mmaus').hide();
								$('#lasts2mman').show();
								$('#durchslp3').show();
							}
						}

						$(function() {
							display_lastmanagement2();
							$('#lastmanagements2').change( function() {
								display_lastmanagement2();
							});
						});
					</script>

					<div class="row">
						<h4>
							<b><label for="lastmanagementlp4">Vierter Ladepunkt:</label></b>
							<select name="lastmanagementlp4" id="lastmanagementlp4">
								<option <?php if($mySettings->getSetting('lastmanagementlp4') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('lastmanagementlp4') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>

					<div id="lastlp4mmaus">
					</div>
					<div id="lastlp4mman" style="margin:5em;">
						<div class="row">
							<b><label for="lp3name">Name Ladepunkt 4:</label></b>
							<input type="text" name="lp4name" id="lp4name" value="<?php echo $mySettings->getSetting('lp4name') ?>">
						</div>
						<div class="row bg-info">
							<b><label for="evseiplp4">EVSE IP:</label></b>
							<input type="text" name="evseiplp4" id="evseiplp4" value="<?php echo $mySettings->getSetting('evseiplp4') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse.
						</div>
						<div class="row bg-info">
							<b><label for="evseidlp4">EVSE ID:</label></b>
							<input type="text" name="evseidlp4" id="evseidlp4" value="<?php echo $mySettings->getSetting('evseidlp4') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID der EVSE.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp4ip">MPM3PM Modbus Ladeleistung IP:</label></b>
							<input type="text" name="mpmlp4ip" id="mpmlp4ip" value="<?php echo $mySettings->getSetting('mpmlp4ip') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse des Modbus Ethernet Konverters.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp4id">MPM3PM Modbus Ladeleistung ID:</label></b>
							<input type="text" name="mpmlp4id" id="mpmlp4id" value="<?php echo $mySettings->getSetting('mpmlp4id') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID des MPM3PM.
						</div>
					</div>

					<script>
						function display_lastmanagementlp4() {
							if($('#lastmanagementlp4').val() == '0') {
								$('#lastlp4mmaus').show();
								$('#lastlp4mman').hide();
							}
							else {
								$('#lastlp4mmaus').hide();
								$('#lastlp4mman').show();
							}
						}

						$(function() {
							display_lastmanagementlp4();
							$('#lastmanagementlp4').change( function() {
								display_lastmanagementlp4();
							});
						});
					</script>
					<div class="row">
						<h4>
							<b><label for="lastmanagementlp5">Fünfter Ladepunkt:</label></b>
							<select name="lastmanagementlp5" id="lastmanagementlp5">
								<option <?php if($mySettings->getSetting('lastmanagementlp5') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('lastmanagementlp5') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>

					<div id="lastlp5mmaus">
					</div>
					<div id="lastlp5mman" style="margin:5em;">
						<div class="row">
							<b><label for="lp5name">Name Ladepunkt 5:</label></b>
							<input type="text" name="lp5name" id="lp5name" value="<?php echo $mySettings->getSetting('lp5name') ?>">
						</div>
						<div class="row bg-info">
							<b><label for="evseiplp5">EVSE IP:</label></b>
							<input type="text" name="evseiplp5" id="evseiplp5" value="<?php echo $mySettings->getSetting('evseiplp5') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse.
						</div>
						<div class="row bg-info">
							<b><label for="evseidlp5">EVSE ID:</label></b>
							<input type="text" name="evseidlp5" id="evseidlp5" value="<?php echo $mySettings->getSetting('evseidlp5') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID der EVSE.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp5ip">MPM3PM Modbus Ladeleistung IP:</label></b>
							<input type="text" name="mpmlp5ip" id="mpmlp5ip" value="<?php echo $mySettings->getSetting('mpmlp5ip') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse des Modbus Ethernet Konverters.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp5id">MPM3PM Modbus Ladeleistung ID:</label></b>
							<input type="text" name="mpmlp5id" id="mpmlp5id" value="<?php echo $mySettings->getSetting('mpmlp5id') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID des MPM3PM.
						</div>
					</div>

					<script>
						function display_lastmanagementlp5() {
							if($('#lastmanagementlp5').val() == '0') {
								$('#lastlp5mmaus').show();
								$('#lastlp5mman').hide();
							}
							else {
								$('#lastlp5mmaus').hide();
								$('#lastlp5mman').show();
							}
						}

						$(function() {
							display_lastmanagementlp5();
							$('#lastmanagementlp5').change( function() {
								display_lastmanagementlp5();
							});
						});
					</script>
					<div class="row">
						<h4>
							<b><label for="lastmanagementlp6">Sechster Ladepunkt:</label></b>
							<select name="lastmanagementlp6" id="lastmanagementlp6">
								<option <?php if($mySettings->getSetting('lastmanagementlp6') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('lastmanagementlp6') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>

					<div id="lastlp6mmaus">
					</div>
					<div id="lastlp6mman" style="margin:5em;">
						<div class="row">
							<b><label for="lp6name">Name Ladepunkt 6:</label></b>
							<input type="text" name="lp6name" id="lp6name" value="<?php echo $mySettings->getSetting('lp6name') ?>">
						</div>
						<div class="row bg-info">
							<b><label for="evseiplp6">EVSE IP:</label></b>
							<input type="text" name="evseiplp6" id="evseiplp6" value="<?php echo $mySettings->getSetting('evseiplp6') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse.
						</div>
						<div class="row bg-info">
							<b><label for="evseidlp6">EVSE ID:</label></b>
							<input type="text" name="evseidlp6" id="evseidlp6" value="<?php echo $mySettings->getSetting('evseidlp6') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID der EVSE.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp6ip">MPM3PM Modbus Ladeleistung IP:</label></b>
							<input type="text" name="mpmlp6ip" id="mpmlp6ip" value="<?php echo $mySettings->getSetting('mpmlp6ip') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse des Modbus Ethernet Konverters.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp6id">MPM3PM Modbus Ladeleistung ID:</label></b>
							<input type="text" name="mpmlp6id" id="mpmlp6id" value="<?php echo $mySettings->getSetting('mpmlp6id') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID des MPM3PM.
						</div>
					</div>

					<script>
						function display_lastmanagementlp6() {
							if($('#lastmanagementlp6').val() == '0') {
								$('#lastlp6mmaus').show();
								$('#lastlp6mman').hide();
							}
							else {
								$('#lastlp6mmaus').hide();
								$('#lastlp6mman').show();
							}
						}
						$(function() {
							display_lastmanagementlp6();
							$('#lastmanagementlp6').change( function() {
								display_lastmanagementlp6();
							});
						});
					</script>
					<div class="row">
						<h4>
							<b><label for="lastmanagementlp7">Siebter Ladepunkt:</label></b>
							<select name="lastmanagementlp7" id="lastmanagementlp7">
								<option <?php if($mySettings->getSetting('lastmanagementlp7') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('lastmanagementlp7') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>

					<div id="lastlp7mmaus">
					</div>
					<div id="lastlp7mman" style="margin:5em;">
						<div class="row">
							<b><label for="lp7name">Name Ladepunkt 7:</label></b>
							<input type="text" name="lp7name" id="lp7name" value="<?php echo $mySettings->getSetting('lp7name') ?>">
						</div>
						<div class="row bg-info">
							<b><label for="evseiplp7">EVSE IP:</label></b>
							<input type="text" name="evseiplp7" id="evseiplp7" value="<?php echo $mySettings->getSetting('evseiplp7') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse.
						</div>
						<div class="row bg-info">
							<b><label for="evseidlp7">EVSE ID:</label></b>
							<input type="text" name="evseidlp7" id="evseidlp7" value="<?php echo $mySettings->getSetting('evseidlp7') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID der EVSE.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp7ip">MPM3PM Modbus Ladeleistung IP:</label></b>
							<input type="text" name="mpmlp7ip" id="mpmlp7ip" value="<?php echo $mySettings->getSetting('mpmlp7ip') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse des Modbus Ethernet Konverters.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp7id">MPM3PM Modbus Ladeleistung ID:</label></b>
							<input type="text" name="mpmlp7id" id="mpmlp7id" value="<?php echo $mySettings->getSetting('mpmlp7id') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID des MPM3PM.
						</div>
					</div>

					<script>
						function display_lastmanagementlp7() {
							if($('#lastmanagementlp7').val() == '0') {
								$('#lastlp7mmaus').show();
								$('#lastlp7mman').hide();
							}
							else {
								$('#lastlp7mmaus').hide();
								$('#lastlp7mman').show();
							}
						}

						$(function() {
							display_lastmanagementlp7();
							$('#lastmanagementlp7').change( function() {
								display_lastmanagementlp7();
							});
						});
					</script>
					<div class="row">
						<h4>
							<b><label for="lastmanagementlp8">Achter Ladepunkt:</label></b>
							<select name="lastmanagementlp8" id="lastmanagementlp8">
								<option <?php if($mySettings->getSetting('lastmanagementlp8') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('lastmanagementlp8') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>

					<div id="lastlp8mmaus">
					</div>
					<div id="lastlp8mman" style="margin:5em;">
						<div class="row">
							<b><label for="lp8name">Name Ladepunkt 8:</label></b>
							<input type="text" name="lp8name" id="lp8name" value="<?php echo $mySettings->getSetting('lp8name') ?>">
						</div>
						<div class="row bg-info">
							<b><label for="evseiplp8">EVSE IP:</label></b>
							<input type="text" name="evseiplp8" id="evseiplp8" value="<?php echo $mySettings->getSetting('evseiplp8') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse.
						</div>
						<div class="row bg-info">
							<b><label for="evseidlp8">EVSE ID:</label></b>
							<input type="text" name="evseidlp8" id="evseidlp8" value="<?php echo $mySettings->getSetting('evseidlp8') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID der EVSE.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp8ip">MPM3PM Modbus Ladeleistung IP:</label></b>
							<input type="text" name="mpmlp8ip" id="mpmlp8ip" value="<?php echo $mySettings->getSetting('mpmlp8ip') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte IP Adresse des Modbus Ethernet Konverters.
						</div>
						<div class="row bg-info">
							<b><label for="mpmlp8id">MPM3PM Modbus Ladeleistung ID:</label></b>
							<input type="text" name="mpmlp8id" id="mpmlp8id" value="<?php echo $mySettings->getSetting('mpmlp8id') ?>">
						</div>
						<div class="row bg-info">
							Gültige Werte 1-254. Modbus ID des MPM3PM.
						</div>
					</div>

					<script>
						function display_lastmanagementlp8() {
							if($('#lastmanagementlp8').val() == '0') {
								$('#lastlp8mmaus').show();
								$('#lastlp8mman').hide();
							}
							else {
								$('#lastlp8mmaus').hide();
								$('#lastlp8mman').show();
							}
						}

						$(function() {
							display_lastmanagementlp8();
							$('#lastmanagementlp8').change( function() {
								display_lastmanagementlp8();
							});
						});
					</script>
					<div class="row">
						<h3> Strombezugsmessmodul (EVU-Übergabepunkt)</h3>
					</div>
					<div class="row">
						<b><label for="wattbezugmodul">Strombezugsmodul:</label></b>
						<select name="wattbezugmodul" id="wattbezugmodul">
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "none") echo "selected" ?> value="none">Nicht vorhanden</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_ethmpm3pm") echo "selected" ?> value="bezug_ethmpm3pm">openWB EVU Kit</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "vzlogger") echo "selected" ?> value="vzlogger">VZLogger</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "sdm630modbusbezug") echo "selected" ?> value="sdm630modbusbezug">SDM 630</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_http") echo "selected" ?> value="bezug_http">HTTP</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_json") echo "selected" ?> value="bezug_json">Json</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_mpm3pm") echo "selected" ?> value="bezug_mpm3pm">MPM3PM</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_smashm") echo "selected" ?> value="bezug_smashm">SMA HomeManager</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_fronius_sm") echo "selected" ?> value="bezug_fronius_sm">Fronius Energy Meter</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_fronius_s0") echo "selected" ?> value="bezug_fronius_s0">Fronius WR mit S0 Meter</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_solarlog") echo "selected" ?> value="bezug_solarlog">SolarLog</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_solaredge") echo "selected" ?> value="bezug_solaredge">Solaredge</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_smartme") echo "selected" ?> value="bezug_smartme">Smartme</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_e3dc") echo "selected" ?> value="bezug_e3dc">E3DC Speicher</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_sbs25") echo "selected" ?> value="bezug_sbs25">SMA SBS2.5 Speicher</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_kostalplenticoreem300haus") echo "selected" ?> value="bezug_kostalplenticoreem300haus">Kostal Plenticore mit EM300/KSEM</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_kostalpiko") echo "selected" ?> value="bezug_kostalpiko">Kostal Piko mit Energy Meter</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_smartfox") echo "selected" ?> value="bezug_smartfox">Smartfox</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_powerwall") echo "selected" ?> value="bezug_powerwall">Tesla Powerwall</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_victrongx") echo "selected" ?> value="bezug_victrongx">Victron (z.B. GX)</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_alphaess") echo "selected" ?> value="bezug_alphaess">Alpha ESS</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_solarview") echo "selected" ?> value="bezug_solarview">Solarview</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_discovergy") echo "selected" ?> value="bezug_discovergy">Discovergy</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_lgessv1") echo "selected" ?> value="bezug_lgessv1">LG ESS 1.0VI</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_mqtt") echo "selected" ?> value="bezug_mqtt">MQTT</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_sonneneco") echo "selected" ?> value="bezug_sonneneco">Sonnen eco</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_fems") echo "selected" ?> value="bezug_fems">Fenecon FEMS</option>
							<option <?php if($mySettings->getSetting('wattbezugmodul') == "bezug_solarworld") echo "selected" ?> value="bezug_solarworld">Solarworld</option>
						</select>
					</div>
					<div id="wattbezugsonneneco">
						<div class="row">
							Keine Konfiguration erforderlich. Es muss beim Speicher die alternative Methode ausgewählt werden, da die Daten nur von der JSON-API übergeben werden.
						</div>
					</div>
					<div id="wattbezugmqtt">
						<div class="row">Keine Konfiguration erforderlich</div>
						<div class="row">Per MQTT zu schreiben:</div>
						<div class="row"><b>"openWB/set/evu/W"</b></div>
						<div class="row">Bezugsleistung in Watt, int, positiv Bezug, negativ Einspeisung</div>
						<div class="row"><b>"openWB/set/evu/APhase1"</b></div>
						<div class="row">Strom in Ampere für Phase 1, float, Punkt als Trenner, positiv Bezug, negativ Einspeisung</div>
						<div class="row"><b>"openWB/set/evu/APhase2"</b></div>
						<div class="row">Strom in Ampere für Phase 2, float, Punkt als Trenner, positiv Bezug, negativ Einspeisung</div>
						<div class="row"><b>"openWB/set/evu/APhase3"</b></div>
						<div class="row">Strom in Ampere für Phase 3, float, Punkt als Trenner, positiv Bezug, negativ Einspeisung</div>
						<div class="row"><b>"openWB/set/evu/WhImported"</b></div>
						<div class="row">Bezogene Energie in Wh, float, Punkt als Trenner, nur positiv</div>
						<div class="row"><b>"openWB/set/evu/WhExported"</b></div>
						<div class="row">Eingespeiste Energie in Wh, float, Punkt als Trenner, nur positiv</div>
						<div class="row"><b>"openWB/set/evu/VPhase1"</b></div>
						<div class="row">Spannung in Volt für Phase 1, float, Punkt als Trenner</div>
						<div class="row"><b>"openWB/set/evu/VPhase2"</b></div>
						<div class="row">Spannung in Volt für Phase 2, float, Punkt als Trenner</div>
						<div class="row"><b>"openWB/set/evu/VPhase3"</b></div>
						<div class="row">Spannung in Volt für Phase 3, float, Punkt als Trenner</div>
						<div class="row"><b>"openWB/set/evu/HzFrequenz"</b></div>
						<div class="row">Netzfrequenz in Hz, float, Punkt als Trenner</div>
					</div>
					<div id="wattbezuglgessv1">
						<div class="row">
							Konfiguration im zugehörigen Speichermodul des LG ESS 1.0VI erforderlich. Als PV-Modul auch LG ESS 1.0VI wählen!
						</div>
					</div>
					<div id="wattbezugethmpm3pm">
						<div class="row">
							<b><label for="evukitversion">Version des openWB evu Kits:</label></b>
							<select name="evukitversion" id="evukitversion">
								<option <?php if($mySettings->getSetting('evukitversion') == 0) echo "selected" ?> value="0">EVU Kit</option>
								<option <?php if($mySettings->getSetting('evukitversion') == 1) echo "selected" ?> value="1">EVU Kit v2</option>
							</select>
						</div>
					</div>
					<div id="wattbezugsolarview">
						<div class="row">
							Konfiguration im zugehörigen PV Modul erforderlich.
						</div>
					</div>
					<div id="wattbezugpowerwall">
						<div class="row">
							Keine Konfiguration erforderlich. Mit diesem Modul ist kein Lastmanagement / Hausanschlussüberwachung möglich.
						</div>
					</div>
					<div id="wattbezugvictrongx">
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_victronip">Victron IP:</label></b>
							<input type="text" name="bezug_victronip" id="bezug_victronip" value="<?php echo $mySettings->getSetting('bezug_victronip') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP. IP Adresse des Victron, z.B. GX.
						</div>
					</div>
					<div id="wattbezugfems">
						<div class="row" style="background-color:#febebe">
							<b><label for="femsip">Fenecon IP:</label></b>
							<input type="text" name="femsip" id="femsip" value="<?php echo $femsipold ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP. IP Adresse des Fenecon FEMS.
						</div>
					</div>
					<div id="wattbezugsolarworld">
						<div class="row" style="background-color:#febebe">
							<b><label for="solarworld_emanagerip">Solarworld IP:</label></b>
							<input type="text" name="solarworld_emanagerip" id="solarworld_emanagerip" value="<?php echo $solarworld_emanageripold ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP. IP Adresse des Solarworld eManager.
						</div>
					</div>

					<div id="wattbezugdiscovergy">
						<div class="row" style="background-color:#febebe">
							<b><label for="discovergyuser">Discovergy Username (Email):</label></b>
							<input type="text" name="discovergyuser" id="discovergyuser" value="<?php echo $mySettings->getSetting('discovergyuser') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="discovergypass">Discovergy Passwort:</label></b>
							<input type="text" name="discovergypass" id="discovergypass" value="<?php echo $mySettings->getSetting('discovergypass') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="discovergyevuid">Meter ID:</label></b>
							<input type="text" name="discovergyevuid" id="discovergyevuid" value="<?php echo $mySettings->getSetting('discovergyevuid') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte ID. Um die ID herauszufinden mit dem Browser die Adresse "https://api.discovergy.com/public/v1/meters" aufrufen und dort Benutzername und Passwort eingeben. Hier wird nun u.a. die ID des Zählers angezeigt.
						</div>
					</div>
					<div id="wattbezugkostalsmartenergymeter">
                                                <div class="row" style="background-color:#febebe">
                                                        <b><label for="ksemip">Kostal Smart Energy Meter / TQ EM410 - IP Adresse:</label></b>
                                                        <input type="text" name="ksemip" id="ksemip" value="<?php echo $ksemipold ?>"><br>
                                                </div>
                                        </div>
					<div id="wattbezugkostalpiko">
						<div class="row" style="background-color:#febebe">
							IP Adresse wird im PV Modul konfiguriert. Angeschlossenes Meter erforderlich. Der WR liefert Werte nur solange er auch PV Leistung liefert. Nachts geht er in den Standby.<br>
							Die Hausanschlussüberwachung ist nur aktiv wenn der Wechselrichter auch aktiv ist.<br>
							Ein extra PV-Modul muss nicht mehr ausgewählt werden.
						</div>
					</div>
					<div id="wattbezugplentihaus">
						<div class="row" style="background-color:#febebe">
							Dieses Modul erfordert als 1. PV-Modul das Modul "Kostal Plenticore". Dieses wird automatisch fest eingestellt. Der EM300 bzw. das KSEM muss am 1. Plenticore angeschlossen sein.
							Ein am 1. Plenticore angeschlossener Speicher wird ebenfalls ohne weitere Einstellung ausgelesen, das Speicher-Modul wird dazu entsprechend voreingestellt.
							Am 2. Plenticore darf kein Speicher angeschlossen sein, da dies die weiteren Berechnungen verfälscht.
							Die Einbauposition des EM300/KSEM (Hausverbrauchs-Zweig = Pos. 1 oder Netzanschluss-Zweig = Pos. 2) ist anzugeben.
						</div>
						<input type='hidden' value='0' name='kostalplenticorehaus'>
						<input id="kostalplenticorehaus" name="kostalplenticorehaus" value="1" type="checkbox" <?php if ( $mySettings->getSetting('kostalplenticorehaus') == 1){ echo "checked"; } ?> >
						<label for="kostalplenticorehaus">EM300/KSEM im Netzanschluss-Zweig (Pos. 2)</label>
					</div>
					<div id="wattbezugmpm3pm">
						<div class="row" style="background-color:#febebe">
							<b><label for="mpm3pmevusource">MPM3PM Zähler EVU Source:</label></b>
							<input type="text" name="mpm3pmevusource" id="mpm3pmevusource" value="<?php echo $mySettings->getSetting('mpm3pmevusource') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der MPM3PM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
							Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="mpm3pmevuid">MPM3PM Zähler EVU ID:</label></b>
							<input type="text" name="mpm3pmevuid" id="mpm3pmevuid" value="<?php echo $mySettings->getSetting('mpm3pmevuid') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte 1-254. Modbus ID des MPM3PM.
						</div>
						<input type='hidden' value='0' name='mpm3pmevuhaus'>
						<input id="mpm3pmevuhaus" name="mpm3pmevuhaus" value="1" type="checkbox" <?php if ( $mySettings->getSetting('mpm3pmevuhaus') == 1){ echo "checked"; } ?> >
						<label for="mpm3pmevuhaus">MPM3PM im Hausverbrauchszweig</label>
						<div class="row" style="background-color:#febebe">
							Wenn der MPM3PM EVU Zähler im Hausverbrauchszweig NACH den Ladepunkten angeschlossen ist hier ein Hacken setzen.<br>
							z.B. auch zu nutzen wenn der Ladepunkt an einem seperaten Rundsteuerempfänger(=extra Zähler) angeschlossen ist.<br>
							Bei gesetzten Hacken werden die Ladeströme der Ladepunkte zu den Strömen gemessen am EVU Zähler hinzuaddiert.<br>
							Somit ist ein Lastmanagement / Hausanschlussüberwachung möglich.
							Auf korrekte Verkabelung ist zu achten!<br>
							EVU L1, LP1 L1, LP2 L2<br>
							EVU L2, LP1 L2, LP2 L3<br>
							EVU L3, LP1 L3, LP2 L1
						</div>
					</div>
					<div id="wattbezugnone">
						<div class="row" style="background-color:#febebe">
							<b><label for="hausbezugnone">Angenommener Hausverbrauch:</label></b>
							<input type="text" name="hausbezugnone" id="hausbezugnone" value="<?php echo $mySettings->getSetting('hausbezugnone') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte Zahl. Wenn keine EVU Messung vorhanden ist kann hier ein Hausgrundverbrauch festgelegt werden.<br>
							Daraus resultierend agiert die PV Regelung bei vorhandenem PV-Modul
						</div>
					</div>
					<div id="wattbezugsdm">
						<div class="row" style="background-color:#febebe">
							<b><label for="sdm630modbusbezugsource">SDM 630 Zähler Source:</label></b>
							<input type="text" name="sdm630modbusbezugsource" id="sdm630modbusbezugsource" value="<?php echo $mySettings->getSetting('sdm630modbusbezugsource') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte /dev/ttyUSBx, /dev/virtualcomx. Das "x" steht für den Adapter. Dies kann 0,1,2, usw sein. Serieller Port an dem der SDM angeschlossen ist.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="sdm630modbusbezugid">Zähler ID:</label></b>
							<input type="text" name="sdm630modbusbezugid" id="sdm630modbusbezugid" value="<?php echo $mySettings->getSetting('sdm630modbusbezugid') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte 1-254. Modbus ID des SDM. Getestet SDM230 & SDM630v2.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="sdm630modbusbezuglanip">RS485/Lan-Konverter IP:</label></b>
							<input type="text" name="sdm630modbusbezuglanip" id="sdm630modbusbezuglanip" value="<?php echo $mySettings->getSetting('sdm630modbusbezuglanip') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP. Ist die source "virtualcomX" wird automatisch ein Lan Konverter genutzt.
						</div>
					</div>
					<div id="wattbezugvz">
						<div class="row" style="background-color:#febebe">
							<b><label for="vzloggerip">Vzlogger IP Adresse inkl Port:</label></b>
							<input type="text" name="vzloggerip" id="vzloggerip" value="<?php echo $mySettings->getSetting('vzloggerip') ?>"><br>
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP:Port z.B. 192.168.0.12:8080.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="vzloggerline">Vzlogger Watt Zeile:</label></b>
							<input type="text" name="vzloggerline" id="vzloggerline" value="<?php echo $mySettings->getSetting('vzloggerline') ?>"><br>
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte z.B. Zahl. Bitte auf der Shell ausführen: "curl -s IPdesVZLogger:Port/ | jq ."<br>
							Nun zählen in welcher Zeile die aktullen Watt stehen und diesen hier eintragen.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="vzloggerline">Vzlogger Bezug kWh Zeile:</label></b>
							<input type="text" name="vzloggerkwhline" id="vzloggerkwhline" value="<?php echo $mySettings->getSetting('vzloggerkwhline') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte z.B. Zahl. Bitte auf der Shell ausführen: "curl -s IPdesVZLogger:Port/ | jq ."<br>
							Nun zählen in welcher Zeile die Gesamt kWh stehen und diesen hier eintragen. Der Wert dient rein dem Logging. Wird dieses nicht genutzt oder ist der Wert nicht verfügbar bitte auf "none" setzen, dann wird die Abfrage nicht ausgeführt.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="vzloggerline">Vzlogger Einspeisung kWh Zeile:</label></b>
							<input type="text" name="vzloggerekwhline" id="vzloggerekwhline" value="<?php echo $mySettings->getSetting('vzloggerekwhline') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte z.B. Zahl. Bitte auf der Shell ausführen: "curl -s IPdesVZLogger:Port/ | jq ."<br>
							Nun zählen in welcher Zeile die Gesamt eingespeisten kWh stehen und diesen hier eintragen.
						</div>
					</div>
					<div id="wattbezughttp">
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_http_w_url">Vollständige URL für den Watt Bezug</label></b>
							<input type="text" name="bezug_http_w_url" id="bezug_http_w_url" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_http_w_url')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als "-" (für Einspeisung) oder "0-9" wird der Wert auf null gesetzt. Der Wert muss in Watt sein.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_http_ikwh_url">Vollständige URL für den kWh Bezug</label></b>
							<input type="text" name="bezug_http_ikwh_url" id="bezug_http_ikwh_url" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_http_ikwh_url')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Der Wert muss in WattStunden sein. Der Wert dient rein dem Logging. Wird dieses nicht genutzt oder ist der Wert nicht verfügbar bitte auf "none" setzen, dann wird die Abfrage nicht ausgeführt.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_http_ekwh_url">Vollständige URL für die kWh Einspeisung</label></b>
							<input type="text" name="bezug_http_ekwh_url" id="bezug_http_ekwh_url" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_http_ekwh_url')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Der Wert muss in WattStunden sein. Der Wert dient rein dem Logging. Wird dieses nicht genutzt oder ist der Wert nicht verfügbar bitte auf "none" setzen, dann wird die Abfrage nicht ausgeführt.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_http_l1_url">Vollständige URL für die Ampere Phase 1</label></b>
							<input type="text" name="bezug_http_l1_url" id="bezug_http_l1_url" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_http_l1_url')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als "-" (für Einspeisung) oder "0-9" wird der Wert auf null gesetzt. Der Wert muss in Ampere sein. Bei nicht Nutzung auf none setzen.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_http_l2_url">Vollständige URL für die Ampere Phase 2</label></b>
							<input type="text" name="bezug_http_l2_url" id="bezug_http_l2_url" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_http_l2_url')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als "-" (für Einspeisung) oder "0-9" wird der Wert auf null gesetzt. Der Wert muss in Ampere sein. Bei nicht Nutzung auf none setzen.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_http_l3_url">Vollständige URL für die Ampere Phase 3</label></b>
							<input type="text" name="bezug_http_l3_url" id="bezug_http_l3_url" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_http_l3_url')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als "-" (für Einspeisung) oder "0-9" wird der Wert auf null gesetzt. Der Wert muss in Ampere sein. Bei nicht Nutzung auf none setzen.
						</div>
					</div>
					<div id="wattbezugsmartme">
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_smartme_user">Smartme Benutzername</label></b>
							<input type="text" name="bezug_smartme_user" id="bezug_smartme_user" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_smartme_user')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Smartme Benutzername
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_smartme_pass">Smartme Passwort</label></b>
							<input type="text" name="bezug_smartme_pass" id="bezug_smartme_pass" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_smartme_pass')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Smartme Passwort
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_smartme_url">Smartme Url</label></b>
							<input type="text" name="bezug_smartme_url" id="bezug_smartme_url" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_smartme_url')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Smartme Url
						</div>
					</div>
					<div id="wattbezugshm">
						<div class="row" style="background-color:#febebe">
							<b><label for="smaeshmbezugid">Seriennummer des SMA Home Manager</label></b>
							<input type="text" name="smashmbezugid" id="smaeshmbezugid" value="<?php echo $mySettings->getSetting('smashmbezugid') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte: Seriennummer. Hier die Seriennummer des SMA Meter für Bezug/Einspeisung anzugeben. Ist nur erforderlich wenn mehrere SMA HomeManager in Betrieb sind, ansonsten none eintragen. Funktioniert auch mit Energy Meter statt Home Manager.
						</div>
					</div>
					<div id="wattbezugsmartfox">
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_smartfox_ip">Ip Adresse des SmartFox</label></b>
							<input type="text" name="bezug_smartfox_ip" id="bezug_smartfox_ip" value="<?php echo $mySettings->getSetting('bezug_smartfox_ip') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP Adresse.
						</div>
					</div>
					<div id="wattbezugsma">
						<div class="row" style="background-color:#febebe">
							<b><label for="smaemdbezugid">Seriennummer des SMA Energy Meter</label></b>
							<input type="text" name="smaemdbezugid" id="smaemdbezugid" value="<?php echo $mySettings->getSetting('smaemdbezugid') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte Seriennummer. Hier die Seriennummer des SMA Meter für Bezug/Einspeisung angeben<br>
							Infos zum SMA Energy Meter <a href="https://github.com/snaptec/openWB#extras">HIER</a>
						</div>
					</div>
					<div id="wattbezugfronius">
						<div class="row" style="background-color:#febebe">
							Die IP des Wechselrichters wird im dazugehörigen Fronius PV-Modul eingestellt.
						</div>
						<input type='hidden' value='0' name='froniusprimo'>
						<input id="froniusprimo" name="froniusprimo" value="1" type="checkbox" <?php if ( $mySettings->getSetting('froniusprimo') == 1){ echo "checked"; } ?> >
						<label for="froniusprimo">Kompatibilitätsmodus für die Primo Reihe</label>
					</div>
					<div id="wattbezugjson">
						<div class="row" style="background-color:#febebe">
							<b><label for="bezugjsonurl">Bezug URL:</label></b>
							<input type="text" name="bezugjsonurl" id="bezugjsonurl" value="<?php echo $mySettings->getSetting('bezugjsonurl') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte URL. Vollständige URL die die Json Antwort enthält.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezugjsonwatt">Json Abfrage für Watt:</label></b>
							<input type="text" name="bezugjsonwatt" id="bezugjsonwatt" value="<?php echo $mySettings->getSetting('bezugjsonwatt') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Der hier eingetragene Befehl reduziert die Json Abfrage auf das wesentliche.<br>
							Im Hintergrund wird der Befehl jq benutzt.<br>
							Ist die Json Antwort z.B."{"PowerInstalledPeak":4655,"PowerProduced":132,"PowerOut":897.08172362555717,"PowerSelfSupplied":234.9182763744428}" So muss hier - .PowerOut - ohne die - - eingetragen werden.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezugjsonkwh">Json Abfrage für Bezug kWh:</label></b>
							<input type="text" name="bezugjsonkwh" id="bezugjsonkwh" value="<?php echo $mySettings->getSetting('bezugjsonkwh') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Der hier eingetragene Befehl reduziert die Json Abfrage auf das wesentliche.<br>
							Im Hintergrund wird der Befehl jq benutzt.<br>
							Ist die Json Antwort z.B."{"PowerInstalledPeak":4655,"PowerProduced":132,"PowerOut":897.08172362555717,"PowerSelfSupplied":234.9182763744428}" So muss hier - .PowerProduced - ohne die - - eingetragen werden
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="bezugjsonkwh">Json Abfrage für Einspeisung kWh:</label></b>
							<input type="text" name="einspeisungjsonkwh" id="einspeisungjsonkwh" value="<?php echo $mySettings->getSetting('einspeisungjsonkwh') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Der hier eingetragene Befehl reduziert die Json Abfrage auf das wesentliche.<br>
							Im Hintergrund wird der Befehl jq benutzt.<br>
							Ist die Json Antwort z.B."{"PowerInstalledPeak":4655,"PowerProduced":132,"PowerOut":897.08172362555717,"PowerSelfSupplied":234.9182763744428}" So muss hier - .PowerSelfSupplied - ohne die - - eingetragen werden.
						</div>
					</div>
					<div id="wattbezugsolarlog">

						<div class="row" style="background-color:#febebe">
							Die zugehörige IP Adresse ist im PV Modul einzustellen.
						</div>
						<div class="row">
							<b><label for="bezug_solarlog_speicherv">Kompatibilitätsmodus bei vorhandenem Speicher:</label></b>
							<select name="bezug_solarlog_speicherv" id="bezug_solarlog_speicherv">
								<option <?php if($mySettings->getSetting('bezug_solarlog_speicherv') == 0) echo "selected" ?> value="0">Nein</option>
								<option <?php if($mySettings->getSetting('bezug_solarlog_speicherv') == 1) echo "selected" ?> value="1">Ja</option>
							</select>
						</div>
					</div>
					<div id="wattbezugsolaredge">
						<div class="row" style="background-color:#febebe">
							<b><label for="solaredgeip">IP Adresse des SolarEdge</label></b>
							<input type="text" name="solaredgeip" id="solaredgeip" value="<?php echo htmlspecialchars($mySettings->getSetting('solaredgeip')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP.<br>
							Hierfür muss ein EVU Zähler am SolarEdge Wechselrichter per Modbus angebunden sein.<br>
							Ebenso muss ModbusTCP am Wechselrichter aktiviert werden
						</div>
					</div>
					<div id="wattbezuge3dc">
						<div class="row" style="background-color:#febebe">
							Die IP des Speichers wird im dazugehörigen E3DC Speicher-Modul eingestellt.<br>
							Es kann nötig sein in den Einstellungen des E3DC ModbusTCP zu aktivieren.<br>
							Das Protokoll in den E3DC Einstellungen ist auf E3DC zu stellen.
						</div>
					</div>
					<div id="wattbezugsbs25">
						<div class="row" style="background-color:#febebe">
							Die IP des Speichers wird im dazugehörigen SMA SBS 2.5 Speicher-Modul eingestellt.
						</div>
					</div>

					<div class="row">
						<h4>
							<b><label for="evuglaettungakt">EVU Glättung:</label></b>
							<select name="evuglaettungakt" id="evuglaettungakt">
								<option <?php if($mySettings->getSetting('evuglaettungakt') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('evuglaettungakt') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h4>
					</div>

					<div id="evuglaettungdiv">
						<div class="row" style="background-color:#febebe">
							<b><label for="evuglaettung">Glättung der EVU Werte:</label></b>
							<input type="text" name="evuglaettung" id="evuglaettung" value="<?php echo $mySettings->getSetting('evuglaettung') ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte: Zeit in Sekunden, z.B. 30,50,200.<br>
							Kombiniert die EVU Werte der letzten x Sekunden und bildet einen Mittelwert darüber.<br>
							Sinnvoll, wenn öfter kurze Lastspitzen auftreten.<br>
							Der Durchschnittswert wird auf der Hauptseite in Klammern angezeigt.
						</div>
					</div>

					<script>
						$(function() {
							if($('#evuglaettungakt').val() == '0') {
								$('#evuglaettungdiv').hide();
							} else {
								$('#evuglaettungdiv').show();
							}

							$('#evuglaettungakt').change(function(){
								if($('#evuglaettungakt').val() == '0') {
									$('#evuglaettungdiv').hide();
								} else {
									$('#evuglaettungdiv').show();
								}
							});
						});

						function enable_pv_selector() {
							// enable das Dropdown-Element zur Auswahl des PV-Moduls
							document.getElementById("pvwattmodul").disabled=false;
						}

						function disable_pv_selector() {
							// disable das Dropdown-Element zur Auswahl des PV-Moduls
							document.getElementById("pvwattmodul").disabled=true;
						}

						function display_wattbezugmodul() {
							$('#wattbezugvz').hide();
							$('#wattbezugsdm').hide();
							$('#wattbezugnone').hide();
							$('#wattbezughttp').hide();
							$('#wattbezugsma').hide();
							$('#wattbezugsolarworld').hide();
							$('#wattbezugfronius').hide();
							$('#wattbezugjson').hide();
							$('#wattbezugmpm3pm').hide();
							$('#wattbezugsolarlog').hide();
							$('#wattbezugsolaredge').hide();
							$('#wattbezugshm').hide();
							$('#wattbezugsmartme').hide();
							$('#wattbezugsbs25').hide();
							$('#wattbezuge3dc').hide();
							$('#wattbezugethmpm3pm').hide();
							$('#wattbezugplentihaus').hide();
							$('#wattbezugkostalpiko').hide();
							$('#wattbezugkostalsmartenergymeter').hide();
							$('#wattbezugsmartfox').hide();
							$('#wattbezugpowerwall').hide();
							$('#wattbezugvictrongx').hide();
							$('#wattbezugsolarview').hide();
							$('#wattbezugdiscovergy').hide();
							$('#wattbezuglgessv1').hide();
							$('#wattbezugmqtt').hide();
							$('#wattbezugsonneneco').hide();
							$('#wattbezugfems').hide();

							// Auswahl PV-Modul generell erlauben
							enable_pv_selector();
							if($('#wattbezugmodul').val() == 'bezug_sonneneco') {
								$('#wattbezugsonneneco').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_fems') {
								$('#wattbezugfems').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_solarworld') {
								$('#wattbezugsolarworld').show();
							}

							if($('#wattbezugmodul').val() == 'bezug_solarview') {
								$('#wattbezugsolarview').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_discovergy') {
								$('#wattbezugdiscovergy').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_mqtt') {
								$('#wattbezugmqtt').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_victrongx') {
								$('#wattbezugvictrongx').show();
							}
							if($('#wattbezugmodul').val() == 'vzlogger') {
								$('#wattbezugvz').show();
							}
							if($('#wattbezugmodul').val() == 'sdm630modbusbezug')   {
								$('#wattbezugsdm').show();
							}
							if($('#wattbezugmodul').val() == 'none')   {
								$('#wattbezugnone').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_http')   {
								$('#wattbezughttp').show();
							}
							if($('#wattbezugmodul').val() == 'smaemd_bezug')   {
						 		$('#wattbezugsma').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_fronius_sm')   {
								$('#wattbezugfronius').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_fronius_s0')   {
								$('#wattbezugfronius').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_json')   {
								$('#wattbezugjson').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_mpm3pm')   {
								$('#wattbezugmpm3pm').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_solarlog')   {
								$('#wattbezugsolarlog').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_solaredge')   {
								$('#wattbezugsolaredge').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_smashm')   {
								$('#wattbezugshm').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_smartme')   {
								$('#wattbezugsmartme').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_e3dc')   {
								$('#wattbezuge3dc').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_ethmpm3pm')   {
								$('#wattbezugethmpm3pm').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_sbs25')   {
								$('#wattbezugsbs25').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_kostalplenticoreem300haus')   {
								$('#wattbezugplentihaus').show();
								// keine Auswahl PV-Modul in dieser Konfiguration
								// Plenticore immer fix auswählen
								document.getElementById('pvwattmodul').value = 'wr_plenticore';
								// und Einstellung sperren
								disable_pv_selector();
								display_pvwattmodul();
								// passendes Speichermodul 'optisch' voreinstellen, da automatisch alle Werte
								// mit aus dem WR gelesen werden
								//document.getElementById('speichermodul').value = 'speicher_kostalplenticore';
								//display_speichermodul();
							}
							if($('#wattbezugmodul').val() == 'bezug_kostalpiko')   {
								$('#wattbezugkostalpiko').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_ksem')   {
                                                                $('#wattbezugkostalsmartenergymeter').show();
                                                        }
							if($('#wattbezugmodul').val() == 'bezug_smartfox')   {
								$('#wattbezugsmartfox').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_powerwall')   {
								$('#wattbezugpowerwall').show();
							}
							if($('#wattbezugmodul').val() == 'bezug_lgessv1')   {
								$('#wattbezuglgessv1').show();
							}
						}

						$(function() {
							display_wattbezugmodul();
							$('#wattbezugmodul').change( function(){
								display_wattbezugmodul();
							});
						});
					</script>

					<div class="row">
						<h3> PV-Modul </h3>
					</div>
					<div class="row">
						<b><label for="pvwattmodul">PV-Modul:</label></b>
						<select name="pvwattmodul" id="pvwattmodul">
							<option <?php if($mySettings->getSetting('pvwattmodul') == "none") echo "selected" ?> value="none">Nicht vorhanden</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_ethmpm3pmaevu") echo "selected" ?> value="wr_ethmpm3pmaevu">MPM3PM an openWB EVU Kit</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_ethsdm120") echo "selected" ?> value="wr_ethsdm120">SDM120 an openWB Modbus Lan Konverter</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_fronius") echo "selected" ?> value="wr_fronius">Fronius WR</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "sdm630modbuswr") echo "selected" ?> value="sdm630modbuswr">SDM 630 Modbus</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "vzloggerpv") echo "selected" ?> value="vzloggerpv">VZLogger</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_http") echo "selected" ?> value="wr_http">WR mit URL abfragen</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "smaemd_pv") echo "selected" ?> value="smaemd_pv">SMA Energy Meter</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_json") echo "selected" ?> value="wr_json">WR mit Json abfragen</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "mpm3pmpv") echo "selected" ?> value="mpm3pmpv">MPM3PM </option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_kostalpiko") echo "selected" ?> value="wr_kostalpiko">Kostal Piko</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_solaredge") echo "selected" ?> value="wr_solaredge">SolarEdge WR</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_smartme") echo "selected" ?> value="wr_smartme">SmartMe</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_tripower9000") echo "selected" ?> value="wr_tripower9000">SMA ModbusTCP WR</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_plenticore") echo "selected" ?> value="wr_plenticore">Kostal Plenticore</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_solarlog") echo "selected" ?> value="wr_solarlog">SolarLog</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_kostalpikovar2") echo "selected" ?> value="wr_kostalpikovar2">Kostal Piko alt</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_powerwall") echo "selected" ?> value="wr_powerwall">Tesla Powerwall</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_solarview") echo "selected" ?> value="wr_solarview">Solarview</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_discovergy") echo "selected" ?> value="wr_discovergy">Discovergy</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_youless120") echo "selected" ?> value="wr_youless120">Youless 120</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_lgessv1") echo "selected" ?> value="wr_lgessv1">LG ESS 1.0VI</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_mqtt") echo "selected" ?> value="wr_mqtt">MQTT</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_sunways") echo "selected" ?> value="wr_sunways">Sunways</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_fems") echo "selected" ?> value="wr_fems">Fenecon FEMS</option>
							<option <?php if($mySettings->getSetting('pvwattmodul') == "wr_solarworld") echo "selected" ?> value="wr_solarworld">Solarworld</option>
						</select>
					</div>

					<div id="pvnone">
					</div>
					<div id="pvmqtt">
							<div class="row">Keine Konfiguration erforderlich</div>
							<div class="row">Per MQTT zu schreiben:</div>
							<div class="row"><b>"openWB/set/pv/W"</b></div>
							<div class="row">PVleistung in Watt, int, negativ</div>
							<div class="row"><b>"openWB/set/pv/WhCounter"</b></div>
							<div class="row">Erzeugte Energie in Wh, float, nur positiv</div>
					</div>
					<div id="pvlgessv1">
						<div class="row">
							Konfiguration im zugehörigen Speichermodul des LG ESS 1.0VI erforderlich. Als PV-Modul auch LG ESS 1.0VI wählen!
						</div>
					</div>
					<div id="pvfems">
						<div class="row">
							Konfiguration im zugehörigen EVU Modul des FEMS erforderlich.
						</div>
					</div>
					<div id="pvsolarworld">
						<div class="row">
							Konfiguration im zugehörigen EVU Modul des Solarworld erforderlich.
						</div>
					</div>

					<div id="pvyouless">
						<div class="row" style="background-color:#febebe">
							<b><label for="wryoulessip">IP Adresse des Youless</label></b>
							<input type="text" name="wryoulessip" id="wryoulessip" value="<?php echo htmlspecialchars($mySettings->getSetting('wryoulessip')); ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP.
						</div>
					</div>
					<div id="pvsunways">
						<div class="row" style="background-color:#febebe">
							<b><label for="wrsunwaysip">IP Adresse des Sunways</label></b>
							<input type="text" name="wrsunwaysip" id="wrsunwaysip" value="<?php echo htmlspecialchars($mySettings->getSetting('wrsunwaysip')); ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP.<br>
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="wrsunwayspw">Passwort des Sunways</label></b>
							<input type="text" name="wrsunwayspw" id="wrsunwayspw" value="<?php echo htmlspecialchars($mySettings->getSetting('wrsunwayspw')); ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte Passwort.
						</div>

					</div>

					<div id="pvsolarlog">
						<div class="row" style="background-color:#febebe">
							<b><label for="bezug_solarlog_ip">IP Adresse des SolarLog</label></b>
							<input type="text" name="bezug_solarlog_ip" id="bezug_solarlog_ip" value="<?php echo htmlspecialchars($mySettings->getSetting('bezug_solarlog_ip')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP. Wenn ein Eigenverbrauchszähler installiert ist bitte EVU SolarLog Modul nutzen. Wenn nicht dann dieses Modul.
						</div>
					</div>
					<div id="pvdiscovergy">
						<div class="row" style="background-color:#febebe">
							<b><label for="discovergypvid">Meter ID des Zählers</label></b>
							<input type="text" name="discovergypvid" id="discovergypvid" value="<?php echo htmlspecialchars($mySettings->getSetting('discovergypvid')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte ID. Um die ID herauszufinden mit dem Browser die Adresse "https://api.discovergy.com/public/v1/meters" aufrufen und dort Benutzername und Passwort eingeben. Hier wird nun u.a. die ID des Zählers angezeigt.<br>
							Die Benutzerdaten werden im Discovergy EVU Modul konfiguriert.
						</div>
					</div>
					<div id="pvsolarview">
						<div class="row" style="background-color:#febebe">
							<b><label for="solarview_hostname">IP Adresse des Solarview</label></b>
							<input type="text" name="solarview_hostname" id="solarview_hostname" value="<?php echo htmlspecialchars($mySettings->getSetting('solarview_hostname')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte IP.
						</div>
						<div class="row" style="background-color:#febebe">
							<b><label for="solarview_port">Port des Solarview</label></b>
							<input type="text" name="solarview_port" id="solarview_port" value="<?php echo htmlspecialchars($mySettings->getSetting('solarview_port')) ?>">
						</div>
						<div class="row" style="background-color:#febebe">
							Gültige Werte Port, z.B. 80.
						</div>
					</div>
					<div id="pvpowerwall">
						<div class="row" style="background-color:#febebe">
							Keine Einstellung nötig. Die IP wird im Speichermodul konfiguriert
						</div>
					</div>
					<div id="pvmpmevu">
						<div class="row" style="background-color:#febebe">
							<b><label for="pvkitversion">Version des openWB PV Kits:</label></b>
							<select name="pvkitversion" id="pvkitversion">
								<option <?php if($mySettings->getSetting('pvkitversion') == 0) echo "selected" ?> value="0">PV Kit</option>
								<option <?php if($mySettings->getSetting('pvkitversion') == 1) echo "selected" ?> value="1">PV Kit v2</option>
							</select>
						</div>
					</div>
					<div id="pvplenti">
						<div class="row" style="background-color:#befebe">
							<b><label for="kostalplenticoreip">IP Adresse des 1. Kostal Plenticore:</label></b>
							<input type="text" name="kostalplenticoreip" id="kostalplenticoreip" value="<?php echo $mySettings->getSetting('kostalplenticoreip') ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Gültige Werte: IP-Adresse des 1. Kostal Plenticore. An diesem muss (wenn vorhanden) der EM300/das KSEM und ggf. Speicher angeschlossen sein. Modbus/Sunspec (TCP) muss im WR aktiviert sein (Port 1502, Unit-ID 71).
						</div>
						<div class="row" style="background-color:#befebe">
							<b><label for="name_wechselrichter1">Bezeichnung des 1. Kostal Plenticore:</label></b>
							<input type="text" name="name_wechselrichter1" id="name_wechselrichter1" value="<?php echo $mySettings->getSetting('name_wechselrichter1') ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Gültige Werte: Freie Bezeichnung des Wechselrichters zu Anzeigezwecken, kann leer bleiben.
						</div>
						<div class="row" style="background-color:#befebe">
							<b><label for="kostalplenticoreip2">IP Adresse des 2. Kostal Plenticore:</label></b>
							<input type="text" name="kostalplenticoreip2" id="kostalplenticoreip2" value="<?php echo $mySettings->getSetting('kostalplenticoreip2') ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Gültige Werte: IP-Adresse des 2. Kostal Plenticore oder "none". An diesem WR darf kein Speicher angeschlossen sein. Wenn nur ein WR genutzt wird, muss der Wert "none" gesetzt werden, ansonsten muss Modbus/Sunspec (TCP) im WR aktiviert sein (Port 1502, Unit-ID 71).
						</div>
						<div class="row" style="background-color:#befebe">
							<b><label for="name_wechselrichter2">Bezeichnung des 2. Kostal Plenticore:</label></b>
							<input type="text" name="name_wechselrichter2" id="name_wechselrichter2" value="<?php echo $mySettings->getSetting('name_wechselrichter2') ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Gültige Werte: Freie Bezeichnung des zweiten Wechselrichters zu Anzeigezwecken, kann leer bleiben.
						</div>
					</div>
					<div id="pvsmartme">
						<div class="row" style="background-color:#befebe">
							<b><label for="wr_smartme_user">Smartme Benutzername</label></b>
							<input type="text" name="wr_smartme_user" id="wr_smartme_user" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_smartme_user')) ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Smartme Benutzername
						</div>
						<div class="row" style="background-color:#befebe">
							<b><label for="wr_smartme_pass">Smartme Passwort</label></b>
							<input type="text" name="wr_smartme_pass" id="wr_smartme_pass" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_smartme_pass')) ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Smartme Passwort
						</div>
						<div class="row" style="background-color:#befebe">
							<b><label for="wr_smartme_url">Smartme Url</label></b>
							<input type="text" name="wr_smartme_url" id="wr_smartme_url" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_smartme_url')) ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Smartme Url
						</div>
					</div>
					<div id="pvpiko2">
						<div class="row" style="background-color:#befebe">
							<b><label for="wr_piko2_user">Benutzername</label></b>
							<input type="text" name="wr_piko2_user" id="wr_piko2_user" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_piko2_user')) ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Piko Benutzername
						</div>
						<div class="row" style="background-color:#befebe">
							<b><label for="wr_piko2_pass">Passwort</label></b>
							<input type="text" name="wr_piko2_pass" id="wr_piko2_pass" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_piko2_pass')) ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Piko Passwort
						</div>
						<div class="row" style="background-color:#befebe">
							<b><label for="wr_piko2_url">Url</label></b>
							<input type="text" name="wr_piko2_url" id="wr_piko2_url" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_piko2_url')) ?>">
						</div>
						<div class="row" style="background-color:#befebe">
							Piko Url
						</div>
					</div>
					<div id="pvwrjson">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrjsonurl">WR URL:</label></b>
							<input type="text" name="wrjsonurl" id="wrjsonurl" value="<?php echo $mySettings->getSetting('wrjsonurl') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte URL. Vollständige URL die die Json Antwort enthält.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrjsonwatt">Json Abfrage für Watt:</label></b>
							<input type="text" name="wrjsonwatt" id="wrjsonwatt" value="<?php echo $mySettings->getSetting('wrjsonwatt') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Der hier eingetragene Befehl reduziert die Json Abfrage auf das wesentliche.<br>
							Im Hintergrund wird der Befehl jq benutzt.<br>
							Ist die Json Antwort z.B."{"PowerInstalledPeak":4655,"PowerProduced":132,"PowerOut":897.08172362555717,"PowerSelfSupplied":234.9182763744428}" So muss hier - .PowerOut - ohne die - - eingetragen werden
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrjsonkwh">Json Abfrage für kWh:</label></b>
							<input type="text" name="wrjsonkwh" id="wrjsonkwh" value="<?php echo $mySettings->getSetting('wrjsonkwh') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Der hier eingetragene Befehl reduziert die Json Abfrage auf das wesentliche.<br>
							Im Hintergrund wird der Befehl jq benutzt.<br>
							Ist die Json Antwort z.B."{"PowerInstalledPeak":4655,"PowerProduced":132,"PowerOut":897.08172362555717,"PowerSelfSupplied":234.9182763744428}" So muss hier - .PowerProduced - ohne die - - eingetragen werden
						</div>
					</div>
					<div id="pvwrkostalpiko">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrfroniusip">WR Kostal Piko IP:</label></b>
							<input type="text" name="wrkostalpikoip" id="wrkostalpikoip" value="<?php echo $mySettings->getSetting('wrkostalpikoip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP. IP Adresse Kostal Wechselrichter.
						</div>
					</div>
					<div id="pvwrtri9000">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="tri9000ip">SMA WR IP:</label></b>
							<input type="text" name="tri9000ip" id="tri9000ip" value="<?php echo $mySettings->getSetting('tri9000ip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte: IPs. IP Adresse des SMA WR, ggf. muss der modbusTCP im WR noch aktiviert werden (normalerweise deaktiviert, entweder direkt am Wechselrichter, per Sunny Portal oder über das Tool "Sunny Explorer").
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrsmawebbox">Handelt es sich um eine SMA Webbox?:</label></b>
							<select name="wrsmawebbox" id="wrsmawebbox">
								<option <?php if($mySettings->getSetting('wrsmawebbox') == 0) echo "selected" ?> value="0">Nein</option>
								<option <?php if($mySettings->getSetting('wrsmawebbox') == 1) echo "selected" ?> value="1">Ja</option>
							</select>
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrsma2ip">WR 2 IP:</label></b>
							<input type="text" name="wrsma2ip" id="wrsma2ip" value="<?php echo $mySettings->getSetting('wrsma2ip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte: IP Adresse oder "none". IP des zweiten SMA Wechselrichters. Wenn nur ein WR genutzt wird, muss der Wert "none" gesetzt werden.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrsma3ip">WR 3 IP:</label></b>
							<input type="text" name="wrsma3ip" id="wrsma3ip" value="<?php echo $mySettings->getSetting('wrsma3ip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte: IP Adresse oder "none". IP des dritten SMA Wechselrichters. Wenn nur zwei WR genutzt werden, muss der Wert "none" gesetzt werden.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrsma4ip">WR 4 IP:</label></b>
							<input type="text" name="wrsma4ip" id="wrsma4ip" value="<?php echo $mySettings->getSetting('wrsma4ip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte: IP Adresse oder "none". IP des vierten SMA Wechselrichters. Wenn nur drei WR genutzt werden, muss der Wert "none" gesetzt werden.
						</div>
					</div>
					<div id="pvwrsolaredge">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="solaredgepvip">WR Solaredge IP:</label></b>
							<input type="text" name="solaredgepvip" id="solaredgepvip" value="<?php echo $mySettings->getSetting('solaredgepvip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP. IP Adresse des SolarEdge Wechselrichters.Modbus TCP muss am WR aktiviert werden, der Port ist auf 502 zu stellen.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="solaredgepvslave1">WR 1 Solaredge ID:</label></b>
							<input type="text" name="solaredgepvslave1" id="solaredgepvslave1" value="<?php echo $mySettings->getSetting('solaredgeipslave1') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte Zahl. ID des SolarEdge Wechselrichters. Normalerweise 1.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="solaredgepvslave2">WR 2 Solaredge ID:</label></b>
							<input type="text" name="solaredgepvslave2" id="solaredgepvslave2" value="<?php echo $mySettings->getSetting('solaredgeipslave2') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte Zahl oder none. ID des zweiten SolarEdge Wechselrichters. Wenn nur ein WR genutzt wird auf none setzen.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="solaredgepvslave3">WR 3 Solaredge ID:</label></b>
							<input type="text" name="solaredgepvslave3" id="solaredgepvslave3" value="<?php echo $mySettings->getSetting('solaredgeipslave3') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte Zahl oder none. ID des dritten SolarEdge Wechselrichters. Wenn nur ein oder zwei WRs genutzt werden auf none setzen.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="solaredgewr2ip">WR 2 Solaredge IP:</label></b>
							<input type="text" name="solaredgewr2ip" id="solaredgewr2ip" value="<?php echo $mySettings->getSetting('solaredgewr2ip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP oder none. IP des zweiten SolarEdge Wechselrichters. Ist nur nötig wenn 2 Wechselrichter genutzt werden die nicht per Modbus miteinander verbunden sind.
						</div>
					</div>
					<div id="pvwrfronius">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrfroniusip">WR Fronius IP:</label></b>
							<input type="text" name="wrfroniusip" id="wrfroniusip" value="<?php echo $mySettings->getSetting('wrfroniusip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP. IP Adresse des Fronius Wechselrichters. Werden hier und im Feld unten zwei verschiedene Adressen eingetragen, muss hier die Adresse des Wechselrichters stehen, an dem das SmartMeter angeschlossen ist.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wrfronius2ip">WR Fronius 2 IP:</label></b>
							<input type="text" name="wrfronius2ip" id="wrfronius2ip" value="<?php echo $mySettings->getSetting('wrfronius2ip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP. IP Adresse des zweiten Fronius Wechselrichters. Sind nur Symos in Nutzung, welche über Fronius Solar Net / DATCOM miteinander verbunden sind, reicht die Angabe der Adresse eines Wechselrichters im ersten Feld. Sind aber z.B. Symo und Symo Hybrid im Einsatz, müssen diese beide angegeben werden (hier dann die Adresse des Wechselrichters, an dem das SmartMeter NICHT angeschlossen ist). Ist kein zweiter Wechselrichter vorhanden, dann bitte hier "none" eintragen.
						</div>
					</div>
					<div id="pvmpm3pm">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="mpm3pmpvsource">MPM3PM Wechselrichterleistung Source:</label></b>
							<input type="text" name="mpm3pmpvsource" id="mpm3pmpvsource" value="<?php echo $mySettings->getSetting('mpm3pmpvsource') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der MPM3PM angeschlossen ist. Meist /dev/ttyUSB0<br>
							Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="mpm3pmpvid">MPM3PM Wechselrichterleistung ID:</label></b>
							<input type="text" name="mpm3pmpvid" id="mpm3pmpvid" value="<?php echo $mySettings->getSetting('mpm3pmpvid') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte 1-254. Modbus ID des MPM3PM.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="mpm3pmpvlanip">IP des Modbus/Lan Konverter:</label></b>
							<input type="text" name="mpm3pmpvlanip" id="mpm3pmpvlanip" value="<?php echo $mySettings->getSetting('mpm3pmpvlanip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP. Ist die source "virtualcomX" wird automatisch ein Lan Konverter genutzt, ansonsten irrelevant.
						</div>
					</div>
					<div id="pvethsdm120">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wr_sdm120ip">SDM Modbus IP Adresse:</label></b>
							<input type="text" name="wr_sdm120ip" id="wr_sdm120ip" value="<?php echo $mySettings->getSetting('wr_sdm120ip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP. IP Adresse des ModbusLAN Konverters.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wr_sdm120id">SDM Modbus ID:</label></b>
							<input type="text" name="wr_sdm120id" id="wr_sdm120id" value="<?php echo $mySettings->getSetting('wr_sdm120id') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte 1-254. Modbus ID des SDM.
						</div>
					</div>
					<div id="pvsdmwr">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="sdm630modbuswrsource">SDM Modbus Wechselrichterleistung Source:</label></b>
							<input type="text" name="sdm630modbuswrsource" id="sdm630modbuswrsource" value="<?php echo $mySettings->getSetting('sdm630modbuswrsource') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte /dev/ttyUSB0, /dev/virtualcomX. Serieller Port an dem der SDM in der Wallbox angeschlossen ist. Meist /dev/ttyUSB0<br>
							Nach ändern der Einstellung von ttyUSB auf virtualcom0 ist ein Neustart erforderlich
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="sdm630modbuswrid">SDM Modbus Wechselrichterleistung ID:</label></b>
							<input type="text" name="sdm630modbuswrid" id="sdm630modbuswrid" value="<?php echo $mySettings->getSetting('sdm630modbuswrid') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte 1-254. Modbus ID des SDM. Getestet SDM230 & SDM630v2.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="sdm630modbuswrlanip">IP des Modbus/Lan Konverter:</label></b>
							<input type="text" name="sdm630modbuswrlanip" id="sdm630modbuswrlanip" value="<?php echo $mySettings->getSetting('sdm630modbuswrlanip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP. Ist die source "virtualcomX" wird automatisch ein Lan Konverter genutzt.
						</div>
					</div>
					<div id="pvvzl">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="vzloggerpvip">Vzloggerpv IP Adresse inkl Port:</label></b>
							<input type="text" name="vzloggerpvip" id="vzloggerpvip" value="<?php echo $mySettings->getSetting('vzloggerpvip') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte IP:Port z.B. 192.168.0.12:8080.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="vzloggerpvline">Vzloggerpv Zeile:</label></b>
							<input type="text" name="vzloggerpvline" id="vzloggerpvline" value="<?php echo $mySettings->getSetting('vzloggerpvline') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte z.B. Zahl. Bitte auf der Shell ausführen: "curl -s IPdesVZLogger:Port/ | jq ."<br>
							Nun zählen in welcher Zeile der gewünschte Wert steht und diesen hier eintragen.
						</div>
					</div>
					<div id="pvhttp">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wr_http_w_url">Vollständige URL für die Wechselrichter Watt</label></b>
							<input type="text" name="wr_http_w_url" id="wr_http_w_url" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_http_w_url')) ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Enthält der Rückgabewert etwas anderes als wird der Wert auf null gesetzt. Der Wert muss in Watt sein.
						</div>
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="wr_http_kwh_url">Vollständige URL für die Wechselrichter absolut kWh</label></b>
							<input type="text" name="wr_http_kwh_url" id="wr_http_kwh_url" value="<?php echo htmlspecialchars($mySettings->getSetting('wr_http_kwh_url')) ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte vollständige URL. Die abgerufene Url muss eine reine Zahl zurückgeben. Der Wert muss in WattStunden sein. Der Wert dient rein dem Logging. Wird dieses nicht genutzt oder ist der Wert nicht verfügbar bitte auf "none" setzen, dann wird die Abfrage nicht ausgeführt.
						</div>
					</div>
					<div id="pvsma">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="smaemdpvid">Seriennummer des SMA Energy Meter</label></b>
							<input type="text" name="smaemdpvid" id="smaemdpvid" value="<?php echo $mySettings->getSetting('smaemdpvid') ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte Seriennummer. Hier die Seriennummer des SMA Meter für die PV angeben.

						</div>
					</div>

					<script>
						function display_pvwattmodul() {
							$('#pvvzl').hide();
							$('#pvsdmwr').hide();
							$('#pvwrfronius').hide();
							$('#pvnone').hide();
							$('#pvhttp').hide();
							$('#pvsma').hide();
							$('#pvwrjson').hide();
							$('#pvmpm3pm').hide();
							$('#pvwrkostalpiko').hide();
							$('#pvwrsolaredge').hide();
							$('#pvsmartme').hide();
							$('#pvwrtri9000').hide();
							$('#pvplenti').hide();
							$('#pvsolarlog').hide();
							$('#pvpiko2').hide();
							$('#pvpowerwall').hide();
							$('#pvmpmevu').hide();
							$('#pvethsdm120').hide();
							$('#pvsolarview').hide();
							$('#pvdiscovergy').hide();
							$('#pvyouless').hide();
							$('#pvlgessv1').hide();
							$('#pvmqtt').hide();
							$('#pvsunways').hide();
							$('#pvfems').hide();
							$('#pvsolarworld').hide();

							if($('#pvwattmodul').val() == 'wr_fems') {
								$('#pvfems').show();
							}
							if($('#pvwattmodul').val() == 'wr_solarworld') {
								$('#pvsolarworld').show();
							}

							if($('#pvwattmodul').val() == 'wr_sunways') {
								$('#pvsunways').show();
							}
							if($('#pvwattmodul').val() == 'wr_mqtt') {
								$('#pvmqtt').show();
							}
							if($('#pvwattmodul').val() == 'wr_youless120') {
								$('#pvyouless').show();
							}
							if($('#pvwattmodul').val() == 'wr_solarview') {
								$('#pvsolarview').show();
							}
							if($('#pvwattmodul').val() == 'wr_discovergy') {
								$('#pvdiscovergy').show();
							}
							if($('#pvwattmodul').val() == 'wr_ethsdm120') {
								$('#pvethsdm120').show();
							}
							if($('#pvwattmodul').val() == 'wr_ethmpm3pmaevu') {
								$('#pvmpmevu').show();
							}
							if($('#pvwattmodul').val() == 'vzloggerpv') {
								$('#pvvzl').show();
							}
							if($('#pvwattmodul').val() == 'sdm630modbuswr')   {
								$('#pvsdmwr').show();
							}
							if($('#pvwattmodul').val() == 'wr_fronius')   {
								$('#pvwrfronius').show();
							}
							if($('#pvwattmodul').val() == 'none')   {
								$('#pvnone').show();
							}
							if($('#pvwattmodul').val() == 'wr_http')   {
								$('#pvhttp').show();
							}
							if($('#pvwattmodul').val() == 'smaemd_pv')   {
								$('#pvsma').show();
							}
							if($('#pvwattmodul').val() == 'wr_json')   {
								$('#pvwrjson').show();
							}
							if($('#pvwattmodul').val() == 'mpm3pmpv')   {
								$('#pvmpm3pm').show();
							}
							if($('#pvwattmodul').val() == 'wr_kostalpiko')   {
								$('#pvwrkostalpiko').show();
							}
							if($('#pvwattmodul').val() == 'wr_solaredge')   {
								$('#pvwrsolaredge').show();
							}
							if($('#pvwattmodul').val() == 'wr_smartme')   {
								$('#pvsmartme').show();
							}
							if($('#pvwattmodul').val() == 'wr_tripower9000')   {
								$('#pvwrtri9000').show();
							}
							if($('#pvwattmodul').val() == 'wr_plenticore')   {
								$('#pvplenti').show();
							}
							if($('#pvwattmodul').val() == 'wr_solarlog')   {
								$('#pvsolarlog').show();
							}
							if($('#pvwattmodul').val() == 'wr_kostalpikovar2')   {
								$('#pvpiko2').show();
							}
							if($('#pvwattmodul').val() == 'wr_powerwall')   {
								$('#pvpowerwall').show();
							}
							if($('#pvwattmodul').val() == 'wr_lgessv1')   {
								$('#pvlgessv1').show();
							}
						}

						$(function() {
							display_pvwattmodul();
							$('#pvwattmodul').change( function(){
								display_pvwattmodul();
							} );
						});
					</script>

					<div class="row">
						<h3> Zweites PV-Modul </h3>
					</div>
					<div class="row">
						<b><label for="pv2wattmodul">Zweites PV-Modul:</label></b>
						<select name="pv2wattmodul" id="pv2wattmodul">
							<option <?php if($pv2wattmodulold == "none\n") echo "selected" ?> value="none">Nicht vorhanden</option>
							<option <?php if($pv2wattmodulold == "wr2_ethlovatoaevu\n") echo "selected" ?> value="wr2_ethlovatoaevu">Lovato an openWB EVU Kit</option>
							<option <?php if($pv2wattmodulold == "wr2_ethlovato\n") echo "selected" ?> value="wr2_ethlovato">openWB PV Kit v2</option>
							<option <?php if($pv2wattmodulold == "wr2_smamodbus\n") echo "selected" ?> value="wr2_smamodbus">SMA Wechselrichter</option>
							<option <?php if($pv2wattmodulold == "wr2_kostalsteca\n") echo "selected" ?> value="wr2_kostalsteca">Kostal Piko MP oder Steca Grid Coolcept</option>

						</select>
					</div>

					<div id="pv2none">
					</div>
					<div id="pv2noconfig">
						Keine Konfiguration erforderlich.
					</div>
					<div id="pv2ipdiv">
						<div class="row" style="background-color:#BEFEBE">
							<b><label for="pv2ip">Wechselrichter IP:</label></b>
							<input type="text" name="pv2ip" id="pv2ip" value="<?php echo $pv2ipold ?>">
						</div>
						<div class="row" style="background-color:#BEFEBE">
							Gültige Werte: IPs. IP Adresse des Wechselrichters, ggf. muss modbusTCP im WR noch aktiviert werden.
						</div>
					</div>


					<script>
						function display_pv2wattmodul() {
							$('#pv2none').hide();
							$('#pv2noconfig').hide();
							$('#pv2ipdiv').hide();

							if($('#pv2wattmodul').val() == 'none') {
								$('#pv2none').show();
							}
							if($('#pv2wattmodul').val() == 'wr2_ethlovatoaevu') {
								$('#pv2noconfig').show();
							}
							if($('#pv2wattmodul').val() == 'wr2_ethlovato') {
								$('#pv2noconfig').show();
							}
							if($('#pv2wattmodul').val() == 'wr2_smamodbus') {
								$('#pv2ipdiv').show();
							}
							if($('#pv2wattmodul').val() == 'wr2_kostalsteca') {
								$('#pv2ipdiv').show();
							}

						}
						$(function() {
							display_pv2wattmodul();
							$('#pv2wattmodul').change( function(){
								display_pv2wattmodul();
							} );
						});
					</script>
					<div class="row">
						<h3> Speicher-Modul </h3>
					</div>
					<div class="row">
						<b><label for="speichermodul">Speicher-Modul:</label></b>
						<select name="speichermodul" id="speichermodul">
							<option <?php if($mySettings->getSetting('speichermodul') == "none") echo "selected" ?> value="none">Nicht vorhanden</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_mpm3pm") echo "selected" ?> value="speicher_mpm3pm">openWB Speicher Kit</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_http") echo "selected" ?> value="speicher_http">HTTP Abfrage</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "mpm3pmspeicher") echo "selected" ?> value="mpm3pmspeicher">MPM3PM</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_bydhv") echo "selected" ?> value="speicher_bydhv">ByD HV</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_fronius") echo "selected" ?> value="speicher_fronius">Fronius Speicher</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_e3dc") echo "selected" ?> value="speicher_e3dc">E3DC Speicher</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_sbs25") echo "selected" ?> value="speicher_sbs25">SMA SBS2.5 Speicher</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_solaredge") echo "selected" ?> value="speicher_solaredge">Solaredge Speicher</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_powerwall") echo "selected" ?> value="speicher_powerwall">Tesla Powerwall</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_kostalplenticore") echo "selected" ?> value="speicher_kostalplenticore">Kostal Plenticore mit Speicher</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_sunnyisland") echo "selected" ?> value="speicher_sunnyisland">SMA Sunny Island Speicher</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_sonneneco") echo "selected" ?> value="speicher_sonneneco">Sonnen eco</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_varta") echo "selected" ?> value="speicher_varta">Varta Element u.a.</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_alphaess") echo "selected" ?> value="speicher_alphaess">Alpha ESS</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_victron") echo "selected" ?> value="speicher_victron">Victron Speicher (GX o.ä.)</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_lgessv1") echo "selected" ?> value="speicher_lgessv1">LG ESS 1.0VI</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_mqtt") echo "selected" ?> value="speicher_mqtt">MQTT</option>
							<option <?php if($mySettings->getSetting('speichermodul') == "speicher_fems") echo "selected" ?> value="speicher_fems">Fenecon FEMS</option>
						</select>
					</div>

					<div id="divspeicherlgessv1">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="lgessv1ip">LG ESS 1.0VI IP:</label></b>
							<input type="text" name="lgessv1ip" id="lgessv1ip" value="<?php echo $mySettings->getSetting('lgessv1ip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP. IP-Adresse des LG ESS 1.0VI
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="lgessv1pass">LG ESS 1.0VI Passwort:</label></b>
							<input type="text" name="lgessv1pass" id="lgessv1pass" value="<?php echo $mySettings->getSetting('lgessv1pass') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Standardmäßig ist hier die Registrierungsnummer des LG ESS 1.0VI anzugeben
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b>Bitte die API-Version wählen:</b><br />
							<select name="ess_api_ver" id="ess_api_ver">
								<option <?php if($mySettings->getSetting('ess_api_ver') == "10.2019") echo "selected" ?> value="10.2019">API-Version Oktober 2019</option>
								<option <?php if($mySettings->getSetting('ess_api_ver') == "01.2020") echo "selected" ?> value="01.2020">API-Version Januar 2020</option>
							</select><br />
							Falls Sie nicht wissen, welche API-Version benötigen, benutzten Sie bitte die neueste API-Version<br />
						</div>
					</div>
					<div id="divspeichernone">
					</div>
					<div id="divspeicherkit">
							<div class="row" style="background-color:#fcbe1e">
							Keine Konfiguration erforderlich
						</div>
					</div>
					<div id="divspeichermqtt">
						<div class="row" style="background-color:#fcbe1e">Keine Konfiguration erforderlich</div>
						<div class="row" style="background-color:#fcbe1e">Per MQTT zu schreiben:</div>
						<div class="row" style="background-color:#fcbe1e"><b>"openWB/set/Housebattery/W"</b></div>
						<div class="row" style="background-color:#fcbe1e">Speicherleistung in Watt, int, positiv Ladung, negativ Entladung</div>
						<div class="row" style="background-color:#fcbe1e"><b>"openWB/set/Housebattery/WhImported"</b></div>
						<div class="row" style="background-color:#fcbe1e">Geladene Energie in Wh, float, nur positiv</div>
						<div class="row" style="background-color:#fcbe1e"><b>"openWB/set/Housebattery/WhExported"</b></div>
						<div class="row" style="background-color:#fcbe1e">Entladene Energie in Wh, float, nur positiv</div>
						<div class="row" style="background-color:#fcbe1e"><b>"openWB/set/Housebattery/%Soc"</b></div>
						<div class="row" style="background-color:#fcbe1e">Ladestand des Speichers, int, 0-100</div>
					</div>
					<div id="divspeichervictron">
							<div class="row" style="background-color:#fcbe1e">
							Konfiguration im Bezug Victron Modul.
						</div>
					</div>
					<div id="divspeicherfems">
							<div class="row" style="background-color:#fcbe1e">
							Konfiguration im Bezug Fenecon Modul.
						</div>
					</div>

					<div id="divspeichervarta">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="vartaspeicherip">Varta IP:</label></b>
							<input type="text" name="vartaspeicherip" id="vartaspeicherip" value="<?php echo $mySettings->getSetting('vartaspeicherip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP. IP Adresse des Varta Speichers.
						</div>
					</div>
					<div id="divspeicheralphaess">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="alphaessip">Anbindung:</label></b>
							<input type="text" name="alphaessip" id="alphaessip" value="<?php echo $mySettings->getSetting('alphaessip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Wenn das Alpha Kit von openWB genutzt wird ist hier 192.168.193.31 einzutragen. Wenn direkt RS485 per Adapter genutzt z.B. /dev/ttyUSB1
						</div>
					</div>
					<div id="divspeicherpw">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="speicherpwip">Powerwall IP:</label></b>
							<input type="text" name="speicherpwip" id="speicherpwip" value="<?php echo $mySettings->getSetting('speicherpwip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP. IP Adresse der Tesla Powerwall.
						</div>
					</div>
					<div id="divspeicherseco">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="sonnenecoip">Sonnen eco IP:</label></b>
							<input type="text" name="sonnenecoip" id="sonnenecoip" value="<?php echo $mySettings->getSetting('sonnenecoip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP. IP Adresse der Sonnen eco serie 5.
						</div>
						<b><label for="sonnenecoalternativ">Alternativ Auslesung:</label></b>
						<select name="sonnenecoalternativ" id="sonnenecoalternativ">
							<option <?php if($mySettings->getSetting('sonnenecoalternativ') == "0") echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('sonnenecoalternativ') == "1") echo "selected" ?> value="1">Ja</option>
							<option <?php if($mySettings->getSetting('sonnenecoalternativ') == "2") echo "selected" ?> value="2">ECO 6</option>
						</select>
						<div class="row bg-info">
							Je nach Sonnen Batterie kann die Alternative Auslesung benötigt werden.
						</div>
					</div>
					<div id="divspeichere3dc">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="e3dcip">E3DCIP:</label></b>
							<input type="text" name="e3dcip" id="e3dcip" value="<?php echo $mySettings->getSetting('e3dcip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP. IP Adresse des E3DC Speichers.
						</div>
						<b><label for="e3dcextprod">Externe Produktion des E3DC mit einbeziehen:</label></b>
						<select name="e3dcextprod" id="e3dcextprod">
							<option <?php if($mySettings->getSetting('e3dcextprod') == "0") echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('e3dcextprod') == "1") echo "selected" ?> value="1">Ja</option>
						</select>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="e3dc2ip">E3DC 2 IP:</label></b>
							<input type="text" name="e3dc2ip" id="e3dc2ip" value="<?php echo $mySettings->getSetting('e3dc2ip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP oder none. IP Adresse des zweiten E3DC Speichers. Wenn nicht vorhanden none eintragen.
						</div>
					</div>
					<div id="divspeichersbs25">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="sbs25ip">SBS 2.5 IP:</label></b>
							<input type="text" name="sbs25ip" id="sbs25ip" value="<?php echo $mySettings->getSetting('sbs25ip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte: IPs. IP Adresse des SMA Sunny Boy Storage 2.5 Speichers.
						</div>
					</div>
					<div id="divspeichersunnyisland">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="sunnyislandip">Sunny Island IP:</label></b>
							<input type="text" name="sunnyislandip" id="sunnyislandip" value="<?php echo $mySettings->getSetting('sunnyislandip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP. IP Adresse des SMA Sunny Island.
						</div>
					</div>
					<div id="divspeichersolaredge">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="solaredgespeicherip">Solaredge Speicher IP:</label></b>
							<input type="text" name="solaredgespeicherip" id="solaredgespeicherip" value="<?php echo htmlspecialchars($mySettings->getSetting('solaredgespeicherip')) ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte IP. IP Adresse des Solaredge Wechselrichters an dem der Speicher angeschlossen ist.
						</div>
					</div>
					<div id="divspeicherplenti">
						<div class="row" style="background-color:#fcbe1e">
							Ein am 1. Kostal Plenticore angeschlossener Speicher setzt einen EM300/KSEM voraus. Nach entsprechender Auswahl im Strombezugsmessmodul und Konfiguration der IP des WR im PV-Modul erfolgt das Auslesen des Speichers über den WR ohne weitere Einstellungen.
						</div>
					</div>
					<div id="divspeicherfronius">
						<div class="row" style="background-color:#fcbe1e">
							Die IP des Wechselrichters wird im dazugehörigen Fronius PV-Modul eingestellt.
						</div>
					</div>
					<div id="divspeicherhttp">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="speicherleistung_http">Speicherleistung URL:</label></b>
							<input type="text" name="speicherleistung_http" id="speicherleistung_http" value="<?php echo $mySettings->getSetting('speicherleistung_http') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte URL. Vollständige URL die den aktuellen Leistungswert in Watt wiedergibt. Erwartet wird eine Ganzzahl. Positiv heißt Speicher wird geladen und eine negative Zahl bedeutet das der Speicher entladen wird. Das Modul dient dazu bei NurPV Ladung eine Entladung des Speichers zu verhindern.
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="speichersoc_http">SpeicherSoC URL:</label></b>
							<input type="text" name="speichersoc_http" id="speichersoc_http" value="<?php echo $mySettings->getSetting('speichersoc_http') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte URL. Vollständige URL die den aktuellen SoC wiedergibt.
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="speicherikwh_http">Speicher Import Wh URL:</label></b>
							<input type="text" name="speicherikwh_http" id="speicherikwh_http" value="<?php echo $mySettings->getSetting('speicherikwh_http') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte URL. Wenn nicht vorhanden, none eintragen. Vollständige URL die den Zählerstand der Batterieladung in WattStunden wiedergibt. Erwartet wird eine Ganzzahl.
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="speicherekwh_http">Speicher Export Wh URL:</label></b>
							<input type="text" name="speicherekwh_http" id="speicherekwh_http" value="<?php echo $mySettings->getSetting('speicherekwh_http') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte URL. Wenn nicht vorhanden, none eintragen.  Vollständige URL die den Zählerstand der Batterieladung in WattStunden wiedergibt. Erwartet wird eine Ganzzahl.
						</div>
					</div>
					<div id="divspeicherbydhv">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="bydhvuser">Byd HV Benutzername:</label></b>
							<input type="text" name="bydhvuser" id="bydhvuser" value="<?php echo $mySettings->getSetting('bydhvuser') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Benutzername der ByD Batterie
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="bydhvpass">Byd HV Passwort:</label></b>
							<input type="text" name="bydhvpass" id="bydhvpass" value="<?php echo $mySettings->getSetting('bydhvpass') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Passwort der ByD Batterie
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="bydhvip">Byd HV IP Adresse:</label></b>
							<input type="text" name="bydhvip" id="bydhvip" value="<?php echo $mySettings->getSetting('bydhvip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							IP Adresse der ByD Batterie
						</div>
					</div>
					<div id="divspeichermpm3pm">
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="mpm3pmspeichersource">Modbus Source:</label></b>
							<input type="text" name="mpm3pmspeichersource" id="mpm3pmspeichersource" value="<?php echo $mySettings->getSetting('mpm3pmspeichersource') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte /dev/ttyUSBx , /dev/virtualcomX bei Verwendung mit Ethernet Modbus
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="mpm3pmspeicherid">Modbus ID:</label></b>
							<input type="text" name="mpm3pmspeicherid" id="mpm3pmspeicherid" value="<?php echo $mySettings->getSetting('mpm3pmspeicherid') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
							Gültige Werte Zahl.
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="mpm3pmspeicherpv">PV mit einberechnen?:</label></b>
							<select name="mpm3pmspeicherpv" id="mpm3pmspeicherpv">
								<option <?php if($mySettings->getSetting('mpm3pmspeicherpv') == "0") echo "selected" ?> value="0">Keine extra Berechnung</option>
								<option <?php if($mySettings->getSetting('mpm3pmspeicherpv') == "1") echo "selected" ?> value="1">Subtrahieren der PV Leistung</option>
							</select>
						</div>
						<div class="row" style="background-color:#fcbe1e">
							<b><label for="mpm3pmspeicherlanip">Lan Modbus Konverter IP:</label></b>
							<input type="text" name="mpm3pmspeicherlanip" id="mpm3pmspeicherlanip" value="<?php echo $mySettings->getSetting('mpm3pmspeicherlanip') ?>">
						</div>
						<div class="row" style="background-color:#fcbe1e">
						Gültige Werte eine IP Adresse.
						</div>
					</div>

					<script>
						function display_speichermodul() {
							$('#divspeichermqtt').hide();
							$('#divspeichernone').hide();
							$('#divspeicherhttp').hide();
							$('#divspeichermpm3pm').hide();
							$('#divspeicherbydhv').hide();
							$('#divspeicherfronius').hide();
							$('#divspeichere3dc').hide();
							$('#divspeichersbs25').hide();
							$('#divspeichersolaredge').hide();
							$('#divspeicherpw').hide();
							$('#divspeicherplenti').hide();
							$('#divspeichersunnyisland').hide();
							$('#divspeicherseco').hide();
							$('#divspeicherkit').hide();
							$('#divspeichervarta').hide();
							$('#divspeicheralphaess').hide();
							$('#divspeichervictron').hide();
							$('#divspeicherlgessv1').hide();
							$('#divspeicherfems').hide();

							if($('#speichermodul').val() == 'speicher_fems') {
								$('#divspeicherfems').show();
							}

							if($('#speichermodul').val() == 'speicher_alphaess') {
								$('#divspeicheralphaess').show();
							}
							if($('#speichermodul').val() == 'speicher_mqtt') {
								$('#divspeichermqtt').show();
							}
							if($('#speichermodul').val() == 'speicher_victron') {
								$('#divspeichervictron').show();
							}
							if($('#speichermodul').val() == 'speicher_mpm3pm') {
								$('#divspeicherkit').show();
							}
							if($('#speichermodul').val() == 'speicher_sonneneco') {
								$('#divspeicherseco').show();
							}
							if($('#speichermodul').val() == 'none') {
								$('#divspeichernone').show();
							}
							if($('#speichermodul').val() == 'speicher_http')   {
								$('#divspeicherhttp').show();
							}
							if($('#speichermodul').val() == 'mpm3pmspeicher')   {
								$('#divspeichermpm3pm').show();
							}
							if($('#speichermodul').val() == 'speicher_bydhv')   {
								$('#divspeicherbydhv').show();
							}
							if($('#speichermodul').val() == 'speicher_fronius')   {
								$('#divspeicherfronius').show();
							}
							if($('#speichermodul').val() == 'speicher_e3dc')   {
								$('#divspeichere3dc').show();
							}
							if($('#speichermodul').val() == 'speicher_sbs25')   {
								$('#divspeichersbs25').show();
							}
							if($('#speichermodul').val() == 'speicher_solaredge')   {
								$('#divspeichersolaredge').show();
							}
							if($('#speichermodul').val() == 'speicher_varta')   {
								$('#divspeichervarta').show();
							}

							if($('#speichermodul').val() == 'speicher_powerwall')   {
								$('#divspeicherpw').show();
							}
							if($('#speichermodul').val() == 'speicher_kostalplenticore')   {
								$('#divspeicherplenti').show();
							}
							if($('#speichermodul').val() == 'speicher_sunnyisland')   {
								$('#divspeichersunnyisland').show();
							}
							if($('#speichermodul').val() == 'speicher_lgessv1')   {
								$('#divspeicherlgessv1').show();
							}
						}

						$(function() {
						display_speichermodul();
							$('#speichermodul').change( function(){
								display_speichermodul();
							});
						});
					</script>

					<button type="submit" class="btn btn-green" onclick="enable_pv_selector()">Save</button>
				</form>

				<div class="row justify-content-center">
					<div class="col text-center">
						Open Source made with love!<br>
						Jede Spende hilft die Weiterentwicklung von openWB vorranzutreiben<br>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="2K8C4Y2JTGH7U">
							<input type="image" src="./img/btn_donate_SM.gif" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
							<img alt="" src="./img/pixel.gif" width="1" height="1">
						</form>
					</div>
				</div>
			</div>
		</div>  <!-- container -->

		<footer class="footer bg-dark text-light font-small">
			<div class="container text-center">
				<small>Sie befinden sich hier: Einstellungen/Modulkonfiguration</small>
			</div>
		</footer>


		<script type="text/javascript">

			$.get("settings/navbar.php", function(data){
				$("#nav").replaceWith(data);
				// disable navbar entry for current page
				$('#navModulkonfiguration-ng').addClass('disabled');
			});

		</script>


	</body>
</html>
