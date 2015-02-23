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
elements::writeTable($form);
?>
<input type="hidden" name="rid" value="<?php echo($_SESSION["rid"]); ?>" />
</form>
<?php
} else {
	// LOGIN STUFF
	$configs = sql::get("SELECT * FROM config_site");
	$configOut = [];
	foreach($configs as $k => $v) {
		$configOut[$v["name"]] = "<input type=\"text\" name=\"".$v["id"]."\" value=\"".$v["val"]."\"></p>";
	}
	elements::writeTable($configOut);
	elements::write("a", "Logga ut", "a href=\"functions/logout.php\"");
}
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
	elements::writeTable($userlist, "vertical");
}
?>
