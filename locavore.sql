-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 06 nov. 2020 à 12:35
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
-- Structure de la table `products_family`
--

DROP TABLE IF EXISTS `products_family`;
CREATE TABLE IF NOT EXISTS `products_family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products_family`
--

INSERT INTO `products_family` (`id`, `family_name`) VALUES
(1, 'Alcool / cidre / bière'),
(2, 'Jus / boissons sans alcool'),
(3, 'Thé / infusion'),
(4, 'Lait / beurre / glace'),
(5, 'Fromage'),
(6, 'Œufs'),
(7, 'Farine'),
(8, 'Légumes'),
(9, 'Fruits'),
(10, 'Viande de bœuf / veau'),
(11, 'Viande d\'agneau / mouton / chèvre'),
(12, 'Viande de volaille / lapin'),
(13, 'Viande de porc / charcuterie'),
(14, 'Miel'),
(15, 'Escargots'),
(16, 'Poisson / fruit de mer / algues'),
(17, 'Aromates / épices');

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
  `type` text,
  `address` varchar(255) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `lng_lat` geometry DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `email` text,
  `timetable` text,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `status` enum('valid') DEFAULT NULL,
  `creation_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_stores` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stores`
--

INSERT INTO `stores` (`id`, `user_id`, `name`, `description`, `type`, `address`, `postal_code`, `city`, `country`, `lng_lat`, `phone`, `email`, `timetable`, `website`, `facebook`, `twitter`, `instagram`, `status`, `creation_at`, `update_at`) VALUES
(3, 1, 'Drive fermier locavor Ussel', 'Dans notre catalogue, vous trouverez uniquement des produits fermiers et artisanaux en fonction de la saison et de la production locale : légumes, fruits, viandes, volailles, fromages, boissons, farines, miel, confitures, tisanes, ...', 'drive', '23 avenue Carnot', 19200, 'USSEL', 'FRANCE', '\0\0\0\0\0\0\0�:���{@~�ƃ-�F@', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-30 11:56:27', NULL),
(4, 1, 'Drive fermier locavor Merlines', 'Dans notre catalogue, vous trouverez uniquement des produits fermiers et artisanaux en fonction de la saison et de la production locale : légumes, fruits, viandes, volailles, fromages, boissons, farines, miel, confitures, tisanes, …', 'Drive fermier', '28 avenue Pierre Sémard ', 19340, 'Merlines', 'France', '\0\0\0\0\0\0\0{h+��@uF^��F@', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-03 15:13:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `stores_products_family`
--

DROP TABLE IF EXISTS `stores_products_family`;
CREATE TABLE IF NOT EXISTS `stores_products_family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stores_id` int(11) NOT NULL,
  `products_family_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stores_stores_products_family` (`stores_id`),
  KEY `fk_products_family_stores_products_family` (`products_family_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `phone` varchar(60) DEFAULT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(60) NOT NULL,
  `registration_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmation_at` timestamp NULL DEFAULT NULL,
  `update_token` varchar(60) DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `phone`, `email`, `password`, `registration_at`, `confirmation_token`, `confirmation_at`, `update_token`, `update_at`) VALUES
(1, 'admin', NULL, NULL, NULL, 'pannetier.j@hotmail.fr', '$2y$10$J/s.HB56i4GvUoTtsg95cOPV2lwMfrlvEwoI2LYPZYAxcXdv.pIeC', '2020-09-30 11:53:56', NULL, NULL, NULL, NULL),
(8, 'user', NULL, NULL, NULL, 'user@demo.fr', '$2y$10$me4ZdT82/9IHHxd38Gas2umcUDLOLvRd1gmD0wr9g72iKmYXnVcM6', '2020-10-01 13:52:43', NULL, NULL, NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `fk_users_stores` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stores_products_family`
--
ALTER TABLE `stores_products_family`
  ADD CONSTRAINT `fk_products_family_stores_products_family` FOREIGN KEY (`products_family_id`) REFERENCES `products_family` (`id`),
  ADD CONSTRAINT `fk_stores_stores_products_family` FOREIGN KEY (`stores_id`) REFERENCES `stores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
