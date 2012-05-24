-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2012 at 01:28 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ap_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_custom_banners`
--

CREATE TABLE IF NOT EXISTS `wp_custom_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_name` varchar(100) NOT NULL,
  `banner_text` text NOT NULL,
  `banner_url` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `positionid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wp_custom_banners`
--

INSERT INTO `wp_custom_banners` (`id`, `banner_name`, `banner_text`, `banner_url`, `image`, `positionid`) VALUES
(1, 'test1', 'test1', 'test1', '1.jpg', 2),
(2, 'testing2', 'testing2', 'testing2', '2.jpg', 3),
(3, 'test3', 'test3', 'test3', '3.jpg', 4),
(4, 'test4', 'test4', 'test4', '4.jpg', 5),
(5, 'test5', 'test5', 'test5', '5.jpg', 1);
