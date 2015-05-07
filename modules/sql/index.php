<?php
class sql {
	private static $pdo;
	public static function init() {
		$db = Config::getDB();
		$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
		self::$pdo = new PDO($db["dsn"], $db["user"], $db["pass"], $options);
	}
	private static function sanitize($q, $type = true) {
		$rep = [];
		$rep[0] = [";", "pass"];
		$rep[0] = ["AND", ""];
		$rep[0] = ["OR", ""];
		$rep[0] = ["SELECT", ""];
		$rep[0] = ["FROM", ""];
		$dangers = [];
		foreach($rep as $k => $v) {
			$explode = explode(":", $v[1]);
			if((in_array($type, $explode)) || ($type === true)) {
				array_push($dangers, $v[0]);
			}
		}
		if(gettype($q) === "array") {
			foreach($q as $k => $v) {
				$k = str_ireplace($dangers, "", $k);
			}
		}
		return $q;
	}
	static public function sanitizePosts($vars, $posts) {
		foreach($vars as $k => $v) {
			if(isset($posts[$v])) {
				$posts[$v] = self::sanitize($posts[$v]);
			}
		}
		return $posts;
	}
	public static function get($q) {
		$q = str_replace(";", "", $q);
		$todo = self::$pdo->prepare($q.";");
		$todo->setFetchMode(PDO::FETCH_ASSOC);
		$todo->execute();
		if($todo->rowCount() > 1) {
			return $todo->fetchAll();
		} elseif($todo->rowCount() == 1) {
			return $todo->fetch();
		} else {
			return false;
		}
	}
	public static function insert($q) {
		$q = str_replace(";", "", $q);
		$todo = self::$pdo->prepare($q.";");
		$todo->execute();
		if($todo->rowCount() == 1) {
			return self::$pdo->lastInsertId();
		} else {
			return $todo->errorInfo();
		}
	}
	public static function upd($q) {
		$q = str_replace(";", "", $q);
		$todo = self::$pdo->prepare($q.";");
		$ret = $todo->execute();
		if($ret === true) {
			return true;
		} else {
			return $todo->errorInfo();
		}
	}
	public static function del($q) {
		$q = str_replace(";", "", $q);
		$todo = self::$pdo->prepare($q.";");
		$ret = $todo->execute();
		return $ret;
	}
}
sql::init();
?>