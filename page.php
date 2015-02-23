<?php
// Includes and creates the base code
require("inc/bootstrap.php");
require("header.php");
$file = true;
$filter = menu::get("user");
foreach($filter as $k => $v) {
	if($_GET["_page"] == $v["url"]) {
		$file = false;
	}
}
if($file) {
	include($_GET["_page"].".php");
} else {
	page::write($_GET["_page"]);
}
echo("</div>");
require("footer.php");
?>