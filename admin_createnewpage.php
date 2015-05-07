<h1>Skapa sida</h1>
<form action="functions/createpage.php" method="POST">
<?php
echo(elements::link("Tillbaka", "admin_pages")."<br />");
$tab["header"] = ["<p>Namn</p>", "<p>Beskrivning</p>", "<p>Adress</p>", "<p>Plats</p>", "<p>Sökbar</p>", "<p>Undersida till</p>", ""];
$tab[0] = "<input type=\"text\" name=\"name\">";
$tab[1] = "<input type=\"text\" name=\"desc\">";
$tab[2] = "<input type=\"text\" name=\"url\">";
$tab[3] = "<input type=\"text\" size=1 name=\"order\" onkeyup=\"updOrder();\">";
$tab[4] = "<input type=\"radio\" name=\"searchable\"><input type=\"radio\" name=\"searchable\">";
$tab[5] = "<select name=\"parent\">
<option value=\"null\" default>Ingen</option>";
$pages = sql::get("SELECT name, url FROM ".Config::dbPrefix()."pages WHERE parent IS NULL");
if($pages !== false) {
	if(isset($pages["name"])) {
		$tab[5] .= "<option value=\"".$pages["url"]."\">".$pages["name"]."</option>";
	} else {
		foreach($pages as $k => $v) {
			$tab[5] .= "<option value=\"".$v["url"]."\">".$v["name"]."</option>";
		}
	}
}
$tab[5] .= "</select>";
$tab[6] = "<input type=\"submit\" value=\"Skapa sida\">";
echo(elements::writeTable($tab, "v"));
?>
</form>