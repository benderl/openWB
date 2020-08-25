<?php
class openWBModule {

	/**
	 * The friendlyName is displayed in the ui.
	 */
	protected $friendlyName = null;

	/**
	 * The unique id for this module.
	 */
	protected $id = null;

	/**
	 * What can this mudule do?
	 */
	protected $capabilities = array(
									"Bezug" => false,
									"Ladepunkt Zähler" => false,
									"Ladepunkt SoC" => false,
									"Speicher" => false,
									"PV" => false
								);

	/**
	 * An array of settings for each capability.
	 * 
	 * Currently each element has to be an array with this elements:
	 * 	array(
	 *		"id" => "<id for this setting in the webpage>",
	 *		"configId" => "<id for this setting in the config file>",
	 *		"label" => "<text for the label>",
	 *		"inputtype" => "<type of field element to use>",
	 *		"description" => "<Short description for the setting>",
	 *		"minvalue" => <for inputtype=number a minimum value can be set>,
	 *		"maxvalue" => <for inputtype=number a maximum value can be set>
	 * 	)
	 * 
	 * For socSettings, the number of the charging point is added to the fields "id" and "configId".
	 * So for charging point 2 the "configId" will be "<id for this setting in the config file>_lp2".
	 * 
	 * The "inputtype" must be one of the supported html input type definitions:
	 * text, number, password, email, tel, url, date, month, week, time
	 * Other inputtypes may be supported in the future.
	 */
	protected $bezugSettingsDefinition = array();
	protected $zaehlerSettingsDefinition = array();
	protected $socSettingsDefinition = array();
	protected $speicherSettingsDefinition = array();
	protected $pvSettingsDefinition = array();

	protected $settingsFile = null;
	protected $settings = array(
								'bezug' => array(),
								'zaehler' => array(),
								'soc' => array(),
								'speicher' => array(),
								'pv' => array()
							);

	/**
	 * Derived classes have to init their variables here.
	 */
	function __construct(){
		// nothing to do here
	}

	/**
	 * Returns our id.
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * Returns our friendly name.
	 */
	public function getName(){
		return $this->friendlyName;
	}

	/**
	 * Returns our capabilities array.
	 */
	public function getCapabilities(){
		return $this->capabilities;
	}

	/**
	 * Returns our settings definition for "Bezug".
	 */
	public function getBezugSettingsDefinition(){
		return $this->bezugSettingsDefinition;
	}

	/**
	 * Returns our settings for "Bezug".
	 */
	public function getBezugSettings(){
		return $this->settings['bezug'];
	}

	/**
	 * Saves our settings for "Bezug".
	 */
	protected function setBezugSettings( $newSettings ){
		$this->settings['bezug'] = array_merge( $this->settings['bezug'], $newSettings );
		return true;
	}

	/**
	 * Returns our settings definition for "Ladepunkt Zähler".
	 */
	public function getLadepunktZaehlerSettingsDefinition(){
		return $this->zaehlerSettingsDefinition;
	}

	/**
	 * Returns our settings for "Ladepunkt Zähler".
	 */
	public function getLadepunktZaehlerSettings(){
		return $this->settings['zaehler'];
	}

	/**
	 * Saves our settings for "Ladepunkt Zähler".
	 */
	protected function setLadepunktZaehlerSettings( $newSettings ){
		$this->settings['zaehler'] = array_merge( $this->settings['zaehler'], $newSettings );
		return true;
	}

	/**
	 * Returns our settings definition for "Ladepunkt SoC".
	 */
	public function getLadepunktSoCSettingsDefinition(){
		return $this->socSettingsDefinition;
	}

	/**
	 * Returns our settings for "Ladepunkt SoC".
	 */
	public function getLadepunktSoCSettings(){
		return $this->settings['soc'];
	}

	/**
	 * Saves our settings for "Ladepunkt SoC".
	 */
	protected function setLadepunktSoCSettings( $newSettings ){
		$this->settings['soc'] = array_merge( $this->settings['soc'], $newSettings );
		return true;
	}

	/**
	 * Returns our settings definition for "Speicher".
	 */
	public function getSpeicherSettingsDefinition(){
		return $this->speicherSettingsDefinition;
	}

	/**
	 * Returns our settings for "Speicher".
	 */
	public function getSpeicherSettings(){
		return $this->settings['speicher'];
	}

	/**
	 * Saves our settings for "Speicher".
	 */
	protected function setSpeicherSettings( $newSettings ){
		$this->settings['speicher'] = array_merge( $this->settings['speicher'], $newSettings );
		return true;
	}

	/**
	 * Returns our settings definition for "PV".
	 */
	public function getPvSettingsDefinition(){
		return $this->pvSettingsDefinition;
	}

	/**
	 * Returns our settings for "PV".
	 */
	public function getPVSettings(){
		return $this->settings['pv'];
	}

