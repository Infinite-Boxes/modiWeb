<?php
session_start();
define("SCRIPTTIME", microtime(true));
require("vars.php");
define("SITEPATH", $vars["sitePath"]);
$currentPath = str_replace(substr(strrchr($_SERVER["SCRIPT_NAME"], "/"), 1), "", $_SERVER["SCRIPT_NAME"]);
if($vars["sitePath"] != "/") {
	$currentPath = str_replace($vars["sitePath"], "", strtolower($currentPath));
} else {
	$currentPath = substr($currentPath, 1);
}
$rootPath = "";
for($c = 0; $c < substr_count($currentPath, "/"); $c++) {
	$rootPath .= "../";
}
define("BASEPAGE", "home");
$tempstr = str_replace($vars["sitePath"], "", strtolower($_SERVER["REQUEST_URI"]));
if(strpos($tempstr, "?") !== false) {
	define("PAGE", substr($tempstr, 0, strpos($tempstr, "?")));
	define("PAGEGETS", substr($tempstr, strpos($tempstr, "?")));
} else {
	define("PAGE", $tempstr);
	define("PAGEGETS", "");
}
if(isset($_SESSION["previous_page"])) {
	define("PREPAGE", $_SESSION["previous_page"]);
}
if(isset($_GET["_page"])) {
	$_SESSION["page"] = $_GET["_page"];
}
if($_SERVER["SERVER_NAME"] != "localhost") {
	define("ROOT", $rootPath);
} else {
	define("ROOT", $rootPath);
}
//require(ROOT."inc/errorHandling.php");
require(ROOT."inc/moduleManifest.php");
require(ROOT."inc/config.php");
require(ROOT."inc/menu.php");
