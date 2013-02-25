-- Wed, 23 Jan 2013 20:19:56 GMT
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
-- Dumping database structure for budget_prod
DROP DATABASE IF EXISTS `budget_prod`;
CREATE DATABASE `budget_prod` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `budget_prod`;


-- Dumping structure for table budget_prod.budget_card
DROP TABLE IF EXISTS `budget_card`;
CREATE TABLE `budget_card` (
  `card_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `card_title` varchar(100) NOT NULL,
  `card_number` varchar(100) NOT NULL,
  `card_joint` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = joint',
  `card_updated` datetime DEFAULT NULL,
  `card_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_prod.budget_card: ~3 rows (approximately)
/*!40000 ALTER TABLE `budget_card` DISABLE KEYS */;
INSERT INTO `budget_card` (`card_id`, `card_title`, `card_number`, `card_joint`, `card_updated`, `card_registered`) VALUES 
	(5, 'Felles', '22528,25286', 1, NULL, '2013-01-10 17:23:31'),
	(6, 'Kris', '27239,9558', 0, NULL, '2013-01-10 17:23:31'),
	(7, 'Malin', '18277,64505', 0, '2013-01-13 16:44:27', '2013-01-10 17:23:31')
;
/*!40000 ALTER TABLE `budget_card` ENABLE KEYS */;


-- Dumping structure for table budget_prod.budget_debug
DROP TABLE IF EXISTS `budget_debug`;
CREATE TABLE `budget_debug` (
  `debug_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `debug_session` smallint(6) NOT NULL DEFAULT '0',
  `debug_level` mediumint(1) NOT NULL COMMENT 'Predefined level',
  `debug_data` text NOT NULL COMMENT 'Debug data',
  `debug_file` varchar(255) NOT NULL DEFAULT '',
  `debug_line` smallint(6) NOT NULL DEFAULT '0',
  `debug_backtrack` longtext,
  `debug_trace` longtext,
  `debug_type` varchar(50) NOT NULL DEFAULT '' COMMENT 'Data type',
  `debug_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`debug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table budget_prod.budget_debug: ~0 rows (approximately)


-- Dumping structure for table budget_prod.budget_entry
DROP TABLE IF EXISTS `budget_entry`;
CREATE TABLE `budget_entry` (
  `entry_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `entry_cost` float NOT NULL,
  `entry_comment` varchar(255) NOT NULL DEFAULT '',
  `entry_credit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 debit, 1 credit',
  `entry_date` date NOT NULL,
  `entry_single` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 divide 1 single',
  `entry_type` char(50) NOT NULL,
  `entry_card` tinyint(4) NOT NULL,
  `entry_updated` datetime DEFAULT NULL,
  `entry_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`),
  KEY `entry_type` (`entry_type`),
  KEY `entry_card` (`entry_card`),
  CONSTRAINT `FK_ENTRY_CARD` FOREIGN KEY (`entry_card`) REFERENCES `budget_card` (`card_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ENTRY_TYPE` FOREIGN KEY (`entry_type`) REFERENCES `budget_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_prod.budget_entry: ~311 rows (approximately)
/*!40000 ALTER TABLE `budget_entry` DISABLE KEYS */;
INSERT INTO `budget_entry` (`entry_id`, `entry_cost`, `entry_comment`, `entry_credit`, `entry_date`, `entry_single`, `entry_type`, `entry_card`, `entry_updated`, `entry_registered`) VALUES 
	(1, 107.5, '', 0, '2011-01-13', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(2, 236.09, '', 0, '2011-01-17', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(3, 156.06, '', 0, '2011-01-19', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(4, 282.5, '', 0, '2011-01-20', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(5, 159.8, '', 0, '2011-01-21', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(6, 108.7, '', 0, '2011-01-23', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(7, 297.1, '', 0, '2011-01-27', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(8, 181, '', 0, '2011-01-28', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(9, 181.5, '', 0, '2011-02-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(10, 99.82, '', 0, '2011-02-03', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(11, 72.5, '', 0, '2011-02-04', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(12, 211.3, '', 0, '2011-02-05', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(13, 240.45, '', 0, '2011-02-06', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(14, 59.3, '', 0, '2011-02-07', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(15, 39.06, '', 0, '2011-02-09', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(16, 265.42, '', 0, '2011-02-11', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(17, 200.1, '', 0, '2011-02-12', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(18, 87.69, '', 0, '2011-02-15', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(19, 98.31, '', 0, '2011-02-17', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(20, 54.1, '', 0, '2011-02-17', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(21, 126, '', 0, '2011-03-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(22, 87.5, '', 0, '2011-03-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(23, 106.95, '', 0, '2011-03-03', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(24, 153.8, '', 0, '2011-03-04', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(25, 131.67, '', 0, '2011-03-05', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(26, 259, '', 0, '2011-03-06', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(27, 122.08, '', 0, '2011-03-07', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(28, 353.02, '', 0, '2011-03-08', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(29, 136.7, '', 0, '2011-03-09', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(30, 157.64, '', 0, '2011-03-11', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(31, 129.74, '', 0, '2011-03-12', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(32, 83.71, '', 0, '2011-03-14', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(33, 231.62, '', 0, '2011-03-16', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(34, 216.3, '', 0, '2011-03-17', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(35, 119.06, '', 0, '2011-03-19', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(36, 171.71, '', 0, '2011-03-21', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(37, 98.05, '', 0, '2011-03-22', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(38, 104.3, '', 0, '2011-03-23', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(39, 185.62, '', 0, '2011-03-25', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(40, 102.1, '', 0, '2011-03-26', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(41, 163.64, '', 0, '2011-03-26', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(42, 169.26, '', 0, '2011-03-28', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(43, 113.25, '', 0, '2011-03-29', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(44, 90.68, '', 0, '2011-03-30', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(45, 34.9, '', 0, '2011-04-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(46, 167.95, '', 0, '2011-04-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(47, 91.55, '', 0, '2011-04-06', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(48, 264.93, '', 0, '2011-04-07', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(49, 83.2, '', 0, '2011-04-08', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(50, 54.52, '', 0, '2011-04-11', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(51, 98.5, '', 0, '2011-04-12', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(52, 95.86, '', 0, '2011-04-13', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(53, 166.64, '', 0, '2011-04-14', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(54, 38.51, '', 0, '2011-04-16', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(55, 121.8, '', 0, '2011-04-25', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(56, 108.52, '', 0, '2011-04-26', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(57, 107.99, '', 0, '2011-04-27', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(58, 46.1, '', 0, '2011-04-27', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(59, 153.2, '', 0, '2011-04-27', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(60, 78.3, '', 0, '2011-04-29', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(61, 103.8, '', 0, '2011-04-30', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(62, 207.87, '', 0, '2011-05-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(63, 95.2, '', 0, '2011-05-03', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(64, 28.3, '', 0, '2011-05-04', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(65, 173.99, '', 0, '2011-05-06', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(66, 72.01, '', 0, '2011-05-07', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(67, 29.9, '', 0, '2011-05-07', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(68, 133.42, '', 0, '2011-05-09', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(69, 108.83, '', 0, '2011-05-13', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(70, 171.34, '', 0, '2011-05-16', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(71, 82, '', 0, '2011-05-19', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(72, 145.53, '', 0, '2011-05-20', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(73, 86.13, '', 0, '2011-05-23', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(74, 53.53, '', 0, '2011-05-23', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(75, 94.56, '', 0, '2011-05-24', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(76, 54.3, '', 0, '2011-05-25', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(77, 260.97, '', 0, '2011-05-27', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(78, 123.3, '', 0, '2011-05-29', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(79, 96.8, '', 0, '2011-05-30', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(80, 235.25, '', 0, '2011-06-01', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(81, 181.3, '', 0, '2011-08-08', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(82, 591.33, '', 0, '2011-08-09', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(83, 17.19, '', 0, '2011-08-09', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(84, 244.5, '', 0, '2011-08-10', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(85, 89.6, '', 0, '2011-08-11', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(86, 149.85, '', 0, '2011-08-13', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(87, 248.97, '', 0, '2011-08-15', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(88, 220.44, '', 0, '2011-08-17', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(89, 175.15, '', 0, '2011-08-24', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(90, 112.55, '', 0, '2011-08-25', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(91, 19.1, '', 0, '2011-08-26', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(92, 176.65, '', 0, '2011-08-26', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(93, 194.3, '', 0, '2011-08-30', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(94, 120.49, '', 0, '2011-08-30', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(95, 73, '', 0, '2011-08-31', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(96, 189.44, '', 0, '2011-09-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(97, 165.61, '', 0, '2011-09-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(98, 141.93, '', 0, '2011-09-05', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(99, 238.74, '', 0, '2011-09-06', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(100, 98.08, '', 0, '2011-09-09', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(101, 159.3, '', 0, '2011-09-10', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(102, 129.93, '', 0, '2011-09-12', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(103, 168.91, '', 0, '2011-09-20', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(104, 174, '', 0, '2011-09-24', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(105, 81.2, '', 0, '2011-10-04', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(106, 119.08, '', 0, '2011-10-06', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(107, 108.19, '', 0, '2011-10-07', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(108, 42.81, '', 0, '2011-10-12', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(109, 218.43, '', 0, '2011-10-14', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(110, 55.9, '', 0, '2011-10-19', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(111, 176.47, '', 0, '2011-10-21', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(112, 23.1, '', 0, '2011-10-25', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(113, 393.42, '', 0, '2011-10-28', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(114, 76.3, '', 0, '2011-10-28', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(115, 82.27, '', 0, '2011-10-29', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(116, 210.36, '', 0, '2011-10-31', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(117, 72.9, '', 0, '2011-11-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(118, 70.04, '', 0, '2011-11-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(119, 98.25, '', 0, '2011-11-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(120, 242.17, '', 0, '2011-11-04', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(121, 245.74, '', 0, '2011-11-10', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(122, 45.05, '', 0, '2011-11-15', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(123, 76.18, '', 0, '2011-11-16', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(124, 129.5, '', 0, '2011-11-17', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(125, 226.5, '', 0, '2011-11-18', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(126, 194.14, '', 0, '2011-11-18', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(127, 70, '', 0, '2011-11-18', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(128, 114.6, '', 0, '2011-11-19', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(129, 215.7, '', 0, '2011-11-21', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(130, 121.45, '', 0, '2011-11-22', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(131, 196.5, '', 0, '2011-11-25', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(132, 56.7, '', 0, '2011-11-25', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(133, 191.67, '', 0, '2011-11-26', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(134, 346.51, '', 0, '2011-11-28', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(135, 142.63, '', 0, '2011-11-30', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(136, 117.5, '', 0, '2011-12-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(137, 172.68, '', 0, '2011-12-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(138, 160.24, '', 0, '2011-12-03', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(139, 86.34, '', 0, '2011-12-05', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(140, 117.25, '', 0, '2011-12-08', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(141, 90.62, '', 0, '2011-12-08', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(142, 219.44, '', 0, '2011-12-08', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(143, 190.76, '', 0, '2011-12-12', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(144, 63.6, '', 0, '2011-12-15', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(145, 1600, '', 1, '2012-01-01', 1, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(146, 108.9, '', 0, '2012-01-06', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(147, 248.35, '', 0, '2012-01-09', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(148, 197.8, '', 0, '2012-01-05', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(149, 134.65, '', 0, '2012-01-09', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(150, 422.74, '', 0, '2012-01-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(151, 1290.06, '', 0, '2012-01-31', 1, 'tv', 5, NULL, '2013-01-10 23:39:18'),
	(152, 420.25, '', 0, '2012-01-03', 0, 'strom', 5, NULL, '2013-01-10 23:39:18'),
	(153, 4000, 'Fra Kris', 1, '2012-01-28', 1, 'husleie', 7, NULL, '2013-01-10 23:39:18'),
	(154, 4000, '', 0, '2012-01-31', 1, 'husleie', 7, NULL, '2013-01-10 23:39:18'),
	(155, 1290.06, 'Fra Kris og Malin', 1, '2012-01-28', 0, 'tv', 5, NULL, '2013-01-10 23:39:18'),
	(156, 420.25, 'Fra Kris og Malin', 1, '2012-01-28', 0, 'strom', 5, NULL, '2013-01-10 23:39:18'),
	(157, 194.78, '', 0, '2012-01-10', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(158, 366.3, '', 0, '2012-01-13', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(159, 279.87, '', 0, '2012-01-13', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(160, 60, '', 0, '2012-01-13', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(161, 611.38, 'Strom for desember', 0, '2012-01-31', 0, 'strom', 5, NULL, '2013-01-10 23:39:18'),
	(162, 611.38, '', 1, '2012-01-28', 0, 'strom', 5, NULL, '2013-01-10 23:39:18'),
	(163, 52.37, '', 0, '2012-01-16', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(164, 156.8, '', 0, '2012-01-16', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(165, 118, '', 0, '2012-01-14', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(166, 167, 'Pastasentralen og calzone', 0, '2012-01-17', 1, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(167, 200, '', 0, '2012-01-17', 1, 'kos', 6, NULL, '2013-01-10 23:39:18'),
	(168, 155.12, '', 0, '2012-01-19', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(169, 54.07, '', 0, '2012-01-18', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(170, 54, '', 0, '2012-01-25', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(171, 81.8, '', 0, '2012-01-24', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(172, 173.15, '', 0, '2012-01-23', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(173, 116.38, '', 0, '2012-01-20', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(174, 93.51, '', 0, '2012-02-01', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(175, 193.57, '', 0, '2012-02-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(176, 171.08, '', 0, '2012-01-27', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(177, 65.8, '', 0, '2012-01-26', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(178, 72, '7-eleven', 0, '2012-01-27', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(179, 102, '', 0, '2012-01-25', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(180, 119.7, 'Rema-1000', 0, '2012-01-23', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(181, 128.23, '', 0, '2012-02-07', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(182, 128.45, '', 0, '2012-02-21', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(183, 258.62, '', 0, '2012-02-20', 0, 'mat', 7, NULL, '2013-01-10 23:39:18'),
	(184, 33.85, '', 0, '2012-02-20', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(185, 245, 'Pizzabakeren', 0, '2012-02-18', 0, 'kos', 6, NULL, '2013-01-10 23:39:18'),
	(186, 83.9, '', 0, '2012-02-18', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(187, 287.3, '', 0, '2012-02-04', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(188, 262.61, '', 0, '2012-02-17', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(189, 70.6, '', 0, '2012-02-13', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(190, 245.48, '', 0, '2012-02-11', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(191, 112.09, '', 0, '2012-02-15', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(192, 170.5, '', 0, '2012-02-14', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(193, 360.07, '', 0, '2012-02-09', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(194, 99.95, '', 0, '2012-02-10', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(195, 58.8, '', 0, '2012-02-08', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(196, 119.39, '', 0, '2012-02-06', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(197, 62.8, '', 0, '2012-02-05', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(198, 61.2, '', 0, '2012-02-03', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(199, 200.49, '', 0, '2012-02-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(200, 660, '', 0, '2012-02-06', 0, 'kos', 7, NULL, '2013-01-10 23:39:18'),
	(201, 179.99, '', 0, '2012-02-02', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(202, 84.68, '', 0, '2012-02-19', 0, 'mat', 6, NULL, '2013-01-10 23:39:18'),
	(203, 108, '', 0, '2012-02-16', 0, 'kos', 6, NULL, '2013-01-10 23:39:18'),
	(204, 1314.3, 'Telenor', 0, '2012-02-08', 0, 'internett', 5, NULL, '2013-01-10 23:39:18'),
	(205, 1314.3, '', 1, '2012-02-28', 0, 'internett', 5, NULL, '2013-01-10 23:39:18'),
	(206, 957.22, 'Januar', 0, '2012-02-29', 0, 'strom', 5, NULL, '2013-01-10 23:39:18'),
	(207, 957.22, 'Januar', 1, '2012-02-28', 0, 'strom', 5, NULL, '2013-01-10 23:39:18'),
	(208, 1600, '', 1, '2012-02-01', 0, 'mat', 5, NULL, '2013-01-10 23:39:18'),
	(209, 78.1, '', 0, '2012-11-10', 0, 'mat', 6, NULL, '2013-01-11 20:29:38'),
	(210, 222.97, '', 0, '2012-11-21', 0, 'mat', 6, NULL, '2013-01-11 20:30:33'),
	(211, 152.79, '', 0, '2012-11-08', 0, 'mat', 6, NULL, '2013-01-11 20:30:58'),
	(212, 246.22, '', 0, '2012-11-23', 0, 'mat', 6, NULL, '2013-01-11 20:31:25'),
	(213, 97.9, '', 0, '2012-11-07', 0, 'mat', 6, NULL, '2013-01-11 20:31:50'),
	(214, 135.92, '', 0, '2012-11-26', 0, 'mat', 6, NULL, '2013-01-11 20:55:01'),
	(215, 105.7, '', 0, '2012-11-30', 0, 'mat', 6, NULL, '2013-01-11 20:55:33'),
	(216, 273.4, '', 0, '2012-11-30', 0, 'mat', 6, NULL, '2013-01-11 20:56:00'),
	(217, 173.71, '', 0, '2012-12-01', 0, 'mat', 6, NULL, '2013-01-11 20:56:28'),
	(218, 335.65, '', 0, '2012-11-22', 0, 'mat', 6, NULL, '2013-01-11 20:56:55'),
	(219, 311.03, '', 0, '2012-11-24', 0, 'mat', 6, NULL, '2013-01-11 20:57:28'),
	(220, 157.41, '', 0, '2012-11-06', 0, 'mat', 5, NULL, '2013-01-11 20:58:27'),
	(221, 219.31, '', 0, '2012-11-16', 0, 'mat', 6, NULL, '2013-01-11 20:59:04'),
	(222, 275.24, '', 0, '2012-11-06', 0, 'mat', 5, NULL, '2013-01-11 21:00:02'),
	(223, 85.5, '', 0, '2012-10-31', 0, 'mat', 5, NULL, '2013-01-11 21:00:27'),
	(224, 77, '', 0, '2012-11-05', 0, 'mat', 5, NULL, '2013-01-11 21:01:03'),
	(225, 142.97, '', 0, '2012-11-03', 0, 'mat', 5, NULL, '2013-01-11 21:01:35'),
	(226, 119.26, '', 0, '2012-11-01', 0, 'mat', 5, NULL, '2013-01-11 21:02:16'),
	(227, 27.3, '', 0, '2012-11-12', 0, 'mat', 5, NULL, '2013-01-11 21:02:41'),
	(228, 229.8, '', 0, '2012-11-13', 0, 'mat', 5, NULL, '2013-01-11 21:03:06'),
	(229, 397.23, '', 0, '2012-11-14', 0, 'mat', 5, NULL, '2013-01-11 21:03:34'),
	(230, 192.69, '', 0, '2012-12-04', 0, 'mat', 7, NULL, '2013-01-11 21:04:16'),
	(231, 222.9, '', 0, '2012-11-02', 0, 'mat', 7, NULL, '2013-01-11 21:04:57'),
	(232, 146.2, '', 0, '2012-11-30', 0, 'mat', 7, NULL, '2013-01-11 21:05:27'),
	(233, 129.5, '', 0, '2012-11-09', 0, 'mat', 7, '2013-01-13 17:01:45', '2013-01-11 21:06:16'),
	(234, 116.1, '', 0, '2012-11-16', 0, 'mat', 5, NULL, '2013-01-11 21:06:55'),
	(235, 43.55, '', 0, '2012-12-03', 0, 'mat', 7, NULL, '2013-01-11 21:07:32'),
	(236, 84.65, '', 0, '2012-12-09', 0, 'mat', 7, NULL, '2013-01-13 16:42:29'),
	(237, 139.1, '', 0, '2012-12-11', 0, 'mat', 5, NULL, '2013-01-13 16:45:16'),
	(238, 155.96, '', 0, '2012-12-14', 0, 'mat', 5, '2013-01-13 16:47:20', '2013-01-13 16:45:51'),
	(239, 118, 'Pasta sentralen, november 29', 0, '2012-12-29', 0, 'kos', 7, NULL, '2013-01-13 17:18:46'),
	(240, 900, 'Kurt Nilsen mai', 0, '2013-01-10', 0, 'konsert', 6, NULL, '2013-01-13 17:21:03'),
	(241, 1286.29, 'Strøm desember', 0, '2013-01-29', 0, 'strom', 6, NULL, '2013-01-13 17:27:11'),
	(242, 1179.3, 'Første kvartal 2013', 0, '2013-01-24', 0, 'internett', 6, NULL, '2013-01-13 17:28:24'),
	(243, 1340.28, 'NRK 2013', 0, '2013-01-31', 0, 'tv', 6, NULL, '2013-01-13 17:54:31'),
	(244, 869.29, 'Strøm november', 0, '2012-12-16', 0, 'strom', 6, NULL, '2013-01-13 17:57:23'),
	(245, 128.01, '', 0, '2013-01-04', 0, 'mat', 7, NULL, '2013-01-13 18:05:48'),
	(246, 500, '', 0, '2013-01-02', 0, 'mat', 5, NULL, '2013-01-13 18:09:16'),
	(247, 85, '', 0, '2013-01-02', 0, 'mat', 6, NULL, '2013-01-13 18:09:32'),
	(248, 203.66, '', 0, '2013-01-05', 0, 'mat', 6, NULL, '2013-01-13 18:10:34'),
	(249, 132.02, '', 0, '2013-01-10', 0, 'mat', 7, NULL, '2013-01-13 18:11:12'),
	(250, 56.27, '', 0, '2013-01-08', 0, 'mat', 6, NULL, '2013-01-13 18:11:43'),
	(251, 279.62, '', 0, '2013-01-07', 0, 'mat', 7, NULL, '2013-01-13 18:12:04'),
	(252, 58.4, '', 0, '2013-01-12', 0, 'mat', 6, NULL, '2013-01-13 18:13:15'),
	(253, 150, 'Brutus SAS til Ålesund', 0, '2012-12-05', 0, 'transport', 7, NULL, '2013-01-13 18:22:22'),
	(254, 200, 'Brutus Norwegian til Bergen', 0, '2012-12-12', 0, 'transport', 7, '2013-01-13 20:40:10', '2013-01-13 18:23:06'),
	(255, 150, 'Brutus SAS til Oslo', 0, '2012-12-28', 0, 'transport', 7, '2013-01-13 18:29:56', '2013-01-13 18:24:08'),
	(256, 270, 'Taxi til Flesland', 0, '2012-12-28', 0, 'transport', 7, '2013-01-13 18:29:20', '2013-01-13 18:24:48'),
	(257, 135, 'Buss Gardemoen til Moss', 0, '2012-12-28', 0, 'transport', 7, NULL, '2013-01-13 18:25:11'),
	(258, 1168, 'Fly Bergen til Oslo', 0, '2012-12-28', 0, 'transport', 7, NULL, '2013-01-13 18:26:07'),
	(259, 400, 'Pengene fra returnert bukse', 1, '2012-12-27', 1, 'skyldig', 6, NULL, '2013-01-13 18:27:40'),
	(260, 178.68, '', 0, '2013-01-12', 0, 'mat', 6, NULL, '2013-01-13 20:52:48'),
	(261, 85.71, '', 0, '2013-01-12', 1, 'mat', 6, NULL, '2013-01-13 20:53:59'),
	(262, 485, 'Sand og mat', 0, '2013-01-03', 0, 'katt', 6, NULL, '2013-01-13 21:17:01'),
	(263, 295, 'Taxi fra Flesland', 0, '2013-01-02', 0, 'transport', 6, NULL, '2013-01-13 21:18:11'),
	(264, 4000, '', 0, '2012-12-30', 1, 'husleie', 7, '2013-01-13 22:15:45', '2013-01-13 22:12:28'),
	(266, 2000, 'Mat januar', 0, '2012-12-30', 0, 'skyldig', 6, '2013-01-14 14:28:11', '2013-01-13 22:26:10'),
	(267, 54.8, '', 0, '2012-04-13', 0, 'mat', 5, NULL, '2013-01-13 23:36:28'),
	(268, 326.01, '', 0, '2012-03-29', 0, 'mat', 5, NULL, '2013-01-13 23:36:55'),
	(269, 71, '', 0, '2012-04-13', 0, 'mat', 5, NULL, '2013-01-13 23:37:30'),
	(270, 111.9, '', 0, '2012-04-14', 0, 'mat', 5, NULL, '2013-01-13 23:38:10'),
	(271, 153.85, '', 0, '2012-04-18', 0, 'mat', 7, NULL, '2013-01-13 23:38:58'),
	(272, 81.7, '', 0, '2012-04-27', 0, 'mat', 6, NULL, '2013-01-13 23:39:34'),
	(273, 135.22, '', 0, '2012-04-16', 0, 'mat', 7, NULL, '2013-01-13 23:39:56'),
	(274, 202.47, '', 0, '2012-04-25', 0, 'mat', 6, NULL, '2013-01-13 23:40:18'),
	(275, 216.1, '', 0, '2012-04-26', 0, 'mat', 6, NULL, '2013-01-13 23:40:44'),
	(276, 235.17, '', 0, '2012-04-28', 0, 'mat', 6, NULL, '2013-01-13 23:41:12'),
	(277, 222, '', 0, '2012-04-03', 0, 'mat', 5, NULL, '2013-01-13 23:41:48'),
	(278, 146.78, '', 0, '2012-04-28', 0, 'mat', 7, NULL, '2013-01-13 23:42:11'),
	(279, 125.8, '', 0, '2012-04-23', 0, 'mat', 6, NULL, '2013-01-13 23:43:11'),
	(280, 331.79, '', 0, '2012-03-27', 0, 'mat', 7, NULL, '2013-01-13 23:43:31'),
	(281, 136.3, '', 0, '2012-03-31', 0, 'mat', 5, NULL, '2013-01-13 23:44:00'),
	(282, 277.48, '', 0, '2012-04-02', 0, 'mat', 7, NULL, '2013-01-13 23:44:23'),
	(283, 258.97, '', 0, '2012-04-12', 0, 'mat', 5, NULL, '2013-01-13 23:44:48'),
	(284, 149.2, '', 0, '2012-04-19', 0, 'mat', 6, NULL, '2013-01-13 23:45:09'),
	(285, 445.69, '', 0, '2012-04-07', 0, 'mat', 5, NULL, '2013-01-13 23:45:30'),
	(286, 192.61, '', 0, '2012-04-10', 0, 'mat', 5, NULL, '2013-01-13 23:45:52'),
	(287, 166.08, '', 0, '2012-04-04', 0, 'mat', 5, NULL, '2013-01-13 23:46:26'),
	(288, 41.8, '', 0, '2012-05-14', 0, 'mat', 5, NULL, '2013-01-13 23:50:12'),
	(289, 149.1, '', 0, '2012-05-24', 0, 'mat', 6, NULL, '2013-01-13 23:50:39'),
	(290, 93.43, '', 0, '2012-05-31', 0, 'mat', 6, NULL, '2013-01-13 23:51:00'),
	(291, 435, '', 0, '2012-05-16', 0, 'transport', 6, NULL, '2013-01-13 23:51:33'),
	(292, 70.1, '', 0, '2012-05-22', 0, 'mat', 5, NULL, '2013-01-13 23:52:10'),
	(293, 152.39, '', 0, '2012-05-30', 0, 'mat', 6, NULL, '2013-01-13 23:52:43'),
	(294, 91.4, '', 0, '2012-05-22', 0, 'mat', 6, NULL, '2013-01-13 23:53:04'),
	(295, 99, '', 0, '2012-05-05', 0, 'katt', 5, NULL, '2013-01-13 23:53:44'),
	(296, 143.5, '', 0, '2012-05-03', 0, 'mat', 5, NULL, '2013-01-13 23:54:19'),
	(297, 191.48, '', 0, '2012-05-02', 0, 'mat', 5, NULL, '2013-01-13 23:54:42'),
	(298, 123, '', 0, '2012-05-14', 0, 'mat', 5, NULL, '2013-01-13 23:55:16'),
	(299, 74.4, '', 0, '2012-05-04', 0, 'mat', 5, NULL, '2013-01-13 23:55:41'),
	(300, 103.5, '', 0, '2012-05-04', 0, 'mat', 5, NULL, '2013-01-13 23:56:03'),
	(301, 79.1, '', 0, '2012-05-10', 0, 'mat', 5, NULL, '2013-01-13 23:56:26'),
	(302, 249, 'Laser', 0, '2012-05-05', 0, 'misc', 5, '2013-01-13 23:57:56', '2013-01-13 23:57:15'),
	(303, 163.1, '', 0, '2012-05-11', 0, 'mat', 5, NULL, '2013-01-13 23:58:24'),
	(304, 153.2, '', 0, '2012-05-10', 0, 'mat', 5, NULL, '2013-01-13 23:59:06'),
	(305, 77, '', 0, '2012-05-08', 0, 'mat', 5, NULL, '2013-01-13 23:59:30'),
	(306, 128.4, '', 0, '2012-05-08', 0, 'mat', 5, NULL, '2013-01-14 00:00:06'),
	(307, 206, '', 0, '2012-05-22', 0, 'katt', 7, NULL, '2013-01-14 00:00:33'),
	(308, 347, 'Taxi', 0, '2012-09-29', 0, 'transport', 7, NULL, '2013-01-14 00:01:39'),
	(309, 178.29, '', 0, '2012-05-22', 0, 'mat', 7, NULL, '2013-01-14 00:02:02'),
	(310, 223, '', 0, '2012-05-25', 0, 'mat', 7, NULL, '2013-01-14 00:02:24'),
	(311, 213.62, '', 0, '2012-05-12', 0, 'mat', 7, NULL, '2013-01-14 00:02:45'),
	(312, 950, 'Kastrering', 0, '2012-05-10', 0, 'katt', 7, NULL, '2013-01-14 00:03:35')
;
/*!40000 ALTER TABLE `budget_entry` ENABLE KEYS */;


-- Dumping structure for table budget_prod.budget_error
DROP TABLE IF EXISTS `budget_error`;
CREATE TABLE `budget_error` (
  `error_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `error_kill` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Error killed response',
  `error_code` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Error PHP code',
  `error_message` text NOT NULL,
  `error_file` varchar(255) NOT NULL DEFAULT '',
  `error_line` smallint(6) NOT NULL DEFAULT '0',
  `error_occured` smallint(6) NOT NULL DEFAULT '1',
  `error_url` varchar(255) NOT NULL DEFAULT '',
  `error_backtrack` longtext,
  `error_trace` longtext,
  `error_query` text,
  `error_exception` varchar(50) NOT NULL DEFAULT '',
  `error_updated` timestamp NULL DEFAULT NULL,
  `error_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`error_id`),
  UNIQUE KEY `error_unique` (`error_file`,`error_line`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_prod.budget_error: ~4 rows (approximately)
/*!40000 ALTER TABLE `budget_error` DISABLE KEYS */;
INSERT INTO `budget_error` (`error_id`, `error_kill`, `error_code`, `error_message`, `error_file`, `error_line`, `error_occured`, `error_url`, `error_backtrack`, `error_trace`, `error_query`, `error_exception`, `error_updated`, `error_registered`) VALUES 
	(1, 0, 0, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php', 244, 1, 'api_rest.php?/entry/add/&mode=1', '#1 DbException->__construct \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\db_exception.php:13\n#2 PdoDbApi->queryInsert \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php:244\n#3 PdoDbApi->query \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php:89\n#4 StandardDbDao->add \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\dao\\db\\standard_db_dao.php:265\n#5 EntryHandler->handleNew \\Scripting\\KrisSkarbo\\Budget2\\src\\handler\\entry_handler.php:69\n#6 EntryRestController->doAddModel \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\entry_rest_controller.php:106\n#7 AbstractStandardRestController->doAddCommand \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:373\n#8 AbstractStandardRestController->request \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:578\n#9 AbstractApi->doControllerViewRender \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#10 AbstractApi->doRequest \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php(89): PdoDbApi->queryInsert(Object(InsertQueryDbCore))\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\dao\\db\\standard_db_dao.php(265): PdoDbApi->query(Object(InsertQueryDbCore))\n#2 \\Scripting\\KrisSkarbo\\Budget2\\src\\handler\\entry_handler.php(69): StandardDbDao->add(Object(EntryModel), NULL)\n#3 \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\entry_rest_controller.php(106): EntryHandler->handleNew(Object(EntryModel))\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(373): EntryRestController->doAddModel(Object(EntryModel), \'1211\')\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(578): AbstractStandardRestController->doAddCommand()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#7 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#8 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#9 {main}', 'INSERT INTO budget_entry (entry_cost, entry_credit, entry_date, entry_single, entry_type, entry_card) VALUES (:comment, :debit, :date, :divide, :type, :card)\nArray\n(\n    [cost] => 97.9\n    [comment] => \n    [debit] => 0\n    [date] => 2012-11-07\n    [divide] => 0\n    [type] => mat\n    [card] => 6\n)\n', 'DbException', NULL, '2013-01-10 23:14:20'),
	(2, 0, 0, 'array_keys() expects parameter 1 to be array, integer given', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\core\\core.php', 62, 117, 'api_rest.php?/entry/edit/266&mode=1', NULL, '#0 [internal function]: AbstractApi->doErrorHandling(2, \'array_keys() ex...\', \'C:\\Users\\Kris L...\', 62, Array)\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\core\\core.php(62): array_keys(0)\n#2 \\Scripting\\KrisSkarbo\\Budget2\\src\\dao\\db\\entry_db_dao.php(273): Core::arrayAtIndex(0, 1212, 0)\n#3 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(405): EntryDbDao->getForeign(1212)\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(582): AbstractStandardRestController->doEditCommand()\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#7 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#8 {main}', NULL, 'ErrorException', '2013-01-14 14:28:11', '2013-01-10 23:15:47'),
	(4, 0, 0, 'Missing argument 3 for Validator::validateRegex(), called in C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget2\\src\\validator\\card_validator.php on line 35 and defined', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php', 116, 2, 'api_rest.php?/card/edit/7&mode=1', NULL, '#0 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php(116): AbstractApi->doErrorHandling(2, \'Missing argumen...\', \'C:\\Users\\Kris L...\', 116, Array)\n#1 \\Scripting\\KrisSkarbo\\Budget2\\src\\validator\\card_validator.php(35): Validator::validateRegex(\'Card title\', \'/[^\\w\\p{L}\\s,.-...\')\n#2 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php(199): CardValidator->doTitle()\n#3 \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\card_rest_controller.php(55): Validator->doValidate(Object(CardModel))\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(396): CardRestController->getModelPost()\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(582): AbstractStandardRestController->doEditCommand()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#7 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(CardRestController))\n#8 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#9 {main}', NULL, 'ErrorException', '2013-01-13 16:44:27', '2013-01-13 16:42:48'),
	(5, 0, 0, '', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php', 213, 1, 'api_rest.php?/card/edit/7&mode=1', '#1 ValidatorException->__construct \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\validator_exception.php:10\n#2 Validator->doValidate \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php:213\n#3 CardRestController->getModelPost \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\card_rest_controller.php:55\n#4 AbstractStandardRestController->doEditCommand \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:396\n#5 AbstractStandardRestController->request \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:582\n#6 AbstractApi->doControllerViewRender \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#7 AbstractApi->doRequest \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\card_rest_controller.php(55): Validator->doValidate(Object(CardModel))\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(396): CardRestController->getModelPost()\n#2 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(582): AbstractStandardRestController->doEditCommand()\n#3 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(CardRestController))\n#5 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#6 {main}', NULL, 'ValidatorException', NULL, '2013-01-13 16:42:48')
;
/*!40000 ALTER TABLE `budget_error` ENABLE KEYS */;


-- Dumping structure for table budget_prod.budget_type
DROP TABLE IF EXISTS `budget_type`;
CREATE TABLE `budget_type` (
  `type_id` char(50) NOT NULL,
  `type_title` varchar(255) NOT NULL,
  `type_updated` datetime DEFAULT NULL,
  `type_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table budget_prod.budget_type: ~11 rows (approximately)
/*!40000 ALTER TABLE `budget_type` DISABLE KEYS */;
INSERT INTO `budget_type` (`type_id`, `type_title`, `type_updated`, `type_registered`) VALUES 
	('husleie', 'Husleie', NULL, '2013-01-10 17:21:53'),
	('internett', 'Internett', NULL, '2013-01-10 17:21:53'),
	('katt', 'Katt', NULL, '2013-01-13 21:17:01'),
	('konsert', 'Konsert', NULL, '2013-01-13 17:21:03'),
	('kos', 'Kos', NULL, '2013-01-10 17:21:53'),
	('mat', 'Mat', NULL, '2013-01-10 17:21:53'),
	('misc', 'Misc', NULL, '2013-01-13 23:57:15'),
	('skyldig', 'Skyldig', NULL, '2013-01-13 18:26:40'),
	('strom', 'Strøm', NULL, '2013-01-10 17:21:53'),
	('transport', 'Transport', NULL, '2013-01-13 18:18:23'),
	('tv', 'TV', NULL, '2013-01-10 17:21:53')
;
/*!40000 ALTER TABLE `budget_type` ENABLE KEYS */;


-- Dumping structure for table budget_prod.budget_user
DROP TABLE IF EXISTS `budget_user`;
CREATE TABLE `budget_user` (
  `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table budget_prod.budget_user: ~0 rows (approximately)


-- Dumping structure for table budget_prod.budget_user_auth
DROP TABLE IF EXISTS `budget_user_auth`;
CREATE TABLE `budget_user_auth` (
  `user_id` mediumint(9) NOT NULL,
  `user_auth_id` varchar(100) NOT NULL,
  `user_auth_type` varchar(50) NOT NULL COMMENT 'facebook|google',
  `user_auth_name` varchar(100) NOT NULL,
  `user_auth_email` varchar(255) NOT NULL,
  `user_auth_loggedin` datetime DEFAULT NULL,
  `user_auth_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`user_auth_id`),
  CONSTRAINT `FK_USER_AUTH_USER` FOREIGN KEY (`user_id`) REFERENCES `budget_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table budget_prod.budget_user_auth: ~0 rows (approximately)


/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
