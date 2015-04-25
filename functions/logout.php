<?php
require("../inc/bootstrap.php");
unset($_SESSION["user"]);
msg::notice(elements::keyName("logoutnotice")["content"]);
if(isset($_GET["redir"])) {
	header("Location: ../".$_GET["redir"]);
} else {
	header("Location: ../admin");
}
?>