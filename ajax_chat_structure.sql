-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2010 at 01:56 AM
-- Server version: 5.1.41
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ajax_chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_msg`
--

DROP TABLE IF EXISTS `chat_msg`;
CREATE TABLE IF NOT EXISTS `chat_msg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `msg_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `name_id` int(11) NOT NULL,
  `name_ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `chat_msg`
--


-- --------------------------------------------------------

--
-- Table structure for table `chat_name`
--

DROP TABLE IF EXISTS `chat_name`;
CREATE TABLE IF NOT EXISTS `chat_name` (
  `name_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_ip` varchar(255) NOT NULL,
  `name_status` int(2) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=admin',
  `name_add` timestamp NULL DEFAULT NULL,
  `name_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'last time this name chat',
  PRIMARY KEY (`name_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `chat_name`
--


-- --------------------------------------------------------

--
-- Table structure for table `chat_room`
--

DROP TABLE IF EXISTS `chat_room`;
CREATE TABLE IF NOT EXISTS `chat_room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(255) DEFAULT NULL,
  `room_create` timestamp NULL DEFAULT NULL,
  `room_last_chat` timestamp NULL DEFAULT NULL,
  `room_status` int(2) NOT NULL DEFAULT '1' COMMENT '0=disable, 1=enable',
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `chat_room`
--

INSERT INTO `chat_room` (`room_id`, `room_name`, `room_create`, `room_last_chat`, `room_status`) VALUES
(1, 'public room', '2010-01-04 02:32:42', '2010-01-07 01:54:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat_room_stat`
--

DROP TABLE IF EXISTS `chat_room_stat`;
CREATE TABLE IF NOT EXISTS `chat_room_stat` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `name_id` int(11) NOT NULL,
  `name_ip` varchar(255) NOT NULL,
  `stat_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`stat_id`),
  KEY `name_id` (`name_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `chat_room_stat`
--

