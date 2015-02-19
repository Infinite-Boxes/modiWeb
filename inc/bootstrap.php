<?php
session_start();
$sitePath = "/modiWeb/";
$currentPath = str_replace(substr(strrchr($_SERVER["SCRIPT_NAME"], "/"), 1), "", $_SERVER["SCRIPT_NAME"]);
$currentPath = str_replace($sitePath, "", $currentPath);
$rootPath = "";
for($c = 0; $c < substr_count($currentPath, "/"); $c++) {
	$rootPath .= "../";
}
if($_SERVER["SERVER_NAME"] != "localhost") {
	define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/modiWeb/");
} else {
	define("ROOT", $rootPath);
}
//require(ROOT."inc/errorHandling.php");
require(ROOT."inc/moduleManifest.php");
require(ROOT."inc/config.php");
require(ROOT."inc/menu.php");
