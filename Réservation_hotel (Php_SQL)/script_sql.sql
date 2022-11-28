-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 20 juil. 2022 à 10:28
-- Version du serveur : 10.6.5-MariaDB
-- Version de PHP : 7.4.26

DROP DATABASE IF EXISTS php_expert_devoir2;
CREATE DATABASE IF NOT EXISTS php_expert_devoir2;
USE php_expert_devoir2;

--
-- Base de données : `php_expert_devoir2`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(30) NOT NULL AUTO_INCREMENT,
  `admin_nom` varchar(255) NOT NULL,
  `admin_mail` varchar(255) NOT NULL,
  `role_id` int(30) NOT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_nom`, `admin_mail`, `role_id`) VALUES
(1, 'admin_nom1', '$1$CEsn1K96$wkrPYd8eMFMfBYuKmu0Gk.', 1),
(2, 'admin_nom2', '$1$8R.8G.UG$A.Z6kF7W.vfpmkvnhcJxp1', 2),
(3, 'admin_nom3', '$1$xgEQ/POX$kMK.ldM/oR293fDTcstHU0', 3),
(4, 'admin_nom4', '$1$F3gNPwXF$RcWlMAI7O453h7LzkM4Gf/', 1),
(5, 'admin_nom5', '$1$21Adp7Yq$BdFvN5KNqZprRHpYRavcp1', 2);

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int(30) NOT NULL AUTO_INCREMENT,
  `client_id` int(30) NOT NULL,
  `chambre_id` int(30) NOT NULL,
  `deb_resa` date NOT NULL,
  `fin_resa` date NOT NULL,
  `creation` date NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `client_id` (`client_id`),
  KEY `chambre_id` (`chambre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `booking`
--

