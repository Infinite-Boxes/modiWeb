<?php
$rootpath = '.';
$fileinfos = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootpath)
);
function ok($var){
	$ret = true;
	if(substr($var, 0, 4) == ".git") { $ret = false; }
	if(substr($var, -4) == ".ttf") { $ret = false; }
	if(substr($var, -4) == ".png") { $ret = false; }
	if(substr($var, 0, 12) == "projectfiles") { $ret = false; }
	if($var == ".htaccess") { $ret = false; }
	if($var == ".project") { $ret = false; }
	if($var == "colors.html") { $ret = false; }
	if($var == "counter.php") { $ret = false; }
	if($var == "README.md") { $ret = false; }
	return $ret;
}
$paths = [];
$tot = 0;
foreach($fileinfos as $pathname => $fileinfo) {
    if (!$fileinfo->isFile()) continue;
	$path = substr($pathname, 2);
    if(ok($path)) {
		$file = file_get_contents($path);
		$size = strlen($file);
		$tot += $size;
		array_push($paths, ["file" => $path, "size" => $size]);
	}
}
usort($paths, function($a, $b) {
    return $b['size'] - $a['size'];
});
echo("<p style=\"font-weight: bold; margin: 0px; margin-top: 10px;\"><meter max=".$tot." value=".$tot." style=\"width: 600px; margin-right: 10px;\"></meter>".$tot." tecken</p>");
foreach($paths as $k => $v) {
	echo("<p style=\"margin: 0px; width: 110px; display: inline-block;\">".$paths[$k]["size"]." tecken.</p><meter max=".$tot." value=".$paths[$k]["size"]." style=\"width: 600px; margin-right: 10px;\"></meter><p style=\"margin: 0px; display: inline;\">".$paths[$k]["file"]."</p><br />");
}