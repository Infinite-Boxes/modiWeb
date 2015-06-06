<?php
$prod = [
	[
		"cat" => "lager ljus",
		"name" => "Mikkeller - American Dream",
		"pris" => 62.7
	],
	[
		"cat" => "lager ljus",
		"name" => "Nils Oscar - God Lager",
		"pris" => 58.5
	],
	[
		"cat" => "lager mörk",
		"name" => "Falcon - Bayerskt",
		"pris" => 33
	],
	[
		"cat" => "pilsner",
		"name" => "Pilsner Urquell",
		"pris" => 33.8
	],
	[
		"cat" => "ale",
		"name" => "Kilkenny Draught",
		"pris" => 41.8
	],
	[
		"cat" => "weissbier",
		"name" => "Weihenstephaner - Hefe-Weissbier",
		"pris" => 43.8
	],
	[
		"cat" => "ESB",
		"name" => "Fullers ESB",
		"pris" => 59.7
	],
	[
		"cat" => "Pale Ale",
		"name" => "Sierra nevada pale ale",
		"pris" => 71.7
	],
	[
		"cat" => "Indian Pale Ale",
		"name" => "Brewdog Punk IPA",
		"pris" => 65.7
	],
	[
		"cat" => "Porter",
		"name" => "Carnegie Porter",
		"pris" => 47.7
	],
	[
		"cat" => "Stout",
		"name" => "Guinness Extra Stout",
		"pris" => 53.7
	],
	[
		"cat" => "Trappist",
		"name" => "La Trappe Blond",
		"pris" => 71.7
	],
	[
		"cat" => "Spontanjäst",
		"name" => "Timmermans - Kriek Lambicus",
		"pris" => 53.7
	]
];
?>
<script>
var pris = [];
<?php
$c = 0;
foreach($prod as $k => $v) {
	echo("pris[".$c."] = ".$v["pris"].";
");
	$c++;
}
?>
function upd() {
	var nr = 13;
	var sum = 0;
	for(var c = 0; c < nr; c++) {
		if(obj("list"+c).checked === true) {
			sum += pris[c];
		}
	}
	obj("sumtxt").innerHTML = Math.round(sum)+" ("+(625-Math.round(sum))+")";
}
</script>
<table>
<?php
$c = 0;
$sum = 0;
foreach($prod as $k => $v) {
	echo("<tr><td><p style=\"font-weight: bold;\">".$v["name"]."</p></td><td><p>".$v["cat"]."</p></td><td><p>".$v["pris"]."</p></td><td><input type=\"checkbox\" id=\"list".$c."\" checked onclick=\"upd();\"></td></tr>");
	$c++;
	$sum += $v["pris"];
}
echo("<tr><td><p>&nbsp;</p></td><td><p><b id=\"sumtxt\">".$sum."</b></p></td><td><p>&nbsp;</p></td></tr>");
?>
</table>

