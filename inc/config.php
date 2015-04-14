<?php
class Config {
	private static $modules = [];
	private static $db = [];
	private static $css = [];
	private static $menu = [];
	private static $protectedPages = [];
	private static $userFunctions = [];
	private static $editorKeynames = [];
	private static $editorSnippets = [];
	static public function init() {
		// Required modules
		self::$db["dsn"] = "mysql:host=localhost;dbname=modiweb";
		self::$db["user"] = "root";
		self::$db["pass"] = "";
		/*self::$db["dsn"] = "mysql:host=localhost;dbname=etqwxiwh_db";self::$db["user"] = "etqwxiwh_admin";self::$db["pass"] = "=0211dave";*/
		self::$db["prefix"] = "modiweb";
		
		//self::$css["theme"] = "theme.css";
		
		self::$menu["orientation"] = "horizontal";
		
		// Other modules
		array_push(self::$modules, "base");
		array_push(self::$modules, "msg");
		array_push(self::$modules, "browsercheck");
		array_push(self::$modules, "sql");
		array_push(self::$modules, "log");
		array_push(self::$modules, "statistics");
		array_push(self::$modules, "elements");
		array_push(self::$modules, "page");
		array_push(self::$modules, "users");
		array_push(self::$modules, "lang");
		array_push(self::$modules, "dates");
		
		array_push(self::$modules, "shop");
		
		self::loadModules();
		
		// SET SESSIONS
		if(!isset($_SESSION["lang"])) {
			$_SESSION["lang"] = self::getConfig("default_lang");
		} else {
			$_SESSION["lang"] = self::getConfig("default_lang");
		}
		
		// PROTECTED PAGES
		array_push(self::$protectedPages, "pages");
	}
	private static function loadModules() {
		foreach(self::$modules as $k => $v) {
			ModuleManifest::load($v);
		}
	}
	public static function addUserFunction($name, $function) {
		if(isset(debug_backtrace()[1]["class"])) {
			$caller = debug_backtrace()[1]["class"];
		} else {
			return false;
		}
		self::$userFunctions[$name] = ["caller" => $caller, "function" => $function];
		return true;
	}
	public static function addKeyname($key, $replaceWith) {
		self::$editorKeynames[$key] = $replaceWith;
	}
	public static function getKeynames() {
		$keys = [];
		foreach(self::$editorKeynames as $k => $v) {
			array_push($keys, $k);
		}
		return $keys;
	}
	public static function getKeyReplace($key) {
		return self::$editorKeynames[$key];
	}
	public static function runUserFunction($function, $args = false) {
		if($args === false) {
			return call_user_func([self::$userFunctions[$function]["caller"], self::$userFunctions[$function]["function"]]);
		} else {
			return call_user_func([self::$userFunctions[$function]["caller"], self::$userFunctions[$function]["function"]], $args);
		}
	}
	public static function getUserFunctions() {
		$list = [];
		foreach(self::$userFunctions as $k => $v) {
			array_push($list, $k);
		}
		return $list;
	}
	public static function addSnippet($key, $snippetFunction) {
		if(isset(debug_backtrace()[1]["class"])) {
			$caller = debug_backtrace()[1]["class"];
		} else {
			return false;
		}
		self::$editorSnippets[$key] = ["caller" => $caller, "function" => $snippetFunction];
	}
	public static function getSnippets() {
		$keys = [];
		foreach(self::$editorSnippets as $k => $v) {
			array_push($keys, $k);
		}
		return $keys;
	}
	public static function snippetExist($snippet) {
		return isset(self::$editorSnippets[$snippet]);
	}
	public static function runSnippet($function) {
		return call_user_func([self::$editorSnippets[$function]["caller"], self::$editorSnippets[$function]["function"]]);
	}
	public static function isProtectedPage($page) {
		$ret = false;
		foreach(self::$protectedPages as $v) {
			if($page == $v) {
				$ret = true;
			}
		}
		if(isset($_SESSION["user"])) {
			$ret = false;
		}
		return $ret;
	}
	public static function getDB() {
		return self::$db;
	}
	public static function getCSS($style = NULL) {
		if(isset(self::$css[$style])) {
			return self::$css[$style];
		} else {
			return false;
		}
	}
	public static function getMenu() {
		return self::$menu;
	}
	public static function dbPrefix() {
		return self::$db["prefix"]."_";
	}
	public static function getConfig($key = "all") {
		if($key == "all") {
			return sql::get("SELECT name,val FROM ".Config::dbPrefix()."config_site");
		} else {
			return sql::get("SELECT val FROM ".Config::dbPrefix()."config_site WHERE name = '".$key."'")["val"];
		}
	}
}
Config::init();