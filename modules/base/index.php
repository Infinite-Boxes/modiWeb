<?php
class base {
	private static $sortKey = false;
	static public function init() {
		Config::addSnippet("LoadingTime", "loadTime");
	}
	static public function o($var) {
		echo("<pre>");
		print_r($var);
		echo("</pre>");
	}
	static public function loadTime() {
		return "<p class=\"loadingTimeText\">".lang::getText("loadtime1")." ".round(microtime(true)-SCRIPTTIME, 3)." ".lang::getText("loadtime2")."</p>";
	}
	static public function stringSafe($str) {
		return urlencode(utf8_decode($str));//str_replace($k, $v, $str);
	}
	static private function sortByFunction($a, $b) {
		$ret = 0;
		if(isset($a[self::$sortKey])) {
			$va = $a[self::$sortKey];
		} else {
			$va = 0;
		}
		if(isset($b[self::$sortKey])) {
			$vb = $b[self::$sortKey];
		} else {
			$vb = 0;
		}
		return ($va < $vb) ? -1 : 1;
	}
	static public function sortBy($arr, $key) {
		self::$sortKey = $key;
		usort($arr, array("base", "sortByFunction"));
		return $arr;
	}
	static public function array_insert($array, $pos, $insert) {
		$pre = [];
		$post = [];
		$insert = $insert;
		$id = 0;
		$sw = false;
		foreach($array as $k => $v) {
			if($sw == false) {
				$id ++;
			}
			if($k == $pos) {
				$sw = true;
			}
		}
		$post = array_splice($array, $id);
		$pre = array_splice($array, 0, $id);
		return array_merge($pre, $insert, $post);
	}
	static public function array_move($array, $from, $to) {
		$pre = [];
		$post = [];
		$id = 0;
		$sw = false;
		foreach($array as $k => $v) {
			if($k == $from) {
				$sw = true;
			}
			if($sw == false) {
				$id ++;
			}
		}
		$toMove = array_splice($array, $id, 1);
		$array = self::array_insert($array, $to, $toMove);
		return $array;
	}
	static public function urlExists($url) {
		$file = $url;
		$file_headers = @get_headers($file);
		echo("<pre>");
		print_r($file_headers);
		echo("</pre>");
		if(!strpos($file_headers[0], '404')) {
			return true;
		} elseif(!strpos($file_headers[0], '403')) {
			return "403";
		} else {
			return false;
		}
	}
	static public function apiGet($api, $url, $vars) {
		$headers = [];
		foreach($vars as $k => $v) {
			$headers[] = $k.": ".$v;
		}
		if($api === "klarna") {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, "curl/7.35.0");
			//curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$output = curl_exec($ch);
			if($output === false) {
				$ret = lang::getText("error"); // curl_error($ch));
			} else {
				$ret = JSON_decode($output);
			}
			curl_close($ch);
		}
		return $ret;
	}
	static public function session($key) {
		if(isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return null;
		}
	}
	static private function stringLikeness($v1, $v2) {
		$v1 = strtolower($v1);
		$v2 = strtolower($v2);
		$totLen = strlen($v1)+strlen($v2);
		$percent = similar_text($v1, $v2, $percent)/$totLen;
		return ($percent*$percent*$percent*$percent)*100;
	}
	static private function searchDocument($q, $doc) {
		$mode = true;
		$doc = strip_tags(preg_replace("#<[^>]+>#", "-", $doc));
		$words = explode(" ", $doc);
		$points = [];
		$repl = [
			".",
			",",
			";",
			":",
			"!",
			"?"
		];
		$qs = explode(" ", $q);
		for($c = 0; $c < substr_count(strtolower($doc), strtolower($q)); $c++) {
			for($count = 0; $count < count($words)*0.5; $count++) {
				$points[] = 100;
			}
		}
		for($c = 0; $c < substr_count($doc, $q); $c++) {
			for($count = 0; $count < count($words)*0.5; $count++) {
				$points[] = 100;
			}
		}
		foreach($qs as $ql) {
			for($c = 0; $c < substr_count(strtolower($doc), $ql); $c++) {
				$points[] = 100;
			}
			foreach($words as $v) {
				if($v !== "") {
					$v = str_replace($repl, "", $v);
					//echo($v.": ".round(self::stringLikeness($v, $ql))."<br>");
					$points[] = self::stringLikeness($v, $ql)*(100/6);
				}
			}
		}
		if(count($points) !== 0) {
			$points = array_sum($points)/count($points);
		} else {
			$points = 0;
		}
		return $points;
	}
	static private function searchSort($a, $b) {
		if($a["searchPoints"] === $b["searchPoints"]) {
			return 0;
		}
		return ($a["searchPoints"] > $b["searchPoints"]) ? -1 : 1;
	}
	static public function search($q) {
		$filePages = moduleManifest::getModVal("menu");
		$pages = [];
		foreach($filePages as $k => $v) {
			if(isset($v["searchable"])) {
				if($v["searchable"] === false) {
					unset($filePages[$k]);
				}
			}
			if(isset($v["type"])) {
				if($v["type"] !== "file") {
					unset($filePages[$k]);
				}
			}
		}
		$userPages = sql::get("SELECT name,url,content FROM ".Config::dbPrefix()."pages WHERE searchable = 1");
		if((count($userPages) < 2) && ($userPages !== false)) {
			$userPages = [$userPages];
		}
		if($userPages !== false) {
			foreach($userPages as $k => $v) {
				$points  = self::searchDocument($q, $v["content"]);
				array_push($pages, ["type" => "page", "url" => $v["url"], "name" => $v["name"], "searchPoints" => $points]);
			}
		}
		foreach($filePages as $k => $v) {
			$url = $v["link"];
			$points  = self::searchDocument($q, file_get_contents(moduleManifest::menuModule($v["link"])["file"]));
			array_push($pages, ["type" => "page", "url" => $url, "name" => $v["name"], "searchPoints" => $points]);
		}
		foreach(moduleManifest::getModVal("search") as $v) {
			array_push($pages, ["type" => $v["type"], "url" => $v["url"], "name" => $v["name"], "searchPoints" => self::searchDocument($q, $v["txt"])]);
		}
		foreach($pages as $k => $v) {
			if($v["searchPoints"] < 5) {
				unset($pages[$k]);
			}
		}
		usort($pages, array("base", "searchSort"));
		return $pages;
	}
	static public function adminError($cat, $type, $txt) {
		
	}
}