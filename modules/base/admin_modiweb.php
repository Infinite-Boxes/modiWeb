<h1>ModiWeb <?php
$domain = "relaterat.nu";
$version = floatval(file_get_contents("version"));
?>
<div id="updateButton" style="display: inline;"><img src="img/loading_40.png" onload="updUpdateButton('<?php echo($domain); ?>', <?php echo($version); ?>);" onmouseover="popup('<?php echo(lang::getText("searchingforupdates")."..."); ?>');" class="doSpin"></div></h1>
<?php
echo(elements::group("<div id=\"news\"><p>Loading news...</p></div>", false, lang::getText("news"), "", "", "", "style=\"overflow-y: auto; max-height: 250px; border-radius: 10px 0px 0px 10px;\""));
?>