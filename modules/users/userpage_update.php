<pre>
<?php
print_r($_POST);
$_POST = sql::sanitizePosts($_POST);
print_r($_POST);
//sql::get("SELECT lang,rights,contactid FROM ".Config::dbPrefix()."users WHERE username = '".$_SESSION["user"]["base"]["username"]."'");
?>
</pre>
