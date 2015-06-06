<?php
class elements {
	public static function keyName($id) {
		$t = sql::get("SELECT * FROM ".Config::dbPrefix()."texts WHERE name = '".$id."'");
		return $t;
	}
	public static function keyId($id) {
		$t = sql::get("SELECT * FROM ".Config::dbPrefix()."texts WHERE id = '".$id."'");
		return $t;
	}
	public static function write($type = "", $id = "", $parameters = "") {
		if($parameters != "") {
			$parameters = " ".$parameters;
		}
		$t = sql::get("SELECT name,id FROM ".Config::dbPrefix()."texts");
		$texts = [];
		foreach($t as $k => $v) {
			array_push($texts, ["name" => $v["name"], "id" => $v["id"]]);
		}
		foreach($texts as $k => $v) {
			if((isset($_SESSION["user"])) && (page::isEditable() === true)) {
				$id = str_ireplace("!:!".$v["name"]."!:!", "<a href=\"#\" class=\"edit\" onclick=\"edit(".$v["id"].");\">".sql::get("SELECT content FROM ".Config::dbPrefix()."texts WHERE name = '".$v["name"]."';")["content"]."</a>", $id);
			} else {
				$id = str_ireplace("!:!".$v["name"]."!:!", sql::get("SELECT content FROM ".Config::dbPrefix()."texts WHERE name = '".$v["name"]."';")["content"], $id);
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
		$t = sql::get("SELECT name,id FROM ".Config::dbPrefix()."texts");
		$texts = [];
		foreach($t as $k => $v) {
			array_push($texts, ["name" => $v["name"], "id" => $v["id"]]);
		}
		foreach($texts as $k => $v) {
			if(isset($_SESSION["user"])) {
				$id = str_ireplace("!:!".$v["name"]."!:!", "<a href=\"#\" class=\"edit\" onclick=\"edit(".$v["id"].");\">".sql::get("SELECT content FROM ".Config::dbPrefix()."texts WHERE name = '".$v["name"]."';")["content"]."</a>", $id);
			} else {
				$id = str_ireplace("!:!".$v["name"]."!:!", sql::get("SELECT content FROM ".Config::dbPrefix()."texts WHERE name = '".$v["name"]."';")["content"], $id);
			}
		}
		if($type != "") {
			return "<".$type.$parameters.">".$id."</".$type.">";
		} else {
			return $id;
		}
	}
	public static function editReplace($text, $linked = true) {
		$t = sql::get("SELECT name,id FROM ".Config::dbPrefix()."texts");
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
			$text = str_ireplace("!:!".$v["name"]."!:!", $link1.sql::get("SELECT content FROM ".Config::dbPrefix()."texts WHERE name = '".$v["name"]."';")["content"].$link2, $text);
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
	public static function writeTable($content, $type = "h", $tAtt = "") {
		$ret = "";
		/*
		table[
			cont[
				header[],
				content[
					text,
					cAtt
				]
			],
			type,
			tAtt
		]
		*/
		if($tAtt !== "") {
			if(isset($tAtt["class"])) {
				$tClass = " ".$tAtt["class"];
				$tAtt = " ".$tAtt["att"];
			} else {
				$tClass = "";
				$tAtt = " ".$tAtt;
			}
		} else {
			$tAtt = "";
			$tClass = "";
		}
		if($type == "h") {
			$ret .= "<table class=\"tablehorizontal".$tClass."\"".$tAtt.">";
			if(isset($content["header"])) {
				$ret .= "<tr>";
				if(!isset(current($content["header"])["text"])) {
					foreach($content["header"] as $k => $v) {
						$ret .= "<th>".$v."</th>";
					}
				} else {
					foreach($content["header"] as $k => $v) {
						if($v["att"] != "") {
							$hAtt = " ".$v["att"];
						} else {
							$hAtt = "";
						}
						$ret .= "<th".$hAtt.">".$v["text"]."</th>";
					}
				}
				$ret .= "</tr>";
			}
			unset($content["header"]);
			foreach($content as $rowKey => $row) {
				$ret .= "<tr>";
				if(!is_array($row)) {
					$ret .= "<td>".$row."</td>";
				} else {
					foreach($row as $cellKey => $cell) {
						if(is_array($cell)) {
							if($cell["att"] != "") {
								$cAtt = " ".$cell["att"];
							} else {
								$cAtt = "";
							}
							$out = $cell["text"];
						} else {
							$cAtt = "";
							$out = $cell;
						}
						$ret .= "<td".$cAtt.">".$out."</td>";
					}
				}
				$ret .= "</tr>";
			}
			$ret .= "</table>";
		} else {
			$ret .= "<table class=\"tablevertical".$tClass."\"".$tAtt.">";
			if(isset($content["header"])) {
				$header = $content["header"];
				$theContent = $content;
				unset($theContent["header"]);
				if(is_array($theContent[0])) {
					foreach($header as $key => $row) {
						$ret .= "<tr>";
						if(is_array($row)) {
							if($row["att"] != "") {
								$thAtt = " ".$row["att"];
							} else {
								$thAtt = " ".$row["att"];
							}
							$ret .= "<th".$thAtt.">".$row["text"]."</th>";
						} else {
							$ret .= "<th>".$row."</th>";
						}
						foreach($theContent[$key] as $key2 => $text) {
							if(is_array($text)) {
								if($text["att"] != "") {
									$cAtt = " ".$text["att"];
								} else {
									$cAtt = "";
								}
								$ret .= "<td".$cAtt.">".$text["text"]."</td>";
							} else {
								$ret .= "<td>".$text."</td>";
							}
						}
						$ret .= "</tr>";
					}
				} else {
					foreach($header as $key => $row) {
						$ret .= "<tr>";
						$ret .= "<th>".$row."</th>";
						if(isset($theContent[$key])) {
							$ret .= "<td>".$theContent[$key]."</td>";
						} else {
							$ret .= "<td></td>";
						}
						$ret .= "</tr>";
					}
				}
			} else {
				$ret .= "<tr>";
				foreach($content as $k => $v) {
					if(is_array($v)) {
						foreach($row as $key => $text) {
							$ret .= "<td>".$text."</td>";
						}
					} else {
						$ret .= "<td>".$v."</td>";
					}
				}
				$ret .= "</tr>";
			}
			$ret .= "</table>";
		}
		
		return $ret;
	}
	public static function group($content, $minimizable = false, $title = false, $id = false, $attr = false, $class = false, $contentAttr = false) {
		if($id !== false) {
			$idt = " id=\"".$id."\"";
		} else {
			$idt = "";
		}
		if($attr !== false) {
			$attr = " ".$attr;
		} else {
			$attr = "";
		}
		if($class !== false) {
			$class = " ".$class;
		} else {
			$class = "";
		}
		if($contentAttr !== false) {
			$contentAttr = " ".$contentAttr;
		} else {
			$contentAttr = "";
		}
		if($minimizable === true) {
			$minimize = " onclick=\"groupMinimize(this);\" onmouseover=\"popup('Minimera');\"";
		} else {
			$minimize = "";
		}
		if($title != false) {
			return "<div class=\"group".$class."\"".$idt.$attr."><div class=\"grouptitle\"".$minimize."><h3>".$title."</h3></div><div class=\"groupcontent\"".$contentAttr.">".$content."</div></div>
";
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
			return "<a href=\"".$link[1]."\"".$attr2." class=\"".$class."\"><img src=\"img/".$img."\" class=\"imgbutton\"".$attr." /></a>";
		} elseif($link[0] == "js") {
			return "<img src=\"img/".$img."\" class=\"imgbutton".$class."\" onclick=\"".$link[1]."\"".$attr." />";
		}
	}
	public static function checkbox($name, $yesVal = "true", $noVal = "false", $img = false, $js = "") {
		if($img !== false) {
			$image = "<img src=\"".$img."\">";
			$border = " class=\"bordered\"";
		} else {
			$image = "";
			$border = "";
		}
		return "<div id=\"".$name."\" onclick=\"clickCheckbox(this, '".$yesVal."', '".$noVal."');".$js."\"".$border."><input type=\"hidden\" name=\"".$name."\" value=\"".$noVal."\"><img src=\"img/checkbox_15.png\">".$image."<script>loadCheckbox('".$name."', '".$yesVal."', '".$noVal."');</script></div>";
	}
	public static function inputChoice($name, $choices) {
		$ret = "<noscript><select name=\"".$name."\">";
		foreach($choices as $v) {
			$ret .= "<option value=\"".$v[1]."\">".$v[0]."</option>";
		}
		$ret .= "<div class=\"noscript\"></noscript>";
		$ret .= "<div class=\"inputChoice\">";
		$ret .= "<input type=\"hidden\" name=\"".$name."\" value=\"".$choices[0][1]."\">";
		$ret = "";
		$c = 0;
		foreach($choices as $v) {
			$check = "";
			if($c === 0) {
				$check = " checked";
			}
			$ret .= "<input type=\"radio\" id=\"".$name.$c."\" name=\"".$name."\" value=\"".$v[1]."\"".$check."><label for=\"".$name.$c."\">".$v[0]."</label>";
			$c++;
		}
		//$ret .= "</div><noscript></div></noscript>";
		return $ret;
	}
}
