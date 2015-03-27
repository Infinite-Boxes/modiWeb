<?php
$filter = [];
if(isset($_GET["cat"])) {
	echo(shop::filterMenu($_GET["cat"]));
	if($_SESSION["filterCatInclude"] != "true") {
		$filter["cat"] = "cat = '".sql::get("SELECT id FROM products_categories WHERE url = '".$_GET["cat"]."'")["id"]."'";
	} else {
		$temp = shop::filterCat($_GET["cat"]);
		if($temp != "") {
			$filter["cat"] = $temp;
		}
	}
} else {
	echo(shop::filterMenu());
}
echo("<div id=\"products\">");
if(count($filter) > 0) {
	$filterTxt = " WHERE";
	$sw = false;
	foreach($filter as $k => $v) {
		$andTxt = " AND ";
		if($sw == false) {
			$andTxt = " ";
			$sw = true;
		}
		$filterTxt .= $andTxt.$v; 
	}
} else {
	$filterTxt = "";
}
if((isset($_SESSION["sortDirection"])) && (isset($_SESSION["shopSortBy"]))) {
	$sortStr = " ORDER BY ".$_SESSION["shopSortBy"]." ".$_SESSION["sortDirection"];
} else {
	$sortStr = "";
}
$sql = "SELECT url,name,price,img,flags FROM products".$filterTxt.$sortStr;
$sqlList = sql::get($sql);
if($sqlList !== false) {
	$products = [];
	if(isset($sqlList["name"])) {
		array_push($products, $sqlList);
	} else {
		$products = $sqlList;
	}
	foreach($products as $k => $v) {
		//$sqlImg = sql::get("SELECT src FROM products ");
		$v["flags"] = explode(" ", $v["flags"]);
		echo(shop::productObject($v));
	}
} else {
	echo(shop::emptyShop());
}
?>
</div>