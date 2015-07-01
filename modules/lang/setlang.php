<?php
$langs = lang::getLangs();
$lang = "";
if(isset($_GET["lang"])) {
	$lang = $_GET["lang"];
}
foreach($langs as $v) {
	if($v["val"] === $_GET["lang"]) {
		$lang = $v["name"];
		$_SESSION["lang"] = $_GET["lang"];
		if(isset($_SESSION["user"])) {
			$_SESSION["user"]["base"]["lang"] = $_GET["lang"];
			sql::upd("UPDATE ".Config::dbPrefix()."users SET lang ='".$_GET["lang"]."' WHERE username = '".$_SESSION["user"]["base"]["username"]."'");
		}
	}
}
msg::notice(lang::getText("setlang").$lang);
$gets = [];
$dels = ["lang", "_func", "redir", "_page"];
foreach($_GET as $k => $v) {
	$go = true;
	foreach($dels as $v2) {
		if($k === $v2) {
			$go = false;
		}
	}
	if($go === true) {
		array_push($gets, $k."=".$v);
	}
}
header("Location: ".$_GET["redir"]."?".implode("&", $gets));
