<?php
class menu {
	static private $items;
	static public function init() {
		// STANDARD
		//self::add("Hem", "hem");
		if(isset($_SESSION["user"])) {
			self::add("Admin", "admin");
			self::add("ModiWeb", "admin_modiweb", "admin");
			self::add("Sidor", "admin_pages", "admin");
			self::add("Bilder", "admin_images", "admin");
		}
		// PAGES
		$pages = sql::get("SELECT * FROM ".Config::dbPrefix()."pages WHERE url IS NOT NULL AND inmenu = 1 ORDER BY -ord DESC");
		if($pages != false) {
			if(isset($pages["name"])){
				if($pages["parent"] == null) {
					self::add($pages["name"], $pages["url"]);
				} else {
					self::add($pages["name"], $pages["url"], $pages["parent"]);
				}
			} else {
				foreach($pages as $k => $v) {
					if($v["parent"] == null) {
						self::add($v["name"], $v["url"]);
					} else {
						self::add($v["name"], $v["url"], $v["parent"]);
					}
				}
			}
		}
		// MODULES
		foreach(moduleManifest::getMenu() as $k => $v) {
			if(isset($v["name"])) {
				if($v["visible"] !== false) {
					self::add($v["name"], $v["link"], $v["parent"]);
				}
			} elseif(isset($v[0]["name"])) {
				foreach($v as $key => $val) {
					if($val["visible"] !== false) {
						self::add($v[$key]["name"], $v[$key]["link"], $v[$key]["parent"]);
					}
				}
			}
		}
	}
	static public function add($name, $url, $parent = "main") {
		$toPush = ["name" => $name, "url" => $url];
		if($parent == "") {
			$parent = "main";
		}
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
		self::init();
		$conf = Config::getMenu();
		echo("<script>
");
		$topPage = "none";
		foreach(self::$items as $k => $v) {
			echo("menuList['".$k."'] = [");
			$tsw = false;
			foreach($v as $k2 => $v2) {
				if($v2["url"] === $_SESSION["page"]) {
					if($k === "main") {
						$found = false;
						foreach(self::$items as $k3 => $v3) {
							if($k3 === $v2["url"]) {
								$found = true;
							}
						}
						if($found === true) {
							$topPage = $v2["url"];
						}
					} else {
						$topPage = $k;
					}
				}
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
menuCurrentPage = '".$topPage."';
</script>
");
		if($conf["orientation"] == "horizontal") {
			$childExists = false;
			if(isset(self::$items[$_SESSION["page"]])) {
				$childExists = true;
			}
			if($childExists == true) {
				echo("<div id=\"menu\" class=\"menu\">");
			} else {
				echo("<div id=\"menu\" class=\"menu\">");
			}
			$sw = false;
			foreach(self::$items as $k => $v) {
				if($sw == false) {
					echo("<div id=\"main\"><ul>");
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
					$active = "";
					if(isset($_GET["cat"])) {
						if($v2["url"] === "c_".$_GET["cat"]) {
							$active = " menuActive";
						}
					}
					if(($_SESSION["page"] === $v2["url"]) || ($v2["url"] === $topPage)) {
						$active = " menuActive";
					}
					$tabDisable = " tabindex=\"-1\"";
					echo("<li class=\"td link".$active."\"".$link."><a".$tabDisable." href=\"".urlencode($v2["url"])."\">".$v2["name"]."</a></li>");
				}
				echo("</ul></div>");
				if($sw == false) {
					echo("<div class=\"submenus\" onmouseover=\"resetResetTimer()\">");
					$sw = true;
				}
			}
			echo("</div></div>");
		}
	}
	static public function isUser($url) {
		$pages = sql::get("SELECT * FROM ".Config::dbPrefix()."pages WHERE url = '".$url."'");
		if($pages === false) {
			return false;
		} else {
			return true;
		}
	}
}