<?php
$baseFolder = $_SERVER["DOCUMENT_ROOT"];
$uri = $_SERVER["REQUEST_URI"];

// Includes and creates the base code
require("inc/bootstrap.php");
require("header.php");
include($_GET['_page'].".php");

require("footer.php");
?>