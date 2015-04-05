<?php
class lang {
	public static function getText($name) {
		return sql::get("SELECT val FROM ".Config::dbPrefix()."lang WHERE name = '".$name."' AND lang = '".$_SESSION["lang"]."'")["val"];
		
	}
}