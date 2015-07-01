-- --------------------------------------------------------
-- Värd:                         127.0.0.1
-- Server version:               5.6.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.2.0.4947
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Configuration for the site';

-- Dumping data for table modiweb.modiweb_config_site: ~4 rows (approximately)
/*!40000 ALTER TABLE `modiweb_config_site` DISABLE KEYS */;
INSERT INTO `modiweb_config_site` (`id`, `name`, `admname`, `val`) VALUES
	(1, 'title', 'title', 'ModiWeb'),
	(2, 'owner', 'owner', 'Infinite-Boxes'),
	(3, 'default_lang', 'default_lang', 'SE'),
	(4, 'favicon', 'favicon', 'favicon.png');
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
  `email` text COLLATE utf32_bin,
  `phonenumber` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Kontaktdetaljer. Namn, adress osv';

-- Dumping data for table modiweb.modiweb_contactdetails: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_contactdetails` DISABLE KEYS */;
INSERT INTO `modiweb_contactdetails` (`id`, `firstname`, `middlenames`, `sirname`, `ssn`, `address`, `postalcode`, `town`, `country`, `email`, `phonenumber`) VALUES
	(1, 'David', 'Elias Christoffer', 'Andersson', '8802113533', 'Bryggaregatan 32', 25227, 'Helsingborg', 'Sweden', 'rrx_88@hotmail.com', '0739772996'),
	(31, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'testse', NULL);
/*!40000 ALTER TABLE `modiweb_contactdetails` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_cronjobs
CREATE TABLE IF NOT EXISTS `modiweb_cronjobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin NOT NULL,
  `type` tinytext COLLATE utf32_bin NOT NULL,
  `rule` tinytext COLLATE utf32_bin NOT NULL,
  `func` text COLLATE utf32_bin NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_cronjobs: ~1 rows (approximately)
/*!40000 ALTER TABLE `modiweb_cronjobs` DISABLE KEYS */;
INSERT INTO `modiweb_cronjobs` (`id`, `name`, `type`, `rule`, `func`, `finished`) VALUES
	(1, 'test', 'ONCE', '2015-06-25 22:35', 'cronjobs::test("woho")', 0);
/*!40000 ALTER TABLE `modiweb_cronjobs` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_images
CREATE TABLE IF NOT EXISTS `modiweb_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `url` text COLLATE utf32_bin,
  `alt` text COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_images: ~1 rows (approximately)
/*!40000 ALTER TABLE `modiweb_images` DISABLE KEYS */;
INSERT INTO `modiweb_images` (`id`, `name`, `url`, `alt`) VALUES
	(7, 'Logo', 'img/user/logo.png', 'Logotyp');
