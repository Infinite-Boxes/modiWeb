<?php
require("inc/bootstrap.php");
$err = lang::getText("err_".$_GET["e"]);
if(file_exists("page.php")) {
	if($err !== false) {
		msg::warning($err);
		header("Location: home");
	} else {
		msg::warning("ERROR: ".$_GET["e"]);
	}
} else {
	echo("<h1>".$_GET["e"]."</h1>");
	if($err !== false) {
		echo("<p>".$err."</p>");
	}
}