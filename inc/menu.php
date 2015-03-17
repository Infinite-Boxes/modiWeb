<?php
class menu {
	static private $items;
	static public function init() {
		self::add("Hem", "hem");
		if(isset($_SESSION["user"])) {
			self::add("Admin", "admin");
			self::add("Sidor", "admin_pages", "admin");
			self::add("Bilder", "admin_images", "admin");
		}
		$items = scandir(ROOT."modules");
		foreach($items as $k => $v) {
			if(file_exists(ROOT."modules/".$v."/manifest.php")) {
				include(ROOT."modules/".$v."/manifest.php");
				if(isset($menu)) {
					self::add($menu, $menuLink);
				}
			}
		}
		$pages = sql::get("SELECT * FROM pages");
		if($pages != false) {
			if(isset($pages["name"])){
				self::add($pages["name"], $pages["url"]);
			} else {
				foreach($pages as $k => $v) {
					self::add($v["name"], $v["url"]);
				}
			}
		}
	}
	static private function add($name, $url, $parent = "main") {
		$toPush = ["name" => $name, "url" => $url];
		if(!isset(self::$items[$parent])) {
			self::$items[$parent] = [];
		}
		array_push(self::$items[$parent], $toPush);
	}
	static private function isLast($url) {
		$ret = false;
		foreach(self::$items as $k => $v) {
			foreach($v as $k2 => $v2) {
				if($v2["url"] == $url) {
					$ret = true;
				}
			}
		}
		return $ret;
	}
	static public function write() {
		$conf = Config::getMenu();
		echo("<script>
");
		foreach(self::$items as $k => $v) {
			echo("menuList['".$k."'] = [");
			$tsw = false;
			foreach($v as $k2 => $v2) {
				if($tsw === false) {
					echo("'".$v2["url"]."'");
					$tsw = true;
				} else {
					echo(", '".$v2["url"]."'");
				}
			}
		echo("];
");
		}
		echo("
menuCurrentPage = '".$_SESSION["page"]."';
</script>
");
		if($conf["orientation"] == "horizontal") {
			$childExists = false;
			if(isset(self::$items[$_SESSION["page"]])) {
				$childExists = true;
			}
			if($childExists == true) {
				echo("<div id=\"menu\">");
			} else {
				echo("<div id=\"menu\">");
			}
			$sw = false;
			foreach(self::$items as $k => $v) {
				if($sw == false) {
					echo("<div class=\"menu\" id=\"main\"><ul>");
				} else {
					$childExists = false;
					foreach($v as $k2 => $v2) {
						if($v2["url"] == $_SESSION["page"]) {
							$childExists = true;
						}
					}
					if(($k == $_SESSION["page"]) || ($childExists == true)) {
						$dis = "";
					} else {
						$dis = " disabledMenu";
					}
					echo("<div class=\"submenu".$dis."\" id=\"sub".$k."\"><ul>");
				}
				foreach($v as $k2 => $v2) {
					if(isset(self::$items[$v2["url"]])) {
						$link = " onmouseover=\"submenu('".$v2["url"]."');\"";
					} else {
						if($sw !== true) {
							$link = " onmouseover=\"submenu('none');\"";
						} else {
							$link = "";
						}
					}
					if($_SESSION["page"] == $v2["url"]) {
						$active = " menuActive";
					} else {
						$active = "";
					}
					echo("<li class=\"td link".$active."\"".$link."><a href=\"".$v2["url"]."\">".$v2["name"]."</a></li>");
				}
				echo("</ul></div>");
				if($sw == false) {
					$sw = true;
				}
			}
			echo("</div>");
		}
	}
	static public function isUser($url) {
		$pages = sql::get("SELECT * FROM pages WHERE url = '".$url."'");
		if($pages === false) {
			return false;
		} else {
			return true;
		}
	}
}
menu::init();