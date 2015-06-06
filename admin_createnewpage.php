<h1>Skapa sida</h1>
<form action="functions/createpage.php" method="POST">
<?php
echo(elements::link("Tillbaka", "admin_pages")."<br />");
$tab["header"] = ["<p>".lang::getText("name")."</p>", "<p>".lang::getText("description")."</p>", "<p>".lang::getText("url")."</p>", "<p>".lang::getText("position")."</p>", "<p>".lang::getText("searchable")."</p>", "<p>".lang::getText("subpagefor")."</p>", ""];
$tab[0] = "<input type=\"text\" id=\"menuItemName\" name=\"name\" onkeyup=\"createMenuItem();\" onchange=\"createMenuItem();\" oninput=\"createMenuItem();\">";
$tab[1] = "<input type=\"text\" name=\"desc\">";
$tab[2] = "<input type=\"text\" name=\"url\">";
$tab[3] = "<input type=\"text\" size=1
 name=\"order\" id=\"menuItemOrder\" onkeyup=\"createMenuItem();\">";
$tab[4] = "<input type=\"checkbox\" name=\"searchable\" class=\"checkbox\" checked>";
$tab[5] = "<select name=\"parent\" id=\"menuItemSub\" onchange=\"createMenuItem();\">
<option value=\"null\" default>Ingen</option>";
$pages = sql::get("SELECT name, url FROM ".Config::dbPrefix()."pages WHERE parent IS NULL AND url IS NOT NULL");
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