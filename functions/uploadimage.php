<?php
require("../inc/bootstrap.php");
$target_dir = ROOT."img/user/";
$target_file = $target_dir . basename($_FILES["uploadFile"]["name"]);
$returnName = "img/user/".$_FILES["uploadFile"]["name"];
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["uploadFile"]["tmp_name"]);
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
if ($_FILES["uploadFile"]["size"] > 500000) {
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
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
        echo $returnName.":::".$_FILES["uploadFile"]["name"];
    } else {
        echo "ERROR_Det har inträffat ett fel när vi försökte ladda upp din bild. Försök igen.";
    }
}
?>