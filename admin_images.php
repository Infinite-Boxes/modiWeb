<?php
elements::write("h1", "Bilder");
if(!isset($_SESSION["user"])) {
	// $_SESSION["rid"] = crypt(time());	Register-check
	header("Location: admin.php");
} else {
	// Config-variables
	$images = sql::get("SELECT * FROM ".Config::dbPrefix()."images");
	if(isset($images["url"])) {
		$temp = $images;
		unset($images);
		$images[0] = $temp;
	}
	echo(elements::button("tool_add_image.png", ["a", "admin_addimage"], "addImage"));
	if($images !== false) {
		$imgText = [];
		foreach($images as $k => $v) {
			array_push($imgText, "<a href=\"admin_editimage?id=".$v["id"]."\"><img src=\"".$v["url"]."\" class=\"thumb50\" /></a>");
		}
		echo(elements::writeTable($imgText, "v"));
	} else {
		echo($imgText["Lägg till"]."<p>Inga bilder i databasen</p>");
	}
}
