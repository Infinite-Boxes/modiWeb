<?php
echo("<a href=\"admin_pages\">".lang::getText("back")."</a>");
$tabs = [
	"name" => [
		"name" => lang::getText("name"),
		"type" => "txt"
	],
	"description" => [
		"name" => lang::getText("description"),
		"type" => "txt"
	],
	"type" => [
		"name" => lang::getText("type"),
		"type" => "flag"
	],
	"parent" => [
		"name" => lang::getText("parent"),
		"type" => "list"
	],
	"deletable" => [
		"name" => lang::getText("deletable"),
		"type" => "flag"
	],
	"protected" => [
		"name" => lang::getText("protected"),
		"type" => "flag"
	],
	"inmenu" => [
		"name" => lang::getText("inmenu"),
		"type" => "checkbox"
	],
	"ord" => [
		"name" => lang::getText("order"),
		"type" => "txt"
	],
	"searchable" => [
		"name" => lang::getText("searchable"),
		"type" => "checkbox"
	],
	"getVars" => [
		"name" => lang::getText("vars"),
		"type" => "txt"
	],
	"url" => [
		"name" => lang::getText("url"),
		"type" => "txt"
	],
	"lang" => [
		"name" => lang::getText("language"),
		"type" => "list"
	]
];
$keys = [
	"name",
	"description",
	"type",
	"parent",
	"deletable",
	"protected",
	"inmenu",
	"ord",
	"searchable",
	"getVars",
	"url",
	"lang"
];
$pageInfo = sql::get("SELECT ".implode(", ", $keys)." FROM ".Config::dbPrefix()."pages WHERE id = ".$_GET["p"]);
//base::o($pageInfo);
$flags = [];
$outp = "";
foreach($keys as $v) {
	if($tabs[$v]["type"] === "flag") {
		array_push($flags, [$v, $tabs[$v]["name"], $pageInfo[$v]]);
	} else {
		$outp .= "<tr><td><p>".$tabs[$v]["name"]."</p></td><td>";
		if($tabs[$v]["type"] === "txt") {
			if($v === "description") {
				$outp .= "<textarea name=\"".$v."\" placeholder=\"".$tabs[$v]["name"]."\" style=\"width: 100%;\">".$pageInfo[$v]."</textarea>";
			} else {
				$outp .= "<input type=\"text\" name=\"".$v."\" value=\"".$pageInfo[$v]."\" placeholder=\"".$tabs[$v]["name"]."\">";
			}
		} elseif($tabs[$v]["type"] === "list") {
			if($v === "parent") {
				$parents = sql::get("SELECT name,parent,url FROM ".Config::dbPrefix()."pages WHERE parent IS NULL AND inmenu = 1");
				$outp .= "<select name=\"".$v."\">
				<option value=\"NULL\">".lang::getText("none")."</option>";
				foreach($parents as $p) {
					$sel = "";
					if($p["url"] === $pageInfo[$v]) {
						$sel = " selected";
					}
					$outp .= "<option value=\"".$p["name"]."\"".$sel.">".$p["name"]."</option>";
				}
				$outp .= "</select>";
			} else {
				$parents = lang::getLangs();
				$outp .= "<select name=\"".$v."\">
				<option value=\"NULL\">".lang::getText("default")." (".Config::getConfig("default_lang").")</option>";
				foreach($parents as $p) {
					$sel = "";
					if($p["val"] === $pageInfo[$v]) {
						$sel = " selected";
					}
					$outp .= "<option value=\"".$p["name"]."\"".$sel.">".$p["name"]."</option>";
				}
				$outp .= "</select>";
			}//box($name, $yesVal = "true", $noVal = "false", $img = false, $js = "") {
		} elseif($tabs[$v]["type"] === "checkbox") {
			$outp .= elements::checkbox($v, 1, 0);
		}
		$outp .= "</td></tr>";
	}
}
echo("<br><br><h1 style=\"display: inline;\">".lang::getText("editpage")."</h1>");
if(count($flags) > 0) {
	echo("<span class=\"flagList\">");
	foreach($flags as $v) {
		if($v[0] !== "type") {
			$val = "false";
			if($v[2] === "1") {
				$val = "true";
				if($v[0] === "deletable") {
					$txt = lang::getText("isdeletable");
				} else {
					$txt = lang::getText("isprotected");
				}
			} else {
				$val = "false";
				if($v[0] === "deletable") {
					$txt = lang::getText("notdeletable");
				} else {
					$txt = lang::getText("notprotected");
				}
			}
			echo("<img src=\"img/flags_".$v[0]."_".$val.".png\" onmouseover=\"popup('".$txt."');\">");
		} else {
			if($v[2] !== null) {
				$val = $v[2];
				$txt = lang::getText($v[2]);
			} else {
				$val = "page";
				$txt = lang::getText("page");
			}
			echo("<img src=\"img/page_type_".$val.".png\" onmouseover=\"popup('".lang::getText("type").": ".$txt."');\">");
		}
	}
	echo("</span>");
}
echo("<form action=\"func_admin_pagedetails_save\" method=\"POST\">
<table>".$outp);
?>
<tr><td>&nbsp;</td><td><input type="submit" value="<?php echo(lang::getText("save")); ?>"></td></tr>
</table>
</form>
<?php
