<?php
require("../inc/bootstrap.php");
$varexists = true;
$vars = ["name", "desc", "url"];
foreach($vars as $v) {
	if(!isset($_POST[$v])) {
		$varexists = false;
	} else {
		if($_POST[$v] == "") {
			$varexists = false;
		}
	}
}
if($varexists == true) {
	if($_POST["parent"] !== "null") {
		$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."pages(name, description, url, parent) VALUES('".$_POST["name"]."', '".$_POST["desc"]."', '".$_POST["url"]."', '".$_POST["parent"]."');");
	} else {
		$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."pages(name, description, url) VALUES('".$_POST["name"]."', '".$_POST["desc"]."', '".$_POST["url"]."');");
	}
	if($ok !== false) {
		msg::notice("Sidan skapades");
		header("Location: ../".$_POST["url"]);
	} else {
		msg::warning("Det gick inte att skapa sidan");
		header("Location: ../createnewpage");
	}
}