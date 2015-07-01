<?php
class cronjobs {
	private static $jobs;
	public static function init() {
		$jobs = sql::get("SELECT * FROM ".Config::dbPrefix()."cronjobs WHERE finished = 0 ORDER BY time");
		if(isset($jobs["id"])) {
			$jobs = [$jobs];
		}
		if($jobs !== false) {
			foreach($jobs as $v) {
				self::$jobs[$v["name"]] = [
					"type" => $v["type"], 
					"time" => $v["time"], 
					"rule" => $v["rule"], 
					"func" => $v["func"]
				];
			}
		}
		self::run();
	}
	private static function run() {
		foreach(self::$jobs as $v) {
			if($v["type"] === "ONCE") {
				$jobTime = $v["time"];
				if(time() < $jobTime) {
					continue;
				}
			}
			$caller = explode("::", $v["func"])[0];
			$func = substr(explode("::", $v["func"])[1], 0, strpos(explode("::", $v["func"])[1], "("));
			$args = substr(explode("::", $v["func"])[1], strpos(explode("::", $v["func"])[1], "(")+1, -1);
			$args = explode(",", $args);
			foreach($args as $k2 => $v2) {
				$args[$k2] = trim($v2, '"');
			}
			call_user_func([$caller, $func], $args);
		}
	}
	public static function getJobs() {
		return self::$jobs;
	}
	public static function getMailJobs() {
		$jobs = [];
		foreach(self::$jobs as $k => $v) {
			if(substr($v["func"], 0, 14) === "mail::sendPage") {
				$jobs[$k] = $v;
			}
		}
		return $jobs;
	}
	public static function test($txt) {
		define("test", $txt[0]);
	}
}
