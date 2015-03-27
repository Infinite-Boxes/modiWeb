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

-- Dumping structure for table modiweb.config_site
CREATE TABLE IF NOT EXISTS `config_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `admname` tinytext COLLATE utf32_bin,
  `val` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Configuration for the site';

-- Dumping data for table modiweb.config_site: ~3 rows (approximately)
/*!40000 ALTER TABLE `config_site` DISABLE KEYS */;
INSERT INTO `config_site` (`id`, `name`, `admname`, `val`) VALUES
	(1, 'title', 'title', 'ModiWeb'),
	(2, 'owner', 'owner', 'Infinite-Boxes'),
	(3, 'default_lang', 'default_lang', 'SE');
/*!40000 ALTER TABLE `config_site` ENABLE KEYS */;


-- Dumping structure for table modiweb.contactdetails
CREATE TABLE IF NOT EXISTS `contactdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` tinytext COLLATE utf32_bin NOT NULL,
  `middlenames` tinytext COLLATE utf32_bin,
  `sirname` tinytext COLLATE utf32_bin,
  `ssn` tinytext COLLATE utf32_bin,
  `address` tinytext COLLATE utf32_bin,
  `town` tinytext COLLATE utf32_bin,
  `country` tinytext COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Kontaktdetaljer. Namn, adress osv';

-- Dumping data for table modiweb.contactdetails: ~1 rows (approximately)
/*!40000 ALTER TABLE `contactdetails` DISABLE KEYS */;
INSERT INTO `contactdetails` (`id`, `firstname`, `middlenames`, `sirname`, `ssn`, `address`, `town`, `country`) VALUES
	(1, 'David', 'Elias Christoffer', 'Andersson', '8802113533', 'Bryggaregatan 32', 'Helsingborg', 'Sweden');
/*!40000 ALTER TABLE `contactdetails` ENABLE KEYS */;


-- Dumping structure for table modiweb.images
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `url` text COLLATE utf32_bin,
  `alt` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.images: ~2 rows (approximately)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` (`id`, `name`, `url`, `alt`) VALUES
	(7, 'idé', 'img/user/imagination.png', 'Nya idéer!'),
	(10, 'rammstien', 'img/user/77164.png', 'Du hast. Du hast kod');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;


