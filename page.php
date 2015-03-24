<?php
// Includes and creates the base code
require("inc/bootstrap.php");
require("header.php");
if(moduleManifest::hasMenu($_GET["_page"]) != false) {
	include("modules/".$_GET["_page"]."/".$_GET["_page"].".php");
} elseif(!menu::isUser($_GET["_page"])) {
	include($_GET["_page"].".php");
} else {
	page::write($_GET["_page"]);
}
echo("</div>");
require("footer.php");
$_SESSION["previous_page"] = PAGE;
?>