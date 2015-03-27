<?php
// Includes and creates the base code
require("inc/bootstrap.php");
require("header.php");
if(!config::isProtectedPage($_GET["_page"])) {
	if(moduleManifest::hasMenu($_GET["_page"]) != false) {
		$pageType = moduleManifest::menuType($_GET["_page"]);
		if($pageType === false) {
			include(moduleManifest::menuModule($_GET["_page"])["file"]);
		} elseif($pageType == "page") {
			page::write(moduleManifest::menuModule($_GET["_page"])["file"]);
		} else {
			include(moduleManifest::menuModule($_GET["_page"])["file"]);
		}
	} elseif(!menu::isUser($_GET["_page"])) {
		if(file_exists($_GET["_page"].".php")) {
			include($_GET["_page"].".php");
		} else {
			echo(lang::getText("err_404"));
		}
	} else {
		page::write($_GET["_page"]);
	}
} else {
	echo("
<h1>Du är inte behörig!</h1>
<a href=\"admin\">Gå tillbaka</a>
");
}
echo("</div>");
require("footer.php");
$_SESSION["previous_page"] = PAGE;
?>