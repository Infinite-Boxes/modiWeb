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
	echo(elements::keyReplace("a", "Logga ut", "a href=\"functions/logout.php\""));
	// Config-variables
	$configs = sql::get("SELECT * FROM config_site");
	$configOut = [];
	foreach($configs as $k => $v) {
		$configOut[ucfirst($v["admname"])] = "<input type=\"text\" name=\"".$v["id"]."\" value=\"".$v["val"]."\"></p>";
	}
	echo(elements::group(elements::writeTable($configOut), "Sidans konfiguration"));
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
		echo(elements::group($pagesText, "Sidor"));
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
