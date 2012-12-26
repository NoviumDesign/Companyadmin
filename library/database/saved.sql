-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 26 december 2012 kl 22:47
-- Serverversion: 5.1.44
-- PHP-version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `customer_1`
--
CREATE DATABASE `customer_1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `customer_1`;

-- --------------------------------------------------------

--
-- Struktur för tabell `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(20) NOT NULL,
  `type` int(10) NOT NULL,
  `items` varchar(500) NOT NULL,
  `location` varchar(200) NOT NULL,
  `delivery` varchar(20) NOT NULL,
  `delivery_date` int(20) NOT NULL,
  `completed` varchar(20) NOT NULL,
  `by` varchar(50) NOT NULL,
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Data i tabell `orders`
--

INSERT INTO `orders` (`order_id`, `date`, `type`, `items`, `location`, `delivery`, `delivery_date`, `completed`, `by`) VALUES
(1, 1356561543, 0, '3', 'Heimdalsvägen 12', 'ja', 1386561543, 'nej', 'Emil Blomquist'),
(2, 1356361543, 0, '25', 'Smalagränd 5:a', 'Nej', 1356521543, 'Nej', 'Anton');
--
-- Databas: `order-system`
--
CREATE DATABASE `order-system` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `order-system`;

-- --------------------------------------------------------

--
-- Struktur för tabell `users`
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
-- Data i tabell `users`
--

INSERT INTO `users` (`id`, `mail`, `password`, `role`, `company`, `name`) VALUES
(1, 'user1', 'pass1', 'admin', 1, 'User One'),
(2, 'user2', 'pass2', 'user', 1, 'User Two');
