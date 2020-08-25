<!DOCTYPE html>
<html lang="de">

	<!-- Einstellungen für automatisches Sperren/Entsperren
		 der LP: ein Vorgang pro Tag
		 Autor: M. Ortenstein -->
	<head>
		<base href="/openWB/web/">

		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>openWB Einstellungen</title>
		<meta name="author" content="Michael Ortenstein">
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

		<!-- important scripts to be loaded -->
		<script  src="js/jquery-3.4.1.min.js"></script>
		<script src="js/bootstrap-4.4.1/bootstrap.bundle.min.js"></script>

		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap-4.4.1/bootstrap.min.css">
		<!-- Normalize -->
		<link rel="stylesheet" type="text/css" href="css/normalize-8.0.1.css">
		<!-- Font Awesome, all styles -->
		<link href="fonts/font-awesome-5.8.2/css/all.css" rel="stylesheet">

		<!-- include settings-style -->
		<link rel="stylesheet" type="text/css" href="settings/settings_style.css">

		<!-- clockpicker -->
		<script src="js/clockpicker/bootstrap-clockpicker.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/clockpicker/bootstrap-clockpicker.min.css">

		<!-- global variables -->
		<script>
			var oldClockpickerTime;  // holds old value of clockpicker during changing the time
		</script>
	</head>

	<body>
		<?php

			// some global vars
			$maxQuantityLp = 8;  // max configured lp
			$elemName = '';
			$elemId = '';
			$elemValue = '';
			$elemCheckboxValue = '';
			$lp;
			$dayOfWeek;  // Mo = 1, ..., So = 7

			// get settings
			require_once $_SERVER['DOCUMENT_ROOT'].'/openWB/web/settings/settingsClass.php';
			$mySettings = new openWBSettings();

			$isConfiguredLp = array_fill(1, $maxQuantityLp, false); // holds boolean for configured lp
			// due to inconsitent variable naming need individual lines
			$isConfiguredLp[1] = 1;  // lp1 always configured
			$isConfiguredLp[2] = ($settingsArray['lastmanagement'] == 1) ? 1 : 0;
			$isConfiguredLp[3] = ($settingsArray['lastmanagements2'] == 1) ? 1 : 0;
			for ($lp=4; $lp<=$maxQuantityLp; $lp++) {
				$isConfiguredLp[$lp] = ($mySettings->getSetting('lastmanagementlp'.$lp) == 1) ? true : false;
			}

			// just to make sure... reset all elements for non-configured lp
			$newSettings = [];
			for ($lp=1; $lp<=$maxQuantityLp; $lp++) {
				if ( !$isConfiguredLp[$lp] ) {
					$newSettings['waitUntilFinishedBoxLp'.$lp] = 'off';
					for ($dayOfWeek=1; $dayOfWeek<=7; $dayOfWeek++) {
						// all days...
						$newSettings['lockBoxLp'.$lp.'_'.$dayOfWeek] = 'off';
						$newSettings['lockTimeLp'.$lp.'_'.$dayOfWeek] = '';
						$newSettings['unlockBoxLp'.$lp.'_'.$dayOfWeek] = 'off';
						$newSettings['unlockTimeLp'.$lp.'_'.$dayOfWeek] = '';
					}
				}
			}
			// merge settings into read config file
			$mySettings->setSettings($newSettings);

			function getDayOfWeekString($dayOfWeek) {
				// returns name of the weekday
				switch ($dayOfWeek) {
					case 1:
						return 'Montag';
					case 2:
						return 'Dienstag';
					case 3:
						return 'Mittwoch';
					case 4:
						return 'Donnerstag';
					case 5:
						return 'Freitag';
					case 6:
						return 'Samstag';
					case 7:
						return 'Sonntag';
					default:
						return 'Wochentag?';
				}
			}

			function buildElementProperties($elemType) {
				// builds name, id and value strings for element
				global $lp, $dayOfWeek, $elemName, $elemId, $elemValue, $mySettings;

				$elemId = $elemType.$lp.'_'.$dayOfWeek;
				$elemName = $elemType.$lp.'_'.$dayOfWeek;
				$elemValue = $mySettings->getSetting($elemId);
			}

			function echoCheckboxDiv($elemType, $label) {
				// echoes the div to render checkbox to lock lp
				global $elemName, $elemId, $elemValue;
				buildElementProperties($elemType);
				// translate boolean to proper html
				if ( $elemValue == 'on' ) {
					$elemCheckboxValue = " checked='checked'";
				} else {
					$elemCheckboxValue = '';
				}
				?>
				<div class="col-auto my-1">
					<div class="form-check">
						<input type="hidden" id="<?php echo $elemId."_text"; ?>" name="<?php echo $elemName; ?>" value="<?php echo $elemValue; ?>">
						<input class="form-check-input lockUnlockCheckbox checkboxToText" type="checkbox" id="<?php echo $elemId; ?>" <?php echo $elemCheckboxValue; ?>>
						<label class="form-check-label pl-10" for="<?php echo $elemId; ?>"><?php echo $label; ?></label>
					</div>
				</div>
				<?php
			}

			function echoClockpickerDiv($elemType) {
				// echoes the div to render locktime timepicker for lp
				global $elemName, $elemId, $elemValue;
				buildElementProperties($elemType);
				?>
				<div class="col-sm-6 my-1">
					<div class="input-group">
						<input type="text" class="form-control" readonly id="<?php echo $elemId; ?>" name="<?php echo $elemName; ?>" placeholder="--" value="<?php echo $elemValue; ?>">
						<div class="input-group-append">
							<span class="input-group-text far fa-xs fa-clock vaRow"></span>
						</div>
					</div>
				</div>
				<?php
			}

			function echoDayRow() {
				// echoes all elements for one day-row in form
				global $dayOfWeek;
				$dayOfWeekString = getDayOfWeekString($dayOfWeek);
				?>
				<div class="row vaRow">  <!-- row <?php echo $dayOfWeekString; ?> -->
					<div class="col-2">
						<?php echo $dayOfWeekString; ?>
					</div>
					<div class="col-5">
						<div class="form-row align-items-center">
				<?php
				echoCheckboxDiv("lockBoxLp", "sperren");
				echoClockpickerDiv("lockTimeLp");
				?>
						</div>
					</div>
					<div class="col-5">
						<div class="form-row align-items-center">
				<?php
				echoCheckboxDiv("unlockBoxLp", "entsperren");
				echoClockpickerDiv("unlockTimeLp");
				?>
						</div>
					</div>
				</div>  <!-- end row <?php echo $dayOfWeekString; ?> -->
				<?php
				if ( $dayOfWeek < 7 ) {
					?>
				<hr class="d-sm-none">
					<?php
				}
			}  // end echoDayRow

		?>

