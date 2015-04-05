<?php
require("../inc/bootstrap.php");
if(isset($_GET["ip"])) {
	$gets = str_replace("\"", "'", $_GET["gets"]);
	$posts = str_replace("\"", "'", $_GET["posts"]);
	$theSql = "INSERT INTO ".Config::dbPrefix()."statistics (ip, script, page, gets, posts) VALUES (\"".$_GET["ip"]."\", \"".$_GET["script"]."\", \"".$_GET["page"]."\", \"".$gets."\", \"".$posts."\");";
	$return = sql::insert($theSql);
	if($return != false) {
		echo("ok");
	} else {
		echo("ERROR");
	}
} else {
		echo("ERROR");
	}
?>