/*!40000 ALTER TABLE `modiweb_images` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_lang
CREATE TABLE IF NOT EXISTS `modiweb_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf32_bin,
  `lang` varchar(2) COLLATE utf32_bin NOT NULL DEFAULT 'SE',
  `val` text COLLATE utf32_bin,
  `protected` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_lang: ~246 rows (approximately)
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
	(20, 'err_404', 'SE', 'Den sidan existerar inte!', 0),
	(21, 'err_404', 'EN', 'That page does not exist!', 0),
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
	(39, 'shop_smsnotice', 'SE', 'Telefonnumret behövs ifall du vill få en SMS-påminnelse.', 0),
	(40, 'clientinformation', 'SE', 'Uppgifter', 0),
	(41, 'shipping', 'SE', 'Frakt', 0),
	(42, 'payment', 'SE', 'Betalning', 0),
	(43, 'done', 'SE', 'Klart', 0),
	(44, 'shop_shippinginfo', 'SE', 'Vilket fraktsätt vill du använda?', 0),
	(45, 'username', 'SE', 'Användarnamn', 0),
	(46, 'password', 'SE', 'Lösenord', 0),
	(47, 'login', 'SE', 'Logga in', 0),
	(48, 'login', 'EN', 'Login', 0),
	(49, 'logout', 'SE', 'Logga ut', 0),
	(50, 'productname', 'SE', 'Produktnamn', 0),
	(51, 'add', 'SE', 'Lägg till', 0),
	(52, 'url', 'SE', 'Webbadress', 0),
	(53, 'shortdescription', 'SE', 'Kort beskrivning', 0),
	(54, 'longdescription', 'SE', 'Lång beskrivning', 0),
	(55, 'img', 'SE', 'Bild', 0),
	(56, 'flags', 'SE', 'Flaggor', 0),
	(57, 'sale', 'SE', 'Rea', 0),
	(58, 'shop_err_missname', 'SE', 'Produkten saknar namn.', 0),
	(59, 'shop_err_missurl', 'SE', 'Produkten saknar adress.', 0),
	(60, 'shop_err_misscat', 'SE', 'Produkten saknar kategori.', 0),
	(61, 'shop_err_missdshort', 'SE', 'Produkten saknar kort beskrivning.', 0),
	(62, 'shop_err_missdlong', 'SE', 'Produkten saknar lång beskrivning.', 0),
	(63, 'shop_err_missprice', 'SE', 'Produkten saknar pris.', 0),
	(64, 'shop_err_imgexistsnot', 'SE', 'Bilden verkar inte finnas, så vi har valt en tom bild för produkten.', 0),
	(65, 'shop_limitedproduct', 'SE', 'Begränsad upplaga', 0),
	(66, 'activated', 'SE', 'Aktiverad', 0),
	(67, 'shop_err_imgforbiddenhotlink', 'SE', 'Bilden existerar men originalsidan tillåter inte länkning.', 0),
	(68, 'restricted_page', 'SE', 'Du är inte behörig att besöka den delen av sidan', 0),
	(69, 'shop_missing_product', 'SE', 'Denna produkten finns inte.', 0),
	(70, 'updated_form', 'SE', 'Formuläret har uppdaterats.', 0),
	(71, 'shop_missing_paymentmethod', 'SE', 'Du måste välja en betalningsmetod.', 0),
	(72, 'search', 'SE', 'Sök', 0),
	(73, 'yes', 'SE', 'Ja', 0),
	(74, 'no', 'SE', 'Nej', 0),
	(75, 'yes', 'EN', 'Yes', 0),
	(76, 'no', 'EN', 'No', 0),
	(77, 'shop_dialog_removeitem', 'SE', 'Vill du ta bort denna produkten?', 0),
	(78, 'shop_dialog_removeitem', 'EN', 'Do you wish to remove this product?', 0),
	(79, 'news', 'SE', 'Nyheter', 0),
	(80, 'news', 'EN', 'News', 0),
	(81, 'searchingforupdates', 'SE', 'Söker efter uppdateringar', 0),
	(82, 'searchingforupdates', 'EN', 'Searching for updates', 0),
	(83, 'mypage', 'SE', 'Min sida', 0),
	(84, 'myinformation', 'SE', 'Mina uppgifter', 0),
	(85, 'myinformation', 'EN', 'My information', 0),
	(86, 'language', 'SE', 'Språk', 0),
	(87, 'language', 'EN', 'Language', 0),
	(88, 'rights', 'SE', 'Rättigheter', 0),
	(89, 'rights', 'EN', 'Rights', 0),
	(90, 'user', 'SE', 'Användare', 0),
	(91, 'admin', 'SE', 'Administratör', 0),
	(92, 'user', 'EN', 'User', 0),
	(93, 'admin', 'EN', 'Admin', 0),
	(94, 'activated', 'EN', 'Activated', 0),
	(95, 'add', 'EN', 'Add', 0),
	(96, 'address', 'EN', 'Address', 0),
	(97, 'clientinformation', 'EN', 'Information', 0),
	(98, 'done', 'EN', 'Done', 0),
	(99, 'email', 'EN', 'E-mail', 0),
	(100, 'flags', 'EN', 'Flags', 0),
	(101, 'img', 'EN', 'Image', 0),
	(102, 'limit_exceeded_functions', 'EN', 'Too many functions in the document!', 0),
	(103, 'limit_exceeded_variables', 'EN', 'Too many variables in the document!', 0),
	(104, 'logout', 'EN', 'Logout', 0),
	(105, 'longdescription', 'EN', 'Long description', 0),
	(106, 'missing_address', 'EN', 'You need to enter your address.', 0),
	(107, 'missing_name', 'EN', 'You need to enter your name.', 0),
	(108, 'missing_postalcity', 'EN', 'You need to enter your postal city.', 0),
	(109, 'missing_postalnumber', 'EN', 'You need to enter your postalnumber.', 0),
	(110, 'mypage', 'EN', 'My page', 0),
	(111, 'password', 'EN', 'Password', 0),
	(112, 'payment', 'EN', 'Payment', 0),
	(113, 'phonenumber', 'EN', 'Phonenumber', 0),
	(114, 'postalcity', 'EN', 'Postal city', 0),
	(115, 'postalnumber', 'EN', 'Postalnumber', 0),
	(116, 'postalnumber_notice', 'EN', 'Format: First Avenue 2b', 0),
	(117, 'productname', 'EN', 'Productname', 0),
	(118, 'restricted_page', 'EN', 'You are not authorized to visit that part of the site.', 0),
	(119, 'sale', 'EN', 'Sale', 0),
	(120, 'search', 'EN', 'Search', 0),
	(121, 'shipping', 'EN', 'Shipping', 0),
	(122, 'shop_err_imgexistsnot', 'EN', 'We\'ve chosen an empty image since the chosen image doesn\'t seem to exist.', 0),
	(123, 'shop_err_imgforbiddenhotlink', 'EN', 'The image exist, but the source-site doesn\'t allow linking.', 0),
	(124, 'shop_err_misscat', 'EN', 'There\'s no category for the product.', 0),
	(125, 'shop_err_missdlong', 'EN', 'There\'s no long description for the product.', 0),
	(126, 'shop_err_missdshort', 'EN', 'There\'s no short description for the product.', 0),
	(127, 'shop_err_missname', 'EN', 'There\'s no name for the product.', 0),
	(128, 'shop_err_missprice', 'EN', 'There\'s no price for the product.', 0),
	(129, 'shop_err_missurl', 'EN', 'There\'s no URL for the product.', 0),
	(130, 'shop_limitedproduct', 'EN', 'Limited edition', 0),
	(131, 'shop_missing_paymentmethod', 'EN', 'You need to choose a method of payment.', 0),
	(132, 'shop_missing_product', 'EN', 'This product does not exist.', 0),
	(133, 'shop_shippinginfo', 'EN', 'Which type of transport do you want?', 0),
	(134, 'shop_smsnotice', 'EN', 'You need a phonenumber if you wish an SMS-notice.', 0),
	(135, 'shoppingCart', 'EN', 'Shoppingcart', 0),
	(136, 'shortdescription', 'EN', 'Short description', 0),
	(137, 'unknown_error', 'EN', 'An unknown error has occured.', 0),
	(138, 'updated_form', 'EN', 'The form has been updated.', 0),
	(139, 'url', 'EN', 'Webaddress', 0),
	(140, 'username', 'EN', 'Username', 0),
	(141, 'firstname', 'SE', 'Förnamn', 0),
	(142, 'firstname', 'EN', 'Firstname', 0),
	(143, 'middlenames', 'SE', 'Mellannamn', 0),
	(144, 'middlenames', 'EN', 'Middlenames', 0),
	(145, 'sirname', 'SE', 'Efternamn', 0),
	(146, 'sirname', 'EN', 'Sirname', 0),
	(147, 'ssn', 'SE', 'Personnummer', 0),
	(148, 'ssn', 'EN', 'Social Security Number', 0),
	(152, 'postalcode', 'SE', 'Postkod', 0),
	(153, 'postalcode', 'EN', 'Postalcode', 0),
	(154, 'town', 'SE', 'Postort', 0),
	(155, 'town', 'EN', 'Town', 0),
	(156, 'country', 'SE', 'Land', 0),
	(157, 'country', 'EN', 'Land', 0),
	(160, 'update', 'SE', 'Uppdatera', 0),
	(161, 'update', 'EN', 'Update', 0),
	(162, 'description', 'SE', 'Beskrivning', 0),
	(163, 'description', 'EN', 'Description', 0),
	(164, 'position', 'SE', 'Position', 0),
	(165, 'position', 'EN', 'Position', 0),
	(166, 'searchable', 'SE', 'Sökbar', 0),
	(167, 'searchable', 'EN', 'Searchable', 0),
	(168, 'subpagefor', 'SE', 'Undersida', 0),
	(169, 'subpagefor', 'EN', 'Subpage', 0),
	(170, 'subpage', 'SE', 'Undersida', 0),
	(171, 'subpage', 'EN', 'Subpage', 0),
	(172, 'pagecreated', 'SE', 'Sidan har skapats.', 0),
	(173, 'pagecreated', 'EN', 'The page has been created.', 0),
	(174, 'error_pagenotcreated', 'SE', 'Sidan kunde inte skapas.', 0),
	(175, 'error_pagenotcreated', 'EN', 'The page could not be created.', 0),
	(176, 'error_missingfollowing', 'SE', 'Fel. Följande uppgifter saknas: ', 0),
	(177, 'error_missingfollowing', 'EN', 'Error. Following information are missing: ', 0),
	(178, 'setval', 'SE', 'Ändra till ', 0),
	(179, 'setval', 'EN', 'Set to ', 0),
	(180, 'setvaldone', 'SE', 'Ändrade till ', 0),
	(181, 'setvaldone', 'EN', 'Has set to ', 0),
	(182, 'default', 'SE', 'Standard', 0),
	(183, 'default', 'EN', 'Default', 0),
	(184, 'inmenu', 'SE', 'I meny', 0),
	(185, 'inmenu', 'EN', 'In menu', 0),
	(186, 'notinmenu', 'SE', 'Inte i menu', 0),
	(187, 'notinmenu', 'EN', 'Not in menu', 0),
	(188, 'none', 'SE', 'Ingen', 0),
	(189, 'none', 'EN', 'None', 0),
	(190, 'custom', 'SE', 'Anpassad', 0),
	(191, 'custom', 'EN', 'Custom', 0),
	(192, 'target', 'SE', 'Mål', 0),
	(193, 'target', 'EN', 'Target', 0),
	(194, 'newwindow', 'SE', 'Nytt fönster', 0),
	(195, 'newwindow', 'EN', 'New window', 0),
	(196, 'samewindow', 'SE', 'Samma fönster', 0),
	(197, 'samewindow', 'EN', 'Same window', 0),
	(198, 'register', 'SE', 'Skapa konto', 0),
	(199, 'register', 'EN', 'Create account', 0),
	(200, 'submit', 'SE', 'Skicka', 0),
	(201, 'submit', 'EN', 'Submit', 0),
	(202, 'and', 'SE', 'och', 0),
	(203, 'and', 'EN', 'and', 0),
	(204, 'usercreated', 'SE', 'Användaren har skapats.', 0),
	(205, 'usercreated', 'EN', 'The user has been created.', 0),
	(206, 'error_usernotcreated', 'SE', 'Användaren kunde inte skapas.', 0),
	(207, 'error_usernotcreated', 'EN', 'User could not be created.', 0),
	(208, 'userexists', 'SE', 'Användaren finns redan.', 0),
	(209, 'userexists', 'EN', 'The user already exists.', 0),
	(210, 'setlang', 'SE', 'Du har ändrat språk till: ', 0),
	(211, 'setlang', 'EN', 'You\'ve changed language to: ', 0),
	(212, 'editpage', 'SE', 'Redigera sidan', 0),
	(213, 'editpage', 'EN', 'Edit page', 0),
	(216, 'type', 'SE', 'Typ', 0),
	(217, 'type', 'EN', 'Type', 0),
	(218, 'parent', 'SE', 'Överordnad', 0),
	(219, 'parent', 'EN', 'Parent', 0),
	(220, 'protected', 'SE', 'Skyddad', 0),
	(221, 'protected', 'EN', 'Protected', 0),
	(222, 'order', 'SE', 'Ordning', 0),
	(223, 'order', 'EN', 'Order', 0),
	(226, 'vars', 'SE', 'Variabler', 0),
	(227, 'vars', 'EN', 'Variables', 0),
	(228, 'deletable', 'SE', 'Möjlig att radera', 0),
	(229, 'deletable', 'EN', 'Deletable', 0),
	(230, 'loadtime1', 'SE', 'Sidan laddades på', 0),
	(231, 'loadtime1', 'EN', 'Page loaded in', 0),
	(232, 'loadtime2', 'SE', 'sekunder.', 0),
	(233, 'loadtime2', 'EN', 'seconds.', 0),
	(234, 'back', 'SE', 'Tillbaka', 0),
	(235, 'back', 'EN', 'Back', 0),
	(236, 'isdeletable', 'SE', 'Sidan går att radera', 0),
	(237, 'isdeletable', 'EN', 'Page is deletable', 0),
	(238, 'notdeletable', 'SE', 'Sidan går INTE att radera', 0),
	(239, 'notdeletable', 'EN', 'Page is NOT deletable', 0),
	(240, 'isprotected', 'SE', 'Sidan är skyddad', 0),
	(241, 'isprotected', 'EN', 'Page is protected', 0),
	(242, 'notprotected', 'SE', 'Sidan är inte skyddad', 0),
	(243, 'notprotected', 'EN', 'Page is not protected', 0),
	(245, 'header', 'SE', 'Sidhuvud', 0),
	(246, 'header', 'EN', 'Header', 0),
	(247, 'footer', 'SE', 'Sidfot', 0),
	(248, 'footer', 'EN', 'Footer', 0),
	(249, 'page', 'SE', 'Sida', 0),
	(250, 'page', 'EN', 'Page', 0),
	(251, 'save', 'SE', 'Spara', 0),
	(252, 'save', 'EN', 'Save', 0),
	(253, 'alreadyloggedin', 'SE', 'Du är redan inloggad.', 0),
	(254, 'alreadyloggedin', 'EN', 'You have already logged in.', 0),
	(255, 'mail_nofrom', 'SE', 'Ingen avsändare vald.', 0),
	(256, 'mail_nofrom', 'EN', 'No account to send from chosen.', 0);
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
	(1, 'Svenska', 'SE'),
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


-- Dumping structure for table modiweb.modiweb_news
CREATE TABLE IF NOT EXISTS `modiweb_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf32_bin,
  `tid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text COLLATE utf32_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- Dumping data for table modiweb.modiweb_news: ~0 rows (approximately)
/*!40000 ALTER TABLE `modiweb_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `modiweb_news` ENABLE KEYS */;


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
  `type` tinytext COLLATE utf32_bin,
  `lang` varchar(3) COLLATE utf32_bin DEFAULT NULL,
  `prefunction` text COLLATE utf32_bin,
  `deletable` tinyint(1) NOT NULL DEFAULT '1',
  `protected` int(1) NOT NULL DEFAULT '0',
  `inmenu` int(1) NOT NULL DEFAULT '1',
  `ord` int(4) DEFAULT NULL,
  `searchable` int(1) NOT NULL DEFAULT '1',
  `getVars` tinytext COLLATE utf32_bin,
  `description` text COLLATE utf32_bin,
  `url` tinytext COLLATE utf32_bin,
  `content` longtext COLLATE utf32_bin,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Användarskapade sidor';

