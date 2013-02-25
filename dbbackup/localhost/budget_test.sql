-- Wed, 23 Jan 2013 20:19:56 GMT
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
-- Dumping database structure for budget_test
DROP DATABASE IF EXISTS `budget_test`;
CREATE DATABASE `budget_test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `budget_test`;


-- Dumping structure for table budget_test.budget_budget
DROP TABLE IF EXISTS `budget_budget`;
CREATE TABLE `budget_budget` (
  `budget_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `budget_title` varchar(100) DEFAULT NULL,
  `budget_updated` datetime DEFAULT NULL,
  `budget_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_id`)
) ENGINE=InnoDB AUTO_INCREMENT=790 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_test.budget_budget: ~1 rows (approximately)
/*!40000 ALTER TABLE `budget_budget` DISABLE KEYS */;
INSERT INTO `budget_budget` (`budget_id`, `budget_title`, `budget_updated`, `budget_registered`) VALUES 
	(789, 'Personal Budget', NULL, '2013-01-18 23:45:47')
;
/*!40000 ALTER TABLE `budget_budget` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_budget_user
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


-- Dumping data for table budget_test.budget_budget_user: ~2 rows (approximately)
/*!40000 ALTER TABLE `budget_budget_user` DISABLE KEYS */;
INSERT INTO `budget_budget_user` (`budget_id`, `user_id`, `budget_user_email`, `budget_user_registered`) VALUES 
	(789, 656, NULL, '2013-01-18 23:45:47'),
	(789, NULL, 'testing@email.com', '2013-01-19 10:43:07')
;
/*!40000 ALTER TABLE `budget_budget_user` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_card
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_test.budget_card: ~3 rows (approximately)
/*!40000 ALTER TABLE `budget_card` DISABLE KEYS */;
INSERT INTO `budget_card` (`card_id`, `budget_id`, `card_title`, `card_number`, `card_joint`, `card_updated`, `card_registered`) VALUES 
	(1, 789, 'New Card', 1234, 0, '2013-01-19 10:36:30', '2013-01-19 10:05:54'),
	(2, 789, 'New Card2', '', 0, NULL, '2013-01-19 10:28:16'),
	(3, 789, 'New Card 3', 4321, 0, NULL, '2013-01-19 10:48:15')
