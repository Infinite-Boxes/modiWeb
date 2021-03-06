<?php
class page {
	static private $keys = [];
	static private $vals = [];
	static private $temp = 0;
	static private $headers = [];
	static private $tools = [];
	static private $adminPages = [
		"admin",
		"admin_editimage",
		"admin_addimage",
		"admin_pages",
		"admin_images",
		"admin_createnewpage"
	];
	static public function write($page = "") {
		$out = sql::get("SELECT * FROM ".Config::dbPrefix()."pages WHERE url = '".$page."' OR name = '".$page."';");
		//$out["content"] = json_decode(stripslashes($out["content"]));
		if($out !== false) {
			$out["content"] = elements::keyReplace("", stripslashes($out["content"]), "");
			self::ak("!b!", "<div>");
			self::ak("!e!", "</div>");
			$txt = str_replace(self::$keys, self::$vals, stripslashes($out["content"]));
			$txt = self::replaceModules($txt);
			$txt = self::replaceKeynames($txt);
			$txt = self::replaceVariables($txt);
			$txt = self::replaceDbQueries($txt);
			$txt = self::replaceUserFunctions($txt);
			echo($txt);
		}
	}
	static private function replaceModules($txt) {
		$c = 0;
		while($pos = stripos($txt, "!MOD!")) {
			$pos2 = stripos($txt, "!ENDMOD!", $pos);
			if($pos2 == false) {
				$pos2 = strlen($txt);
			}
			$mod = substr($txt, $pos+6, ($pos2-$pos)-7);
			if(Config::snippetExist($mod)) {
				$replacement = Config::runSnippet($mod);
			} else {
				$replacement = "";
			}
			$txt = substr_replace($txt, $replacement, $pos, ($pos2-$pos)+8);
			//$txt = str_replace("!MOD!", "MODULE:", $txt);
			if($c == 500) {
				echo(lang::getText("limit_exceeded_variables"));
				break;
			}
			$c++;
		}
		return $txt;
	}
	static private function replaceVariables($txt) {
		$c = 0;
		while($pos = stripos($txt, "!V!")) {
			$pos2 = stripos($txt, "!:!", $pos);
			if($pos2 == false) {
				$pos2 = strlen($txt);
			}
			$var = substr($txt, $pos+4, ($pos2-$pos)-5);
			if(isset($_GET[$var])) {
				$theVar = $_GET[$var];
			} else {
				$theVar = "";
			}
			$txt = substr_replace($txt, $theVar, $pos, ($pos2-$pos)+3);
			if($c == 500) {
				echo(lang::getText("limit_exceeded_variables"));
				break;
			}
			$c++;
		}
		return $txt;
	}
	static private function replaceKeynames($txt) {
		foreach(Config::getKeynames() as $k => $v) {
			 $txt = str_replace($v, Config::getKeyReplace($v), $txt);
		}
		return $txt;
	}
	static private function replaceDbQueries($txt) {
		$c = 0;
		while($pos = stripos($txt, "!GET!")) {
			$pos2 = stripos($txt, "!ENDGET!", $pos);
			if($pos2 === false) {
				$txt = substr_replace($txt, "", $pos, 4);
				break;
			} else {
				$sqlQuery = substr($txt, $pos+6, ($pos2-$pos)-7);
				$endQuery = "SELECT ";
				$keys = [];
				$c2 = 0;
				$keyBegin = 0;
				while(($tpos = stripos($sqlQuery, "KEY_")) !== false) {
					$type = "res";
					$typeStr1 = "";
					$typeStr2 = "";
					$diff = 0;
					if(substr($sqlQuery, $tpos+4, 4) == "SUM_") {
						$typeStr1 = "SUM(";
						$typeStr2 = ")";
						$diff = 4;
					}
					if(substr($sqlQuery, $tpos+4+$diff, 1) == "\"") {
						$tpos2 = stripos($sqlQuery, "\"", 5)+1;
						//$sqlQuery = substr_replace($sqlQuery, "", $tpos+4, 1);
					} else {
						$tpos2 = stripos($sqlQuery, " ");
					}
					array_push($keys, $typeStr1.substr($sqlQuery, $tpos+4+$diff, $tpos2-($tpos+4)-$diff).$typeStr2);
					$sqlQuery = substr_replace($sqlQuery, "", $tpos, ($tpos2-$tpos)+1);
					if($c2 == 20) {
						echo(lang::getText("unknown_error"));
						break;
					}
					$c2++;
				}
				$val = 0;
				foreach($keys as $k => $v) {
					if($endQuery != "SELECT ") {
						$endQuery .= ",".$v." AS val".$val;
					} else {
						$endQuery .= $v." AS val".$val;
					}
					$val++;
				}
				$table = "!:!:!ERROR!:!:!";
				while(($tpos = stripos($sqlQuery, "FROM_")) !== false) {
					if(substr($sqlQuery, $tpos+5, 1) == "\"") {
						$sqlQuery = substr_replace($sqlQuery, "", $tpos+6, 1);
						$tpos2 = stripos($sqlQuery, "\"");
					} else {
						$tpos2 = stripos($sqlQuery, " ");
					}
					$table = substr($sqlQuery, $tpos+5, $tpos2-($tpos+5));
					$sqlQuery = substr_replace($sqlQuery, "", $tpos, ($tpos2-$tpos)+1);
					if($c2 == 20) {
						echo(lang::getText("unknown_error"));
						break;
					}
					$c2++;
				}
				$endQuery .= " FROM ".Config::dbPrefix().$table;
				if(stripos($sqlQuery, "WHERE ") !== false) {
					$sqlQuery = str_replace("WHERE ", " WHERE ", $sqlQuery);
					$endQuery .= str_replace("IS", "=", $sqlQuery);
				} else {
					$endQuery = "!:!:!ERROR!:!:!";
				}
				if(stripos($endQuery, "!:!:!ERROR!:!:!") === false) {
					$value = sql::get($endQuery);
					$ret = "";
					if(is_array($value)) {
						foreach($value as $k => $v) {
							if(is_array($v)) {
								foreach($v as $k2 => $v2) {
									if(count($v) == 1) {
										$ret .= $v2."<br />";
									} else {
										$ret .= $v2;
									}
								}
							} else {
								if(count($value) == 1) {
									$ret .= $v;
								} else {
									$ret .= $v."<br />";
								}
							}
						}
					} else {
						$ret = $value;
					}
					$txt = substr_replace($txt, $ret, $pos, ($pos2-$pos)+8);
				} else {
					echo(lang::getText("unknown_error"));
					break;
				}
			}
			if($c == 500) {
				echo(lang::getText("limit_exceeded_variables"));
				break;
			}
			$c++;
		}
		return $txt;
	}
	static private function replaceUserFunctions($txt) {
		$functions = Config::getUserFunctions();
		foreach($functions as $v) {
			$c = 0;
			while(($pos = strpos($txt, "!FUNC!")) !== false) {
				$pos2 = strpos($txt, "!ENDFUNC!");
				$funcStr = substr($txt, $pos+7, ($pos2-$pos)-8);
				$funcEnd = strpos($funcStr, " ");
				$func = substr($funcStr, 0, $funcEnd);
				if(stripos($funcStr, "(") === false) {
					$args = "";
					$result = Config::runUserFunction($v);
				} else {
					$argStr = substr($funcStr, $funcEnd+2, -3);
					if(stripos($funcStr, ",") === false) {
						$args = $argStr;
					} else {
						$args = explode(",", $argStr);
					}
					$result = Config::runUserFunction($v, $args);
				}
				$str2Replace = substr($txt, $pos, ($pos2-$pos)+9);
				if(gettype($result) === "array") {
					$result = implode($result);
				}
				$txt = str_replace($str2Replace, $result, $txt);
				if($c == 100) {
					echo(lang::getText("limit_exceeded_functions"));
					break;
				}
				$c++;
			}
		}
		return $txt;
	}
	static public function editable($url) {
		$out = sql::get("SELECT * FROM ".Config::dbPrefix()."pages WHERE url = '".$url."' OR name = '".$url."';");
		$pageType = moduleManifest::menuType($url);
		if($out !== false) {
			return $out["id"]; //moduleManifest::menuModule($url)["file"];
		} elseif($pageType == "page") {;
			return page::pagenameToId(moduleManifest::menuModule($url)["file"]);
		} else {
			return false;
		}
	}
	static private function pagenameToId($name) {
		$ret = sql::get("SELECT id FROM ".Config::dbPrefix()."pages WHERE name = '".$name."'");
		return $ret["id"];
	}
	static private function ak($kn, $val) {
		array_push(self::$keys, $kn);
		array_push(self::$vals, $val);
	}
	static public function getCode($page = "") {
		if($page === "") {
			return stripslashes(sql::get("SELECT content FROM ".Config::dbPrefix()."pages;"));
		} else {
			return stripslashes(sql::get("SELECT content FROM ".Config::dbPrefix()."pages WHERE id = ".$page.";")["content"]);
		}
	}
	static public function editorContentID() {
		self::$temp++;
		return "el".self::$temp;
	}
	static public function editorContent($content) {
		/*$r1 = [
			"!_p!",
			"!__p!"
		];
		$r2 = [
			"<p id='".self::editorContentID()."' onclick='tools_mark(this);'>",
			"</p>"
		];
		self::$temp = -1;
		//array_push($r1, "!b!");array_push($r2, "<div id='".self::editorContentID()."' onclick='tools_mark(this);'>");
		while(strpos($content, "!_p!") !== false) {
			$content = substr_replace($content, "<p id='".self::editorContentID()."' onclick='tools_mark(this);'>", strpos($content, "!_p!"), 3);
		}
		array_push($r1, "!__p!");array_push($r2, "</p>");
		$content = str_replace($r1, $r2, $content);
		$content = elements::editReplace($content, false);*/
		return $content;
	}
	static public function editorContentLines($content) {
		return substr_count($content, "!_p!");
	}
	static private function tool($tool) {
		array_push(self::$headers, "<p>".$tool["header"]."</p>");
		array_push(self::$tools, $tool["content"]);
	}
	static public function menu() {
		echo("<div class=\"pageeditmenu\" id=\"pageeditmenu\">");
		$help = elements::button("tool_help.png", ["a", "documentation_editor"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Hjälp!');\"", "target=\"_blank\"");
		$codeAll = elements::button("tool_editcode.png", ["js", "tools_editAllCode()"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Redigera all kod');\"", "target=\"_blank\"");
		echo("<div style=\"float: right;\">".$help."</div>");
		echo("<div style=\"float: right;\">".$codeAll."</div>");
		echo(elements::write("h2", "Redigerar sida", "onclick=\"tools_minmax();\" onmouseover=\"popup('Minimera/maximera verktygslådan');\""));
		$buttons = [
			["tool_del.png", "js", "tools_del();", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Radera element');\""],
			["tool_moveup.png", "js", "tools_move('up');", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Flytta upp');\""],
			["tool_movedown.png", "js", "tools_move('down');", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Flytta ner');\""],
			["tool_editcode.png", "js", "tools_editCode();", "tool", "onload=\"tools_loadTool(this, 'P H1 H2 H3 A IMG TABLE UL DIV');\" onmouseover=\"popup('Redigera koden');\""],
			["tool_save.png", "js", "tools_save();", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Spara sidan');\""]
		];
		$mainbuttons = "";
		foreach($buttons as $v) {
			$mainbuttons .= elements::button($v[0], [$v[1], $v[2]], $v[3], $v[4]);
		}
		echo("<div id=\"allCode\" style=\"display: none;\" class=\"tool disabledTool\">");
		echo(elements::group("<textarea id=\"allCodeTextarea\" style=\"resize: vertical;\"></textarea><input type=\"button\" value=\"Uppdatera sidan\" onclick=\"tools_updateAllCode();\" />", true, "Sidans kod", "tools_codeTool"));
		echo("</div>");
		echo("<div id=\"allTools\" class=\"tool\">");
		echo(elements::group("<p id=\"tools_current\" class=\"only\" style=\"margin-left: 5px;\">Välj ett element</p><br />".$mainbuttons."<br />
		".elements::button("tool_add_text.png", ["js", "tools_create('P');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till text');\"").elements::button("tool_add_image.png", ["js", "tools_create('IMG');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till bild');\"").elements::button("tool_add_table.png", ["js", "tools_create('TABLE');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till tabell');\"").elements::button("tool_add_list.png", ["js", "tools_create('UL');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till lista');\"").elements::button("tool_add_link.png", ["js", "tools_create('A');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till länk');\"").elements::button("tool_add_code.png", ["js", "tools_createCode();"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till kod');\"").elements::button("tool_add_snippet.png", ["js", "tools_createSnippet();"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till modul');\"")."<br />".elements::button("tool_edit.png", ["js", "tools_detailEdit();"], "tool", "onload=\"tools_loadTool(this, 'TABLE UL');\" onmouseover=\"popup('Redigera');\"").elements::button("tool_edit_save.png", ["js", "tools_detailEditSave();"], "tool", "onload=\"tools_loadTool(this, 'TABLE UL');\" onmouseover=\"popup('Spara element');\""), true, "Huvudverktyg", "tools_mainTools"));
		
		$images = sql::get("SELECT * FROM ".Config::dbPrefix()."images");
		if(isset($images["url"])) {
			$temp = $images;
			unset($images);
			$images[0] = $temp;
		} elseif(!isset($images[0]["url"])) {
			$images = false;
		}
		$imgText = "<select id=\"toolsImageUrl\" onchange=\"tools_updateImage(true);\">";$imgText .= "<option value=\"false\" selected>Ingen</option>
";
		if($images !== false) {
			foreach($images as $k => $v) {
				$imgText .= "<option value=\"".$v["url"]."\">".$v["name"]."</option>
";
			}
		}
		$imgText .= "</select>
";
		echo("
<script>
	var subtexts = [];
	var subtextsIndex = [];
");
		if($images !== false) {
			foreach($images as $k => $v) {
				echo("	subtexts[".$k."] = \"".$v["alt"]."\";
	");
			}
			foreach($images as $k => $v) {
				echo("	subtextsIndex[".$k."] = \"".$v["url"]."\";
	");
			}
		}
		echo("</script>
");
		self::tool(["header" => "Text", "content" => "<form onsubmit=\"return false;\" id=\"tools_textDiv\"><script>tools_loadTool(obj('tools_textDiv').parentNode.parentNode, 'P A H1 H2 H3'); obj('tools_textDiv').parentNode.parentNode.classList.add('tool'); </script>
			<textarea id=\"toolsContent\" style=\"resize: vertical;\" onkeyup=\"tools_change();\"></textarea>
		</form>"]);
		
		self::tool(["header" => "Teckensnitt", "content" => "<form onsubmit=\"return false;\" id=\"tools_font\"><script>tools_loadTool(obj('tools_font').parentNode.parentNode, 'P H1 H2 H3 A'); obj('tools_font').parentNode.parentNode.classList.add('tool'); </script>
				<select id=\"tool_font\" onchange=\"tools_changeFont(this);\" oninput=\"tools_changeFont(this);\">
					<optgroup label=\"Serif\">
						<option value=\"Georgia, serif\">Georgia</option>
						<option value=\"'Palatino Linotype', 'Book Antiqua', Palatino, serif\">Palatino Linotype</option>
						<option value=\"'Times New Roman', Times, serif\">Times New Roman</option>
					</optgroup>
					<optgroup label=\"Sans-Serif\">
						<option value=\"Arial, Helvetica, sans-serif\">Arial</option>
						<option value=\"'Arial Black', Gadget, sans-serif\">Arial Black</option>
						<option value=\"'Comic Sans MS', cursive, sans-serif\">Comic Sans MS</option>
						<option value=\"Impact, Charcoal, sans-serif\">Impact</option>
						<option value=\"'Lucida Sans Unicode', 'Lucida Grande', sans-serif\">Lucida Sans Unicode</option>
						<option value=\"Tahoma, Geneva, sans-serif\">Tahoma</option>
						<option value=\"'Trebuchet MS', Helvetica, sans-serif\">Trebuchet MS</option>
						<option value=\"Verdana, Geneva, sans-serif\" selected>Verdana -".lang::getText("default")."-</option>
					</optgroup>
					<optgroup label=\"Monospace\">
						<option value=\"'Courier New', Courier, monospace\">Courier New</option>
						<option value=\"'Lucida Console', Monaco, monospace\">Lucida Console</option>
					</optgroup>
				</select>
			</form>", "attr" => " class=\"tool\""]);
			
		self::tool(["header" => "Färg", "content" => "<form onsubmit=\"return false;\" id=\"tools_color\"><script>tools_loadTool(obj('tools_color').parentNode.parentNode, 'P H1 H2 H3 A'); obj('tools_color').parentNode.parentNode.classList.add('tool'); </script>
				<input type=\"text\" id=\"tool_color\" placeholder=\"Färg\" oninput=\"tools_updColor();\" onchange=\"tools_updColor();\">
				<input type=\"color\" id=\"tool_colorPick\" style=\"width: 20px;\" oninput=\"tools_updColorPick();\" onchange=\"tools_updColorPick();\">
			</form>", "attr" => " class=\"tool\""]);
		
		self::tool(["header" => "Avstånd", "content" => "<form onsubmit=\"return false;\" id=\"tools_marginDiv\"><script>tools_loadTool(obj('tools_marginDiv').parentNode.parentNode, 'P A H1 H2 H3 IMG TABLE UL DIV MOD'); obj('tools_marginDiv').parentNode.parentNode.classList.add('tool'); </script>
			<input type=\"text\" id=\"tool_marginu\" size=1 onchange=\"tools_marginEnd();\" onkeyup=\"tools_updMargin();\" />
			<input type=\"text\" id=\"tool_marginr\" size=1 onchange=\"tools_marginEnd();\" onkeyup=\"tools_updMargin();\" />
			<input type=\"text\" id=\"tool_margind\" size=1 onchange=\"tools_marginEnd();\" onkeyup=\"tools_updMargin();\" />
			<input type=\"text\" id=\"tool_marginl\" size=1 onchange=\"tools_marginEnd();\" onkeyup=\"tools_updMargin();\" />
		</form>"]);
			
		$snippetsMenu = "<option value=\"\">Ingen</option>
";
		foreach(Config::getSnippets() as $k => $v) {
			$snippetsMenu .= "<option value=\"".$v."\">".$v."</option>
";
		}
		self::tool(["header" => "Modul", "content" => "<form onsubmit=\"return false;\" id=\"tools_moduleDiv\"><script>tools_loadTool(obj('tools_moduleDiv').parentNode.parentNode, 'MOD'); obj('tools_moduleDiv').parentNode.parentNode.classList.add('tool'); </script>
				<select id=\"moduleList\" onchange=\"tools_requestSnippet();\">
					".$snippetsMenu."
				</select>
			</form>"]);
		self::tool(["header" => "Länk", "content" => "<form onsubmit=\"return false;\" id=\"tools_linkDiv\"><script>tools_loadTool(obj('tools_linkDiv').parentNode.parentNode, 'A'); obj('tools_linkDiv').parentNode.parentNode.classList.add('tool'); </script>
				<input type=\"text\" id=\"toolsLink\" oninput=\"tools_changeLink();\" onkeyup=\"tools_changeLink();\" />
			</form>"]);
		
		$pagesInMenuOption = "";
		$pagesNotInMenuOption = "";
		
		$pagesFromDB = sql::get("SELECT name,url FROM ".Config::dbPrefix()."pages WHERE url IS NOT NULL");
		if($pagesFromDB !== false) {
			if(isset($pagesFromDB["name"])) {
				$pagesFromDB = [$pagesFromDB];
			}
		}
		$pagesInMenuList = [];
		foreach($pagesFromDB as $v) {
			//array_push($pagesInMenuList, $v);
		}
		/*foreach(moduleManifest::getMenu() as $v) {
			foreach($v as $k2 => $v2) {
				if(isset($v2["link"])) {
					if($v2["visible"] === true) {
						array_push($pagesInMenuList, ["url" => $v2["link"], "name" => $v2["name"]]);
					}
				}
			}
		}*/
		foreach(menu::getItemsForPagesList() as $v) {
			array_push($pagesInMenuList, $v);
		}
		$pagesInMenuList = base::sortBy($pagesInMenuList, "name");
		foreach($pagesInMenuList as $k => $v) {
			if(gettype($v["url"]) === "NULL") {
				$url = "NULL";
			} else {
				$url = $v["url"];
			}
			$pagesInMenuOption .= "<option value=\"".$url."\">".$v["name"]."</option>
";
		}
		self::tool(["header" => "&nbsp;", "content" => "<form onsubmit=\"return false;\" id=\"tools_linkList\"><script>tools_loadTool(obj('tools_linkList').parentNode.parentNode, 'A'); obj('tools_linkList').parentNode.parentNode.classList.add('tool'); </script>
				<select id=\"tool_linkList\" onchange=\"tools_selectLink()\">
					<option value=\"NULL\" selected>".lang::getText("custom")."</option>
					<optgroup label=\"".lang::getText("inmenu")."\">
						".$pagesInMenuOption."
					</optgroup>
					<optgroup label=\"".lang::getText("notinmenu")."\">
						".$pagesNotInMenuOption."
					</optgroup>
				</select>
			</form>"]);
		self::tool(["header" => "".lang::getText("target")."", "content" => "<form onsubmit=\"return false;\" id=\"tools_linkTarget\"><script>tools_loadTool(obj('tools_linkTarget').parentNode.parentNode, 'A'); obj('tools_linkTarget').parentNode.parentNode.classList.add('tool'); </script>
				<select id=\"tool_linkTarget\" onchange=\"tools_linkTarget()\">
					<option value=\"_blank\" selected>".lang::getText("newwindow")."</option>
					<option value=\"_self\" selected>".lang::getText("samewindow")."</option>
				</select>
			</form>"]);
		self::tool(["header" => "Visa", "content" => "<form onsubmit=\"return false;\" id=\"tools_displayDiv\"><script>tools_loadTool(obj('tools_displayDiv').parentNode.parentNode, 'P A H1 H2 H3 DIV MOD'); obj('tools_displayDiv').parentNode.parentNode.classList.add('tool'); </script> 
				".elements::button("tool_display_inline.png", ["js", "tools_displayType('inline');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Dela rad med andra objekt');\"")."
				".elements::button("tool_display_block.png", ["js", "tools_displayType('block');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Visa ensam på rad');\"")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Bild", "content" => "<form onsubmit=\"return false;\" id=\"tools_urlDiv\"><script>tools_loadTool(obj('tools_urlDiv').parentNode.parentNode, 'IMG'); obj('tools_urlDiv').parentNode.parentNode.classList.add('tool'); </script>
				".$imgText."
			</form>"]);
		self::tool(["header" => "Bildtext", "content" => "<form onsubmit=\"return false;\" id=\"tools_imgAlt\"><script>tools_loadTool(obj('tools_imgAlt').parentNode.parentNode, 'IMG'); obj('tools_imgAlt').parentNode.parentNode.classList.add('tool'); </script>
				".elements::checkbox("tool_imgAlt", "true", "false", "img/tool_subtext.png", "tools_imgAlt(this);")."
			</form>"]);
		self::tool(["header" => "Bildruta", "content" => "<form onsubmit=\"return false;\" id=\"tools_imgContainer\"><script>tools_loadTool(obj('tools_imgContainer').parentNode.parentNode, 'IMG'); obj('tools_imgContainer').parentNode.parentNode.classList.add('tool'); </script>
				".elements::checkbox("tool_imgContainer", "true", "false", "img/tool_imgcontainer.png", "tools_imgContainer(this);")."
			</form>"]);
		self::tool(["header" => "Stil", "content" => "<form onsubmit=\"return false;\" id=\"tools_style\"><script>tools_loadTool(obj('tools_style').parentNode.parentNode, 'P H1 H2 H3 A'); obj('tools_style').parentNode.parentNode.classList.add('tool'); </script>
				".elements::checkbox("tool_bold", "true", "false", "img/tool_bold.png", "tools_style('bold');")."
				".elements::checkbox("tool_italic", "true", "false", "img/tool_italic.png", "tools_style('italic');")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Storlek", "content" => "<form onsubmit=\"return false;\" id=\"tools_size\"><script>tools_loadTool(obj('tools_size').parentNode.parentNode, 'P H1 H2 H3'); obj('tools_size').parentNode.parentNode.classList.add('tool'); </script>
				".elements::button("tool_h1.png", ["js", "tools_textSize('H1');"], "", "onmouseover=\"popup('Störst titel');\"")."
				".elements::button("tool_h2.png", ["js", "tools_textSize('H2');"], "", "onmouseover=\"popup('Mellanstor titel');\"")."
				".elements::button("tool_h3.png", ["js", "tools_textSize('H3');"], "", "onmouseover=\"popup('Liten titel');\"")."
				".elements::button("tool_p.png", ["js", "tools_textSize('P');"], "", "onmouseover=\"popup('Vanlig text');\"")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Max bredd", "content" => "<form onsubmit=\"return false;\" id=\"tools_maxwidthDiv\"><script>tools_loadTool(obj('tools_maxwidthDiv').parentNode.parentNode, 'IMG'); obj('tools_maxwidthDiv').parentNode.parentNode.classList.add('tool'); </script>
				<input type=\"text\" id=\"toolsImageMaxwidth\" placeholder=\"Bredd i pixlar\" onkeyup=\"tools_maxWidth();\" />
			</form>"]);
		self::tool(["header" => "Justera", "content" => "<form onsubmit=\"return false;\" id=\"tools_alignDiv\"><script>tools_loadTool(obj('tools_alignDiv').parentNode.parentNode, 'P A H1 H2 H3'); obj('tools_alignDiv').parentNode.parentNode.classList.add('tool'); </script> 
				".elements::button("tool_align_left.png", ["js", "tools_align('left');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Justera till vänster');\"")."
				".elements::button("tool_align_center.png", ["js", "tools_align('center');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Justera till mitten');\"")."
				".elements::button("tool_align_right.png", ["js", "tools_align('right');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Justera till höger');\"")."
				".elements::button("tool_align_justify.png", ["js", "tools_align('justify');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Justera till full bredd');\"")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Flyt", "content" => "<form onsubmit=\"return false;\" id=\"tools_floatDiv\"><script>tools_loadTool(obj('tools_floatDiv').parentNode.parentNode, 'IMG TABLE UL P H1 H2 H3 A'); obj('tools_floatDiv').parentNode.parentNode.classList.add('tool'); </script>
				".elements::button("tool_float_left.png", ["js", "tools_float('left');"], "", "onmouseover=\"popup('Flyt till vänster');\"")."
				".elements::button("tool_float_right.png", ["js", "tools_float('right');"], "", "onmouseover=\"popup('Flyt till höger');\"")."
				".elements::button("tool_float_none.png", ["js", "tools_float('none');"], "", "onmouseover=\"popup('Flyt inte');\"")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Celler", "content" => "<form onsubmit=\"return false;\" id=\"tools_tableRows\"><script>tools_loadTool(obj('tools_tableRows').parentNode.parentNode, 'TABLE'); obj('tools_tableRows').parentNode.parentNode.classList.add('tool'); </script>
				".elements::button("tool_row_add.png", ["js", "tools_tableRow('add');"], "", "onmouseover=\"popup('Lägg till rad');\"")."
				".elements::button("tool_row_remove.png", ["js", "tools_tableRow('remove');"], "", "onmouseover=\"popup('Ta bort rad');\"")."
				".elements::button("tool_cell_add.png", ["js", "tools_tableCell('add');"], "", "onmouseover=\"popup('Lägg till kolumn');\"")."
				".elements::button("tool_cell_remove.png", ["js", "tools_tableCell('remove');"], "", "onmouseover=\"popup('Ta bort kolumn');\"")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Punkter", "content" => "<form onsubmit=\"return false;\" id=\"tools_list\"><script>tools_loadTool(obj('tools_list').parentNode.parentNode, 'UL'); obj('tools_list').parentNode.parentNode.classList.add('tool'); </script>
				".elements::button("tool_list_add.png", ["js", "tools_list('add');"], "", "onmouseover=\"popup('Lägg till rad');\"")."
				".elements::button("tool_list_remove.png", ["js", "tools_list('remove');"], "", "onmouseover=\"popup('Ta bort rad');\"")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Detaljer", "content" => "<form onsubmit=\"return false;\" id=\"tools_tableDetails\"><script>tools_loadTool(obj('tools_tableDetails').parentNode.parentNode, 'TABLE'); obj('tools_tableDetails').parentNode.parentNode.classList.add('tool');
			</script>
				".elements::button("tool_tableborder_add.png", ["js", "tools_tableBorder('add');"], "", "id=\"tools_tableAddBorder\" onmouseover=\"popup('Lägg till kant');\" onload=\"tools_loadTool(this, 'TABLE');\"")."
				".elements::button("tool_tableborder_remove.png", ["js", "tools_tableBorder('remove');"], "", "id=\"tools_tableRemoveBorder\" onmouseover=\"popup('Ta bort kant');\" onload=\"tools_loadTool(this, 'TABLE');\"")."
			</form>", "attr" => "class=\"tool\""]);
		$tools = [];
		$tools["header"] = [];
		foreach(self::$headers as $v) {
			array_push($tools["header"], $v);
		}
		foreach(self::$tools as $v) {
			array_push($tools, $v);
		}
		
		$codeTools = ["header" => ["<p><b>Kod</b></p>"], 
		"<textarea id=\"codearea\" style=\"resize: vertical;\"></textarea><br /><input type=\"button\" onclick=\"tools_updateCode();\" value=\"Uppdatera\" />"];
		echo(elements::group(elements::writeTable($codeTools, "v"), true, "Kod", "tools_code", "onload=\"tools_disable(this);\"", "tool"));
		
		echo(elements::group(elements::writeTable($tools, "v"), true, "Redigera", "tools_editTools", "", "tool"));
		
		echo("</div><div id=\"out\"></div></div>");
	}
	static public function isEditable() {
		$page = sql::get("SELECT * FROM ".Config::dbPrefix()."pages WHERE url = '".$_SESSION["page"]."'");
		if($page === false) {
			if(!in_array($_SESSION["page"], self::$adminPages)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}
