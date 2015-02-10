<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php print_r(sql::get("SELECT val FROM config_site WHERE key = 'title'")); ?></title>
<link rel="stylesheet" type="text/css" href="style/base.css">
<?php
if(Config::getCSS()["theme"] != "") {
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"style/".Config::getCSS()["theme"]."\">");
}
?>
</head>
<body>
<div id="header">
<img src="img/logo.png" />
</div>