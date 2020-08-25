<?php
session_start();
require_once "/var/www/html/openWB/web/class/pDraw.class.php";
require_once "/var/www/html/openWB/web/class/pImage.class.php";
require_once "/var/www/html/openWB/web/class/pData.class.php";

require_once '../../tools/ramdiskClass.php';
$myRamdisk = new openWBRamdisk();
require_once '../../settings/settingsClass.php';
$mySettings = new openWBSettings();

$myData = new pData();
$myData->addPoints($myRamdisk->getData('ev-live.graph'),"EV");
$myData->addPoints($myRamdisk->getData('ev1-live.graph'),"EV1");
$myData->addPoints($myRamdisk->getData('evu-live.graph'),"EVU");
$myData->addPoints($myRamdisk->getData('pv-live.graph'),"PV");
$myData->addPoints($myRamdisk->getData('soc-live.graph'), "SoC");
if ($myRamdisk->getData('speichervorhanden') == 1) {
	$myData->addPoints($myRamdisk->getData('speicher-live.graph'), "Speicher");
	$myData->addPoints($myRamdisk->getData('speichersoc-live.graph'), "Speicher SoC");
}
if ($myRamdisk->getData('soc1vorhanden') == 1) {
	$myData->addPoints($myRamdisk->getData('soc1-live.graph'), "SoC LP2");
	$myData->addPoints($myRamdisk->getData('ev2-live.graph'),"EV2");
}
$highest1 = max($myRamdisk->getData('evu-live.graph'));
$highest = max($myRamdisk->getData('ev-live.graph'));
$highest2 = max($myRamdisk->getData('pv-live.graph'));
$highest = max($highest,$highest1,$highest2);
$lowest = min($myRamdisk->getData('evu-live.graph'));
$lowest1 = min($myRamdisk->getData('pv-live.graph'));
$lowest2 = min($myRamdisk->getData('ev-live.graph'));
if ($myRamdisk->getData('speichervorhanden') == 1) {
	$lowest3 = min($myRamdisk->getData('speicher-live.graph'));
	$loweste = min($lowest,$lowest1,$lowest2,$lowest3);
} else {
	$loweste = min($lowest,$lowest1,$lowest2);
}

$myData->setSerieOnAxis("EV1",0);
$myData->setSerieOnAxis("EV",0);
$myData->setSerieOnAxis("EVU",0);
$myData->setSerieOnAxis("PV",0);
if ($myRamdisk->getData('speichervorhanden') == 1) {
	$myData->setSerieOnAxis("Speicher",0);
	$myData->setPalette("Speicher",array("R"=>122,"G"=>29,"B"=>29));
	$myData->setSerieOnAxis("Speicher SoC",1);
	$myData->setPalette("Speicher SoC",array("R"=>229,"G"=>59,"B"=>59));
}
if ($myRamdisk->getData('soc1vorhanden') == 1) {
	$myData->setSerieOnAxis("EV1",0);
	$myData->setPalette("EV2",array("R"=>51,"G"=>122,"B"=>83));
	$myData->setSerieOnAxis("SoC LP2",1);
	$myData->setPalette("SoC LP2",array("R"=>0,"G"=>155,"B"=>237));
	$minsoc = min($myRamdisk->getData('soc-live.graph'),$myRamdisk->getData('soc1-live.graph'));
	$minsoc = min($minsoc);
	$maxsoc1 = max($myRamdisk->getData('soc1-live.graph'));
	$maxsoc = max($myRamdisk->getData('soc-live.graph'));
	$maxsoc = max($maxsoc,$maxsoc1);
	if ($maxsoc > 100) {
		$maxsoc = "100";
	}
} else {
	$minsoc = min($myRamdisk->getData('soc-live.graph'));
	$maxsoc = max($myRamdisk->getData('soc-live.graph'));
	if ($maxsoc > 100) {
		$maxsoc = "100";
	}
}
if ($myRamdisk->getData('speichervorhanden') == 1) {
	$minssoc = min($myRamdisk->getData('speichersoc-live.graph'));
	$minsoc = min($minssoc,$minsoc);
	$maxssoc = max($myRamdisk->getData('speichersoc-live.graph'));
	$maxsoc = max($maxssoc,$maxsoc);
}
$myData->setSerieOnAxis("SoC",1);
$myData->setPalette("EV",array("R"=>51,"G"=>122,"B"=>183));
$myData->setPalette("EV1",array("R"=>51,"G"=>122,"B"=>213));
$myData->setPalette("SoC",array("R"=>0,"G"=>255,"B"=>237));
$myData->setPalette("EVU",array("R"=>254,"G"=>0,"B"=>0));
$myData->setPalette("PV",array("R"=>0,"G"=>254,"B"=>0));

$myData->addPoints($myRamdisk->getData('time-live.graph'),"Labels");
$myData->setSerieOnAxis("Labels",0);
$myData->setSerieDescription("Labels","Uhrzeit");
$myData->setAbscissa("Labels");
$myData->setAxisPosition(1,AXIS_POSITION_RIGHT);
$myData->setAxisName(0,"kW");
$myData->setAxisPosition(2,AXIS_POSITION_RIGHT);
$myData->setAxisName(1,"% SoC");
$myData->setAxisDisplay(0,AXIS_FORMAT_CUSTOM,"YAxisFormat");

$AxisBoundaries = array(0=>array("Min"=>$loweste,"Max"=>$highest),1=>array("Min"=>$minsoc,"Max"=>$maxsoc));
$ScaleSettings  = array("DrawYLines"=>array(0),"GridR"=>128,"GridG"=>128,"GridB"=>128,"GridTicks"=>0,"GridAlpha"=>5,"DrawXLines"=>FALSE,"Mode"=>SCALE_MODE_MANUAL,
						"ManualScale"=>$AxisBoundaries,"LabelSkip"=>24);

$width = 1150;
$height = 200;

$myImage = new pImage($width, $height, $myData);
$myImage->setFontProperties(array(
	"FontName" => "/var/www/html/openWB/web/fonts/GeosansLight.ttf",
	"FontSize" => 18));
$myImage->setGraphArea(70,25,1070,175);
// set background gradient
//$Settings = array("StartR" => 221, "StartG" => 221, "StartB" => 221, "EndR" => 120, "EndG" => 120, "EndB" => 120, "Alpha" => 50);
//$myImage->drawGradientArea(0, 0, $width, $height, DIRECTION_VERTICAL, $Settings);

$myImage->drawScale($ScaleSettings);
$myImage->drawLegend(240,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
$myData->setSerieDrawable("PV",false);
$myData->setSerieDrawable("EVU",false);
if ($myRamdisk->getData('speichervorhanden') == 1) {
	$myData->setSerieDrawable("Speicher",true);
	$myData->setSerieDrawable("Speicher SoC",true);
}

$myImage->drawLineChart();
if ($myRamdisk->getData('speichervorhanden') == 1) {
	$myData->setSerieDrawable("Speicher",false);
	$myData->setSerieDrawable("Speicher SoC",false);
}
if ($myRamdisk->getData('soc1vorhanden') == 1) {
	$myData->setSerieDrawable("SoC LP2",false);
}
$myData->setSerieDrawable("PV",true);
$myData->setSerieDrawable("EVU",true);
$myData->setSerieDrawable("SoC",false);
$myData->setSerieDrawable("EV",true);
$myData->setSerieDrawable("EV1",false);
$myData->setSerieDrawable("EV2",false);
$myImage->drawAreaChart();

$myImage->autoOutput();

function YAxisFormat($Value) {
	return(round($Value/1000,2));
}
