<?php
elements::write("h1", "Admin");
if(!isset($_SESSION["user"])) {
	// $_SESSION["rid"] = crypt(time());	Register-check
?>
<form action="functions/login.php" method="POST">
<?php
$form = [];
$form["header"] = ["Användarnamn", "Lösenord", ""];
$form[0] = "<input type=\"text\" name=\"username\" />";
$form[1] = "<input type=\"password\" name=\"password\" />";
$form[2] = "<input type=\"submit\" value=\"Logga in\" />";
echo(elements::group(elements::writeTable($form), false, "Logga in"));
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
	echo(elements::group(elements::writeTable($configOut), false, "Sidans konfiguration", "", "style=\"float: left; width: 300px;\"", "tabcell"));
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
	echo(elements::group(elements::writeTable($userlist, "vertical"), false, "Användare"));
}
*/
