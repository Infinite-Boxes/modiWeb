<?php
require("../../inc/bootstrap.php");
if($_POST["id"] != "") {
	if($_POST["txt"] != "") {
		echo(sql::upd("UPDATE texts SET text='".$_POST["txt"]."' WHERE id=".$_POST["id"]));
	} else {
		echo(sql::upd("DELETE FROM texts WHERE id=".$_POST["id"]));
	}
} else {
	msg::warning("Fel ID. Antar intrångsförsök.");
}
header("Location: ".ROOT.$_POST["recall"]);
?>