-- Dumping data for table modiweb.modiweb_pages: ~5 rows (approximately)
/*!40000 ALTER TABLE `modiweb_pages` DISABLE KEYS */;
INSERT INTO `modiweb_pages` (`id`, `parent`, `name`, `type`, `lang`, `prefunction`, `deletable`, `protected`, `inmenu`, `ord`, `searchable`, `getVars`, `description`, `url`, `content`) VALUES
	(16, NULL, 'productPage', NULL, '', 'shop::productExist', 0, 0, 0, NULL, 0, 'product', 'Mallen för varje produktsida på sidan', 'product', '<div class="module">!MOD! ProduktKategoriTräd !ENDMOD!</div><h2>!GET! KEY_name FROM_products WHERE url IS \'!V! product !:!\' !ENDGET!</h2><p>!GET! KEY_desc_short FROM_products WHERE url IS \'!V! product !:!\' !ENDGET!</p><div class="module" style="display: inline;">!MOD! Produktbild !ENDMOD!</div><div class="module" style="margin: 0px 0px 0px 200px; display: block;">!MOD! Köpruta !ENDMOD!</div><div style="margin: 60px 0px 0px; display: block;"><div style="display: block;"></div></div><p>!GET! KEY_desc_long FROM_products WHERE url IS \'!V! product !:!\' !ENDGET!</p>'),
	(1, NULL, 'Hem', NULL, 'SE', NULL, 0, 0, 1, 1, 1, NULL, 'Förstasidan', 'home', '<h1>Välkommen till ModiWeb!</h1><p style="margin: 0px; display: block;">Och tack så hemskt mycket för köpet!</p><p style="display: block; margin: 0px;">Innan er hemsida ligger ute live så är det bäst att ställa in alla inställningar och sånt först. Så följ dessa steg så är sidan snart igång.</p><h3 style="margin: 20px 0px 0px;">1. Ställ in inställningar</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Allra först så är det bäst att ställa in alla inställningarna för sidan. Det är då att namnge sidan, ställa in standardspråk, ställa in vilka ni är som äger sidan, kontaktuppgifter ifall någon behöver ta kontakt med er, osv. Alla dessa inställningar hittar ni när ni klickat er in på </p><a target="_blank" href="admin" data-ytta-id="-" style="display: inline;">Admin</a><p style="display: inline;">. Aktivera dock inte sidan ännu där. Det finns fler steg att gå igenom först.</p><h3 style="margin: 20px 0px 0px; display: block;">2. Fyll databaserna</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Nu är det dags att fylla er sida med information. Det är förstås bara ifall ni har köpt Shop-modulen eller har annan information ni vill kunna hämta till era sidor. Är det produkter ni ska fylla databasen med så är det   Admin - </p><a target="_blank" style="margin: 0px; display: inline;" href="admin_shop" data-ytta-id="-">Shop</a><p style="display: inline;">. Är det däremot någon annan information som inte ska användas primärt utav en modul, så kan ni lägga till och redigera informationen i vår </p><a target="_blank" href="admin_databaseeditor" style="display: inline;" data-ytta-id="-">Databashanterare</a><p style="display: inline; margin: 0px;">. </p><h3 style="margin: 20px 0px 0px;">3. Redigera hemsidans utseende</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Gå sen in i Admin - </p><a target="_blank" style="display: inline;" href="admin_maineditor">Huvudutseende</a><p style="display: inline;">. Där kan ni ändra er hemsida till precis det utseendet ni vill.</p><h3 style="margin: 20px 0px 0px;">4. Redigera era sidor</h3><p>Det näst sista steget är att redigera alla era sidor. Lägg till all den information ni vill ha på er hemsida, där ni vill ha den. Och det är enkelt att göra det. Gå till huvudmenyn och gå till den sidan ni vill redigera, ifall den redan finns förstås. Klicka sen helt enkelt på den ljusröda knappen "Redigera sidan" så kommer ni direkt till Redigeraren. Där kan ni lägga till och redigera text, bilder, tabeller, listor, moduler, och t o m vanlig kod, ifall ni skulle behöva det.</p><p>Där kan ni också redigera denna sidan, då detta är startsidan. Vänta dock med det till sist så att ni säkert inte behöver titta på denna listan igen.</p><h3 style="margin: 20px 0px 0px;">5. Aktivera sidan</h3><p style="display: inline; margin: 0px 0px 0px 10px;">Och till sist, aktivera sidan! Gå in till </p><a target="_blank" style="display: inline; margin: 0px;" href="admin" data-ytta-id="-">Admin</a><p style="display: inline;">. </p>'),
	(18, NULL, 'EULA', NULL, '', NULL, 1, 0, 1, NULL, 1, NULL, 'Licens och termer för denna produkt.', 'licenseandterms', '<h1>EULA - End User License Agreement</h1><h3>Terms that is used in this document</h3><p><b>"We"</b> : Refers to Infinite Boxes.</p><p><b>"Client"</b> and/or <b>"User"</b> : The end user. The person or company that the license is bought. </p>'),
	(32, NULL, 'footer', 'footer', 'SE', NULL, 0, 0, 0, NULL, 0, NULL, 'Footer', NULL, '<p style="display: block">© Upphovsrättsskyddad 2015 av Infinite Boxes</p><div class="module">!MOD! LoadingTime !ENDMOD!</div>'),
	(34, NULL, 'header', 'header', 'SE', NULL, 0, 0, 0, NULL, 0, NULL, 'Header', NULL, '\n<div class="module">!MOD! languageButton !ENDMOD!</div><div class="img containerFreeImg"><img tabindex="1" src="img/user/logo.png"></div>');
