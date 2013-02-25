-- Wed, 23 Jan 2013 20:19:56 GMT
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
-- Dumping database structure for budget_dev
DROP DATABASE IF EXISTS `budget_dev`;
CREATE DATABASE `budget_dev` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `budget_dev`;


-- Dumping structure for table budget_dev.budget_budget
DROP TABLE IF EXISTS `budget_budget`;
CREATE TABLE `budget_budget` (
  `budget_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `budget_title` varchar(100) DEFAULT NULL,
  `budget_updated` datetime DEFAULT NULL,
  `budget_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_budget: ~2 rows (approximately)
/*!40000 ALTER TABLE `budget_budget` DISABLE KEYS */;
INSERT INTO `budget_budget` (`budget_id`, `budget_title`, `budget_updated`, `budget_registered`) VALUES 
	(1, 'Personal Budget', NULL, '2013-01-18 23:29:26'),
	(2, 'Personal Budget', NULL, '2013-01-19 09:45:54')
;
/*!40000 ALTER TABLE `budget_budget` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_budget_user
DROP TABLE IF EXISTS `budget_budget_user`;
CREATE TABLE `budget_budget_user` (
  `budget_id` smallint(6) NOT NULL,
  `user_id` smallint(6) DEFAULT NULL,
  `budget_user_email` varchar(255) DEFAULT NULL,
  `budget_user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `budget_id_user_id_budget_user_email` (`budget_id`,`user_id`,`budget_user_email`),
  KEY `budget_id` (`budget_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_BUDGET_USER_BUDGET` FOREIGN KEY (`budget_id`) REFERENCES `budget_budget` (`budget_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_BUDGET_USER_USER` FOREIGN KEY (`user_id`) REFERENCES `budget_user` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_budget_user: ~2 rows (approximately)
/*!40000 ALTER TABLE `budget_budget_user` DISABLE KEYS */;
INSERT INTO `budget_budget_user` (`budget_id`, `user_id`, `budget_user_email`, `budget_user_registered`) VALUES 
	(2, 1, NULL, '2013-01-19 09:45:54'),
	(1, 1, NULL, '2013-01-19 09:47:44')
;
/*!40000 ALTER TABLE `budget_budget_user` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_card
DROP TABLE IF EXISTS `budget_card`;
CREATE TABLE `budget_card` (
  `card_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `budget_id` smallint(6) NOT NULL,
  `card_title` varchar(100) NOT NULL,
  `card_number` varchar(100) NOT NULL,
  `card_joint` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = joint',
  `card_updated` datetime DEFAULT NULL,
  `card_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`card_id`),
  KEY `budget_id` (`budget_id`),
  CONSTRAINT `FK_CARD_BUDGET` FOREIGN KEY (`budget_id`) REFERENCES `budget_budget` (`budget_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_card: ~4 rows (approximately)
/*!40000 ALTER TABLE `budget_card` DISABLE KEYS */;
INSERT INTO `budget_card` (`card_id`, `budget_id`, `card_title`, `card_number`, `card_joint`, `card_updated`, `card_registered`) VALUES 
	(5, 1, 'Felles', '22528,25286', 1, NULL, '2013-01-10 17:23:31'),
	(6, 1, 'Kris', '27239,9558', 0, NULL, '2013-01-10 17:23:31'),
	(7, 1, 'Malin', '18277,64505', 0, '2013-01-13 16:44:27', '2013-01-10 17:23:31'),
	(8, 2, 'New Card', '', 0, NULL, '2013-01-22 13:53:28')
;
/*!40000 ALTER TABLE `budget_card` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_debug
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_debug: ~4 rows (approximately)
/*!40000 ALTER TABLE `budget_debug` DISABLE KEYS */;
INSERT INTO `budget_debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES 
	(1, 1, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n            [type_title] => New Type\n            [card_title] => New Card\n            [card_number] => \n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doAddModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:145\n#4 AbstractStandardRestController->doAddCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:374\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:631\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 2)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-22 13:53:28'),
	(2, 2, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n            [type_title] => New Type 3\n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doAddModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:145\n#4 AbstractStandardRestController->doAddCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:374\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:631\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 2)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-22 15:34:29'),
	(3, 3, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doAddModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:145\n#4 AbstractStandardRestController->doAddCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:374\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:631\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 2)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-23 20:19:42'),
	(4, 4, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doAddModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:145\n#4 AbstractStandardRestController->doAddCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:374\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:631\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 2)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-23 20:28:11')
;
/*!40000 ALTER TABLE `budget_debug` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_entry
DROP TABLE IF EXISTS `budget_entry`;
CREATE TABLE `budget_entry` (
  `entry_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `budget_id` smallint(6) NOT NULL,
  `entry_cost` float NOT NULL,
  `entry_comment` varchar(255) NOT NULL DEFAULT '',
  `entry_credit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 debit, 1 credit',
  `entry_date` date NOT NULL,
  `entry_single` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 divide 1 single',
  `entry_type` smallint(6) DEFAULT NULL,
  `entry_card` smallint(6) NOT NULL,
  `entry_updated` datetime DEFAULT NULL,
  `entry_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`entry_id`),
  KEY `entry_card` (`entry_card`),
  KEY `budget_id` (`budget_id`),
  KEY `entry_type` (`entry_type`),
  CONSTRAINT `FK_ENTRY_BUDGET` FOREIGN KEY (`budget_id`) REFERENCES `budget_budget` (`budget_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ENTRY_CARD` FOREIGN KEY (`entry_card`) REFERENCES `budget_card` (`card_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ENTRY_TYPE` FOREIGN KEY (`entry_type`) REFERENCES `budget_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=316 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_entry: ~314 rows (approximately)
/*!40000 ALTER TABLE `budget_entry` DISABLE KEYS */;
INSERT INTO `budget_entry` (`entry_id`, `budget_id`, `entry_cost`, `entry_comment`, `entry_credit`, `entry_date`, `entry_single`, `entry_type`, `entry_card`, `entry_updated`, `entry_registered`) VALUES 
	(1, 1, 107.5, '', 0, '2011-01-13', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(2, 1, 236.09, '', 0, '2011-01-17', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(3, 1, 156.06, '', 0, '2011-01-19', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(4, 1, 282.5, '', 0, '2011-01-20', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(5, 1, 159.8, '', 0, '2011-01-21', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(6, 1, 108.7, '', 0, '2011-01-23', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(7, 1, 297.1, '', 0, '2011-01-27', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(8, 1, 181, '', 0, '2011-01-28', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(9, 1, 181.5, '', 0, '2011-02-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(10, 1, 99.82, '', 0, '2011-02-03', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(11, 1, 72.5, '', 0, '2011-02-04', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(12, 1, 211.3, '', 0, '2011-02-05', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(13, 1, 240.45, '', 0, '2011-02-06', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(14, 1, 59.3, '', 0, '2011-02-07', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(15, 1, 39.06, '', 0, '2011-02-09', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(16, 1, 265.42, '', 0, '2011-02-11', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(17, 1, 200.1, '', 0, '2011-02-12', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(18, 1, 87.69, '', 0, '2011-02-15', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(19, 1, 98.31, '', 0, '2011-02-17', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(20, 1, 54.1, '', 0, '2011-02-17', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(21, 1, 126, '', 0, '2011-03-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(22, 1, 87.5, '', 0, '2011-03-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(23, 1, 106.95, '', 0, '2011-03-03', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(24, 1, 153.8, '', 0, '2011-03-04', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(25, 1, 131.67, '', 0, '2011-03-05', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(26, 1, 259, '', 0, '2011-03-06', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(27, 1, 122.08, '', 0, '2011-03-07', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(28, 1, 353.02, '', 0, '2011-03-08', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(29, 1, 136.7, '', 0, '2011-03-09', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(30, 1, 157.64, '', 0, '2011-03-11', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(31, 1, 129.74, '', 0, '2011-03-12', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(32, 1, 83.71, '', 0, '2011-03-14', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(33, 1, 231.62, '', 0, '2011-03-16', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(34, 1, 216.3, '', 0, '2011-03-17', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(35, 1, 119.06, '', 0, '2011-03-19', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(36, 1, 171.71, '', 0, '2011-03-21', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(37, 1, 98.05, '', 0, '2011-03-22', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(38, 1, 104.3, '', 0, '2011-03-23', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(39, 1, 185.62, '', 0, '2011-03-25', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(40, 1, 102.1, '', 0, '2011-03-26', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(41, 1, 163.64, '', 0, '2011-03-26', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(42, 1, 169.26, '', 0, '2011-03-28', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(43, 1, 113.25, '', 0, '2011-03-29', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(44, 1, 90.68, '', 0, '2011-03-30', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(45, 1, 34.9, '', 0, '2011-04-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(46, 1, 167.95, '', 0, '2011-04-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(47, 1, 91.55, '', 0, '2011-04-06', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(48, 1, 264.93, '', 0, '2011-04-07', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(49, 1, 83.2, '', 0, '2011-04-08', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(50, 1, 54.52, '', 0, '2011-04-11', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(51, 1, 98.5, '', 0, '2011-04-12', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(52, 1, 95.86, '', 0, '2011-04-13', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(53, 1, 166.64, '', 0, '2011-04-14', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(54, 1, 38.51, '', 0, '2011-04-16', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(55, 1, 121.8, '', 0, '2011-04-25', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(56, 1, 108.52, '', 0, '2011-04-26', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(57, 1, 107.99, '', 0, '2011-04-27', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(58, 1, 46.1, '', 0, '2011-04-27', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(59, 1, 153.2, '', 0, '2011-04-27', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(60, 1, 78.3, '', 0, '2011-04-29', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(61, 1, 103.8, '', 0, '2011-04-30', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(62, 1, 207.87, '', 0, '2011-05-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(63, 1, 95.2, '', 0, '2011-05-03', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(64, 1, 28.3, '', 0, '2011-05-04', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(65, 1, 173.99, '', 0, '2011-05-06', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(66, 1, 72.01, '', 0, '2011-05-07', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(67, 1, 29.9, '', 0, '2011-05-07', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(68, 1, 133.42, '', 0, '2011-05-09', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(69, 1, 108.83, '', 0, '2011-05-13', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(70, 1, 171.34, '', 0, '2011-05-16', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(71, 1, 82, '', 0, '2011-05-19', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(72, 1, 145.53, '', 0, '2011-05-20', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(73, 1, 86.13, '', 0, '2011-05-23', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(74, 1, 53.53, '', 0, '2011-05-23', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(75, 1, 94.56, '', 0, '2011-05-24', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(76, 1, 54.3, '', 0, '2011-05-25', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(77, 1, 260.97, '', 0, '2011-05-27', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(78, 1, 123.3, '', 0, '2011-05-29', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(79, 1, 96.8, '', 0, '2011-05-30', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(80, 1, 235.25, '', 0, '2011-06-01', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(81, 1, 181.3, '', 0, '2011-08-08', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(82, 1, 591.33, '', 0, '2011-08-09', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(83, 1, 17.19, '', 0, '2011-08-09', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(84, 1, 244.5, '', 0, '2011-08-10', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(85, 1, 89.6, '', 0, '2011-08-11', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(86, 1, 149.85, '', 0, '2011-08-13', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(87, 1, 248.97, '', 0, '2011-08-15', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(88, 1, 220.44, '', 0, '2011-08-17', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(89, 1, 175.15, '', 0, '2011-08-24', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(90, 1, 112.55, '', 0, '2011-08-25', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(91, 1, 19.1, '', 0, '2011-08-26', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(92, 1, 176.65, '', 0, '2011-08-26', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(93, 1, 194.3, '', 0, '2011-08-30', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(94, 1, 120.49, '', 0, '2011-08-30', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(95, 1, 73, '', 0, '2011-08-31', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(96, 1, 189.44, '', 0, '2011-09-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(97, 1, 165.61, '', 0, '2011-09-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(98, 1, 141.93, '', 0, '2011-09-05', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(99, 1, 238.74, '', 0, '2011-09-06', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(100, 1, 98.08, '', 0, '2011-09-09', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(101, 1, 159.3, '', 0, '2011-09-10', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(102, 1, 129.93, '', 0, '2011-09-12', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(103, 1, 168.91, '', 0, '2011-09-20', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(104, 1, 174, '', 0, '2011-09-24', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(105, 1, 81.2, '', 0, '2011-10-04', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(106, 1, 119.08, '', 0, '2011-10-06', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(107, 1, 108.19, '', 0, '2011-10-07', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(108, 1, 42.81, '', 0, '2011-10-12', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(109, 1, 218.43, '', 0, '2011-10-14', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(110, 1, 55.9, '', 0, '2011-10-19', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(111, 1, 176.47, '', 0, '2011-10-21', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(112, 1, 23.1, '', 0, '2011-10-25', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(113, 1, 393.42, '', 0, '2011-10-28', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(114, 1, 76.3, '', 0, '2011-10-28', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(115, 1, 82.27, '', 0, '2011-10-29', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(116, 1, 210.36, '', 0, '2011-10-31', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(117, 1, 72.9, '', 0, '2011-11-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(118, 1, 70.04, '', 0, '2011-11-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(119, 1, 98.25, '', 0, '2011-11-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(120, 1, 242.17, '', 0, '2011-11-04', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(121, 1, 245.74, '', 0, '2011-11-10', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(122, 1, 45.05, '', 0, '2011-11-15', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(123, 1, 76.18, '', 0, '2011-11-16', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(124, 1, 129.5, '', 0, '2011-11-17', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(125, 1, 226.5, '', 0, '2011-11-18', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(126, 1, 194.14, '', 0, '2011-11-18', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(127, 1, 70, '', 0, '2011-11-18', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(128, 1, 114.6, '', 0, '2011-11-19', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(129, 1, 215.7, '', 0, '2011-11-21', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(130, 1, 121.45, '', 0, '2011-11-22', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(131, 1, 196.5, '', 0, '2011-11-25', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(132, 1, 56.7, '', 0, '2011-11-25', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(133, 1, 191.67, '', 0, '2011-11-26', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(134, 1, 346.51, '', 0, '2011-11-28', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(135, 1, 142.63, '', 0, '2011-11-30', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(136, 1, 117.5, '', 0, '2011-12-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(137, 1, 172.68, '', 0, '2011-12-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(138, 1, 160.24, '', 0, '2011-12-03', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(139, 1, 86.34, '', 0, '2011-12-05', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(140, 1, 117.25, '', 0, '2011-12-08', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(141, 1, 90.62, '', 0, '2011-12-08', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(142, 1, 219.44, '', 0, '2011-12-08', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(143, 1, 190.76, '', 0, '2011-12-12', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(144, 1, 63.6, '', 0, '2011-12-15', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(145, 1, 1600, '', 1, '2012-01-01', 1, 6, 5, NULL, '2013-01-10 23:39:18'),
	(146, 1, 108.9, '', 0, '2012-01-06', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(147, 1, 248.35, '', 0, '2012-01-09', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(148, 1, 197.8, '', 0, '2012-01-05', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(149, 1, 134.65, '', 0, '2012-01-09', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(150, 1, 422.74, '', 0, '2012-01-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(151, 1, 1290.06, '', 0, '2012-01-31', 1, 12, 5, NULL, '2013-01-10 23:39:18'),
	(152, 1, 420.25, '', 0, '2012-01-03', 0, 10, 5, NULL, '2013-01-10 23:39:18'),
	(153, 1, 4000, 'Fra Kris', 1, '2012-01-28', 1, 1, 7, NULL, '2013-01-10 23:39:18'),
	(154, 1, 4000, '', 0, '2012-01-31', 1, 1, 7, NULL, '2013-01-10 23:39:18'),
	(155, 1, 1290.06, 'Fra Kris og Malin', 1, '2012-01-28', 0, 12, 5, NULL, '2013-01-10 23:39:18'),
	(156, 1, 420.25, 'Fra Kris og Malin', 1, '2012-01-28', 0, 10, 5, NULL, '2013-01-10 23:39:18'),
	(157, 1, 194.78, '', 0, '2012-01-10', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(158, 1, 366.3, '', 0, '2012-01-13', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(159, 1, 279.87, '', 0, '2012-01-13', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(160, 1, 60, '', 0, '2012-01-13', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(161, 1, 611.38, 'Strom for desember', 0, '2012-01-31', 0, 10, 5, NULL, '2013-01-10 23:39:18'),
	(162, 1, 611.38, '', 1, '2012-01-28', 0, 10, 5, NULL, '2013-01-10 23:39:18'),
	(163, 1, 52.37, '', 0, '2012-01-16', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(164, 1, 156.8, '', 0, '2012-01-16', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(165, 1, 118, '', 0, '2012-01-14', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(166, 1, 167, 'Pastasentralen og calzone', 0, '2012-01-17', 1, 6, 7, NULL, '2013-01-10 23:39:18'),
	(167, 1, 200, '', 0, '2012-01-17', 1, 5, 6, NULL, '2013-01-10 23:39:18'),
	(168, 1, 155.12, '', 0, '2012-01-19', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(169, 1, 54.07, '', 0, '2012-01-18', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(170, 1, 54, '', 0, '2012-01-25', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(171, 1, 81.8, '', 0, '2012-01-24', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(172, 1, 173.15, '', 0, '2012-01-23', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(173, 1, 116.38, '', 0, '2012-01-20', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(174, 1, 93.51, '', 0, '2012-02-01', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(175, 1, 193.57, '', 0, '2012-02-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(176, 1, 171.08, '', 0, '2012-01-27', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(177, 1, 65.8, '', 0, '2012-01-26', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(178, 1, 72, '7-eleven', 0, '2012-01-27', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(179, 1, 102, '', 0, '2012-01-25', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(180, 1, 119.7, 'Rema-1000', 0, '2012-01-23', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(181, 1, 128.23, '', 0, '2012-02-07', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(182, 1, 128.45, '', 0, '2012-02-21', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(183, 1, 258.62, '', 0, '2012-02-20', 0, 6, 7, NULL, '2013-01-10 23:39:18'),
	(184, 1, 33.85, '', 0, '2012-02-20', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(185, 1, 245, 'Pizzabakeren', 0, '2012-02-18', 0, 5, 6, NULL, '2013-01-10 23:39:18'),
	(186, 1, 83.9, '', 0, '2012-02-18', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(187, 1, 287.3, '', 0, '2012-02-04', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(188, 1, 262.61, '', 0, '2012-02-17', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(189, 1, 70.6, '', 0, '2012-02-13', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(190, 1, 245.48, '', 0, '2012-02-11', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(191, 1, 112.09, '', 0, '2012-02-15', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(192, 1, 170.5, '', 0, '2012-02-14', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(193, 1, 360.07, '', 0, '2012-02-09', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(194, 1, 99.95, '', 0, '2012-02-10', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(195, 1, 58.8, '', 0, '2012-02-08', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(196, 1, 119.39, '', 0, '2012-02-06', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(197, 1, 62.8, '', 0, '2012-02-05', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(198, 1, 61.2, '', 0, '2012-02-03', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(199, 1, 200.49, '', 0, '2012-02-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(200, 1, 660, '', 0, '2012-02-06', 0, 5, 7, NULL, '2013-01-10 23:39:18'),
	(201, 1, 179.99, '', 0, '2012-02-02', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(202, 1, 84.68, '', 0, '2012-02-19', 0, 6, 6, NULL, '2013-01-10 23:39:18'),
	(203, 1, 108, '', 0, '2012-02-16', 0, 5, 6, NULL, '2013-01-10 23:39:18'),
	(204, 1, 1314.3, 'Telenor', 0, '2012-02-08', 0, 2, 5, NULL, '2013-01-10 23:39:18'),
	(205, 1, 1314.3, '', 1, '2012-02-28', 0, 2, 5, NULL, '2013-01-10 23:39:18'),
	(206, 1, 957.22, 'Januar', 0, '2012-02-29', 0, 10, 5, NULL, '2013-01-10 23:39:18'),
	(207, 1, 957.22, 'Januar', 1, '2012-02-28', 0, 10, 5, NULL, '2013-01-10 23:39:18'),
	(208, 1, 1600, '', 1, '2012-02-01', 0, 6, 5, NULL, '2013-01-10 23:39:18'),
	(209, 1, 78.1, '', 0, '2012-11-10', 0, 6, 6, NULL, '2013-01-11 20:29:38'),
	(210, 1, 222.97, '', 0, '2012-11-21', 0, 6, 6, NULL, '2013-01-11 20:30:33'),
	(211, 1, 152.79, '', 0, '2012-11-08', 0, 6, 6, NULL, '2013-01-11 20:30:58'),
	(212, 1, 246.22, '', 0, '2012-11-23', 0, 6, 6, NULL, '2013-01-11 20:31:25'),
	(213, 1, 97.9, '', 0, '2012-11-07', 0, 6, 6, NULL, '2013-01-11 20:31:50'),
	(214, 1, 135.92, '', 0, '2012-11-26', 0, 6, 6, NULL, '2013-01-11 20:55:01'),
	(215, 1, 105.7, '', 0, '2012-11-30', 0, 6, 6, NULL, '2013-01-11 20:55:33'),
	(216, 1, 273.4, '', 0, '2012-11-30', 0, 6, 6, NULL, '2013-01-11 20:56:00'),
	(217, 1, 173.71, '', 0, '2012-12-01', 0, 6, 6, NULL, '2013-01-11 20:56:28'),
	(218, 1, 335.65, '', 0, '2012-11-22', 0, 6, 6, NULL, '2013-01-11 20:56:55'),
	(219, 1, 311.03, '', 0, '2012-11-24', 0, 6, 6, NULL, '2013-01-11 20:57:28'),
	(220, 1, 157.41, '', 0, '2012-11-06', 0, 6, 5, NULL, '2013-01-11 20:58:27'),
	(221, 1, 219.31, '', 0, '2012-11-16', 0, 6, 6, NULL, '2013-01-11 20:59:04'),
	(222, 1, 275.24, '', 0, '2012-11-06', 0, 6, 5, NULL, '2013-01-11 21:00:02'),
	(223, 1, 85.5, '', 0, '2012-10-31', 0, 6, 5, NULL, '2013-01-11 21:00:27'),
	(224, 1, 77, '', 0, '2012-11-05', 0, 6, 5, NULL, '2013-01-11 21:01:03'),
	(225, 1, 142.97, '', 0, '2012-11-03', 0, 6, 5, NULL, '2013-01-11 21:01:35'),
	(226, 1, 119.26, '', 0, '2012-11-01', 0, 6, 5, NULL, '2013-01-11 21:02:16'),
	(227, 1, 27.3, '', 0, '2012-11-12', 0, 6, 5, NULL, '2013-01-11 21:02:41'),
	(228, 1, 229.8, '', 0, '2012-11-13', 0, 6, 5, NULL, '2013-01-11 21:03:06'),
	(229, 1, 397.23, '', 0, '2012-11-14', 0, 6, 5, NULL, '2013-01-11 21:03:34'),
	(230, 1, 192.69, '', 0, '2012-12-04', 0, 6, 7, NULL, '2013-01-11 21:04:16'),
	(231, 1, 222.9, '', 0, '2012-11-02', 0, 6, 7, NULL, '2013-01-11 21:04:57'),
	(232, 1, 146.2, '', 0, '2012-11-30', 0, 6, 7, NULL, '2013-01-11 21:05:27'),
	(233, 1, 129.5, '', 0, '2012-11-09', 0, 6, 7, '2013-01-13 17:01:45', '2013-01-11 21:06:16'),
	(234, 1, 116.1, '', 0, '2012-11-16', 0, 6, 5, NULL, '2013-01-11 21:06:55'),
	(235, 1, 43.55, '', 0, '2012-12-03', 0, 6, 7, NULL, '2013-01-11 21:07:32'),
	(236, 1, 84.65, '', 0, '2012-12-09', 0, 6, 7, NULL, '2013-01-13 16:42:29'),
	(237, 1, 139.1, '', 0, '2012-12-11', 0, 6, 5, NULL, '2013-01-13 16:45:16'),
	(238, 1, 155.96, '', 0, '2012-12-14', 0, 6, 5, '2013-01-13 16:47:20', '2013-01-13 16:45:51'),
	(239, 1, 118, 'Pasta sentralen, november 29', 0, '2012-12-29', 0, 5, 7, NULL, '2013-01-13 17:18:46'),
	(240, 1, 900, 'Kurt Nilsen mai', 0, '2013-01-10', 0, 4, 6, NULL, '2013-01-13 17:21:03'),
	(241, 1, 1286.29, 'Strøm desember', 0, '2013-01-29', 0, 10, 6, NULL, '2013-01-13 17:27:11'),
	(242, 1, 1179.3, 'Første kvartal 2013', 0, '2013-01-24', 0, 2, 6, NULL, '2013-01-13 17:28:24'),
	(243, 1, 1340.28, 'NRK 2013', 0, '2013-01-31', 0, 12, 6, NULL, '2013-01-13 17:54:31'),
	(244, 1, 869.29, 'Strøm november', 0, '2012-12-16', 0, 10, 6, NULL, '2013-01-13 17:57:23'),
	(245, 1, 128.01, '', 0, '2013-01-04', 0, 6, 7, NULL, '2013-01-13 18:05:48'),
	(246, 1, 500, '', 0, '2013-01-02', 0, 6, 5, NULL, '2013-01-13 18:09:16'),
	(247, 1, 85, '', 0, '2013-01-02', 0, 6, 6, NULL, '2013-01-13 18:09:32'),
	(248, 1, 203.66, '', 0, '2013-01-05', 0, 6, 6, NULL, '2013-01-13 18:10:34'),
	(249, 1, 132.02, '', 0, '2013-01-10', 0, 6, 7, NULL, '2013-01-13 18:11:12'),
	(250, 1, 56.27, '', 0, '2013-01-08', 0, 6, 6, NULL, '2013-01-13 18:11:43'),
	(251, 1, 279.62, '', 0, '2013-01-07', 0, 6, 7, NULL, '2013-01-13 18:12:04'),
	(252, 1, 58.4, '', 0, '2013-01-12', 0, 6, 6, NULL, '2013-01-13 18:13:15'),
	(253, 1, 150, 'Brutus SAS til Ålesund', 0, '2012-12-05', 0, 11, 7, NULL, '2013-01-13 18:22:22'),
	(254, 1, 200, 'Brutus Norwegian til Bergen', 0, '2012-12-12', 0, 11, 7, '2013-01-13 20:40:10', '2013-01-13 18:23:06'),
	(255, 1, 150, 'Brutus SAS til Oslo', 0, '2012-12-28', 0, 11, 7, '2013-01-13 18:29:56', '2013-01-13 18:24:08'),
	(256, 1, 270, 'Taxi til Flesland', 0, '2012-12-28', 0, 11, 7, '2013-01-13 18:29:20', '2013-01-13 18:24:48'),
	(257, 1, 135, 'Buss Gardemoen til Moss', 0, '2012-12-28', 0, 11, 7, NULL, '2013-01-13 18:25:11'),
	(258, 1, 1168, 'Fly Bergen til Oslo', 0, '2012-12-28', 0, 11, 7, NULL, '2013-01-13 18:26:07'),
	(259, 1, 400, 'Pengene fra returnert bukse', 1, '2012-12-27', 1, 9, 6, NULL, '2013-01-13 18:27:40'),
	(260, 1, 178.68, '', 0, '2013-01-12', 0, 6, 6, NULL, '2013-01-13 20:52:48'),
	(261, 1, 85.71, '', 0, '2013-01-12', 1, 6, 6, NULL, '2013-01-13 20:53:59'),
	(262, 1, 485, 'Sand og mat', 0, '2013-01-03', 0, 3, 6, NULL, '2013-01-13 21:17:01'),
	(263, 1, 295, 'Taxi fra Flesland', 0, '2013-01-02', 0, 11, 6, NULL, '2013-01-13 21:18:11'),
	(264, 1, 4000, '', 0, '2012-12-30', 1, 1, 7, '2013-01-13 22:15:45', '2013-01-13 22:12:28'),
	(266, 1, 2000, 'Mat januar', 0, '2012-12-30', 0, 9, 6, '2013-01-14 14:28:11', '2013-01-13 22:26:10'),
	(267, 1, 54.8, '', 0, '2012-04-13', 0, 6, 5, NULL, '2013-01-13 23:36:28'),
	(268, 1, 326.01, '', 0, '2012-03-29', 0, 6, 5, NULL, '2013-01-13 23:36:55'),
	(269, 1, 71, '', 0, '2012-04-13', 0, 6, 5, NULL, '2013-01-13 23:37:30'),
	(270, 1, 111.9, '', 0, '2012-04-14', 0, 6, 5, NULL, '2013-01-13 23:38:10'),
	(271, 1, 153.85, '', 0, '2012-04-18', 0, 6, 7, NULL, '2013-01-13 23:38:58'),
	(272, 1, 81.7, '', 0, '2012-04-27', 0, 6, 6, NULL, '2013-01-13 23:39:34'),
	(273, 1, 135.22, '', 0, '2012-04-16', 0, 6, 7, NULL, '2013-01-13 23:39:56'),
	(274, 1, 202.47, '', 0, '2012-04-25', 0, 6, 6, NULL, '2013-01-13 23:40:18'),
	(275, 1, 216.1, '', 0, '2012-04-26', 0, 6, 6, NULL, '2013-01-13 23:40:44'),
	(276, 1, 235.17, '', 0, '2012-04-28', 0, 6, 6, NULL, '2013-01-13 23:41:12'),
	(277, 1, 222, '', 0, '2012-04-03', 0, 6, 5, NULL, '2013-01-13 23:41:48'),
	(278, 1, 146.78, '', 0, '2012-04-28', 0, 6, 7, NULL, '2013-01-13 23:42:11'),
	(279, 1, 125.8, '', 0, '2012-04-23', 0, 6, 6, NULL, '2013-01-13 23:43:11'),
	(280, 1, 331.79, '', 0, '2012-03-27', 0, 6, 7, NULL, '2013-01-13 23:43:31'),
	(281, 1, 136.3, '', 0, '2012-03-31', 0, 6, 5, NULL, '2013-01-13 23:44:00'),
	(282, 1, 277.48, '', 0, '2012-04-02', 0, 6, 7, NULL, '2013-01-13 23:44:23'),
	(283, 1, 258.97, '', 0, '2012-04-12', 0, 6, 5, NULL, '2013-01-13 23:44:48'),
	(284, 1, 149.2, '', 0, '2012-04-19', 0, 6, 6, NULL, '2013-01-13 23:45:09'),
	(285, 1, 445.69, '', 0, '2012-04-07', 0, 6, 5, NULL, '2013-01-13 23:45:30'),
	(286, 1, 192.61, '', 0, '2012-04-10', 0, 6, 5, NULL, '2013-01-13 23:45:52'),
	(287, 1, 166.08, '', 0, '2012-04-04', 0, 6, 5, NULL, '2013-01-13 23:46:26'),
	(288, 1, 41.8, '', 0, '2012-05-14', 0, 6, 5, NULL, '2013-01-13 23:50:12'),
	(289, 1, 149.1, '', 0, '2012-05-24', 0, 6, 6, NULL, '2013-01-13 23:50:39'),
	(290, 1, 93.43, '', 0, '2012-05-31', 0, 6, 6, NULL, '2013-01-13 23:51:00'),
	(291, 1, 435, '', 0, '2012-05-16', 0, 11, 6, NULL, '2013-01-13 23:51:33'),
	(292, 1, 70.1, '', 0, '2012-05-22', 0, 6, 5, NULL, '2013-01-13 23:52:10'),
	(293, 1, 152.39, '', 0, '2012-05-30', 0, 6, 6, NULL, '2013-01-13 23:52:43'),
	(294, 1, 91.4, '', 0, '2012-05-22', 0, 6, 6, NULL, '2013-01-13 23:53:04'),
	(295, 1, 99, '', 0, '2012-05-05', 0, 3, 5, NULL, '2013-01-13 23:53:44'),
	(296, 1, 143.5, '', 0, '2012-05-03', 0, 6, 5, NULL, '2013-01-13 23:54:19'),
	(297, 1, 191.48, '', 0, '2012-05-02', 0, 6, 5, NULL, '2013-01-13 23:54:42'),
	(298, 1, 123, '', 0, '2012-05-14', 0, 6, 5, NULL, '2013-01-13 23:55:16'),
	(299, 1, 74.4, '', 0, '2012-05-04', 0, 6, 5, NULL, '2013-01-13 23:55:41'),
	(300, 1, 103.5, '', 0, '2012-05-04', 0, 6, 5, NULL, '2013-01-13 23:56:03'),
	(301, 1, 79.1, '', 0, '2012-05-10', 0, 6, 5, NULL, '2013-01-13 23:56:26'),
	(302, 1, 249, 'Laser', 0, '2012-05-05', 0, 7, 5, '2013-01-13 23:57:56', '2013-01-13 23:57:15'),
	(303, 1, 163.1, '', 0, '2012-05-11', 0, 6, 5, NULL, '2013-01-13 23:58:24'),
	(304, 1, 153.2, '', 0, '2012-05-10', 0, 6, 5, NULL, '2013-01-13 23:59:06'),
	(305, 1, 77, '', 0, '2012-05-08', 0, 6, 5, NULL, '2013-01-13 23:59:30'),
	(306, 1, 128.4, '', 0, '2012-05-08', 0, 6, 5, NULL, '2013-01-14 00:00:06'),
	(307, 1, 206, '', 0, '2012-05-22', 0, 3, 7, NULL, '2013-01-14 00:00:33'),
	(308, 1, 347, 'Taxi', 0, '2012-09-29', 0, 11, 7, NULL, '2013-01-14 00:01:39'),
	(309, 1, 178.29, '', 0, '2012-05-22', 0, 6, 7, NULL, '2013-01-14 00:02:02'),
	(310, 1, 223, '', 0, '2012-05-25', 0, 6, 7, NULL, '2013-01-14 00:02:24'),
	(311, 1, 213.62, '', 0, '2012-05-12', 0, 6, 7, NULL, '2013-01-14 00:02:45'),
	(312, 1, 950, 'Kastrering', 0, '2012-05-10', 0, 3, 7, NULL, '2013-01-14 00:03:35'),
	(313, 2, 789, 'test', 0, '2013-01-01', 0, 8, 8, NULL, '2013-01-22 13:53:28'),
	(314, 2, 741, '', 0, '2013-01-03', 0, 14, 8, NULL, '2013-01-22 15:34:29'),
	(315, 2, 798, '', 0, '2013-01-02', 0, 14, 8, NULL, '2013-01-23 20:28:11')
;
/*!40000 ALTER TABLE `budget_entry` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_error
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_error: ~5 rows (approximately)
/*!40000 ALTER TABLE `budget_error` DISABLE KEYS */;
INSERT INTO `budget_error` (`error_id`, `error_kill`, `error_code`, `error_message`, `error_file`, `error_line`, `error_occured`, `error_url`, `error_backtrack`, `error_trace`, `error_query`, `error_exception`, `error_updated`, `error_registered`) VALUES 
	(1, 0, 0, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php', 244, 1, 'api_rest.php?/entry/add/&mode=1', '#1 DbException->__construct \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\db_exception.php:13\n#2 PdoDbApi->queryInsert \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php:244\n#3 PdoDbApi->query \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php:89\n#4 StandardDbDao->add \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\dao\\db\\standard_db_dao.php:265\n#5 EntryHandler->handleNew \\Scripting\\KrisSkarbo\\Budget2\\src\\handler\\entry_handler.php:69\n#6 EntryRestController->doAddModel \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\entry_rest_controller.php:106\n#7 AbstractStandardRestController->doAddCommand \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:373\n#8 AbstractStandardRestController->request \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:578\n#9 AbstractApi->doControllerViewRender \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#10 AbstractApi->doRequest \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\db\\pdo_db_api.php(89): PdoDbApi->queryInsert(Object(InsertQueryDbCore))\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\dao\\db\\standard_db_dao.php(265): PdoDbApi->query(Object(InsertQueryDbCore))\n#2 \\Scripting\\KrisSkarbo\\Budget2\\src\\handler\\entry_handler.php(69): StandardDbDao->add(Object(EntryModel), NULL)\n#3 \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\entry_rest_controller.php(106): EntryHandler->handleNew(Object(EntryModel))\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(373): EntryRestController->doAddModel(Object(EntryModel), \'1211\')\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(578): AbstractStandardRestController->doAddCommand()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#7 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#8 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#9 {main}', 'INSERT INTO budget_entry (entry_cost, entry_credit, entry_date, entry_single, entry_type, entry_card) VALUES (:comment, :debit, :date, :divide, :type, :card)\nArray\n(\n    [cost] => 97.9\n    [comment] => \n    [debit] => 0\n    [date] => 2012-11-07\n    [divide] => 0\n    [type] => mat\n    [card] => 6\n)\n', 'DbException', NULL, '2013-01-10 23:14:20'),
	(2, 0, 0, 'array_keys() expects parameter 1 to be array, integer given', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\core\\core.php', 62, 117, 'api_rest.php?/entry/edit/266&mode=1', NULL, '#0 [internal function]: AbstractApi->doErrorHandling(2, \'array_keys() ex...\', \'C:\\Users\\Kris L...\', 62, Array)\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\core\\core.php(62): array_keys(0)\n#2 \\Scripting\\KrisSkarbo\\Budget2\\src\\dao\\db\\entry_db_dao.php(273): Core::arrayAtIndex(0, 1212, 0)\n#3 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(405): EntryDbDao->getForeign(1212)\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(582): AbstractStandardRestController->doEditCommand()\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#7 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#8 {main}', NULL, 'ErrorException', '2013-01-14 14:28:11', '2013-01-10 23:15:47'),
	(4, 0, 0, 'Missing argument 3 for Validator::validateRegex(), called in C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget2\\src\\validator\\card_validator.php on line 35 and defined', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php', 116, 2, 'api_rest.php?/card/edit/7&mode=1', NULL, '#0 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php(116): AbstractApi->doErrorHandling(2, \'Missing argumen...\', \'C:\\Users\\Kris L...\', 116, Array)\n#1 \\Scripting\\KrisSkarbo\\Budget2\\src\\validator\\card_validator.php(35): Validator::validateRegex(\'Card title\', \'/[^\\w\\p{L}\\s,.-...\')\n#2 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php(199): CardValidator->doTitle()\n#3 \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\card_rest_controller.php(55): Validator->doValidate(Object(CardModel))\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(396): CardRestController->getModelPost()\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(582): AbstractStandardRestController->doEditCommand()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#7 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(CardRestController))\n#8 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#9 {main}', NULL, 'ErrorException', '2013-01-13 16:44:27', '2013-01-13 16:42:48'),
	(5, 0, 0, '', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php', 213, 1, 'api_rest.php?/card/edit/7&mode=1', '#1 ValidatorException->__construct \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\validator_exception.php:10\n#2 Validator->doValidate \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\validator\\validator.php:213\n#3 CardRestController->getModelPost \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\card_rest_controller.php:55\n#4 AbstractStandardRestController->doEditCommand \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:396\n#5 AbstractStandardRestController->request \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:582\n#6 AbstractApi->doControllerViewRender \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#7 AbstractApi->doRequest \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 \\Scripting\\KrisSkarbo\\Budget2\\src\\controller\\rest\\card_rest_controller.php(55): Validator->doValidate(Object(CardModel))\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(396): CardRestController->getModelPost()\n#2 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(582): AbstractStandardRestController->doEditCommand()\n#3 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): AbstractStandardRestController->request()\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(CardRestController))\n#5 \\Scripting\\KrisSkarbo\\Budget2\\api_rest.php(128): AbstractApi->doRequest(Array)\n#6 {main}', NULL, 'ValidatorException', NULL, '2013-01-13 16:42:48'),
	(6, 0, 0, 'Type \"0\" does not exist', '\\Scripting\\KrisSkarbo\\Budget\\src\\handler\\entry_handler.php', 89, 1, 'api_rest.php?/entry/add/2&mode=2', NULL, '#0 \\Scripting\\KrisSkarbo\\Budget\\src\\handler\\entry_handler.php(111): EntryHandler->handleEntry(2, Object(EntryModel), Array)\n#1 \\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryHandler->handleNew(2, Object(EntryModel), Array)\n#2 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 2)\n#3 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#4 \\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#7 \\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#8 {main}', NULL, 'Exception', NULL, '2013-01-23 20:19:42')
;
/*!40000 ALTER TABLE `budget_error` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_type
DROP TABLE IF EXISTS `budget_type`;
CREATE TABLE `budget_type` (
  `type_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `budget_id` smallint(6) NOT NULL,
  `type_title` varchar(255) NOT NULL,
  `type_updated` datetime DEFAULT NULL,
  `type_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`),
  KEY `budget_id` (`budget_id`),
  CONSTRAINT `FK_TYPE_BUDGET` FOREIGN KEY (`budget_id`) REFERENCES `budget_budget` (`budget_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_type: ~14 rows (approximately)
/*!40000 ALTER TABLE `budget_type` DISABLE KEYS */;
INSERT INTO `budget_type` (`type_id`, `budget_id`, `type_title`, `type_updated`, `type_registered`) VALUES 
	(1, 1, 'Husleie', NULL, '2013-01-10 17:21:53'),
	(2, 1, 'Internett', NULL, '2013-01-10 17:21:53'),
	(3, 1, 'Katt', NULL, '2013-01-13 21:17:01'),
	(4, 1, 'Konsert', NULL, '2013-01-13 17:21:03'),
	(5, 1, 'Kos', NULL, '2013-01-10 17:21:53'),
	(6, 1, 'Mat', NULL, '2013-01-10 17:21:53'),
	(7, 1, 'Misc', NULL, '2013-01-13 23:57:15'),
	(8, 2, 'New Type', NULL, '2013-01-22 13:53:28'),
	(9, 1, 'Skyldig', NULL, '2013-01-13 18:26:40'),
	(10, 1, 'Strøm', NULL, '2013-01-10 17:21:53'),
	(11, 1, 'Transport', NULL, '2013-01-13 18:18:23'),
	(12, 1, 'TV', NULL, '2013-01-10 17:21:53'),
	(13, 2, 'New Type 2', NULL, '2013-01-22 15:33:45'),
	(14, 2, 'New Type 3', NULL, '2013-01-22 15:34:29')
;
/*!40000 ALTER TABLE `budget_type` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_user
DROP TABLE IF EXISTS `budget_user`;
CREATE TABLE `budget_user` (
  `user_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_loggedin` datetime DEFAULT NULL,
  `user_updated` datetime DEFAULT NULL,
  `user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_user: ~1 rows (approximately)
/*!40000 ALTER TABLE `budget_user` DISABLE KEYS */;
INSERT INTO `budget_user` (`user_id`, `user_name`, `user_email`, `user_loggedin`, `user_updated`, `user_registered`) VALUES 
	(1, 'Demo', 'demo@email.com', '2013-01-23 21:19:56', NULL, '2013-01-19 09:45:54')
;
/*!40000 ALTER TABLE `budget_user` ENABLE KEYS */;


-- Dumping structure for table budget_dev.budget_user_auth
DROP TABLE IF EXISTS `budget_user_auth`;
CREATE TABLE `budget_user_auth` (
  `user_id` smallint(6) NOT NULL,
  `user_auth_id` varchar(100) NOT NULL,
  `user_auth_type` varchar(50) NOT NULL COMMENT 'facebook|google',
  `user_auth_loggedin` datetime DEFAULT NULL,
  `user_auth_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`user_auth_id`),
  CONSTRAINT `FK_USER_AUTH_USER` FOREIGN KEY (`user_id`) REFERENCES `budget_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping data for table budget_dev.budget_user_auth: ~1 rows (approximately)
/*!40000 ALTER TABLE `budget_user_auth` DISABLE KEYS */;
INSERT INTO `budget_user_auth` (`user_id`, `user_auth_id`, `user_auth_type`, `user_auth_loggedin`, `user_auth_registered`) VALUES 
	(1, 'demo', 'demo', '2013-01-23 19:30:24', '2013-01-19 09:45:54')
;
/*!40000 ALTER TABLE `budget_user_auth` ENABLE KEYS */;


/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
