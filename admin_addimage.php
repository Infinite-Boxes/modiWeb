<?php
elements::write("h1", "Lägg till bild");
echo(elements::link("Tillbaka", "admin")."<br />");
$rootPath = 'img/user';
$fileList = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath)
);
$fileText = "<select name=\"url\" id=\"currentUrl\" style=\"margin: 5px;\" onchange=\"addImage_updateChosen(false);\">";
$sw = false;
$registered = sql::get("SELECT * FROM images");
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
		echo("<div id=\"uploader\" style=\"float: left; margin: 5px; border: 1px solid #aaa;\"><img src=\"".$url."\" id=\"currentImage\" style=\"max-width: 200px; border: none;\" onerror=\"addImage_errorUrl();\" /><p id=\"subText\" class=\"subtext\" style=\"display: none;\"></p></div>
");
			$sw = true;
		}
		$fileText .= "<option value=\"".$url."\">".$v."</option>";
		$tc++;
	}
}
if($tc == 0) {
	echo("<div id=\"uploader\" style=\"float: left; margin: 5px; border: 1px solid #aaa;\"><img src=\"img/tools_emptyimage.png\" id=\"currentImage\" style=\"max-width: 200px; border: none;\" onerror=\"addImage_errorUrl();\"><p id=\"subText\" style=\"display: none;\"></p></div>
");
}
$tab = [
	"!REQ!Uppladdade" => $fileText."</select>",
	"Annan" => "<input type=\"text\" id=\"customUrl\" style=\"width: 300px; margin-right: 10px;\"><input type=\"button\" value=\"Visa miniatyr\" onclick=\"addImage_updateChosen('custom');\">",
	"Ladda upp" => "<form action=\"function/uploadimage.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"uploadImage();\" id=\"uploadForm\">
	<input type=\"file\" name=\"uploadfile\" id=\"uploadFile\">
	<input type=\"submit\" value=\"Ladda upp bild\" name=\"submit\">
</form>",
	"!REQ!Namn" => "<input type=\"text\" id=\"imagename\" />",
	"!REQ!Alternativ text" => "<input type=\"text\" id=\"imagealt\" />",
	"Text under bild" => "<input type=\"text\" id=\"imagetextunder\" onkeyup=\"addImage_updSubtext();\" />"
];
echo(elements::writeTable($tab, "horizontal"));
?>
<p id="uploadWindow"></p>
<?php
echo(elements::button("tool_save.png", ["js", "addImage_add();"], "saveImage"));
