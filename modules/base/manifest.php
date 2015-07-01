<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Search", "link" => "search", "file" => "search.php", "visible" => false, "type" => "file", "searchable" => false]);

array_push($vars["menu"], ["name" => "ModiWeb", "link" => "admin_modiweb", "file" => "admin_modiweb.php", "visible" => true, "type" => "file", "searchable" => false, "parent" => "admin", "order" => 2]);
array_push($vars["menu"], ["name" => "Bilder", "link" => "admin_images", "file" => "admin_images.php", "visible" => true, "type" => "file", "searchable" => false, "parent" => "admin", "order" => 0]);
array_push($vars["menu"], ["name" => "Admin Skapa ny sida", "link" => "admin_createnewpage", "file" => "admin_createnewpage.php", "visible" => false, "type" => "file", "searchable" => false, "parent" => "admin"]);
array_push($vars["menu"], ["name" => "Admin Lägg till bild", "link" => "admin_addimage", "file" => "admin_addimage.php", "visible" => false, "type" => "file", "searchable" => false, "parent" => "admin"]);


$vars["integrate"] = [];
array_push($vars["integrate"], ["position" => "topright", "pages" => ["all"], "notPages" => [], "url" => "searchbar.php", "prio" => "5"]);