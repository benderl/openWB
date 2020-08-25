<?php
require_once dirname( __FILE__, 2 )."/openwbmodule.class.php";

class openWBModule_soc_tesla extends openWBModule {

	/**
	 * Init our variables here.
	 */
	function __construct(){
		$this->friendlyName = "SoC Tesla";
		$this->id = "soc_tesla";
		$this->capabilities = array(
			"Bezug" => false,
			"Ladepunkt Zähler" => false,
			"Ladepunkt SoC" => true,
			"Speicher" => false,
			"PV" => false
		);
		$this->socSettingsDefinition = array(
			array(
				"id" => "teslasocuser",
				"configId" => "socteslausername",
				"label" => "Tesla Benutzername",
				"inputtype" => "email",
				"description" => "Email Adresse des Tesla Logins.",
				"default" => "deine@email.com"
			),
			array(
				"id" => "teslasocpw",
				"configId" => "socteslapw",
				"label" => "Tesla Passwort",
				"inputtype" => "password",
				"description" => "Password des Tesla Logins.",
				"default" => ""
			),
			array(
				"id" => "teslasoccarnumber",
				"configId" => "socteslacarnumber",
				"label" => "Auto im Account",
				"inputtype" => "number",
				"description" => "Im Normalfall hier 0 eintragen. Sind mehrere Teslas im Account für den zweiten Tesla eine 1 eintragen.",
				"minvalue" => 0,
				"default" => 0
			),
			array(
				"id" => "teslasocintervall",
				"configId" => "socteslaintervall",
				"label" => "Abfrageintervall Standby",
				"inputtype" => "number",
				"description" => "Wie oft der Tesla abgefragt wird wenn nicht geladen wird. Angabe in Minuten.",
				"minvalue" => 5,
				"default" => 720
			),
			array(
				"id" => "teslasocintervallladen",
				"configId" => "socteslaintervallladen",
				"label" => "Abfrageintervall Laden",
				"inputtype" => "number",
				"description" => "Wie oft der Tesla abgefragt wird während geladen wird. Angabe in Minuten.",
				"minvalue" => 5,
				"default" => 10
			),
			array(
				"inputtype" => null,
				"description" => "Das ist ein Infotext zum Modul SoC Tesla."
			)
		);
		$this->settingsFile = dirname( __FILE__ ).'/settings.json';
		$this->loadSettings();
	}

}
?>