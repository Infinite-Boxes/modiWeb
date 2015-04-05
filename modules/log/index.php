<?php
class log {
	public static function add($type, $message) {
		$path =  $_SERVER["DOCUMENT_ROOT"].$_SERVER["SCRIPT_NAME"];
		$vdump = print_r($GLOBALS, true);
		sql::insert("INSERT INTO ".Config::dbPrefix()."log (type, message, path, vardump) VALUES ('".$type."', '".$message."', '".$path."', '".$vdump."');");
	}
}
?>