<h1>Admin - Shop</h1>
<?php
if(base::session("user")) {
	echo("<table><tr><td style=\"vertical-align: top;\">");
	echo("<form action=\"".PAGE."\" method=\"POST\">");
	if(isset($_GET["page"])) {
		$page = $_GET["page"];
	} else {
		$page = 0;
	}
	$itemsPerPage = 10;
	$toFetch = "name,img,url";
	$limit = "LIMIT ".($page*$itemsPerPage).",".$itemsPerPage;
	if(isset($_POST["filterCat"])) {
		if($_POST["filterCat"] !== "__all__") {
			echo(shop::catsSelect(false, $_POST["filterCat"]));
			$catId = sql::get("SELECT id FROM ".Config::dbPrefix()."products_categories WHERE url = '".$_POST["filterCat"]."'")["id"];
			$wheres = "";
			foreach(shop::allParentsFromId($catId) as $v) {
				if($wheres === "") {
					$wheres .= " cat = ".$v;
				} else {
					$wheres .= " OR cat = ".$v;
				}
			}
			$products = sql::get("SELECT ".$toFetch." FROM ".Config::dbPrefix()."products WHERE ".$wheres." ORDER BY name ASC ".$limit);
			if(isset($products["name"])) {
				$products = [$products];
			} elseif($products === false) {
				$products = [];
			}
			$numberOfProducts = sql::get("SELECT COUNT(id) AS nr FROM ".Config::dbPrefix()."products WHERE ".$wheres)["nr"];
		} else {
			echo(shop::catsSelect());
			$products = sql::get("SELECT ".$toFetch." FROM ".Config::dbPrefix()."products ORDER BY name ASC ".$limit);
			$numberOfProducts = sql::get("SELECT COUNT(id) AS nr FROM ".Config::dbPrefix()."products")["nr"];
		}
	} else {
		echo(shop::catsSelect());
		$products = sql::get("SELECT ".$toFetch." FROM ".Config::dbPrefix()."products ORDER BY name ASC ".$limit);
		$numberOfProducts = sql::get("SELECT COUNT(id) AS nr FROM ".Config::dbPrefix()."products")["nr"];
	}
	if(isset($products["name"])) {
		$products = [$products];
	}
	echo("</form>");
	if($page > 0) {
		$td1 = "<a href=\"".PAGE."?page=".($page-1)."\"><div class=\"linkedDiv\">Previous page</div></a>";
	} else {
		$td1 = "";
	}
	if($page < ceil(($numberOfProducts/$itemsPerPage)-1)) {
		$td2 = "<a href=\"".PAGE."?page=".($page+1)."\"><div class=\"linkedDiv\">Next page</div></a>";
	} else {
		$td2 = "";
	}
	if(($td1 !== "") || ($td2 !== "")) {
		echo("<table><tr>
	<td style=\"padding: 0px; width:120px; text-align: center;\">".$td1."</td>
	<td style=\"padding: 0px; width:120px; text-align: center;\">".$td2."</td>
	</tr></table>");
	}
	echo("<table class=\"tableLinks\">");
	if(count($products) > 0) {
		foreach($products as $v) {
			echo("<tr>
			<td style=\"padding: 0px;\"><a href=\"admin_shop_editproduct?prod=".$v["url"]."\"><div style=\"padding: 5px;\"><img src=\"img/products/".$v["img"]."\" class=\"imgNotLinked\" style=\"max-height: 20px;\"></div></a></td>
			<td style=\"width: 200px; padding: 0px;\"><a href=\"admin_shop_editproduct?prod=".$v["url"]."\"><div style=\"white-space: nowrap; text-overflow: ellipsis; overflow: hidden; padding: 5px;\">".$v["name"]."</div></a></td>
			</tr>");
		}
	} else {
		echo("<tr><td><p>Inga produkter</p></td></tr>");
	}
?>
</table>
</td><td style="vertical-align: top; border-left: 1px solid #ccc;">
<form action="modules/shop/admin_shop_addproduct.php" method="POST">
<table class="secondTdFull">
<?php
	$categories = sql::get("SELECT id,parent,name,url FROM ".Config::dbPrefix()."products_categories");
	$cats = "";
	$cs = [];
	foreach($categories as $v) {
		$cs[$v["id"]] = $v["parent"];
	}
	foreach($categories as $k => $v) {
		$space = str_repeat(" - ", shop::catDepth($cs, $v["id"]));
		$cats .= "<option value=\"".$v["id"]."\">".$space.$v["name"]."</option>";
	}
	$inp = [
		"productname" => 		["<input type=\"text\" name=\"name\">", ""],
		"activated" => 			["<input type=\"checkbox\" name=\"active\">", ""],
		"url" => 				["<input type=\"text\" name=\"url\" maxlength=255>", "Tillåtna tecken: A-ö, 0-9, -_"],
		"category" => 			["<select name=\"cat\">".$cats."</select>", ""],
		"shortdescription" => 	["<input type=\"text\" name=\"desc_short\">", ""],
		"longdescription" => 	["<textarea name=\"desc_long\" style=\"resize: vertical;\"></textarea>", ""],
		"price" => 				["<input type=\"text\" name=\"price\">", ""],
		"img" => 				["<input type=\"text\" name=\"img\">", ""],
		"flags" => 				["<input type=\"checkbox\" name=\"flag1\"><label for=\"flag1\">".lang::getText("sale")."</label><input type=\"checkbox\" name=\"flag2\"><label for=\"flag2\">".lang::getText("shop_limitedproduct")."</label>", ""]
	];
	foreach($inp as $k => $v) {
		echo("<tr><td><p style=\"white-space: nowrap;\">".lang::getText($k)."</p></td><td style=\"white-space: nowrap;\">".$v[0]."</td><td><p style=\"display: inline;\" class=\"info\">".$v[1]."</p></td></tr>");
	}
	echo("</table><input type=\"submit\" value=\"".lang::getText("add")."\">");
?>
</form>
</td></tr></table>
<?php
}
