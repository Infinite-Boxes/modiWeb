<?php
class lang {
	public static function getText($name) {
		return sql::get("SELECT val FROM ".Config::dbPrefix()."lang WHERE name = '".$name."' AND lang = '".$_SESSION["lang"]."'")["val"];
		
	}
	public static function getLangs() {
		return sql::get("SELECT name,val FROM ".Config::dbPrefix()."languages");
	}
}