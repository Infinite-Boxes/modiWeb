<?php
class users {
	public static function get($name) {
		$user = [];
		if($name == "all") {
			$c1 = sql::get("SELECT * FROM users");
			if(isset($c1[0])) {
				if(gettype($c1[0]) == "array") {
					foreach($c1 as $k => $v) {
						$c2 = sql::get("SELECT * FROM contactdetails WHERE id = ".$v["contactid"].";");
						array_push($user, ["base" => $v, "contactdetails" => $c2]);
					}
				} else {
					$c2 = sql::get("SELECT * FROM contactdetails WHERE id = ".$c1["contactid"].";");
					array_push($user, ["base" => $c1, "contactdetails" => $c2]);
				}
			} elseif(count($c1) > 1) {
				$user["base"] = $c1;
				$user["contactdetails"] = sql::get("SELECT * FROM contactdetails WHERE id = '".$c1["contactid"]."';");
			} else {
				$user = "Tomt";
			}
		} else {
			$user["base"] = sql::get("SELECT * FROM users WHERE username = '".$name."';");
			$user["contactdetails"] = sql::get("SELECT * FROM contactdetails WHERE id = '".$user["base"]["contactid"]."';");
		}
		return $user;
	}
	public static function add($user) {
		$n = [];
		$n[0] = "firstname";
		$n[1] = "middlenames";
		$n[2] = "sirname";
		$n[3] = "ssn";
		$n[4] = "address";
		$n[5] = "town";
		$n[6] = "country";
		$inserts = [];
		foreach($n as $k => $v) {
			if(isset($user[$v])) {
				$inserts[$v] = $user[$v];
			} else {
				$inserts[$v] = "";
			}
		}
		$keys = "";
		$vals = "";
		$c = 0;
		foreach($inserts as $k => $v) {
			if($c != 0) {
				$keys .= ", ";
				$vals .= ", ";
			}
			$keys .= $k;
			$vals .= "'".$v."'";
			$c++;
		}
		$id = sql::insert("INSERT INTO contactdetails (".$keys.") VALUES (".$vals.")");
		unset($n);
		unset($inserts);
		unset($keys);
		unset($vals);
		$n = [];
		$n[0] = "username";
		$n[1] = "password";
		$n[2] = "lang";
		$inserts = [];
		foreach($n as $k => $v) {
			if(isset($user[$v])) {
				$inserts[$v] = $user[$v];
			} else {
				$inserts[$v] = "";
			}
		}
		$keys = "";
		$vals = "";
		$c = 0;
		foreach($inserts as $k => $v) {
			if($c != 0) {
				$keys .= ", ";
				$vals .= ", ";
			}
			$keys .= $k;
			$vals .= "'".$v."'";
			$c++;
		}
		$ok = sql::insert("INSERT INTO users (contactid, ".$keys.") VALUES ('".$id."', ".$vals.")");
	}
}
?>