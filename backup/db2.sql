-- --------------------------------------------------------
-- Värd:                         127.0.0.1
-- Server version:               5.6.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4913
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table modiweb.modiweb_config_site
CREATE TABLE IF NOT EXISTS `modiweb_config_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `admname` tinytext COLLATE utf32_bin,
  `val` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Configuration for the site';

-- Dumping data for table modiweb.modiweb_config_site: ~3 rows (approximately)
/*!40000 ALTER TABLE `modiweb_config_site` DISABLE KEYS */;
INSERT INTO `modiweb_config_site` (`id`, `name`, `admname`, `val`) VALUES
	(1, 'title', 'title', 'ModiWeb'),
	(2, 'owner', 'owner', 'Infinite-Boxes'),
	(3, 'default_lang', 'default_lang', 'SE');
/*!40000 ALTER TABLE `modiweb_config_site` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_contactdetails
CREATE TABLE IF NOT EXISTS `modiweb_contactdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` tinytext COLLATE utf32_bin NOT NULL,
  `middlenames` tinytext COLLATE utf32_bin,
  `sirname` tinytext COLLATE utf32_bin,
  `ssn` tinytext COLLATE utf32_bin,
  `address` tinytext COLLATE utf32_bin,
  `postalcode` int(6) DEFAULT NULL,
  `town` tinytext COLLATE utf32_bin,
  `country` tinytext COLLATE utf32_bin,
  `mail` text COLLATE utf32_bin,
  `phonenumber` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Kontaktdetaljer. Namn, adress osv';

-- Dumping data for table modiweb.modiweb_contactdetails: ~1 rows (approximately)
/*!40000 ALTER TABLE `modiweb_contactdetails` DISABLE KEYS */;
INSERT INTO `modiweb_contactdetails` (`id`, `firstname`, `middlenames`, `sirname`, `ssn`, `address`, `postalcode`, `town`, `country`, `mail`, `phonenumber`) VALUES
	(1, 'David', 'Elias Christoffer', 'Andersson', '8802113533', 'Bryggaregatan 32', 25227, 'Helsingborg', 'Sweden', 'rrx_88@hotmail.com', '0739772996');
/*!40000 ALTER TABLE `modiweb_contactdetails` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_images
CREATE TABLE IF NOT EXISTS `modiweb_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `url` text COLLATE utf32_bin,
  `alt` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_images: ~0 rows (approximately)
