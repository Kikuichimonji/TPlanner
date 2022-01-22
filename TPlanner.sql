-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for tplanner
CREATE DATABASE IF NOT EXISTS `tplanner` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tplanner`;

-- Dumping structure for table tplanner.boards
CREATE TABLE IF NOT EXISTS `boards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `lastChange` datetime DEFAULT NULL,
  `environnement_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_environnement` (`environnement_id`),
  KEY `id_user` (`user_id`),
  CONSTRAINT `boards_ibfk_1` FOREIGN KEY (`environnement_id`) REFERENCES `environnements` (`id`),
  CONSTRAINT `boards_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.boards: ~9 rows (approximately)
/*!40000 ALTER TABLE `boards` DISABLE KEYS */;
INSERT INTO `boards` (`id`, `label`, `lastChange`, `environnement_id`, `user_id`) VALUES
	(1, 'My first board', '2022-01-19 13:20:54', NULL, 1),
	(2, 'Board deux', '2022-01-05 21:49:15', NULL, 1),
	(3, 'Board 3', '2022-01-18 08:18:28', NULL, 1),
	(4, 'tablo', '2022-01-05 15:09:54', NULL, 1),
	(5, 'rtrtyryt', NULL, NULL, 1),
	(6, 'aaaaaaaa', NULL, NULL, 1),
	(7, 'User 2 board', '2022-01-19 13:21:57', NULL, 2),
	(8, 'Board user 3', NULL, NULL, NULL),
	(9, 'aaaaaaaaaaaaaaaaaaaaaa', '2022-01-11 09:17:41', NULL, NULL),
	(10, 'New board', NULL, NULL, 1),
	(11, 'anna', '2022-01-18 18:39:31', NULL, 5);
/*!40000 ALTER TABLE `boards` ENABLE KEYS */;

-- Dumping structure for table tplanner.cards
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text,
  `positions` smallint(6) NOT NULL,
  `color` varchar(25) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `isArchived` tinyint(1) NOT NULL DEFAULT '0',
  `list_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_list` (`list_id`),
  CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.cards: ~23 rows (approximately)
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` (`id`, `title`, `description`, `positions`, `color`, `picture`, `deadline`, `isArchived`, `list_id`) VALUES
	(49, 'CArd 3', '0000000000000000000000000111111111111111111111111111222222222222222222222222222222223333333333333333333333333333333344444444444444444444444444444444455555555555555555555555555555555556666666666666666666666666666666', 1, NULL, NULL, NULL, 0, 1),
	(50, 'Card 4', NULL, 0, NULL, NULL, NULL, 0, 1),
	(74, 'Card 5', NULL, 2, NULL, NULL, NULL, 0, 1),
	(75, 'Card 6', '', 1, NULL, NULL, NULL, 0, 16),
	(78, 'a card', NULL, 2, NULL, NULL, NULL, 0, 16),
	(84, 'Card 1', '>1\r\n>2\r\n>3', 0, NULL, NULL, NULL, 0, 16),
	(93, 'zerzer', 'aazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraa', 0, NULL, NULL, NULL, 1, 24),
	(96, 'alert();', 'hello <p> aa</p>\r\ntest', 1, NULL, NULL, NULL, 0, 3),
	(97, 'adaqzer', 'Cette description', 0, NULL, NULL, NULL, 0, 2),
	(98, 'a card', 'eterter', 0, NULL, NULL, NULL, 0, 11),
	(106, 'And now a card', NULL, 0, NULL, NULL, NULL, 0, 21),
	(109, 'fdssdfsdf', NULL, 5, NULL, NULL, NULL, 1, 24),
	(110, 'eertert', NULL, 1, NULL, NULL, NULL, 1, 24),
	(111, 'qsdqsd', 'qsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsd', 2, NULL, NULL, NULL, 1, 24),
	(112, 'last card', NULL, 0, NULL, NULL, NULL, 0, 35),
	(113, 'last card', NULL, 1, NULL, NULL, NULL, 0, 35),
	(114, 'last card', NULL, 2, NULL, NULL, NULL, 0, 35),
	(115, 'aaaaaaa', NULL, 0, NULL, NULL, NULL, 0, 40),
	(116, 'A cArd', NULL, 0, NULL, NULL, NULL, 0, 41),
	(117, 'A new card', NULL, 0, NULL, NULL, NULL, 0, 3),
	(118, 'aaaaaa', NULL, 3, NULL, NULL, NULL, 1, 24),
	(119, 'A card', '11161651651651', 0, NULL, NULL, NULL, 0, 46),
	(121, 'A card', NULL, 0, NULL, NULL, NULL, 1, 37);
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;

