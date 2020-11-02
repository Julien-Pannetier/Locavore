-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 23 oct. 2020 à 12:04
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `locavore`
--

-- --------------------------------------------------------

--
-- Structure de la table `stores`
--

DROP TABLE IF EXISTS `stores`;
CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` enum('farm','drive','market') NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `lat_long` geometry DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `timetable` text,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `status` enum('valid') DEFAULT NULL,
  `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_stores` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stores`
--

INSERT INTO `stores` (`id`, `user_id`, `name`, `description`, `type`, `product_id`, `address`, `zip_code`, `city`, `country`, `lat_long`, `contact_id`, `timetable`, `website`, `facebook`, `twitter`, `instagram`, `status`, `creation_date`, `update_date`) VALUES
(3, 1, 'Drive fermier locavor Ussel', 'Dans notre catalogue, vous trouverez uniquement des produits fermiers et artisanaux en fonction de la saison et de la production locale : légumes, fruits, viandes, volailles, fromages, boissons, farines, miel, confitures, tisanes, ...', 'drive', NULL, '23 avenue Carnot', 19200, 'USSEL', 'FRANCE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-30 11:56:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(320) NOT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `password` varchar(60) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmation_date` timestamp NULL DEFAULT NULL,
  `update_token` varchar(60) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `email`, `phone`, `password`, `registration_date`, `confirmation_token`, `confirmation_date`, `update_token`, `update_date`) VALUES
(1, 'admin', NULL, NULL, 'pannetier.j@hotmail.fr', NULL, '$2y$10$J/s.HB56i4GvUoTtsg95cOPV2lwMfrlvEwoI2LYPZYAxcXdv.pIeC', '2020-09-30 11:53:56', NULL, NULL, NULL, NULL),
(8, 'user', NULL, NULL, 'user@demo.fr', NULL, '$2y$10$me4ZdT82/9IHHxd38Gas2umcUDLOLvRd1gmD0wr9g72iKmYXnVcM6', '2020-10-01 13:52:43', NULL, NULL, NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `fk_users_stores` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
