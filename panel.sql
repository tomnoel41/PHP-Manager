-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 09 juin 2023 à 11:13
-- Version du serveur : 11.0.1-MariaDB-1:11.0.1+maria~ubu1804
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `panel`
--

-- --------------------------------------------------------

--
-- Structure de la table `instances`
--

CREATE TABLE `instances` (
  `id` int(11) NOT NULL,
  `projetID` int(11) NOT NULL,
  `node` int(11) NOT NULL,
  `vmid` varchar(200) NOT NULL,
  `hostname` text NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `os` varchar(200) NOT NULL,
  `owner` int(11) NOT NULL,
  `createdAt` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=suspendu,1=actif,-1=supprimer',
  `ip` text NOT NULL DEFAULT '',
  `ipGw` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nodes`
--

CREATE TABLE `nodes` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0 = Désactivé, 1 = Activé',
  `name` varchar(200) NOT NULL,
  `pays` varchar(200) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `FQDN` varchar(255) NOT NULL,
  `user` varchar(200) NOT NULL,
  `pwd` varchar(500) NOT NULL,
  `bridge` varchar(255) NOT NULL DEFAULT 'vmbr0',
  `disk` varchar(255) NOT NULL,
  `note` text NOT NULL DEFAULT '',
  `templateDisk` varchar(255) NOT NULL,
  `flag` varchar(255) NOT NULL DEFAULT 'fr'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `projectName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `logo` text NOT NULL,
  `favicon` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `name`, `logo`, `favicon`, `description`) VALUES
(1, 'Proxmox-Manager', '/assets/upload/logo.jpg', '/assets/upload/logo.jpg', 'Proxmox-Manager est un panel complet permettant la gestion facile et rapide des instances virtuelles. Créez, gérez et supprimez vos instances en toute simplicité pour répondre à vos besoins spécifiques.');

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Clos, 1 = Ouvert'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tickets_msg`
--

CREATE TABLE `tickets_msg` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Non vérifié, 1 = Vérifié',
  `ip` varchar(20) NOT NULL,
  `token` text NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp(),
  `admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT '	0 = non admin, 1 = admin'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `instances`
--
ALTER TABLE `instances`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `nodes`
--
ALTER TABLE `nodes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tickets_msg`
--
ALTER TABLE `tickets_msg`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `instances`
--
ALTER TABLE `instances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `nodes`
--
ALTER TABLE `nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `tickets_msg`
--
ALTER TABLE `tickets_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
