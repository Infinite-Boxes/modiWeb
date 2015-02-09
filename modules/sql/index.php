<?php
class sql {
	private static $pdo;
	public static function start() {
		$db = Config::getDB();
		$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
		self::$pdo = new PDO($db["dsn"], $db["user"], $db["pass"], $options);
	}
	public static function get($q) {
		$todo = self::$pdo->prepare($q);
		$todo->execute();
		if($todo->rowCount() > 1) {
			return $todo->fetchAll();
		} elseif($todo->rowCount() > 1) {
			return $todo->fetchAll();
		} else {
			return $todo->fetch();
		}
	}
}
sql::start();
?>