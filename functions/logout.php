<?php
require("../inc/bootstrap.php");
unset($_SESSION["user"]);
msg::notice(elements::keyName("logoutnotice")["content"]);
header("Location: ../admin");
?>