<?php
function customError($errno, $errstr) {
	if($errno == 2) {
		header("Location: error404");
	} else {
		echo "<b>Fel: [$errno]</b> $errstr<br>";
		die();
	}
}
function customException($exception) {
	if($exception->getCode() == "1044") {
		echo "<b>Fel:</b> Felaktig login för databasen.<br>";
	}elseif($exception->getCode() == "1045") {
		echo "<b>Fel:</b> Felaktig login för databasen (med lösenord).<br>";
	}elseif($exception->getCode() == "1049") {
		echo "<b>Fel:</b> Felaktig databas.<br>";
	}elseif($exception->getCode() == "2") {
		echo "<b>Fel:</b> Sidan finns inte!<br>";
	} else {
		echo "<b>Fel:</b> ".$exception->getMessage()."<br>";
	}
}
set_error_handler("customError");
set_exception_handler('customException');
?>