/*!40000 ALTER TABLE `modiweb_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `modiweb_images` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_lang
CREATE TABLE IF NOT EXISTS `modiweb_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `lang` varchar(2) COLLATE utf32_bin NOT NULL DEFAULT 'SE',
  `val` text COLLATE utf32_bin,
  `protected` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_lang: ~49 rows (approximately)
/*!40000 ALTER TABLE `modiweb_lang` DISABLE KEYS */;
INSERT INTO `modiweb_lang` (`id`, `name`, `lang`, `val`, `protected`) VALUES
	(1, 'currency', 'SE', 'kr', 0),
	(2, 'currency', 'EN', '$', 0),
	(3, 'category', 'SE', 'Kategori', 0),
	(4, 'category', 'EN', 'Category', 0),
	(5, 'everything', 'SE', 'Allt', 0),
	(6, 'everything', 'EN', 'Everything', 0),
	(7, 'incl_subcategories', 'SE', 'Inkl. underkategorier', 0),
	(8, 'incl_subcategories', 'EN', 'Incl. subcategories', 0),
	(9, 'excl_subcategories', 'SE', 'Exkl. underkategorier', 0),
	(10, 'excl_subcategories', 'EN', 'Excl. subcategories', 0),
	(11, 'price', 'SE', 'Pris', 0),
	(12, 'price', 'EN', 'Price', 0),
	(13, 'name', 'SE', 'Namn', 0),
	(14, 'name', 'EN', 'Name', 0),
	(15, 'asc', 'SE', 'Uppåt', 0),
	(16, 'desc', 'SE', 'Nedåt', 0),
	(17, 'asc', 'EN', 'Ascending', 0),
	(18, 'desc', 'EN', 'Descending', 0),
	(19, 'documentation_editor_databases', 'SE', '<a href="documentation">Dokumentation</a> - <a href="documentation_editor">Redigeraren</a>\r\n<p>Du kan använda enklare databaser på din hemsida genom Redigeraren. Detta kan du göra varsomhelst i redigeraren där du kan skriva in text (text för titlar och vanliga textobjekt, adress för bilder, länkar osv, eller värden som bredden på en bild t ex). Där skriver du då olika nyckelord för vad du vill få fram för information. Nyckelorden <b>MÅSTE</b> skrivas in i den följd de visas nedan. De är följande:</p>\r\n<table class="documentationtable">\r\n<tr>\r\n<td><p><b>!GET!</b></p></td><td><p>Måste skrivas allra först och informerar systemet om att den ska hämta information från databasen.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>KEY_*</b></p></td><td><p>Bestämmer vilken information du vill hämta. Istället för asterisken (*) så skriver du vilken tabellcell från databasen (du kan se en lista över tillgängliga databas-tabeller och deras celler nedan. Du kan också använda ett par andra nyckelord.<br />\r\n<b>KEY_COUNT_*</b> räknar antalet celler som informationen finns i.<br />\r\n<b>KEY_SUM_*</b> summerar alla värden i tabellraden.<br />\r\n<b>KEY_MAX_*</b> hämtar det högsta av värdena.<br />\r\n<b>KEY_MIN_*</b> hämtar det minsta av värdena.<br />\r\n<b>KEY_AVG_*</b> hämtar det genomsnittliga värdet.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>FROM_*</b></p></td><td><p>Vilken tabell informationen ska hämtas från. Tabellnamnen står listade nedan.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>WHERE * IS *</b></p></td><td><p>Där tabellcellens text/värde är lika med den andra asterisken. DU kan använda AND efter detta för att bestämma mer detaljerat exakt vad du vill ha. <br />Här kan du också använda de variabler som sidan kan ta emot. Om du t ex har länkat till sidan med en variabel (sidansnamn?variabel=värde) så kan du använda den variabeln i databasfrågan genom att skriva \'!V! variabelnamnet !:!\'. Tänk på att variabelnamnen <b>INTE</b> kan innehålla mellanrum. Tänk också på att de enkla citationstecknen bara behövs ifall variabelnamnets värde innehåller något annat än siffror.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>!ENDGET!</b></p></td><td><p>Avslutar förfrågan till databasen och <b>MÅSTE</b> vara sist.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>!TRUEGET!</b></p></td><td><p>Du kan också använda detta nyckelord om du vill använda riktiga MySQL-satser. Tänk på att bara använda detta ifall du är <b>helt säker</b> på vad du gör då detta kan krasha din hemsida om det används felaktigt.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>!ENDTRUEGET!</b></p></td><td><p>Avslutar en riktig MySQL-sats.</p></td>\r\n</tr>\r\n</table>\r\n<p><b>*</b><i> Ifall ett nyckelnamn innehåller mellanrum så <b>MÅSTE</b> du använda ENKLA citationstecken ( \' ) runt namnet. T ex WHERE user IS \'main admin\'.</i></p>\r\n<p><b>*</b><i> Ifall resultatet består utav mer än ett värde (t ex att du får flera användare när du frågar efter alla användare med "language IS SE") så kommer resultaten visas på varsin rad.</i></p>\r\n<h3>Exempel</h3>\r\n<pre>\r\n!GET! KEY_namn FROM_users WHERE phone IS 0731234567 !ENDGET!\r\n!TRUEGET! SELECT namn FROM users WHERE phone = 0731234567 !ENDTRUEGET!\r\n</pre>\r\n<pre>\r\n!GET! KEY_username FROM_users WHERE user IS admin AND password IS 1234 !ENDGET!\r\n!TRUEGET! SELECT username FROM users WHERE user = "admin" AND password = 1234 !ENDTRUEGET!\r\n</pre>\r\n<pre>\r\n!GET! KEY_"användare namn" FROM_users WHERE adress IS "Järnvägsgatan 11" !ENDGET!\r\n!TRUEGET! SELECT "användare namn" FROM users WHERE adress = "Järnvägsgatan 11" !ENDTRUEGET!\r\n</pre>\r\n<pre>\r\n!GET! KEY_SUM_names FROM_users WHERE language IS SE !ENDGET!\r\n!TRUEGET! SELECT SUM(names) FROM users WHERE language = "SE" !ENDTRUEGET!\r\n</pre>\r\n<pre>\r\n!GET! KEY_name FROM_users WHERE language IS \'!V! userId !:!\' !ENDGET!\r\n!TRUEGET! SELECT name FROM users WHERE language = \'!V! userId !:!\' !ENDTRUEGET!\r\n</pre>', 1),
	(20, 'err_404', 'SE', '<h1>404</h1>\n<p>Oj. Hur hamnade du här? Denna sidan finns ju inte.</p>', 0),
	(21, 'err_404', 'EN', '<h1>404</h1>\n<p>Oh my. How did you end up here? This page doesn\'t exist.</p>', 0),
	(22, 'documentation_editor', 'SE', '<p>Välkommen för dokumentationen för redigeraren. Redigeraren är ett kraftfullt men främst enkelt verktyg som gör att du som användare kan redigera dina sidor på ett enkelt sätt. Detta har vi gjort av en enda anledning. För att du ska spara pengar så du slipper anställa oss vid vartenda liten uppdatering av sidan. Självklart hjälper vi dig gärna ändå, men på detta sättet kan du själv göra alla de ändringar du vill få gjorda.</p>\r\n<h3>Övesikt</h3>\r\n<a href="documentation_editor_databases">Databaser. Hur du hämtar data från dem.</a>', 1),
	(23, 'limit_exceeded_variables', 'SE', 'För många variabler i dokumentet!', 0),
	(24, 'unknown_error', 'SE', 'Ett okänt fel upptäcktes.', 0),
	(25, 'limit_exceeded_functions', 'SE', 'För många funktioner i dokumentet!', 0),
	(26, 'shoppingCart', 'SE', 'Kundvagn', 0),
	(27, 'cart', 'SE', 'Kundvagn', 0),
	(28, 'cart', 'EN', 'Cart', 0),
	(29, 'missing_name', 'SE', 'Du måste fylla i ditt namn.', 0),
	(30, 'missing_address', 'SE', 'Du måste fylla i din adress.', 0),
	(31, 'missing_postalnumber', 'SE', 'Du måste fylla i ditt postnummer.', 0),
	(32, 'missing_postalcity', 'SE', 'Du måste fylla i din postort.', 0),
	(33, 'postalnumber_notice', 'SE', 'Format: Västra Storgatan 2b', 0),
	(34, 'email', 'SE', 'E-post', 0),
	(35, 'phonenumber', 'SE', 'Telefonnummer', 0),
	(36, 'address', 'SE', 'Adress', 0),
	(37, 'postalcity', 'SE', 'Postort', 0),
	(38, 'postalnumber', 'SE', 'Postnummer', 0),
	(39, 'shop_smsnotice', 'SE', 'Telefonnumret behövs ifall du vill få en SMS-påminnelse', 0),
	(40, 'clientinformation', 'SE', 'Uppgifter', 0),
	(41, 'shipping', 'SE', 'Frakt', 0),
	(42, 'payment', 'SE', 'Betalning', 0),
	(43, 'done', 'SE', 'Klart', 0),
	(44, 'shop_shippinginfo', 'SE', 'Vilket fraktsätt vill du använda?', 0),
	(45, 'username', 'SE', 'Användarnamn', 0),
	(46, 'password', 'SE', 'Lösenord', 0),
	(47, 'login', 'SE', 'Logga in', 0),
	(48, 'login', 'EN', 'Login', 0),
	(49, 'logout', 'SE', 'Logga ut', 0);
