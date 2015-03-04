<?php
require("../inc/bootstrap.php");
if(isset($_POST["rid"])) {
	$prid = $_POST["rid"];
} else {
	$prid = false;
}
if(isset($_SESSION["rid"])) {
	$srid = $_SESSION["rid"];
} else {
	$srid = true;
}
if($prid === $srid) {
	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
	$salt = sprintf("$2a$%02d$", 50) . $salt;
	$hash = crypt($_POST["password"], $salt);
	$user = [];
	$user["username"] = $_POST["username"];
	$user["password"] = $hash;
	$user["lang"] = "SE";
	$user["firstname"] = "David";
	$user["middlenames"] = "Elias Christoffer";
	$user["sirname"] = "Andersson";
	$user["ssn"] = "8802113533";
	$user["address"] = "Bryggaregatan 32";
	$user["town"] = "Helsingborg";
	$user["country"] = "Sweden";
	users::add($user);
	msg::notice("Användaren har registrerats");
	header("Location: ".ROOT."hem");
} else {
	trigger_error("Uppgifterna blev inte korrekt mottagna. <a href=\"../admin\">Försök igen</a>.");
}
?>