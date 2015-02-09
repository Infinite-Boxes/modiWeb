<?php
class Config {
	private static $modules = [];
	private static $db = [];
	private static $css = [];
	static function setup() {
		// Required modules
		self::$db["dsn"] = "mysql:host=localhost;dbname=modiweb";
		self::$db["user"] = "root";
		self::$db["pass"] = "";
		
		self::$css["theme"] = "";
		
		array_push(self::$modules, "sql");
		array_push(self::$modules, "elements");
		
		// Other modules
		self::loadModules();
	}
	private static function loadModules() {
		foreach(self::$modules as $k => $v) {
			ModuleManifest::load($v);
		}
	}
	public static function getDB() {
		return self::$db;
	}
	public static function getCSS() {
		return self::$css;
	}
}