/*!40000 ALTER TABLE `modiweb_lang` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_languages
CREATE TABLE IF NOT EXISTS `modiweb_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf32_bin NOT NULL,
  `val` varchar(4) COLLATE utf32_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_languages: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_languages` DISABLE KEYS */;
INSERT INTO `modiweb_languages` (`id`, `name`, `val`) VALUES
	(1, 'Swedish', 'SE'),
	(2, 'English', 'EN');
/*!40000 ALTER TABLE `modiweb_languages` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_log
CREATE TABLE IF NOT EXISTS `modiweb_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinytext COLLATE utf32_bin NOT NULL,
  `message` tinytext COLLATE utf32_bin NOT NULL,
  `path` tinytext COLLATE utf32_bin NOT NULL,
  `vardump` mediumtext COLLATE utf32_bin NOT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Errorlogging, with var-dumping etc.';

-- Dumping data for table modiweb.modiweb_log: ~1 rows (approximately)
/*!40000 ALTER TABLE `modiweb_log` DISABLE KEYS */;
INSERT INTO `modiweb_log` (`id`, `time`, `type`, `message`, `path`, `vardump`) VALUES
	(1, '2015-03-13 12:37:20', 'error', '2: include(numbero.php): failed to open stream: No such file or', 'C:/xampp/htdocs/modiWeb/page.php', 'Array\n(\n    [_GET] => Array\n        (\n            [_page] => numbero\n        )\n\n    [_POST] => Array\n        (\n        )\n\n    [_COOKIE] => Array\n        (\n            [PHPSESSID] => gmmuo38j4qihnjqner51mpo0e6\n        )\n\n    [_FILES] => Array\n        (\n        )\n\n    [_SERVER] => Array\n        (\n            [REDIRECT_MIBDIRS] => C:/xampp/php/extras/mibs\n            [REDIRECT_MYSQL_HOME] => xamppmysqlin\n            [REDIRECT_OPENSSL_CONF] => C:/xampp/apache/bin/openssl.cnf\n            [REDIRECT_PHP_PEAR_SYSCONF_DIR] => xamppphp\n            [REDIRECT_PHPRC] => xamppphp\n            [REDIRECT_TMP] => xampp	mp\n            [REDIRECT_STATUS] => 200\n            [MIBDIRS] => C:/xampp/php/extras/mibs\n            [MYSQL_HOME] => xamppmysqlin\n            [OPENSSL_CONF] => C:/xampp/apache/bin/openssl.cnf\n            [PHP_PEAR_SYSCONF_DIR] => xamppphp\n            [PHPRC] => xamppphp\n            [TMP] => xampp	mp\n            [HTTP_HOST] => localhost\n            [HTTP_CONNECTION] => keep-alive\n            [HTTP_CACHE_CONTROL] => max-age=0\n            [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\n            [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36\n            [HTTP_REFERER] => http://localhost/modiWeb/test\n            [HTTP_ACCEPT_ENCODING] => gzip, deflate, sdch\n            [HTTP_ACCEPT_LANGUAGE] => en-US,en;q=0.8,sv;q=0.6\n            [HTTP_COOKIE] => PHPSESSID=gmmuo38j4qihnjqner51mpo0e6\n            [PATH] => C:ProgramDataOracleJavajavapath;C:Program Files (x86)InteliCLS Client;C:Program FilesInteliCLS Client;C:windowssystem32;C:windows;C:windowsSystem32Wbem;C:windowsSystem32WindowsPowerShellv1.0;C:Program FilesIntelIntel(R) Management Engine ComponentsDAL;C:Program FilesIntelIntel(R) Management Engine ComponentsIPT;C:Program Files (x86)IntelIntel(R) Management Engine ComponentsDAL;C:Program Files (x86)IntelIntel(R) Management Engine ComponentsIPT;C:Program FilesLenovoBluetooth Software;C:Program FilesLenovoBluetooth Softwaresyswow64;C:Program FilesMicrosoft SQL Server110ToolsBinn;C:Program Files (x86)Microsoft SDKsTypeScript1.0\n            [SystemRoot] => C:windows\n            [COMSPEC] => C:windowssystem32cmd.exe\n            [PATHEXT] => .COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC\n            [WINDIR] => C:windows\n            [SERVER_SIGNATURE] => <address>Apache/2.4.9 (Win32) OpenSSL/1.0.1g PHP/5.5.11 Server at localhost Port 80</address>\n\n            [SERVER_SOFTWARE] => Apache/2.4.9 (Win32) OpenSSL/1.0.1g PHP/5.5.11\n            [SERVER_NAME] => localhost\n            [SERVER_ADDR] => ::1\n            [SERVER_PORT] => 80\n            [REMOTE_ADDR] => ::1\n            [DOCUMENT_ROOT] => C:/xampp/htdocs\n            [REQUEST_SCHEME] => http\n            [CONTEXT_PREFIX] => \n            [CONTEXT_DOCUMENT_ROOT] => C:/xampp/htdocs\n            [SERVER_ADMIN] => postmaster@localhost\n            [SCRIPT_FILENAME] => C:/xampp/htdocs/modiWeb/page.php\n            [REMOTE_PORT] => 52057\n            [REDIRECT_QUERY_STRING] => _page=numbero\n            [REDIRECT_URL] => /modiWeb/numbero\n            [GATEWAY_INTERFACE] => CGI/1.1\n            [SERVER_PROTOCOL] => HTTP/1.1\n            [REQUEST_METHOD] => GET\n            [QUERY_STRING] => _page=numbero\n            [REQUEST_URI] => /modiWeb/numbero\n            [SCRIPT_NAME] => /modiWeb/page.php\n            [PHP_SELF] => /modiWeb/page.php\n            [REQUEST_TIME_FLOAT] => 1426246640.186\n            [REQUEST_TIME] => 1426246640\n        )\n\n    [_SESSION] => Array\n        (\n            [prepage] => error.php?e=404\n            [rid] => $1$dP..ix/.$K2MgbjEyEE7oxzul9fg1o.\n            [user] => Array\n                (\n                    [base] => Array\n                        (\n                            [id] => 1\n                            [username] => admin\n                            [password] => $2WDW3kZP7foI\n                            [contactid] => 64\n                            [lang] => SE\n                        )\n\n                    [contactdetails] => Array\n                        (\n                            [id] => 64\n                            [firstname] => David\n                            [middlenames] => Elias Christoffer\n                            [sirname] => Andersson\n                            [ssn] => 8802113533\n                            [address] => Bryggaregatan 32\n                            [town] => Helsingborg\n                            [country] => Sweden\n                        )\n\n                )\n\n        )\n\n    [sitePath] => /modiweb/\n    [currentPath] => \n    [rootPath] => \n    [c] => 0\n    [tempstr] => numbero\n    [GLOBALS] => Array\n *RECURSION*\n    [cPage] => \n    [msgs] => Array\n        (\n            [warnings] => Array\n                (\n                )\n\n            [notices] => Array\n                (\n                )\n\n        )\n\n    [showWarnings] => \n    [file] => 1\n    [filter] => Array\n        (\n            [0] => Array\n                (\n                    [name] => Test\n                    [url] => test\n                )\n\n            [1] => Array\n                (\n                    [name] => Vi testar\n                    [url] => numbero2\n                )\n\n        )\n\n    [v] => Array\n        (\n            [name] => Vi testar\n            [url] => numbero2\n        )\n\n    [k] => 1\n)\n');
