<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Mail", "link" => "admin_mail", "file" => "admin_mail.php", "visible" => true, "type" => "file", "parent" => "admin", "protection" => "a", "searchable" => false]);
array_push($vars["menu"], ["name" => "Mail new", "link" => "admin_mail_new", "file" => "admin_mail_new.php", "visible" => false, "type" => "file", "protection" => "a", "searchable" => false]);
array_push($vars["menu"], ["name" => "Mail new script", "link" => "admin_mail_createnew", "file" => "admin_mail_createnew.php", "visible" => false, "type" => "file", "protection" => "a", "searchable" => false]);
array_push($vars["menu"], ["name" => "Mail ", "link" => "admin_mail_new_newpage", "file" => "admin_mail_new_newpage.php", "visible" => false, "type" => "file", "protection" => "a", "searchable" => false]);
/*
array_push($vars["css"], "css.css");
$vars["js"] = [];
array_push($vars["js"], ["file" => "shop.js", "pages" => true]);
*/