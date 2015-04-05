<?php
error_reporting (0);
require("../inc/bootstrap.php");
echo(Config::runSnippet($_GET["mod"]));
?>