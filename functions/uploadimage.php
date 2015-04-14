<?php
require("../inc/bootstrap.php");
$file = $_FILES["uploadFile"];
$target_dir = ROOT."img/user/";
$target_file = $target_dir . basename($file["name"]);
$returnName = "img/user/".$file["name"];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "ERROR_Filen är inte en bild.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "ERROR_Tyvärr, en fil med detta namnet finns redan.";
    $uploadOk = 0;
}
// Check file size
if ($file["size"] > 500000) {
    echo "ERROR_Tyvärr, filen är för stor.";
    $uploadOk = 0;
}
// Allow certain file formats
$ff = [
	"jpg",
	"gif",
	"jpeg",
	"png"
];
$errFile = true;
foreach($ff as $k => $v) {
	if(strtolower($imageFileType) == $v) {
		$errFile = false;
	}
}
if($errFile === true) {
    echo "ERROR_Tyvärr. Filformatet '".$imageFileType."' stöds ej.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk != 0) {
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        echo $returnName.":::".$file["name"];
    } else {
        echo "ERROR_Det har inträffat ett fel när vi försökte ladda upp din bild. Försök igen.";
    }
}
?>