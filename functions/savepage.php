<?php
require("../inc/bootstrap.php");
$sql = "UPDATE pages SET content = '".$_GET["content"]."' WHERE id = ".$_GET["id"].";";
$ok = sql::upd($sql);
if($ok != false) {
	print_r($ok);
} else {
	echo("OK");
}
?>