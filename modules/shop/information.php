<h1>ShoppingCart</h1>
<?php
if(count($_SESSION["shoppingCart"]) > 0) {
	shop::writeCartTabs("information", true);
?>
<form action="shop_shipping" method="POST" id="informationForm">
<?php
$str[0] = "name";
$str[1] = "address";
$str[2] = "postalNumber";
$str[3] = "postalCity";
$str[4] = "email";
$str[5] = "phone";
for($c = 0; $c < count($str); $c++) {
	if(isset($_SESSION["shop_information"][$str[$c]])) {
		$formValue[$c] = " value=\"".$_SESSION["shop_information"][$str[$c]]."\"";
	} else {
		$formValue[$c] = "";
	}
}
if(isset($_SESSION["user"])) {
	$details = $_SESSION["user"]["contactdetails"];
	$list = [
		["firstname", "middlenames", "sirname"],
		["address"],
		["postalcode"],
		["town"],
		["mail"],
		["phonenumber"]
	];
	foreach($list as $k => $v) {
		foreach($v as $k2 => $v2) {
			if(isset($details[$v2])) {
				if($details[$v2] !== "") {
					if(count($v) > 1) {
						$v[$k2] = $details[$v2];
					}
					$formV[$k] = implode(" ", $v);
				} else {
					$formV[$k] = $details[$v];
				}
			}
		}
	}
	/*
	if($ok === true) {
		$formV[0] = $details["firstname"]." ".$details["middlenames"]." ".$details["sirname"];
		$formV[1] = $details["address"];
		$formV[2] = $details["postalcode"];
		$formV[3] = $details["town"];
		$formV[4] = $details["mail"];
		$formV[5] = $details["phonenumber"];
	}*/
	if(!isset($_SESSION["shop_information"])) {
		foreach($formV as $k => $v) {
			$formValue[$k] = " value=\"".$formV[$k]."\"";
		}
	}
}
if(isset($_SESSION["user"])) {
	echo("<script>
function autoFill() {
	var formVals = [];
");
	foreach($formV as $k => $v) {
		echo("	formVals[".$k."] = '".$v."';
");
	}
	echo("	for(var c = 0; c < 6; c++) {
		obj('val'+c).value = formVals[c];
	}
	popup('".lang::getText("updated_form")."');
}
</script>
<div class=\"button\" onclick=\"autoFill();\"><p>Fyll i med mina uppgifter</p></div>");
}
?>
<table>
<tr><th><p class="req"><?php echo(lang::getText("name")); ?></p></th><td><input type="text" name="name" id="val0"<?php echo($formValue[0]); ?> size=24></td></tr>
<tr><th><p class="req"><?php echo(lang::getText("address")); ?></p></th><td><input type="text" name="address" id="val1"<?php echo($formValue[1]); ?> size=24> <p class="info"><?php echo(lang::getText("postalnumber_notice")); ?></p></td></tr>
<tr><th><p class="req"><?php echo(lang::getText("postalnumber")); ?></p></th><td><input type="text" name="postalNumber" id="val2"<?php echo($formValue[2]); ?> size=24></td></tr>
<tr><th><p class="req"><?php echo(lang::getText("postalcity")); ?></p></th><td><input type="text" name="postalCity" id="val3"<?php echo($formValue[3]); ?> size=24></td></tr>
<tr><th><p><?php echo(lang::getText("email")); ?></p></th><td><input type="text" name="email" id="val4"<?php echo($formValue[4]); ?> size=24></td></tr>
<tr><th><p><?php echo(lang::getText("phonenumber")); ?></p></th><td><input type="text" name="phone" id="val5"<?php echo($formValue[5]); ?> size=24> <p class="info"><?php echo(lang::getText("shop_smsnotice")); ?></p></td></tr>
</table>
<table class="bigShoppingCart">
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="#" onclick="obj('informationForm').submit();">Gå till frakt</a></td></tr>
</table>
</form>
<?php
}