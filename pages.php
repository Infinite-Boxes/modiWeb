<?php
if(!isset($_SESSION["user"])) {
?>
<h1>Du är inte behörig!</h1>
<a href="admin">Gå tillbaka</a>
<?php
} else {
	echo("<script>
var loadedVar = '".$_GET["_page"]."';
</script>
");
	page::menu();
	echo("<script>
pageeditcontent = \"".page::editorContent(page::getCode($_GET["id"]))."
tools_cid = ".page::editorContentLines(page::getCode($_GET["id"])).";
");
for($c = 0; $c < page::editorContentLines(page::getCode($_GET["id"])); $c++) {
	echo("tools_objects.push(\"el\"+".$c.");
");
}
echo("</script>
<div id=\"pageeditor\">
</div>");
}
?>