;
/*!40000 ALTER TABLE `budget_card` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_debug
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_test.budget_debug: ~4 rows (approximately)
/*!40000 ALTER TABLE `budget_debug` DISABLE KEYS */;
INSERT INTO `budget_debug` (`debug_id`, `debug_session`, `debug_level`, `debug_data`, `debug_file`, `debug_line`, `debug_backtrack`, `debug_trace`, `debug_type`, `debug_registered`) VALUES 
	(6, 6, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doAddModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:145\n#4 AbstractStandardRestController->doAddCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:374\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:631\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 789)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-19 10:28:44'),
	(7, 7, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doAddModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:145\n#4 AbstractStandardRestController->doAddCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:374\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:631\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 789)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-19 10:32:57'),
	(8, 8, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doAddModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:145\n#4 AbstractStandardRestController->doAddCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:374\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:631\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(145): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(374): EntryRestController->doAddModel(Object(EntryModel), 789)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(631): AbstractStandardRestController->doAddCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-19 11:10:52'),
	(9, 9, 1, 'Array\n(\n    [0] => New type card object\n    [1] => Array\n        (\n        )\n\n)\n', '\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php', 117, '#1 DebugException->__construct C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\exception\\debug_exception.php:18\n#2 EntryRestController::getNewTypeCardObject C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:117\n#3 EntryRestController->doEditModel C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:154\n#4 AbstractStandardRestController->doEditCommand C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:402\n#5 AbstractStandardRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php:635\n#6 EntryRestController->request C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php:208\n#7 AbstractApi->doControllerViewRender C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:572\n#8 AbstractApi->doRequest C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php:541', '#0 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(154): EntryRestController::getNewTypeCardObject()\n#1 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(402): EntryRestController->doEditModel(5, Object(EntryModel), 789)\n#2 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(635): AbstractStandardRestController->doEditCommand()\n#3 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#4 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#5 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#6 C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#7 {main}', 'string, array', '2013-01-19 11:11:21')
;
/*!40000 ALTER TABLE `budget_debug` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_entry
DROP TABLE IF EXISTS `budget_entry`;
CREATE TABLE `budget_entry` (
  `entry_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `budget_id` smallint(6) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_test.budget_entry: ~2 rows (approximately)
/*!40000 ALTER TABLE `budget_entry` DISABLE KEYS */;
INSERT INTO `budget_entry` (`entry_id`, `budget_id`, `entry_cost`, `entry_comment`, `entry_credit`, `entry_date`, `entry_single`, `entry_type`, `entry_card`, `entry_updated`, `entry_registered`) VALUES 
	(1, 789, 456, 'New comment4', 0, '2013-01-04', 0, 1, 1, '2013-01-19 10:27:35', '2013-01-19 10:05:54'),
	(5, 789, 78, '', 0, '2013-01-17', 0, 1, 3, '2013-01-19 11:11:21', '2013-01-19 11:10:52')
;
/*!40000 ALTER TABLE `budget_entry` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_error
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_test.budget_error: ~2 rows (approximately)
/*!40000 ALTER TABLE `budget_error` DISABLE KEYS */;
INSERT INTO `budget_error` (`error_id`, `error_kill`, `error_code`, `error_message`, `error_file`, `error_line`, `error_occured`, `error_url`, `error_backtrack`, `error_trace`, `error_query`, `error_exception`, `error_updated`, `error_registered`) VALUES 
	(1, 0, 0, 'array_keys() expects parameter 1 to be array, integer given', '\\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\core\\core.php', 62, 9, 'api_rest.php?/entry/edit/5&mode=3', NULL, '#0 [internal function]: AbstractApi->doErrorHandling(2, \'array_keys() ex...\', \'C:\\Users\\Kris L...\', 62, Array)\n#1 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\core\\core.php(62): array_keys(0)\n#2 \\Scripting\\KrisSkarbo\\Budget\\src\\dao\\db\\entry_db_dao.php(295): Core::arrayAtIndex(0, Array, 0)\n#3 \\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\cardentrytype_rest_controller.php(109): EntryDbDao->getForeign(Array)\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(409): CardentrytypeRestController->doGetForeign(Array)\n#5 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(635): AbstractStandardRestController->doEditCommand()\n#6 \\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#7 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#8 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#9 \\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#10 {main}', NULL, 'ErrorException', '2013-01-19 11:11:21', '2013-01-19 10:05:54'),
	(2, 0, 0, 'Missing argument 2 for EntryDbDao::getMonth(), called in C:\\Users\\Kris Laptop Win\\Dropbox\\Scripting\\KrisSkarbo\\Budget\\src\\dao\\db\\entry_db_dao.php on line 295 and defined', '\\Scripting\\KrisSkarbo\\Budget\\src\\dao\\db\\entry_db_dao.php', 272, 9, 'api_rest.php?/entry/edit/5&mode=3', NULL, '#0 \\Scripting\\KrisSkarbo\\Budget\\src\\dao\\db\\entry_db_dao.php(272): AbstractApi->doErrorHandling(2, \'Missing argumen...\', \'C:\\Users\\Kris L...\', 272, Array)\n#1 \\Scripting\\KrisSkarbo\\Budget\\src\\dao\\db\\entry_db_dao.php(295): EntryDbDao->getMonth(0)\n#2 \\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\cardentrytype_rest_controller.php(109): EntryDbDao->getForeign(Array)\n#3 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(409): CardentrytypeRestController->doGetForeign(Array)\n#4 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\controller\\rest\\standard\\abstract_standard_rest_controller.php(635): AbstractStandardRestController->doEditCommand()\n#5 \\Scripting\\KrisSkarbo\\Budget\\src\\controller\\rest\\entry_rest_controller.php(208): AbstractStandardRestController->request()\n#6 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(572): EntryRestController->request()\n#7 \\Scripting\\KrisSkarbo\\KrisSkarboApi\\src\\api\\api\\abstract_api.php(541): AbstractApi->doControllerViewRender(Object(EntryRestController))\n#8 \\Scripting\\KrisSkarbo\\Budget\\api_rest.php(152): AbstractApi->doRequest(Array)\n#9 {main}', NULL, 'ErrorException', '2013-01-19 11:11:21', '2013-01-19 10:05:54')
;
/*!40000 ALTER TABLE `budget_error` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_type
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_test.budget_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `budget_type` DISABLE KEYS */;
INSERT INTO `budget_type` (`type_id`, `budget_id`, `type_title`, `type_updated`, `type_registered`) VALUES 
	(1, 789, 'New Type3', '2013-01-19 10:36:42', '2013-01-19 10:05:54'),
	(2, 789, 'New type4', NULL, '2013-01-19 10:48:07')
;
/*!40000 ALTER TABLE `budget_type` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_user
DROP TABLE IF EXISTS `budget_user`;
CREATE TABLE `budget_user` (
  `user_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_loggedin` datetime DEFAULT NULL,
  `user_updated` datetime DEFAULT NULL,
  `user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=657 DEFAULT CHARSET=utf8;


-- Dumping data for table budget_test.budget_user: ~1 rows (approximately)
/*!40000 ALTER TABLE `budget_user` DISABLE KEYS */;
INSERT INTO `budget_user` (`user_id`, `user_name`, `user_email`, `user_loggedin`, `user_updated`, `user_registered`) VALUES 
	(656, 'Demo', 'demo@email.com', '2013-01-19 11:11:26', NULL, '2013-01-18 23:45:47')
;
/*!40000 ALTER TABLE `budget_user` ENABLE KEYS */;


-- Dumping structure for table budget_test.budget_user_auth
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


-- Dumping data for table budget_test.budget_user_auth: ~1 rows (approximately)
/*!40000 ALTER TABLE `budget_user_auth` DISABLE KEYS */;
INSERT INTO `budget_user_auth` (`user_id`, `user_auth_id`, `user_auth_type`, `user_auth_loggedin`, `user_auth_registered`) VALUES 
	(656, 'demo', 'demo', '2013-01-19 11:11:26', '2013-01-18 23:45:47')
;
/*!40000 ALTER TABLE `budget_user_auth` ENABLE KEYS */;


/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
