<?php
require("../../inc/bootstrap.php");
if($_POST["id"] != "") {
	if($_POST["txt"] != "") {
		sql::upd("UPDATE ".Config::dbPrefix()."texts SET content='".$_POST["txt"]."' WHERE id=".$_POST["id"]);
	} else {
		sql::upd("DELETE FROM ".Config::dbPrefix()."texts WHERE id=".$_POST["id"]);
	}
} else {
	msg::warning("Fel ID. Antar intrångsförsök.");
}
header("Location: ".ROOT.$_POST["recall"]);
?>
