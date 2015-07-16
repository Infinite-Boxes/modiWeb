<h1><?php echo(lang::getText("mailnewmsg")); ?></h1>
<form action="functions/createpage.php?type=mail" method="POST">
<?php
echo(elements::link("Tillbaka", "admin_mail_new")."<br />");
$tab["header"] = ["<p>".lang::getText("name")."</p>", "<p>".lang::getText("description")."</p>", ""];
$tab[0] = "<input type=\"text\" name=\"name\">";
$tab[1] = "<input type=\"text\" name=\"desc\">";
$tab[2] = "<input type=\"submit\" value=\"Skapa meddelande\">";
echo(elements::writeTable($tab, "v"));
?>
</form>