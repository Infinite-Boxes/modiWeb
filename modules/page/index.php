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
		$out = sql::get("SELECT * FROM pages WHERE url = '".$page."' OR name = '".$page."';");
		if($out !== false) {
			$out["content"] = elements::keyReplace("", $out["content"], "");
			self::ak("!b!", "<div>");
			self::ak("!e!", "</div>");
			echo(str_replace(self::$keys, self::$vals, $out["content"]));
		}
	}
	static public function editable($url) {
		$out = sql::get("SELECT * FROM pages WHERE url = '".$url."' OR name = '".$url."';");
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
		$ret = sql::get("SELECT id FROM pages WHERE name = '".$name."'");
		return $ret["id"];
	}
	static private function ak($kn, $val) {
		array_push(self::$keys, $kn);
		array_push(self::$vals, $val);
	}
	static public function getCode($page = "") {
		if($page === "") {
			return sql::get("SELECT content FROM pages;");
		} else {
			return sql::get("SELECT content FROM pages WHERE id = ".$page.";")["content"];
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
		echo("<div style=\"float: right;\">".$help."</div>");
		echo(elements::write("h2", "Redigerar sida", "onclick=\"tools_minmax();\" onmouseover=\"popup('Minimera/maximera verktygslådan');\""));
		$buttons = [
			["tool_del.png", "js", "tools_del();", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Radera element');\""],
			["tool_moveup.png", "js", "tools_move('up');", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Flytta upp');\""],
			["tool_movedown.png", "js", "tools_move('down');", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Flytta ner');\""],
			["tool_editcode.png", "js", "tools_editCode();", "tool", "onload=\"tools_loadTool(this, 'P H1 H2 H3 A IMG TABLE UL');\" onmouseover=\"popup('Redigera koden');\""],
			["tool_save.png", "js", "tools_save();", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Spara sidan');\""]
		];
		$mainbuttons = "";
		foreach($buttons as $v) {
			$mainbuttons .= elements::button($v[0], [$v[1], $v[2]], $v[3], $v[4]);
		}
		echo(elements::group("<p id=\"tools_current\" class=\"only\" style=\"margin-left: 5px;\">Välj ett element</p><br />".$mainbuttons."<br />
		".elements::button("tool_add_text.png", ["js", "tools_create('P');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till text');\"").elements::button("tool_add_image.png", ["js", "tools_create('IMG');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till bild');\"").elements::button("tool_add_table.png", ["js", "tools_create('TABLE');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till tabell');\"").elements::button("tool_add_list.png", ["js", "tools_create('UL');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till lista');\"").elements::button("tool_add_link.png", ["js", "tools_create('A');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Lägg till länk');\"")."<br />".elements::button("tool_edit.png", ["js", "tools_detailEdit();"], "tool", "onload=\"tools_loadTool(this, 'TABLE UL');\" onmouseover=\"popup('Redigera');\"").elements::button("tool_edit_save.png", ["js", "tools_detailEditSave();"], "tool", "onload=\"tools_loadTool(this, 'TABLE UL');\" onmouseover=\"popup('Spara element');\""), true, "Huvudverktyg", "tools_mainTools"));
		
		$images = sql::get("SELECT * FROM images");
		if(isset($images["url"])) {
			$temp = $images;
			unset($images);
			$images[0] = $temp;
		} elseif(!isset($images[0]["url"])) {
			$images = false;
		}
		$imgText = "<select id=\"toolsImageUrl\" onchange=\"tools_updateImage();\">";$imgText .= "<option value=\"false\" selected>Ingen</option>
";
		if($images != false) {
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
		foreach($images as $k => $v) {
			echo("	subtexts[".$k."] = \"".$v["alt"]."\";
");
		}
		foreach($images as $k => $v) {
			echo("	subtextsIndex[".$k."] = \"".$v["url"]."\";
");
		}
		echo("</script>
");
		self::tool(["header" => "Text", "content" => "<form onsubmit=\"return false;\" id=\"tools_textDiv\"><script>tools_loadTool(obj('tools_textDiv').parentNode.parentNode, 'P A H1 H2 H3'); obj('tools_textDiv').parentNode.parentNode.classList.add('tool'); </script>
				<textarea id=\"toolsContent\" style=\"resize: vertical;\" onkeyup=\"tools_change();\"></textarea>
			</form>"]);
		self::tool(["header" => "Länk", "content" => "<form onsubmit=\"return false;\" id=\"tools_linkDiv\"><script>tools_loadTool(obj('tools_linkDiv').parentNode.parentNode, 'A'); obj('tools_linkDiv').parentNode.parentNode.classList.add('tool'); </script>
				<input type=\"text\" id=\"toolsLink\" onkeyup=\"tools_changeLink();\" />
			</form>"]);
		self::tool(["header" => "Visa", "content" => "<form onsubmit=\"return false;\" id=\"tools_displayDiv\"><script>tools_loadTool(obj('tools_displayDiv').parentNode.parentNode, 'P A H1 H2 H3'); obj('tools_displayDiv').parentNode.parentNode.classList.add('tool'); </script> 
				".elements::button("tool_display_inline.png", ["js", "tools_displayType('inline');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Dela rad med andra objekt');\"")."
				".elements::button("tool_display_block.png", ["js", "tools_displayType('block');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup('Visa ensam på rad');\"")."
			</form>", "attr" => " class=\"tool\""]);
		self::tool(["header" => "Bild", "content" => "<form onsubmit=\"return false;\" id=\"tools_urlDiv\"><script>tools_loadTool(obj('tools_urlDiv').parentNode.parentNode, 'IMG'); obj('tools_urlDiv').parentNode.parentNode.classList.add('tool'); </script>
				".$imgText."
			</form>"]);
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
		
		echo(elements::group(elements::writeTable($tools, "v"), true, "Redigera", "tools_editTools", "", "tool"));
		$codeTools = ["header" => ["<p><b>Kod</b></p>"], 
		"<textarea id=\"codearea\" style=\"resize: vertical;\"></textarea><br /><input type=\"button\" onclick=\"tools_updateCode();\" value=\"Uppdatera\" />"];
		echo(elements::group(elements::writeTable($codeTools, "v"), true, "Kod", "tools_code", "onload=\"tools_disable(this);\"", "tool"));
		echo("</div>");
	}
	static public function isEditable() {
		$page = sql::get("SELECT * FROM pages WHERE url = '".$_SESSION["page"]."'");
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
