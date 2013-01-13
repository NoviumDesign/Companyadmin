-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 13 jan 2013 kl 18:31
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
  `business` varchar(30) NOT NULL,
  `custom_field_1` varchar(30) NOT NULL,
  `custom_field_2` varchar(30) NOT NULL,
  `custom_field_3` varchar(30) NOT NULL,
  `company_name` text NOT NULL,
  `company_adress` text NOT NULL,
  `company_box` text NOT NULL,
  `company_zip_code` int(11) NOT NULL,
  `company_city` text NOT NULL,
  `company_country` text NOT NULL,
  `company_phone` int(11) NOT NULL,
  `company_mail` text NOT NULL,
  UNIQUE KEY `type_id` (`business_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `businesses`
--

INSERT INTO `businesses` (`business_id`, `business`, `custom_field_1`, `custom_field_2`, `custom_field_3`, `company_name`, `company_adress`, `company_box`, `company_zip_code`, `company_city`, `company_country`, `company_phone`, `company_mail`) VALUES
(1, 'Kr&#228;ftor', '', '', '', '', '', '', 0, '', '', 0, ''),
(2, 'Julgranar', '', '', '', '', '', '', 0, '', '', 0, ''),
(3, 'Skidor', 'Lopp', 'Startled', '', 'MaRob Aktiviteter AB', 'Klockarbol', '', 64393, 'Vingåker', 'Sverige', 0, '');

-- --------------------------------------------------------

--
-- Tabellstruktur `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `business` int(10) NOT NULL,
  `registered` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `customer_adress` varchar(50) NOT NULL,
  `box` text NOT NULL,
  `zip_code` text NOT NULL,
  `city` text NOT NULL,
  `country` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `registered` (`registered`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumpning av Data i tabell `customers`
--

INSERT INTO `customers` (`customer_id`, `business`, `registered`, `name`, `type`, `mail`, `phone`, `customer_adress`, `box`, `zip_code`, `city`, `country`, `notes`) VALUES
(1, 3, 'true', 'Gunde Svan', 'private', 'gunde@svan.se', '0701234567', 'Sn&ouml;bollskrigsv&auml;gen 3', '', '', '', '', ''),
(2, 3, 'true', 'Novium Design', 'company', 'mail@noviumdesign.se', '0704910203', 'Solrosgatan 2A', 'Ocks&aring; i link&ouml;ping?', '616 34', 'Link&ouml;ping', 'Sverige', 'We&#039;re to good for notes... ;)'),
(3, 3, 'false', 'Spin media', 'company', 'mail', 'Hej jag heter jann...', 'Sture-p', '', '', '', '', 'TROLOLOLOLOLO!!'),
(5, 0, 'false', 'Novium Design', 'company', 'mail@noviumdesign.se', '0704910203', 'N&aring;gonstans i link&ouml;ping', 'Ocks&aring; i link&ouml;ping?', 'link&ouml;pings', 'Link&ouml;ping', 'SCHWEDEN baby!', 'We&#039;re to good for notes... ;)'),
(6, 0, 'false', 'Novium Design', 'company', 'mail@noviumdesign.se', '0704910203', 'N&aring;gonstans i link&ouml;ping', 'Ocks&aring; i link&ouml;ping?', 'link&ouml;pings', 'Link&ouml;ping', 'SCHWEDEN baby!', 'We&#039;re to good for notes... ;)'),
(7, 0, 'true', 'Gunde Svan', 'private', 'gunde@svan.se', '0701234567', 'Sn&ouml;bollskrigsv&auml;gen 3', '', '', '', '', ''),
(8, 0, 'true', 'Gunde Svan', 'private', 'gunde@svan.se', '0701234567', 'Snï¿½bollskrigsvï¿½gen 3', '', '', '', '', ''),
(9, 0, 'true', 'Gunde Svan', 'private', 'gunde@svan.se', '0701234567', 'Snï¿½bollskrigsvï¿½gen 3', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `status` text NOT NULL,
  `date` int(11) NOT NULL,
  `due` int(11) NOT NULL,
  `discount` float NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `customer` (`customer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumpning av Data i tabell `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_number`, `business`, `customer`, `status`, `date`, `due`, `discount`, `notes`) VALUES
(11, 1, 3, 2, 'paid', 1358032524, 1360623600, 1000, '-100 kronor f&ouml;r dig din j&auml;vel! ');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumpning av Data i tabell `items`
--

INSERT INTO `items` (`item_id`, `product`, `order`, `invoice`, `quantity`, `price`) VALUES
(40, 1, 1, 0, 3, 1),
(41, 2, 1, 0, 1, 3),
(42, 1, 2, 0, 1, 4),
(43, 2, 2, 0, 2, 3),
(64, 2, 7, 0, 5.5, 3),
(62, 3, 0, 11, 13, 15),
(60, 2, 0, 11, 2, 3),
(63, 1, 7, 0, 5, 4),
(65, 3, 7, 0, 6, 15);

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(10) DEFAULT NULL,
  `date` int(11) NOT NULL,
  `business` int(10) NOT NULL,
  `delivery_adress` varchar(200) NOT NULL,
  `delivery` varchar(20) NOT NULL,
  `delivery_date` int(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `customer` int(10) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `custom_1` text NOT NULL,
  `custom_2` text NOT NULL,
  `custom_3` text NOT NULL,
  UNIQUE KEY `order_id` (`order_id`),
  KEY `business` (`business`),
  KEY `order_number` (`order_number`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `date`, `business`, `delivery_adress`, `delivery`, `delivery_date`, `status`, `customer`, `notes`, `custom_1`, `custom_2`, `custom_3`) VALUES
(1, 1, 1357861024, 3, 'Hit', 'approved', 1357947360, 'active', 1, 'inga n&ouml;tter', 'Vasaloppet', 'Elit, som en gladiator', ''),
(2, 2, 1357861125, 3, 'Hit', 'requested', 1357947480, 'active', 2, 'Skidorna gick s&ouml;nder, men sk&ouml;nt att man kan k&ouml;pa dem om 3!', 'Vasaloppet', '1', ''),
(7, 3, 1358083028, 3, '', 'requested', 1358687760, 'active', 3, 'notes', '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumpning av Data i tabell `prices`
--

INSERT INTO `prices` (`price_id`, `price`, `unit`, `date`) VALUES
(1, 50000, 'par', 1357860821),
(2, 2000, 'par', 1357860883),
(3, 2000, 'par', 1357860897),
(4, 70000, '3 skidor', 1357861073),
(5, 300, 'styck', 1357861190),
(6, 123, '123', 1358000549),
(7, 123, '123', 1358000561),
(8, 123, '123', 1358000583),
(9, 123, '123', 1358000597),
(10, 123, '123', 1358000746),
(11, 123, '123', 1358000760),
(12, 0, '213', 1358000777),
(13, 0, '213', 1358000829),
(14, 0, '213', 1358000835),
(15, 0.5, 'styck', 1358033785);

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_number` varchar(30) NOT NULL DEFAULT '0',
  `business` int(10) NOT NULL,
  `product` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `status` varchar(20) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `notes` varchar(2000) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `business` (`business`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`product_id`, `product_number`, `business`, `product`, `price`, `status`, `description`, `notes`, `date`) VALUES
(1, '1', 3, 'Skidor', 4, 'available', 'En skateskida fr&aring;n ficsher, om en g&aring;r s&ouml;nder! Smart va! :)', 'Hittas p&aring; hylla 3', 1357860821),
(2, '2', 3, 'Stavar', 3, 'available', 'Skatestavar fr&aring;n rosignol, men det st&auml;mmer ju inte!!', 'Bryt inte av dem, d&aring; blir pappa arg! :/\r\nnytt stycke', 1357860883),
(3, '3', 3, 'Valla', 15, 'available', 'kletigt', '&Auml;r egentligen bara stearin, men det s&auml;ljer vi dyrt haha!!', 1357861190),
(4, '5467', 3, 'trolololo', 11, 'deleted', '123', '3241', 1358000549),
(5, '7', 3, '213', 14, 'deleted', '1', '', 1358000777);

-- --------------------------------------------------------

--
-- Tabellstruktur `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `test`
--

INSERT INTO `test` (`id`, `test`) VALUES
(1, 0),
(2, 4);

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
(1, 4),
(2, 3);
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
  `company` varchar(30) NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `companies`
--

INSERT INTO `companies` (`company_id`, `company`) VALUES
(1, 'Company 1');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  UNIQUE KEY `id` (`id`,`mail`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `mail`, `password`, `role`, `company`, `name`) VALUES
(1, 'user1', 'pass1', 'admin', 1, 'User One'),
(2, 'user2', 'pass2', 'user', 1, 'User Two');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
