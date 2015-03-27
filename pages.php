<?php
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
