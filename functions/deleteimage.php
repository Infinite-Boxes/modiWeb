<?php
require("../inc/bootstrap.php");
if(isset($_GET["id"])) {
	$ok = sql::del("DELETE FROM ".Config::dbPrefix()."images WHERE id = ".$_GET["id"]);
	if($ok == true) {
		msg::notice("Bilden har raderats");
		header("Location: ../admin_images");
	} else {
		msg::warning("Bilden kunde inte raderas");
		header("Location: ../admin_editimage?id=".$_GET["id"]);
	}
} else {
	msg::warning("Ett fel har inträffat!");
	header("Location: ../admin_images");
}
?>