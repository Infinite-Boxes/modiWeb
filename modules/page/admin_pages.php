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
				$del = "";
				if($v["deletable"] === "1") {
					$del = elements::button("x.png", ["a", "functions/deletepage.php?id=".$v["id"]], "", "", "onclick=\"dialog('Vill du verkligen radera sidan?', this);\"");
				}
				array_push($pages, [
					"del" => $del, 
					"editor" => elements::button("edit.png", ["a", "pages?type=".$type."&id=".$v["id"]], "", "onmouseover=\"popup('".lang::getText("editpage")."');\""), 
					"edit" => "<a href=\"admin_pagedetails?p=".$v["id"]."\">".$v["name"]."</a>"
				]);
			}
		} else {
			array_push($pages, [
				"del" => elements::button("x.png", ["a", "functions/deletepage.php?id=".$pageslist["id"]]), 
				"editor" => elements::button("edit.png", ["a", "pages?type=".$v["type"]."&id=".$pageslist["id"]], "", "onmouseover=\"popup('".lang::getText("editpage")."');\""),
				"edit" => "<a href=\"admin_pagedetails?p=".$pagesList["id"]."\">".$pageslist["name"]."</a>"
			]);
		}
	}
	echo(elements::button("new_doc.png", ["a", "admin_createnewpage"], "newDoc", "onmouseover=\"popup('Lägg till ny sida');\""));
	echo("<table class=\"pagesList\">");
	foreach($pages as $k => $v) {
		echo("<tr><td>".$v["del"]."</td><td>".$v["editor"]."</td><td><p>".$v["edit"]."</p></td></tr>");
	}
	echo("</table>");
}
