<?php
elements::write("h1", "!:!hem!:!");
elements::write("p", "!:!hemtext1!:!");
elements::write("p", "!:!hemtext2!:!");
if(isset($_GET["a"])) {
	if($_GET["a"] == "a") {
		$_SESSION["rid"] = crypt(time()); // Register-check
?>
<form action="functions/register.php" method="POST">
<?php
echo("<input type=\"hidden\" name=\"rid\" value=\"".$_SESSION["rid"]."\" />");
?>
Användarnamn: <input type="text" name="username" /><br />
Lösenord: <input type="text" name="password" /><br />
<input type="submit" value="Registrera" />
</form>
<?php
	}
}