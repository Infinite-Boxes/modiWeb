<?php
$groups[0]["tit"] = lang::getText("mail");
$groups[1]["tit"] = lang::getText("mailaccounts");
$groups[2]["tit"] = lang::getText("maillists");
$groups[0]["txt"] = "<a href=\"admin_mail_new\">".lang::getText("newmail")."</a>";
$groups[1]["txt"] = "<a href=\"admin_mail_newaccount\">".lang::getText("newmailaccount")."</a>";
$groups[2]["txt"] = "<a href=\"admin_mail_newlist\">".lang::getText("newmaillist")."</a>";
$groups[0]["txt"] .= "<table>
<tr>
	<th><p>Namn</p></th>
	<th><p>Typ</p></th>
	<th><p>Regel</p></th>
</tr>";
$mails = cronjobs::getMailJobs();
if($mails !== false) {
	foreach($mails as $k => $v) {
		$groups[0]["txt"] .= "<tr><td><p>".$k."</p></td>
		<td><p>".$v["type"]."</p></td>
		<td><p>".$v["time"]."</p></td>
		<td><p>".$v["rule"]."</p></td></tr>";
	}
} else {
	$groups[0]["txt"] .= "<tr><td colspan=4><p>".lang::getText("empty")."</p></td></tr>";
}
$groups[0]["txt"] .= "</table>";

$groups[1]["txt"] .= "<table>
<tr>
	<th><p>Namn</p></th>
	<th><p>Adress</p></th>
</tr>";
$accounts = sql::get("SELECT * FROM ".dbPrefix."mail_accounts");
if($accounts !== false) {
	if(isset($accounts["name"])) {
		$accounts = [$accounts];
	}
	foreach($accounts as $k => $v) {
		$groups[1]["txt"] .= "<tr><td><p>".$v["name"]."</p></td>
		<td><p>".$v["address"]."@".DOMAIN."</p></td></tr>";
	}
} else {
	$groups[1]["txt"] .= "<tr><td colspan=4><p>".lang::getText("empty")."</p></td></tr>";
}
$groups[1]["txt"] .= "</table>";

$groups[2]["txt"] .= "<table>
<tr>
	<th><p>Namn</p></th>
	<th><p>Adress</p></th>
</tr>";
$lists = sql::get("SELECT * FROM ".dbPrefix."mail_lists");
if($lists !== false) {
	if(isset($lists["name"])) {
		$lists = [$lists];
	}
	foreach($lists as $k => $v) {
		$names = explode(";", $v["list"]);
		foreach($names as $k2 => $v2) {
			if($v2 === "") {
				unset($names[$k2]);
			}
		}
		$groups[2]["txt"] .= "<tr><td><p>".$v["name"]."</p></td>
		<td><p>".count($names)."</p></td></tr>";
	}
} else {
	$groups[2]["txt"] .= "<tr><td colspan=4><p>".lang::getText("empty")."</p></td></tr>";
}
$groups[2]["txt"] .= "</table>";
foreach($groups as $k => $v) {
	echo(elements::group($v["txt"], true, $v["tit"], "group".$k, "style=\"float: left;\""));
}
?>