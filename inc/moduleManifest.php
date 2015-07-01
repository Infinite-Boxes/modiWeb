<?php
// Modules
class moduleManifest {
	private static $modules = [];
	private static $moduleVars = [];
	private static $menuPages = [];
	public static function load($module) {
		if(!Config::isLoaded($module)) {
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
								$v[$k2]["file"] = ROOT."modules/".$module."/".$v2["file"];
							}
							array_push(self::$moduleVars[$k], $v);
						} elseif($k == "integrate") {
							foreach($v as $k2 => $v2) {
								$v[$k2]["url"] = ROOT."modules/".$module."/".$v2["url"];
							}
							array_push(self::$moduleVars[$k], $v);
						} else {
							array_push(self::$moduleVars[$k], $v);
						}
					}
					if(isset($vars["menu"])) {
						$menu = $vars["menu"];
						if(isset($menu["name"])) {
							array_push(self::$menuPages, $menu);
							if(isset($menu["link"])) {
								if(isset($menu["protection"])) {
									Config::addToProtectedPages($menu["link"], $menu["protection"]);
								}
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
								if(isset($menu["linkable"])) {
									$linkable = $menu["linkable"];
								} else {
									$linkable = true;
								}
								if(isset($menu["order"])) {
									$order = $menu["order"];
								} else {
									$order = false;
								}
								if(isset($menu["parent"])) {
									array_push($menuPush, ["name" => $menu["name"], "link" => $menu["link"], "file" => $file, "visible" => $vis, "type" => $type, "linkable" => $linkable, "parent" => $menu["parent"], "order" => $order]);
								} else {
									array_push($menuPush, ["name" => $menu["name"], "link" => $menu["link"], "file" => $file, "visible" => $vis, "type" => $type, "linkable" => $linkable, "parent" => "", "order" => $order]);
								}
							}
						} elseif(isset($menu[0]["name"])) {
							foreach($menu as $k => $v) {
								array_push(self::$menuPages, $menu[$k]);
								if(isset($menu[$k]["name"])) {
									if(isset($menu[$k]["link"])) {
										if(isset($menu[$k]["protection"])) {
											Config::addToProtectedPages($menu[$k]["link"], $menu[$k]["protection"]);
										}
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
										if(isset($menu[$k]["linkable"])) {
											$linkable = $menu[$k]["linkable"];
										} else {
											$linkable = true;
										}
										if(isset($menu[$k]["order"])) {
											$order = $menu[$k]["order"];
										} else {
											$order = false;
										}
										if(isset($menu[$k]["parent"])) {
											array_push($menuPush, ["name" => $v["name"], "link" => $v["link"], "file" => $file, "visible" => $vis, "type" => $type, "linkable" => $linkable, "parent" => $v["parent"], "order" => $order]);
										} else {
											array_push($menuPush, ["name" => $v["name"], "link" => $v["link"], "file" => $file, "visible" => $vis, "type" => $type, "linkable" => $linkable, "parent" => "", "order" => $order]);
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
		} else {
			$ret = base::sortBy($ret, "order");
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
		if(isset(self::$moduleVars[$val])) {
			$ret = [];
			foreach(self::$moduleVars[$val] as $v) {
				foreach($v as $v2) {
					array_push($ret, $v2);
				}
			}
			return $ret;
		} else {
			echo($val." is empty!<br>");
			return false;
		}
	}
}