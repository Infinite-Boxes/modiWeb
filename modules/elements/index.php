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
				$id = str_ireplace("!:!".$v["name"]."!:!", "<a href=\"#\" class=\"edit\" onclick=\"edit(".$v["id"].");\">".sql::get("SELECT text FROM texts WHERE name = '".$v["name"]."';")["text"]."</a>", $id);
			} else {
				$id = str_ireplace("!:!".$v["name"]."!:!", sql::get("SELECT text FROM texts WHERE name = '".$v["name"]."';")["text"], $id);
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
				$id = str_ireplace("!:!".$v["name"]."!:!", "<a href=\"#\" class=\"edit\" onclick=\"edit(".$v["id"].");\">".sql::get("SELECT text FROM texts WHERE name = '".$v["name"]."';")["text"]."</a>", $id);
			} else {
				$id = str_ireplace("!:!".$v["name"]."!:!", sql::get("SELECT text FROM texts WHERE name = '".$v["name"]."';")["text"], $id);
			}
		}
		if($type != "") {
			return "<".$type.$parameters.">".$id."</".$type.">";
		} else {
			return $id;
		}
	}
	public static function writeTable($content, $type = "horizontal", $withKeys = true) {
		$ret = "";
		/*
		$t = sql::get("SELECT name FROM texts");
		$texts = [];
		foreach($t as $k => $v) {
			array_push($texts, $v["name"]);
		}
		foreach($texts as $k => $v) {
			$id = str_ireplace("!:!".$v."!:!", sql::get("SELECT text FROM texts WHERE name = '".$v."';")[0], $id);
		}
		echo("<".$type.$parameters.">".$id."</".$type.">");*/
		$multiDim = false;
		foreach($content as $v) {
			if(is_array($v)){
				$multiDim = true;
			}
		}
		if($type == "horizontal") {
			$ret .= "<table class=\"tablehorizontal\">
";
			if($multiDim == false) {
				foreach($content as $k => $v) {
					if(substr($k, 0, 4) == "null") {
						$k = "";
					}
					$ret .= "	<tr>";
					if($withKeys == true) {
						$ret .= "<td><p class=\"bold\">".$k."<p /></td>";
					}
					$ret .= "<td>".$v."</td>
		</tr>
	";
				}
			} else {
				foreach($content as $k => $v) {
					$ret .= "	<tr>";
					if($withKeys == true) {
						$ret .= "<th><p class=\"bold\">".$k."<p /></th>";
					}
					foreach($v as $v2) {
						$ret .= "		<td>".$v2."</td>
	";
					}
					$ret .= "	</tr>
	";
				}
			}
		} else {
			$ret .= "<table class=\"tablevertical\">";
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
	public static function group($content, $title = false) {
		if($title != false) {
			return "<div class=\"group\"><div class=\"grouptitle\"><h3>".$title."</h3></div><div class=\"groupcontent\">".$content."</div></div>";
		}
	}
	public static function link($content, $href) {
		return "<a href=\"".$href."\">".$content."</a>";
	}
}