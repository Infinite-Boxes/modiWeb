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

-- Dumping data for table modiweb.modiweb_config_site: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_config_site` DISABLE KEYS */;
INSERT INTO `modiweb_config_site` (`id`, `name`, `admname`, `val`) VALUES
	(1, 'title', 'title', 'ModiWeb'),
	(2, 'owner', 'owner', 'Infinite-Boxes'),
	(3, 'default_lang', 'default_lang', 'SE');
/*!40000 ALTER TABLE `modiweb_config_site` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_lang
CREATE TABLE IF NOT EXISTS `modiweb_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `lang` varchar(2) COLLATE utf32_bin NOT NULL DEFAULT 'SE',
  `val` text COLLATE utf32_bin,
  `protected` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_lang: ~23 rows (approximately)
/*!40000 ALTER TABLE `modiweb_lang` DISABLE KEYS */;
INSERT INTO `modiweb_lang` (`id`, `name`, `lang`, `val`, `protected`) VALUES
	(1, 'currency', 'SE', 'kr', 0),
	(2, 'currency', 'US', '$', 0),
	(3, 'category', 'SE', 'Kategori', 0),
	(4, 'category', 'US', 'Category', 0),
	(5, 'everything', 'SE', 'Allt', 0),
	(6, 'everything', 'US', 'Everything', 0),
	(7, 'incl_subcategories', 'SE', 'Inkl. underkategorier', 0),
	(8, 'incl_subcategories', 'US', 'Incl. subcategories', 0),
	(9, 'excl_subcategories', 'SE', 'Exkl. underkategorier', 0),
	(10, 'excl_subcategories', 'US', 'Excl. subcategories', 0),
	(11, 'price', 'SE', 'Pris', 0),
	(12, 'price', 'US', 'Price', 0),
	(13, 'name', 'SE', 'Namn', 0),
	(14, 'name', 'US', 'Name', 0),
	(15, 'asc', 'SE', 'Uppåt', 0),
	(16, 'desc', 'SE', 'Nedåt', 0),
	(17, 'asc', 'US', 'Ascending', 0),
	(18, 'desc', 'US', 'Descending', 0),
	(19, 'documentation_editor_databases', 'SE', '<a href="documentation">Dokumentation</a> - <a href="documentation_editor">Redigeraren</a>\r\n<p>Du kan använda enklare databaser på din hemsida genom Redigeraren. Detta kan du göra varsomhelst i redigeraren där du kan skriva in text (text för titlar och vanliga textobjekt, adress för bilder, länkar osv, eller värden som bredden på en bild t ex). Där skriver du då olika nyckelord för vad du vill få fram för information. Nyckelorden <b>MÅSTE</b> skrivas in i den följd de visas nedan. De är följande:</p>\r\n<table class="documentationtable">\r\n<tr>\r\n<td><p><b>!GET!</b></p></td><td><p>Måste skrivas allra först och informerar systemet om att den ska hämta information från databasen.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>KEY_*</b></p></td><td><p>Bestämmer vilken information du vill hämta. Istället för asterisken (*) så skriver du vilken tabellcell från databasen (du kan se en lista över tillgängliga databas-tabeller och deras celler nedan. Du kan också använda ett par andra nyckelord.<br />\r\n<b>KEY_COUNT_*</b> räknar antalet celler som informationen finns i.<br />\r\n<b>KEY_SUM_*</b> summerar alla värden i tabellraden.<br />\r\n<b>KEY_MAX_*</b> hämtar det högsta av värdena.<br />\r\n<b>KEY_MIN_*</b> hämtar det minsta av värdena.<br />\r\n<b>KEY_AVG_*</b> hämtar det genomsnittliga värdet.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>FROM_*</b></p></td><td><p>Vilken tabell informationen ska hämtas från. Tabellnamnen står listade nedan.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>WHERE * IS *</b></p></td><td><p>Där tabellcellens text/värde är lika med den andra asterisken. DU kan använda AND efter detta för att bestämma mer detaljerat exakt vad du vill ha. <br />Här kan du också använda de variabler som sidan kan ta emot. Om du t ex har länkat till sidan med en variabel (sidansnamn?variabel=värde) så kan du använda den variabeln i databasfrågan genom att skriva "!V!variabelnamnet!:!" utan citationstecken. Tänk på att variabelnamnen <b>INTE</b> kan innehålla mellanrum.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>!ENDGET!</b></p></td><td><p>Avslutar förfrågan till databasen och <b>MÅSTE</b> vara sist.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>!TRUEGET!</b></p></td><td><p>Du kan också använda detta nyckelord om du vill använda riktiga MySQL-satser. Tänk på att bara använda detta ifall du är <b>helt säker</b> på vad du gör då detta kan krasha din hemsida om det används felaktigt.</p></td>\r\n</tr>\r\n<tr>\r\n<td><p><b>!ENDTRUEGET!</b></p></td><td><p>Avslutar en riktig MySQL-sats.</p></td>\r\n</tr>\r\n</table>\r\n<p><b>*</b><i> Ifall ett nyckelnamn innehåller mellanrum så <b>MÅSTE</b> du använda ENKLA citationstecken ( \' ) runt namnet. T ex WHERE user IS "main admin".</i></p>\r\n<p><b>*</b><i> Ifall resultatet består utav mer än ett värde (t ex att du får flera användare när du frågar efter alla användare med "language IS SE") så kommer resultaten visas på varsin rad.</i></p>\r\n<h3>Exempel</h3>\r\n<pre>\r\n!GET! KEY_namn FROM_users WHERE phone IS 0731234567 !ENDGET!\r\n!TRUEGET! SELECT namn FROM users WHERE phone = 0731234567 !ENDTRUGET!\r\n</pre>\r\n<pre>\r\n!GET! KEY_username FROM_users WHERE user IS admin AND password IS 1234 !ENDGET!\r\n!TRUEGET! SELECT username FROM users WHERE user = "admin" AND password = 1234 !ENDTRUGET!\r\n</pre>\r\n<pre>\r\n!GET! KEY_"användare namn" FROM_users WHERE adress IS "Järnvägsgatan 11" !ENDGET!\r\n!TRUEGET! SELECT "användare namn" FROM users WHERE adress = "Järnvägsgatan 11" !ENDTRUGET!\r\n</pre>\r\n<pre>\r\n!GET! KEY_SUM_names FROM_users WHERE language IS SE !ENDGET!\r\n!TRUEGET! SELECT SUM(names) FROM users WHERE language = "SE" !ENDTRUGET!\r\n</pre>', 1),
	(20, 'err_404', 'SE', '<h1>404</h1>\n<p>Oj. Hur hamnade du här? Denna sidan finns ju inte.</p>', 0),
	(21, 'err_404', 'US', '<h1>404</h1>\n<p>Oh my. How did you end up here? This page doesn\'t exist.</p>', 0),
	(22, 'documentation_editor', 'SE', '<p>Välkommen för dokumentationen för redigeraren. Redigeraren är ett kraftfullt men främst enkelt verktyg som gör att du som användare kan redigera dina sidor på ett enkelt sätt. Detta har vi gjort av en enda anledning. För att du ska spara pengar så du slipper anställa oss vid vartenda liten uppdatering av sidan. Självklart hjälper vi dig gärna ändå, men på detta sättet kan du själv göra alla de ändringar du vill få gjorda.</p>\r\n<h3>Övesikt</h3>\r\n<a href="documentation_editor_databases">Databaser. Hur du hämtar data från dem.</a>', 1),
	(23, 'limit_exceeded_variables', 'SE', 'För många variabler i dokumentet!', 0),
	(24, 'unknown_error', 'SE', 'Ett okänt fel upptäcktes.', 0),
	(25, 'limit_exceeded_functions', 'SE', 'För många funktioner i dokumentet!', 0);
