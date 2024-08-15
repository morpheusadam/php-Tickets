-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2016 at 09:47 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ah_tickets`
--

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(150) NOT NULL,
  `option_value` longtext NOT NULL,
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_id` (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` text NOT NULL,
  `post_slug` text NOT NULL,
  `post_type` text NOT NULL,
  `post_department` int(11) NOT NULL,
  `post_content` longtext NOT NULL,
  `post_time` int(11) NOT NULL,
  `post_like` int(11) NOT NULL,
  `post_views` int(11) NOT NULL,
  `is_public` int(11) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `n_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `n_user_from` bigint(20) NOT NULL,
  `n_user_to` bigint(20) NOT NULL,
  `n_type` varchar(100) NOT NULL,
  `n_data` text NOT NULL,
  `n_browser_read` int(11) NOT NULL,
  `n_user_read` int(11) NOT NULL,
  `n_time` int(11) NOT NULL,
  PRIMARY KEY (`n_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `tickets`
--

ALTER TABLE `tickets` ADD `is_delete` INT NOT NULL AFTER `is_answer`;

--
-- Table structure for table `users`
--

ALTER TABLE `users` DROP `facebook_id`, DROP `twitter_id`;
ALTER TABLE `users` ADD `social_type` VARCHAR(100) NOT NULL AFTER `social_id`;


--
-- Table structure for table `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `content` text NOT NULL,
  `sent_to` varchar(50) CHARACTER SET utf32 NOT NULL,
  `status` int(25) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
