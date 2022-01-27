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

-- Listage de la structure de la table tplanner. boards
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.boards : ~16 rows (environ)
/*!40000 ALTER TABLE `boards` DISABLE KEYS */;
INSERT INTO `boards` (`id`, `label`, `lastChange`, `environnement_id`, `user_id`) VALUES
	(1, 'My first board', '2022-01-23 16:14:44', NULL, 1),
	(2, 'Board deux', '2022-01-05 21:49:15', NULL, 1),
	(3, 'Board 3', '2022-01-18 08:18:28', NULL, 1),
	(4, 'tablo', '2022-01-05 15:09:54', NULL, 1),
	(5, 'rtrtyryt', NULL, NULL, 1),
	(6, 'aaaaaaaa', NULL, NULL, 1),
	(7, 'User 2 board', '2022-01-25 16:36:47', NULL, 2),
	(8, 'Board user 3', NULL, NULL, NULL),
	(9, 'aaaaaaaaaaaaaaaaaaaaaa', '2022-01-11 09:17:41', NULL, NULL),
	(10, 'New board', NULL, NULL, 1),
	(11, 'anna', '2022-01-18 18:39:31', NULL, 5),
	(12, 'TPlanner', '2022-01-23 15:10:46', NULL, 6),
	(13, 'TPlanner', '2022-01-26 13:33:37', NULL, 1),
	(14, 'Test', '2022-01-25 18:19:35', NULL, 7),
	(15, 'des trucs', '2022-01-23 18:23:26', NULL, 8),
	(16, 'New board', '2022-01-25 16:35:49', NULL, 1),
	(17, 'a board', '2022-01-26 08:35:36', NULL, 4);
