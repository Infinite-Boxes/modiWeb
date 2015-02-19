<?php
elements::write("h1", "Admin");
$_SESSION["rid"] = crypt(time());
?>
<form action="functions/register.php" method="POST">
<?php
$form = [];
$form["Användarnamn"] = "<input type=\"text\" name=\"username\" />";
$form["Lösenord"] = "<input type=\"password\" name=\"password\" />";
$form["null0"] = "<input type=\"submit\" value=\"Registrera\" />";
elements::writeTable($form);
?>
<input type="hidden" name="rid" value="<?php echo($_SESSION["rid"]); ?>" />
</form>
<?php
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
