<?php
$owbversion = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/openWB/web/version');
if (isset($_GET['theme'])) {
	$theme = $_GET['theme'];
	$_SESSION['theme'] = $theme;
} else {
	$theme = $themeold;
	$_SESSION['theme'] = $theme;
}


// convert lines to key/value array for faster manipulation
foreach($lines as $line) {
	// split line at char '='
	$splitLine = explode('=', $line);
	// trim parts
	$splitLine[0] = trim($splitLine[0]);
	$splitLine[1] = trim($splitLine[1]);
	// push key/value pair to new array
	$settingsArray[$splitLine[0]] = $splitLine[1];
}
// now values can be accessed by $settingsArray[$key] = $value;

$isConfiguredLp = array_fill(1, 8, false); // holds boolean for configured lp
// due to inconsitent variable naming need individual lines
$isConfiguredLp[1] = 1;  // lp1 always configured
$isConfiguredLp[2] = ($settingsArray['lastmanagement'] == 1) ? 1 : 0;
$isConfiguredLp[3] = ($settingsArray['lastmanagements2'] == 1) ? 1 : 0;
for ( $lp = 4  ; $lp <= 8; $lp++) {
	$isConfiguredLp[$lp] = ($settingsArray['lastmanagementlp'.$lp] == 1) ? 1 : 0;
}
$countLpConfigured = array_sum($isConfiguredLp);

// remove special characters from lp-names except space and underscore... maybe dangerous
for ( $lp = 1  ; $lp <= 8; $lp++) {
	$settingsArray['lp'.$lp.'name'] = preg_replace('/[^A-Za-z0-9_ ]/', '', $settingsArray['lp'.$lp.'name']);
}

?>
