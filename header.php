<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo(Config::getConfig("title")); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo(ROOT); ?>style/base.css">
<?php
//echo("<base href=\"".$_SERVER["DOCUMENT_ROOT"].SITEPATH."\" target=\"_blank\">");
if(Config::getCSS("theme") !== false) {
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT."style/".Config::getCSS()["theme"]."\">
");
}
?>
<script src="js/base.js"></script>
</head>
<body>
<p id="popup">Info</p>
<?php
if(isset($_SESSION["user"])) {
	if(PAGE != "pages") {
		$cPage = sql::get("SELECT url,id FROM pages WHERE url = '".PAGE."';");
		if($cPage["url"] == PAGE) {
			echo("<a href=\"pages?id=".$cPage["id"]."\" class=\"admineditable\">Redigera sidan</a>");
		}
	}
}
if(isset($_SESSION["user"])) {
	echo("<div id=\"admineditfull\">
	<div>
		<a href=\"#\" onclick=\"show('admineditfull');show('adminedit');\"><img src=\"img/min.png\" alt=\"Förminska\" /></a>
		<a href=\"#\" onclick=\"show('admineditfull');\"><img src=\"img/close.png\" alt=\"Stäng\" /></a>
	</div>
	<form action=\"modules/elements/updtexts.php\" method=\"POST\">
		<textarea name=\"txt\" id=\"admineditfulltextarea\">
		</textarea>
		<input type=\"hidden\" name=\"recall\" value=\"".PAGE."\" />
		<input type=\"hidden\" name=\"id\" id=\"admineditfullid\" value=\"\" />
		<input type=\"submit\" value=\"Ändra\" />
	</form>
</div>

<div id=\"adminedit\">
	<div>
<a href=\"#\" onclick=\"show('adminedit');\"><img src=\"img/close.png\" alt=\"Stäng\" /></a>
<a href=\"#\" onclick=\"show('adminedit', false);show('admineditfull', true);\"><img src=\"img/full.png\" alt=\"Förstora\" /></a>
<img src=\"img/admineditmovable.png\" id=\"admineditmoveable\" onmousedown=\"startDrag(event, 'adminedit');\" ondragstart=\"event.preventDefault();\" alt=\"Flytta\" />
<form action=\"modules/elements/updtexts.php\" method=\"POST\">
<textarea name=\"txt\" id=\"adminedittextarea\">
</textarea>
<input type=\"hidden\" name=\"recall\" value=\"".PAGE."\" />
<input type=\"hidden\" name=\"id\" id=\"admineditid\" value=\"\" />
<input type=\"submit\" value=\"Ändra\" />
</form>
</div>
</div>");
}
?>
<div id="header">
<div id="headerContent">
<img src="<?php echo(ROOT); ?>img/logo.png" alt="Banner" />
</div>
<?php
menu::write();
?>
</div>
<div id="content">
<noscript>
<p class="warning">Din webbläsare stödjer inte javascript eller så har du avaktiverat det. Utan javascript fungerar inte sidan korrekt.</p>
</noscript>
<?php
$msgs = msg::get();
if((count($msgs["warnings"]) > 0) || (count($msgs["notices"]) > 0)) {
	$showWarnings = true;
} else {
	$showWarnings = false;
}
if($showWarnings == true) {
	echo("<div id=\"msg\">");
	if(count($msgs["warnings"]) > 0) {
		foreach($msgs["warnings"] as $k => $v) {
			echo("<p class=\"warning\">".$v."</p>");
		}
	}
	if(count($msgs["notices"]) > 0) {
		foreach($msgs["notices"] as $k => $v) {
			echo("<p class=\"notice\">".$v."</p>");
		}
	}
	echo("</div>");
}
?>
