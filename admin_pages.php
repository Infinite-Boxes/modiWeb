<?php
elements::write("h1", "Sidor");
if(!isset($_SESSION["user"])) {
	// $_SESSION["rid"] = crypt(time());	Register-check
	header("Location: admin.php");
} else {
	// Pages
	$pageslist = sql::get("SELECT * FROM pages");
	$pages = [];
	if($pageslist != false) {
		if(!isset($pageslist["url"])) {
			foreach($pageslist as $k => $v) {
				array_push($pages, elements::link($v["name"], "pages?id=".$v["id"]));
			}
		} else {
			array_push($pages, elements::link($pageslist["name"], "pages?id=".$pageslist["id"]));
		}
	}
	$pagesText = elements::button("new_doc.png", ["a", "createnewpage"], "newDoc", "");
	foreach($pages as $k => $v) {
		if($pagesText == "") {
			$pagesText .= $v;
		} else {
			$pagesText .= "<br />".$v;
		}
	}
	echo($pagesText);
}
