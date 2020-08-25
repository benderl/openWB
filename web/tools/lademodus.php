<?php
require_once './ramdiskClass.php';

$ajax = new Ajaxloader();

//Class for loading Content
class Ajaxloader{

	//Init
	function __construct(){
		$call = $_POST['call'];
		$myRamdisk = new openWBRamdisk();

		if($call == "loadfile"){
			header("Content-type: application/json");
			echo json_encode(array("text"=> $myRamdisk->getData('lademodus')));
		}
	}

}
?>
