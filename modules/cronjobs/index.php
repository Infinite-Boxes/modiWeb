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
					"upd" => $v["updated"],
					"ends" => $v["ends"], 
					"rule" => $v["rule"], 
					"func" => $v["func"],
					"id" => $v["id"]
				];
			}
		}
		if(count(self::$jobs) !== 0) {
			self::run();
		}
	}
	private static function run() {
		$err = [];
		foreach(self::$jobs as $k => $v) {
			if(strtotime($v["time"]) >= time()) {
				continue;
			}
			$caller = explode("::", $v["func"])[0];
			$func = substr(explode("::", $v["func"])[1], 0, strpos(explode("::", $v["func"])[1], "("));
			$args = substr(explode("::", $v["func"])[1], strpos(explode("::", $v["func"])[1], "(")+1, -1);
			$args = explode(",", $args);
			foreach($args as $k2 => $v2) {
				$args[$k2] = trim($v2, '"');
			}
			$times = self::jobTimes($k);
			if($times !== false) {
				$allOk = true;
				foreach($times as $v2) {
					$ret = call_user_func([$caller, $func], $args, $v2);
					echo("trigger ".$k."<br>");
					if($ret === false) {
						$allOk = false;
					}
				}
			} else {
				$allOk = false;
			}
			if($allOk !== false) {
				if(strtotime($v["ends"]) === false) {
					$end = strtotime($v["time"]);
				} else {
					$end = strtotime($v["ends"]);
				}
				if(time() >= $end) {
					$ok = sql::upd("UPDATE ".dbPrefix."cronjobs SET updated = NOW(), finished = 1 WHERE id = ".$v["id"]);
					if($ok !== true) {
						array_push($err, $ok);
					}
				} else {
					$ok = sql::upd("UPDATE ".dbPrefix."cronjobs SET updated = NOW() WHERE id = ".$v["id"]);
					if($ok !== true) {
						array_push($err, $ok);
					}
				}
			}
		}
		if(!empty($err)) {
			print_r($err);
		}
	}
	public static function getJobs() {
		return self::$jobs;
	}
	public static function getJob($jobName) {
		foreach(self::$jobs as $k => $v) {
			if($k === $jobName) {
				return $v;
			}
		}
	}
	public static function getMailJobs() {
		$jobs = [];
		if(count(self::$jobs) !== 0) {
			foreach(self::$jobs as $k => $v) {
				if(substr($v["func"], 0, 14) === "mail::sendPage") {
					$jobs[$k] = $v;
				}
			}
		} else {
			return false;
		}
		return $jobs;
	}
	private static function jobTimes($jobName) {
		$job = self::getJob($jobName);
		if($job["type"] === "ONCE") {
			return [strtotime($job["time"])];
		} elseif($job["type"] === "REPEAT") {
			if(strpos($job["rule"], " ") !== false) {
				$parts = explode(":", $job["rule"]);
				foreach($parts as $k => $v) {
					$parts[$k] = explode(" ", $parts[$k]);
					$parts[$k] = ["steps" => $parts[$k][0], "type" => $parts[$k][1]];
				}
				$timeStr = [];
				foreach($parts as $v) {
					array_push($timeStr, implode(" ", $v));
				}
				$timeStr = implode(" ", $timeStr);
				if(strtotime("+".$timeStr, strtotime($job["time"])) !== false) {
					$currTime = strtotime($job["time"]);
					$times = [];
					while($currTime < strtotime($job["ends"])) {
						$currTime = strtotime("+".$timeStr, $currTime);
						if($currTime > strtotime($job["upd"])) {
							array_push($times, $currTime);
						}
					}
					return $times;
				}
			}
		}
		return [0];
	}
	public static function tryme($v, $tid) {
		return true;
	}
	private static function isJobDone($jobName) {
		$job = self::getJob($jobName);
		if($job["type"] === "ONCE") {
			if(time() > strtotime($job["time"])) {
				return true;
			} else {
				return false;
			}
		} elseif($job["type"] === "REPEAT") {
			if(time() > strtotime($job["ends"])) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
