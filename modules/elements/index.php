<?php
class elements {
	public static function write($type, $id = "", $parameters = "") {
		if($parameters != "") {
			$parameters = " ".$parameters;
		}
		echo("<".$type.$parameters.">".(sql::get("SELECT text FROM texts WHERE name = '".$id."'")["text"])."</".$type.">");
	}
}