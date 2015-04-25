<h1>ShoppingCart</h1>
<?php
if(count($_SESSION["shoppingCart"]) > 0) {
$checks = [];
array_push($checks, ["shippingtype", lang::getText("missing_postalservice")]);
$check = true;
$errorStr = "";
foreach($checks as $v) {
	if(!isset($_POST[$v[0]])) {
		$check = false;
		if($v[1] !== false) {
			$errorStr .= "<p class=\"warning\">".$v[1]."</p>";
		}
	} elseif($_POST[$v[0]] === "") {
		$check = false;
		if($v[1] !== false) {
			$errorStr .= "<p class=\"warning\">".$v[1]."</p>";
		}
	}
}
if($check === false) {
	$check = true;
	if(isset($_SESSION["shop_information"])) {
		foreach($checks as $v) {
			if(!isset($_SESSION["shop_information"][$v[0]])) {
				$check = false;
			}
		}
	}
} else {
	foreach($checks as $v) {
		$_SESSION["shop_information"][$v[0]] = $_POST[$v[0]];
	}
}
shop::writeCartTabs("payment", true);
if($check === false) {
	echo($errorStr);
}
if($check === false) {
	echo("<a href=\"shop_client\">Tillbaka</a>");
} else {
	if(isset($_SESSION["shop_information"]["paymenttype"])) {
		$inputValue = $_SESSION["shop_information"]["paymenttype"];
	} else {
		$inputValue = "false";
	}
	
?>
<div><div class="tabWindow">
<?php
$tlist = sql::get("SELECT * FROM ".Config::dbPrefix()."paymentmethods WHERE activated = 1");
if(!isset($tlist[0]["adminname"])) {
	$tlist = [$tlist];
}
$list = [];
$methods = shop::klarnaMethods();
$klarnaList = [];
if($methods !== false) {
	foreach($methods as $k2 => $v2) {
		array_push($klarnaList, ["name" => $v2["name"], "value" => $v["name"]."_".$v2["value"], "info" => $v2["info"]]);
	}
}
foreach($tlist as $k => $v) {
	array_push($list, ["name" => $v["adminname"], "value" => $v["name"], "info" => $v["info"]]);
}
foreach($list as $k => $v) {
	if(isset($v["subname"])) {
		$sub = "<p style=\"font-weight: bold;\">".$v["subname"]."</p>";
	} else {
		$sub = "";
	}
	echo("<div>
	<div onclick=\"openTab(this); shop_updPayment(this, '".$v["value"]."');\" class=\"tabHeader\">".$v["name"]."</div>
	<div>".$sub."<p>".$v["info"]."</p></div>
</div>");
}
echo("</div></div>");
}
?>
<form action="shop_done" method="POST">
<input type="hidden" name="paymentmethod" id="paymentType">
</form>
<table class="bigShoppingCart">
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="shop_done">Slutför</a></td></tr>
</table>
<?php
}