-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 oct. 2025 à 16:58
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `te_tp4-5-php`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

DROP TABLE IF EXISTS `billets`;
CREATE TABLE IF NOT EXISTS `billets` (
  `id_billet` int NOT NULL AUTO_INCREMENT,
  `fk_proprietaire` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id_billet`),
  KEY `fk_proprietaire` (`fk_proprietaire`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `billets`
--

INSERT INTO `billets` (`id_billet`, `fk_proprietaire`, `titre`, `description`, `date`, `image`) VALUES
(2, 1, 'Mille et une vies à l’Espace Monte-Cristo : une expo qui transporte', 'Plongé au cœur de l’art contemporain, j’ai découvert une exposition unique à l’Espace Monte-Cristo. « Mille et une vies » propose un voyage sensoriel entre sculptures, installations et émotions. Une sortie parfaite pour les amateurs d’art ou les curieux e', '2025-10-19', 'images/sorties-img/exposition-mille-et-une-vies-espace-monte-cristo-in-situ-8-2048x1365.jpg'),
(3, 1, '100% L’Expo : une explosion de créativité à ne pas manquer', 'Entre installations originales et créations étonnantes, « 100% L’Expo » est une véritable immersion dans l’art contemporain. Chaque œuvre raconte une histoire et invite à la réflexion. Une sortie parfaite pour ceux qui aiment explorer de nouveaux univers ', '2025-10-22', 'images/sorties-img/La_Villette_ 100_ L_EXPO_2025.jpg'),
(4, 1, 'Kiliwatch : la friperie incontournable pour les amateurs de vintage', 'Si tu aimes chiner des pièces uniques, cette friperie est une véritable caverne aux trésors. Entre vêtements rétro, accessoires stylés et ambiance authentique, une visite chez Kiliwatch est une sortie à faire au moins une fois. Parfaite pour les passionné', '2025-10-22', 'images/sorties-img/kiliwatch-2.jpg'),
(5, 1, 'Le Musée d’Orsay : un voyage au cœur de l’art impressionniste', 'Situé dans une ancienne gare au charme unique, le Musée d\'Orsay abrite quelques-uns des chefs-d’œuvre les plus célèbres de l’art moderne. Entre Monet, Van Gogh et Degas, chaque salle est une invitation à l’émerveillement. Une sortie idéale pour les amoure', '2025-10-23', 'images/sorties-img/nef Panorama.webp'),
(6, 1, 'Le Musée du Louvre : entre chefs-d’œuvre et histoire vivante', 'Impossible de parler de sorties culturelles sans évoquer le Musée du Louvre. Des sculptures antiques à la mythique Mona Lisa, chaque salle renferme un morceau d’histoire et d’art. Une visite incontournable pour tous ceux qui veulent (re)découvrir la riche', '2025-10-23', 'images/sorties-img/image-louvres.webp'),
(7, 1, 'Les plongeuses de Jeju : une exposition fascinante au Centre culturel coréen', 'Au Centre culturel coréen de Paris, j’ai découvert une exposition touchante consacrée aux plongeuses de l’île de Jeju, ces femmes courageuses qui défient la mer depuis des générations. Entre photographies, récits et objets du quotidien, l’exposition rend ', '2025-10-23', 'images/sorties-img/exposition-ile-de-jeju-centre-culturel-coreen-in-situ-9-3200x0.jpg'),
(8, 1, 'Le Musée de l’Orangerie : l’émerveillement impressionniste au cœur du Jardin des Tuileries', 'Situé au cœur du Jardin des Tuileries, le Musée de l\'Orangerie est un écrin dédié aux chefs-d’œuvre impressionnistes et post-impressionnistes. Des Nymphéas de Monet aux œuvres de Renoir et Cézanne, chaque salle invite à la contemplation et à l’évasion art', '2025-10-23', 'images/sorties-img/68fa93dc82945_CRT_IDF_PRA7204.jpg'),
(9, 1, 'Aquarium Tropical : plongez au cœur de la biodiversité', 'Entre poissons colorés, coraux fascinants et ambiances tropicales, l’Aquarium Tropical est une véritable immersion dans les mers du monde. Une sortie idéale pour les familles, les curieux et tous les passionnés de nature et de faune marine', '2025-10-23', 'images/sorties-img/68fa955704c58_aquarium-tropical-porte-doree.jpg'),
(10, 1, 'CORPS ET ÂMES à la Bourse de Commerce : l’art contemporain en mouvement', 'À la Bourse de Commerce – Pinault Collection, l’exposition « CORPS ET ÂMES » propose un dialogue fascinant entre œuvres contemporaines et corps humains, explorant émotions, mouvement et matière. Une sortie captivante pour les amateurs d’art contemporain e', '2025-10-23', 'images/sorties-img/68faa494b52a8_141608-corps-et-ames.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaire` int NOT NULL AUTO_INCREMENT,
  `fk_auteur` int NOT NULL,
  `date` date NOT NULL,
  `fk_comment_billet` int NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `fk_comment_user` (`fk_comment_billet`),
  KEY `fk_auteur` (`fk_auteur`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_commentaire`, `fk_auteur`, `date`, `fk_comment_billet`, `commentaire`) VALUES
(1, 2, '2025-10-21', 2, 'Super billet ! Merci pour le partage.'),
(5, 3, '2025-10-23', 2, 'Oh je l\'ai déjà fait, cette exposition est vraiment incroyable à le faire, et l\'expérience est folle !'),
(6, 3, '2025-10-23', 4, 'L\'une des meilleures friperies que j\'ai jamais fait de ma vie..'),
(7, 2, '2025-10-23', 3, 'Une exposition parfaite pour avoir de l\'inspiration ou bien pour admirer les différentes oeuvres des différents artistes. Très immersif, je recommande !'),
(8, 1, '2025-10-23', 2, 'Merci beaucoup, avec plaisir ! ');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_photo` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `username`, `password`, `profile_photo`) VALUES
(1, 'admin', '$2y$10$0kufvkRdqywP9I4MaED3ZuJ6y87vzp.HY6TmNg1tZ6DRb8hxgBsxG', 'images/profile/68faa24d4895e_aquarium-tropical-porte-doree.jpg'),
(2, 'Mimnjim', '$2y$10$0vj3LhxcGTeI6hJU6ha9e.AoaqLg0cV7U15oogXeUAfsLsoiavKZu', ''),
(3, 'Utilisateur1234', '$2y$10$oWhIIpwZV32M.OqmolFUe.jGseGH/n51Vwtb5DjqwihQKL3fgfkqi', 'images/profile/68faa180233f9_image-louvres.webp');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `billets`
--
ALTER TABLE `billets`
  ADD CONSTRAINT `billets_ibfk_2` FOREIGN KEY (`fk_proprietaire`) REFERENCES `utilisateurs` (`id_user`);

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`fk_comment_billet`) REFERENCES `billets` (`id_billet`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`fk_auteur`) REFERENCES `utilisateurs` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