/*!40000 ALTER TABLE `modiweb_lang` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_pages
CREATE TABLE IF NOT EXISTS `modiweb_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` tinytext COLLATE utf32_bin,
  `name` tinytext COLLATE utf32_bin,
  `getVars` tinytext COLLATE utf32_bin,
  `description` text COLLATE utf32_bin,
  `url` tinytext COLLATE utf32_bin,
  `content` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Användarskapade sidor';

-- Dumping data for table modiweb.modiweb_pages: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_pages` DISABLE KEYS */;
INSERT INTO `modiweb_pages` (`id`, `parent`, `name`, `getVars`, `description`, `url`, `content`) VALUES
	(8, NULL, 'Om oss', NULL, 'En informationssida om företaget', 'about', '\n\n\n<div class="img" style="float: left; clear: right; max-width: 100px;"><img src="img/user/imagination.png"><p class="subtext">Nya idéer!</p></div><h1 style="text-align: left;">Om oss</h1><p style="display: block;">Det är vi som är ModiWeb. Vårt mål är inte att vara bäst. Det är inte heller att lösa alla era bekymmer. Vårt mål är att göra något unikt. Något som inte är den bästa versionen av det ni önskar. Utan något som är något helt nytt.</p>'),
	(16, NULL, 'productPage', 'product', 'Mallen för varje produktsida på sidan', NULL, '<div class="module">!MOD! ProduktKategoriTräd !ENDMOD!</div><table class="chosen" style="float: none; clear: right;"><tbody><tr><td style="border: none;"><h3>!GET! KEY_name FROM_products WHERE url IS "!V! product !:!" !ENDGET!</h3></td></tr><tr><td style="border: none;"><p>!GET! KEY_desc_short FROM_products WHERE url IS "!V! product !:!" !ENDGET!</p></td></tr></tbody></table><div class="module" style="display: inline;">!MOD! Produktbild !ENDMOD!</div><div class="module" style="display: block; margin: 0px 0px 0px 300px;">!MOD! Köpruta !ENDMOD!</div><div class=""><div style="clear: both;"></div></div><p style="float: none; display: block;" class="">!GET! KEY_desc_long FROM_products WHERE url IS "!V! product !:!" !ENDGET!</p>');
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

-- Dumping data for table modiweb.modiweb_pages_original: ~0 rows (approximately)
/*!40000 ALTER TABLE `modiweb_pages_original` DISABLE KEYS */;
INSERT INTO `modiweb_pages_original` (`id`, `parent`, `name`, `getVars`, `description`, `url`, `content`) VALUES
	(17, NULL, 'productPage', NULL, 'Mallen för varje produktsida på sidan', NULL, NULL);
/*!40000 ALTER TABLE `modiweb_pages_original` ENABLE KEYS */;


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
	(3, 'dator', 'dator', 1, 'En billig dator', 'En av de billigare datorerna', 3299.00, 'none.png', NULL, NULL, NULL),
	(4, 'En mac', 'en-mac', 10, 'En dyr Mac', 'En jäkligt dyr pissMAC. Ingen som vill ha, förutom de som vill skryta om en fin dator.', 29999.00, 'none.png', NULL, NULL, NULL);
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
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