/*!40000 ALTER TABLE `modiweb_log` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_orders
CREATE TABLE IF NOT EXISTS `modiweb_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinytext COLLATE utf32_bin NOT NULL,
  `client` int(11) NOT NULL,
  `products` text COLLATE utf32_bin NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `shipping` text COLLATE utf32_bin NOT NULL,
  `paymentType` text COLLATE utf32_bin NOT NULL,
  `hasPayed` text COLLATE utf32_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Alla ordrar';

-- Dumping data for table modiweb.modiweb_orders: ~0 rows (approximately)
/*!40000 ALTER TABLE `modiweb_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `modiweb_orders` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_pages
CREATE TABLE IF NOT EXISTS `modiweb_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` tinytext COLLATE utf32_bin,
  `name` tinytext COLLATE utf32_bin,
  `protected` int(1) NOT NULL DEFAULT '0',
  `inmenu` int(1) NOT NULL DEFAULT '1',
  `ord` int(4) DEFAULT NULL,
  `getVars` tinytext COLLATE utf32_bin,
  `description` text COLLATE utf32_bin,
  `url` tinytext COLLATE utf32_bin,
  `content` longtext COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Användarskapade sidor';

-- Dumping data for table modiweb.modiweb_pages: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_pages` DISABLE KEYS */;
INSERT INTO `modiweb_pages` (`id`, `parent`, `name`, `protected`, `inmenu`, `ord`, `getVars`, `description`, `url`, `content`) VALUES
	(16, NULL, 'productPage', 1, 1, NULL, 'product', 'Mallen för varje produktsida på sidan', NULL, '<div class="module">!MOD! ProduktKategoriTräd !ENDMOD!</div><h2>!GET! KEY_name FROM_products WHERE url IS \'!V! product !:!\' !ENDGET!</h2><p>!GET! KEY_desc_short FROM_products WHERE url IS \'!V! product !:!\' !ENDGET!</p><div class="module" style="display: inline;">!MOD! Produktbild !ENDMOD!</div><div class="module" style="margin: 0px 0px 0px 200px; display: block;">!MOD! Köpruta !ENDMOD!</div><div style="margin: 60px 0px 0px; display: block;"><div style="display: block;"></div></div><p>!GET! KEY_desc_long FROM_products WHERE url IS \'!V! product !:!\' !ENDGET!</p>'),
	(1, NULL, 'Hem', 0, 1, 1, NULL, 'Förstsidan', 'home', '<h1>Välkommen till ModiWeb!</h1><p style="margin: 0px; display: block;">Och tack så hemskt mycket för köpet!</p><p style="display: block; margin: 0px;">Innan er hemsida ligger ute live så är det bäst att ställa in alla inställningar och sånt först. Så följ dessa steg så är sidan snart igång.</p><h3 style="margin: 20px 0px 0px;">1. Ställ in inställningar</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Allra först så är det bäst att ställa in alla inställningarna för sidan. Det är då att namnge sidan, ställa in standardspråk, ställa in vilka ni är som äger sidan, kontaktuppgifter ifall någon behöver ta kontakt med er, osv. Alla dessa inställningar hittar ni när ni klickat er in på </p><a target="_blank" href="admin" data-ytta-id="-" style="display: inline;">Admin</a><p style="display: inline;">. Aktivera dock inte sidan ännu där. Det finns fler steg att gå igenom först.</p><h3 style="margin: 20px 0px 0px; display: block;">2. Fyll databaserna</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Nu är det dags att fylla er sida med information. Det är förstås bara ifall ni har köpt Shop-modulen eller har annan information ni vill kunna hämta till era sidor. Är det produkter ni ska fylla databasen med så är det   Admin - </p><a target="_blank" style="margin: 0px; display: inline;" href="admin_shop" data-ytta-id="-">Shop</a><p style="display: inline;">. Är det däremot någon annan information som inte ska användas primärt utav en modul, så kan ni lägga till och redigera informationen i vår </p><a target="_blank" href="admin_databaseeditor" style="display: inline;" data-ytta-id="-">Databashanterare</a><p style="display: inline; margin: 0px;">. </p><h3 style="margin: 20px 0px 0px;">3. Redigera hemsidans utseende</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Gå sen in i Admin - </p><a target="_blank" style="display: inline;" href="admin_maineditor">Huvudutseende</a><p style="display: inline;">. Där kan ni ändra er hemsida till precis det utseendet ni vill.</p><h3 style="margin: 20px 0px 0px;">4. Redigera era sidor</h3><p>Det näst sista steget är att redigera alla era sidor. Lägg till all den information ni vill ha på er hemsida, där ni vill ha den. Och det är enkelt att göra det. Gå till huvudmenyn och gå till den sidan ni vill redigera, ifall den redan finns förstås. Klicka sen helt enkelt på den ljusröda knappen "Redigera sidan" så kommer ni direkt till Redigeraren. Där kan ni lägga till och redigera text, bilder, tabeller, listor, moduler, och t o m vanlig kod, ifall ni skulle behöva det.</p><p>Där kan ni också redigera denna sidan, då detta är startsidan. Vänta dock med det till sist så att ni säkert inte behöver titta på denna listan igen.</p><h3 style="margin: 20px 0px 0px;">5. Aktivera sidan</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Och till sist, aktivera sidan! Gå in till </p><a target="_blank" style="display: inline; margin: 0px;" href="admin" data-ytta-id="-">Admin</a><p style="display: inline;">. </p>');
