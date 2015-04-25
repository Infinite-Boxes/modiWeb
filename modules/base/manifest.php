<?php
$vars["menu"] = [];
array_push($vars["menu"], ["name" => "Search", "link" => "search", "file" => "search.php", "visible" => false, "type" => "file"]);

$vars["integrate"] = [];
array_push($vars["integrate"], ["position" => "topright", "pages" => ["all"], "notPages" => [], "url" => "searchbar.php", "prio" => "5"]);