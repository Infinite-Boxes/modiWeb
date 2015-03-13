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
var pageId = \"".$_GET["id"]."\";
pageeditcontent = \"\";
tools_cid = ".page::editorContentLines(page::getCode($_GET["id"])).";
</script>
<div id=\"pageeditor\">
".page::editorContent(page::getCode($_GET["id"]))."</div>");
}
?>