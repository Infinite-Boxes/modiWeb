<?php
if(isset($_GET["gettype"])) {
	if($_GET["gettype"] === "calendarMove") {
		echo(dates::calendar($_GET["recall"], true, true, $_GET["date"], $_GET["pdate"], false, true));
	}
}
?>