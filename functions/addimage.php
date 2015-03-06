<?php
require("../inc/bootstrap.php");
if(file_exists(ROOT.$_GET["file"])) {
	$url = $_GET["file"];
	if($_GET["name"] != "") {
		if($_GET["alt"] != "") {
			$name = $_GET["name"];
			$alt = $_GET["alt"];
			$sub = $_GET["sub"];
			if(sql::insert("INSERT INTO images(name, url, alt, subtext) values('".$name."', '".$url."', '".$alt."', '".$sub."')")) {
				echo("ok");
			} else {
				echo("ERROR_Något gick fel");
			}
		} else {
			
		}
	} else {
		echo("ERROR_Inget filnamn");
	}
} else {
	$url = $_GET["file"];
	$name = $_GET["name"];
	$alt = $_GET["alt"];
	$sub = $_GET["sub"];
	if(substr($url, 0, 7) === "http://") {
		if(sql::insert("INSERT INTO images(name, url, alt, subtext) values('".$name."', '".$url."', '".$alt."', '".$sub."')")) {
			echo("ok");
		} else {
			echo("ERROR_Något gick fel");
		}
	} else {
		echo("ERROR_".ROOT.$_GET["file"]);
	}
}
?>