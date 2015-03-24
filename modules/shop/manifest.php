<?php
$menu = [];
array_push($menu, ["name" => "Shop", "link" => "shop"]);
$cats = sql::get("SELECT name,url,parent FROM products_categories WHERE parent IS NULL");
foreach($cats as $k => $v) {
	array_push($menu, ["name" => $v["name"], "link" => "c_".$v["url"], "parent" => "shop"]);
}