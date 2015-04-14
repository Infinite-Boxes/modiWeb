<h1>ShoppingCart</h1>
<?php
if(count($_SESSION["shoppingCart"]) > 0) {
?>
<a href="modules/shop/delcart.php?type=all"><img src="img/minus_20.png" class="imgbutton" /> Ta bort alla</a>
<?php
}
?>
<table class="bigShoppingCart">
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
echo("<tr><td>&nbsp;</td><td>&nbsp;</td><td><p>".count($_SESSION["shoppingCart"])." produkter</p></td><td><p style=\"font-weight: bold;\">".$tot.lang::getText("currency")."</p></td></tr>");
?>
</table>
