<?php
elements::write("h1", "Admin");
if(!isset($_SESSION["user"])) {
	// $_SESSION["rid"] = crypt(time());	Register-check
?>
<form action="functions/login.php" method="POST">
<?php
$form = [];
$form["Användarnamn"] = "<input type=\"text\" name=\"username\" />";
$form["Lösenord"] = "<input type=\"password\" name=\"password\" />";
$form["null0"] = "<input type=\"submit\" value=\"Logga in\" />";
echo(elements::group(elements::writeTable($form), "Logga in"));
?>
<input type="hidden" name="rid" value="<?php echo($_SESSION["rid"]); ?>" />
</form>
<?php
} else {
	// --- LOGIN STUFF ---
	// Logout-button
	echo(elements::keyReplace("a", "Logga ut", "a href=\"functions/logout.php\"")."<br />
");
	// Config-variables
	$configs = sql::get("SELECT * FROM config_site");
	$configOut = [];
	foreach($configs as $k => $v) {
		$configOut[ucfirst($v["admname"])] = "<input type=\"text\" name=\"".$v["id"]."\" value=\"".$v["val"]."\"></p>";
	}
	echo(elements::group(elements::writeTable($configOut), "Sidans konfiguration", "", "style=\"float: left;\"", "tabcell"));
	// Pages
	$pageslist = sql::get("SELECT * FROM pages");
	$pages = [];
	if(!isset($pageslist["url"])) {
		foreach($pageslist as $k => $v) {
			array_push($pages, elements::link($v["name"], "pages?id=".$v["id"]));
		}
	} else {
		array_push($pages, elements::link($pageslist["name"], "pages?id=".$pageslist["id"]));
	}
	$pagesText = "";
	foreach($pages as $k => $v) {
		if($pagesText == "") {
			$pagesText .= $v;
		} else {
			$pagesText .= "<br />".$v;
		}
	}
	if(count($pages) > 0) {
		echo(elements::group($pagesText, "Sidor", "", "style=\"float: left; min-width: 100px;\"", "tabcell"));
	}
	$images = sql::get("SELECT * FROM images");
	if(isset($images["url"])) {
		$temp = $images;
		unset($images);
		$images[0] = $temp;
	}
	$imgText = [];
	$imgText["Lägg till"] = elements::button("tool_add_image.png", ["a", "admin_addimage"], "addImage", "style=\"float: right;\"");
	if($images !== false) {
		foreach($images as $k => $v) {
			$imgText[$v["name"]] = "<img src=\"".$v["url"]."\" class=\"thumb50\" />";
		}
		echo(elements::group(elements::writeTable($imgText), "Bilder", "", "style=\"float: left;\"", "tabcell"));
	} else {
		$imgText = $imgText["Lägg till"]."<p>Inga bilder i databasen</p>";
		echo(elements::group($imgText, "Bilder", "", "style=\"float: left;\"", "tabcell"));
	}
}

/*
$users = users::get("all");
$userlist = [];
if($users != "Tomt") {
	if(!isset($users["base"])) {
		foreach($users as $k => $v) {
			$user = [
				"Användarnamn" => "<p>".$v["base"]["username"]."</p>",
				"Namn" => "<p>".$v["contactdetails"]["firstname"]." ".$v["contactdetails"]["middlenames"]." ".$v["contactdetails"]["sirname"]."</p>",
				"Personnummer" => "<p>".$v["contactdetails"]["ssn"]."</p>"
			];
			array_push($userlist, $user);
		}
	} else {
		$user = [
			"Användarnamn" => "<p>".$users["base"]["username"]."</p>",
			"Namn" => "<p>".$users["contactdetails"]["firstname"]." ".$users["contactdetails"]["middlenames"]." ".$users["contactdetails"]["sirname"]."</p>",
			"Personnummer" => "<p>".$users["contactdetails"]["ssn"]."</p>"
		];
		array_push($userlist, $user);
	}
	echo(elements::group(elements::writeTable($userlist, "vertical"), "Användare"));
}
*/