<!-- begin of html body -->

		<div id="nav"></div> <!-- placeholder for navbar -->

		<div role="main" class="container" style="margin-top:20px">
			<div class="row justify-content-center">

				<form class="form col-md-10" action="settings/savepostsettings.php" method="POST">

				<?php

					for ($lp=1; $lp<=$maxQuantityLp; $lp++) {
						// build form-groups for all lp
						if ( $isConfiguredLp[$lp] ) {
							// if lp is configured: display form-group
							$visibility = '';
						} else {
							// if lp is not configured: hide form-group
							$visibility = ' display: none;';
						}
						// remove special characters except space and underscore... maybe dangerous
						$nameLp = preg_replace('/[^A-Za-z0-9_ ]/', '', $mySettings->getSetting('lp'.$lp.'name'));

						$elemId = 'waitUntilFinishedBoxLp'.$lp;
						$elemName = 'waitUntilFinishedBoxLp'.$lp;
						$elemValue = $mySettings->getSetting($elemId);
						// translate boolean to proper html
						if ( $elemValue == 'on' ) {
							$elemCheckboxValue = " checked='checked'";
						} else {
							$elemCheckboxValue = '';
						}
						?>
						<div class="form-group px-3 pb-3" style="border:1px solid black;<?php echo $visibility; ?>" id="lp<?php echo $lp; ?>">  <!-- group charge point <?php echo $lp; ?> -->
							<h1>LP <?php echo $lp; ?> (<?php echo $nameLp; ?>)</h1>
							<div class="row mt-2">
								<div class="col">
									<div class="form-check">
										<input type="hidden" id="<?php echo $elemId; ?>_text" name="<?php echo $elemName; ?>" value="<?php echo $elemValue; ?>">
										<input class="form-check-input checkboxToText" type="checkbox" id="<?php echo $elemId; ?>"<?php echo $elemCheckboxValue; ?>>
										<label class="form-check-label pl-10" for="<?php echo $elemId; ?>">sperren erst nach Ende lfd. Ladevorgang</label>
									</div>
								</div>
							</div>
							<hr>
						<?php
						for ($dayOfWeek=1; $dayOfWeek<=7; $dayOfWeek++) {
							// build form-rows for all weekdays
							echoDayRow();
						}  // end all days
						?>
							<div class="row justify-content-center mt-2">
								<button type="button" class="btn btn-sm btn-red resetForm" id="resetFormBtnLp<?php echo $lp; ?>">LP<?php echo $lp; ?> zurücksetzen</button>
							</div>
						</div>  <!-- end form-group charge point <?php echo $lp; ?> -->
						<?php
					}  // end all lp

				?>

					<div class="row justify-content-center">
						<button type="submit" class="btn btn-green">Einstellungen übernehmen</button>
					</div>

				</form>  <!-- end form -->
			</div>

		</div>  <!-- end container -->

		<footer class="footer bg-dark text-light font-small">
			<div class="container text-center">
				<small>Sie befinden sich hier: Auto-Lock</small>
			</div>
		</footer>

		<script type="text/javascript">

			$.get("settings/navbar.html", function(data){
				$("#nav").replaceWith(data);
				// disable navbar entry for current page
				$('#navAutolock').addClass('disabled');
			});

			$(document).ready(function(){

				function addClockpicker(clockpickerId, initialSetup) {
					if ( !initialSetup ) {
						// make sure both times lock/unlock differ, not necessary at initial setup from config
						// add a clockpicker to input targetId (eg #unlockTimeLp1_7)
						// first create clockpicker id of the second clockpicker for the lp and day
						if ( clockpickerId.includes("unlock") ) {
							var secondClockpickerId = clockpickerId.replace("unlock", "lock");
						} else {
							var secondClockpickerId = clockpickerId.replace("lock", "unlock");
						}
						if ( $(secondClockpickerId).val() != "" ) {
							// other clockpicker is present, make sure both times for the day differ
							var timeParts = $(secondClockpickerId).val().split(":");
							var newTime = new Date(0, 0, 0, timeParts[0], timeParts[1]);  // date doesn't matter, time = the second clockpicker
							newTime.setMinutes(newTime.getMinutes() + 5);  // add 5 minutes
							var timeStr = (newTime.getHours() < 10 ? "0" : "") + newTime.getHours() + ":" + (newTime.getMinutes() < 10 ? "0" : "") + newTime.getMinutes(); // convert with leading zeros
							$(clockpickerId).val(timeStr);  // set value to calculated new time
						} else {
							// get current time rounded to next 5 minute
							var step = 1000 * 60 * 5;  // 5 minutes in milliseconds
							var now = new Date();  // get date/time
							now.setSeconds(0);  // remove seconds
							now.setMilliseconds(0);  // and milliseconds
							var roundedDate = new Date(Math.ceil(now / step) * step);  // round up to next full 5 minutes
							var timeStr = (roundedDate.getHours() < 10 ? "0" : "") + roundedDate.getHours() + ":" + (roundedDate.getMinutes() < 10 ? "0" : "") + roundedDate.getMinutes(); // convert with leading zeros
							$(clockpickerId).val(timeStr);  // set value to calculated new time
						}
					}
					$(clockpickerId).clockpicker({
						placement: "bottom",  // clock popover placement
						align: "left",  // popover arrow align
						donetext: "",  // done button text
						autoclose: true,  // auto close when minute is selected
						vibrate: true,  // vibrate the device when dragging clock hand
						default: "00:00",
					});
				}  // end add clockpicker

				function removeClockpicker(targetId) {
					// remove a clockpicker in input targetId (eg #unlockTimeLp1_7)
					// and set input value to --
					if ( $(targetId).val() != "" ) {
						// if clockpicker exists
						$(targetId).clockpicker("remove");
						$(targetId).val("");
					}
				}

				$(function() {
					$(".lockUnlockCheckbox").change(function() {
						// if a checkbox for enabling lock or unlock time is checked/unchecked
						// add/remove respective clockpicker and empty input field if removed
						var boxIsChecked = $(this).prop("checked") == true;
						var clockpickerId = "#" + this.id.replace("Box", "Time");  // create matching clockpicker id
						if ( boxIsChecked ) {
							// activate clockpicker
							if ( $(clockpickerId).val() == "" ) {
								// replace empty field (placeholder = --) with initial time
								$(clockpickerId).val("00:00");
							}
							addClockpicker(clockpickerId, false);
						} else {
							// remove clockpicker
							removeClockpicker(clockpickerId);
						}
					});

					$(".checkboxToText").change(function() {
						var boxIsChecked = $(this).prop("checked") == true;
						// if a checkbox for enabling lock or unlock time is checked/unchecked
						// fill the corresponding hidden input field
						var textID = "#"+this.id+"_text";
						if ( boxIsChecked ) {
							$(textID).val("on");
						} else {
							$(textID).val("off");
						}
					});

					$("input:text").click(function() {
						// if clockpicker input is clickedstore the old clockpicker time of clicked clockpicker in global var
						//  before changing it so it can be reset if lock/unlock time is accidently chosen to be identical
						window.oldClockpickerTime = $(this).val();
					});

					$("input:text").change(function() {
						// if clockpicker input is equal to second time of the days, reset to old value
						// create clockpicker id of the second clockpicker for the lp and day
						var clockpickerId = "#"+this.id;
						if ( clockpickerId.includes("unlock") ) {
							var secondClockpickerId = clockpickerId.replace("unlock", "lock");
						} else {
							var secondClockpickerId = clockpickerId.replace("lock", "unlock");
						}
						if ( window.oldClockpickerTime != "" && $(clockpickerId).val() == $(secondClockpickerId).val() ) {
							// both clockpickers with same times for the day
							$(clockpickerId).val(window.oldClockpickerTime);  // so reset to last value
							$("#alertModal").modal('show');
						}
					});

					$(".resetForm").click(function() {
						// reset all inputs for lp
						$('input:checkbox').removeAttr('checked');
						var chargePoint = this.id.match(/\d+/g)[0];  // extract lp-# from button id
						for (day=1; day<=7; day++) {
							// reset all days
							$("#lockBoxLp"+chargePoint+"_"+day).prop("checked", false);
							$("#lockBoxLp"+chargePoint+"_"+day+"_text").val("off");
							removeClockpicker("#lockTimeLp"+chargePoint+"_"+day);
							$("#unlockBoxLp"+chargePoint+"_"+day).prop("checked", false);
							$("#unlockBoxLp"+chargePoint+"_"+day+"_text").val("off");
							removeClockpicker("#unlockTimeLp"+chargePoint+"_"+day);
							$("#waitUntilFinishedBoxLp"+chargePoint).prop("checked", false);
							$("#waitUntilFinishedBoxLp"+chargePoint+"_text").val("off");
						}
					});

				});  // end $(function()...

				// initially add all clockpickers to visible form-groups
				for (chargePoint=1; chargePoint<=8; chargePoint++) {
					if ( $("#lp"+chargePoint).is(":visible") ) {
						for (day=1; day<=7; day++) {
							if ( $("#lockBoxLp"+chargePoint+"_"+day).prop("checked") == true ) {
								addClockpicker("#lockTimeLp"+chargePoint+"_"+day, true);
							}
							if ( $("#unlockBoxLp"+chargePoint+"_"+day).prop("checked") == true ) {
								addClockpicker("#unlockTimeLp"+chargePoint+"_"+day, true);
							}
						}
					}

				}

			});  // end document ready function

		</script>

		<!-- modal alert window -->
		<div class="modal fade" id="alertModal">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- modal header -->
					<div class="modal-header btn-blue">
						<h4 class="modal-title">Info</h4>
					</div>

					<!-- modal body -->
					<div class="modal-body text-center">
						Beide Schaltzeiten müssen sich unterscheiden,<br>
						ursprüngliche Zeit wurde wiederhergestellt.
					</div>

					<!-- modal footer -->
					<div class="modal-footer justify-content-center">
						<button type="button" class="btn btn-green" data-dismiss="modal">OK</button>
					</div>

				</div>
			</div>
		</div>

	</body>

</html>
