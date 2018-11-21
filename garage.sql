-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 10 jan. 2018 à 12:30
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `garage`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `nom` varchar(10) NOT NULL,
  `prenom` varchar(10) NOT NULL,
  `sexe` text NOT NULL,
  `dateNaissance` date NOT NULL,
  `adresse` text NOT NULL,
  `numTel` int(11) NOT NULL,
  `mail` text NOT NULL,
  `codePostal` int(20) NOT NULL,
  `Ville` varchar(20) NOT NULL,
  `Pays` varchar(20) NOT NULL,
  `montantMax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `nom`, `prenom`, `sexe`, `dateNaissance`, `adresse`, `numTel`, `mail`, `codePostal`, `Ville`, `Pays`, `montantMax`) VALUES
(10, 'Smith', 'William', 'man', '1998-07-10', '2, rue oui', 612345678, 'smith@hotmail.fr', 45100, 'Los Angeles', 'Usa', 1500),
(11, 'DUPONT', 'Dupont', 'man', '2018-01-09', 'rue test', 60000000, 'test@test.fr', 45000, 'Orleans', 'France', 500);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `idEmploye` int(11) NOT NULL,
  `login` text NOT NULL,
  `motDePasse` text NOT NULL,
  `Categorie` text NOT NULL,
  `nomEmploye` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`idEmploye`, `login`, `motDePasse`, `Categorie`, `nomEmploye`) VALUES
(8, 'MonLogin', '1234', 'Directeur', 'Pierre'),
(9, 'MonLogin', '0000', 'Agent', 'Andrew'),
(10, 'MonLogin', '4321', 'Mecanicien', 'Elsa'),
(11, 'MonLogin', '1111', 'Mecanicien', 'Y');

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `idFormation` int(11) NOT NULL,
  `dateFormation` date NOT NULL,
  `heureFormation` datetime NOT NULL,
  `idEmploye` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`idFormation`, `dateFormation`, `heureFormation`, `idEmploye`) VALUES
(9, '2018-01-10', '2018-01-10 18:00:00', 10);

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE `intervention` (
  `codeIntervention` int(11) NOT NULL,
  `idTI` int(11) NOT NULL,
  `dateIntervention` date NOT NULL,
  `heureIntervention` datetime NOT NULL,
  `idEmploye` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `etat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`codeIntervention`, `idTI`, `dateIntervention`, `heureIntervention`, `idEmploye`, `idClient`, `etat`) VALUES
(36, 11, '2018-01-01', '2018-01-01 11:00:00', 10, 10, 'payee'),
(37, 13, '2018-01-10', '2018-01-10 11:00:00', 10, 10, 'en attente de payement'),
(38, 12, '2018-01-11', '2018-01-11 12:00:00', 10, 10, 'en attente de payement'),
(39, 11, '2018-01-11', '2018-11-01 10:00:00', 10, 10, 'differe'),
(40, 12, '2018-01-12', '2018-12-01 14:00:00', 10, 10, 'payee'),
(41, 13, '2018-01-12', '2018-01-12 15:00:00', 10, 10, 'en attente de payement'),
(42, 11, '2018-01-10', '2018-01-10 18:00:00', 10, 11, 'payee'),
(43, 15, '2018-01-10', '2018-01-10 10:00:00', 10, 11, 'payee');

-- --------------------------------------------------------

--
-- Structure de la table `type_intervention`
--

CREATE TABLE `type_intervention` (
  `idTI` int(11) NOT NULL,
  `nomTI` varchar(30) NOT NULL,
  `montant` int(11) NOT NULL,
  `element_piece` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_intervention`
--

INSERT INTO `type_intervention` (`idTI`, `nomTI`, `montant`, `element_piece`) VALUES
(11, 'Vidange', 150, 'Huile a vidange'),
(12, 'Plaquette', 150, 'Plaquette de frein'),
(13, 'Changement vitre', 145, 'Vitre'),
(14, 'Autoradio', 150, 'Radio, Auto'),
(15, 'X', 200, 'p');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`idEmploye`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`idFormation`),
  ADD UNIQUE KEY `idEmploye` (`idEmploye`);

--
-- Index pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD PRIMARY KEY (`codeIntervention`),
  ADD KEY `idTI` (`idTI`),
  ADD KEY `idEmploye` (`idEmploye`),
  ADD KEY `idClient` (`idClient`);

--
-- Index pour la table `type_intervention`
--
ALTER TABLE `type_intervention`
  ADD PRIMARY KEY (`idTI`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `idEmploye` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `idFormation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `intervention`
--
ALTER TABLE `intervention`
  MODIFY `codeIntervention` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `type_intervention`
--
ALTER TABLE `type_intervention`
  MODIFY `idTI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `formation_ibfk_1` FOREIGN KEY (`idEmploye`) REFERENCES `employe` (`idEmploye`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `intervention_Fk_1` FOREIGN KEY (`idEmploye`) REFERENCES `employe` (`idEmploye`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `intervention_Fk_2` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `intervention_ibfk_1` FOREIGN KEY (`idTI`) REFERENCES `type_intervention` (`idTI`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
