-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 14 feb 2013 kl 00:18
-- Serverversion: 5.5.27
-- PHP-version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `company_1`
--
CREATE DATABASE `company_1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `company_1`;

-- --------------------------------------------------------

--
-- Tabellstruktur `businesses`
--

CREATE TABLE IF NOT EXISTS `businesses` (
  `business_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_secret` varchar(10) NOT NULL,
  `business` text NOT NULL,
  `custom_field_1` text,
  `custom_field_2` text,
  `custom_field_3` text,
  `company_name` text NOT NULL,
  `company_adress` text,
  `company_box` text,
  `company_zip_code` text,
  `company_city` text,
  `company_country` text,
  `company_phone` text,
  `company_mail` text,
  `company_site` text,
  `company_bank` text,
  `company_orgnr` text,
  `company_color` varchar(6) NOT NULL DEFAULT '000000',
  UNIQUE KEY `type_id` (`business_id`),
  KEY `business_secret` (`business_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `businesses`
--

INSERT INTO `businesses` (`business_id`, `business_secret`, `business`, `custom_field_1`, `custom_field_2`, `custom_field_3`, `company_name`, `company_adress`, `company_box`, `company_zip_code`, `company_city`, `company_country`, `company_phone`, `company_mail`, `company_site`, `company_bank`, `company_orgnr`, `company_color`) VALUES
(1, '54y645cfy4', 'Svensk krÃ¤fta', '', '', '', 'MaRob Aktiviteter AB', 'Klockarbol', '', '64393', 'VingÃ¥ker', 'Sverige', '82731000', 'info@vallaservice.se', NULL, NULL, NULL, '000000'),
(2, '452fg6h345', 'Torggran', '', '', '', 'MaRob Aktiviteter AB', 'Klockarbol', '', '64393', 'VingÃ¥ker', 'Sverige', '82731000', 'info@vallaservice.se', NULL, NULL, NULL, '000000'),
(3, '43g5345hj3', 'Vallaservice', 'Lopp', 'InlÃ¤mningsort', '', 'MaRob Aktiviteter AB', 'Klockarbol', '', '64393', 'VingÃ¥ker', 'Sverige', '82731000', 'info@vallaservice.se', 'vallaservice.se', 'xyz', '556780-4835', '050161');

-- --------------------------------------------------------

--
-- Tabellstruktur `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_secret` varchar(200) DEFAULT NULL,
  `business` int(10) NOT NULL,
  `registered` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) DEFAULT 'private',
  `mail` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `customer_adress` text,
  `box` text,
  `zip_code` text,
  `city` text,
  `country` text,
  `notes` text,
  PRIMARY KEY (`customer_id`),
  KEY `registered` (`registered`),
  KEY `customer_secret` (`customer_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_secret`, `business`, `registered`, `name`, `type`, `mail`, `phone`, `customer_adress`, `box`, `zip_code`, `city`, `country`, `notes`) VALUES
(1, '', 3, 'true', 'Customer 1', 'private', 'email@me.com', '07012345678', 'Invoice adress', 'Box', 'Zip code', 'City', 'Country', 'Notes');

-- --------------------------------------------------------

