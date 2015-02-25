<?php
if(!isset($_SESSION["user"])) {
?>
<h1>Du är inte behörig!</h1>
<a href="admin">Gå tillbaka</a>
<?php
} else {
	echo(elements::write("h1", "Redigerar sida"));
}
?>