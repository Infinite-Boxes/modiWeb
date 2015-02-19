<?php
// Includes and creates the base code
require("inc/bootstrap.php");
require("header.php");
include($_GET['_page'].".php");
require("footer.php");
?>