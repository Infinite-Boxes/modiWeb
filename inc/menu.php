<?php
class menu {
	static private $items;
	static private $links;
	static public function init() {
		$items = scandir(ROOT."modules");
		self::$items[0] = "Hem";
		self::$links[0] = "index";
		if(isset($_SESSION["user"])) {
			self::$items[1] = "Admin";
			self::$links[1] = "admin";
		}
		self::$items[2] = "Test";
		self::$links[2] = "test";
		foreach($items as $k => $v) {
			if(file_exists(ROOT."modules/".$v."/manifest.php")) {
				include(ROOT."modules/".$v."/manifest.php");
				if(isset($menu)) {
					self::$items[$k] = $menu;
					self::$links[$k] = $menuLink;
				}
			}
		}
	}
	static public function write() {
		$conf = Config::getMenu();
		if($conf["orientation"] == "horizontal") {
			echo("<div id=\"menu\"><ul>");
			foreach(self::$items as $k => $v) {
				echo("
<li class=\"td link\"><a href=\"".self::$links[$k]."\">".$v."</a></li>
");
			}
			echo("</ul></div>
");
		}
	}
}
menu::init();