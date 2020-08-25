<?php
session_start();
require_once "/var/www/html/openWB/web/class/pDraw.class.php";
require_once "/var/www/html/openWB/web/class/pImage.class.php";
require_once "/var/www/html/openWB/web/class/pData.class.php";

require_once './tools/ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

$EV = $myRamdisk->getData('ev-live.graph');
$EVU = $myRamdisk->getData('evu-live.graph');
$PV = $myRamdisk->getData('pv-live.graph');
$timef = $myRamdisk->getData('time-live.graph');
$SOC = $myRamdisk->getData('soc-live.graph');

$myData = new pData();
$myData->addPoints($EV,"EV");
$myData->addPoints($EVU,"EVU");
$myData->addPoints($PV,"PV");
$myData->addPoints($SOC, "SoC");

$highest1 = max($EVU);
$highest = max($EV);
$highest2 = max($PV);
$highest = max($highest,$highest1,$highest2);
$lowestu = min($EVU);
$lowest = min($PV);
$lowest = min($lowest,$lowestu);
$myData->setSerieOnAxis("EV",0);
$myData->setSerieOnAxis("EVU",0);
$myData->setSerieOnAxis("PV",0);
$myData->setSerieOnAxis("SoC",1);
$myData->setPalette("EV",array("R"=>0,"G"=>0,"B"=>254));
$myData->setPalette("EVU",array("R"=>254,"G"=>0,"B"=>0));
$myData->setPalette("PV",array("R"=>0,"G"=>254,"B"=>0));

$myData->addPoints($timef,"Labels");
$myData->setSerieOnAxis("Labels",0);
$myData->setSerieDescription("Labels","Uhrzeit");
$myData->setAbscissa("Labels");
$myData->setAxisPosition(1,AXIS_POSITION_RIGHT);

$myData->setAxisName(0,"Watt");
$AxisBoundaries = array(0=>array("Min"=>$lowest,"Max"=>$highest),1=>array("Min"=>0,"Max"=>100));
$ScaleSettings  = array("Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>$AxisBoundaries,"LabelSkip"=>24);

$myImage = new pImage(320, 125, $myData);

$myImage->setFontProperties(array(
    "FontName" => "/var/www/html/openWB/web/fonts/GeosansLight.ttf",
    "FontSize" => 12));
$myImage->setGraphArea(45,15, 290,100);
$myImage->drawScale($ScaleSettings);

$myImage->drawLineChart();

$myImage->autoOutput(); // headers are sent by method, no filename as we are directly streaming to the browser
