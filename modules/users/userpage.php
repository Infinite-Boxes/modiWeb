<h3><?php echo(lang::getText("myinformation")); ?></h3>
<form action="userpage_update" method="POST">
<?php
$sqlinfo = sql::get("SELECT lang,rights,contactid FROM ".Config::dbPrefix()."users WHERE username = '".$_SESSION["user"]["base"]["username"]."'");
$info = [];
$langs = sql::get("SELECT name,val FROM ".Config::dbPrefix()."languages");
if(count($langs) === 1) {
	$langs = false;
}
$langSelect = "";
if($langs !== false) {
	$langSelect = "<select name=\"lang\">";
	foreach($langs as $v) {
		$chosen = "";
		if($sqlinfo["lang"] === $v["val"]) {
			$chosen = " selected";
		}
		$langSelect .= "<option value=\"".$v["val"]."\"".$chosen.">".$v["name"]."</option>";
	}
	$langSelect .= "</select>";
} else {
	$langSelect = "<p>".$sqlinfo["lang"]."</p>";
}
$info[0] = $langSelect;
$rightsFlags = "";
foreach(str_split($sqlinfo["rights"]) as $v) {
	$rightsFlags .= "<img src=\"img/".users::flags($v)["src"]."\" onmouseover=\"popup('".users::flags($v)["name"]."', 500);\" style=\"margin: 0px 1px;\">";
}
$info[1] = $rightsFlags;
$detInfo = sql::get("SELECT firstname,middlenames,sirname,ssn,address,postalcode,town,country,email,phonenumber FROM ".Config::dbPrefix()."contactdetails WHERE id = ".$sqlinfo["contactid"]);
$c = 2;
$info["header"] = ["<p>".lang::getText("language")."</p>", "<p>".lang::getText("rights")."</p>"];
$names = [];
$protected = [];
foreach($detInfo as $k => $v) {
	$names[$k] = lang::getText($k);
	if($k === "ssn") {
		$protected[$k] = true;
	} else {
		$protected[$k] = false;
	}
}
$formnames = ["firstname" => "fname", "middlenames" => "mnames", "sirname" => "sname", "ssn" => "pnr", "address" => "address", "postalcode" => "pcode", "town" => "ptown", "country" => "nat", "email" => "mail", "phonenumber" => "phone"];
foreach($detInfo as $k => $v) {
	$info[$c] = "<input type=\"text\" name=\"".$formnames[$k]."\" value=\"".$v."\">";
	if($protected[$k] === true) {
		$info[$c] = "<p>".$v."</p>";
	}
	array_push($info["header"], "<p>".$names[$k]."</p>");
	$c++;
}
array_push($info, "<input type=\"submit\" value=\"".lang::getText("update")."\">");
array_push($info["header"], "&nbsp;");
echo(elements::writeTable($info, "v"));
?>
</form>