-- Dumping structure for table modiweb.lang
CREATE TABLE IF NOT EXISTS `lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `lang` varchar(2) COLLATE utf32_bin NOT NULL DEFAULT 'SE',
  `val` text COLLATE utf32_bin,
  UNIQUE KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.lang: ~18 rows (approximately)
/*!40000 ALTER TABLE `lang` DISABLE KEYS */;
INSERT INTO `lang` (`id`, `name`, `lang`, `val`) VALUES
	(1, 'currency', 'SE', 'kr'),
	(2, 'currency', 'US', '$'),
	(3, 'category', 'SE', 'Kategori'),
	(4, 'category', 'US', 'Category'),
	(5, 'everything', 'SE', 'Allt'),
	(6, 'everything', 'US', 'Everything'),
	(7, 'incl_subcategories', 'SE', 'Inkl. underkategorier'),
	(8, 'incl_subcategories', 'US', 'Incl. subcategories'),
	(9, 'excl_subcategories', 'SE', 'Exkl. underkategorier'),
	(10, 'excl_subcategories', 'US', 'Excl. subcategories'),
	(11, 'price', 'SE', 'Pris'),
	(12, 'price', 'US', 'Price'),
	(13, 'name', 'SE', 'Namn'),
	(14, 'name', 'US', 'Name'),
	(15, 'asc', 'SE', 'Uppåt'),
	(16, 'desc', 'SE', 'Nedåt'),
	(17, 'asc', 'US', 'Ascending'),
	(18, 'desc', 'US', 'Descending');
/*!40000 ALTER TABLE `lang` ENABLE KEYS */;


-- Dumping structure for table modiweb.log
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinytext COLLATE utf32_bin NOT NULL,
  `message` tinytext COLLATE utf32_bin NOT NULL,
  `path` tinytext COLLATE utf32_bin NOT NULL,
  `vardump` mediumtext COLLATE utf32_bin NOT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Errorlogging, with var-dumping etc.';

-- Dumping data for table modiweb.log: ~0 rows (approximately)
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` (`id`, `time`, `type`, `message`, `path`, `vardump`) VALUES
	(1, '2015-03-13 12:37:20', 'error', '2: include(numbero.php): failed to open stream: No such file or', 'C:/xampp/htdocs/modiWeb/page.php', 'Array\n(\n    [_GET] => Array\n        (\n            [_page] => numbero\n        )\n\n    [_POST] => Array\n        (\n        )\n\n    [_COOKIE] => Array\n        (\n            [PHPSESSID] => gmmuo38j4qihnjqner51mpo0e6\n        )\n\n    [_FILES] => Array\n        (\n        )\n\n    [_SERVER] => Array\n        (\n            [REDIRECT_MIBDIRS] => C:/xampp/php/extras/mibs\n            [REDIRECT_MYSQL_HOME] => xamppmysqlin\n            [REDIRECT_OPENSSL_CONF] => C:/xampp/apache/bin/openssl.cnf\n            [REDIRECT_PHP_PEAR_SYSCONF_DIR] => xamppphp\n            [REDIRECT_PHPRC] => xamppphp\n            [REDIRECT_TMP] => xampp	mp\n            [REDIRECT_STATUS] => 200\n            [MIBDIRS] => C:/xampp/php/extras/mibs\n            [MYSQL_HOME] => xamppmysqlin\n            [OPENSSL_CONF] => C:/xampp/apache/bin/openssl.cnf\n            [PHP_PEAR_SYSCONF_DIR] => xamppphp\n            [PHPRC] => xamppphp\n            [TMP] => xampp	mp\n            [HTTP_HOST] => localhost\n            [HTTP_CONNECTION] => keep-alive\n            [HTTP_CACHE_CONTROL] => max-age=0\n            [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\n            [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36\n            [HTTP_REFERER] => http://localhost/modiWeb/test\n            [HTTP_ACCEPT_ENCODING] => gzip, deflate, sdch\n            [HTTP_ACCEPT_LANGUAGE] => en-US,en;q=0.8,sv;q=0.6\n            [HTTP_COOKIE] => PHPSESSID=gmmuo38j4qihnjqner51mpo0e6\n            [PATH] => C:ProgramDataOracleJavajavapath;C:Program Files (x86)InteliCLS Client;C:Program FilesInteliCLS Client;C:windowssystem32;C:windows;C:windowsSystem32Wbem;C:windowsSystem32WindowsPowerShellv1.0;C:Program FilesIntelIntel(R) Management Engine ComponentsDAL;C:Program FilesIntelIntel(R) Management Engine ComponentsIPT;C:Program Files (x86)IntelIntel(R) Management Engine ComponentsDAL;C:Program Files (x86)IntelIntel(R) Management Engine ComponentsIPT;C:Program FilesLenovoBluetooth Software;C:Program FilesLenovoBluetooth Softwaresyswow64;C:Program FilesMicrosoft SQL Server110ToolsBinn;C:Program Files (x86)Microsoft SDKsTypeScript1.0\n            [SystemRoot] => C:windows\n            [COMSPEC] => C:windowssystem32cmd.exe\n            [PATHEXT] => .COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC\n            [WINDIR] => C:windows\n            [SERVER_SIGNATURE] => <address>Apache/2.4.9 (Win32) OpenSSL/1.0.1g PHP/5.5.11 Server at localhost Port 80</address>\n\n            [SERVER_SOFTWARE] => Apache/2.4.9 (Win32) OpenSSL/1.0.1g PHP/5.5.11\n            [SERVER_NAME] => localhost\n            [SERVER_ADDR] => ::1\n            [SERVER_PORT] => 80\n            [REMOTE_ADDR] => ::1\n            [DOCUMENT_ROOT] => C:/xampp/htdocs\n            [REQUEST_SCHEME] => http\n            [CONTEXT_PREFIX] => \n            [CONTEXT_DOCUMENT_ROOT] => C:/xampp/htdocs\n            [SERVER_ADMIN] => postmaster@localhost\n            [SCRIPT_FILENAME] => C:/xampp/htdocs/modiWeb/page.php\n            [REMOTE_PORT] => 52057\n            [REDIRECT_QUERY_STRING] => _page=numbero\n            [REDIRECT_URL] => /modiWeb/numbero\n            [GATEWAY_INTERFACE] => CGI/1.1\n            [SERVER_PROTOCOL] => HTTP/1.1\n            [REQUEST_METHOD] => GET\n            [QUERY_STRING] => _page=numbero\n            [REQUEST_URI] => /modiWeb/numbero\n            [SCRIPT_NAME] => /modiWeb/page.php\n            [PHP_SELF] => /modiWeb/page.php\n            [REQUEST_TIME_FLOAT] => 1426246640.186\n            [REQUEST_TIME] => 1426246640\n        )\n\n    [_SESSION] => Array\n        (\n            [prepage] => error.php?e=404\n            [rid] => $1$dP..ix/.$K2MgbjEyEE7oxzul9fg1o.\n            [user] => Array\n                (\n                    [base] => Array\n                        (\n                            [id] => 1\n                            [username] => admin\n                            [password] => $2WDW3kZP7foI\n                            [contactid] => 64\n                            [lang] => SE\n                        )\n\n                    [contactdetails] => Array\n                        (\n                            [id] => 64\n                            [firstname] => David\n                            [middlenames] => Elias Christoffer\n                            [sirname] => Andersson\n                            [ssn] => 8802113533\n                            [address] => Bryggaregatan 32\n                            [town] => Helsingborg\n                            [country] => Sweden\n                        )\n\n                )\n\n        )\n\n    [sitePath] => /modiweb/\n    [currentPath] => \n    [rootPath] => \n    [c] => 0\n    [tempstr] => numbero\n    [GLOBALS] => Array\n *RECURSION*\n    [cPage] => \n    [msgs] => Array\n        (\n            [warnings] => Array\n                (\n                )\n\n            [notices] => Array\n                (\n                )\n\n        )\n\n    [showWarnings] => \n    [file] => 1\n    [filter] => Array\n        (\n            [0] => Array\n                (\n                    [name] => Test\n                    [url] => test\n                )\n\n            [1] => Array\n                (\n                    [name] => Vi testar\n                    [url] => numbero2\n                )\n\n        )\n\n    [v] => Array\n        (\n            [name] => Vi testar\n            [url] => numbero2\n        )\n\n    [k] => 1\n)\n');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;


