<?php
require("inc/bootstrap.php");
echo("<h1>".$_GET["e"]."</h1>");
$err = lang::getText("err_".$_GET["e"]);
if($err !== false) {
	echo("<p>".$err."</p>");
}