--
-- Database: `ah_tickets`
--

-- --------------------------------------------------------

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

ALTER TABLE `tickets` ADD `is_public` INT NOT NULL AFTER `is_delete`;