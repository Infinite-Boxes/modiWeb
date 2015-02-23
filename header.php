<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo(Config::getConfig("title")); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo(ROOT); ?>style/base.css">
<?php
if(Config::getCSS()["theme"] != "") {
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT."style/".Config::getCSS()["theme"]."\">");
}
?>
<script src="js/base.js"></script>
</head>
<body>
<?php
if(isset($_SESSION["user"])) {
	echo("<div id=\"adminedit\">
	<div>
<a href=\"#\" onclick=\"show('adminedit');\"><img src=\"img/close.png\" alt=\"Stäng\" /></a>
<a href=\"#\" onclick=\"full('adminedit');\"><img src=\"img/full.png\" alt=\"Förstora\" /></a>
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