-- Dumping structure for table modiweb.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` tinytext COLLATE utf32_bin,
  `name` tinytext COLLATE utf32_bin,
  `getVars` tinytext COLLATE utf32_bin,
  `description` text COLLATE utf32_bin,
  `url` tinytext COLLATE utf32_bin,
  `content` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Användarskapade sidor';

-- Dumping data for table modiweb.pages: ~2 rows (approximately)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `parent`, `name`, `getVars`, `description`, `url`, `content`) VALUES
	(8, NULL, 'Om oss', NULL, 'En informationssida om företaget', 'about', '<div class="img" id="el0" style="float: left; clear: right; max-width: 100px;"><img src="img/user/imagination.png"><p class="subtext">Nya idéer!</p></div><h1 id="el1" style="text-align: left;">Om oss</h1><p id="el2" style="display: block;">Det är vi som är ModiWeb. Vårt mål är inte att vara bäst. Det är inte heller att lösa alla era bekymmer. Vårt mål är att göra något unikt. Något som inte är den bästa versionen av det ni önskar. Utan något som är något helt nytt.</p>'),
	(16, NULL, 'productPage', NULL, 'Mallen för varje produktsida på sidan', NULL, '<p id="el0">Nytt text-element</p>');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;


-- Dumping structure for table modiweb.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf32_bin NOT NULL,
  `url` tinytext COLLATE utf32_bin NOT NULL,
  `cat` int(11) DEFAULT NULL,
  `desc_short` text COLLATE utf32_bin,
  `desc_long` text COLLATE utf32_bin,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `img` text COLLATE utf32_bin,
  `flags` text COLLATE utf32_bin,
  `upvotes` int(11) DEFAULT NULL,
  `downvotes` int(11) DEFAULT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Produkterna för hemsidan';

-- Dumping data for table modiweb.products: ~4 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `url`, `cat`, `desc_short`, `desc_long`, `price`, `img`, `flags`, `upvotes`, `downvotes`) VALUES
	(1, 'testprodukt1', 'test-produkt1', 21, 'Första testet', 'Detta första test är så¨fruktansvärt häftig. Alltså, riktigt jäkla häftigt! Bara så fett coolt att alla är avundsjuka på denna produkten. Det är den bästaste någonsin. EVER!', 299.90, 'phone.jpg', 'sale', NULL, NULL),
	(2, 'test2', 'test2', 11, 'Andra produkten', 'Den andra produkten. Den är inte lika häftig. Alls. Faktiskt riktigt jäkla dålig', 99.90, NULL, NULL, NULL, NULL),
	(3, 'dator', 'dator', 1, 'En billig dator', 'En av de billigare datorerna', 3299.00, NULL, NULL, NULL, NULL),
	(4, 'En mac', 'en-mac', 10, 'En dyr Mac', 'En jäkligt dyr pissMAC. Ingen som vill ha, förutom de som vill skryta om en fin dator.', 29999.00, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Dumping structure for table modiweb.products_categories
CREATE TABLE IF NOT EXISTS `products_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext CHARACTER SET utf8 NOT NULL,
  `url` tinytext COLLATE utf32_bin,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Kategorierna till produkterna';

