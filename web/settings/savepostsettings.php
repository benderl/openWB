<!DOCTYPE html>
<?php $debug = true; ?>
<html lang="de">
	<head>
	<script>
		function goBack() {
			window.history.go(-1);
		}
	</script>
	</head>
	<body>
		<h1>Einstellungen werden gespeichert...</h1>
		<?php
		// get settings
		include './settingsClass.php';
		$mySettings = new openWBSettings();
		if( $debug === true ){
			?>
			<h2>Alte Einstellungen</h2>
			<pre><?php echo $mySettings->dumpSettings(); ?></pre>
			<h2>Zu speichernde Einstellungen ($_POST)</h2>
			<pre><?php print_r($_POST); ?></pre>
			<?php
			}
		$mySettings->setSettings($_POST);
		$mySettings->saveConfigFile();
		if( $debug === true ){
			?>
			<h2>Aktualisierte Einstellungen</h2>
			<pre><?php echo $mySettings->dumpSettings(); ?></pre>
			<?php
			function getFolders($modulesDir){
				foreach( array_diff(scandir($modulesDir),array('.','..') ) as $subDir ) {
					if ( is_dir($modulesDir.'/'.$subDir) ) {
						$dirList[] = $subDir;
					}
				}
				return $dirList;
			}

			function loadModules($modulesDir){
				$dirList = getFolders($modulesDir);
				$modules = array();
				foreach( $dirList as $subDir ) {
					$moduleClassFile = $modulesDir.'/'.$subDir.'/'.$subDir.'.class.php';
					$className = "openWBModule_".$subDir;
					if( file_exists( $moduleClassFile ) ) {
						require_once $moduleClassFile;
						if( class_exists("openWBModule_".$subDir) ) {
							$modules[$className] = new $className();
						}
					}
				}
				return $modules;
			}

			function printDebugInfo(){
				global $myModules;
				echo "<pre>\n";
				//print_r( $myModules );
				foreach( $myModules as $moduleName => $module ){
					echo $moduleName.": ".$module->getName()." (".$module->getId().")\n";
				}
				echo "</pre>\n";
			}

			$myModules = loadModules($_SERVER['DOCUMENT_ROOT'].'/openWB/modules');
			?>
			<h2>Module Settings</h2>
			<h3>Found Modules:</h3>
			<?php printDebugInfo(); ?>
			<pre>
			<?php
			foreach( $myModules as $module ){
				echo "Saving Module Settings for: " . $module->getName() . "...";
				$result = $module->setSettings( $_POST );
				if( $result === true ){
					echo "<span style=\"color: green;\">ok</span>\n";
				} else {
					echo "<span style=\"color: red;\">error</span>\n";
				}
			}
			?>
			</pre>
			<?php
		} else {
			?>
			<!-- return to previous page -->
			<script>
				window.setTimeout('goBack()',2000);
			</script>
			<?php
		}
		?>
		<p>Fertig! Sie werden in zwei Sekunden weitergeleitet.<br>
		Sollte die Weiterleitung nicht funktionieren, nutzen Sie bitte <a href="javascript:goBack();">diesen Link</a>.</p>
	</body>
</html>
