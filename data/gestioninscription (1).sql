-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 août 2024 à 14:16
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestioninscription`
--

-- --------------------------------------------------------

--
-- Structure de la table `apprenant`
--

CREATE TABLE `apprenant` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `postnom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `lieuNaissance` varchar(50) NOT NULL,
  `dateNaissance` date NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `etatCivil` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `apprenant`
--

INSERT INTO `apprenant` (`id`, `nom`, `postnom`, `prenom`, `lieuNaissance`, `dateNaissance`, `email`, `tel`, `etatCivil`, `photo`) VALUES
(1, 'Bwirabuciza', 'Blondy', 'Achille', 'Kinshasa', '2002-08-12', 'achilleblondy@gmail.com', '0999249863', 'Célibataire', '95e95850-218c-4c77-8c8c-9dd8d7eefc34.jpg'),
(2, 'Admin', 'Administration', 'Auth', 'Goma', '2024-08-24', 'admin@gmail.com', '0823138029', 'Marié(e)', 'images.png');

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

CREATE TABLE `domaine` (
  `id` int(11) NOT NULL,
  `intituleDomaine` varchar(100) NOT NULL,
  `typeDomaine` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `domaine`
--

INSERT INTO `domaine` (`id`, `intituleDomaine`, `typeDomaine`) VALUES
(1, 'Mecanique Generale', 'Auto-Completion');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `domaines`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `domaines` (
`domaine_id` int(11)
,`intituleDomaine` varchar(100)
,`typeDomaine` varchar(100)
,`sousdomaine_id` int(11)
,`description` varchar(50)
,`image` varchar(100)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `inscall`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `inscall` (
`apprenant_nom` varchar(50)
,`apprenant_postnom` varchar(50)
,`apprenant_photo` varchar(100)
,`domaine_intitule` varchar(100)
,`domaine_type` varchar(100)
,`sousdomaine_description` varchar(50)
,`sousdomaine_image` varchar(100)
,`payement_montant` float
,`payement_date` date
,`payement_numTrans` varchar(100)
,`payement_photo` varchar(100)
,`inscription_matricule` varchar(50)
,`inscription_dateInscription` date
);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `idApp` int(11) DEFAULT NULL,
  `idSousDomaine` int(11) DEFAULT NULL,
  `idPayement` int(11) DEFAULT NULL,
  `dateInscription` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `matricule`, `idApp`, `idSousDomaine`, `idPayement`, `dateInscription`, `status`) VALUES
(5, 'APINPP001', 1, 2, 6, '2024-08-24', 'payé');

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `message`, `date`, `seen`) VALUES
(1, 1, 'Votre inscription a été enregistrée. Votre cas sera traité dans quelques instants et une notification vous sera renvoyée. Votre matricule est Apprenant pour l\'instant.', '2024-08-24 06:53:22', 1),
(2, 2, 'Un nouvel apprenant vient de vous envoyer une demande d\'inscription. Veuillez vérifier et valider cette inscription.', '2024-08-24 06:53:22', 1);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `idApprenant` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `statut` varchar(50) DEFAULT 'non lu',
  `dateNotification` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `idApprenant`, `message`, `statut`, `dateNotification`) VALUES
