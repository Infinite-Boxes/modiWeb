<?php
if(isset($_GET["q"])) {
	$query = $_GET["q"];
	$length = round(strlen($query)*1.5);
} else {
	$query = "";
	$length = 20;
}
?>
<form action="search" method="GET" style="margin-top: 5px;">
<input type="text" name="q" size=<?php
echo($length);
?> placeholder="<?php echo(lang::getText("search")); ?>" value="<?php
echo($query);
?>"> <input type="submit" value="<?php echo(lang::getText("search")); ?>">
</form>
<?php
echo("<p><b>Sökte efter:</b> ".$query."</p>
<div class=\"linkList\">");
$results = base::search($query);
foreach($results as $v) {
	echo("<a href=\"".$v["url"]."\" style=\"display: table-row;\"><div class=\"tabcell\"><img src=\"img/type_".$v["type"].".png\" class=\"imgNotLinked\"></div><div class=\"tabcell\">".$v["name"]."</div><div>".$v["searchPoints"]."</div></a>");
}
?>
</div>
