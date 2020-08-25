<?php
require_once '../settings/settingsClass.php';

$ajax = new Ajaxloader();

//Class for loading Content
class Ajaxloader{

	//Init
	function __construct(){
		$mySettings = new openWBSettings();

		if($call == "loadfile"){
			header("Content-type: application/json");
			echo json_encode(array("text" => $mySettings->getSetting("debug")));
		}
	}

}
?>
