<?php
require("../inc/bootstrap.php");
$sql = "UPDATE ".Config::dbPrefix()."pages SET content = '".addslashes(trim($_POST["content"]))."' WHERE id = ".$_POST["id"].";";
$ok = sql::upd($sql);
if($ok === true) {
	echo("Sparad!");
} else {
	echo($sql);
	echo("ERROR_fel!");
}
?>