-- Dumping data for table modiweb.products_categories: ~25 rows (approximately)
/*!40000 ALTER TABLE `products_categories` DISABLE KEYS */;
INSERT INTO `products_categories` (`id`, `name`, `url`, `parent`) VALUES
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
/*!40000 ALTER TABLE `products_categories` ENABLE KEYS */;


-- Dumping structure for table modiweb.statistics
CREATE TABLE IF NOT EXISTS `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `script` text COLLATE utf32_bin,
  `page` text COLLATE utf32_bin,
  `ip` tinytext COLLATE utf32_bin,
  `gets` text COLLATE utf32_bin,
  `posts` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.statistics: ~1 rows (approximately)
/*!40000 ALTER TABLE `statistics` DISABLE KEYS */;
INSERT INTO `statistics` (`id`, `time`, `script`, `page`, `ip`, `gets`, `posts`) VALUES
	(40, '2015-03-13 15:56:10', '/modiWeb/page.php', 'statistics', '::1', '{\'_page\':\'statistics\'}', '[]');
/*!40000 ALTER TABLE `statistics` ENABLE KEYS */;


-- Dumping structure for table modiweb.texts
CREATE TABLE IF NOT EXISTS `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `content` text NOT NULL,
  `align` tinytext NOT NULL,
  `float` tinytext NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='Alla texter på sidan';

-- Dumping data for table modiweb.texts: ~11 rows (approximately)
/*!40000 ALTER TABLE `texts` DISABLE KEYS */;
INSERT INTO `texts` (`id`, `name`, `content`, `align`, `float`) VALUES
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
/*!40000 ALTER TABLE `texts` ENABLE KEYS */;


-- Dumping structure for table modiweb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` tinytext COLLATE utf32_bin NOT NULL,
  `password` tinytext COLLATE utf32_bin NOT NULL,
  `contactid` int(11) NOT NULL,
  `lang` tinytext COLLATE utf32_bin NOT NULL,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Users of the page';

-- Dumping data for table modiweb.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `contactid`, `lang`) VALUES
	(1, 'admin', '$2WDW3kZP7foI', 1, 'SE');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
