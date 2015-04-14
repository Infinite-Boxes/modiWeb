<h1>ModiWeb <?php
$version = floatval(file_get_contents("version"));
$last = floatval(file_get_contents("http://kopplat.nu/version.php"));
if($last > $version) {
	echo(elements::button("update.png", ["a", "http://kopplat.nu/update"], "but_spin", "", "target=\"_blank\" onmouseover=\"popup('Uppdatera ModiWeb');\""));
} else {
	
	echo("<img src=\"img/update_disabled.png\" onmouseover=\"popup('Ni har den senaste versionen');\" />");
}
?></h1>
<?php
$news = file_get_contents("http://kopplat.nu/news.php");
echo(elements::group($news, false, "Nyheter", "", "", "", "style=\"overflow-y: auto; max-height: 250px; border-radius: 10px 0px 0px 10px;\""));
