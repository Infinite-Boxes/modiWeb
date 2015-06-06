<?php
elements::write("h1", "Redigera bild");
$img = sql::get("SELECT * FROM ".Config::dbPrefix()."images WHERE id = '".$_GET["id"]."';");
if($img !== false) {
	echo(elements::link("Tillbaka", "admin_images")."<br />");
} else {
	msg::warning("Ett fel har inträffat. Försök igen senare.");
	header("Location: admin");
}
echo("<div  class=\"img\" style=\"float: left; max-width: 200px;\"><img src=\"".$img["url"]."\" id=\"currentImage\" onerror=\"addImage_errorUrl();\"><p id=\"subText\" class=\"subtext\">".$img["alt"]."</p></div>
");
$tab = [];
$tab["header"] = ["<p class=\"req\">Namn</p>", "<p class=\"req\">Alternativ text</p>", "<p>Radera</p>"];
array_push($tab, 
	"<input type=\"text\" id=\"imagename\" value=\"".$img["name"]."\" />",
	"<input type=\"text\" id=\"imagealt\"  value=\"".$img["alt"]."\"onkeyup=\"addImage_updSubtext();\" />",
	"<a href=\"functions/deleteimage.php?id=".$_GET["id"]."\" onclick=\"dialog('Vill du verkligen radera denna bilden?', this);\">Radera</a>"
);
echo(elements::writeTable($tab, "v"));
echo("<p id=\"uploadWindow\"></p>");
echo(elements::button("tool_ok.png", ["js", "editImage_save(".$_GET["id"].");"], "saveImage", "onmouseover=\"popup('Spara bild');\""));