<?php
require_once './settings/settingsClass.php';
$mySettings = new openWBSettings();

require_once './tools/ramdiskClass.php';
$myRamdisk = new openWBRamdisk();

if(isset($_GET["lademodus"])) {
	$myRamdisk->setData('lademodus',$_GET["lademodus"]);
}
if(isset($_GET["sofortlllp1"])) {
	$myRamdisk->setData('lp1sofortll',$_GET["sofortlllp1"]);
}
if(isset($_GET["sofortlllp2"])) {
	$myRamdisk->setData('lp2sofortll',$_GET["sofortlllp2"]);
}
if(isset($_GET["sofortlllp3"])) {
	$myRamdisk->setData('lp3sofortll',$_GET["sofortlllp3"]);
}
if(isset($_GET["speicher"])) {
	$myRamdisk->setData('speicher',$_GET["speicher"]);
}
if(isset($_GET["get"])) {
	if($_GET["get"] == "homekit") {
		$json = array(
			"date"	=>	date('Y:m:d-H:i:s'),
			"llkwlp1"	=>	$myRamdisk->getData('llaktuell', true),
			"llkwlp2"	=>	$myRamdisk->getData('llaktuells1', true),
			"llkwlp3"	=>	$myRamdisk->getData('llaktuells2', true),
			"socLP1"	=>	$myRamdisk->getData('soc', true),
			"speichersoc"	=>	$myRamdisk->getData('speichersoc', true),
			"speicherleistung"	=>	$myRamdisk->getData('speicherleistung', true),
			"evuw"	=>	$myRamdisk->getData('wattbezug', true),
			"pvw"	=>	$myRamdisk->getData('pvwatt', true),
			"socLP2"	=>	$myRamdisk->getData('soc1', true)
		);
		header("Content-type: application/json");
		echo json_encode($json);
	}
	if($_GET["get"] == "all") {
		$json = array(
			"date"	=>	date('Y:m:d-H:i:s'),
			"lademodus"	=>	$myRamdisk->getData('lademodus'),
			"minimalstromstaerke" => $mySettings->getSetting("minimalstromstaerke"),
			"maximalstromstaerke" => $mySettings->getSetting("maximalstromstaerke"),
			"llsoll"	=>	$myRamdisk->getData('llsoll'),
			"restzeitlp1"	=>	$myRamdisk->getData('restzeitlp1'),
			"restzeitlp2"	=>	$myRamdisk->getData('restzeitlp2'),
			"restzeitlp3"	=>	$myRamdisk->getData('restzeitlp3'),
			"gelkwhlp1"	=>	$myRamdisk->getData('aktgeladen'),
			"gelkwhlp2"	=>	$myRamdisk->getData('aktgeladens1'),
			"gelkwhlp3"	=>	$myRamdisk->getData('aktgeladens2'),
			"gelrlp1"	=>	$myRamdisk->getData('gelrlp1'),
			"gelrlp2"	=>	$myRamdisk->getData('gelrlp2'),
			"gelrlp3"	=>	$myRamdisk->getData('gelrlp3'),
			"llgesamt"	=>	$myRamdisk->getData('llkombiniert'),
			"evua1"	=>	$myRamdisk->getData('bezuga1'),
			"evua2"	=>	$myRamdisk->getData('bezuga2'),
			"evua3"	=>	$myRamdisk->getData('bezuga3'),
			"lllp1"	=>	$myRamdisk->getData('llaktuell'),
			"lllp2"	=>	$myRamdisk->getData('llaktuells1'),
			"lllp3"	=>	$myRamdisk->getData('llaktuells2'),
			"evuw"	=>	$myRamdisk->getData('wattbezug'),
			"pvw"	=>	$myRamdisk->getData('pvwatt'),
			"evuv1"	=>	$myRamdisk->getData('evuv1'),
			"evuv2"	=>	$myRamdisk->getData('evuv2'),
			"evuv3"	=>	$myRamdisk->getData('evuv3'),
			"ladestatusLP1"	=>	$myRamdisk->getData('ladestatus'),
			"ladestatusLP2"	=>	$myRamdisk->getData('ladestatuss1'),
			"ladestatusLP3"	=>	$myRamdisk->getData('ladestatuss2'),
			"ladestartzeitLP1"	=>	$myRamdisk->getData('ladestart'),
			"ladestartzeitLP2"	=>	$myRamdisk->getData('ladestarts1'),
			"ladestartzeitLP3"	=>	$myRamdisk->getData('ladestarts2'),
			"zielladungaktiv"	=>	$myRamdisk->getData('ladungdurchziel'),
			"lla1LP1"	=>	$myRamdisk->getData('lla1'),
			"lla2LP1"	=>	$myRamdisk->getData('lla2'),
			"lla3LP1"	=>	$myRamdisk->getData('lla3'),
			"lla1LP2"	=>	$myRamdisk->getData('llas11'),
			"lla2LP2"	=>	$myRamdisk->getData('llas12'),
			"lla3LP2"	=>	$myRamdisk->getData('llas13'),
			"llkwhLP1"	=>	$myRamdisk->getData('llkwh'),
			"llkwhLP2"	=>	$myRamdisk->getData('llkwhs1'),
			"llkwhLP3"	=>	$myRamdisk->getData('llkwhs2'),
			"evubezugWh"	=>	$myRamdisk->getData('bezugkwh'),
			"evueinspeisungWh"	=>	$myRamdisk->getData('einspeisungkwh'),
			"pvWh"	=>	$myRamdisk->getData('pvkwh'),
			"speichersoc"	=>	$myRamdisk->getData('speichersoc'),
			"socLP1"	=>	$myRamdisk->getData('soc'),
			"socLP2"	=>	$myRamdisk->getData('soc1'),
			"speicherleistung"	=>	$myRamdisk->getData('speicherleistung'),
			"ladungaktivLP1"	=>	$myRamdisk->getData('ladungaktivlp1'),
			"ladungaktivLP2"	=>	$myRamdisk->getData('ladungaktivlp2'),
			"ladungaktivLP3"	=>	$myRamdisk->getData('ladungaktivlp3'),
			"chargestatLP1"	=>	$myRamdisk->getData('chargestat'),
			"chargestatLP2"	=>	$myRamdisk->getData('chargestats1'),
			"plugstatLP1"	=>	$myRamdisk->getData('plugstat'),
			"plugstatLP2"	=>	$myRamdisk->getData('plugstats1'),
			"restzeitlp1m"	=>	$myRamdisk->getData('restzeitlp1m'),
			"restzeitlp2m"	=>	$myRamdisk->getData('restzeitlp2m'),
			"restzeitlp3m"	=>	$myRamdisk->getData('restzeitlp3m'),
			"lla1LP3"	=>	$myRamdisk->getData('llas21'),
			"lla2LP3"	=>	$myRamdisk->getData('llas22'),
			"lla3LP3"	=>	$myRamdisk->getData('llas23')
		);
		header("Content-type: application/json");
		echo json_encode($json);
	}
}
?>
