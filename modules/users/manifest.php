<?php
$vars["integrate"] = [];
array_push($vars["integrate"], ["position" => "topright", "pages" => ["all"], "url" => "loginpage.php", "prio" => 10]);

$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Min sida", "link" => "userpage", "file" => "userpage.php", "visible" => false, "searchable" => false]);
array_push($vars["menu"], ["name" => "Update information", "link" => "userpage_update", "file" => "userpage_update.php", "visible" => false, "searchable" => false]);
array_push($vars["menu"], ["name" => "User registration", "link" => "userregister", "file" => "userregister.php", "visible" => false, "searchable" => false]);
array_push($vars["menu"], ["name" => "User CreateAccountScript", "link" => "func_createaccount", "file" => "usercreatescript.php", "visible" => false, "searchable" => false, "linkable" => false]);

$vars["js"] = [];
array_push($vars["js"], ["file" => "userpage.js", "pages" => "userpage"]);