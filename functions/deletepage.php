<?php
require("../inc/bootstrap.php");
if(isset($_GET["id"])) {
	$ok = sql::del("DELETE FROM ".Config::dbPrefix()."pages WHERE id = ".$_GET["id"]);
	if($ok == true) {
		msg::notice("Sidan har raderats");
		header("Location: ../admin_pages");
	} else {
		msg::warning("Bilden kunde inte raderas");
		header("Location: ../admin_pages");
	}
} else {
	msg::warning("Ett fel har inträffat!");
	header("Location: ../admin_pages");
}
?>