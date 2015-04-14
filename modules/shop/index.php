<?php
class shop {
	public static function init() {
		// Create userfunction. Arg1 = callName. Arg2 = arguments. For multiple arguments, use Array
		//Config::addUserFunction("productCategories", "catTree");
		Config::addUserFunction("includeSmallShoppingCart", "writeCartSmall");
		// Add keynames to use in the editor.
		Config::addKeyname("[currency]", lang::getText("currency"));
		// Create snippets
		Config::addSnippet("Produktbild", "productimage");
		Config::addSnippet("ProduktKategoriTräd", "productCategories");
		Config::addSnippet("Köpruta", "buyWindow");
	}
	public static function rot() {
		return "hej";
	}
	public static function productimage() {
		$src = sql::get("SELECT img FROM ".Config::dbPrefix()."products WHERE url = '".$_GET["product"]."'")["img"];
		if($src == "") {
			$src = "none.png";
		}
		return "<img style=\"margin: 0px 10px 0px 0px; border: 1px solid #bbb; width: 100px; height: 150px; float: left;\" src=\"img/products/".$src."\" />";
	}
	public static function buyWindow() {
		$all = "";
		$p = sql::get("SELECT price,name,url FROM ".Config::dbPrefix()."products WHERE url = '".$_GET["product"]."'");
		$curr = lang::getText("currency");
		if($p["price"] == "") {
			$priceStr = "<p>Pris saknas</p>";
		} else {
			$priceStr = "<p>".$p["price"].$curr."</p>";
		}
		$buyStr = "<div class=\"buyButton\" onclick=\"shop_shoppingCartAdd('".$p["name"]."', '".$p["url"]."', ".$p["price"].");\">Köp</div>";
		$all = "<div class=\"buyWindow\">".$priceStr.$buyStr."</div>";
		return $all;
	}
	public static function productCategories() {
		if(isset($_GET["product"])) {
			return "<p>".self::catTree($_GET["product"])."</p>";
		} else {
			return "<p>Module: ProductCategories</p>";
		}
	}
	public static function productObject($obj) {
		if($obj["img"] != null) {
			$img = "img/products/".$obj["img"];
		} else {
			$img = "img/tools_emptyimage.png";
		}
		if(in_array("sale", $obj["flags"])) {
			$priceFlags = " priceSale";
		} else {
			$priceFlags = "";
		}
		$price = $obj["price"];
		return "<div class=\"product\"><a href=\"p_".$obj["url"]."\"><div><p class=\"name\">".$obj["name"]."</p>
<div class=\"productImg\"><img src=\"".$img."\" class=\"imgNotLinked\" /></div>
<p class=\"price".$priceFlags."\">".$price." ".lang::getText("currency")."</p></div></a><div class=\"buyButtonSmall\" onclick=\"shop_shoppingCartAdd('".$obj["name"]."', '".$obj["url"]."', ".$obj["price"].");\">Köp</div></div>";
	}
	public static function getCats($prod) {
		$cat = [];
		$id = sql::get("SELECT cat FROM ".Config::dbPrefix()."products WHERE id = ".$prod)["cat"];
		$pid = $id;
		$err = 0;
		while($pid !== "") {
			$parent = sql::get("SELECT parent,name FROM ".Config::dbPrefix()."products_categories WHERE id = ".$pid);
			$pid = $parent["parent"];
			if($pid != "") {
				array_push($cat, $parent["name"]);
			}
			$err ++;
			if($err == 100) {
				$pid = "";
			}
		}
		return $cat;
	}
	public static function catTree($prod) {
		$cat = [];
		$id = sql::get("SELECT cat FROM ".Config::dbPrefix()."products WHERE url = '".$prod."'")["cat"];
		$pid = $id;
		$err = 0;
		while($pid !== "") {
			$parent = sql::get("SELECT parent,name,url FROM ".Config::dbPrefix()."products_categories WHERE id = ".$pid);
			$pid = $parent["parent"];
			if($pid != "") {
				array_push($cat, ["name" => $parent["name"], "link" => $parent["url"]]);
			}
			$err ++;
			if($err == 100) {
				$pid = "";
			}
		}
		$str = "";
		$sw = false;
		$cat = array_reverse($cat);
		foreach($cat as $k => $v) {
			if($sw == false) {
				$sw = true;
				$str .= "<a href=\"c_".$v["link"]."\" style=\"font-size: 1em;\">".$v["name"]."</a>";
			} else {
				$str .= " - <a href=\"c_".$v["link"]."\" style=\"font-size: 1em;\">".$v["name"]."</a>";
			}
		}
		return $str;
	}
	static public function filterCat($category) {
		$id = sql::get("SELECT id FROM ".Config::dbPrefix()."products_categories WHERE url = '".$category."'")["id"];
		$cat = [];
		$pid = $id;
		$err = 0;
		$id2check = [$id];
		$sw = true;
		while(count($id2check) > 0) {
			$id = array_pop($id2check);
			array_push($cat, $id);
			$pid = sql::get("SELECT id FROM ".Config::dbPrefix()."products_categories WHERE parent = ".$id);
			if(isset($pid["id"])) {
				array_push($id2check, $pid["id"]);
			} elseif(isset($pid[0]["id"])) {
				foreach($pid as $k => $v) {
					array_push($id2check, $v["id"]);
				}
			}
			$err ++;
			if($err == 20) {
				$id2check = [];
			}
		}
		$str = "";
		$sw = false;
		foreach($cat as $k => $v) {
			if($sw == false) {
				$str .= "cat = ".$v;
				$sw = true;
			} else {
				$str .= " OR cat = ".$v;
			}
		}
		return $str;
	}
	static private function sortCats($cats = false) {
		if($cats == false) {
			return false;
		} else {
			$c = 0;
			while($c < 10) {
				foreach($cats as $k => $v) {
					if($v["parent"] != "NULL") {
						$id = false;
						foreach($cats as $k2 => $v2) {
							if($v2["id"] == $v["parent"]) {
								$id = $k2;
								break;
							}
						}
						if($id !== false) {
							$cats = base::array_move($cats, $k, $k2);
						}
					}
				}
				$c++;
			}
			return $cats;
		}
	}
	static private function catDepth($cats, $cat) {
		$depth = 0;
		$pid = $cat;
		$err = 0;
		while($pid !== "") {
			foreach($cats as $k => $v) {
				if($k == $pid) {
					$pid = $v;
				}
			}
			if($pid != "") {
				$depth++;
			}
			$err ++;
			if($err == 20) {
				$pid = "";
			}
		}
		return $depth;
	}
	static private function catChildren($id) {
		$depth = 0;
		$pid = $cat;
		$err = 0;
		while($pid !== "") {
			foreach($cats as $k => $v) {
				if($k == $pid) {
					$pid = $v;
				}
			}
			if($pid != "") {
				$depth++;
			}
			$err ++;
			if($err == 20) {
				$pid = "";
			}
		}
		return $depth;
	}
	static public function orderQuery() {
		
	}
	static public function subProductsCount($id = false) {
		if($id !== false) {
			if($_SESSION["filterCatInclude"] == "true") {
				$cats = sql::get("SELECT id,parent FROM ".Config::dbPrefix()."products_categories");
				$toSearch = [];
				foreach($cats as $k => $v) {
					if($v["parent"] == $id) {
						array_push($toSearch, $v);
					}
				}
				$c = 0;
				$count = 0;
				while(count($toSearch) > 0) {
					$toFind = array_shift($toSearch);
					$count = $count+sql::get("SELECT COUNT(*) as c FROM ".Config::dbPrefix()."products WHERE cat = ".$toFind["id"])["c"];
					foreach($cats as $k => $v) {
						if($v["parent"] == $toFind["id"]) {
							array_push($toSearch, $v);
						}
					}
					
					if($c > 50) {
						$toSearch = [];
					}
					$c++;
				}
			} else {
				$count = 0;
			}
			$base = sql::get("SELECT COUNT(*) AS c FROM ".Config::dbPrefix()."products WHERE cat = ".$id)["c"];
			return $base+$count;
		} else {
			return false;
		}
	}
	static public function emptyShop() {
		return "<p>Inga produkter</p>";
	}
	static public function filterMenu($cat = null) {
		$str = <<<EOD
<div id="filterMenu">
EOD;
$cats = sql::get("SELECT * FROM ".Config::dbPrefix()."products_categories ORDER BY parent ASC, id ASC");
if($cats != false) {
	$form = "<form action=\"functions/shop_redir.php\" method=\"POST\">";
	$select = $form."<p>".lang::getText("category")."<select name=\"filterCat\" id=\"filterCat\" style=\"margin: 0px 5px;\" onchange=\"submit();\">";
	if($cat !== null) {
		$select .= "<option value=\"__all__\" selected>".lang::getText("everything")."</option>";
	} else {
		$select .= "<option value=\"__all__\">".lang::getText("everything")."</option>";
	}
	if(isset($cats["name"])) {
		$select .= "<option value=\"".$cats["url"]."\">".$cats["name"]."</option>";
	} else {
		$theCats = [];
		foreach($cats as $k => $v) {
			$theCats[$v["id"]] = $v["parent"];
		}
		$cats = self::sortCats($cats);
		foreach($cats as $k => $v) {
			if($v["url"] == $cat) {
				$sel = " selected";
			} else {
				$sel = "";
			}
			$select .= "<option value=\"".$v["url"]."\"".$sel.">".str_repeat("-&nbsp;", self::catDepth($theCats, $v["id"])).$v["name"]." (".self::subProductsCount($v["id"]).")</option>";
		}
	}
	$select .= "</select></p>
</form>";
	$includes = $form;
	$filterCatInclude_yes = "<input type=\"hidden\" name=\"filterCatInclude\" value=\"true\"><input type=\"submit\" value=\"".lang::getText("incl_subcategories")."\" />";
	$filterCatInclude_no = "<input type=\"hidden\" name=\"filterCatInclude\" value=\"false\"><input type=\"submit\" value=\"".lang::getText("excl_subcategories")."\" />";
	if(isset($_SESSION["filterCatInclude"])) {
		if($_SESSION["filterCatInclude"] == "true") {
			$includes .= $filterCatInclude_no;
		} else {
			$includes .= $filterCatInclude_yes;
		}
	} else {
		$includes .= $filterCatInclude_no;
	}
	$includes .= "
</form>";
	$sortBy = $form."<p>Sorterar efter <select id=\"shopSortBy\" name=\"sortby\" onchange=\"submit();\">
";
	foreach(moduleManifest::getModVal("shopSortBy") as $k => $v) {
		if(isset($_SESSION["shopSortBy"])) {
			if($_SESSION["shopSortBy"] == $v["var"]) {
				$selected = " selected";
			} else {
				$selected = "";
			}
		} else {
			$selected = "";
		}
		$sortBy .= "<option value=\"".$v["var"]."\"".$selected.">".lang::getText($v["name"])."</option>
";
	}
	$sortBy .= "
</select></p>";
	
	$sortBy .= "</form>";
	$sortDir = $form."<p>";
	$sortDesc = "<input type=\"hidden\" name=\"sortdirection\" value=\"ASC\"><input type=\"submit\" value=\"".lang::getText("asc")."\" id=\"shopSortDir\" />";
	$sortAsc = "<input type=\"hidden\" name=\"sortdirection\" value=\"DESC\"><input type=\"submit\" value=\"".lang::getText("desc")."\" id=\"shopSortDir\" />";
	if(isset($_SESSION["sortDirection"])) {
		if($_SESSION["sortDirection"] == "ASC") {
			$sortDir .= $sortAsc;
		} else {
			$sortDir .= $sortDesc;
		}
	} else {
		$sortDir .= $sortAsc;
	}
	$sortDir .= "</p></form>";
	$view = $form;
	
	$view .= "</form>";
	$str .= $select;
	$str .= $includes;
	$str .= $sortBy;
	$str .= $sortDir;
	$str .= $view;
}
$str .= "</div>
";
		return $str;
	}
	static public function getProduct($url) {
		$ret = sql::get("SELECT * FROM ".Config::dbPrefix()."products WHERE url = '".$url."'");
		return $ret;
	}
	static public function writeCartSmall() {
		$totSum = 0;
		if(isset($_SESSION["shoppingCart"])) {
			$prodList = $_SESSION["shoppingCart"];
			$totSum = 0;
			if(count($prodList) > 4) {
				$products = "<p>".count($prodList)." produkter";
				foreach($prodList as $k => $v) {
					$totSum += sql::get("SELECT price FROM ".Config::dbPrefix()."products WHERE (url = '".$v["url"]."')")["price"];
				}
			} elseif(count($prodList) > 0) {
				$products = "<table>";
				$c = 0;
				foreach($prodList as $k => $v) {
					$price = sql::get("SELECT price FROM ".Config::dbPrefix()."products WHERE (url = '".$v["url"]."')")["price"];
					$totSum += $price;
					$products .= "<tr><td>".elements::button("button_minus_15.png", ["js", "shop_shoppingCartRemove('".$v["url"]."')"], "", "onmouseover=\"popup('Ta bort produkten');\"")."</td>
					<td><a href=\"p_".$v["url"]."\">".$v["name"]."</a><input type=\"hidden\" id=\"price".$c."\" value=\"".$price."\">
					</td></tr>";
					$c++;
				}
				$products .= "</table>";
			} else {
				$products = "<tr><td><p>Inga produkter</p></td></tr>";
			}
		} else {
			$products = "<tr><td><p>Inga produkter</p></td></tr>";
		}
		return "<div id=\"shoppingCart\"><a href=\"shop_cart\"><b>".lang::getText("shoppingCart")."</b></a>
<div id=\"shoppingCartList\">".$products."</table></div><p id=\"cartTotPrice\">Totalt ".$totSum." ".lang::getText("currency")."</div>";
	}
}
shop::init();
?>