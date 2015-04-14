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
foreach($_SESSION["shoppingCart"] as $v) {
	echo("<tr>
	<td><a href=\"modules/shop/delcart.php?url=".$v["url"]."\"><img src=\"img/minus_20.png\" class=\"imgbutton\" /></a></td>
	<td><a href=\"p_".$v["url"]."\">".$v["name"]."</a></td>
	<td><p>".sql::get("SELECT price FROM ".Config::dbPrefix()."products WHERE url = '".$v["url"]."'")["price"]."</p></td>
</tr>");
}
?>
</table>
