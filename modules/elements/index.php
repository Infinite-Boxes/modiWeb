<?php
class elements {
	public static function keyName($id) {
		$t = sql::get("SELECT * FROM texts WHERE name = '".$id."'");
		return $t;
	}
	public static function keyId($id) {
		$t = sql::get("SELECT * FROM texts WHERE id = '".$id."'");
		return $t;
	}
	public static function write($type = "", $id = "", $parameters = "") {
		if($parameters != "") {
			$parameters = " ".$parameters;
		}
		$t = sql::get("SELECT name,id FROM texts");
		$texts = [];
		foreach($t as $k => $v) {
			array_push($texts, ["name" => $v["name"], "id" => $v["id"]]);
		}
		foreach($texts as $k => $v) {
			if(isset($_SESSION["user"])) {
				$id = str_ireplace("!:!".$v["name"]."!:!", "<a href=\"#\" class=\"edit\" onclick=\"edit(".$v["id"].");\">".sql::get("SELECT content FROM texts WHERE name = '".$v["name"]."';")["content"]."</a>", $id);
			} else {
				$id = str_ireplace("!:!".$v["name"]."!:!", sql::get("SELECT content FROM texts WHERE name = '".$v["name"]."';")["content"], $id);
			}
		}
		if($type != "") {
			echo("<".$type.$parameters.">".$id."</".$type.">");
		} else {
			echo($id);
		}
	}
	public static function keyReplace($type = "", $id = "", $parameters = "") {
		if($parameters != "") {
			$parameters = " ".$parameters;
		}
		$t = sql::get("SELECT name,id FROM texts");
		$texts = [];
		foreach($t as $k => $v) {
			array_push($texts, ["name" => $v["name"], "id" => $v["id"]]);
		}
		foreach($texts as $k => $v) {
			if(isset($_SESSION["user"])) {
				$id = str_ireplace("!:!".$v["name"]."!:!", "<a href=\"#\" class=\"edit\" onclick=\"edit(".$v["id"].");\">".sql::get("SELECT content FROM texts WHERE name = '".$v["name"]."';")["content"]."</a>", $id);
			} else {
				$id = str_ireplace("!:!".$v["name"]."!:!", sql::get("SELECT content FROM texts WHERE name = '".$v["name"]."';")["content"], $id);
			}
		}
		if($type != "") {
			return "<".$type.$parameters.">".$id."</".$type.">";
		} else {
			return $id;
		}
	}
	public static function editReplace($text, $linked = true) {
		$t = sql::get("SELECT name,id FROM texts");
		$texts = [];
		foreach($t as $k => $v) {
			array_push($texts, ["name" => $v["name"], "id" => $v["id"]]);
		}
		$idtext = "";
		$idc = 0;
		foreach($texts as $k => $v) {
			if($linked === true) {
				$link1 = "<a href=\"#\" class=\"edit\" onclick=\"edit(".$v["id"].");\">";
				$link2 = "</a>";
			} else {
				$link1 = "";
				$link2 = "";
			}
			$idtext .= "var el".$idc." = '".$v["name"]."';
";
			$idc++;
			$text = str_ireplace("!:!".$v["name"]."!:!", $link1.sql::get("SELECT content FROM texts WHERE name = '".$v["name"]."';")["content"].$link2, $text);
		}
		$replace1 = [];
		$replace2 = [];
		array_push($replace1, "!b!");array_push($replace2, "<div>");
		array_push($replace1, "!e!");array_push($replace2, "</div>");
		$text = str_ireplace($replace1, $replace2, $text);
		$text .= "\";
".$idtext;
		return $text;
	}
	public static function writeTable($content, $type = "horizontal", $attr = "", $withKeys = true) {
		$ret = "";
		/*
		$t = sql::get("SELECT name FROM texts");
		$texts = [];
		foreach($t as $k => $v) {
			array_push($texts, $v["name"]);
		}
		foreach($texts as $k => $v) {
			$id = str_ireplace("!:!".$v."!:!", sql::get("SELECT content FROM texts WHERE name = '".$v."';")[0], $id);
		}
		echo("<".$type.$parameters.">".$id."</".$type.">");*/
		if($attr !== "") {
			$attr = " ";
		}
		$multiDim = false;
		foreach($content as $v) {
			if(is_array($v)){
				$multiDim = true;
			}
		}
		if($type == "horizontal") {
			$ret .= "<table class=\"tablehorizontal\"".$attr.">
";
			foreach($content as $k => $v) {
				if(count($v) > 1) {
					$line = $content[$k]["text"];
					$rowAtt = " ".$content[$k]["attr"];
				} else {
					$line = $v;
					$rowAtt = "";
				}
				if(substr($k, 0, 4) == "null") {
					$k = "";
				}
				$ret .= "	<tr>";
				if($withKeys == true) {
					$ret .= "<td".$rowAtt."><p class=\"bold\">".$k."<p /></td>";
				}
				$ret .= "<td".$rowAtt."><p>".$line."</p></td>
	</tr>
";
			}
		} else {
			$ret .= "<table class=\"tablevertical\"".$attr.">";
			if($withKeys == true) {
				$ret .= "<tr>";
				foreach($content[0] as $k => $v) {
					$ret .= "<th><p class=\"bold\">".$k."</p></th>
";
				}
				$ret .= "</tr>
";
			}
			foreach($content as $k => $v) {
				$ret .= "<tr>
";
				foreach($v as $k2 => $v2) {
					$ret .= "<td><p>".$v2."</p></td>
";
				}
				$ret .= "</tr>
";
			}
		}
		$ret .= "</table>
";
		return $ret;
	}
	public static function group($content, $title = false, $id = false) {
		if($id !== false) {
			$idt = " id=\"".$id."\"";
		} else {
			$idt = "";
		}
		if($title != false) {
			return "<div class=\"group\"".$idt."><div class=\"grouptitle\" onclick=\"groupMinimize(this);\"><h3>".$title."</h3></div><div class=\"groupcontent\">".$content."</div></div>";
		}
	}
	public static function link($content, $href) {
		return "<a href=\"".$href."\">".$content."</a>";
	}
	public static function button($img, $link, $class = "", $attr = "", $attr2 = "") {
		if($attr !== "") {
			$attr = " ".$attr;
		}
		if($attr2 !== "") {
			$attr2 = " ".$attr2;
		}
		if($class !== "") {
			$class = " ".$class;
		}
		if($link[0] == "a") {
			return "<a href=\"".$link[1]."\"".$attr2." class=\"".$class."\"><img src=\"img/".$img."\"".$attr." /></a>";
		} elseif($link[0] == "js") {
			return "<img src=\"img/".$img."\" class=\"imgbutton".$class."\" onclick=\"".$link[1]."\"".$attr." />";
		}
	}
}
