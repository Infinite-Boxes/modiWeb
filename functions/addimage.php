<?php
require("../inc/bootstrap.php");
if(file_exists(ROOT.$_GET["file"])) {
	$url = $_GET["file"];
	if($_GET["name"] != "") {
		if($_GET["alt"] != "") {
			$name = $_GET["name"];
			$alt = addslashes($_GET["alt"]);
			if(sql::insert("INSERT INTO images(name, url, alt) values('".$name."', '".$url."', '".$alt."')")) {
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
	$alt = addslashes($_GET["alt"]);
	if(substr($url, 0, 7) === "http://") {
		if(sql::insert("INSERT INTO images(name, url, alt) values('".$name."', '".$url."', '".$alt."')")) {
			echo("ok");
		} else {
			echo("ERROR_Något gick fel");
		}
	} else {
		echo("ERROR_".ROOT.$_GET["file"]);
	}
}
?>