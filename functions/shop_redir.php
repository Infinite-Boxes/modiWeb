<?php
require("../inc/bootstrap.php");
$keys = [];
array_push($keys, "filterCat");
array_push($keys, "filterCatInclude");
$posted = false;
foreach($keys as $k => $v) {
	if(isset($_POST[$v])) {
		$posted = $v;
	}
}
if($posted !== false) {
	if($posted == "filterCat") {
		if($_POST["filterCat"] != "__all__") {
			$redir = "c_".$_POST["filterCat"];
		} else {
			$redir = "shop";
		}
	} elseif($posted == "filterCatInclude") {
		$_SESSION["filterCatInclude"] = $_POST["filterCatInclude"];
		$redir = PREPAGE;
	} else {
		$redir = PREPAGE;
	}
} else {
	$redir = PREPAGE;
}
header("Location: ../".$redir);
?>