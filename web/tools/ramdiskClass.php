<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/openWB/web/settings/settingsClass.php';

class openWBRamdisk {

	private $ramdiskPath = '';
	private $mySettings;

	function __construct($newPath = null){
		if(is_null($newPath)){
			$newPath = $_SERVER['DOCUMENT_ROOT'].'/openWB/ramdisk';
		}
		if(file_exists($newPath)){
			$this->ramdiskPath = $newPath;
		} else {
			die("Ramdisk nicht gefunden: $newPath");
		}
		$this->mySettings = new openWBSettings();
	}

	public function getData($datapoint, $homekit = false){
		if(file_exists($this->ramdiskPath."/".$datapoint)){
			$value = trim(file_get_contents($this->ramdiskPath."/".$datapoint));
			// special conversions for different datapoints
			switch( $datapoint ){
				case 'llaktuell':
				case 'llaktuells1':
				case 'llaktuells2':
				case 'speicherleistung':
				case 'wattbezug':
				case 'pvwatt':
					if( $homekit === true ){
						$value = $value / 1000;
					}
				break;
			}
			return $value;
		}
		return null;
	}

	public function getDataArray($datapointArray, $homekit = false){
		$result = array();
		foreach($datapointArray as $key => $datapoint){
			if( is_numeric($key) ){
				$result[$datapoint] = getData($datapoint, $homekit);
			} else {
				$result[$text] = getData($datapoint, $homekit);
			}
		}
		return $result;
	}

	public function setData($datapoint, $value, $append = false){
		if(file_exists($this->ramdiskPath."/".$datapoint)){
			// special conversions for different datapoints
			switch($datapoint){
				case 'lademodus':
					$value = $this->getLademodusNumber($value);
				break;
				case 'lp1sofortll':
				case 'lp2sofortll':
				case 'lp3sofortll':
					$value = $this->getSofortll($value);
				break;
			}
			if($append === true){
				file_put_contents($this->ramdiskPath."/".$datapoint, $value, FILE_APPEND);
			} else {
				file_put_contents($this->ramdiskPath."/".$datapoint, $value);
			}
			return true;
		}
		return false;
	}

	public function setDataArray($datapointArray, $append = false){
		$result = true;
		foreach($datapointArray as $datapoint => $value){
			$result &= $this->setData($datapoint, $value, $append);
		}
		return $result;
	}

	private function getSofortll($value){
		$value = max(
			$this->mySettings->getSetting("minimalstromstaerke"),
			min(
				$value,
				$this->mySettings->getSetting("maximalstromstaerke")
			)
		);
		return $value;
	}

	private function getLademodusNumber($modus){
		$lademodus = array(
			'jetzt' => 0,
			'minundpv' => 1,
			'pvuberschuss' => 2,
			'stop' => 3,
			'standby' => 4
		);
		if(in_array($modus,$lademodus)){
			return $lademodus[$modus];
		} else {
			if(is_numeric($modus) && ($modus >= 0) && $modus < sizeof($lademodus)){
				return $modus;
			}
		}
		// unbekannter Lademodus! 'stop' wird gesetzt
		return 3;
	}

	public function getDatapointTime($datapoint){
		if (file_exists($this->ramdiskPath.'/'.$datapoint)) {
			return date("H:i", $this->getDatapointFiletime($datapoint));
		}
		return null;
	}

	public function getDatapointFiletime($datapoint){
		if (file_exists($this->ramdiskPath.'/'.$datapoint)) {
			return filemtime($this->ramdiskPath.'/'.$datapoint);
		}
		return null;
	}
}
?>