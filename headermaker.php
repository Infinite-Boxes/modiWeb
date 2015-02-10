<?php
require("inc/bootstrap.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>HeaderMaker</title>
<link rel="stylesheet" type="text/css" href="style/base.css">
<script src="js/menumaker.js"></script>
<style>
#header {
	border-bottom: 1px solid #000;
}
#headerDrag {
	position: absolute;
	width: 100%;
	height: 10px;
}
#headerDrag:hover {
	background: rgba(255,0,0,0.5);
}
</style>
</head>
<body>
<div id="header">
</div>
<div id="headerDrag"></div>
<div id="content">
<p>Content</p>
</div>
<?php
include("footer.php");
?>