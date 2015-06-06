<?php
require("../inc/bootstrap.php");
$sql = "UPDATE ".Config::dbPrefix()."pages SET content = '".addslashes($_POST["content"])."' WHERE id = ".$_POST["id"].";";
$ok = sql::upd($sql);
if($ok === true) {
	echo("Sparad!");
} else {
	echo("ERROR_fel!<br>");
	echo($sql);
}
?>