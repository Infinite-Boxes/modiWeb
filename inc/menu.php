<?php
class menu {
	static private $items;
	static public function init() {
		self::$items["base"] = [];
		self::$items["user"] = [];
		self::$items["module"] = [];
		self::add("Hem", "hem", "base");
		if(isset($_SESSION["user"])) {
			self::add("Admin", "admin", "base");
		}
		$items = scandir(ROOT."modules");
		foreach($items as $k => $v) {
			if(file_exists(ROOT."modules/".$v."/manifest.php")) {
				include(ROOT."modules/".$v."/manifest.php");
				if(isset($menu)) {
					self::add($menu, $menuLink, "module");
				}
			}
		}
		$pages = sql::get("SELECT * FROM pages");
		if($pages != false) {
			if(isset($pages["name"])){
				self::add($pages["name"], $pages["url"], "user");
			} else {
				foreach($pages as $k => $v) {
					self::add($v["name"], $v["url"], "user");
				}
			}
		}
	}
	static private function add($name, $url, $type) {
		array_push(self::$items[$type], ["name" => $name, "url" => $url]);
	}
	static public function write() {
		$conf = Config::getMenu();
		if($conf["orientation"] == "horizontal") {
			echo("<div id=\"menu\"><ul>");
			foreach(self::$items as $k => $v) {
				foreach($v as $k2 => $v2) {
					echo("
<li class=\"td link\"><a href=\"".$v2["url"]."\">".$v2["name"]."</a></li>
");
				}
			}
			echo("</ul></div>
");
		}
	}
	static public function get($type = "all") {
		if($type == "all") {
			$ret = [];
			foreach(self::$items as $k => $v) {
				foreach($v as $k2 => $v2) {
					array_push($ret, $v2);
				}
			}
			return $ret;
		} else {
			$ret = [];
			foreach(self::$items[$type] as $k => $v) {
				array_push($ret, $v);
			}
			return $ret;
		}
	}
}
menu::init();