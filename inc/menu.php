<?php
class menu {
	static private $items;
	static private $links;
	static public function init() {
		$items = scandir(ROOT."modules");
		unset($items[0]);
		unset($items[1]);
		self::$items[0] = "Hem";
		self::$links[0] = "index";
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
<a href=\"".self::$links[$k]."\" class=\"td link\"><li>".$v."</li></a>
");
			}
			echo("</ul></div>
");
		}
	}
}
menu::init();