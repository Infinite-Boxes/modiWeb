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
}