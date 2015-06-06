<?php
$names = [
	lang::getText("username"),
	lang::getText("password"),
	lang::getText("language"),
	lang::getText("email"),
	lang::getText("ssn"),
	lang::getText("firstname"),
	lang::getText("middlenames"),
	lang::getText("sirname"),
	lang::getText("address"),
	lang::getText("postalcode"),
	lang::getText("town"),
	lang::getText("country"),
	lang::getText("phonenumber")
];
$keys = [
	"uname",
	"pass",
	"lang",
	"mail",
	"ssn",
	"fname",
	"mname",
	"sname",
	"addr",
	"pcode",
	"town",
	"country",
	"pnumber"
];
$reqNames = [
	"username",
	"password",
	"lang",
	"email",
	"ssn",
	"firstname",
	"middlenames",
	"sirname",
	"address",
	"postalcode",
	"town",
	"country",
	"phonenumber"
];
$db1 = [
	"firstname",
	"middlenames",
	"sirname",
	"ssn",
	"address",
	"postalcode",
	"town",
	"country",
	"phonenumber",
	"email"
];
$db2 = [
	"username",
	"password",
	"lang"
];
$types = [
	"str",
	"str",
	"str",
	"str",
	"str",
	"str",
	"str",
	"str",
	"str",
	"int",
	"str",
	"str",
	"str"
];
$req = [];
$requireds = sql::get("SELECT * FROM ".Config::dbPrefix()."users_requiredfields WHERE user = 1");
foreach($reqNames as $k => $v) {
	if($v !== false) {
		$found = false;
		foreach($requireds as $v2) {
			if($v2["field"] === $v) {
				$found = $v2["user"];
			}
		}
		if($found !== false) {
			if($found === "1") {
				$req[$k] = true;
			} else {
				$req[$k] = false;
			}
		} else {
			$req[$k] = false;
		}
	} else {
		$req[$k] = false;
	}
}
$err = false;
function err($str) {
	$ret = true;
	if(!isset($_POST[$str])) {
		$ret = false;
	} elseif($_POST[$str] !== "") {
		$ret = false;
	}
	return $ret;
}
foreach($req as $k => $v) {
	if($v !== false) {
		if((err($keys[$k]) === true)) {
			if($err === false) {
				$err = [];
			}
			array_push($err, $names[$k]);
		}
	}
}
$dead = false;
if(isset($_POST["uname"])) {
	echo("1");
	$try = sql::get("SELECT username FROM ".Config::dbPrefix()."users WHERE username = '".$_POST["uname"]."'");
	if($try !== false) {
		msg::warning(lang::getText("userexists"));
		header("Location: userregister");
		exit();
	}
}
if(isset($_POST["mail"])) {
	echo("2");
	$try = sql::get("SELECT email FROM ".Config::dbPrefix()."contactdetails WHERE email = '".$_POST["mail"]."'");
	if($try !== false) {
		msg::warning(lang::getText("userexists"));
		header("Location: userregister");
		exit();
	}
}
if($err !== false) {
	$msg = "";
	if(count($err) === 1) {
		$msg = lang::getText("error_missingfollowing").implode($err).".";
	} else {
		$last = array_pop($err);
		$msg = lang::getText("error_missingfollowing").implode(", ", $err)." ".lang::getText("and")." ".$last.".";
	}
	msg::warning($msg);
	header("Location: userregister");
	exit();
} else {
	$posts = [];
	$keys = [];
	foreach($_POST as $k => $v) {
		array_push($posts, $k);
		if(err($_POST[$k]) === false) {
			array_push($keys, $k);
		}
	}
	$_POST = sql::sanitizePosts($_POST, $posts);
	$post1 = [];
	$vals1 = [];
	foreach($db1 as $k => $v) {
		$key = false;
		foreach($reqNames as $k2 => $v2) {
			if($v2 === $v) {
				$key = $k2;
			}
		}
		if($_POST[$keys[$key]] !== "") {
			array_push($post1, $v);
			if($types[$key] === "str") {
				array_push($vals1, "'".$_POST[$keys[$key]]."'");
			} else {
				array_push($vals1, $_POST[$keys[$key]]);
			}
		}
	}
	$post2 = ["rights"];
	$vals2 = ["'U'"];
	foreach($db2 as $k => $v) {
		$key = false;
		foreach($reqNames as $k2 => $v2) {
			if($v2 === $v) {
				$key = $k2;
			}
		}
		if($_POST[$keys[$key]] !== "") {
			array_push($post2, $v);
			if($types[$key] === "str") {
				array_push($vals2, "'".$_POST[$keys[$key]]."'");
			} else {
				array_push($vals2, $_POST[$keys[$key]]);
			}
		}
	}
	$vals1 = implode(", ", $vals1);
	$vals2 = implode(", ", $vals2);
	$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."contactdetails (".implode(", ", $post1).") values (".$vals1.")");
	if($ok[0] === false) {
		msg::warning(lang::getText("error_usernotcreated"));
		header("Location: userregister");
		exit();
	} else {
		$sql = "INSERT INTO ".Config::dbPrefix()."users (".implode(", ", $post2).") values (".$vals2.")";
		$ok = sql::insert("INSERT INTO ".Config::dbPrefix()."users (".implode(", ", $post2).") values (".$vals2.")");
		if($ok[0] === false) {
			msg::warning(lang::getText("error_usernotcreated"));
			header("Location: userregister");
			exit();
	} else {
			msg::notice(lang::getText("usercreated"));
			header("Location: userregister");
			exit();
		}
	}
}