/*!40000 ALTER TABLE `modiweb_pages` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_paymentmethods
CREATE TABLE IF NOT EXISTS `modiweb_paymentmethods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminname` tinytext COLLATE utf32_bin NOT NULL,
  `name` tinytext COLLATE utf32_bin NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '0',
  `info` text COLLATE utf32_bin,
  `fetchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Types of paymentmethods';

-- Dumping data for table modiweb.modiweb_paymentmethods: ~3 rows (approximately)
/*!40000 ALTER TABLE `modiweb_paymentmethods` DISABLE KEYS */;
INSERT INTO `modiweb_paymentmethods` (`id`, `adminname`, `name`, `activated`, `info`, `fetchid`) VALUES
	(1, 'Klarna Faktura', 'klarna invoice ', 1, 'Betala med faktura.', -1),
	(2, 'Payson', 'payson', 1, 'Betala med payson!', NULL),
	(3, 'Klarna Avbetalning', 'klarna partpayment', 1, '', NULL);
/*!40000 ALTER TABLE `modiweb_paymentmethods` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_products
CREATE TABLE IF NOT EXISTS `modiweb_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf32_bin NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Produkterna för hemsidan';

-- Dumping data for table modiweb.modiweb_products: ~6 rows (approximately)
/*!40000 ALTER TABLE `modiweb_products` DISABLE KEYS */;
INSERT INTO `modiweb_products` (`id`, `name`, `active`, `url`, `cat`, `desc_short`, `desc_long`, `price`, `img`, `flags`, `upvotes`, `downvotes`) VALUES
	(1, 'testprodukt1', 1, 'test-produkt1', 21, 'Första testet', 'Detta första test är så fruktansvärt häftig. Alltså, riktigt jäkla häftigt! Bara så fett coolt att alla är avundsjuka på denna produkten. Det är den bästaste någonsin. EVER!', 299.90, 'phone.jpg', 'S', NULL, NULL),
	(2, 'test2', 1, 'test2-_', 11, 'Andra produkten', 'Den andra produkten. Den är inte lika häftig. Alls. Faktiskt riktigt jäkla dålig.', 99.90, 'none.png', NULL, NULL, NULL),
	(3, 'dator', 1, 'dator', 1, 'En billig dator', 'En av de billigare datorerna', 3299.00, 'com.jpg', NULL, NULL, NULL),
	(4, 'En mac', 1, 'en-mac', 10, 'En dyr Mac', 'En jäkligt dyr pissMAC. Ingen som vill ha, förutom de som vill skryta om en fin dator.', 29999.00, 'none.png', NULL, NULL, NULL),
	(5, 'superdator', 1, 'super', 17, 'Bästa', 'Bästa datorn någonsin', 25000.00, 'com.jpg', NULL, NULL, NULL),
	(6, 'mobil', 1, 'enmobil', 20, 'En vanlig mobil', 'En telefon', 1999.00, 'phone.jpg', NULL, NULL, NULL);
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
	(6, 'copyright', '&copy Upphovsrättsskyddad 2015 av David Andersson', '', ''),
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Users of the page';

