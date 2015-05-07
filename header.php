<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo(Config::getConfig("title")); ?></title>
<?php
$config = Config::getConfig("all");
$favIcon = "";
$favIconType = "";
foreach($config as $v) {
	if($v["name"] === "favicon") {
		$favIcon = $v["val"];
	}
}
$favType = substr($favIcon, strripos($favIcon, ".")+1);
if($favType === "png") {
	$favIconType = "image/png";
} elseif($favType === "gif") {
	$favIconType = "image/gif";
} elseif($favType === "ico") {
	$favIconType = "image/vnd.microsoft.icon";
}
?>
<link rel="icon" type="<?php echo($favIconType); ?>" href="<?php echo($favIcon); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo(ROOT); ?>style/base.css">
<?php
//echo("<base href=\"".$_SERVER["DOCUMENT_ROOT"].SITEPATH."\" target=\"_blank\">");
if(Config::getCSS("theme") !== false) {
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT."style/".Config::getCSS()["theme"]."\">
");
}
foreach(moduleManifest::getCSS() as $k => $v) {
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"".$v."\">
");
}
?>
<script src="js/base.js"></script>
<?php
if(!config::isProtectedPage($_GET["_page"])) {
	if(file_exists("js/".$_GET["_page"].".js")) {
		echo("<script src=\"js/".$_GET["_page"].".js\"></script>
	");
	}
}
foreach(moduleManifest::getJS() as $k => $v) {
	echo("<script src=\"".$v."\"></script>
");
}
?>
</head>
<body>
<div style="position: absolute; top: 0px; right: 0px;">
<?php
$oList = moduleManifest::getModVal("integrate");
$list = [];
if($_GET["_page"] !== "pages") {
	foreach($oList as $k => $v) {
		if(!isset($list[$v["prio"]])) {
			$list[$v["prio"]] = [];
		}
		$list[$v["prio"]][] = $v;
	}
	krsort($list);
	$objects = [];
	foreach($list as $k => $v) {
		foreach($list[$k] as $k2 => $v2) {
			array_push($objects, $v2);
		}
	}
	foreach($objects as $k => $v) {
		if($v["position"] === "topright") {
			if(isset($v["pages"])) {
				$found = false;
				foreach($v["pages"] as $k2 => $v2) {
					if(($v2 === $_GET["_page"]) || ($v2 === "all")) {
						$found = true;
					}
				}
			} else {
				$found = true;
			}
			if(isset($v["notPages"])) {
				foreach($v["notPages"] as $k2 => $v2) {
					if($v2 === $_GET["_page"]) {
						$found = false;
					}
				}
			}
			if($found === true) {
				echo("<div style=\"float: right;\">");
				include($v["url"]);
				echo("</div>");
			}
		}
	}
}
?>
</div>
<div id="grey" class="off" style="display: none;"></div>
<?php
echo("<script>
var statVar = \"".statistics::rec()."\";
</script>");
?>
<p id="popup" onmouseover="hidePopup();">Info</p>
<?php
if(isset($_SESSION["user"])) {
	if(PAGE != "pages") {
		$editable = page::editable($_GET["_page"]);
		if($editable !== false) {
			echo("<a href=\"pages?id=".$editable."\" class=\"admineditable\">Redigera sidan</a>");
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
<img src=\"img/admineditmovable.png\" class=\"imgbutton\" id=\"admineditmoveable\" onmousedown=\"startDrag(event, 'adminedit');\" ondragstart=\"event.preventDefault();\" alt=\"Flytta\" />
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
echo("
<div id=\"header\">
<div id=\"headerContent\">
");
?>
<img src="<?php echo(ROOT); ?>img/logo.png" alt="Banner" />
</div>
<?php
menu::write();
?>
</div>

<?php
$msgs = msg::get();
if((count($msgs["warnings"]) > 0) || (count($msgs["notices"]) > 0)) {
	$showWarnings = true;
} else {
	$showWarnings = false;
}
if($showWarnings == true) {
	echo("<div id=\"msg\"><div class=\"window\" onmouseover=\"fadeNotice();\">");
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
	echo("</div></div>");
}
?>

<div id="dialog">
<div class="window">
<h3>Vill du vinna?</h3>
<p onclick="dialogFinish(true);"><?php echo(lang::getText("yes")); ?></p><p onclick="dialogFinish(false);"><?php echo(lang::getText("no")); ?></p>
</div>
</div>

<div id="content">
<noscript>
<p style="background: #fff; color: #f00; border: 1px solid #f00; border-radius: 10px; padding: 10px; margin: 0px;">Din webbläsare stödjer inte javascript eller så har du avaktiverat det. Utan javascript fungerar inte sidan korrekt.<?php
if(PAGE == "pages") {
	echo("<br />Just denna sidan kan inte användas alls utan Javascript. Aktivera det för att kunna redigera sidor.");
}
?></p>
</noscript>
