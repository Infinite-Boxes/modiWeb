<h3><?php echo(lang::getText("register")); ?></h3>
<form action="func_createaccount" method="POST" onload="this.reset();">
<?php
$names = [
	lang::getText("username"),
	lang::getText("password"),
	lang::getText("language"),
	false,
	lang::getText("email"),
	lang::getText("ssn"),
	false,
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
	false,
	"mail",
	"ssn",
	false,
	"fname",
	"mname",
	"sname",
	"addr",
	"pcode",
	"town",
	"country",
	"pnumber"
];
$types = [
	"text",
	"password",
	"special:1",
	false,
	"text",
	"text",
	false,
	"text",
	"text",
	"text",
	"text",
	"text",
	"text",
	"text",
	"text"
];
$reqNames = [
	"username",
	"password",
	"lang",
	false,
	"email",
	"ssn",
	false,
	"firstname",
	"middlenames",
	"sirname",
	"address",
	"postalcode",
	"town",
	"country",
	"phonenumber",
];
$req = [];
//	Account-type
$accType = "admin";
$requireds = sql::get("SELECT * FROM ".Config::dbPrefix()."users_requiredfields WHERE ".$accType." = 1");
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
?>
<table>
<?php
$sw = false;
foreach($keys as $k => $v) {
	if($sw === false) {
		echo("<tr>");
	}
	if($v !== false) {
		if($req[$k] === true) {
			$reqStr = " class=\"req\"";
		} else {
			$reqStr = "";
		}
		echo("<td><p".$reqStr." style=\"font-weight: bold;\">".$names[$k]."</p></td>");
		if($types[$k] === "text") {
			echo("<td><input type=\"text\" name=\"".$keys[$k]."\"></td>");
		} elseif($types[$k] === "special:1") {
			echo("<td>");
			$langs = lang::getLangs();
			$input = [];
			foreach($langs as $k2 => $v2) {
				array_push($input, [$v2["name"], $v2["val"]]);
			}
			echo(elements::inputChoice($keys[$k], $input));
		} elseif($types[$k] === "password") {
			echo("<td><input type=\"password\" name=\"".$keys[$k]."\"></td>");
		}
	} else {
		if($sw === true) {
			echo("<td colspan=2><p>&nbsp;</p></td>");
		}
		echo("</tr><tr><td colspan=4><p>&nbsp;</p></td>");
		$sw = true;
	}
	if($sw === true) {
		echo("</tr>");
	}
	if($sw === false) {
		$sw = true;
	} else {
		$sw = false;
	}
}
?>
<tr><td colspan=4 style="text-align: right;"><input type="submit" value="<?php echo(lang::getText("submit")); ?>"></td></tr>
</table>
</form>