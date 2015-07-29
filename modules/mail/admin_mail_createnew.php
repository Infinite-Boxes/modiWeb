<?php
$err = false;
$type = false;
$p = [];
$checks = ["name", "from", "to", "type", "subject", "page"];
foreach($checks as $v) {
	if(!isset($_POST[$v])) {
		$err = true;
		msg::warning(lang::getText("restricted_page"));
		header("Location: ".PREPAGE);
		exit();
	} else {
		if(($v !== "page")) {
			$p[$v] = $_POST[$v];
		}
	}
}
if(isset($_POST["type"])) {
	if($_POST["type"] !== "") {
		$type = $_POST["type"];
	} else {
		$err = true;
	}
} else {
	$err = true;
}
if($err === false) {
	$startDateName = strtolower($type)."startdate";
	if(isset($_POST[$startDateName])) {
		if($_POST[$startDateName] !== "") {
			$p["startDate"] = sql::sanitizePosts($_POST[$startDateName]);
		} else {
			$err = true;
		}
	} else {
		$err = true;
	}
} else {
	$err = true;
}
if($err === false) {
	if(isset($_POST["mail"])) {
		if($_POST["mail"] !== "") {
			if($_POST["page"] === "text") {
				$p["msg"] = $_POST["mail"];
				$p["func"] = "mail::sendText_cron";
			} else {
				$p["msg"] = $_POST["page"];
				$p["func"] = "mail::sendPage_cron";
			}
		} else {
			msg::warning(lang::getText("mail_msgmissing"));
			header("Location: ".PREPAGE);
			exit();
		}
	} else {
		$err = true;
	}
	if($type === "ONCE") {
		$p["endDate"] = false;
	} else {
		if(isset($_POST["repeatenddate"])) {
			$p["endDate"] = $_POST["repeatenddate"];	
		} else {
			$err = true;
		}
		if(isset($_POST["rule"])) {
			if($_POST["rule"] !== "") {
				$p["rule"] = $_POST["rule"];
			} else {
				$p["rule"] = false;
			}			
		} else {
			$err = true;
		}
	}
} else {
	msg::warning(lang::getText("restricted_page"));
	header("Location: ".PREPAGE);
	exit();
}
if($err !== true) {
	$post = [
		"name" => $p["name"],
		"type" => $p["type"],
		"time" => $p["startDate"],
		"rule" => "",
		"func" => $p["func"]."('".$p["from"]."', '".$p["to"]."', '".sql::sanitizePosts($p["msg"])."')"
	];
	if($p["type"] === "REPEAT") {
		$post["ends"] = $p["endDate"];
		$post["rule"] = $p["rule"];
	}
	base::o($post);
	//sql::insert("INSERT (".implode($keys).") INTO ".dbPrefix."cronjobs	
} else {
	msg::warning(lang::getText("restricted_page"));
	header("Location: ".PREPAGE);
	exit();
}
base::o($p);
base::o($_POST);
echo(PREPAGE);