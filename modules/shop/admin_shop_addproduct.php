<?php
require("../../inc/bootstrap.php");
$checks["name"] = "shop_err_missname";
$checks["url"] = "shop_err_missurl";
$checks["cat"] = "shop_err_misscat";
$checks["desc_short"] = "shop_err_missdshort";
$checks["desc_long"] = "shop_err_missdlong";
$checks["price"] = "shop_err_missprice";
$ok = true;
foreach($checks as $k => $v) {
	if(!isset($_POST[$k])) {
		$ok = false;
		msg::warning(lang::getText($v));
	} elseif($_POST[$k] === "") {
		$ok = false;
		msg::warning(lang::getText($v));
	}
}
if($ok === true) {
	if(!isset($_POST["img"])) {
		$vars["img"] = "none.png";
	} elseif($_POST["img"] === "") {
		$vars["img"] = "none.png";
	} else {
		$exists = base::urlExists($_POST["img"]);
		if($exists === true) {
			$vars["img"] = $_POST["img"];
		} elseif($exists === "403") {
			$vars["img"] = "none.png";
			msg::notice(lang::getText("shop_err_imgforbiddenhotlink"));
		}  else {
			$vars["img"] = "none.png";
			msg::notice(lang::getText("shop_err_imgexistsnot"));
		}
	}
	if(!isset($_POST["active"])) {
		$vars["active"] = false;
	} else {
		if($_POST["active"] === "on") {
			$vars["active"] = true;
		} else {
			$vars["active"] = true;
		}
	}
	foreach($_POST as $k => $v) {
		if($k === "active") {
			if($v === "on") {
				$vars[$k] = true;
			} else {
				$vars[$k] = false;
			}
		} elseif(substr($k, 0, 4) !== "flag") {
			$vars[$k] = $v;
		}
	}
	$vars["flags"] = "";
	$flagStr = ["S", "L"];
	for($c = 1; $c <= 2; $c++) {
		if(isset($_POST["flag".$c])) {
			if($_POST["flag".$c] === "on") {
				$vars["flags"] .= $flagStr[$c-1];
			}
		}
	}
	$keys = [];
	array_push($keys, 
		["name", "name"],
		["active", "active"],
		["img", "img"],
		["url", "url"],
		["cat", "cat"],
		["desc_short", "desc_short"],
		["desc_long", "desc_long"],
		["price", "price"],
		["flags", "flags"]
		
	);
	$str = "";
	$keys = "";
	foreach($vars as $k => $v) {
		if($str === "") {
			$keys = $k;
			$str = "\"".$v."\"";
		} else {
			$keys .= ", ".$k;
			$str .= ", \"".$v."\"";
		}
	}
	echo($str."<br />".$keys."<br />");
	$check = sql::insert("INSERT INTO ".Config::dbPrefix()."products (".$keys.") VALUES (".$str.")");
	if($check === false) {
		echo("NO");
	} else {
		print_r($check);
	}
} else {
	header("Location: ".PREPAGE);
}
?>