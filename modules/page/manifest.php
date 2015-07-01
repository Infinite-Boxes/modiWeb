<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Sidor", "link" => "admin_pages", "file" => "admin_pages.php", "visible" => true, "parent" => "admin", "searchable" => false, "protection" => "a"]);
array_push($vars["menu"], ["name" => "Page details", "link" => "admin_pagedetails", "file" => "admin_pagedetails.php", "visible" => false, "searchable" => false, "protection" => "a"]);
array_push($vars["menu"], ["name" => "Page details SAVE", "link" => "func_admin_pagedetails_save", "file" => "admin_pagedetails_save.php", "visible" => false, "searchable" => false, "protection" => "a"]);
