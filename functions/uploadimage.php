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
        echo "ERROR_File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "ERROR_Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["uploadFile"]["size"] > 500000) {
    echo "ERROR_Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "ERROR_Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk != 0) {
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
        echo $returnName.":::".$_FILES["uploadFile"]["name"];
    } else {
        echo "ERROR_Sorry, there was an error uploading your file.";
    }
}
?>