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
	private static $keys = [];
	static public function init() {
		require("sql.php");
		// Required modules
		self::$db["dsn"] = $sqlInformation["dsn"];
		self::$db["user"] = $sqlInformation["user"];
		self::$db["pass"] = $sqlInformation["pass"];
		
		self::$db["prefix"] = "modiweb";
		
		//self::$css["theme"] = "theme.css";
		
		self::$menu["orientation"] = "horizontal";
		
		// Other modules
		array_push(self::$modules, ["base", false]);
		array_push(self::$modules, ["msg", false]);
		array_push(self::$modules, ["browsercheck", false]);
		//array_push(self::$modules, ["sql", false]);
		array_push(self::$modules, ["log", false]);
		array_push(self::$modules, ["statistics", false]);
		array_push(self::$modules, ["elements", false]);
		array_push(self::$modules, ["page", false]);
		array_push(self::$modules, ["users", false]);
		array_push(self::$modules, ["lang", false]);
		array_push(self::$modules, ["dates", false]);
		
		array_push(self::$modules, ["shop", false]);
		
		self::loadModule("sql");
		// SET SESSIONS
		if(isset($_SESSION["user"])) {
			$_SESSION["lang"] = $_SESSION["user"]["base"]["lang"];
		} else {
			if(!isset($_SESSION["lang"])) {
				$_SESSION["lang"] = self::getConfig("default_lang");
			} else {
				$_SESSION["lang"] = self::getConfig("default_lang");
			}
		}
		self::loadModules();
		
		
		// PROTECTED PAGES
		array_push(self::$protectedPages, "pages");
		array_push(self::$protectedPages, "admin_modiweb");
		array_push(self::$protectedPages, "admin_pages");
		array_push(self::$protectedPages, "admin_images");
		
		// KEYS. These CANNOT be altered
		self::$keys["shipping"]["posten"] = "0eb30c21-625c-429b-9f8b-d696327f00d1";
		self::$keys["payment"]["klarna"] = ["eid" => "4123", "secret" => "3h9yNpI9UtTBaah"];
	}
	private static function loadModules() {
		foreach(self::$modules as $k => $v) {
			ModuleManifest::load($v[0]);
			self::$modules[$k][1] = true;
		}
	}
	private static function loadModule($mod) {
		array_push(self::$modules, [$mod, false]);
		foreach(self::$modules as $k => $v) {
			if($v[0] === $mod) {
				ModuleManifest::load($v[0]);
				self::$modules[$k][1] = true;
			}
		}
	}
	public static function isLoaded($mod) {
		foreach(self::$modules as $k => $v) {
			if($v[0] === $mod) {
				return self::$modules[$k][1];
			}
		}
		return false;
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
	public static function addToProtectedPages($page) {
		array_push(self::$protectedPages, $page);
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
	public static function getKey($type, $key) {
		if(isset(self::$keys[$type])) {
			if(isset(self::$keys[$type][$key])) {
				return self::$keys[$type][$key];
			} else {
				return "Key does not exist";
			}
		} else {
			return "Type does not exist";
		}
	}
}
Config::init();