<?php
elements::write("h1", "Sidor");
if(!isset($_SESSION["user"])) {
	// $_SESSION["rid"] = crypt(time());	Register-check
	header("Location: admin.php");
} else {
	// Pages
	$pageslist = sql::get("SELECT * FROM ".Config::dbPrefix()."pages");
	$pages = [];
	if($pageslist != false) {
		if(!isset($pageslist["url"])) {
			foreach($pageslist as $k => $v) {
				array_push($pages, elements::button("x.png", ["a", "functions/deletepage.php?id=".$v["id"]]).elements::link($v["name"], "pages?id=".$v["id"]));
			}
		} else {
			array_push($pages, elements::button("x.png", ["a", "functions/deletepage.php?id=".$pageslist["id"]]).elements::link($pageslist["name"], "pages?id=".$pageslist["id"]));
		}
	}
	$pagesText = elements::button("new_doc.png", ["a", "admin_createnewpage"], "newDoc", "");
	foreach($pages as $k => $v) {
		if($pagesText == "") {
			$pagesText .= $v;
		} else {
			$pagesText .= "<br />".$v;
		}
	}
	echo($pagesText);
}
