<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Shop", "link" => "shop", "file" => "shop.php", "searchable" => false]);
array_push($vars["menu"], ["name" => "Product", "link" => "product", "file" => "productPage", "visible" => false, "type" => "page", "searchable" => false]);
array_push($vars["menu"], ["name" => "ShoppingCart", "link" => "shop_cart", "file" => "cart.php", "visible" => false, "type" => "file", "searchable" => false]);
array_push($vars["menu"], ["name" => "ShoppingCart_clientInformation", "link" => "shop_client", "file" => "information.php", "visible" => false, "type" => "file", "searchable" => false]);
array_push($vars["menu"], ["name" => "ShoppingCart_shipping", "link" => "shop_shipping", "file" => "shipping.php", "visible" => false, "type" => "file", "searchable" => false]);
array_push($vars["menu"], ["name" => "ShoppingCart_payment", "link" => "shop_payment", "file" => "payment.php", "visible" => false, "type" => "file", "searchable" => false]);
array_push($vars["menu"], ["name" => "ShoppingCart_done", "link" => "shop_done", "file" => "done.php", "visible" => false, "type" => "file", "searchable" => false]);

array_push($vars["menu"], ["name" => "Shop", "link" => "admin_shop", "file" => "admin_shop.php", "visible" => true, "type" => "file", "parent" => "admin", "protected" => true, "searchable" => false]);

$vars["integrate"] = [];
array_push($vars["integrate"], ["position" => "topright", "pages" => ["all"], "notPages" => ["shop_cart", "shop_client", "shop_shipping", "shop_payment", "shop_done"], "url" => "integratecart.php", "prio" => "1000"]);

$cats = sql::get("SELECT name,url,parent FROM ".Config::dbPrefix()."products_categories WHERE parent IS NULL");
foreach($cats as $k => $v) {
	array_push($vars["menu"], ["name" => $v["name"], "link" => "c_".$v["url"], "parent" => "shop", "searchable" => false]);
}
$vars["shopSortBy"] = [];
array_push($vars["shopSortBy"], ["name" => "price", "var" => "price"]);
array_push($vars["shopSortBy"], ["name" => "name", "var" => "name"]);
$vars["css"] = [];

array_push($vars["css"], "css.css");
$vars["js"] = [];
array_push($vars["js"], ["file" => "shop.js", "pages" => true]);

$vars["search"] = [];
$search = sql::get("SELECT id,name,url,desc_short,desc_long,cat FROM ".Config::dbPrefix()."products");
foreach($search as $v) {
	$cats = implode(shop::getCats($v["id"]), " ");
	array_push($vars["search"], ["type" => "product", "url" => "p_".$v["url"], "name" => $v["name"], "txt" => $v["name"]." ".$cats." ".$v["desc_short"]." ".$v["desc_long"]]);
}
