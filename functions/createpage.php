<?php
require("../inc/bootstrap.php");
$varexists = true;
$vars = [["id" => "name", "name" => lang::getText("name")], ["id" => "desc", "name" => lang::getText("description")], ["id" => "url", "name" => lang::getText("url")]];
$missing = [];
foreach($vars as $v) {
	if(!isset($_POST[$v["id"]])) {
		$varexists = false;
		array_push($missing, $v["name"]);
	} else {
		if($_POST[$v["id"]] == "") {
			$varexists = false;
			array_push($missing, $v["name"]);
		}
	}
}
if($varexists == true) {
	if($_POST["searchable"] === "on") {
		$searchable = 1;
	} else {
		$searchable = 0;
	}
	if(isset($_POST["order"])) {
		if($_POST["order"] !== "") {
			$ordEnable = ", ord";
			$ordVal = ", ".$_POST["order"];
		} else {
			$ordEnable = "";
			$ordVal = "";
		}
	} else {
		$ordEnable = "";
		$ordVal = "";
	}
	if($_POST["parent"] !== "null") {
		$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."pages(name, description, url, parent, searchable".$ordEnable.") VALUES('".$_POST["name"]."', '".$_POST["desc"]."', '".$_POST["url"]."', '".$_POST["parent"]."', ".$searchable.$ordVal.");");
	} else {
		$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."pages(name, description, url, searchable".$ordEnable.") VALUES('".$_POST["name"]."', '".$_POST["desc"]."', '".$_POST["url"]."', ".$searchable.$ordVal.");");
	}
	if($ok !== false) {
		msg::notice(lang::getText("pagecreated"));
		header("Location: ../".$_POST["url"]);
	} else {
		msg::warning(lang::getText("error_pagenotcreated"));
		header("Location: ../admin_createnewpage");
	}
} else {
	$ret = lang::getText("error_missingfollowing").strtolower(implode(", ", $missing)).".";
	msg::warning($ret);
	header("Location: ../admin_createnewpage");
}