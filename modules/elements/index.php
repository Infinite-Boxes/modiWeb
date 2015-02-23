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
	public static function write($type, $id = "", $parameters = "") {
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
		echo("<".$type.$parameters.">".$id."</".$type.">");
	}
	public static function writeTable($content, $type = "horizontal") {
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
			echo("<table class=\"tablehorizontal\">
");
			if($multiDim == false) {
				foreach($content as $k => $v) {
					if(substr($k, 0, 4) == "null") {
						$k = "";
					}
					echo("	<tr>
			<td><p class=\"bold\">".$k."<p /></td>
			<td>".$v."</td>
		</tr>
	");
				}
			} else {
				foreach($content as $k => $v) {
					echo("	<tr>
			<th><p class=\"bold\">".$k."<p /></th>
	");
					foreach($v as $v2) {
						echo("		<td>".$v2."</td>
	");
					}
					echo("	</tr>
	");
				}
			}
		} else {
			echo("<table class=\"tablevertical\">
");
			echo("<tr>");
			foreach($content[0] as $k => $v) {
				echo("<th><p class=\"bold\">".$k."</p></th>");
			}
			echo("</tr>");
			foreach($content as $k => $v) {
				echo("<tr>");
				foreach($v as $k2 => $v2) {
					echo("<td><p>".$v2."</p></td>");
				}
				echo("</tr>");
			}
		}
		echo("</table>
");
	}
}