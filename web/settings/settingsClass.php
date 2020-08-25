<?php
class openWBSettings {

	private $configFile = "";
	private $settings = [];
	private $defaultFile = "";
	private $defaultSettings = [];

	function __construct($file = null, $defaults = null) {
		if(is_null($file)){
			$file = $_SERVER['DOCUMENT_ROOT'].'/openWB/openwb.conf';
		}
		if(is_null($defaults)){
			$defaults = $_SERVER['DOCUMENT_ROOT'].'/openWB/web/files/openwbdefaults.conf';
		}
		if ( file_exists($defaults) ) {
			$this->defaultFile = $defaults;
			$this->readConfigFile($defaults, $this->defaultSettings);
		} else {
			die("Standardeinstellungen nicht gefunden: $defaults" );
		}
		if ( file_exists($file) ) {
			$this->configFile = $file;
			$this->readConfigFile($this->configFile, $this->settings);
		} else {
			die("Konfigurationsdatei nicht gefunden: $file" );
			// hier eventuell eine Standardkonfiguration erstellen?
		}
	}

	private function readConfigFile($filename, &$settingsArray , $useQuotes = true) {
		// first read config-lines in array
		$settingsFile = file($filename);

		// convert lines to key/value array for faster manipulation
		foreach($settingsFile as $line) {
			// check for comment-lines in older config files and don't process them
			if ( strlen(trim($line)) > 3 && $line[0] != "#" ) {
				// split line at char '='
				$splitLine = explode('=', $line, 2);
				// trim parts
				$splitLine[0] = trim($splitLine[0]);
				if($useQuotes === true){
					$splitLine[1] = stripcslashes(trim($splitLine[1], "\n\"'"));
					//$splitLine[1] = str_replace("\\\"", "\"", trim($splitLine[1], "\n\"'"));
				} else {
					$splitLine[1] = trim($splitLine[1]);
				}
				// push key/value pair to new array
				$settingsArray[$splitLine[0]] = $splitLine[1];
			}
		}
	}

	public function saveConfigFile($useQuotes = true) {
		// write config to file
		$fp = fopen($this->configFile, "w");
		if ( $fp ) {
			ksort( $this->settings);
			foreach($this->settings as $key => $value) {
				if($useQuotes === true){
					// mask special characters
					$value = "\"".addcslashes( $value, '\\$"')."\"";
					//$value = "\"".str_replace("\"", "\\\"", $value)."\"";
				}
				fwrite($fp, $key."=".$value."\n");
			}
		} else {
			die("Konfigurationsdatei konnte nicht geschrieben werden: $this->configFile");
		}
	}

	public function dumpSettings() {
		return print_r($this->settings, true);
	}

	public function getSetting($getKey) {
		if(array_key_exists($getKey, $this->settings)) {
			return $this->settings[$getKey];
		} else {
			return $this->getDefaultSetting($getKey);
		}
		return null;
	}

	private function getDefaultSetting($getKey) {
		if(array_key_exists($getKey, $this->defaultSettings)) {
			return $this->defaultSettings[$getKey];
		}
		return null;
	}

	public function addSettings($newSettings = []){
		foreach($newSettings as $newKey => $newValue){
			$this->addSetting($newKey, $newValue);
		}
	}

	public function addSetting($addKey, $addValue) {
		if(!array_key_exists($addKey, $this->settings)) {
			$this->settings[$addKey] = $addValue;
		} else {
			$this->setSettings($addKey, $addValue);
		}
	}

	public function setSettings($newSettings = []) {
		foreach($newSettings as $newKey => $newValue){
			$this->setSetting($newKey, $newValue);
		}
	}

	private function setSetting($setKey, $setValue = '') {
		if(array_key_exists($setKey, $this->settings)) {
			$this->settings[$setKey] = $setValue;
		} else {
			echo "Unknown setting: ".$setKey."(".$setValue.")";
		}
	}
}
?>
