<?php
require("../inc/bootstrap.php");
$checks = ["name", "alt", "id"];
$errStr = ["Det är ett fel med namnet.", "Det är ett fel med den alternativa texten.", "Något gick fel"];
$error = false;
foreach($checks as $k => $v) {
	if(!isset($_GET[$v])) {
		if($_GET[$v] != "") {
			$error = true;
			echo("ERROR_".$errStr[$v]);
			break;
		}
	}
}
if($error == false) {
	$ret = sql::upd("UPDATE ".Config::dbPrefix()."images SET name = '".$_GET["name"]."', alt = '".addslashes($_GET["alt"])."' WHERE id = ".$_GET["id"]);
	if($ret === true) {
		echo("ok");
	} else {
		echo("ERROR_Något gick fel.<pre>");
		print_r($ret);
		echo("</pre>");
	}
}
?>