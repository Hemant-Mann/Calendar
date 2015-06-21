-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2015 at 02:12 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my-calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `event_desc` text COLLATE utf8_unicode_ci,
  `event_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `event_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`event_id`),
  KEY `event_start` (`event_start`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `event_title`, `event_desc`, `event_start`, `event_end`) VALUES
(1, 1, 'New Year&#039;s Day', 'Happy New Year!', '2009-12-31 18:30:00', '2010-01-01 18:29:59'),
(2, 2, 'Last Day of January', 'Last day of the month! Yay!', '2010-01-30 18:30:00', '2010-01-31 18:29:59'),
(4, 1, 'My bday', 'My 20th bday was awesome', '2015-03-12 18:30:00', '2015-03-13 18:29:59'),
(36, 1, 'Calendar Done', 'This is the time to add remaining features to the calendar which is already done by me', '2015-03-08 15:30:00', '2015-03-08 18:30:00'),
(37, 1, 'Sameer Bday', 'Sameer''s fifteenth bday', '2015-07-20 18:30:00', '2015-07-21 18:29:59'),
(38, 2, 'Event by another user', 'Yo it is an event by another user', '2015-03-08 18:30:00', '2015-03-09 04:30:00'),
(39, 3, 'My bday', 'Yippee it is my birthday', '2015-07-20 18:30:00', '2015-07-21 18:29:59'),
(40, 3, 'Testing Event', 'Ok this is a test events', '2015-03-23 12:30:00', '2017-03-24 14:30:00'),
(41, 3, 'Test Event 2', 'This is a test event 2', '2015-03-23 04:30:00', '2015-03-23 06:30:00'),
(42, 1, 'Malik''s birthday', 'Malik sahab ka bday', '2015-09-12 18:30:00', '2015-09-13 18:29:59'),
(43, 1, 'Exam 4th sem', 'End semester exams of 4th semester are starting in month of may-15', '2015-05-01 04:30:00', '2015-05-30 07:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`) VALUES
(1, 'Hemant Mann', 'Hemant', '$2y$10$ODdkOGYwYTdjMDJmODRjZeoMQRRZkh8xR6MAHM.Iwb7zUTKuJGk6i', 'hemant.mann121@gmail.com'),
(2, 'Test User', 'Test', '$2y$10$NzBjMDZkNjEyZWM5NWEwN.ynbFe0OtQ4xMcj2fPO3w39gBAQYGlRG', 'testing@gmail.com'),
(3, 'Sameer Mann', 'Sam', '$2y$10$NTU5YzIwZWQ1ZDYyZjE3MexPKXU27a5qZkHzNHEQmhU2cPMPvgxzO', 'sameer@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