--
-- Tabellstruktur `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_secret` varchar(10) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `status` text NOT NULL,
  `date` int(11) NOT NULL,
  `due` int(11) NOT NULL,
  `discount` float NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `customer` (`customer`),
  KEY `invoice_secret` (`invoice_secret`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_secret`, `invoice_number`, `business`, `customer`, `status`, `date`, `due`, `discount`, `notes`) VALUES
(2, 'i8o4yhyt58', 2, 3, 1, 'unpaid', 1360367923, 1383433200, 50, ''),
(3, 'tshdklxat7', 1, 3, 1, 'unpaid', 1360421543, 1362956400, 0, 'n&ouml;tter!'),
(4, 'enji3orpb6', 2, 3, 1, 'unpaid', 1360685294, 1360623600, 0, '');

-- --------------------------------------------------------

--
-- Tabellstruktur `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `invoice` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `price` int(10) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `order` (`order`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumpning av Data i tabell `items`
--

INSERT INTO `items` (`item_id`, `product`, `order`, `invoice`, `quantity`, `price`) VALUES
(1, 1, 1, 0, 1, 1),
(7, 2, 0, 2, 2, 41),
(3, 2, 2, 0, 2, 41),
(4, 4, 2, 0, 1, 45),
(5, 21, 2, 0, 1, 49),
(6, 9, 2, 0, 1, 11),
(8, 4, 0, 2, 1, 45),
(9, 9, 0, 2, 1, 11),
(10, 21, 0, 2, 1, 49),
(11, 1, 0, 3, 1, 46),
(12, 2, 3, 0, 1, 41),
(13, 2, 0, 4, 1, 41),
(14, 2, 4, 0, 1, 41);

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_secret` varchar(10) NOT NULL,
  `order_number` int(10) DEFAULT NULL,
  `date` int(11) NOT NULL,
  `business` int(10) NOT NULL,
  `delivery_adress` text,
  `delivery` varchar(20) NOT NULL,
  `delivery_date` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `customer` int(10) NOT NULL,
  `notes` text,
  `custom_1` text,
  `custom_2` text,
  `custom_3` text,
  UNIQUE KEY `order_id` (`order_id`),
  KEY `business` (`business`),
  KEY `order_number` (`order_number`),
  KEY `order_secret` (`order_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`order_id`, `order_secret`, `order_number`, `date`, `business`, `delivery_adress`, `delivery`, `delivery_date`, `status`, `customer`, `notes`, `custom_1`, `custom_2`, `custom_3`) VALUES
(1, '1y8atdwo40', 1, 1359208519, 3, '', 'none', 1360331640, 'completed', 1, 'n&ouml;tter!', '', '', ''),
(2, 'o01r3td59n', 2, 1360359247, 3, '', 'none', 1360359180, 'active', 1, '', '', '', ''),
(3, '9l9wiyz89c', 50, 1360685279, 3, '', 'none', 1361290020, 'active', 1, '', '', '', ''),
(4, 't6zr5vhdub', 6, 1360714391, 3, '', 'none', 1361319120, 'active', 1, '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  `unit` text NOT NULL,
  `date` int(15) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumpning av Data i tabell `prices`
--

INSERT INTO `prices` (`price_id`, `price`, `unit`, `date`) VALUES
(1, 1400, 'st', 1358792867),
(2, 700, 'st', 1358936332),
(3, 800, 'st', 1358936436),
(4, 1000, 'st', 1358936544),
(5, 1400, 'st', 1358936636),
(6, 1000, 'st', 1358936808),
(7, 550, 'st', 1358936867),
(8, 450, 'st', 1358937003),
(9, 450, 'st', 1358937070),
(10, 250, 'st', 1358937144),
(11, 250, 'st', 1358937190),
(12, 200, 'st', 1358937283),
(13, 700, 'st', 1359106477),
(14, 800, 'st', 1359106563),
(15, 1000, 'st', 1359106690),
(16, 1400, 'st', 1359106808),
(17, 1000, 'st', 1359106881),
(18, 550, 'st', 1359106920),
(19, 450, 'st', 1359107045),
(20, 450, 'st', 1359107136),
(21, 250, 'st', 1359107175),
(22, 200, 'st', 1359107204),
(23, 1000, 'st', 1359107222),
(24, 200, 'st', 1359107243),
(25, 0, 'st', 1359137408),
(26, 700, 'st', 1359193542),
(27, 800, 'st', 1359193584),
(28, 700, 'st', 1359193623),
(29, 1000, 'st', 1359193718),
(30, 1400, 'st', 1359193749),
(31, 700, 'st', 1359193769),
(32, 700, 'st', 1359193791),
(33, 700, 'st', 1359204755),
(34, 800, 'st', 1359204814),
(35, 1000, 'st', 1359204850),
(36, 1400, 'st', 1359204879),
(37, 700, 'st', 1359205962),
(38, 800, 'st', 1359205998),
(39, 1000, 'st', 1359206017),
(40, 1400, 'st', 1359206042),
(41, 700, 'st', 1359206099),
(42, 800, 'st', 1359206117),
(43, 1000, 'st', 1359206151),
(44, 1400, 'st', 1359206302),
(45, 1400, 'st', 1359213882),
(46, 1000, 'st', 1359213918),
(47, 200, 'st', 1359214509),
(48, 0, 'st', 1359505614),
(49, 0, 'st', 1359505647),
(50, 0, 'st', 1359535175),
(51, 0, 'st', 1359537511),
(52, 0, 'st', 1359537563),
(53, 0, 'st', 1359537626),
(54, 0, 'st', 1359548292),
(55, 700, 'st', 1359548303),
(56, 800, 'st', 1359548311),
(57, 1000, 'st', 1359548318),
(58, 0, 'st', 1359548320),
(59, 1400, 'st', 1359548329),
(60, 1000, 'st', 1359548335),
(61, 200, 'st', 1359548342),
(62, 550, 'st', 1359548351),
(63, 450, 'st', 1359548358),
(64, 450, 'st', 1359548366),
(65, 0, 'st', 1359548415),
(66, 0, 'st', 1359548537),
(67, 700, 'st', 1359548609),
(68, 800, 'st', 1359548636),
(69, 800, 'st', 1359548652),
(70, 1000, 'st', 1359548671),
(71, 1400, 'st', 1359548694),
(72, 700, 'st', 1359549192),
(73, 800, 'st', 1359549207),
(74, 1000, 'st', 1359549231),
(75, 1400, 'st', 1359549252),
(76, 0, 'st', 1359564208),
(77, 0, 'st', 1359564475),
(78, 0, 'st', 1359564516),
(79, 0, 'st', 1359564598),
(80, 0, 'st', 1359564616),
(81, 1000, 'st', 1360054107),
(82, 1400, 'st', 1360054840),
(83, 1400, 'st', 1360054841),
(84, 2400, 'st', 1360323032),
(85, 2400, 'st', 1360323371),
(86, 2400, 'st', 1360323453),
(87, 2400, 'st', 1360323581),
(88, 2400, 'st', 1360323639);

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_secret` varchar(10) NOT NULL,
  `product_number` varchar(30) NOT NULL DEFAULT '0',
  `business` int(10) NOT NULL,
  `product` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `status` varchar(20) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `notes` varchar(2000) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `business` (`business`),
  KEY `product_secret` (`product_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`product_id`, `product_secret`, `product_number`, `business`, `product`, `price`, `status`, `description`, `notes`, `date`) VALUES
(1, '2ym7in9vld', 'Paket Raceing 1', 3, '- Raceing 1 - Kuz + f&auml;ste + hf', 46, 'available', '', '', 1358792867),
(2, '7rveuh4axx', 'Paket Motion 1', 3, '- Motion 1 - Kuzmin + f&auml;ste', 41, 'available', '', '', 1358936332),
(3, 'obh909hqx3', 'Paket Motion 2', 3, '- Motion 2 - Kuzmin + f&auml;ste + rill', 42, 'available', '', '', 1358936436),
(4, 'veevlbj10l', 'Paket Raceing 2', 3, '- Raceing 2 - Kuz + f&auml;ste + hf + pulver', 45, 'available', '', '', 1358936636),
(5, 'rq9bfx7fmc', 'Praparering 1', 3, 'H&ouml;gflour + pulver + f&auml;ste', 6, 'available', 'F&ouml;r er med skidor som redan &auml;r stenslipade eller kuzmin sicklade ', '', 1358936808),
(6, 'p4scn4qk99', 'Preparering 2', 3, 'Kuzminsickling', 7, 'available', '', '', 1358936867),
(7, 'mpbcajdwaz', 'Preparering 3', 3, 'H&ouml;gflour', 8, 'available', '', '', 1358937003),
(8, '3q9y5kzw6g', 'Preparering 4', 3, 'Pulvervallning', 9, 'available', '', '', 1358937070),
(9, 'qd3stz1v8r', 'Preparering 5', 3, 'F&auml;ste', 11, 'available', '', '', 1358937144),
(10, '9zfg3bi3z2', 'Preparering 6', 3, 'Reng&ouml;ring', 12, 'available', '', '', 1358937283),
(11, 'srlx12o2pu', 'Paket Motion 1', 1, 'Pkt Motion 1 - Kuzmin + f&auml;ste', 32, 'deleted', '', '', 1359106477),
(12, 'urd2zlz0ar', 'Paket motion 2', 1, 'Pkt Motion 2 - Kuzmin + f&auml;ste + rill', 27, 'deleted', '', '', 1359106563),
(13, 'efy2t9ouc4', 'Paket Raceing 1', 1, 'Pkt Raceing 1 - Kuzmin + f&auml;ste + h&ouml;gflou', 29, 'deleted', '', '', 1359106690),
(14, 'k0ndfr9y1v', 'Paket Raceing 2', 1, 'Pkt Raceing 2 - Kuzmin + f&auml;ste + h&ouml;gflou', 30, 'deleted', '', '', 1359106808),
(15, 'ip125ggtjs', 'Preparering 1', 1, 'H&ouml;gflour + pulver + f&auml;ste', 23, 'deleted', '', 'Anv&auml;nds till redan st&aring;lsicklade eller stenslipade skidor', 1359106881),
(16, 'ja87rnsk17', 'Preparering 2', 1, 'Kuzminsickling', 18, 'deleted', '', '', 1359106920),
(17, 'a7e16rcyog', 'Preparering 3', 1, 'H&ouml;gflour', 19, 'deleted', '', '', 1359107045),
(18, '5yl91a3xh5', 'Preparering 4', 1, 'Pulvervallning', 20, 'deleted', '', '', 1359107136),
(19, 'hfolbhjmwq', 'Preparering 5', 1, 'F&auml;ste', 21, 'deleted', '', '', 1359107175),
(20, '97a1rnsdfc', 'Preparering 6', 1, 'Reng&ouml;ring', 24, 'deleted', '', '', 1359107204),
(21, 'mrb220zar9', '1', 3, 'V&auml;ljer p&aring; plats', 49, 'available', '', '', 1359137408),
(22, 'ao1umrq9x1', 'Preparering', 3, 'Reng&ouml;ring', 47, 'available', '', '', 1359214509);

-- --------------------------------------------------------

--
-- Tabellstruktur `user_access`
--

CREATE TABLE IF NOT EXISTS `user_access` (
  `user` int(10) NOT NULL,
  `business` int(10) NOT NULL,
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `user_access`
--

INSERT INTO `user_access` (`user`, `business`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 2),
(13, 3),
(14, 1),
(14, 2),
(14, 3),
(16, 1),
(16, 3),
(11, 1),
(11, 2),
(11, 3),
(10, 1),
(10, 2),
(10, 3);
--
-- Databas: `companyadmin`
--
CREATE DATABASE `companyadmin` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `companyadmin`;

-- --------------------------------------------------------

--
-- Tabellstruktur `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_secret` varchar(10) NOT NULL,
  `company` varchar(30) NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_secret` (`company_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `companies`
--

INSERT INTO `companies` (`company_id`, `company_secret`, `company`) VALUES
(1, 'dfg7586ghf', 'MaRob Aktiviteter AB');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secret` varchar(10) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  UNIQUE KEY `id` (`id`,`mail`),
  UNIQUE KEY `secret_2` (`secret`),
  KEY `secret` (`secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `secret`, `mail`, `password`, `role`, `company`, `name`) VALUES
(15, '79sfb6fb8d', '123', '202cb962ac59075b964b07152d234b70', 'master', 1, '123'),
(12, '4n6t9dyehl', 'master', 'eb0a191797624dd3a48fa681d3061212', 'master', 1, 'master'),
(14, 'm4aoe9xntu', 'god', 'a4757d7419ff3b48e92e90596f0e7548', 'god', 1, 'god'),
(11, '9qwjhgf220', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 1, 'user'),
(10, '4265rfkqbw', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 1, 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
