<?php
class mail {
	private static $accounts = [];
	static public function addAccount($name, $mail) {
		array_push(self::$accounts, ["name" => $name, "mail" => $mail]);
	}
	static public function send($from, $to, $subj, $msg) {
		$err = false;
		foreach([$from, $to, $subj, $msg] as $k => $v) {
			$types = ["FROM", "TO", "SUBJ", "MSG"];
			if(!isset($v)) {
				$err = "NO".$types[$k];
			}elseif($v === "") {
				$err = "NO".$types[$k];
			}
		}
		if(isset($from)) {
			$ok = false;
			foreach($accounts as $v) {
				if($v["name"] === $from) {
					$ok = true;
				}
			}
			if($ok === false) {
				$err = "WRONGACCOUNT";
			}
		}
		if($err !== false) {
			return $err;
		} else {
			$subj = str_replace("\n", "", $subj);
			$to = [$to];
			$fails = [];
			foreach($to as $v) {
				$ok = mail($v, $subj, $mail, "");
				if($ok === false) {
					array_push($fails, $v);
				}
			}
			if(count($fails)) {
				
			}
		}
	}
	static public function sendPage($from = false, $to = false, $page = false) {
		if($from === false) {
			return false;
		}
		if($to === false) {
			return false;
		}
		if($page === false) {
			return false;
		}
		echo("mailPage");
	}
	static public function test() {
		
	}
}