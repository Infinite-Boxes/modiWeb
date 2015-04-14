<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Shop", "link" => "shop", "file" => "shop.php"]);
array_push($vars["menu"], ["name" => "Product", "link" => "product", "file" => "productPage", "visible" => false, "type" => "page"]);
array_push($vars["menu"], ["name" => "ShoppingCart", "link" => "shop_cart", "file" => "cart.php", "visible" => false, "type" => "file"]);

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
