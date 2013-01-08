-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 08 jan 2013 kl 17:55
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
  UNIQUE KEY `type_id` (`business_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `businesses`
--

INSERT INTO `businesses` (`business_id`, `business`, `custom_field_1`, `custom_field_2`, `custom_field_3`) VALUES
(1, 'Kr&#228;ftor', '', '', ''),
(2, 'Julgranar', '', '', ''),
(3, 'Skidor', 'Lopp', 'Startled', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `business` int(10) NOT NULL,
  `customer_number` int(10) NOT NULL,
  `registered` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `adress` varchar(50) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_number` (`customer_number`),
  KEY `registered` (`registered`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumpning av Data i tabell `customers`
--

INSERT INTO `customers` (`customer_id`, `business`, `customer_number`, `registered`, `name`, `type`, `mail`, `phone`, `adress`) VALUES
(1, 3, 123456, 'no', 'Gunde Svan', 'private', 'gunde@svan.se', '0701234567', 'Snöbollskrigsvägen 3');

-- --------------------------------------------------------

--
-- Tabellstruktur `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `order` (`order`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumpning av Data i tabell `items`
--

INSERT INTO `items` (`item_id`, `product`, `order`, `quantity`, `price`) VALUES
(1, 1, 6, 6, 1),
(2, 2, 6, 3, 2),
(17, 2, 44, 3, 2),
(16, 3, 44, 2, 3),
(15, 1, 44, 1, 4),
(18, 1, 45, 1, 4);

-- --------------------------------------------------------

--
-- Tabellstruktur `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(10) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumpning av Data i tabell `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `date`, `business`, `delivery_adress`, `delivery`, `delivery_date`, `status`, `customer`, `notes`, `custom_1`, `custom_2`, `custom_3`) VALUES
(1, 0, 123123, 2, 'Heimdalsvägen 12', 'approved', 1386561543, 'active', 0, '', '', '', ''),
(2, 0, 0, 1, 'Smalagränd 5:a', 'approved', 1356521543, 'active', 0, '', '', '', ''),
(3, 0, 0, 1, '1', 'none', 1, 'completed', 0, '', '', '', ''),
(4, 0, 1356648762, 1, 'sd', 'requested', 1231231223, 'completed', 0, '', '', '', ''),
(5, 0, 1356648818, 2, 'Ã…re, Duved', 'requested', 100000000, 'incomplete', 0, '', '', '', ''),
(6, 1, 2147483647, 3, 'test', 'none', 1358128860, 'active', 1, 'Extra information about the order given by the customer', 'Vasaloppet', 'Elit', ''),
(44, 2, 1357663928, 3, 'Valhallav&auml;gen 13', 'requested', 1359651060, 'active', 1, 'I Hufudstaden', 'Det som g&aring;r vid slottet', 'finns bara ett', ''),
(45, 3, 1357664015, 3, '', 'none', 1358268780, 'active', 1, 'Inga', 'Inget', '', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(10) NOT NULL,
  `price` float NOT NULL,
  `unit` text NOT NULL,
  `date` int(15) NOT NULL,
  PRIMARY KEY (`price_id`),
  KEY `product` (`product`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `prices`
--

INSERT INTO `prices` (`price_id`, `product`, `price`, `unit`, `date`) VALUES
(1, 1, 1000, 'par', 1000000),
(2, 2, 200, 'styck', 21000000),
(3, 3, 50.5, '10-pack', 2147483647),
(4, 1, 2000, '2 par', 2147483647);

-- --------------------------------------------------------

--
-- Tabellstruktur `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_number` varchar(30) NOT NULL,
  `business` int(10) NOT NULL,
  `product` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `status` varchar(20) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `comment` varchar(2000) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `business` (`business`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `products`
--

INSERT INTO `products` (`product_id`, `product_number`, `business`, `product`, `price`, `status`, `description`, `comment`) VALUES
(1, '0', 3, 'Stavar', 4, 'available', '', ''),
(2, '0', 3, 'Valla', 2, 'out of stock', '', ''),
(3, '0', 3, 'Trugor', 3, 'available', 'Description for the customer made by the sales', 'comment for the saler made by the sales');

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
(1, 4);
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
