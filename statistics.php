<?php
if(statistics::getList() != false) {
	$list = [];
	$list["header"] = ["<p>Besökare</p>", "<p>Tid</p>", "<p>Senaste sidan</p>"];
	foreach(statistics::getList() as $k => $v) {
		array_push($list, ["<p>".$v["ip"]."</p>", "<p>".dates::timeSince($v["time"])."</p>", "<p>".$v["lastPage"]."</p>"]);
	}
	echo(elements::writeTable($list, "h"));
}
else {
	echo("TOM");
}
?>