(1, 1, 'Votre paiement a été validé. Votre nouveau matricule est APINPP001.', 'non lu', '2024-08-24 11:45:05');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE `payement` (
  `id` int(11) NOT NULL,
  `Montant` float NOT NULL,
  `datePayement` date NOT NULL,
  `numTrans` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `payement`
--

INSERT INTO `payement` (`id`, `Montant`, `datePayement`, `numTrans`, `photo`) VALUES
(6, 20, '2024-08-24', 'AL04XE9VUX', 'img/Capture d’écran 2024-08-23 111510.png');

-- --------------------------------------------------------

--
-- Structure de la table `sousdomaine`
--

CREATE TABLE `sousdomaine` (
  `id` int(11) NOT NULL,
  `idDomaine` int(11) DEFAULT NULL,
  `description` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sousdomaine`
--

INSERT INTO `sousdomaine` (`id`, `idDomaine`, `description`, `image`) VALUES
(2, 1, 'Mecanique', 'Capture d’écran 2024-08-22 210145.png');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `idApprenant` int(11) DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  `psw` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `idApprenant`, `category`, `psw`) VALUES
(1, 1, 'Apprenant', '$2y$10$N67f4vXT95FHMEcNPmKXPe9XwLqzcMBYSVmTGT0PMLBUYukb80jkm'),
(2, 2, 'Admin', '$2y$10$3jxiGthZ0byBN.hPXE39OOPUqqSOost4TnE7s4FXVzkMbtqlhxtsO');

-- --------------------------------------------------------

--
-- Structure de la vue `domaines`
--
DROP TABLE IF EXISTS `domaines`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `domaines`  AS SELECT `d`.`id` AS `domaine_id`, `d`.`intituleDomaine` AS `intituleDomaine`, `d`.`typeDomaine` AS `typeDomaine`, `sd`.`id` AS `sousdomaine_id`, `sd`.`description` AS `description`, `sd`.`image` AS `image` FROM (`domaine` `d` left join `sousdomaine` `sd` on(`d`.`id` = `sd`.`idDomaine`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `inscall`
--
DROP TABLE IF EXISTS `inscall`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inscall`  AS SELECT `a`.`nom` AS `apprenant_nom`, `a`.`postnom` AS `apprenant_postnom`, `a`.`photo` AS `apprenant_photo`, `d`.`intituleDomaine` AS `domaine_intitule`, `d`.`typeDomaine` AS `domaine_type`, `sd`.`description` AS `sousdomaine_description`, `sd`.`image` AS `sousdomaine_image`, `p`.`Montant` AS `payement_montant`, `p`.`datePayement` AS `payement_date`, `p`.`numTrans` AS `payement_numTrans`, `p`.`photo` AS `payement_photo`, `i`.`matricule` AS `inscription_matricule`, `i`.`dateInscription` AS `inscription_dateInscription` FROM ((((`inscription` `i` join `apprenant` `a` on(`i`.`idApp` = `a`.`id`)) join `sousdomaine` `sd` on(`i`.`idSousDomaine` = `sd`.`id`)) join `domaine` `d` on(`sd`.`idDomaine` = `d`.`id`)) join `payement` `p` on(`i`.`idPayement` = `p`.`id`)) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `apprenant`
--
ALTER TABLE `apprenant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tel` (`tel`);

--
-- Index pour la table `domaine`
--
ALTER TABLE `domaine`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pr_bt` (`idApp`),
  ADD KEY `bl_ac` (`idSousDomaine`),
  ADD KEY `my_ov` (`idPayement`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idApprenant` (`idApprenant`);

--
-- Index pour la table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sousdomaine`
--
ALTER TABLE `sousdomaine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gk_ux` (`idDomaine`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ui` (`idApprenant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `apprenant`
--
ALTER TABLE `apprenant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `domaine`
--
ALTER TABLE `domaine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `payement`
--
ALTER TABLE `payement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `sousdomaine`
--
ALTER TABLE `sousdomaine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `bl_ac` FOREIGN KEY (`idSousDomaine`) REFERENCES `sousdomaine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `my_ov` FOREIGN KEY (`idPayement`) REFERENCES `payement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pr_bt` FOREIGN KEY (`idApp`) REFERENCES `apprenant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`idApprenant`) REFERENCES `apprenant` (`id`);

--
-- Contraintes pour la table `sousdomaine`
--
ALTER TABLE `sousdomaine`
  ADD CONSTRAINT `gk_ux` FOREIGN KEY (`idDomaine`) REFERENCES `domaine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_ui` FOREIGN KEY (`idApprenant`) REFERENCES `apprenant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
