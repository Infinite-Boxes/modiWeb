<?php
require("../inc/bootstrap.php");
$keys = [];
array_push($keys, "filterCat");
array_push($keys, "filterCatInclude");
array_push($keys, "sortby");
array_push($keys, "sortdirection");
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
	} elseif($posted == "sortby") {
		$_SESSION["shopSortBy"] = $_POST["sortby"];
		if($_POST["sortby"] == "price") {
			$_SESSION["sortDirection"] = "ASC";
		} else {
			$_SESSION["sortDirection"] = "DESC";
		}
		$redir = PREPAGE;
	} elseif($posted == "sortdirection") {
		$_SESSION["sortDirection"] = $_POST["sortdirection"];
		$redir = PREPAGE;
	} else {
		$redir = PREPAGE;
	}
} else {
	$redir = PREPAGE;
}
header("Location: ../".$redir);
?>