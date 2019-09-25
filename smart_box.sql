-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 25 sep. 2019 à 15:06
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `smart_box`
--

-- --------------------------------------------------------

--
-- Structure de la table `box`
--

CREATE TABLE `box` (
  `idBox` int(11) NOT NULL,
  `idCasier` int(11) NOT NULL,
  `derniereUtilisation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `etatBox` varchar(20) NOT NULL,
  `longueurBox` int(11) NOT NULL,
  `largeurBox` int(11) NOT NULL,
  `hauteurBox` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `box`
--

INSERT INTO `box` (`idBox`, `idCasier`, `derniereUtilisation`, `etatBox`, `longueurBox`, `largeurBox`, `hauteurBox`) VALUES
(1, 1, '2019-09-25 12:53:46', 'vide', 400, 80, 200),
(2, 1, '2019-09-25 12:55:02', 'affecte', 400, 80, 200),
(3, 1, '2019-09-25 12:51:18', 'vide', 50, 30, 50);

-- --------------------------------------------------------

--
-- Structure de la table `box_contient_colis`
--

CREATE TABLE `box_contient_colis` (
  `idActeur` int(11) DEFAULT NULL,
  `idBox` int(11) NOT NULL,
  `idCasier` int(11) NOT NULL,
  `idColis` int(11) NOT NULL,
  `dateOperation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `typeOperation` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `box_contient_colis`
--

INSERT INTO `box_contient_colis` (`idActeur`, `idBox`, `idCasier`, `idColis`, `dateOperation`, `typeOperation`) VALUES
(NULL, 2, 1, 131, '2019-09-25 12:55:02', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `casier`
--

CREATE TABLE `casier` (
  `idcasier` int(20) NOT NULL,
  `code_commune` int(4) NOT NULL,
  `adress` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `casier`
--

INSERT INTO `casier` (`idcasier`, `code_commune`, `adress`) VALUES
(1, 16, 'bab zouar'),
(2, 17, 'el_harrach'),
(3, 18, 'grande poste'),
(4, 19, 'el hamma');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`idBox`,`idCasier`),
  ADD KEY `contraint1` (`idCasier`);

--
-- Index pour la table `box_contient_colis`
--
ALTER TABLE `box_contient_colis`
  ADD PRIMARY KEY (`idBox`,`idColis`,`dateOperation`),
  ADD UNIQUE KEY `idColis` (`idColis`),
  ADD KEY `2` (`idCasier`);

--
-- Index pour la table `casier`
--
ALTER TABLE `casier`
  ADD PRIMARY KEY (`idcasier`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `box`
--
ALTER TABLE `box`
  ADD CONSTRAINT `contraint1` FOREIGN KEY (`idCasier`) REFERENCES `casier` (`idcasier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `box_contient_colis`
--
ALTER TABLE `box_contient_colis`
  ADD CONSTRAINT `1` FOREIGN KEY (`idBox`) REFERENCES `box` (`idBox`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `2` FOREIGN KEY (`idCasier`) REFERENCES `casier` (`idcasier`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
