<?php
// Modules
class moduleManifest {
	private static $modules = [];
	private static $moduleVars = [];
	public static function load($module) {
		require(ROOT."modules/".$module."/index.php");
		$url = ROOT."modules/".$module."/manifest.php";
		$menuPush = [];
		if(file_exists($url)) {
			include($url);
			if(isset($vars)) {
				foreach($vars as $k => $v) {
					if(!isset(self::$moduleVars[$k])) {
						self::$moduleVars[$k] = [];
					}
					if($k == "css") {
						foreach($v as $k2 => $v2) {
							$v[$k2] = ROOT."modules/".$module."/".$v2;
						}
						array_push(self::$moduleVars[$k], $v);
					} elseif($k == "js") {
						foreach($v as $k2 => $v2) {
							$v[$k2] = ROOT."modules/".$module."/".$v2;
						}
						array_push(self::$moduleVars[$k], $v);
					} else {
						array_push(self::$moduleVars[$k], $v);
					}
				}
				if(isset($vars["menu"])) {
					$menu = $vars["menu"];
					if(isset($menu["name"])) {
						if(isset($menu["link"])) {
							if(isset($menu["visible"])) {
								$vis = $menu["visible"];
							} else {
								$vis = true;
							}
							if(isset($menu["type"])) {
								$type = $menu["type"];
							} else {
								$type = false;
							}
							if(isset($menu["file"])) {
								if($type != "page") {
									$file = "modules/".$module."/".$menu["file"];
								} else {
									$file = $menu["file"];
								}
							} else {
								$file = false;
							}
							if(isset($menu["parent"])) {
								array_push($menuPush, ["name" => $menu["name"], "link" => $menu["link"], "file" => $file, "visible" => $vis, "type" => $type, "parent" => $menu["parent"]]);
							} else {
								array_push($menuPush, ["name" => $menu["name"], "link" => $menu["link"], "file" => $file, "visible" => $vis, "type" => $type, "parent" => ""]);
							}
						}
					} elseif(isset($menu[0]["name"])) {
						foreach($menu as $k => $v) {
							if(isset($menu[$k]["name"])) {
								if(isset($menu[$k]["link"])) {
									if(isset($menu[$k]["visible"])) {
										$vis = $menu[$k]["visible"];
									} else {
										$vis = true;
									}
									if(isset($menu[$k]["type"])) {
										$type = $menu[$k]["type"];
									} else {
										$type = false;
									}
									if(isset($menu[$k]["file"])) {
										if($type != "page") {
											$file = "modules/".$module."/".$menu[$k]["file"];
										} else {
											$file = $menu[$k]["file"];
										}
									} else {
										$file = false;
									}
									if(isset($menu[$k]["parent"])) {
										array_push($menuPush, ["name" => $v["name"], "link" => $v["link"], "file" => $file, "visible" => $vis, "type" => $type, "parent" => $v["parent"]]);
									} else {
										array_push($menuPush, ["name" => $v["name"], "link" => $v["link"], "file" => $file, "visible" => $vis, "type" => $type, "parent" => ""]);
									}
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
	public static function menuModule($page) {
		$ret = false;
		foreach(self::$modules as $k => $v) {
			if(isset($v["menu"])) {
				foreach($v["menu"] as $k2 => $v2) {
					if($v2["link"] == $page) {
						return $v2;
					}
				}
			}
		}
		return $ret;
	}
	public static function menuType($page) {
		if(isset(self::menuModule($page)["type"])) {
			return self::menuModule($page)["type"];
		} else {
			return false;
		}
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
	public static function getCSS() {
		return self::getModVal("css");
	}
	public static function getJS() {
		return self::getModVal("js");
	}
	public static function hasMenu($page = false) {
		$ret = false;
		foreach(self::$modules as $k => $v) {
			if(isset($v["menu"])) {
				foreach($v["menu"] as $k2 => $v2) {
					if($v2["link"] == $page) {
						$ret = true;
					}
				}
			}
		}
		return $ret;
	}
	public static function getModVal($val) {
		if(self::$moduleVars[$val] !== false) {
			return self::$moduleVars[$val][0];
		} else {
			return false;
		}
	}
}