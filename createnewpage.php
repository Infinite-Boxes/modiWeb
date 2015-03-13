<h1>Skapa sida</h1>
<form action="functions/createpage.php" method="POST">
<?php
$tab["header"] = ["<p>Namn</p>", "<p>Beskrivning</p>", "<p>Adress</p>", ""];
$tab[0] = "<input type=\"text\" name=\"name\">";
$tab[1] = "<input type=\"text\" name=\"desc\">";
$tab[2] = "<input type=\"text\" name=\"url\">";
$tab[3] = "<input type=\"submit\" value=\"Skapa sida\">";
echo(elements::writeTable($tab, "v"));
?>
</form>