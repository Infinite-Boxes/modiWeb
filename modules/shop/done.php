<h1>ShoppingCart</h1>
<?php
if(count($_SESSION["shoppingCart"]) > 0) {
$checks = [];
array_push($checks, ["paymentmethod", lang::getText("shop_missing_paymentmethod")]);
$check = true;
$errorStr = "";
if(count($_POST) > 0) {
	foreach($checks as $v) {
		if($v[1] !== false) {
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
		$_SESSION["shop_information"][$v[0]] = $_POST[$v[0]];
	}
} else {
	$check = true;
	foreach($checks as $v) {
		if($v[1] !== false) {
			if(!isset($_SESSION["shop_information"][$v[0]])) {
				$check = false;
			} elseif($_SESSION["shop_information"][$v[0]] === "") {
				$check = false;
			}
		}
	}
}
if($check === false) {
	echo($errorStr);
	echo("<a href=\"shop_payment\">Tillbaka</a>");
	shop::writeCartTabs("done", false);
} else {
	if(isset($_SESSION["shop_information"]["shippingtype"])) {
		$inputValue = $_SESSION["shop_information"]["shippingtype"];
	} else {
		$inputValue = "false";
	}
	shop::writeCartTabs("done", true);
?>
<p><?php echo(lang::getText("shop_shippinginfo")); ?></p>
<form action="shop_payment" method="POST" id="shippingForm">
<div id="shop_tabWindows">
<?php
$shippingList = sql::get("SELECT * FROM ".Config::dbPrefix()."shipping WHERE activated = 1");
if(!isset($shippingList[0]["adminname"])) {
	$shippingList = [$shippingList];
}
foreach($shippingList as $k => $v) {
	if($out = shop::writeShipping($v["name"])) {
		if($v["name"] === $inputValue) {
			$style1 = " style=\"border-color: #888;\"";
			$style2 = " style=\"max-height: 1000px; padding: 5px;\"";
		} else {
			$style1 = "";
			$style2 = "";
		}
		echo("<div onclick=\"shop_updShipping(this, '".$v["name"]."');\"".$style1."><div class=\"tabHeader\">".$v["adminname"]."<div></div></div><div".$style2.">".$out."</div></div>");
	}
}
echo("</div>");
}
?>
<input type="hidden" name="shippingtype" id="shippingType" value="<?php echo($inputValue); ?>">
<table class="bigShoppingCart">
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="shop_payment">Gå till betalning</a></td></tr>
</table>
</form>
<?php
}