/*!40000 ALTER TABLE `modiweb_pages` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_pages_original
CREATE TABLE IF NOT EXISTS `modiweb_pages_original` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` tinytext COLLATE utf32_bin,
  `name` tinytext COLLATE utf32_bin,
  `getVars` tinytext COLLATE utf32_bin,
  `description` text COLLATE utf32_bin,
  `url` tinytext COLLATE utf32_bin,
  `content` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Användarskapade sidor';

-- Dumping data for table modiweb.modiweb_pages_original: ~1 rows (approximately)
/*!40000 ALTER TABLE `modiweb_pages_original` DISABLE KEYS */;
INSERT INTO `modiweb_pages_original` (`id`, `parent`, `name`, `getVars`, `description`, `url`, `content`) VALUES
	(17, NULL, 'productPage', NULL, 'Mallen för varje produktsida på sidan', NULL, NULL);
/*!40000 ALTER TABLE `modiweb_pages_original` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_paymentmethods
CREATE TABLE IF NOT EXISTS `modiweb_paymentmethods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminname` tinytext COLLATE utf32_bin NOT NULL,
  `name` tinytext COLLATE utf32_bin NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '0',
  `fetchfrom` text COLLATE utf32_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Types of paymentmethods';

-- Dumping data for table modiweb.modiweb_paymentmethods: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_paymentmethods` DISABLE KEYS */;
INSERT INTO `modiweb_paymentmethods` (`id`, `adminname`, `name`, `activated`, `fetchfrom`) VALUES
	(1, 'Klarna Faktura', 'klarnabill', 1, 'klarnaMethods'),
	(2, 'Payson', 'payson', 1, '');
