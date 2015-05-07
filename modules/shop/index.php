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
		if(!strpos($src, "://")) {
			$src = "img/products/".$src;
		}
		return "<img style=\"margin: 0px 10px 0px 0px; border: 1px solid #bbb; max-width: 100px; max-height: 150px; float: left;\" src=\"".$src."\" />";
	}
	public static function buyWindow() {
		$all = "";
		if(isset($_GET["product"])) {
			$productUrl = $_GET["product"];
		} else {
			$productUrl = "";
		}
		$p = sql::get("SELECT price,name,url FROM ".Config::dbPrefix()."products WHERE url = '".$productUrl."' AND active = 1");
		if($p === FALSE) {
			$all = "<div class=\"buyWindow\"><p>Produkten finns inte</p></div>";
		} else {
			$curr = lang::getText("currency");
			if($p["price"] == "") {
				$priceStr = "<p>Pris saknas</p>";
			} else {
				$priceStr = "<p>".$p["price"].$curr."</p>";
			}
			if(!isset($p["price"])) {
				$price = "false";
			} else {
				$price = $p["price"];
			}
			$buyStr = "<div class=\"buyButton\" onclick=\"shop_shoppingCartAdd('".$p["name"]."', '".$p["url"]."', ".$price.");\">Köp</div>";
			$all = "<div class=\"buyWindow\">".$priceStr.$buyStr."</div>";
		}
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
			if(!strpos($obj["img"], "://")) {
				$img = "img/products/".$obj["img"];
			} else {
				$img = $obj["img"];
			}
		} else {
			$img = "img/products/none.png";
		}
		if(in_array("S", $obj["flags"])) {
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
			if($parent !== false) {
				array_push($cat, $parent["name"]);
			}
			$err ++;
			if($err == 200) {
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
			if($parent !== false) {
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
	static public function sortCats($cats = false) {
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
	static public function catDepth($cats, $cat) {
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
	static public function allParentsFromId($id) {
		$cats = sql::get("SELECT id,parent FROM ".Config::dbPrefix()."products_categories");
		$ret = [$id];
		$c = 0;
		$ids = [["id" => $id]];
		while(count($ids) > 0) {
			$id = array_shift($ids);
			foreach($cats as $v) {
				if($v["parent"] === $id["id"]) {
					array_push($ids, $v);
					array_push($ret, $v["id"]);
					$ok = false;
				}
			}
			if($c === 50) {
				break;
			}
			$c++;
		}
		return $ret;
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
	static public function catsSelect($cats = false, $cat = null) {
		if($cats === false) {
			$cats = sql::get("SELECT * FROM ".Config::dbPrefix()."products_categories ORDER BY parent ASC, id ASC");
		}
		$ret = "<select name=\"filterCat\" id=\"filterCat\" style=\"margin: 0px 5px;\" onchange=\"submit();\">";
		if($cat !== null) {
			$ret .= "<option value=\"__all__\" selected>".lang::getText("everything")."</option>";
		} else {
			$ret .= "<option value=\"__all__\">".lang::getText("everything")."</option>";
		}
		if(isset($cats["name"])) {
			$ret .= "<option value=\"".$cats["url"]."\">".$cats["name"]."</option>";
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
				$ret .= "<option value=\"".$v["url"]."\"".$sel.">".str_repeat("-&nbsp;", self::catDepth($theCats, $v["id"])).$v["name"]." (".self::subProductsCount($v["id"]).")</option>";
			}
		}
		$ret .= "</select>";
		return $ret;
	}
	static public function filterMenu($cat = null) {
		$str = <<<EOD
<div id="filterMenu">
EOD;
$cats = sql::get("SELECT * FROM ".Config::dbPrefix()."products_categories ORDER BY parent ASC, id ASC");
if($cats != false) {
	$form = "<form action=\"functions/shop_redir.php\" method=\"POST\">";
	$select = $form."<p>".lang::getText("category").self::catsSelect(false, $cat)."</p>
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
		$ret = sql::get("SELECT * FROM ".Config::dbPrefix()."products WHERE url = '".$url."' AND active = 1");
		return $ret;
	}
	static public function productExist() {
		$ret = sql::get("SELECT * FROM ".Config::dbPrefix()."products WHERE url = '".$_GET["product"]."' AND active = 1");
		if($ret !== false) {
			return true;
		} else {
			return lang::getText("shop_missing_product");
		}
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
					$products .= "<tr><td>".elements::button("button_minus_15.png", ["js", "dialog('".lang::getText("shop_dialog_removeitem")."', this); shop_shoppingCartRemove('".$v["url"]."')"], "", "onmouseover=\"popup('Ta bort produkten');\"")."</td>
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
		return "<div id=\"shoppingCart\" class=\"window\"><a href=\"shop_cart\"><b>".lang::getText("shoppingCart")."</b></a>
<div id=\"shoppingCartList\">".$products."</table></div><p id=\"cartTotPrice\">Totalt ".$totSum." ".lang::getText("currency")."</div>";
	}
	static public function shippingPackageNameFromCode($codeNr) {
		$code[5] = "Ändrat förfogande";
		$code[6] = "Påminnelseavgift";
		$code[7] = "Kopia på kvittens";
		$code[8] = "Tilläggsförsäkring Pall.ETT";
		$code[9] = "Tilläggsförsäkring DPD";
		$code[10] = "Lastbärare";
		$code[11] = "Posten Varubrev Ekonomi";
		$code[13] = "Postpaket";
		$code[14] = "DPD Företagspaket 12.00";
		$code[15] = "DPD Företagspaket";
		$code[19] = "MyPack";
		$code[20] = "Företagspaket (Förbetald)";
		$code[21] = "Företagspaket Ekonomi Förbet.";
		$code[22] = "Hempaket Retur";
		$code[23] = "Kundretur";
		$code[24] = "MyPack - Retur";
		$code[25] = "Postpaket";
		$code[26] = "Paket utan kvittens";
		$code[27] = "Postpaket Kontant";
		$code[28] = "SverigePaket";
		$code[31] = "DPD Företagspaket 09.00";
		$code[32] = "Hempaket";
		$code[33] = "Hem Lokalt";
		$code[35] = "Företagspaket 09.00, (Förbet.)";
		$code[38] = "Kartong med porto";
		$code[42] = "Expresspaket";
		$code[43] = "Express Global Plus";
		$code[44] = "Bud distributionslösningar";
		$code[45] = "Brevpostförskott Inrikes";
		$code[46] = "Brev";
		$code[47] = "EMS International Express";
		$code[48] = "InNight";
		$code[49] = "InNight Reverse";
		$code[50] = "Urntransport";
		$code[51] = "Företagspaket Comeback";
		$code[52] = "PALL.ETT";
		$code[53] = "PALL.ETT Special";
		$code[54] = "PALL.ETT+";
		$code[57] = "DPD Företagspaket Special";
		$code[58] = "InNight Forwarding";
		$code[59] = "Retail Delivery";
		$code[69] = "InNight Systemtransporter";
		$code[75] = "Posten Varubrev 1:a klass";
		$code[76] = "Extern produkt TNT";
		$code[77] = "Extern produkt FedEx";
		$code[78] = "Posten Varubrev Klimatek";
		$code[79] = " Posten Varubrev Ekonomi";
		$code[80] = "DPD MAX";
		$code[81] = "Lokal Åkeritjänst - Pall";
		$code[82] = "Lokal Åkeritjänst - Paket";
		$code[83] = "Styckegods";
		$code[84] = "Road Freight Europe";
		$code[86] = "Posten Varubrev 1:a klass";
		$code[87] = "Posten Varubrev Retur";
		$code[88] = "DPD Classic";
		$code[91] = "Postpaket Utrikes";
		$code[92] = "Import-Ekonomipaket";
		$code[93] = "eCIP Collect";
		$code[94] = "eCIP Home";
		$code[95] = "Postpaket Utrikes";
		$code[96] = "eCIP Return";
		$code[97] = "Import-UPU";
		$code[98] = "Import-EPG";
		$code[99] = "Internpostservice";
		if(isset($code[$codeNr])) {
			return $code[$codeNr];
		} else {
			return false;
		}
	}
	static public function writeCartTabs($tab, $ok) {
		echo("<div class=\"shop_steps\">");
		$pages[0] = "cart";
		$pages[1] = "information";
		$pages[2] = "shipping";
		$pages[3] = "payment";
		$pages[4] = "done";
		$link = [];
		$link[0] = " href=\"shop_cart\"";
		$link[1] = " href=\"shop_client\"";
		$link[2] = [" href=\"#\" onclick=\"obj('informationForm').submit();\"", " href=\"shop_shipping\""];
		$link[3] = [" href=\"#\" onclick=\"obj('shippingForm').submit();\"", " href=\"shop_payment\""];
		$link[4] = " href=\"shop_done\"";
		$item = [];
		$classType1 = "";
		$classType2 = "shop_stepsCurrent";
		$classType3 = "shop_stepsCurrent last";
		$classType4 = "shop_stepsCurrent done";
		$found = false;
		for($c = 0; $c < 5; $c++) {
			if($tab === $pages[$c]) {
				$found = true;
			}
			if($tab === $pages[4]) {
				$item[$c] = " class=\"".$classType4."\"";
				$link[$c] = " href=\"#\"";
			} else {
				if($found === false) {
					if(gettype($link[$c]) === "array") {
						$link[$c] = $link[$c][1];
					}
					$item[$c] = " class=\"".$classType2."\"";
				} elseif($found === true) {
					$item[$c] = " class=\"".$classType3."\"";
					$link[$c] = " href=\"#\"";
					$found = "found";
				} else {
					if($found === "found") {
						$found = "done";
						if(gettype($link[$c]) === "array") {
							if($ok !== false) {
								$link[$c] = $link[$c][0];
							} else {
								$link[$c] = " href=\"#\"";
							}
						}
					} else {
						$link[$c] = " href=\"#\"";
					}
					$item[$c] = " class=\"".$classType1."\"";
				}
			}
		}
		echo("<a".$link[0].$item[0]."><h2>".lang::getText("cart")."</h2></a><a".$link[1].$item[1]."><h2>".lang::getText("clientinformation")."</h2></a><a".$link[2].$item[2]."><h2>".lang::getText("shipping")."</h2></a><a".$link[3].$item[3]."><h2>".lang::getText("payment")."</h2></a><a".$link[4].$item[4]."><h2>".lang::getText("done")."</h2></a>
</div>");
	}
	static public function writeShipping($id) {
		if($id === "posten") {
			$name = $_SESSION["shop_information"]["name"];
			$address = $_SESSION["shop_information"]["address"];
			$postalNumber = $_SESSION["shop_information"]["postalNumber"];
			$postalCity = $_SESSION["shop_information"]["postalCity"];
			$addressEnd = trim(strrchr($address, " "));
			if($addressEnd !== false) {
				$addressStart = trim(substr($address, 0, strrpos($address, $addressEnd)));
			} else {
				$addressStart = $address;
				$addressEnd = "";
			}
			$vars["consumerId"] = Config::getKey("shipping", "posten");
			$vars["dateOfDeparture"] = "+";
			$vars["serviceCode"] = 25;
			$vars["serviceGroupCode"] = "SE";
			$vars["fromAddressStreetName"] = "Bryggaregatan";
			$vars["fromAddressStreetNumber"] = "32";
			$vars["fromAddressPostalCode"] = "25227";
			$vars["fromAddressCountryCode"] = "SE";
			$vars["toAddressStreetName"] = $addressStart;
			$vars["toAddressStreetNumber"] = $addressEnd;
			$vars["toAddressPostalCode"] = str_replace(" ", "", $postalNumber);
			$vars["toAddressCountryCode"] = "SE";
			$vars["responseContent"] = "full";
			$varsStr = "";
			foreach($vars as $k => $v) {
				if($varsStr === "") {
					$varsStr .= "?";
				} else {
					$varsStr .= "&";
				}
				if($v !== "+") {
					$v = urlEncode($v);
				}
				$varsStr .= $k."=".$v;
			}
			$shippingTime = @file_get_contents("http://api.postnord.com/wsp/rest-services/notis-rest/api/transitTimeInfo.json".$varsStr);
			if($shippingTime === false) {
				$shippingTimeStr = "?";
			} else {
				$shippingTime = json_decode($shippingTime);
				$shippingTime = $shippingTime->{"se.posten.loab.lisp.notis.publicapi.serviceapi.TransitTimeResponse"};
				if(!isset($shippingTime->compositeFault)) {
					$shippingTimeStr = $shippingTime->transitTimes[0]->transitTimeInDays." dagar";
				} else {
					$shippingTimeStr = "";
				}
			}
			return "<h3>Posten</h3>
<p>".$shippingTimeStr."</p>";
		} elseif($id === "dhl") {
			return "<h3>DHL</h3>
<p>Dhl leverans</p>";
		} else {
			return false;
		}
	}
	static public function klarnaMethods() {
		$tvars = Config::getKey("payment", "klarna");
		$digest = base64_encode(pack("H*", hash("sha256", $tvars["eid"].":SEK:".$tvars["secret"])));
		$vars["Authorization"] = "xmlrpc-4.2 ".$digest;
		//$vars["Host"] = "payment.testdrive.klarna.com";
		
		$response = base::apiGet("klarna", "https://api-test.klarna.com/touchpoint/checkout/?currency=SEK&merchant_id=".$tvars["eid"]."&locale=sv_se&total_price=".round($_SESSION["shop_information"]["totalPrice"]*100), $vars);
		$ret = false;
		echo("<pre>");
		print_r($response->payment_methods);
		echo("</pre>");
		$payments = $response->payment_methods;
		$ret = [];
		foreach($payments as $k => $v) {
			if($v->extra_info !== "") {
				$xinfo = "<p>".$v->extra_info."</p>";
			} else {
				$xinfo = "";
			}
			if($v->use_case !== "") {
				$usage = "<p><i>".$v->use_case."</i></p>";
			} else {
				$usage = "";
			}
			if(isset($v->logo->uri)) {
				$ico = "<img src=\"".$v->logo->uri."\" style=\"float: right; max-height: 20px;\">";
			} else {
				$ico = "";
			}
			array_push($ret, ["name" => $v->group->title.": <p style=\"display: inline;\">".$v->title."</p>".$ico, "value" => $v->group->code, "info" => $xinfo.$usage]);
		}
		return $ret;
	}
	static public function paysonMethods() {
	}
	static public function startOrder() {
		
	}
}
shop::init();
?>