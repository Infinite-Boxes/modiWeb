<?php
// Includes and creates the base code
require("inc/bootstrap.php");
require("header.php");
if(!menu::isUser($_GET["_page"])) {
	include($_GET["_page"].".php");
} else {
	page::write($_GET["_page"]);
}
echo("</div>");
require("footer.php");
?>