/*!40000 ALTER TABLE `modiweb_paymentmethods` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_products
CREATE TABLE IF NOT EXISTS `modiweb_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf32_bin NOT NULL,
  `url` tinytext COLLATE utf32_bin NOT NULL,
  `cat` int(11) DEFAULT NULL,
  `desc_short` text COLLATE utf32_bin,
  `desc_long` text COLLATE utf32_bin,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `img` varchar(255) COLLATE utf32_bin NOT NULL DEFAULT 'none.png',
  `flags` text COLLATE utf32_bin,
  `upvotes` int(11) DEFAULT NULL,
  `downvotes` int(11) DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Produkterna för hemsidan';

-- Dumping data for table modiweb.modiweb_products: ~4 rows (approximately)
/*!40000 ALTER TABLE `modiweb_products` DISABLE KEYS */;
INSERT INTO `modiweb_products` (`id`, `name`, `url`, `cat`, `desc_short`, `desc_long`, `price`, `img`, `flags`, `upvotes`, `downvotes`) VALUES
	(1, 'testprodukt1', 'test-produkt1', 21, 'Första testet', 'Detta första test är så fruktansvärt häftig. Alltså, riktigt jäkla häftigt! Bara så fett coolt att alla är avundsjuka på denna produkten. Det är den bästaste någonsin. EVER!', 299.90, 'phone.jpg', 'sale', NULL, NULL),
	(2, 'test2', 'test2', 11, 'Andra produkten', 'Den andra produkten. Den är inte lika häftig. Alls. Faktiskt riktigt jäkla dålig.', 99.90, 'none.png', NULL, NULL, NULL),
	(3, 'dator', 'dator', 1, 'En billig dator', 'En av de billigare datorerna', 3299.00, 'com.jpg', NULL, NULL, NULL),
	(4, 'En mac', 'en-mac', 10, 'En dyr Mac', 'En jäkligt dyr pissMAC. Ingen som vill ha, förutom de som vill skryta om en fin dator.', 29999.00, 'none.png', NULL, NULL, NULL),
	(5, 'superdator', 'super', 17, 'Bästa', 'Bästa datorn någonsin', 25000.00, 'com.jpg', NULL, NULL, NULL),
	(6, 'mobil', 'enmobil', 12, 'En vanlig mobil', 'En telefon', 1999.00, 'phone.jpg', NULL, NULL, NULL);
