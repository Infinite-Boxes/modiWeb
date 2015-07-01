<?php
// Includes and creates the base code
require("inc/bootstrap.php");
if(substr($_GET["_page"], 0, 5) !== "_func") {
	if(!config::isProtectedPage($_GET["_page"])) {
		if(moduleManifest::hasMenu($_GET["_page"]) !== false) {
			$pageType = moduleManifest::menuType($_GET["_page"]);
			if($pageType === false) {
				if(file_exists(moduleManifest::menuModule($_GET["_page"])["file"])) {
					require("header.php");
					include(moduleManifest::menuModule($_GET["_page"])["file"]);
				} else {
					header("Location: error404");
				}
			} elseif($pageType == "page") {
				$prerun = sql::get("SELECT prefunction FROM ".Config::dbPrefix()."pages WHERE name = \"".moduleManifest::menuModule($_GET["_page"])["file"]."\"");
				if($prerun !== false) {
					$toRun = $prerun["prefunction"];
					$class = substr($toRun, 0, strpos($toRun, "::"));
					$function = substr($toRun, strpos($toRun, "::")+2);
					$ret = call_user_func($class."::".$function);
				} else {
					$ret = true;
				}
				if($ret === true) {
					if(sql::get("SELECT name FROM ".Config::dbPrefix()."pages WHERE url = '".$_GET["_page"]."'") !== false) {
						require("header.php");
						page::write(moduleManifest::menuModule($_GET["_page"])["file"]);
					} else {
						header("Location: error404");
					}
				} else {
					msg::warning($ret);
					header("Location: ".BASEPAGE);
				}
			} else {
				if(file_exists(moduleManifest::menuModule($_GET["_page"])["file"])) {
					require("header.php");
					include(moduleManifest::menuModule($_GET["_page"])["file"]);
				} else {
					header("Location: error404");
				}
			}
		} elseif(!menu::isUser($_GET["_page"])) {
			if(file_exists($_GET["_page"].".php")) {
				require("header.php");
				include($_GET["_page"].".php");
			} else {
				header("Location: error404");
			}
		} else {
			$prerun = sql::get("SELECT prefunction FROM ".Config::dbPrefix()."pages WHERE name = \"".moduleManifest::menuModule($_GET["_page"])["file"]."\"");
			if($prerun !== false) {
				$toRun = $prerun["prefunction"];
				$class = substr($toRun, 0, strpos($toRun, "::"));
				$function = substr($toRun, strpos($toRun, "::")+2);
				$ret = call_user_func($class."::".$function);
			} else {
				$ret = true;
			}
			if($ret === true) {
				require("header.php");
				page::write($_GET["_page"]);
			} else {
				msg::warning($ret);
				header("Location: ".PREPAGE);
			}
		}
	} else {
		msg::warning(lang::getText("restricted_page"));
		header("Location: home");
	}
	if(!config::isProtectedPage($_GET["_page"])) {
		echo("</div>");
		require("footer.php");
		$_SESSION["previous_page"] = PAGE;
	}
}
?>