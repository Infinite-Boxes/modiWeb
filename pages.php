<?php
$pageType = "page";
if(isset($_GET["type"])) {
	if($_GET["type"] === "footer") {
		$pageType = "footer";
	} elseif($_GET["type"] === "header") {
		$pageType = "headerContent";
	}
}
if($pageType === "page") {
	$editContainer = "<div id=\"pageeditor\">
".page::editorContent(page::getCode($_GET["id"]))."</div>";
}
echo("<script>
var loadedVar = '".$_GET["_page"]."';
</script>
");
page::menu();
echo("<script>
var pageId = \"".$_GET["id"]."\";
pageeditcontent = \"\";
tools_cid = ".page::editorContentLines(page::getCode($_GET["id"])).";
");
if($pageType !== "page") {
	echo("pageContainer = '".$pageType."'");
}
echo("</script>
");
if($pageType === "page") {
	echo($editContainer);
}