-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2013 at 10:59 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jyrno_chat`
--
CREATE DATABASE IF NOT EXISTS `jyrno_chat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `jyrno_chat`;

-- --------------------------------------------------------

--
-- Table structure for table `chatrooms`
--

CREATE TABLE IF NOT EXISTS `chatrooms` (
  `chatroom_id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `created_by` int(20) NOT NULL,
  `created_date` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `state` varchar(20) NOT NULL,
  PRIMARY KEY (`chatroom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `chatrooms`
--

INSERT INTO `chatrooms` (`chatroom_id`, `name`, `type`, `created_by`, `created_date`, `description`, `state`) VALUES
(31, 'publics', 'public', 1, 1375623612, 'dddssd', 'active'),
(32, 'przzz', 'private', 1, 1375624655, 'cccc', 'active'),
(34, 'test', 'private', 1, 1375640808, '', 'active'),
(35, 'test2', 'private', 1, 1375640886, '', '0'),
(36, 'nvb', 'private', 1, 1375640964, '', '0'),
(37, 'yyy', 'private', 2, 1375641018, '', '0'),
(38, 'zzz', 'private', 2, 1375641404, '', '0'),
(39, 'cdf', 'private', 1, 1375641462, 'ksndsjds', '0');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `datetime` int(11) NOT NULL,
  `message` varchar(100) NOT NULL,
  `ipaddress` int(15) NOT NULL,
  `chatroom_id` int(20) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `user_id`, `datetime`, `message`, `ipaddress`, `chatroom_id`) VALUES
(1, 2, 1375640918, 'in test 2', 192168, 35),
(2, 1, 1375640933, 'uinhf', 192168, 35),
(3, 2, 1375640940, 'aalaa', 192168, 35),
(5, 1, 1375641440, 'zz', 192168, 38),
(6, 2, 1375641447, 'zzz', 192168, 38),
(8, 1, 1375898954, 'cxc', 192168, 1),
(10, 1, 1375899662, 'ffd', 192168, 1),
(11, 1, 1375899669, 'fdd', 192168, 1),
(12, 1, 1375899695, 'fd', 192168, 1),
(13, 1, 1375899740, 'dsfds', 192168, 1),
(14, 1, 1375899850, 'nnn', 192168, 1),
(15, 1, 1375899864, 'cxc', 192168, 1),
(16, 1, 1375899877, 'fdfd', 192168, 1),
(17, 1, 1377038829, 'my texts', 192168, 31);

-- --------------------------------------------------------

--
-- Table structure for table `private_chatroom_users`
--

CREATE TABLE IF NOT EXISTS `private_chatroom_users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `chatroom_id` int(20) NOT NULL,
  `user_id` int(100) NOT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `private_chatroom_users`
--

INSERT INTO `private_chatroom_users` (`id`, `chatroom_id`, `user_id`, `state`) VALUES
(18, 32, 2, 'accepted'),
(19, 32, 1, 'accepted'),
(22, 34, 2, 'rejected'),
(23, 34, 1, 'accepted'),
(24, 35, 2, 'accepted'),
(25, 35, 1, 'accepted'),
(26, 36, 1, 'accepted'),
(27, 37, 1, 'rejected'),
(28, 37, 2, 'accepted'),
(29, 38, 1, 'accepted'),
(30, 38, 2, 'accepted'),
(31, 39, 2, 'rejected'),
(32, 39, 1, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `is_login` int(1) NOT NULL,
  `login_time` int(11) NOT NULL,
  `chat_login` int(11) NOT NULL,
  `chat_login_time` varchar(11) NOT NULL,
  `chat_state` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `firstname`, `lastname`, `is_login`, `login_time`, `chat_login`, `chat_login_time`, `chat_state`) VALUES
(1, 'mohsin', '12345', 'mohsin.malik24@yahoo.com', 'Mohsin', 'Malik', 1, 1377203101, 1, '1377203134', 'active'),
(2, 'mohsin2', '12345', 'mohsin.malik24@yahoo.com', 'mohsin2', 'malik2', 1, 1375640551, 0, '0', 'banned');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
