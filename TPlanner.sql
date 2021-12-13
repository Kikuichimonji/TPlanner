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
CREATE DATABASE IF NOT EXISTS `tplanner` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tplanner`;

-- Dumping structure for table tplanner.board
CREATE TABLE IF NOT EXISTS `board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `id_environnement` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_environnement` (`id_environnement`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `board_ibfk_1` FOREIGN KEY (`id_environnement`) REFERENCES `environnement` (`id_environnement`),
  CONSTRAINT `board_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.board: ~2 rows (approximately)
/*!40000 ALTER TABLE `board` DISABLE KEYS */;
INSERT INTO `board` (`id`, `label`, `id_environnement`, `id_user`) VALUES
	(1, 'Board 1', NULL, 1),
	(2, 'Board 2', NULL, 1);
/*!40000 ALTER TABLE `board` ENABLE KEYS */;

-- Dumping structure for table tplanner.card
CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text,
  `positions` smallint(6) NOT NULL,
  `color` varchar(25) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `isArchived` tinyint(1) NOT NULL,
  `id_list` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_list` (`id_list`),
  CONSTRAINT `card_ibfk_1` FOREIGN KEY (`id_list`) REFERENCES `lists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.card: ~4 rows (approximately)
/*!40000 ALTER TABLE `card` DISABLE KEYS */;
INSERT INTO `card` (`id`, `title`, `description`, `positions`, `color`, `picture`, `deadline`, `isArchived`, `id_list`) VALUES
	(1, 'Card1', NULL, 1, NULL, NULL, NULL, 0, 1),
	(2, 'Card2', NULL, 2, NULL, NULL, NULL, 0, 1),
	(3, 'Card3', NULL, 1, NULL, NULL, NULL, 0, 2),
	(4, 'Card4', NULL, 2, NULL, NULL, NULL, 0, 2);
/*!40000 ALTER TABLE `card` ENABLE KEYS */;

-- Dumping structure for table tplanner.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `dateCreation` datetime NOT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `card` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.comment: ~0 rows (approximately)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

-- Dumping structure for table tplanner.environnement
CREATE TABLE IF NOT EXISTS `environnement` (
  `id_environnement` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id_environnement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.environnement: ~0 rows (approximately)
/*!40000 ALTER TABLE `environnement` DISABLE KEYS */;
/*!40000 ALTER TABLE `environnement` ENABLE KEYS */;

-- Dumping structure for table tplanner.lists
CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `listPosition` tinyint(4) NOT NULL,
  `isArchived` tinyint(1) NOT NULL,
  `id_board` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_board` (`id_board`),
  CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`id_board`) REFERENCES `board` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.lists: ~2 rows (approximately)
/*!40000 ALTER TABLE `lists` DISABLE KEYS */;
INSERT INTO `lists` (`id`, `label`, `listPosition`, `isArchived`, `id_board`) VALUES
	(1, '1st List', 0, 0, 1),
	(2, '2nd List', 1, 0, 1);
/*!40000 ALTER TABLE `lists` ENABLE KEYS */;

-- Dumping structure for table tplanner.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `card` (`id`)
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `mail`, `role`, `dateCreation`) VALUES
	(1, 'pseudo', 'password', 'mail@mail.mail', NULL, '2021-12-13');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table tplanner.usersboard
CREATE TABLE IF NOT EXISTS `usersboard` (
  `id_user` int(11) NOT NULL,
  `id_board` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_board`),
  KEY `id_board` (`id_board`),
  CONSTRAINT `usersboard_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `usersboard_ibfk_2` FOREIGN KEY (`id_board`) REFERENCES `board` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.usersboard: ~2 rows (approximately)
/*!40000 ALTER TABLE `usersboard` DISABLE KEYS */;
INSERT INTO `usersboard` (`id_user`, `id_board`) VALUES
	(1, 1),
	(1, 2);
/*!40000 ALTER TABLE `usersboard` ENABLE KEYS */;

-- Dumping structure for table tplanner.userscard
CREATE TABLE IF NOT EXISTS `userscard` (
  `id_user` int(11) NOT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_card`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `userscard_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `userscard_ibfk_2` FOREIGN KEY (`id_card`) REFERENCES `card` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table tplanner.userscard: ~0 rows (approximately)
/*!40000 ALTER TABLE `userscard` DISABLE KEYS */;
/*!40000 ALTER TABLE `userscard` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
