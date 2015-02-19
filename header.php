<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php print_r(sql::get("SELECT val FROM config_site WHERE key = 'title'")); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo(ROOT); ?>style/base.css">
<?php
if(Config::getCSS()["theme"] != "") {
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT."style/".Config::getCSS()["theme"]."\">");
}
?>
</head>
<body>
<div id="header">
<div id="headerContent">
<img src="<?php echo(ROOT); ?>img/logo.png" />
</div>
<?php
menu::write();
?>
</div>
<?php
$msgs = msg::get();
if((count($msgs["warnings"]) > 0) || (count($msgs["notices"]) > 0)) {
	echo("<div id=\"msg\">");
}
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
if((count($msgs["warnings"]) > 0) || (count($msgs["notices"]) > 0)) {
	echo("</div>");
}
?>