/*!40000 ALTER TABLE `boards` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. cards
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text,
  `positions` smallint(6) NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#FFFFFF',
  `deadline` datetime DEFAULT NULL,
  `isArchived` tinyint(1) NOT NULL DEFAULT '0',
  `list_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_list` (`list_id`),
  CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.cards : ~50 rows (environ)
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` (`id`, `title`, `description`, `positions`, `color`, `deadline`, `isArchived`, `list_id`) VALUES
	(49, 'CArd 3', '0000000000000000000000000111111111111111111111111111222222222222222222222222222222223333333333333333333333333333333344444444444444444444444444444444455555555555555555555555555555555556666666666666666666666666666666', 2, '#ffffff', NULL, 0, 1),
	(50, 'Card 4', NULL, 0, '#ffffff', NULL, 0, 1),
	(74, 'Card 5', NULL, 1, '#ffffff', NULL, 0, 1),
	(75, 'Card 6', 'coucou :3', 1, '#ffffff', NULL, 0, 16),
	(78, 'a card', NULL, 2, '#ffffff', NULL, 0, 16),
	(84, 'Card 1', '>1\r\n>2\r\n>3', -1, '#ffffff', NULL, 0, 16),
	(93, 'zerzer', 'aazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraazeeraaazeeraazeeraazeeraazeeraazeeraazeeraazeeraa', 0, '#ffffff', NULL, 1, 24),
	(96, 'alert();', 'hello <p> aa</p>\r\ntest', 0, '#ffffff', NULL, 0, 49),
	(97, 'adaqzer', 'Cette description', 0, '#ffffff', NULL, 0, 2),
	(98, 'a card', 'eterter', 0, '#ffffff', NULL, 0, 11),
	(106, 'And now a card', NULL, 0, '#ffffff', NULL, 0, 21),
	(109, 'fdssdfsdf', NULL, 5, '#ffffff', NULL, 1, 24),
	(110, 'eertert', NULL, 1, '#ffffff', NULL, 1, 24),
	(111, 'qsdqsd', 'qsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsdqsd', 2, '#ffffff', NULL, 1, 24),
	(112, 'last card', NULL, 0, '#ffffff', NULL, 0, 35),
	(113, 'last card', NULL, 1, '#ffffff', NULL, 0, 35),
	(114, 'last card', NULL, 2, '#ffffff', NULL, 0, 35),
	(115, 'aaaaaaa', NULL, 0, '#ffffff', NULL, 0, 40),
	(116, 'A cArd', NULL, 0, '#ffffff', NULL, 0, 41),
	(117, 'A new card', NULL, 0, '#ffffff', NULL, 0, 3),
	(118, 'aaaaaa', NULL, 3, '#ffffff', NULL, 1, 24),
	(119, 'A card', '11161651651651', 0, '#ffffff', NULL, 0, 46),
	(121, 'A card', NULL, 1, '#ffffff', NULL, 1, 37),
	(122, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', NULL, 3, '#ffffff', NULL, 0, 1),
	(123, 'test card', NULL, 1, '#ffffff', NULL, 0, 49),
	(126, 'ScÃ©nario 2', 'Je suis un utilisateur connectÃ© et je souhaite crÃ©er un tableau', 3, '#1eb300', NULL, 0, 52),
	(127, 'ScÃ©nario 1', 'Je suis un utilisateur connectÃ© et je souhaite ajouter des cartes Ã  ma liste pour gÃ©rer mes tÃ¢ches', 0, '#00c203', NULL, 0, 52),
	(128, 'FonctionnalitÃ© trÃ¨s trÃ¨s importante', 'fonctionalitÃ© afficher le menu du tableau', 0, '#ff0000', NULL, 0, 53),
	(129, 'Bug Thomas', 'Drag&Drop over card description is bugged when it', -1, '#fff70f', NULL, 0, 54),
	(130, 'Modif carte', 'fonctionnalitÃ©s modifier carte', 0, '#ff9500', NULL, 0, 55),
	(131, 'Thomas', 'fetch api + drag and drop', 0, '#ff0000', NULL, 0, 56),
	(132, 'URGENT', '', 0, '#664af2', NULL, 0, 58),
	(133, 'COEUR', '', 1, '#fa0000', NULL, 0, 58),
	(134, 'MAJEUR', '', 2, '#ffae00', NULL, 0, 58),
	(135, 'MINEURE', '', 3, '#fbff14', NULL, 0, 58),
	(136, 'Bug Thomas', 'ProblÃ¨me ordre listes', 1, '#fb980e', NULL, 0, 55),
	(137, 'truc1', NULL, 0, '#ffffff', NULL, 0, 60),
	(138, 'truc2', NULL, 1, '#ffffff', NULL, 0, 60),
	(139, 'chose1', '', 0, '#a52c2c', NULL, 0, 61),
	(140, 'chose2', NULL, 1, '#ffffff', NULL, 0, 61),
	(141, 'chose3', NULL, 2, '#ffffff', NULL, 0, 61),
	(142, 'PrÃ©sentation', 'PrÃ©paration de la prÃ©sentation orale', 1, '#f50000', NULL, 0, 56),
	(143, 'Bug Thomas', 'ProblÃ¨me drag and drop', 1, '#fff829', NULL, 1, 51),
	(144, 'Old card', 'A description', 0, '#16e9a3', NULL, 0, 62),
	(150, 'ScÃ©nario 3', 'Je suis un utilisateur et je souhaite m', 4, '#1eb300', NULL, 0, 52),
	(151, 'My card', 'A description A descriptionA descriptionA descriptionA descriptionA descriptionA descriptionA descriptionA description', 0, '#e34a4a', NULL, 0, 64),
	(152, 'Another card', 'Another description', 0, '#f07a7a', NULL, 0, 65),
	(153, 'A card', NULL, -1, '#ffffff', NULL, 1, 37),
	(154, 're', NULL, 0, '#ffffff', NULL, 0, 67),
	(158, 'a card', NULL, 1, '#ffffff', NULL, 0, 53);
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `dateCreation` datetime NOT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_card` (`card_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.comments : ~0 rows (environ)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. environnements
CREATE TABLE IF NOT EXISTS `environnements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.environnements : ~0 rows (environ)
/*!40000 ALTER TABLE `environnements` DISABLE KEYS */;
/*!40000 ALTER TABLE `environnements` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. lists
CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `listPosition` tinyint(4) NOT NULL,
  `isArchived` tinyint(1) NOT NULL DEFAULT '0',
  `isArchiveList` tinyint(1) NOT NULL DEFAULT '0',
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_board` (`board_id`),
  CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.lists : ~44 rows (environ)
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
	(45, 'Archive', -1, 0, 1, 11),
	(46, 'Liste 1', 0, 0, 0, 11),
	(48, 'A list', 0, 1, 0, 7),
	(49, 'a list', 5, 0, 0, 1),
	(50, 'Archive', -1, 0, 1, 12),
	(51, 'Archive', -1, 0, 1, 13),
	(52, 'Backlog', 0, 0, 0, 13),
	(53, 'A faire', 2, 0, 0, 13),
	(54, 'En cours', 3, 0, 0, 13),
	(55, 'Bug / BloquÃ©', 4, 0, 0, 13),
	(56, 'TerminÃ©', 5, 0, 0, 13),
	(57, 'Archive', -1, 0, 1, 14),
	(58, 'Code couleur', 1, 0, 0, 13),
	(59, 'Archive', -1, 0, 1, 15),
	(60, 'truquerino', 0, 0, 0, 15),
	(61, 'choserino', 0, 0, 0, 15),
	(62, 'Old list', -2, 1, 0, 13),
	(63, 'Archive', -1, 0, 1, 16),
	(64, 'My list', 0, 0, 0, 16),
	(65, 'A second list', 0, 0, 0, 16),
	(66, 'A list', 0, 0, 0, 7),
	(67, 'test', 0, 0, 0, 14),
	(68, 'Archive', -1, 0, 1, 17),
	(69, 'A reallly reallly long list name', -2, 1, 0, 13),
	(70, 'a really really really long name', -2, 1, 0, 13),
	(71, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', -2, 1, 0, 13);
/*!40000 ALTER TABLE `lists` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `id_card` (`card_id`),
  CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.tags : ~0 rows (environ)
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `role` text,
  `dateCreation` date NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#50d3b5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.users : ~8 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `mail`, `role`, `dateCreation`, `color`) VALUES
	(1, 'The real Thomas', '$argon2i$v=19$m=65536,t=4,p=1$SExiZVdRbENkQjJSN3c2WQ$L9QZVIg+mdzDkcERVcMytSepI6EEN6JM4LSOFIV8KPM', 'thomas_roess@hotmail.fr', '["user","admin"]', '2021-12-13', '#ffbb00'),
	(2, 'Another long username', '$argon2i$v=19$m=65536,t=4,p=1$SExiZVdRbENkQjJSN3c2WQ$L9QZVIg+mdzDkcERVcMytSepI6EEN6JM4LSOFIV8KPM', 'mail@mail.mail', '["user"]', '2022-01-02', '#3999f9'),
	(4, 'pseudo3', '$argon2i$v=19$m=65536,t=4,p=1$SExiZVdRbENkQjJSN3c2WQ$L9QZVIg+mdzDkcERVcMytSepI6EEN6JM4LSOFIV8KPM', 'mail3@mail3.mail3', '["user"]', '2022-01-11', '#ecf024'),
	(5, 'anna68', '$argon2i$v=19$m=65536,t=4,p=1$SExiZVdRbENkQjJSN3c2WQ$L9QZVIg+mdzDkcERVcMytSepI6EEN6JM4LSOFIV8KPM', 'annabel.begaud1@free.fr', '["user"]', '2022-01-18', '#d350a9'),
	(6, 'test', '$argon2i$v=19$m=65536,t=4,p=1$SExiZVdRbENkQjJSN3c2WQ$L9QZVIg+mdzDkcERVcMytSepI6EEN6JM4LSOFIV8KPM', 'test@test.test', '["user"]', '2022-01-23', '#39f346'),
	(7, 'Epiphanie', '$argon2i$v=19$m=65536,t=4,p=1$R0gxQzdaTDRWdlhxUDZHTw$L5cQjLDK+5zaF7B4Qahzsz9UJpXtkYMa+PpOCSlMLJQ', 'alss-dipsw21-nep@ccicampus.fr', '["user"]', '2022-01-23', '#50d3b5'),
	(8, 'chathamo del ploud', '$argon2i$v=19$m=65536,t=4,p=1$YXVPaEk0VEQ2TENmWko2cg$46Cf4sVs7azfFlR08zbnvbuwY8zho+HzyZoOMWiah6E', 'chathamo.del.ploud@gmailo.como', '["user"]', '2022-01-23', '#5553e4'),
	(9, 'pseudo', '$argon2i$v=19$m=65536,t=4,p=1$Ym16anYwWEs3TS54bzhvTg$LW9INgqOhaRE/Tgn5ksgqhEWRMbb//77Bc7KqlgCmi8', 'test-tq8venafn@srv1.mail-tester.com', '["user"]', '2022-01-24', '#fd3e1c');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. users_boards
CREATE TABLE IF NOT EXISTS `users_boards` (
  `user_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`board_id`),
  KEY `id_board` (`board_id`),
  CONSTRAINT `users_boards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_boards_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.users_boards : ~23 rows (environ)
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
	(5, 11),
	(6, 12),
	(1, 13),
	(2, 13),
	(4, 13),
	(5, 13),
	(6, 13),
	(7, 13),
	(8, 13),
	(7, 14),
	(8, 15),
	(1, 16),
	(4, 17);
/*!40000 ALTER TABLE `users_boards` ENABLE KEYS */;

-- Listage de la structure de la table tplanner. users_cards
CREATE TABLE IF NOT EXISTS `users_cards` (
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`card_id`),
  KEY `id_card` (`card_id`),
  CONSTRAINT `users_cards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `users_cards_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table tplanner.users_cards : ~0 rows (environ)
/*!40000 ALTER TABLE `users_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_cards` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
