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
		?>

		<div id="nav"></div> <!-- placeholder for navbar -->

		<div role="main" class="container" style="margin-top:20px">
			<div class="col-sm-12">
				<form action="settings/savepostsettings.php" method="POST">
					<div class="row ">
						<b><label for="awattaraktiv">Awattar aktivieren:</label></b>
						<select name="awattaraktiv" id="awattaraktiv">
							<option <?php if($mySettings->getSetting('awattaraktiv') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('awattaraktiv') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row">
						<p>Ermöglicht Laden nach Strompreis. Hierfür benötigt wird der Awattar Hourly Tarif sowie ein Discovergy Zähler.<br>
						Die Awattar Funktion ist nur im SofortLaden Modus aktiv!</p>
					</div>
					<div class="row ">
						<b><label for="awattarlocation">Land:</label></b>
						<select name="awattarlocation" id="awattarlocation">
							<option <?php if($awattarlocationold == "de\n") echo "selected" ?> value="de">Deutschland</option>
							<option <?php if($awattarlocationold == "at\n") echo "selected" ?> value="at">Österreich</option>
						</select>
					</div>

					<hr>

					<div class="row">
						<b><label for="stopchargeafterdisclp1">Ladepunkt 1 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp1" id="stopchargeafterdisclp1">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp1') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp1') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row" id="lp2aktdiv">
						<b><label for="stopchargeafterdisclp2">Ladepunkt 2 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp2" id="stopchargeafterdisclp2">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp2') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp2') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row" id="lp3aktdiv">
						<b><label for="stopchargeafterdisclp3">Ladepunkt 3 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp3" id="stopchargeafterdisclp3">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp3') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp3') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row" id="lp4aktdiv">
						<b><label for="stopchargeafterdisclp4">Ladepunkt 4 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp4" id="stopchargeafterdisclp4">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp4') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp4') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row" id="lp5aktdiv">
						<b><label for="stopchargeafterdisclp5">Ladepunkt 5 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp5" id="stopchargeafterdisclp5">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp5') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp5') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row" id="lp6aktdiv">
						<b><label for="stopchargeafterdisclp6">Ladepunkt 6 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp6" id="stopchargeafterdisclp6">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp6') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp6') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row" id="lp7aktdiv">
						<b><label for="stopchargeafterdisclp7">Ladepunkt 7 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp7" id="stopchargeafterdisclp7">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp7') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp7') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<div class="row" id="lp8aktdiv">
						<b><label for="stopchargeafterdisclp8">Ladepunkt 8 sperren nach Abstecken:</label></b>
						<select name="stopchargeafterdisclp8" id="stopchargeafterdisclp8">
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp8') == 0) echo "selected" ?> value="0">Nein</option>
							<option <?php if($mySettings->getSetting('stopchargeafterdisclp8') == 1) echo "selected" ?> value="1">Ja</option>
						</select>
					</div>
					<script>
						$(function() {
							var lp2akt = <?php echo $mySettings->getSetting('lastmanagement') ?>;
							var lp3akt = <?php echo $mySettings->getSetting('lastmanagements2') ?>;
							var lp4akt = <?php echo $mySettings->getSetting('lastmanagementlp4') ?>;
							var lp5akt = <?php echo $mySettings->getSetting('lastmanagementlp5') ?>;
							var lp6akt = <?php echo $mySettings->getSetting('lastmanagementlp6') ?>;
							var lp7akt = <?php echo $mySettings->getSetting('lastmanagementlp7') ?>;
							var lp8akt = <?php echo $mySettings->getSetting('lastmanagementlp8') ?>;

							if(lp2akt == '0') {
								$('#lp2aktdiv').hide();
								$('#loadsharingdiv').hide();
								$('#nachtladenlp2div').hide();
							} else {
								$('#lp2aktdiv').show();
								$('#loadsharingdiv').show();
								$('#nachtladenlp2div').show();
							}
							if(lp3akt == '0') {
								$('#lp3aktdiv').hide();
							} else {
								$('#lp3aktdiv').show();
							}
							if(lp4akt == '0') {
								$('#lp4aktdiv').hide();
							} else {
								$('#lp4aktdiv').show();
							}
							if(lp5akt == '0') {
								$('#lp5aktdiv').hide();
							} else {
								$('#lp5aktdiv').show();
							}
							if(lp6akt == '0') {
								$('#lp6aktdiv').hide();
							} else {
								$('#lp6aktdiv').show();
							}
							if(lp7akt == '0') {
								$('#lp7aktdiv').hide();
							} else {
								$('#lp7aktdiv').show();
							}
							if(lp8akt == '0') {
								$('#lp8aktdiv').hide();
							} else {
								$('#lp8aktdiv').show();
							}

						});
					</script>
					<div class="row">
						Nachdem der Stecker gezogen wird, wird der entsprechende Ladepunkt gesperrt. Ein manuelles aktivieren des Ladepunktes ist erforderlich. Nach aktivieren bleibt der Ladepunkt solange aktiv bis ein Stecker eingesteckt und wieder abgezogen wird. Ist unabhängig davon ob geladen wird.
					</div>

					<hr>

					<div class="row">
						<h5>
							<b><label for="zielladenaktivlp1">Zielladen Ladepunkt 1:(BETA)</label></b>
							<select name="zielladenaktivlp1" id="zielladenaktivlp1">
								<option <?php if($mySettings->getSetting('zielladenaktivlp1') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('zielladenaktivlp1') == 1) echo "selected" ?> value="1">An</option>
							</select>
						</h5>
					</div>
					<div id="zielladenaktivlp1div">
						<div class="row">
							<div class="col">
								<p><b>Beta Feature</b></p>
								<p>Gewünschten SoC, Ziel Uhrzeit sowie Ladegeschwindigkeit einstellen.<br>
								Sicherstellen das die Akkugröße wie auch die richtige Anzahl der Phasen konfiguriert sind.</p>
							</div>
						</div>

						<div class="row">
							<div class="col">
								<b><label for="zielladensoclp1">Ziel SoC an Ladepunkt 1:</label></b>
								<input type="text" name="zielladensoclp1" id="zielladensoclp1" value="<?php echo $mySettings->getSetting('zielladensoclp1') ?>">
								<p>
									Gültige Werte xx, z.B. 85<br>
									Der SoC Wert auf den geladen werden soll.
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col">

								<b><label for="zielladenuhrzeitlp1">Zielladenuhrzeit an Ladepunkt 1:</label></b>
								<input type="text" name="zielladenuhrzeitlp1" id="zielladenuhrzeitlp1" value="<?php echo $mySettings->getSetting('zielladenuhrzeitlp1') ?>">
								<p>
									Gültige Werte YYYY-MM-DD HH:MM, z.B. 2018-12-16 06:15<br>
									Ende der gewünschten Ladezeit. Das Datum muss exakt in diesem Format mit Leerzeichen zwischen Monat und Stunde eingegeben werden.
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<b><label for="zielladenalp1">Stromstärke in A:</label></b>
								<select name="zielladenalp1" id="zielladenalp1">
									<option <?php if($mySettings->getSetting('zielladenalp1') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('zielladenalp1') == 32) echo "selected" ?> value="32">32</option>
								</select>
								<p>Ampere mit denen geladen werden soll um den Ziel SoC zu erreichen.</p>
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col">
							<h1>EV Daten</h1>
						</div>
					</div>
					<div id="durchslp1div">
						<div class="row bg-info">
							<div class="col">
								<b>Durchschnittsverbrauch deines Elektroautos in kWh an Ladepunkt 1:</b><br>
								<input type="text" name="durchslp1" id="durchslp1" value="<?php echo $mySettings->getSetting('durchslp1') ?>"><br>
								Gültige Werte xx.xx, z.B. 14.5<br>
								Dient zur Berechnung der geladenen Strecke.
							</div>
						</div>
						<div class="row bg-info">
							<div class="col">
								<b>Akkugröße deines Elektroautos in kWh an Ladepunkt 1 (nur für Zielladen relevant):</b><br>
								<input type="text" name="akkuglp1" id="akkuglp1" value="<?php echo $mySettings->getSetting('akkuglp1') ?>"><br>
								Gültige Werte xx, z.B. 41<br>
								Dient zur Berechnung der benötigten Ladezeit.
							</div>
						</div>
						<div class="row bg-info">
							<div class="col">
								<b>Anzahl der genutzt Phasen des EV an Ladepunkt 1 (nur für Zielladen relevant):</b><br>
								<select name="zielladenphasenlp1" id="zielladenphasenlp1">
									<option <?php if($mySettings->getSetting('zielladenphasenlp1') == 1) echo "selected" ?> value="1">1</option>
									<option <?php if($mySettings->getSetting('zielladenphasenlp1') == 2) echo "selected" ?> value="2">2</option>
									<option <?php if($mySettings->getSetting('zielladenphasenlp1') == 3) echo "selected" ?> value="3">3</option>
								</select>
							</div>
						</div>
						<div class="row bg-info">
							<div class="col">
								<b>Stromstärke in A mit der maximal geladen werden kann:</b><br>
								<select name="zielladenmaxalp1" id="zielladenmaxalp1">
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('zielladenmaxalp1') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								Ampere mit denen geladen werden kann, um den Ziel SoC zu erreichen. Orientiert an der Leistung der Hausinstallation, oder der des zu ladenden Autos.
							</div>
						</div>
					</div>
					<div id="durchslp2div">
						<div class="row bg-info">
							<div class="col">
								<hr>
								<b>Durchschnittsverbrauch deines Elektroautos in kWh an Ladepunkt 2:</b><br>
								<input type="text" name="durchslp2" id="durchslp2" value="<?php echo $mySettings->getSetting('durchslp2') ?>"><br>
								Gültige Werte xx.xx, z.B. 14.5<br>
								Dient zur Berechnung der geladenen Strecke.
							</div>
						</div>
						<div class="row bg-info">
							<div class="col">
								<b>Akkugröße deines Elektroautos in kWh an Ladepunkt 2:</b><br>
								<input type="text" name="akkuglp2" id="akkuglp2" value="<?php echo $mySettings->getSetting('akkuglp2') ?>"><br>
								Gültige Werte xx, z.B. 41<br>
								Dient zur Berechnung der benötigten Ladezeit.
							</div>
						</div>
					</div>
					<div id="durchslp3div">
						<div class="row bg-info">
							<div class="col">
								<hr>
								<b>Durchschnittsverbrauch deines Elektroautos  in kWh an Ladepunkt 3:</b><br>
								<input type="text" name="durchslp3" id="durchslp3" value="<?php echo $mySettings->getSetting('durchslp3') ?>"><br>
								Gültige Werte xx.xx, z.B. 14.5<br>
								Dient zur Berechnung der geladenen Strecke.
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<h1>Automatische Phasenumschaltung</h1>
						</div>
					</div>
					<div class="row" style="background-color:#33ffa8">
						<div class="col">
							<b>Phasenumschaltung Aktiv:</b><br>
							<select name="u1p3paktiv" id="u1p3paktiv">
								<option <?php if($mySettings->getSetting('u1p3paktiv') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('u1p3paktiv') == 1) echo "selected" ?> value="1">An</option>
							</select><br>
							Automatisierte Umschaltung von 1- und 3-phasiger Ladung. Nur aktivieren, wenn diese Option in der OpenWB verbaut ist. Je nach gekaufter Hardwareoption gültig für alle Ladepunkte!
						</div>
					</div>
					<div id="u1p3paus">
					</div>
					<div id="u1p3pan">
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								<b><label for="u1p3psofort">Sofort Laden:</label></b>
								<select name="u1p3psofort" id="u1p3psofort">
									<option <?php if($mySettings->getSetting('u1p3psofort') == 1) echo "selected" ?> value="1">einphasig</option>
									<option <?php if($mySettings->getSetting('u1p3psofort') == 3) echo "selected" ?> value="3">dreiphasig</option>
								</select>
							</div>
						</div>
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								<b><label for="u1p3pstandby">Standby:</label></b>
								<select name="u1p3pstandby" id="u1p3pstandby">
									<option <?php if($mySettings->getSetting('u1p3pstandby') == 1) echo "selected" ?> value="1">einphasig</option>
									<option <?php if($mySettings->getSetting('u1p3pstandby') == 3) echo "selected" ?> value="3">dreiphasig</option>
								</select>
							</div>
						</div>
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								<b><label for="u1p3pminundpv">Min + PV Laden:</label></b>
								<select name="u1p3pminundpv" id="u1p3pminundpv">
									<option <?php if($mySettings->getSetting('u1p3pminundpv') == 1) echo "selected" ?> value="1">einphasig</option>
									<option <?php if($mySettings->getSetting('u1p3pminundpv') == 3) echo "selected" ?> value="3">dreiphasig</option>
								</select>
							</div>
						</div>
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								<b><label for="u1p3pnurpv">Nur PV Laden:</label></b>
								<select name="u1p3pnurpv" id="u1p3pnurpv">
									<option <?php if($mySettings->getSetting('u1p3pnurpv') == 1) echo "selected" ?> value="1">einphasig</option>
									<option <?php if($mySettings->getSetting('u1p3pnurpv') == 3) echo "selected" ?> value="3">dreiphasig</option>
									<option <?php if($mySettings->getSetting('u1p3pnurpv') == 4) echo "selected" ?> value="4">Automatikmodus</option>
								</select>
							</div>
						</div>
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								Im Automatikmodus wird die PV Ladung einphasig begonnen. Ist für durchgehend 10 Minuten die Maximalstromstärke erreicht, wird die Ladung auf dreiphasige Ladung umgestellt. Ist die Ladung nur für ein Intervall unterhalb der Maximalstromstärke, beginnt der Counter für die Umschaltung erneut. Ist die Ladung im dreiphasigen Modus für 8 Minuten bei der Minimalstromstärke, wird wieder auf einphasige Ladung gewechselt.
							</div>
						</div>
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								<b><label for="u1p3pnl">Nachtladen:</label></b>
								<select name="u1p3pnl" id="u1p3pnl">
									<option <?php if($mySettings->getSetting('u1p3pnl') == 1) echo "selected" ?> value="1">einphasig</option>
									<option <?php if($mySettings->getSetting('u1p3pnl') == 3) echo "selected" ?> value="3">dreiphasig</option>
								</select>
							</div>
						</div>
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								<b><label for="schieflastaktiv">Schieflastbeachtung:</label></b>
								<select name="schieflastaktiv" id="schieflastaktiv">
									<option <?php if($mySettings->getSetting('schieflastaktiv') == 0) echo "selected" ?> value="0">Nein</option>
									<option <?php if($mySettings->getSetting('schieflastaktiv') == 1) echo "selected" ?> value="1">Ja</option>
								</select>
							</div>
						</div>
						<div class="row" style="background-color:#33ffa8">
							<div class="col">
								<b>Schieflastbegrenzung in A:</b>
								<select name="schieflastmaxa" id="schieflastmaxa">
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 16) echo "selected" ?> value="16">10</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 17) echo "selected" ?> value="17">11</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 18) echo "selected" ?> value="18">12</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 19) echo "selected" ?> value="19">13</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 20) echo "selected" ?> value="20">14</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 21) echo "selected" ?> value="21">15</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('schieflastmaxa') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								Gibt an mit wieviel Ampere maximal geladen wird wenn die automatische Umschaltung aktiv ist und mit einer Phase lädt.
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col">
							<h1>Nachtlademodus</h1>
						</div>
					</div>
					<div class="row" style="background-color:#00ada8">
						<div class="col">
							<input type='hidden' value='0' name='nlakt_sofort'>
							<input id="nlakt_sofort" name="nlakt_sofort" value="1" type="checkbox" <?php if ( $mySettings->getSetting('nlakt_sofort') == 1){ echo "checked"; } ?> >
							<label for="nlakt_sofort">Aktiv im Sofort Lademodus</label><br>
							<input type='hidden' value='0' name='nlakt_minpv'>
							<input id="nlakt_minpv" name="nlakt_minpv" value="1" type="checkbox" <?php if ( $mySettings->getSetting('nlakt_minpv') == 1){ echo "checked"; } ?> >
							<label for="nlakt_minpv">Aktiv im Min+PV Lademodus</label><br>
							<input type='hidden' value='0' name='nlakt_nurpv'>
							<input id="nlakt_nurpv" name="nlakt_nurpv" value="1" type="checkbox" <?php if ( $mySettings->getSetting('nlakt_nurpv') == 1){ echo "checked"; } ?> >
							<label for="nlakt_nurpv">Aktiv im NurPV Lademodus</label><br>
							<input type='hidden' value='0' name='nlakt_standby'>
						 	<input id="nlakt_standby" name="nlakt_standby" value="1" type="checkbox" <?php if ( $mySettings->getSetting('nlakt_standby') == 1){ echo "checked"; } ?> >
							<label for="nlakt_standby">Aktiv im Standby Lademodus</label>
						</div>
					</div>
					<div class="row" style="background-color:#00ada8">
						<div class="col">
							<b>Nachtladen Ladepunkt 1:</b><br>
							<select name="nachtladen" id="nachtladen">
								<option <?php if($mySettings->getSetting('nachtladen') == 0) echo "selected" ?> value="0">Aus</option>
								<option <?php if($mySettings->getSetting('nachtladen') == 1) echo "selected" ?> value="1">An</option>
							</select><br>
							Definiert, ob Nachts geladen werden soll.
						</div>
					</div>

					<div id="nachtladenaus">
					</div>
					<div id="nachtladenan">
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b>Nachtladestromstärke in A:</b><br>
								<select name="nachtll" id="nachtll">
									<option <?php if($mySettings->getSetting('nachtll') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('nachtll') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('nachtll') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('nachtll') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('nachtll') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('nachtll') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('nachtll') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('nachtll') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('nachtll') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('nachtll') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('nachtll') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('nachtll') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('nachtll') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('nachtll') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('nachtll') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('nachtll') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('nachtll') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('nachtll') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('nachtll') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('nachtll') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('nachtll') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('nachtll') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('nachtll') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('nachtll') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('nachtll') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('nachtll') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('nachtll') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								Ampere mit der nachts geladen werden soll
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b>Nachtladen Uhrzeit ab:</b><br>
								<select name="nachtladenabuhr" id="nachtladenabuhr">
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('nachtladenabuhr') == 24) echo "selected" ?> value="24">24</option>
								</select><br>
								Ab wann Abends geladen werden soll
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b>Nachtladen Uhrzeit bis:</b><br>
								<select name="nachtladenbisuhr" id="nachtladenbisuhr">
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 0) echo "selected" ?> value="0">0</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 1) echo "selected" ?> value="1">1</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 2) echo "selected" ?> value="2">2</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 3) echo "selected" ?> value="3">3</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 4) echo "selected" ?> value="4">4</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 5) echo "selected" ?> value="5">5</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('nachtladenbisuhr') == 9) echo "selected" ?> value="9">9</option>
								</select><br>
								Bis wann morgens geladen werden soll
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b>Nacht SoC Sonntag bis Donnerstag:</b><br>
								<input type="text" name="nachtsoc" id="nachtsoc" value="<?php echo $mySettings->getSetting('nachtsoc') ?>"><br>
								Gültiger Wert 1-99. Wenn SoC Modul vorhanden wird Nachts bis xx% SoC geladen in dem angegebenen Zeitfenster.<br>
								Das SoC Fenster is von von Sonntag Abend bis Freitag Morgen aktiv.
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b>Nacht SoC Freitag bis Sonntag:</b><br>
								<input type="text" name="nachtsoc1" id="nachtsoc1" value="<?php echo $mySettings->getSetting('nachtsoc1') ?>"><br>
								Gültiger Wert 1-99. Wenn SoC Modul vorhanden wird Nachts bis xx% SoC geladen in dem angegebenen Zeitfenster.<br>
								Das SoC Fenster is von von Freitag Morgen bis Sonntag Abend aktiv.
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b>Die SoC Grenzen gelten nicht für das morgens Laden</b><br>
								<b><label for="mollp1moll">Montag morgens Laden Stromstärke in A:</label></b>
								<select name="mollp1moll" id="mollp1moll">
									<option <?php if($mySettings->getSetting('mollp1moll') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('mollp1moll') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								<b><label for="mollp1moab">ab:</label></b>
								<select name="mollp1moab" id="mollp1moab">
									<option <?php if($mySettings->getSetting('mollp1moab') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1moab') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
								</select>
								<b><label for="mollp1mobis">bis:</label></b>
								<select name="mollp1mobis" id="mollp1mobis">
									<option <?php if($mySettings->getSetting('mollp1mobis') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mobis') == "11:00") echo "selected" ?> value="11:00">11:00 Uhr</option>
								</select>
								<hr>
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b><label for="mollp1dill">Dienstag morgens Laden Stromstärke in A:</label></b>
								<select name="mollp1dill" id="mollp1dill">
									<option <?php if($mySettings->getSetting('mollp1dill') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('mollp1dill') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								<b><label for="mollp1diab">ab:</label></b>
								<select name="mollp1diab" id="mollp1diab">
									<option <?php if($mySettings->getSetting('mollp1diab') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1diab') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
								</select>
								<b><label for="mollp1dibis">bis:</label></b>
								<select name="mollp1dibis" id="mollp1dibis">
									<option <?php if($mySettings->getSetting('mollp1dibis') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dibis') == "11:00") echo "selected" ?> value="11:00">11:00 Uhr</option>
								</select>
								<hr>
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b><label for="mollp1mill">Mittwoch morgens Laden Stromstärke in A:</label></b>
								<select name="mollp1mill" id="mollp1mill">
									<option <?php if($mySettings->getSetting('mollp1mill') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('mollp1mill') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								<b><label for="mollp1miab">ab:</label></b>
								<select name="mollp1miab" id="mollp1miab">
									<option <?php if($mySettings->getSetting('mollp1miab') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1miab') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
								</select>
								<b><label for="mollp1mibis">bis:</label></b>
								<select name="mollp1mibis" id="mollp1mibis">
									<option <?php if($mySettings->getSetting('mollp1mibis') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1mibis') == "11:00") echo "selected" ?> value="11:00">11:00 Uhr</option>
								</select>
								<hr>
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b><label for="mollp1doll">Donnerstag morgens Laden Stromstärke in A:</label></b>
								<select name="mollp1doll" id="mollp1doll">
									<option <?php if($mySettings->getSetting('mollp1doll') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('mollp1doll') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								<b><label for="mollp1doab">ab:</label></b>
								<select name="mollp1doab" id="mollp1doab">
									<option <?php if($mySettings->getSetting('mollp1doab') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1doab') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
								</select>
								<b><label for="mollp1dobis">bis:</label></b>
								<select name="mollp1dobis" id="mollp1dobis">
									<option <?php if($mySettings->getSetting('mollp1dobis') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1dobis') == "11:00") echo "selected" ?> value="11:00">11:00 Uhr</option>
								</select>
								<hr>
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b><label for="mollp1frll">Freitag morgens Laden Stromstärke in A:</label></b>
								<select name="mollp1frll" id="mollp1frll">
									<option <?php if($mySettings->getSetting('mollp1frll') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('mollp1frll') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								<b><label for="mollp1frab">ab:</label></b>
								<select name="mollp1frab" id="mollp1frab">
									<option <?php if($mySettings->getSetting('mollp1frab') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frab') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
								</select>
								<b><label for="mollp1frbis">bis:</label></b>
								<select name="mollp1frbis" id="mollp1frbis">
									<option <?php if($mySettings->getSetting('mollp1frbis') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1frbis') == "11:00") echo "selected" ?> value="11:00">11:00 Uhr</option>
								</select>
								<hr>
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b><label for="mollp1sall">Samstag morgens Laden Stromstärke in A:</label></b>
								<select name="mollp1sall" id="mollp1sall">
									<option <?php if($mySettings->getSetting('mollp1sall') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('mollp1sall') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								<b><label for="mollp1saab">ab:</label></b>
								<select name="mollp1saab" id="mollp1saab">
									<option <?php if($mySettings->getSetting('mollp1saab') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1saab') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
								</select>
								<b><label for="mollp1sabis">bis:</label></b>
								<select name="mollp1sabis" id="mollp1sabis">
									<option <?php if($mySettings->getSetting('mollp1sabis') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sabis') == "11:00") echo "selected" ?> value="11:00">11:00 Uhr</option>
								</select>
								<hr>
							</div>
						</div>
						<div class="row" style="background-color:#00ada8">
							<div class="col">
								<b><label for="mollp1soll">Sonntag morgens Laden Stromstärke in A:</label></b>
								<select name="mollp1soll" id="mollp1soll">
									<option <?php if($mySettings->getSetting('mollp1soll') == 6) echo "selected" ?> value="6">6</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 7) echo "selected" ?> value="7">7</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 8) echo "selected" ?> value="8">8</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 9) echo "selected" ?> value="9">9</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 10) echo "selected" ?> value="10">10</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 11) echo "selected" ?> value="11">11</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 12) echo "selected" ?> value="12">12</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 13) echo "selected" ?> value="13">13</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 14) echo "selected" ?> value="14">14</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 15) echo "selected" ?> value="15">15</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 16) echo "selected" ?> value="16">16</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 17) echo "selected" ?> value="17">17</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 18) echo "selected" ?> value="18">18</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 19) echo "selected" ?> value="19">19</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 20) echo "selected" ?> value="20">20</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 21) echo "selected" ?> value="21">21</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 22) echo "selected" ?> value="22">22</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 23) echo "selected" ?> value="23">23</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 24) echo "selected" ?> value="24">24</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 25) echo "selected" ?> value="25">25</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 26) echo "selected" ?> value="26">26</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 27) echo "selected" ?> value="27">27</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 28) echo "selected" ?> value="28">28</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 29) echo "selected" ?> value="29">29</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 30) echo "selected" ?> value="30">30</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 31) echo "selected" ?> value="31">31</option>
									<option <?php if($mySettings->getSetting('mollp1soll') == 32) echo "selected" ?> value="32">32</option>
								</select><br>
								<b><label for="mollp1soab">ab:</label></b>
								<select name="mollp1soab" id="mollp1soab">
									<option <?php if($mySettings->getSetting('mollp1soab') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1soab') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
								</select>
								<b><label for="mollp1sobis">bis:</label></b>
								<select name="mollp1sobis" id="mollp1sobis">
									<option <?php if($mySettings->getSetting('mollp1sobis') == "03:00") echo "selected" ?> value="03:00">03:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "03:15") echo "selected" ?> value="03:15">03:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "03:30") echo "selected" ?> value="03:30">03:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "03:45") echo "selected" ?> value="03:45">03:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "04:00") echo "selected" ?> value="04:00">04:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "04:15") echo "selected" ?> value="04:15">04:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "04:30") echo "selected" ?> value="04:30">04:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "04:45") echo "selected" ?> value="04:45">04:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "05:00") echo "selected" ?> value="05:00">05:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "05:15") echo "selected" ?> value="05:15">05:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "05:30") echo "selected" ?> value="05:30">05:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "05:45") echo "selected" ?> value="05:45">05:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "06:00") echo "selected" ?> value="06:00">06:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "06:15") echo "selected" ?> value="06:15">06:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "06:30") echo "selected" ?> value="06:30">06:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "06:45") echo "selected" ?> value="06:45">06:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "07:00") echo "selected" ?> value="07:00">07:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "07:15") echo "selected" ?> value="07:15">07:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "07:30") echo "selected" ?> value="07:30">07:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "07:45") echo "selected" ?> value="07:45">07:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "08:00") echo "selected" ?> value="08:00">08:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "08:15") echo "selected" ?> value="08:15">08:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "08:30") echo "selected" ?> value="08:30">08:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "08:45") echo "selected" ?> value="08:45">08:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "09:00") echo "selected" ?> value="09:00">09:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "09:15") echo "selected" ?> value="09:15">09:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "09:30") echo "selected" ?> value="09:30">09:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "09:45") echo "selected" ?> value="09:45">09:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "10:00") echo "selected" ?> value="10:00">10:00 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "10:15") echo "selected" ?> value="10:15">10:15 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "10:30") echo "selected" ?> value="10:30">10:30 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "10:45") echo "selected" ?> value="10:45">10:45 Uhr</option>
									<option <?php if($mySettings->getSetting('mollp1sobis') == "11:00") echo "selected" ?> value="11:00">11:00 Uhr</option>
								</select>
							</div>
						</div>
					</div>

					<script>
						$(function() {
							if($('#nachtladen').val() == '0') {
								$('#nachtladenaus').show();
								$('#nachtladenan').hide();
							} else {
								$('#nachtladenaus').hide();
								$('#nachtladenan').show();
							}
							$('#nachtladen').change(function(){
								if($('#nachtladen').val() == '0') {
									$('#nachtladenaus').show();
									$('#nachtladenan').hide();
								} else {
									$('#nachtladenaus').hide();
									$('#nachtladenan').show();
								}
							});
						});

						$(function() {
							if($('#u1p3paktiv').val() == '0') {
								$('#u1p3paus').show();
								$('#u1p3pan').hide();
							} else {
								$('#u1p3paus').hide();
								$('#u1p3pan').show();
							}
							$('#u1p3paktiv').change(function(){
								if($('#u1p3paktiv').val() == '0') {
									$('#u1p3paus').show();
									$('#u1p3pan').hide();
								} else {
									$('#u1p3paus').hide();
									$('#u1p3pan').show();
								}
							});
						});

						$(function() {
							if($('#zielladenaktivlp1').val() == '0') {
								$('#zielladenaktivlp1div').hide();
							} else {
								$('#zielladenaktivlp1div').show();
							}
							$('#zielladenaktivlp1').change(function(){
								if($('#zielladenaktivlp1').val() == '0') {
									$('#zielladenaktivlp1div').hide();
								} else {
									$('#zielladenaktivlp1div').show();
								}
							});
						});
					</script>
					<div id="nachtladenlp2div">
						<div id="nachtls1div">
							<div class="row" style="background-color:#00ada8">
								<div class="col">
									<b>Nachtladen Ladepunkt 2:</b><br>
									<select name="nachtladens1" id="nachtladens1">
										<option <?php if($mySettings->getSetting('nachtladens1') == 0) echo "selected" ?> value="0">Aus</option>
										<option <?php if($mySettings->getSetting('nachtladens1') == 1) echo "selected" ?> value="1">An</option>
									</select><br>
									Definiert, ob Nachts geladen werden soll. Ist auch bei Lademodus "Stop" aktiv!
								</div>
							</div>
							<div id="nachtladenauss1">
							</div>
							<div id="nachtladenans1">
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b><label for="nachtlls1">Nachtladestromstärke in A:</label></b>
										<select name="nachtlls1" id="nachtlls1">
											<option <?php if($mySettings->getSetting('nachtlls1') == 6) echo "selected" ?> value="6">6</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 7) echo "selected" ?> value="7">7</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 8) echo "selected" ?> value="8">8</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 9) echo "selected" ?> value="9">9</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 10) echo "selected" ?> value="10">10</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 11) echo "selected" ?> value="11">11</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 12) echo "selected" ?> value="12">12</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 13) echo "selected" ?> value="13">13</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 14) echo "selected" ?> value="14">14</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 15) echo "selected" ?> value="15">15</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 16) echo "selected" ?> value="16">16</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 17) echo "selected" ?> value="17">17</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 18) echo "selected" ?> value="18">18</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 19) echo "selected" ?> value="19">19</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 20) echo "selected" ?> value="20">20</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 21) echo "selected" ?> value="21">21</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 22) echo "selected" ?> value="22">22</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 23) echo "selected" ?> value="23">23</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 24) echo "selected" ?> value="24">24</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 25) echo "selected" ?> value="25">25</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 26) echo "selected" ?> value="26">26</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 27) echo "selected" ?> value="27">27</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 28) echo "selected" ?> value="28">28</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 29) echo "selected" ?> value="29">29</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 30) echo "selected" ?> value="30">30</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 31) echo "selected" ?> value="31">31</option>
											<option <?php if($mySettings->getSetting('nachtlls1') == 32) echo "selected" ?> value="32">32</option>
										</select><br>
										Ampere mit der nachts geladen werden soll
									</div>
								</div>
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b><label for="nachtladenabuhrs1">Nachtladen Uhrzeit ab:</label></b>
										<select name="nachtladenabuhrs1" id="nachtladenabuhrs1">
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 17) echo "selected" ?> value="17">17</option>
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 18) echo "selected" ?> value="18">18</option>
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 19) echo "selected" ?> value="19">19</option>
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 20) echo "selected" ?> value="20">20</option>
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 21) echo "selected" ?> value="21">21</option>
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 22) echo "selected" ?> value="22">22</option>
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 23) echo "selected" ?> value="23">23</option>
											<option <?php if($mySettings->getSetting('nachtladenabuhrs1') == 24) echo "selected" ?> value="24">24</option>
										</select><br>
										Ab wann Abends geladen werden soll
									</div>
								</div>
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b><label for="nachtladenbisuhrs1">Nachtladen Uhrzeit bis:</label></b>
										<select name="nachtladenbisuhrs1" id="nachtladenbisuhrs1">
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 0) echo "selected" ?> value="0">0</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 1) echo "selected" ?> value="1">1</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 2) echo "selected" ?> value="2">2</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 3) echo "selected" ?> value="3">3</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 4) echo "selected" ?> value="4">4</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 5) echo "selected" ?> value="5">5</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 6) echo "selected" ?> value="6">6</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 7) echo "selected" ?> value="7">7</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 8) echo "selected" ?> value="8">8</option>
											<option <?php if($mySettings->getSetting('nachtladenbisuhrs1') == 9) echo "selected" ?> value="9">9</option>
										</select><br>
										Bis wann morgens geladen werden soll
									</div>
								</div>
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b>Nacht SoC Sonntag bis Donnerstag:</b><br>
										<input type="text" name="nachtsocs1" id="nachtsocs1" value="<?php echo $mySettings->getSetting('nachtsocs1') ?>"><br>
										Gültiger Wert 1-99. Wenn SoC Modul vorhanden wird Nachts bis xx% SoC geladen in dem angegebenen Zeitfenster.
									</div>
								</div>
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b>Nacht SoC Freitag bis Sonntag:</b><br>
										<input type="text" name="nachtsoc1s1" id="nachtsoc1s1" value="<?php echo $mySettings->getSetting('nachtsoc1s1') ?>"><br>
										Gültiger Wert 1-99. Wenn SoC Modul Ladepunkt 2 vorhanden wird Nachts bis xx% SoC geladen in dem angegebenen Zeitfenster.
									</div>
								</div>
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b><label for="nacht2lls1">Morgens Laden Stromstärke in A:</label></b>
										<select name="nacht2lls1" id="nacht2lls1">
											<option <?php if($mySettings->getSetting('nacht2lls1') == 6) echo "selected" ?> value="6">6</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 7) echo "selected" ?> value="7">7</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 8) echo "selected" ?> value="8">8</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 9) echo "selected" ?> value="9">9</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 10) echo "selected" ?> value="10">10</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 11) echo "selected" ?> value="11">11</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 12) echo "selected" ?> value="12">12</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 13) echo "selected" ?> value="13">13</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 14) echo "selected" ?> value="14">14</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 15) echo "selected" ?> value="15">15</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 16) echo "selected" ?> value="16">16</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 17) echo "selected" ?> value="17">17</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 18) echo "selected" ?> value="18">18</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 19) echo "selected" ?> value="19">19</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 20) echo "selected" ?> value="20">20</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 21) echo "selected" ?> value="21">21</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 22) echo "selected" ?> value="22">22</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 23) echo "selected" ?> value="23">23</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 24) echo "selected" ?> value="24">24</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 25) echo "selected" ?> value="25">25</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 26) echo "selected" ?> value="26">26</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 27) echo "selected" ?> value="27">27</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 28) echo "selected" ?> value="28">28</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 29) echo "selected" ?> value="29">29</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 30) echo "selected" ?> value="30">30</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 31) echo "selected" ?> value="31">31</option>
											<option <?php if($mySettings->getSetting('nacht2lls1') == 32) echo "selected" ?> value="32">32</option>
										</select><br>
										Ampere mit der im zweiten Intervall geladen werden soll
									</div>
								</div>
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b><label for="nachtladen2abuhrs1">Morgens Laden Uhrzeit ab:</label></b>
										<select name="nachtladen2abuhrs1" id="nachtladen2abuhrs1">
											<option <?php if($mySettings->getSetting('nachtladen2abuhrs1') == 3) echo "selected" ?> value="3">3</option>
											<option <?php if($mySettings->getSetting('nachtladen2abuhrs1') == 4) echo "selected" ?> value="4">4</option>
											<option <?php if($mySettings->getSetting('nachtladen2abuhrs1') == 5) echo "selected" ?> value="5">5</option>
											<option <?php if($mySettings->getSetting('nachtladen2abuhrs1') == 6) echo "selected" ?> value="6">6</option>
											<option <?php if($mySettings->getSetting('nachtladen2abuhrs1') == 7) echo "selected" ?> value="7">7</option>
											<option <?php if($mySettings->getSetting('nachtladen2abuhrs1') == 8) echo "selected" ?> value="8">8</option>
											<option <?php if($mySettings->getSetting('nachtladen2abuhrs1') == 9) echo "selected" ?> value="9">9</option>
										</select><br>
										Ab wann im zweiten Intervall geladen werden soll
									</div>
								</div>
								<div class="row" style="background-color:#00ada8">
									<div class="col">
										<b><label for="nachtladen2bisuhrs1">Morgens Laden Uhrzeit bis:</label></b>
										<select name="nachtladen2bisuhrs1" id="nachtladen2bisuhrs1">
											<option <?php if($mySettings->getSetting('nachtladen2bisuhrs1') == 4) echo "selected" ?> value="4">4</option>
											<option <?php if($mySettings->getSetting('nachtladen2bisuhrs1') == 5) echo "selected" ?> value="5">5</option>
											<option <?php if($mySettings->getSetting('nachtladen2bisuhrs1') == 6) echo "selected" ?> value="6">6</option>
											<option <?php if($mySettings->getSetting('nachtladen2bisuhrs1') == 7) echo "selected" ?> value="7">7</option>
											<option <?php if($mySettings->getSetting('nachtladen2bisuhrs1') == 8) echo "selected" ?> value="8">8</option>
											<option <?php if($mySettings->getSetting('nachtladen2bisuhrs1') == 9) echo "selected" ?> value="9">9</option>
											<option <?php if($mySettings->getSetting('nachtladen2bisuhrs1') == 10) echo "selected" ?> value="10">10</option>
										</select><br>
										Bis wann morgens im zweiten Intervall geladen werden soll
									</div>
								</div>
							</div>
							<script>
								$(function() {
									if($('#nachtladens1').val() == '0') {
										$('#nachtladenauss1').show();
										$('#nachtladenans1').hide();
									} else {
										$('#nachtladenauss1').hide();
										$('#nachtladenans1').show();
									}
									$('#nachtladens1').change(function(){
										if($('#nachtladens1').val() == '0') {
											$('#nachtladenauss1').show();
											$('#nachtladenans1').hide();
										} else {
											$('#nachtladenauss1').hide();
											$('#nachtladenans1').show();
										}
									});
								});
							</script>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<h1>EVU basiertes Lastmanagement</h1>
						</div>
					</div>
					<div class="row" style="background-color:#ffffcc">
						<div class="col">
							<b><label for="lastmaxap1">Lastmanagement Max Ampere Phase 1:</label></b>
							<input type="text" name="lastmaxap1" id="lastmaxap1" value="<?php echo $mySettings->getSetting('lastmaxap1') ?>">
						</div>
					</div>
					<div class="row" style="background-color:#ffffcc">
						<div class="col">
							<b><label for="lastmaxap2">Lastmanagement Max Ampere Phase 2:</label></b>
							<input type="text" name="lastmaxap2" id="lastmaxap2" value="<?php echo $mySettings->getSetting('lastmaxap2') ?>">
						</div>
					</div>
					<div class="row" style="background-color:#ffffcc">
						<div class="col">
							<b><label for="lastmaxap3">Lastmanagement Max Ampere Phase 3:</label></b>
							<input type="text" name="lastmaxap3" id="lastmaxap3" value="<?php echo $mySettings->getSetting('lastmaxap3') ?>">
						</div>
					</div>
					<div class="row" style="background-color:#ffffcc">
						<div class="col">
							Gültige Werte 7-64. Definiert die maximal erlaubte Stromstärke der einzelnen Phasen des Hausanschlusses im Sofort Laden Modus, sofern das EVU Modul die Werte je Phase zur Verfügung stellt.
						</div>
					</div>
					<div class="row" style="background-color:#ffffcc">
						<div class="col">
							<b><label for="lastmmaxw">Lastmanagement maximaler Bezug:</label></b>
							<input type="text" name="lastmmaxw" id="lastmmaxw" value="<?php echo $mySettings->getSetting('lastmmaxw') ?>">
						</div>
					</div>
					<div class="row" style="background-color:#ffffcc">
						<div class="col">
							Gültige Werte 2000-200000. Definiert die maximal erlaubten bezogenen Watt des Hausanschlusses im Sofort Laden Modus, sofern die Bezugsleistung bekannt ist.<br><br>
						</div>
					</div>

					<div id="loadsharingdiv">
						<div class="row"><hr>
							<div class="col">
								<h1>Loadsharing LP1/2</h1>
							</div>
						</div>
						<div class="row" style="background-color:#e6ccb3">
							<div class="col">
								<b><label for="loadsharinglp12">Loadsharing LP 1 / LP 2:</label></b>
								<select name="loadsharinglp12" id="loadsharinglp12">
									<option <?php if($mySettings->getSetting('loadsharinglp12') == 0) echo "selected" ?> value="0">Deaktiviert</option>
									<option <?php if($mySettings->getSetting('loadsharinglp12') == 1) echo "selected" ?> value="1">Aktiviert</option>
								</select><br>
							</div>
						</div>
						<div class="row" style="background-color:#e6ccb3">
							<div class="col">
								<b><label for="loadsharingalp12">Loadsharing Ampere LP 1 / LP 2:</label></b>
								<select name="loadsharingalp12" id="loadsharingalp12">
									<option <?php if($mySettings->getSetting('loadsharingalp12') == 16) echo "selected" ?> value="16">16 Ampere</option>
									<option <?php if($mySettings->getSetting('$loadsharingalp12') == 32) echo "selected" ?> value="32">32 Ampere</option>
								</select><br>
							</div>
						</div>
						<div class="row" style="background-color:#e6ccb3">
							<div class="col">
								Wenn Ladepunkt 1 und Ladepunkt 2 sich eine Zuleitung teilen, diese Option aktivieren. Bei der OpenWB Duo muss diese Option aktiviert werden!<br>
								Sie stellt in jedem Lademodus sicher, dass nicht mehr als 16 bzw. 32A je Phase in der Summe von LP 1 und LP 2 genutzt werden.<br>
								Der richtige Anschluss ist zu gewährleisten.<br>

								Ladepunkt 1:
								<p style="text-indent :2em;" >Phase 1 Zuleitung = Phase 1 Ladepunkt 1</p>
								<p style="text-indent :2em;" >Phase 2 Zuleitung = Phase 2 Ladepunkt 1</p>
								<p style="text-indent :2em;" >Phase 3 Zuleitung = Phase 3 Ladepunkt 1</p>
								Ladepunkt 2:
								<p style="text-indent :2em;" >Phase 1 Zuleitung = Phase 2 Ladepunkt 2</p>
								<p style="text-indent :2em;" >Phase 2 Zuleitung = Phase 3 Ladepunkt 2</p>
								<p style="text-indent :2em;" >Phase 3 Zuleitung = Phase 1 Ladepunkt 2</p>
								Durch das Drehen der Phasen ist sichergestellt, dass 2 einphasige Autos mit voller Geschwindigkeit laden können.
							</div>
						</div>
					</div>
					<div class="row justify-content-center">
						<button type="submit" class="btn btn-green">Save</button>
					</div>
				</form>

				<div class="row justify-content-center">
					<div class="col text-center">
						Open Source made with love!<br>
						Jede Spende hilft die Weiterentwicklung von openWB voranzutreiben<br>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="2K8C4Y2JTGH7U">
							<input type="image" src="./img/btn_donate_SM.gif" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
							<img alt="" src="./img/pixel.gif" width="1" height="1">
						</form>
					</div>
				</div>
			</div>
		</div>

		<footer class="footer bg-dark text-light font-small">
			<div class="container text-center">
				<small>Sie befinden sich hier: Einstellungen/Allgemein</small>
			</div>
		</footer>


		<script type="text/javascript">

			$.get("settings/navbar.html", function(data){
				$("#nav").replaceWith(data);
				// disable navbar entry for current page
				$('#navAllgemein').addClass('disabled');
			});

		</script>

	</body>
</html>
