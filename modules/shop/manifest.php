<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Shop", "link" => "shop"]);
$cats = sql::get("SELECT name,url,parent FROM products_categories WHERE parent IS NULL");
foreach($cats as $k => $v) {
	array_push($vars["menu"], ["name" => $v["name"], "link" => "c_".$v["url"], "parent" => "shop"]);
}
$vars["shopSortBy"] = [];
array_push($vars["shopSortBy"], ["name" => "price", "var" => "price"]);
array_push($vars["shopSortBy"], ["name" => "name", "var" => "name"]);
$vars["css"] = [];
array_push($vars["css"], "css.css");