/*!40000 ALTER TABLE `modiweb_products` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_products_categories
CREATE TABLE IF NOT EXISTS `modiweb_products_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext CHARACTER SET utf8 NOT NULL,
  `url` tinytext COLLATE utf32_bin,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Kategorierna till produkterna';

-- Dumping data for table modiweb.modiweb_products_categories: ~25 rows (approximately)
/*!40000 ALTER TABLE `modiweb_products_categories` DISABLE KEYS */;
INSERT INTO `modiweb_products_categories` (`id`, `name`, `url`, `parent`) VALUES
	(1, 'Datorer', 'datorer', NULL),
	(2, 'Telefoni', 'telefoni', NULL),
	(3, 'Nätverk', 'natverk', NULL),
	(4, 'Stationära', 'stationara', 1),
	(5, 'Bärbara', 'barbara', 1),
	(6, 'Plattor', 'plattor', 1),
	(7, 'PC', 'stat_pc', 4),
	(8, 'MAC', 'stat_mac', 4),
	(9, 'PC', 'laptops_pc', 5),
	(10, 'MAC', 'laptops_mac', 5),
	(11, 'Nätverkskort', 'natverkskort', 3),
	(12, 'Routrar, modem, servrar', 'routrarmodemservrar', 3),
	(13, 'Routrar', 'routrar', 12),
	(14, 'Modem', 'modem', 12),
	(15, 'Servrar', 'servrar', 12),
	(16, 'UNIX', 'unix', 15),
	(17, 'Linux', 'linux', 15),
	(18, 'Android', 'mobil_android', 19),
	(19, 'Mobiltelefoni', 'mobiltelefoni', 2),
	(20, 'iPhone', 'mobil_iphone', 19),
	(21, 'Windows', 'mobil_windows', 19),
	(22, 'Läsplattor', 'lasplattor', 6),
	(23, 'Android', 'plattor_android', 6),
	(24, 'Windows', 'plattor_windows', 6),
	(25, 'iPad', 'plattor_ipad', 6);
/*!40000 ALTER TABLE `modiweb_products_categories` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_shipping
CREATE TABLE IF NOT EXISTS `modiweb_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminname` tinytext COLLATE utf32_bin,
  `name` tinytext COLLATE utf32_bin,
  `activated` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Types of shipping';

-- Dumping data for table modiweb.modiweb_shipping: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_shipping` DISABLE KEYS */;
INSERT INTO `modiweb_shipping` (`id`, `adminname`, `name`, `activated`) VALUES
	(1, 'Posten', 'posten', 1),
	(2, 'DHL', 'dhl', 1);
