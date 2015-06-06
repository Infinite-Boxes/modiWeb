<?php
require("inc/bootstrap.php");
if(isset($_GET["_func"])) {
	if($_GET["_func"] !== "") {
		require(moduleManifest::menuModule("func_".$_GET["_func"])["file"]);
	}
}
?>