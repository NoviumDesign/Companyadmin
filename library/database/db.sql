-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 01 apr 2013 kl 00:55
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
  `invoice_prefix` text,
  `confirmation_mail` text,
  `invoice_detail` text,
  `company_reference` text NOT NULL,
  `invoice_mail_title` text NOT NULL,
  `invoice_mail_content` text NOT NULL,
  UNIQUE KEY `type_id` (`business_id`),
  KEY `business_secret` (`business_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumpning av Data i tabell `businesses`
--

INSERT INTO `businesses` (`business_id`, `business_secret`, `business`, `custom_field_1`, `custom_field_2`, `custom_field_3`, `company_name`, `company_adress`, `company_box`, `company_zip_code`, `company_city`, `company_country`, `company_phone`, `company_mail`, `company_site`, `company_bank`, `company_orgnr`, `company_color`, `invoice_prefix`, `confirmation_mail`, `invoice_detail`, `company_reference`, `invoice_mail_title`, `invoice_mail_content`) VALUES
(2, 'y6f52lp4yh', 'business 2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '000000', '', '', NULL, '', '', ''),
(1, 'huq90f3gwf', 'business 1', '', '', '', 'MaRob Aktiviteter AB', 'Klockarbol', 'Box', '64393', 'Ving&aring;ker', 'Sverige', '+46 (0) 70-447 20 07', 'info@vallaservice.se', 'www.vallaservice.se', '428-8650', '556780-4835', '404040', 'Vs', '', 'Invoice detail motherfuckers!!', 'Marcus Meck', 'title', 'content\r\ncontent\r\n&lt;invoice&gt;\r\n123123\r\n&aring;&auml;&ouml;&Aring;&Auml;&Ouml;\r\n&#039;&quot;\r\n&lt;invoice&gt;\r\n&lt;&gt;'),
(3, 'bnta8owsjh', 'test', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '37d617', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `crs`
--

CREATE TABLE IF NOT EXISTS `crs` (
  `crs_id` int(11) NOT NULL AUTO_INCREMENT,
  `crs_secret` varchar(10) NOT NULL,
  `customer` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `task` text,
  `business` int(11) NOT NULL,
  PRIMARY KEY (`crs_id`),
  KEY `customer` (`customer`,`date`),
  KEY `crs_secret` (`crs_secret`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `crs`
--

INSERT INTO `crs` (`crs_id`, `crs_secret`, `customer`, `status`, `date`, `task`, `business`) VALUES
(1, 'whlctbpnvp', 3, 'active', 1363474800, 'test', 1),
(2, 'jnpq4rv6hz', 3, 'active', 1362870000, 'test', 1),
(3, 'wjyh60qpfr', 3, 'active', 1362351600, 'test', 1),
(4, 'asf0xjobnk', 3, 'completed', 1362870000, 'tsrt', 1);

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
  `reference` text,
  PRIMARY KEY (`customer_id`),
  KEY `registered` (`registered`),
  KEY `customer_secret` (`customer_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_secret`, `business`, `registered`, `name`, `type`, `mail`, `phone`, `customer_adress`, `box`, `zip_code`, `city`, `country`, `notes`, `reference`) VALUES
(2, NULL, 2, 'true', 'customer 2.1', 'company', '', '', '', '', '', '', '', '', NULL),
(1, NULL, 1, 'true', 'Emil Blomquist', 'company', 'test@test.se', '', 'Heimdalsv&auml;gen 12', 'Boxfaan', '616 34', '&Aring;by', 'Sverige', '', 'Reference name'),
(3, NULL, 1, 'true', 'customer 1.2', 'private', 'test2@test.se', '', '', '', '', '', '', '', NULL),
(4, NULL, 3, 'true', 'test', 'company', '', '', '', '', '', '', '', '', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumpning av Data i tabell `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_secret`, `invoice_number`, `business`, `customer`, `status`, `date`, `due`, `discount`, `notes`) VALUES
(1, 'jbtegidz6m', 1, 1, 1, 'paid', 1361672432, 1364252400, 0, ''),
(2, '0r8zxwjl0d', 1, 2, 2, 'unpaid', 1361672551, 1364252400, 0, ''),
(3, 'djh0k10unr', 2, 1, 1, 'paid', 1362402860, 1364940000, 0, 'd&ouml;b&ouml;g...'),
(4, '62indxr1td', 3, 1, 1, 'paid', 1362405213, 1364940000, 0, ''),
(5, 'wvgr1xtbok', 1, 1, 1, 'unpaid', 1362405244, 1364940000, 1000, '&aring;&auml;&ouml;\r\n&Aring;&Auml;&Ouml;\r\nabc'),
(6, 'k0zdphrxic', 1, 3, 4, 'unpaid', 1362513784, 1365026400, 0, ''),
(8, '0fgjedowtx', 2, 2, 2, 'unpaid', 1362662104, 1363474800, 0, ''),
(9, 'bfkyemccr3', 3, 1, 3, 'unpaid', 1362662136, 1363474800, 0, ''),
(10, 'xufep1s4nh', 4, 1, 3, 'unpaid', 1362662173, 1363474800, 0, ''),
(11, 'oteniuyzc7', 5, 1, 3, 'unpaid', 1362662304, 1363474800, 0, '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumpning av Data i tabell `items`
--

INSERT INTO `items` (`item_id`, `product`, `order`, `invoice`, `quantity`, `price`) VALUES
(7, 4, 0, 2, 1, 5),
(6, 3, 0, 2, 1, 4),
(5, 3, 2, 0, 1, 4),
(4, 2, 0, 1, 1, 2),
(3, 1, 0, 1, 1, 3),
(2, 2, 1, 0, 1, 2),
(1, 1, 1, 0, 1, 3),
(8, 2, 3, 0, 3, 9),
(9, 1, 4, 0, 6, 8),
(10, 2, 4, 0, 1, 9),
(11, 1, 0, 3, 6, 8),
(12, 2, 0, 3, 1, 9),
(13, 2, 0, 4, 3, 10),
(14, 1, 0, 5, 2, 8),
(23, 2, 0, 5, 1, 10),
(19, 3, 0, 8, 1, 7),
(20, 1, 0, 10, 1, 8),
(24, 1, 5, 0, 1, 8);

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
  `carrier` int(10) NOT NULL DEFAULT '0',
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`order_id`, `order_secret`, `order_number`, `date`, `business`, `delivery_adress`, `delivery`, `delivery_date`, `carrier`, `status`, `customer`, `notes`, `custom_1`, `custom_2`, `custom_3`) VALUES
(2, '4dqskgikh5', 1, 1361672539, 2, '', 'approved', 1362277320, 0, 'active', 2, '', '', '', ''),
(1, '5xhdjopkqy', 1, 1361672338, 1, '', 'approved', 1364597700, 11, 'active', 1, '', '', '', ''),
(3, '1hg5iyc9am', 2, 1362231454, 1, '', 'none', 1364560200, 11, 'active', 1, '', '', '', ''),
(4, '675wej6guh', 3, 1362236104, 1, 'Heimdalsv&auml;gen 12 norrk&ouml;ping', 'approved', 1364568840, 10, 'active', 1, 'd&ouml;b&ouml;g...', '', '', ''),
(5, 'asbv8annel', 4, 1364764394, 1, 'test', 'approved', 1364595120, 11, 'active', 1, '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  `unit` text NOT NULL,
  `vat` float NOT NULL,
  `date` int(15) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumpning av Data i tabell `prices`
--

INSERT INTO `prices` (`price_id`, `price`, `unit`, `vat`, `date`) VALUES
(4, 1, 'enhet 2.1', 25, 1361672200),
(5, 2, 'enhet 2.2', 25, 1361672230),
(3, 1, 'enhet 1.1', 25, 1361672171),
(2, 2, 'enhet 1.2', 25, 1361672161),
(6, 10, 'enhet 1.1 - NEW', 25, 1361672472),
(7, 100, 'enhet 2.1 - NEW', 25, 1361672568),
(8, 100, 'enhet 1.1 - NEW', 25, 1362231525),
(9, 200, 'enhet 1.2', 25, 1362231531),
(10, 2000, 'enhet 1.2', 10, 1362404010),
(11, 111.11, 'st', 25, 1362607900);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`product_id`, `product_secret`, `product_number`, `business`, `product`, `price`, `status`, `description`, `notes`, `date`) VALUES
(4, 'vuo7pxwlyg', '2.2', 2, 'product 2.2', 5, 'available', '', '', 1361672230),
(3, 'zkt6rscy8n', '2.1', 2, 'product 2.1', 7, 'available', '', '', 1361672200),
(2, 'ynesc9d0a3', '1.2', 1, 'product 1.2', 10, 'out of stock', '', '', 1361672161),
(1, 'rrzuqiwnsd', '1.1', 1, 'product 1.1', 8, 'available', '', '', 1361672112),
(5, 'hnqlp950mc', '3', 1, 'produkt', 11, 'available', '', '', 1362607900);

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
(12, 1),
(12, 2),
(12, 3),
(11, 2),
(11, 1),
(11, 3);
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
