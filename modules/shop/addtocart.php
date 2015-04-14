<?php
session_start();
if(!isset($_SESSION["shoppingCart"])) {
	$_SESSION["shoppingCart"] = [];
}
$ret = array_push($_SESSION["shoppingCart"], ["name" => $_GET["name"], "url" => $_GET["url"]]);
if($ret > 0) {
	echo("true");
} else {
	echo("false");
}
?>