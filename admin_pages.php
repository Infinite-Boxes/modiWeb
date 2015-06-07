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
				$type = "page";
				if($v["type"] !== null) {
					$type = $v["type"];
				}
				array_push($pages, elements::button("x.png", ["a", "functions/deletepage.php?id=".$v["id"]], "", "", "onclick=\"dialog('Vill du verkligen radera sidan?', this);\"").elements::link($v["name"], "pages?type=".$type."&id=".$v["id"]));
			}
		} else {
			array_push($pages, elements::button("x.png", ["a", "functions/deletepage.php?id=".$pageslist["id"]], "test='test'").elements::link($pageslist["name"], "pages?type=".$v["type"]."&id=".$pageslist["id"]));
		}
	}
	$pagesText = elements::button("new_doc.png", ["a", "admin_createnewpage"], "newDoc", "onmouseover=\"popup('Lägg till ny sida');\"");
	foreach($pages as $k => $v) {
		if($pagesText == "") {
			$pagesText .= $v;
		} else {
			$pagesText .= "<br />".$v;
		}
	}
	echo($pagesText);
}
