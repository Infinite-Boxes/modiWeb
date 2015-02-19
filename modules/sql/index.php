<?php
class sql {
	private static $pdo;
	public static function init() {
		$db = Config::getDB();
		$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
		self::$pdo = new PDO($db["dsn"], $db["user"], $db["pass"], $options);
	}
	public static function get($q) {
		$todo = self::$pdo->prepare($q);
		$todo->setFetchMode(PDO::FETCH_ASSOC);
		$todo->execute();
		if($todo->rowCount() > 1) {
			return $todo->fetchAll();
		} else {
			return $todo->fetch();
		}
	}
	public static function insert($q) {
		$todo = self::$pdo->prepare($q);
		$todo->execute();
		if($todo->rowCount() == 1) {
			return self::$pdo->lastInsertId();
		} else {
			return false;
		}
	}
}
sql::init();
?>