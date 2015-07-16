<?php
require("../inc/bootstrap.php");
$varexists = true;
$vars = [["id" => "name", "name" => lang::getText("name")], ["id" => "desc", "name" => lang::getText("description")], ["id" => "url", "name" => lang::getText("url")]];
$missing = [];
if(isset($_GET["type"])) {
	if($_GET["type"] === "mail") {
		$vars = [["id" => "name", "name" => lang::getText("name")], ["id" => "desc", "name" => lang::getText("description")]];
	}
	$type = $_GET["type"];
} else {
	$type = "page";
}
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
	$searchable = 0;
	if(isset($_POST["searchable"])) {
		if($_POST["searchable"] === "on") {
			$searchable = 1;
		} else {
			$searchable = 0;
		}
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
	if(isset($_POST["parent"])) {
		if($_POST["parent"] !== "null") {
			$postParent = true;
		} else {
			$postParent = false;
		}
	} else {
		$postParent = false;
	}
	if($type !== "page") {
		$pageTypeId = ", type";
		$pageTypeVal = ", '".$type."'";
	}
	if($postParent === true) {
		$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."pages(name".$pageTypeId.", description, url, parent, searchable".$ordEnable.") VALUES('".$_POST["name"]."'".$pageTypeVal.", '".$_POST["desc"]."', '".$_POST["url"]."', '".$_POST["parent"]."', ".$searchable.$ordVal.");");
	} else {
		$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."pages(name".$pageTypeId.", description, url, searchable".$ordEnable.") VALUES('".$_POST["name"]."'".$pageTypeVal.", '".$_POST["desc"]."', '".$_POST["url"]."', ".$searchable.$ordVal.");");
	}
	$notice = lang::getText($type."created");
	if($type === "mail") {
		$redir = "../admin_mail_new";
	} else {
		$redir = "../".$_POST["url"];
	}
	if($ok !== false) {
		msg::notice($notice);
		header("Location: ".$redir);
	} else {
		if($type === "mail") {
			msg::warning(lang::getText("error_mailmsgnotcreated"));
			header("Location: ../admin_mail_new_newpage");
		} else {
			msg::warning(lang::getText("error_pagenotcreated"));
			header("Location: ../admin_createnewpage");
		}
	}
} else {
	$ret = lang::getText("error_missingfollowing").strtolower(implode(", ", $missing)).".";
	msg::warning($ret);
	if($type === "mail") {
		header("Location: ../admin_mail_new_newpage");
	} else {
		header("Location: ../admin_createnewpage");
	}
}