-- Dumping data for table modiweb.modiweb_users: ~2 rows (approximately)
/*!40000 ALTER TABLE `modiweb_users` DISABLE KEYS */;
INSERT INTO `modiweb_users` (`id`, `username`, `password`, `contactid`, `lang`, `rights`) VALUES
	(1, 'admin', '$2WDW3kZP7foI', 1, 'SE', 'AU'),
	(22, 'test', '$2rcByx51ejoM', 31, 'SE', 'U');
/*!40000 ALTER TABLE `modiweb_users` ENABLE KEYS */;


-- Dumping structure for table modiweb.modiweb_users_requiredfields
CREATE TABLE IF NOT EXISTS `modiweb_users_requiredfields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` tinytext COLLATE utf32_bin NOT NULL,
  `user` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf32 COLLATE=utf32_bin COMMENT='Required fields for a useraccount';

-- Dumping data for table modiweb.modiweb_users_requiredfields: ~13 rows (approximately)
/*!40000 ALTER TABLE `modiweb_users_requiredfields` DISABLE KEYS */;
INSERT INTO `modiweb_users_requiredfields` (`id`, `field`, `user`, `admin`) VALUES
	(1, 'username', 1, 1),
	(2, 'password', 1, 1),
	(3, 'lang', 1, 1),
	(4, 'email', 1, 1),
	(5, 'ssn', 0, 1),
	(6, 'firstname', 1, 1),
	(7, 'middlenames', 0, 0),
	(8, 'sirname', 0, 1),
	(9, 'address', 0, 1),
	(10, 'postalcode', 0, 1),
	(11, 'town', 0, 1),
	(12, 'country', 0, 1),
	(13, 'phonenumber', 0, 1);
/*!40000 ALTER TABLE `modiweb_users_requiredfields` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
