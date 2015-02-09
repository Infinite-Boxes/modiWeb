<?php
// Modules
class moduleManifest {
	private static $modules = [];
	public static function load($module) {
		array_push(self::$modules, $module);
		require("modules/".$module."/index.php");
	}
}