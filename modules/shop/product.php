<?php
$obj = shop::getProduct($_GET["product"]);
echo("<pre>");
print_r($obj);
echo("</pre>");
?>