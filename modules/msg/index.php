<?php
class msg {
	public static function init() {
		if(!isset($_SESSION["notice"])) {
			$_SESSION["notice"] = [];
		}
		if(!isset($_SESSION["warning"])) {
			$_SESSION["warning"] = [];
		}
	}
	public static function notice($msg) {
		array_push($_SESSION["notice"], $msg);
	}
	public static function warning($msg) {
		array_push($_SESSION["warning"], $msg);
	}
	public static function get() {
		$ret = ["warnings" => $_SESSION["warning"], "notices" => $_SESSION["notice"]];
		$_SESSION["warning"] = [];
		$_SESSION["notice"] = [];
		return $ret;
	}
}