	/**
	 * Saves our settings for "PV".
	 */
	protected function setPVSettings( $newSettings ){
		$this->settings['pv'] = array_merge( $this->settings['pv'], $newSettings );
		return true;
	}

	/**
	 * Validates all settings and returns the modified array.
	 */
	protected function validateSettings( $newSettings ){
		return $newSettings;
	}

	/**
	 * Strip submitted settings array down to our defined settings.
	 */
	protected function filterMySettings( $newSettings ){
		$filteredSettings = array(
									'bezug' => array(),
									'zaehler' => array(),
									'soc' => array(),
									'speicher' => array(),
									'pv' => array()
								);
		// soc
		for( $lp = 1; $lp < 9; $lp++ ){
			foreach( $this->socSettingsDefinition as $mySocSetting ){
				if( array_key_exists( $mySocSetting['id'].'_lp'.$lp, $newSettings ) ){
					$filteredSettings['soc']['lp'.$lp][$mySocSetting['id']] = $newSettings[$mySocSetting['id'].'_lp'.$lp];
				}
			}
		}
		return $filteredSettings;
	}

	/**
	 * Saves all settings for this module.
	 * Returns false on error.
	 */
	public function setSettings( $newSettings ){
		$this->console_log( $this->settings );
		$result = true;
		// strip array down to our defined settings
		$newSettings = $this->filterMySettings( $newSettings );
		// validate the new settings
		$newSettings = $this->validateSettings( $newSettings );
		// $result = ( $result && $this->setSpeicherSettings( $newSettings ) );
		// $result = ( $result && $this->setBezugSettings( $newSettings ) );
		// $result = ( $result && $this->setPVSettings( $newSettings ) );
		$result = ( $result && $this->setLadepunktSoCSettings( $newSettings['soc'] ) );
		$this->console_log( array( "setLadepunktSoCSettings" => $result ) );
		// $result = ( $result && $this->setLadepunktZaehlerSettings( $newSettings ) );
		$result = ( $result && $this->saveSettings() );
		$this->console_log( array( "saveSettings" => $result ) );
		$this->console_log( array( 'setting' => $this->settings, 'new' => $newSettings ) );
		return $result;
	}

	/**
	 * Returns our default settings as array.
	 */
	protected function getDefaultSettings(){
		$defaults = array(
						'bezug' => array(),
						'zaehler' => array(),
						'soc' => array(),
						'speicher' => array(),
						'pv' => array()
					);

		// Bezug-Modul
		foreach( $this->bezugSettingsDefinition as $settingDefinition ){
			if( array_key_exists( 'id', $settingDefinition ) ){
				$defaults['bezug'][$settingDefinition['id']] = $settingDefinition['default'];
			}
		}
		// Ladepunkte
		for( $lp = 1; $lp < 9; $lp++ ){
			// Zähler-Modul
			foreach( $this->zaehlerSettingsDefinition as $settingDefinition ){
				if( array_key_exists( 'id', $settingDefinition ) ){
					$defaults['zaehler']['lp'.$lp][$settingDefinition['id']] = $settingDefinition['default'];
				}
			}
			// SoC-Modul
			foreach( $this->socSettingsDefinition as $settingDefinition ){
				if( array_key_exists( 'id', $settingDefinition ) ){
					$defaults['soc']['lp'.$lp][$settingDefinition['id']] = $settingDefinition['default'];
				}
			}
		}
		// Speicher-Modul
		foreach( $this->speicherSettingsDefinition as $settingDefinition ){
			if( array_key_exists( 'id', $settingDefinition ) ){
				$defaults['speicher'][$settingDefinition['id']] = $settingDefinition['default'];
			}
		}
		// PV-Modul
		foreach( $this->pvSettingsDefinition as $settingDefinition ){
			if( array_key_exists( 'id', $settingDefinition ) ){
				$defaults['pv'][$settingDefinition['id']] = $settingDefinition['default'];
			}
		}
		return $defaults;
	}

	/**
	 * Loads our settings, if they already exist.
	 * If not, set our defaults.
	 */
	protected function loadSettings(){
		$this->settings = $this->getDefaultSettings();
		if( file_exists( $this->settingsFile ) && filesize( $this->settingsFile ) > 0 ){
			$fp = fopen( $this->settingsFile, 'r' );
			$this->settings = array_merge( $this->settings, json_decode( fread( $fp, filesize( $this->settingsFile ) ), true ) );
			fclose( $fp );
		}
	}

	/**
	 * Saves our settings to our file.
	 */
	protected function saveSettings(){
		$fp = fopen( $this->settingsFile, 'w');
		if( $fp ){
			fwrite($fp, json_encode( $this->settings, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK ));
			fclose($fp);
			return true;
		}
		return false;
	}

	protected function console_log( $data ){
		echo '<script>';
		echo 'console.log('. json_encode( $data, JSON_NUMERIC_CHECK ) .')';
		echo '</script>';
	}

}
?>