<?php
class base {
	static public function stringSafe($str) {
		return urlencode(utf8_decode($str));//str_replace($k, $v, $str);
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
}