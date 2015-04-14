<?php
elements::write("h1", "Lägg till bild");
echo(elements::link("Tillbaka", "admin_images")."<br />");
$rootPath = 'img/user';
$fileList = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath)
);
$fileText = "<select name=\"url\" id=\"currentUrl\" style=\"margin: 5px;\" onchange=\"addImage_updateChosen(false);\">";
$sw = false;
$registered = sql::get("SELECT * FROM ".Config::dbPrefix()."images");
$regList = [];
if($registered !== false) {
	if(isset($registered["url"])) {
		$temp = $registered;
		unset($registered);
		$registered[0] = $temp;
	}
	foreach($registered as $k => $v) {
		array_push($regList, $v["url"]);
	}
}	
$tc = 0;
foreach($fileList as $k => $v) {
    if(!$fileList->isFile()) continue;
	$url = $v;
	$url = str_replace("\\", "/", $url);
	$v = str_replace($rootPath."\\", "", $v);
	if(array_search($url, $regList) === false) {
		if($sw === false) {
		echo("<div id=\"uploader\" class=\"img\" style=\"float: left; max-width: 200px;\"><img src=\"".$url."\" id=\"currentImage\" onerror=\"addImage_errorUrl();\" /><p id=\"subText\" class=\"subtext\"></p></div>
");
			$sw = true;
		}
		$fileText .= "<option value=\"".$url."\">".$v."</option>";
		$tc++;
	}
}
if($tc == 0) {
	echo("<div id=\"uploader\" class=\"img\" style=\"float: left; max-width: 200px;\"><img src=\"img/tools_emptyimage.png\" id=\"currentImage\" onerror=\"addImage_errorUrl();\"><p id=\"subText\" class=\"subtext\"></p></div>
");
}
$tab = [];
$tab["header"] = ["<p class=\"req\">Uppladdade<p>", "<p>Internetbild</p>", "<p>Ladda upp</p>", "<p class=\"req\">Namn</p>", "<p class=\"req\">Alternativ text</p>"];
array_push($tab, 
	$fileText."</select>",
	"<input type=\"text\" id=\"customUrl\" style=\"width: 300px; margin-right: 10px;\"><input type=\"button\" value=\"Visa miniatyr\" onclick=\"addImage_updateChosen('custom');\">",
	"<form action=\"function/uploadimage.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"uploadImage();\" id=\"uploadForm\">
	<input type=\"file\" name=\"uploadfile\" id=\"uploadFile\">
	<input type=\"submit\" value=\"Ladda upp bild\" name=\"submit\">",
	"<input type=\"text\" id=\"imagename\" />",
	"<input type=\"text\" id=\"imagealt\" onkeyup=\"addImage_updSubtext();\" />
</form>"
);
echo(elements::writeTable($tab, "v"));
echo("<p id=\"uploadWindow\"></p>");
echo(elements::button("tool_save.png", ["js", "addImage_add();"], "saveImage", "onmouseover=\"popup('Spara bild');\""));