INSERT INTO `booking` (`booking_id`, `client_id`, `chambre_id`, `deb_resa`, `fin_resa`, `creation`) VALUES
(1, 1, 2, '2022-07-25', '2022-07-31', '2022-07-20');

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE IF NOT EXISTS `chambre` (
  `chambre_id` int(30) NOT NULL AUTO_INCREMENT,
  `num_chambre` int(30) NOT NULL,
  `pers_max` int(30) NOT NULL,
  `hotel_id` int(30) NOT NULL,
  PRIMARY KEY (`chambre_id`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`chambre_id`, `num_chambre`, `pers_max`, `hotel_id`) VALUES
(1, 1, 2, 1),
(2, 2, 4, 1),
(3, 3, 4, 1),
(4, 4, 2, 1),
(5, 5, 3, 1),
(6, 6, 2, 1),
(7, 7, 3, 1),
(8, 8, 3, 1),
(9, 9, 3, 1),
(10, 10, 2, 1),
(11, 1, 2, 2),
(12, 2, 4, 2),
(13, 3, 3, 2),
(14, 4, 3, 2),
(15, 5, 4, 2),
(16, 6, 4, 2),
(17, 7, 2, 2),
(18, 8, 2, 2),
(19, 9, 3, 2),
(20, 10, 4, 2),
(21, 1, 2, 3),
(22, 2, 3, 3),
(23, 3, 4, 3),
(24, 4, 3, 3),
(25, 5, 2, 3),
(26, 6, 4, 3),
(27, 7, 3, 3),
(28, 8, 3, 3),
(29, 9, 3, 3),
(30, 10, 4, 3),
(31, 1, 3, 4),
(32, 2, 2, 4),
(33, 3, 2, 4),
(34, 4, 2, 4),
(35, 5, 4, 4),
(36, 6, 4, 4),
(37, 7, 3, 4),
(38, 8, 2, 4),
(39, 9, 4, 4),
(40, 10, 4, 4),
(41, 1, 2, 5),
(42, 2, 4, 5),
(43, 3, 4, 5),
(44, 4, 2, 5),
(45, 5, 4, 5),
(46, 6, 2, 5),
(47, 7, 3, 5),
(48, 8, 2, 5),
(49, 9, 2, 5),
(50, 10, 2, 5),
(51, 1, 3, 6),
(52, 2, 3, 6),
(53, 3, 4, 6),
(54, 4, 3, 6),
(55, 5, 2, 6),
(56, 6, 3, 6),
(57, 7, 3, 6),
(58, 8, 2, 6),
(59, 9, 3, 6),
(60, 10, 2, 6),
(61, 1, 4, 7),
(62, 2, 3, 7),
(63, 3, 4, 7),
(64, 4, 4, 7),
(65, 5, 2, 7),
(66, 6, 2, 7),
(67, 7, 3, 7),
(68, 8, 4, 7),
(69, 9, 3, 7),
(70, 10, 3, 7),
(71, 1, 4, 8),
(72, 2, 3, 8),
(73, 3, 2, 8),
(74, 4, 2, 8),
(75, 5, 3, 8),
(76, 6, 3, 8),
(77, 7, 4, 8),
(78, 8, 4, 8),
(79, 9, 4, 8),
(80, 10, 2, 8),
(81, 1, 2, 9),
(82, 2, 4, 9),
(83, 3, 2, 9),
(84, 4, 2, 9),
(85, 5, 3, 9),
(86, 6, 3, 9),
(87, 7, 4, 9),
(88, 8, 3, 9),
(89, 9, 2, 9),
(90, 10, 4, 9),
(91, 11, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `client_id` int(30) NOT NULL AUTO_INCREMENT,
  `client_nom` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`client_id`, `client_nom`, `client_email`) VALUES
(1, 'nom1', 'mail1'),
(2, 'nom2', 'mail2'),
(3, 'nom3', 'mail3'),
(4, 'nom4', 'mail4'),
(5, 'nom5', 'mail5');

-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

DROP TABLE IF EXISTS `connexion`;
CREATE TABLE IF NOT EXISTS `connexion` (
  `connexion_id` int(30) NOT NULL AUTO_INCREMENT,
  `admin_id` int(30) NOT NULL,
  `role_id` int(30) NOT NULL,
  `connecte` varchar(255) NOT NULL,
  PRIMARY KEY (`connexion_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `countchambre`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `countchambre`;
CREATE TABLE IF NOT EXISTS `countchambre` (
`chambre_id` int(30)
,`num_chambre` int(30)
,`pers_max` int(255)
,`hotel_nom` varchar(255)
,`hotel_id` int(30)
);

-- --------------------------------------------------------

--
-- Structure de la table `couplechambre`
--

DROP TABLE IF EXISTS `couplechambre`;
CREATE TABLE IF NOT EXISTS `couplechambre` (
  `chambre1` varchar(255) NOT NULL,
  `chambre2` varchar(255) NOT NULL,
  `hotel_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `couplechambre`
--

INSERT INTO `couplechambre` (`chambre1`, `chambre2`, `hotel_nom`) VALUES
('1', '2', 'hotel1'),
('1', '3', 'hotel1'),
('2', '1', 'hotel1'),
('2', '3', 'hotel1'),
('2', '4', 'hotel1'),
('2', '5', 'hotel1'),
('2', '6', 'hotel1'),
('2', '7', 'hotel1'),
('2', '8', 'hotel1'),
('2', '9', 'hotel1'),
('2', '10', 'hotel1'),
('2', '11', 'hotel1'),
('3', '1', 'hotel1'),
('3', '2', 'hotel1'),
('3', '4', 'hotel1'),
('3', '5', 'hotel1'),
('3', '6', 'hotel1'),
('3', '7', 'hotel1'),
('3', '8', 'hotel1'),
('3', '9', 'hotel1'),
('3', '10', 'hotel1'),
('3', '11', 'hotel1'),
('4', '2', 'hotel1'),
('4', '3', 'hotel1'),
('5', '2', 'hotel1'),
('5', '3', 'hotel1'),
('5', '7', 'hotel1'),
('5', '8', 'hotel1'),
('5', '9', 'hotel1'),
('6', '2', 'hotel1'),
('6', '3', 'hotel1'),
('7', '2', 'hotel1'),
('7', '3', 'hotel1'),
('7', '5', 'hotel1'),
('7', '8', 'hotel1'),
('7', '9', 'hotel1'),
('8', '2', 'hotel1'),
('8', '3', 'hotel1'),
('8', '5', 'hotel1'),
('8', '7', 'hotel1'),
('8', '9', 'hotel1'),
('9', '2', 'hotel1'),
('9', '3', 'hotel1'),
('9', '5', 'hotel1'),
('9', '7', 'hotel1'),
('9', '8', 'hotel1'),
('10', '2', 'hotel1'),
('10', '3', 'hotel1'),
('11', '2', 'hotel1'),
('11', '3', 'hotel1');

-- --------------------------------------------------------

--
-- Structure de la table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE IF NOT EXISTS `hotel` (
  `hotel_id` int(30) NOT NULL AUTO_INCREMENT,
  `hotel_nom` varchar(255) NOT NULL,
  `hotel_ville` varchar(255) DEFAULT NULL,
  `hotel_adresse` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`hotel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `hotel`
--

INSERT INTO `hotel` (`hotel_id`, `hotel_nom`, `hotel_ville`, `hotel_adresse`) VALUES
(1, 'hotel1', 'Paris', NULL),
(2, 'hotel2', 'Paris', NULL),
(3, 'hotel3', 'Paris', NULL),
(4, 'hotel4', 'Bordeaux', NULL),
(5, 'hotel5', 'Bordeaux', NULL),
(6, 'hotel6', 'Marseille', NULL),
(7, 'hotel7', 'Marseille', NULL),
(8, 'hotel8', 'Marseille', NULL),
(9, 'hotel9', 'Lyon', NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `hotelchambre`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `hotelchambre`;
CREATE TABLE IF NOT EXISTS `hotelchambre` (
`chambre_id` int(30)
,`num_chambre` int(30)
,`pers_max` int(255)
,`hotel_nom` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure de la table `navigation`
--

DROP TABLE IF EXISTS `navigation`;
CREATE TABLE IF NOT EXISTS `navigation` (
  `nav_id` int(30) NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(255) NOT NULL,
  `nav_description` text DEFAULT NULL,
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `navigation`
--

INSERT INTO `navigation` (`nav_id`, `nav_name`, `nav_description`) VALUES
(1, 'admin_dataManagement', 'Gestion des réservations'),
(2, 'admin_insertData', 'Gestion des données'),
(3, 'admin_adminManagement', 'Gestion des admin');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `num_chambre` int(30) NOT NULL,
  `pers_max` int(255) NOT NULL,
  `hotel_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(30) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'super_admin'),
(2, 'admin_data'),
(3, 'admin_resa');

-- --------------------------------------------------------

--
-- Structure de la table `role_see_nav`
--

DROP TABLE IF EXISTS `role_see_nav`;
CREATE TABLE IF NOT EXISTS `role_see_nav` (
  `role_see_nav_id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_id` int(30) NOT NULL,
  `role_id` int(30) NOT NULL,
  PRIMARY KEY (`role_see_nav_id`),
  KEY `nav_id` (`nav_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `role_see_nav`
--

INSERT INTO `role_see_nav` (`role_see_nav_id`, `nav_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 2, 2),
(5, 1, 3);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `selectchambre`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `selectchambre`;
CREATE TABLE IF NOT EXISTS `selectchambre` (
`num_chambre` int(30)
,`pers_max` int(255)
,`hotel_nom` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure de la vue `countchambre`
--
DROP TABLE IF EXISTS `countchambre`;

DROP VIEW IF EXISTS `countchambre`;

-- --------------------------------------------------------

--
-- Structure de la vue `hotelchambre`
--
DROP TABLE IF EXISTS `hotelchambre`;

DROP VIEW IF EXISTS `hotelchambre`;

-- --------------------------------------------------------

--
-- Structure de la vue `selectchambre`
--
DROP TABLE IF EXISTS `selectchambre`;

DROP VIEW IF EXISTS `selectchambre`;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`chambre_id`) REFERENCES `chambre` (`chambre_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD CONSTRAINT `chambre_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`hotel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `connexion`
--
ALTER TABLE `connexion`
  ADD CONSTRAINT `connexion_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `role_see_nav`
--
ALTER TABLE `role_see_nav`
  ADD CONSTRAINT `role_see_nav_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `role_see_nav_ibfk_2` FOREIGN KEY (`nav_id`) REFERENCES `navigation` (`nav_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;


