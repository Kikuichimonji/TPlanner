-- --------------------------------------------------------
-- Hôte:                         localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour tplanner
CREATE DATABASE IF NOT EXISTS `tplanner` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tplanner`;

-- Listage de la structure de la table tplanner. board
CREATE TABLE IF NOT EXISTS `board` (
  `id_board` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `id_environnement` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_board`),
  KEY `id_environnement` (`id_environnement`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `board_ibfk_1` FOREIGN KEY (`id_environnement`) REFERENCES `environnement` (`id_environnement`),
  CONSTRAINT `board_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. card
CREATE TABLE IF NOT EXISTS `card` (
  `id_card` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text,
  `positions` smallint(6) NOT NULL,
  `color` varchar(25) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `isArchived` tinyint(1) NOT NULL,
  `id_list` int(11) NOT NULL,
  PRIMARY KEY (`id_card`),
  KEY `id_list` (`id_list`),
  CONSTRAINT `card_ibfk_1` FOREIGN KEY (`id_list`) REFERENCES `list` (`id_list`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `dateCreation` datetime NOT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `card` (`id_card`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. environnement
CREATE TABLE IF NOT EXISTS `environnement` (
  `id_environnement` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id_environnement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. list
CREATE TABLE IF NOT EXISTS `list` (
  `id_list` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `listPosition` tinyint(4) NOT NULL,
  `isArchived` tinyint(1) NOT NULL,
  `id_board` int(11) NOT NULL,
  PRIMARY KEY (`id_list`),
  KEY `id_board` (`id_board`),
  CONSTRAINT `list_ibfk_1` FOREIGN KEY (`id_board`) REFERENCES `board` (`id_board`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `card` (`id_card`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `role` text,
  `dateCreation` date NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. usersboard
CREATE TABLE IF NOT EXISTS `usersboard` (
  `id_user` int(11) NOT NULL,
  `id_board` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_board`),
  KEY `id_board` (`id_board`),
  CONSTRAINT `usersboard_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `usersboard_ibfk_2` FOREIGN KEY (`id_board`) REFERENCES `board` (`id_board`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table tplanner. userscard
CREATE TABLE IF NOT EXISTS `userscard` (
  `id_user` int(11) NOT NULL,
  `id_card` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_card`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `userscard_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `userscard_ibfk_2` FOREIGN KEY (`id_card`) REFERENCES `card` (`id_card`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