-- Dumping structure for table tplanner.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `dateCreation` datetime NOT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_card` (`card_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.comments: ~0 rows (approximately)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Dumping structure for table tplanner.environnements
CREATE TABLE IF NOT EXISTS `environnements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.environnements: ~0 rows (approximately)
/*!40000 ALTER TABLE `environnements` DISABLE KEYS */;
/*!40000 ALTER TABLE `environnements` ENABLE KEYS */;

-- Dumping structure for table tplanner.lists
CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `listPosition` tinyint(4) NOT NULL,
  `isArchived` tinyint(1) NOT NULL DEFAULT '0',
  `isArchiveList` tinyint(4) NOT NULL DEFAULT '0',
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_board` (`board_id`),
  CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.lists: ~24 rows (approximately)
/*!40000 ALTER TABLE `lists` DISABLE KEYS */;
INSERT INTO `lists` (`id`, `label`, `listPosition`, `isArchived`, `isArchiveList`, `board_id`) VALUES
	(1, '1st List', 0, 0, 0, 1),
	(2, '2nd List', 1, 0, 0, 1),
	(3, '3rd liste', 3, 0, 0, 1),
	(11, 'sdfsdf', 1, 0, 0, 2),
	(16, 'Azerty', 2, 0, 0, 1),
	(21, 'My new list', 1, 0, 0, 4),
	(23, 'Archive', 0, 0, 1, 4),
	(24, 'Archive', -1, 0, 1, 1),
	(26, 'ertert', 4, 1, 0, 1),
	(27, 'zsfsfsdfsdfsdfsfs', 0, 0, 0, 2),
	(31, 'zerzer', 4, 1, 0, 1),
	(32, 'ryrty', 4, 1, 0, 1),
	(33, 'sdfsdf', 4, 1, 0, 1),
	(34, 'qqsdqsd', 4, 1, 0, 1),
	(35, 'ert', 4, 1, 0, 1),
	(36, 'Archive', -1, 0, 1, 6),
	(37, 'Archive', -1, 0, 1, 7),
	(38, 'Archive', -1, 0, 1, 8),
	(39, 'Archive', -1, 0, 1, 9),
	(40, 'aaaaa', 0, 0, 0, 9),
	(41, 'titile', 0, 0, 0, 3),
	(42, 'Archive', -1, 0, 1, 10),
	(43, 'fzfzfze', 4, 1, 0, 1),
	(44, 'aaaa', 4, 1, 0, 1),
	(45, 'Archive', -1, 0, 1, 11),
	(46, 'Liste 1', 0, 0, 0, 11),
	(48, 'A list', 0, 1, 0, 7);
/*!40000 ALTER TABLE `lists` ENABLE KEYS */;

-- Dumping structure for table tplanner.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `id_card` (`card_id`),
  CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.tags: ~0 rows (approximately)
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Dumping structure for table tplanner.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `role` text,
  `dateCreation` date NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#50d3b5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `mail`, `role`, `dateCreation`, `color`) VALUES
	(1, 'Thomas', '$argon2i$v=19$m=65536,t=4,p=1$SWhPRW5kM2llMlowbVgyYw$ULnIb46zLfocBQ/gms9v7hFUBkYDa1yFi2RSax6bMqg', 'mail@mail.mail', '["user","admin"]', '2021-12-13', '#25d4c9'),
	(2, 'pseudo2', '$argon2i$v=19$m=65536,t=4,p=1$SWhPRW5kM2llMlowbVgyYw$ULnIb46zLfocBQ/gms9v7hFUBkYDa1yFi2RSax6bMqg', 'mail2@mail2.mail2', '["user"]', '2022-01-02', '#12a09c'),
	(4, 'pseudo3', '$argon2i$v=19$m=65536,t=4,p=1$d2R6OG9McVROWWNLajFUZg$hwwuXlCuZApn4PW9ZciwcQIX1JE/W/jV9PQ56opeDv8', 'mail3@mail3.mail3', '[]', '2022-01-11', '#50d3b5'),
	(5, 'anna68', '$argon2i$v=19$m=65536,t=4,p=1$cFNqeDZWOUV4ekJBdDk0OQ$5KCNINYg2yIDNzSXy8h2Py88igfTW94TLU2ut9S0LuM', 'annabel.begaud1@free.fr', '["user"]', '2022-01-18', '#d350a9');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table tplanner.users_boards
CREATE TABLE IF NOT EXISTS `users_boards` (
  `user_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`board_id`),
  KEY `id_board` (`board_id`),
  CONSTRAINT `users_boards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_boards_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.users_boards: ~9 rows (approximately)
/*!40000 ALTER TABLE `users_boards` DISABLE KEYS */;
INSERT INTO `users_boards` (`user_id`, `board_id`) VALUES
	(1, 1),
	(2, 1),
	(4, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5),
	(1, 6),
	(1, 7),
	(2, 7),
	(1, 10),
	(5, 11);
/*!40000 ALTER TABLE `users_boards` ENABLE KEYS */;

-- Dumping structure for table tplanner.users_cards
CREATE TABLE IF NOT EXISTS `users_cards` (
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`card_id`),
  KEY `id_card` (`card_id`),
  CONSTRAINT `users_cards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_cards_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.users_cards: ~0 rows (approximately)
/*!40000 ALTER TABLE `users_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_cards` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
