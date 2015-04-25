<h1>ShoppingCart</h1>
<?php
$canContinue = true;
if(count($_SESSION["shoppingCart"]) > 0) {
	if(isset($_SESSION["shoppingCart"])) {
		if(count($_SESSION["shoppingCart"]) > 0) {
			$canContinue = true;
		} else {
			$canContinue = false;
		}
	} else {
		$canContinue = false;
	}
	if($canContinue === false) {
		shop::writeCartTabs("cart", false);
	} else {
		shop::writeCartTabs("cart", true);
	}
?>
<a href="modules/shop/delcart.php?type=all"><img src="img/minus_20.png" class="imgbutton" /> Ta bort alla</a>
<?php
?>
<table class="bigShoppingCart" style="width: 100%; max-width: 800px;">
<?php
$tot = 0;
foreach($_SESSION["shoppingCart"] as $v) {
	$o = sql::get("SELECT img,desc_short,price FROM ".Config::dbPrefix()."products WHERE url = '".$v["url"]."'");
	$tot += $o["price"];
	echo("<tr>
	<td><a href=\"modules/shop/delcart.php?url=".$v["url"]."\"><img src=\"img/minus_20.png\" class=\"imgbutton\" /></a></td>
	<td><img src=\"img/products/".$o["img"]."\" style=\"height: 50px;\"></td>
	<td><a href=\"p_".$v["url"]."\">".$v["name"]."</a></td>
	<td><p>".$o["price"].lang::getText("currency")."</p></td>
</tr>");
}
$_SESSION["shop_information"]["totalPrice"] = $tot;
echo("<tr><td>&nbsp;</td><td>&nbsp;</td><td style=\"text-align: right;\"><p>".count($_SESSION["shoppingCart"])." produkter på totalt</p></td><td><p style=\"font-weight: bold;\">".$tot.lang::getText("currency")."</p></td></tr>");
?>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="shop_client">Gå till uppgifter</a></td></tr>
</table>
<?php
} else {
	echo("<p>Det finns inga produkter i kundvagnen</p>");
}