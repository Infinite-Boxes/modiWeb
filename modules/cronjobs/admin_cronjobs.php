<table>
<tr>
	<th><p>Namn</p></th>
	<th><p>Typ</p></th>
	<th><p>Regel</p></th>
	<th><p>Funktion</p></th>
</tr>
<?php
foreach(cronjobs::getJobs() as $k => $v) {
	echo("<tr><td><p>".$k."</p></td>
	<td><p>".$v["type"]."</p></td>
	<td><p>".$v["time"]."</p></td>
	<td><p>".$v["rule"]."</p></td>
	<td><p>".$v["func"]."</p></td></tr>");
}
?>
</table>