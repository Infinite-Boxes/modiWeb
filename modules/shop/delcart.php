<?php
session_start();
if(isset($_GET["url"])) {
	foreach($_SESSION["shoppingCart"] as $k => $v) {
		if($_SESSION["shoppingCart"][$k]["url"] === $_GET["url"]) {
			unset($_SESSION["shoppingCart"][$k]);
			break;
		}
	}
} elseif(isset($_GET["type"])) {
	$_SESSION["shoppingCart"] = [];
}
header("Location: ../../shop_cart");
?>