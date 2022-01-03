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
  `id_environnement` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_environnement` (`id_environnement`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `boards_ibfk_1` FOREIGN KEY (`id_environnement`) REFERENCES `environnements` (`id_environnement`),
  CONSTRAINT `boards_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.boards: ~3 rows (approximately)
/*!40000 ALTER TABLE `boards` DISABLE KEYS */;
INSERT INTO `boards` (`id`, `label`, `id_environnement`, `id_user`) VALUES
	(1, 'My first board', NULL, 1),
	(2, 'Board deux', NULL, 1),
	(3, 'Board 3', NULL, 1);
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
  `id_list` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_list` (`id_list`),
  CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`id_list`) REFERENCES `lists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.cards: ~12 rows (approximately)
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` (`id`, `title`, `description`, `positions`, `color`, `picture`, `deadline`, `isArchived`, `id_list`) VALUES
	(48, 'Card 2', NULL, 0, NULL, NULL, NULL, 0, 3),
	(49, 'CArd 3', NULL, 0, NULL, NULL, NULL, 0, 1),
	(50, 'Card 4', NULL, 2, NULL, NULL, NULL, 0, 2),
	(74, 'Card 5', NULL, 0, NULL, NULL, NULL, 0, 2),
	(75, 'Card 6', NULL, 1, NULL, NULL, NULL, 0, 1),
	(76, 'Card', NULL, 1, NULL, NULL, NULL, 0, 3),
	(77, 'pouet', 'Description', 0, NULL, NULL, NULL, 0, 11),
	(78, 'a card', NULL, 1, NULL, NULL, NULL, 0, 2),
	(84, 'Card 1', '>1\n>2\n>3', 3, NULL, NULL, NULL, 0, 3),
	(93, 'zerzer', 'aazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraa', 0, NULL, NULL, NULL, 0, 16),
	(96, 'alert();', NULL, 2, NULL, NULL, NULL, 0, 3),
	(97, 'adaqzer', 'Cette description', 1, NULL, NULL, NULL, 0, 16);
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;

-- Dumping structure for table tplanner.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `dateCreation` datetime NOT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.comments: ~0 rows (approximately)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Dumping structure for table tplanner.environnements
CREATE TABLE IF NOT EXISTS `environnements` (
  `id_environnement` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id_environnement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.environnements: ~0 rows (approximately)
/*!40000 ALTER TABLE `environnements` DISABLE KEYS */;
/*!40000 ALTER TABLE `environnements` ENABLE KEYS */;

-- Dumping structure for table tplanner.lastchange
CREATE TABLE IF NOT EXISTS `lastchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastChange` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.lastchange: ~0 rows (approximately)
/*!40000 ALTER TABLE `lastchange` DISABLE KEYS */;
INSERT INTO `lastchange` (`id`, `lastChange`) VALUES
	(1, '2022-01-03 21:15:42');
/*!40000 ALTER TABLE `lastchange` ENABLE KEYS */;

-- Dumping structure for table tplanner.lists
CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `listPosition` tinyint(4) NOT NULL,
  `isArchived` tinyint(1) NOT NULL DEFAULT '0',
  `id_board` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_board` (`id_board`),
  CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`id_board`) REFERENCES `boards` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.lists: ~5 rows (approximately)
/*!40000 ALTER TABLE `lists` DISABLE KEYS */;
INSERT INTO `lists` (`id`, `label`, `listPosition`, `isArchived`, `id_board`) VALUES
	(1, '1st List', 0, 0, 1),
	(2, '2nd List', 1, 0, 1),
	(3, '3rd liste', 2, 0, 1),
	(11, 'sdfsdf', 2, 0, 2),
	(16, 'azeazeazezzzzzsdfsdfsdfsdsdfsdfsdfsdfsdfsdfsdfrrrr', 3, 0, 1);
/*!40000 ALTER TABLE `lists` ENABLE KEYS */;

-- Dumping structure for table tplanner.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.tag: ~0 rows (approximately)
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

-- Dumping structure for table tplanner.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `role` text,
  `dateCreation` date NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `mail`, `role`, `dateCreation`, `color`) VALUES
	(1, 'pseudo', '$argon2i$v=19$m=65536,t=4,p=1$SWhPRW5kM2llMlowbVgyYw$ULnIb46zLfocBQ/gms9v7hFUBkYDa1yFi2RSax6bMqg', 'mail@mail.mail', NULL, '2021-12-13', '#3688db'),
	(2, 'pseudo2', '$argon2i$v=19$m=65536,t=4,p=1$SWhPRW5kM2llMlowbVgyYw$ULnIb46zLfocBQ/gms9v7hFUBkYDa1yFi2RSax6bMqg', 'mail2@mail2.mail2', NULL, '2022-01-02', '#12a09c');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table tplanner.usersboard
CREATE TABLE IF NOT EXISTS `usersboard` (
  `id_user` int(11) NOT NULL,
  `id_board` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_board`),
  KEY `id_board` (`id_board`),
  CONSTRAINT `usersboard_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `usersboard_ibfk_2` FOREIGN KEY (`id_board`) REFERENCES `boards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.usersboard: ~3 rows (approximately)
/*!40000 ALTER TABLE `usersboard` DISABLE KEYS */;
INSERT INTO `usersboard` (`id_user`, `id_board`) VALUES
	(1, 1),
	(1, 2),
	(1, 3);
/*!40000 ALTER TABLE `usersboard` ENABLE KEYS */;

-- Dumping structure for table tplanner.userscards
CREATE TABLE IF NOT EXISTS `userscards` (
  `id_user` int(11) NOT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_card`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `userscards_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `userscards_ibfk_2` FOREIGN KEY (`id_card`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.userscards: ~0 rows (approximately)
/*!40000 ALTER TABLE `userscards` DISABLE KEYS */;
/*!40000 ALTER TABLE `userscards` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
