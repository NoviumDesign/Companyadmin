-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2013 at 02:58 PM
-- Server version: 5.5.31-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `company_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
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
  `invoice_due` int(10) NOT NULL DEFAULT '0',
  `delivery` varchar(10) NOT NULL,
  `order_mail_title` text NOT NULL,
  `order_mail_content` text NOT NULL,
  UNIQUE KEY `type_id` (`business_id`),
  KEY `business_secret` (`business_secret`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `crs`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=338 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
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
  KEY `invoice_secret` (`invoice_secret`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=430 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
  `carrier` int(10) DEFAULT '0',
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=284 ;

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  `unit` text NOT NULL,
  `vat` float NOT NULL,
  `date` int(15) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=201 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE IF NOT EXISTS `user_access` (
  `user` int(10) NOT NULL,
  `business` int(10) NOT NULL,
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
