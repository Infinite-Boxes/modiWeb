<?php
// Modules
class moduleManifest {
	private static $modules = [];
	public static function load($module) {
		require(ROOT."modules/".$module."/index.php");
		$url = ROOT."modules/".$module."/manifest.php";
		$menuPush = [];
		if(file_exists($url)) {
			include($url);
			if(isset($menu)) {
				if(isset($menu["name"])) {
					if(isset($menu["link"])) {
						if(isset($menu["parent"])) {
							array_push($menuPush, ["name" => $menu["name"], "link" => $menu["link"], "parent" => $menu["parent"]]);
						} else {
							array_push($menuPush, ["name" => $menu["name"], "link" => $menu["link"], "parent" => ""]);
						}
					}
				} elseif(isset($menu[0]["name"])) {
					foreach($menu as $k => $v) {
						if(isset($menu[$k]["name"])) {
							if(isset($menu[$k]["link"])) {
								if(isset($menu[$k]["parent"])) {
									array_push($menuPush, ["name" => $v["name"], "link" => $v["link"], "parent" => $v["parent"]]);
								} else {
									array_push($menuPush, ["name" => $v["name"], "link" => $v["link"], "parent" => ""]);
								}
							}
						}
					}
				}
			}
		}
		$modulePush["name"] = $module;
		$modulePush["menu"] = $menuPush;
		array_push(self::$modules, $modulePush);
	}
	public static function get() {
		return self::$modules;
	}
	public static function getMenu() {
		$ret = [];
		foreach(self::$modules as $k => $v) {
			if($v["menu"] !== false) {
				array_push($ret, $v["menu"]);
			}
		}
		if(count($ret) === 0) {
			$ret = false;
		}
		return $ret;
	}
	public static function hasMenu($page = false) {
		$ret = false;
		foreach(self::$modules as $k => $v) {
			if($v["name"] == $page) {
				$ret = true;
			}
		}
		return $ret;
	}
}