<?php
class page {
	static private $keys = [];
	static private $vals = [];
	static public function write($page = "") {
		$out = sql::get("SELECT * FROM pages WHERE url = '".$page."';");
		if($out != false) {
			$out["content"] = elements::keyReplace("", $out["content"], "");
			self::ak("!b!", "<div class=\"floater\">");
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
}
