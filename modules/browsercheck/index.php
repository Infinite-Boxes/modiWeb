<?php
class browsercheck {
	static private $browser;
	static public function init() {
		$browser = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($browser, 'MSIE') !== FALSE) {
			$browser = "ie".substr($browser, strpos($browser, 'MSIE')+5, 2);
			if(substr($browser, 3, 1) === ".") {
				$browser = substr($browser, 0, -1);
			}
				if((substr($browser, 0, 2) == "ie") && (substr($browser, 2) <= 8)) {
					msg::notice("Du använder en gammal version av Internet Explorer. Sidan kanske inte visas korrekt");
				}
		} elseif(strpos($browser, 'Trident') !== FALSE) { //For Supporting IE 11
			$browser = "ie11";
		} elseif(strpos($browser, 'Firefox') !== FALSE) {
			$browser = "ff";
		} elseif(strpos($browser, 'Chrome') !== FALSE) {
			$browser = "chrome";
		} elseif(strpos($browser, 'Opera') !== FALSE) {
			$browser = "opera";
		} elseif(strpos($browser, 'Safari') !== FALSE) {
			$browser = "safari";
		} else {
			$browser = false;
		}
		if($browser !== false) {
			self::$browser = $browser;
		} else {
			self::$browser = false;
		}
	}
	static public function get() {
		return self::$browser;
	}
}
browsercheck::init();