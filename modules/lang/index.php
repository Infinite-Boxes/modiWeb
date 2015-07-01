<?php
class lang {
	public static function init() {
		Config::addSnippet("languageButton", "writeLangBut");
	}
	public static function writeLangBut() {
		$out = "<div id=\"langMenu\">
<img src=\"img/lang.png\" onclick=\"openLangMenu();\">
<div id=\"langMenuList\">
";
		$langs = self::getLangs();
		$gets = [];
		foreach($_GET as $k => $v) {
			array_push($gets, $k."=".$v);
		}
		foreach($langs as $v) {
			if(isset($_SESSION["lang"])) {
				if($v["val"] !== $_SESSION["lang"]) {
					
					$out .= "<a href=\"func_setlang?lang=".$v["val"]."&redir=".$_GET["_page"]."&".implode("&", $gets)."\">".$v["name"]."</a>";
				}
			} else {
				$original = "SE";
				//$dbOriginal = sql::get("SELECT default_lang FROM ".Config::dbPrefix()."config_site")["default_lang"]
			}
		}
		$out .= "</div>
</div>";
		if(isset($_GET["_page"])) {
			if($_GET["_page"] === "pages") {
				$out = "<div id=\"langMenu\"><img src=\"img/lang.png\"></div>";
			}
		}
		return $out;
	}
	public static function getText($name) {
		$ret = sql::get("SELECT val FROM ".Config::dbPrefix()."lang WHERE name = '".$name."' AND lang = '".$_SESSION["lang"]."'");
		if($ret !== false) {
			return $ret["val"];
		} else {
			return false;
		}
		
	}
	public static function getLangs() {
		return sql::get("SELECT name,val FROM ".Config::dbPrefix()."languages");
	}
}