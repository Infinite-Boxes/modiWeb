<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Shop", "link" => "shop", "file" => "shop.php"]);
array_push($vars["menu"], ["name" => "Product", "link" => "product", "file" => "productPage", "visible" => false, "type" => "page"]);
array_push($vars["menu"], ["name" => "ShoppingCart", "link" => "shop_cart", "file" => "cart.php", "visible" => false, "type" => "file"]);
array_push($vars["menu"], ["name" => "ShoppingCart_clientInformation", "link" => "shop_client", "file" => "information.php", "visible" => false, "type" => "file"]);
array_push($vars["menu"], ["name" => "ShoppingCart_shipping", "link" => "shop_shipping", "file" => "shipping.php", "visible" => false, "type" => "file"]);
array_push($vars["menu"], ["name" => "ShoppingCart_payment", "link" => "shop_payment", "file" => "payment.php", "visible" => false, "type" => "file"]);
array_push($vars["menu"], ["name" => "ShoppingCart_done", "link" => "shop_done", "file" => "done.php", "visible" => false, "type" => "file"]);

array_push($vars["menu"], ["name" => "Shop", "link" => "admin_shop", "file" => "admin_shop.php", "visible" => true, "type" => "file", "parent" => "admin", "protected" => true]);


$vars["integrate"] = [];
array_push($vars["integrate"], ["position" => "topright", "pages" => ["all"], "notPages" => ["shop_cart", "shop_client", "shop_shipping", "shop_payment", "shop_done"], "url" => "integratecart.php", "prio" => "1000"]);

$cats = sql::get("SELECT name,url,parent FROM ".Config::dbPrefix()."products_categories WHERE parent IS NULL");
foreach($cats as $k => $v) {
	array_push($vars["menu"], ["name" => $v["name"], "link" => "c_".$v["url"], "parent" => "shop"]);
}
$vars["shopSortBy"] = [];
array_push($vars["shopSortBy"], ["name" => "price", "var" => "price"]);
array_push($vars["shopSortBy"], ["name" => "name", "var" => "name"]);
$vars["css"] = [];

array_push($vars["css"], "css.css");
$vars["js"] = [];
array_push($vars["js"], "shop.js");
