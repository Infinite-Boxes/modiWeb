<?php
require("../inc/bootstrap.php");

$_POST["username"] = str_replace(";", "", $_POST["username"]);
$user = users::get($_POST["username"]);
if($user["base"]["password"] === crypt($_POST["password"], $user["base"]["password"])) {
	$_SESSION["user"] = $user;
} else {
	msg::warning(elements::keyName("loginerror")["content"]);
}
header("Location: ../admin");
?>