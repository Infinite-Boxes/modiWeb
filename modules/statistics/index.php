<?php
class statistics {
	public static function rec() {
		$val = [];
		$val["ip"] = $_SERVER['REMOTE_ADDR'];
		$val["script"] = $_SERVER["SCRIPT_NAME"];
		$val["page"] = PAGE;
		$val["site"] = SITEPATH;
		$val["gets"] = str_replace("\"", "'", JSON_encode($_GET));
		$val["posts"] = str_replace("\"", "'", JSON_encode($_POST));
		$str = "";
		foreach($val as $k => $v) {
			if($str == "") {
				$str .= "?".$k."=".urlEncode($v);
			} else {
				$str .= "&".$k."=".urlEncode($v);
			}
		}
		return $str;//str_replace("\"", "'", JSON_encode($v));
	}
	public static function getList() {
		$ret = [];
		$ipList = sql::get("SELECT ip FROM ".Config::dbPrefix()."statistics LIMIT 0,50");
		if($ipList != false) {
			if(isset($ipList["ip"])) {
				$ret[$ipList["ip"]] = [];
				$ret[$ipList["ip"]]["ip"] = $ipList["ip"];
				$parts = sql::get("SELECT MAX(time) AS lastTime, COUNT(page) AS pages FROM ".Config::dbPrefix()."statistics WHERE ip = '".$ipList["ip"]."' LIMIT 0,50");
				$ret[$ipList["ip"]]["time"] = $parts["lastTime"];
				$ret[$ipList["ip"]]["pages"] = count(sql::get("SELECT page FROM ".Config::dbPrefix()."statistics WHERE ip = '".$ipList["ip"]."' GROUP BY page LIMIT 0,50"));
				$lp = sql::get("SELECT page FROM ".Config::dbPrefix()."statistics WHERE ip = '".$ipList["ip"]."' AND page != '' GROUP BY page ORDER BY time ASC LIMIT 0,50");
				if(isset($lp["page"])) {
					$ret[$ipList["ip"]]["lastPage"] = $lp["page"];
				} else {
					$ret[$ipList["ip"]]["lastPage"] = $lp[0]["page"];
				}
			} else {
				foreach($ipList as $k => $v) {
					$ret[$v["ip"]] = [];
					$ret[$v["ip"]]["ip"] = $v["ip"];
					$parts = sql::get("SELECT MAX(time) AS lastTime, COUNT(page) AS pages FROM ".Config::dbPrefix()."statistics WHERE ip = '".$v["ip"]."' LIMIT 0,50");
					$ret[$v["ip"]]["time"] = $parts["lastTime"];
					$ret[$v["ip"]]["pages"] = count(sql::get("SELECT page FROM ".Config::dbPrefix()."statistics WHERE ip = '".$v["ip"]."' GROUP BY page LIMIT 0,50"));
					$lp = sql::get("SELECT page FROM ".Config::dbPrefix()."statistics WHERE ip = '".$v["ip"]."' GROUP BY page ORDER BY time ASC LIMIT 0,50");
					if(isset($lp["page"])) {
						$ret[$v["ip"]]["lastPage"] = $lp["page"];
					} else {
						$ret[$v["ip"]]["lastPage"] = $lp[0]["page"];
					}
				}
			}
		} else {
			$ret = false;
		}
		return $ret;
	}
}
