<?php
class page {
	static private $keys = [];
	static private $vals = [];
	static private $temp = 0;
	static public function write($page = "") {
		$out = sql::get("SELECT * FROM pages WHERE url = '".$page."';");
		if($out != false) {
			$out["content"] = elements::keyReplace("", $out["content"], "");
			self::ak("!b!", "<div>");
			self::ak("!e!", "</div>");
			echo(str_replace(self::$keys, self::$vals, $out["content"]));
		} else {
			echo("tom");
		}
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
		$r1 = [];
		$r2 = [];
		self::$temp = -1;
		//array_push($r1, "!b!");array_push($r2, "<div id='".self::editorContentID()."' onclick='tools_mark(this);'>");
		while(strpos($content, "!b!") !== false) {
			$content = substr_replace($content, "<div id='".self::editorContentID()."' onclick='tools_mark(this);'>", strpos($content, "!b!"), 3);
		}
		array_push($r1, "!e!");array_push($r2, "</div>");
		$content = str_replace($r1, $r2, $content);
		$content = elements::editReplace($content, false);
		return $content;
	}
	static public function editorContentLines($content) {
		return substr_count($content, "!b!");
	}
	static public function menu() {
		echo("<div class=\"pageeditmenu\" id=\"pageeditmenu\">");
		echo(elements::write("h2", "Redigerar sida", "onclick=\"tools_minmax();\" onmouseover=\"popup(this, 'Minimera/maximera verktygslådan');\""));
		$buttons = [
			["tool_del.png", "js", "tools_del();", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Radera element');\""],
			["tool_moveup.png", "js", "tools_move('up');", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Flytta upp');\""],
			["tool_movedown.png", "js", "tools_move('down');", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Flytta ner');\""],
			["tool_save.png", "js", "tools_save();", "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Spara sidan');\""]
		];
		$mainbuttons = "";
		foreach($buttons as $v) {
			$mainbuttons .= elements::button($v[0], [$v[1], $v[2]], $v[3], $v[4]);
		}
		echo(elements::group("<p id=\"tools_current\" class=\"only\" style=\"margin-left: 5px;\">Välj ett element</p><br />".$mainbuttons."<br />
		".elements::button("tool_add_text.png", ["js", "tools_create('P');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Lägg till text');\"").elements::button("tool_add_image.png", ["js", "tools_create('IMG');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Lägg till bild');\"").elements::button("tool_add_table.png", ["js", "tools_create('TABLE');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Lägg till tabell');\"").elements::button("tool_add_list.png", ["js", "tools_create('UL');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Lägg till lista');\""), "Huvudverktyg", "tools_mainTools"));
		$tools = [
			"Text" => "<form onsubmit=\"return false;\" id=\"tools_textDiv\"><script>tools_loadTool(obj('tools_textDiv').parentNode.parentNode, 'P H1 H2 H3'); obj('tools_textDiv').parentNode.parentNode.classList.add('tool')</script>
				<textarea id=\"toolsContent\" style=\"resize: vertical;\"></textarea>
			</form>",
			"Justera" => "<form onsubmit=\"return false;\">
				".elements::button("tool_align_left.png", ["js", "tools_align('left');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Justera till vänster');\"")."
				".elements::button("tool_align_center.png", ["js", "tools_align('center');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Justera till mitten');\"")."
				".elements::button("tool_align_right.png", ["js", "tools_align('right');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Justera till höger');\"")."
				".elements::button("tool_align_justify.png", ["js", "tools_align('justify');"], "tool", "onload=\"tools_loadTool(this, 'all');\" onmouseover=\"popup(this, 'Justera till full bredd');\"")."
			</form>",
			"Flyt" => ["text" => "<form onsubmit=\"return false;\" id=\"tools_floatDiv\"><script>tools_loadTool(obj('tools_floatDiv').parentNode.parentNode, 'IMG');obj('tools_floatDiv').parentNode.parentNode.classList.add('tool')</script>
				".elements::button("tool_float_left.png", ["js", "tools_float('left');"], "", "onmouseover=\"popup(this, 'Flyt till vänster');\"")."
				".elements::button("tool_float_right.png", ["js", "tools_float('right');"], "", "onmouseover=\"popup(this, 'Flyt till höger');\"")."
				".elements::button("tool_float_none.png", ["js", "tools_float('none');"], "", "onmouseover=\"popup(this, 'Flyt inte');\"")."
			</form>", "attr" => " class=\"tool\""]
		];
		echo(elements::group(elements::writeTable($tools).elements::button("tool_save.png", ["js", "tools_change();"], "tool",  "onmouseover=\"popup(this, 'Uppdatera text');\""), "Redigera", "tools_editTools"));
		echo("</div>");
	}
}