/*!40000 ALTER TABLE `modiweb_shipping` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_statistics
CREATE TABLE IF NOT EXISTS `modiweb_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `script` text COLLATE utf32_bin,
  `page` text COLLATE utf32_bin,
  `ip` tinytext COLLATE utf32_bin,
  `gets` text COLLATE utf32_bin,
  `posts` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_statistics: ~7 rows (approximately)
/*!40000 ALTER TABLE `modiweb_statistics` DISABLE KEYS */;
INSERT INTO `modiweb_statistics` (`id`, `time`, `script`, `page`, `ip`, `gets`, `posts`) VALUES
	(40, '2015-03-13 15:56:10', '/modiWeb/page.php', 'statistics', '::1', '{\'_page\':\'statistics\'}', '[]'),
	(41, '2015-04-05 14:32:54', '/modiWeb/page.php', 'shop', '::1', '{\'_page\':\'shop\'}', '[]'),
	(42, '2015-04-05 14:36:57', '/modiWeb/page.php', 'counter', '::1', '{\'_page\':\'counter\'}', '[]'),
	(43, '2015-04-05 14:37:42', '/modiWeb/page.php', 'shop', '::1', '{\'_page\':\'shop\'}', '[]'),
	(44, '2015-04-05 14:37:43', '/modiWeb/page.php', 'p_en-mac', '::1', '{\'_page\':\'product\',\'product\':\'en-mac\'}', '[]'),
	(45, '2015-04-05 14:37:45', '/modiWeb/page.php', 'shop', '::1', '{\'_page\':\'shop\'}', '[]'),
	(46, '2015-04-05 14:37:53', '/modiWeb/page.php', 'p_test-produkt1', '::1', '{\'_page\':\'product\',\'product\':\'test-produkt1\'}', '[]');
/*!40000 ALTER TABLE `modiweb_statistics` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_texts
CREATE TABLE IF NOT EXISTS `modiweb_texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `content` text NOT NULL,
  `align` tinytext NOT NULL,
  `float` tinytext NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='Alla texter på sidan';

-- Dumping data for table modiweb.modiweb_texts: ~11 rows (approximately)
/*!40000 ALTER TABLE `modiweb_texts` DISABLE KEYS */;
INSERT INTO `modiweb_texts` (`id`, `name`, `content`, `align`, `float`) VALUES
	(1, 'hemtext1', 'ModiWeb är ett enklare sätt för dig att hantera din hemsida. Det mesta går att ändra på väldigt enkla sätt samtidigt som du kan göra praktiskt taget vad som helst.\r\nDu kan skapa nya sidor och lägga till dem i huvudmenyn var du vill.\r\nPå sidorna kan du ändra varje textstycke helt själv och direkt få se resultatet.', '', ''),
	(2, 'hemtext2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed porttitor cursus lorem sit amet commodo. Ut quis purus lacus. Nunc sed lorem ac mauris malesuada eleifend. Aliquam erat volutpat. Suspendisse feugiat diam ut massa consequat tristique. Curabitur ultrices justo urna, vel porttitor justo dictum sit amet. Curabitur non nibh tincidunt, consectetur nulla ut, vestibulum sem. Maecenas ullamcorper ligula et sodales tempor. Nam blandit, ante in elementum maximus, risus nisi tincidunt velit, at cursus est nisl nec mauris. Sed sed metus augue.', '', ''),
	(3, 'hem', 'Hej och välkommen!', '', ''),
	(4, 'sitedown_title', 'Sidan ligger nere', '', ''),
	(5, 'sitedown_text', 'Sidan ligger för närvarande nere', '', ''),
	(6, 'copyright', '&copy; Upphovsrättsskyddad 2015 av David Andersson', '', ''),
	(7, 'loginerror', 'Ett fel inträffade vid inloggning. Har du skrivit rätt användarnamn och/eller lösenord?', '', ''),
	(8, 'logoutnotice', 'Du har blivit utloggad.', '', ''),
	(9, 'test1', 'Testsidan', '', ''),
	(11, 'test2', 'Detta är en liten testsida som jag leker lite med.', '', ''),
	(12, 'test3', 'Alltså. Bara lite. Okej, kanske mest på denna sidan. Speciellt just nu. ', '', '');
/*!40000 ALTER TABLE `modiweb_texts` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_users
CREATE TABLE IF NOT EXISTS `modiweb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` tinytext COLLATE utf32_bin NOT NULL,
  `password` tinytext COLLATE utf32_bin NOT NULL,
  `contactid` int(11) NOT NULL,
  `lang` tinytext COLLATE utf32_bin NOT NULL,
  `rights` tinytext COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Users of the page';

-- Dumping data for table modiweb.modiweb_users: ~1 rows (approximately)
/*!40000 ALTER TABLE `modiweb_users` DISABLE KEYS */;
INSERT INTO `modiweb_users` (`id`, `username`, `password`, `contactid`, `lang`, `rights`) VALUES
	(1, 'admin', '$2WDW3kZP7foI', 1, 'SE', 'AU');
/*!40000 ALTER TABLE `modiweb_users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
