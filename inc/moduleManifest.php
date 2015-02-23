<?php
// Modules
class moduleManifest {
	private static $modules = [];
	public static function load($module) {
		array_push(self::$modules, $module);
		require(ROOT."modules/".$module."/index.php");
	}
	public static function get() {
		return self::$modules;
	}
}