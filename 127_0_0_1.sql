-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 08:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_cms`
--
CREATE DATABASE IF NOT EXISTS `blog_cms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog_cms`;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id_article` int(11) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `date_modification` date DEFAULT NULL,
  `nom_createur` varchar(30) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `statu` varchar(30) DEFAULT 'published'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `contenu`, `date_creation`, `date_modification`, `nom_createur`, `id_categorie`, `statu`) VALUES
(1, 'Les Nouvelles Tensions Technologiques en 2024', 'Explorez les technologies émergentes qui vont transformer notre quotidien cette année...', '2024-02-20', '2024-02-21', 'pierre_leroy', 1, 'published'),
(2, 'Comment Maintenir une Bonne Santé au Travail', 'Des conseils pratiques pour préserver votre santé physique et mentale...', '2024-02-25', '2024-02-25', 'sophie_martin', 2, 'archive'),
(4, 'Recette du Gâteau au Chocolat Fondant', 'Une recette simple et rapide pour un gâteau au chocolat irrésistible...', '2024-03-10', '2024-03-11', 'lucie_bernard', 4, 'published'),
(5, 'Préparation Marathon : Guide Complet du Débutant', 'Tout ce qu\'il faut savoir pour préparer son premier marathon...', '2024-03-15', '2024-03-16', 'marc_vincent', 5, 'published'),
(6, 'Apprendre à Coder en 6 Mois : Mon Parcours', 'Comment j\'ai appris la programmation web en moins de 6 mois...', '2024-03-20', '2024-03-21', 'david_morel', 6, 'published'),
(7, 'Investir dans la Cryptomonnaie en 2024', 'Guide pour débutants sur les opportunités et risques...', '2024-04-01', '2024-04-02', 'nicolas_lambert', 7, 'published'),
(8, 'Les Tendances Mode Printemps-Été 2024', 'Découvrez les must-have de la saison prochaine...', '2023-04-05', '2024-04-06', 'antoine_chevalier', 8, 'archive'),
(9, 'Les Avantages du Télétravail pour la Productivité', 'Comment le travail à distance peut booster vos performances...', '2024-04-10', '2024-04-11', 'amelie_colin', 1, 'published'),
(10, 'Les Superaliments pour Renforcer l\'Immunité', '10 aliments à intégrer dans votre alimentation pour être en forme...', '2023-04-15', '2024-04-16', 'clara_royer', 2, 'published'),
(11, 'Voyager en Solo : Mes Conseils Sécurité', 'Guide pratique pour voyager seul en toute sécurité...', '2024-04-20', '2024-04-21', 'amelie_colin', 3, 'published'),
(13, 'Yoga pour Débutants : Programme sur 30 Jours', 'Un programme progressif pour découvrir le yoga...', '2024-05-10', '2024-05-11', 'jean_dupont', 5, 'published'),
(14, 'Les Méthodes d\'Apprentissage des Langues Efficaces', 'Comparatif des différentes approches pour apprendre une langue...', '2021-05-20', '2024-05-21', 'lucie_bernard', 6, 'archive'),
(15, 'Économiser pour Son Premier Achat Immobilier', 'Stratégies pour constituer son apport personnel...', '2024-06-01', '2024-06-02', 'marc_vincent', 7, 'published'),
(16, 'Le Style Minimaliste : Less is More', 'Comment adopter une garde-robe minimaliste et élégante...', '2024-06-10', '2024-06-11', 'david_morel', 8, 'published'),
(17, 'Introduction à l\'Intelligence Artificielle', 'Comprendre les bases de l\'IA et ses applications...', '2024-06-15', '2024-06-16', 'nicolas_lambert', 1, 'published'),
(19, 'Voyager avec un Petit Budget', 'Astuces pour voyager sans se ruiner...', '2024-07-12', '2024-07-13', 'clara_royer', 3, 'published'),
(20, 'Les Plats Typiques de la Cuisine Marocaine', 'Découverte des saveurs et traditions culinaires du Maroc...', '2024-07-20', '2024-07-21', 'amelie_colin', 4, 'published'),
(22, 'Les Outils Numériques pour l\'Éducation', 'Les meilleures applications pour apprendre et enseigner...', '2023-08-10', '2024-08-11', 'marine_lebrun', 6, 'published'),
(23, 'Comprendre les Marchés Boursiers', 'Guide pour débutants en bourse...', '2024-08-20', '2024-08-21', 'pierre_leroy', 7, 'published'),
(24, 'Le Style Casual Chic au Bureau', 'Comment être élégant tout en restant confortable...', '2024-09-01', '2024-09-02', 'sophie_martin', 8, 'published'),
(25, 'La Sécurité Informatique pour les Particuliers', 'Protégez vos données et votre vie privée en ligne...', '2024-09-10', '2024-09-11', 'jean_dupont', 1, 'published'),
(26, 'L\'Importance du Sommeil pour la Santé', 'Comment améliorer la qualité de son sommeil...', '2021-09-20', '2024-09-21', 'lucie_bernard', 2, 'archive'),
(27, 'Les Plus Beaux Villages de France', 'Découverte des villages classés parmi les plus beaux de France...', '2020-10-01', '2024-10-02', 'marc_vincent', 3, 'archive'),
(28, 'Les Techniques de Cuisson Santé', 'Cuire ses aliments tout en préservant les nutriments...', '2022-10-10', '2024-10-11', 'david_morel', 4, 'published'),
(29, 'Le CrossFit : Avantages et Risques', 'Analyse complète de cette discipline sportive...', '2024-10-20', '2024-10-21', 'nicolas_lambert', 5, 'published'),
(30, 'Apprendre par le Jeu : La Ludopédagogie', 'Utiliser le jeu comme outil d\'apprentissage...', '2024-11-01', '2024-11-02', 'antoine_chevalier', 6, 'published');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom_categorie`) VALUES
(1, 'Technologie'),
(2, 'Santé'),
(3, 'Voyage'),
(4, 'Cuisine'),
(5, 'Sport'),
(6, 'Éducation'),
(7, 'Finance'),
(8, 'Mode');

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_cmt` int(11) NOT NULL,
  `contenu_cmt` text DEFAULT NULL,
  `date_creation_cmt` date DEFAULT curdate(),
  `id_article` int(11) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `statu` varchar(20) DEFAULT 'approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id_cmt`, `contenu_cmt`, `date_creation_cmt`, `id_article`, `user_name`, `statu`) VALUES
(1, 'Excellent article, très bien documenté !', '2024-02-21', 1, 'jean_dupont', 'approved'),
(2, 'Je ne suis pas tout à fait d\'accord sur certains points.', '2024-02-22', 1, 'sophie_martin', 'approved'),
(5, 'Je trouve que certains conseils sont dangereux.', '2024-02-27', 4, 'pierre_leroy', 'approved'),
(6, 'Parfait pour les débutants comme moi, merci !', '2024-02-28', 5, 'julie_roux', 'approved'),
(7, 'Très détaillé, j\'ai appris beaucoup de choses.', '2024-02-29', 6, 'marc_vincent', 'approved'),
(8, 'C\'est exactement ce que je cherchais, merci !', '2024-03-01', 7, 'isabelle_leroy', 'approved'),
(9, 'Je ne comprends pas la partie sur les investissements.', '2024-03-02', 8, 'david_morel', 'approved'),
(10, 'Super article, j\'ai hâte de lire la suite !', '2024-03-03', 9, 'caroline_duval', 'approved'),
(11, 'Les tendances présentées sont déjà dépassées.', '2024-03-04', 10, 'nicolas_lambert', 'approved'),
(12, 'Je vais essayer la recette ce week-end !', '2024-03-05', 28, 'elodie_garnier', 'approved'),
(13, 'Bonnes astuces pour économiser, merci.', '2024-03-06', 15, 'antoine_chevalier', 'approved'),
(16, 'La méditation a changé ma vie, merci pour l\'article.', '2024-03-09', 26, 'amelie_colin', 'approved'),
(17, 'Voyager avec un petit budget c\'est possible !', '2024-03-10', 19, 'vincent_gauthier', 'approved'),
(20, 'Quelles applications recommandez-vous pour les enfants ?', '2024-03-13', 22, 'sophie_martin', 'approved'),
(21, 'La bourse me fait peur, merci pour les explications.', '2024-03-14', 23, 'pierre_leroy', 'approved'),
(22, 'Je cherche justement un style casual chic, merci !', '2024-03-15', 24, 'lucie_bernard', 'approved'),
(23, 'Important de parler de sécurité informatique.', '2024-03-16', 25, 'jean_dupont', 'approved'),
(24, 'Je dors mal, merci pour ces conseils.', '2024-03-17', 26, 'marie_dubois', 'approved'),
(25, 'J\'ai visité certains villages, ils sont magnifiques !', '2024-03-18', 27, 'jean_dupont', 'approved'),
(26, '[value-2]', '2025-02-20', 5, NULL, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `user_name` varchar(30) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_inscricption` date DEFAULT curdate(),
  `estAdmin` tinyint(1) DEFAULT NULL,
  `passwords` varchar(30) DEFAULT 'user1234'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nom`, `prenom`, `user_name`, `email`, `date_inscricption`, `estAdmin`, `passwords`) VALUES
('Blog', 'Admin', 'admin_blog', 'admin@blogcms.com', '2024-01-15', 1, 'admin1234'),
('Colin', 'Amelie', 'amelie_colin', 'amelie.colin@email.com', '2024-07-03', 0, 'user1234'),
('Chevalier', 'Antoine', 'antoine_chevalier', 'antoine.chevalier@yahoo.fr', '2024-06-01', 0, 'user1234'),
('Duval', 'Caroline', 'caroline_duval', 'caroline.duval@protonmail.com', '2024-05-02', 1, 'admin1234'),
('Royer', 'Clara', 'clara_royer', 'clara.royer@protonmail.com', '2024-06-10', 0, 'user1234'),
('Morel', 'David', 'david_morel', 'david.morel@email.com', '2024-04-15', 0, 'user1234'),
('Garnier', 'Elodie', 'elodie_garnier', 'elodie.garnier@email.com', '2024-05-20', 0, 'user1234'),
('Leroy', 'Isabelle', 'isabelle_leroy', 'isabelle.leroy@gmail.com', '2024-04-10', 0, 'user1234'),
('jud', 'pont', 'jdupont', 'jean.dupont@email.com', '2025-12-03', 0, '$2y$10$...'),
('Dupont', 'Jean', 'jean_dupont', 'jean.dupont@yahoo.fr', '2024-03-10', 0, 'user1234'),
('Roux', 'Julie', 'julie_roux', 'julie.roux@protonmail.com', '2024-04-01', 0, 'user1234'),
('Bernard', 'Lucie', 'lucie_bernard', 'lucie.bernard@email.com', '2024-03-15', 0, 'user1234'),
('Vincent', 'Marc', 'marc_vincent', 'marc.vincent@yahoo.fr', '2024-04-05', 0, 'user1234'),
('Dubois', 'Marie', 'marie_dubois', 'marie.dubois@email.com', '2024-02-10', 0, 'user1234'),
('Lebrun', 'Marine', 'marine_lebrun', 'marine.lebrun@gmail.com', '2024-07-20', 0, 'user1234'),
('Lambert', 'Nicolas', 'nicolas_lambert', 'nicolas.lambert@gmail.com', '2024-05-10', 0, 'user1234'),
('Leroy', 'Pierre', 'pierre_leroy', 'pierre.leroy@gmail.com', '2024-02-15', 0, 'user1234'),
('Menard', 'Quentin', 'quentin_menard', 'quentin.menard@gmail.com', '2024-06-15', 0, 'user1234'),
('Martin', 'Sophie', 'sophie_martin', 'sophie.martin@protonmail.com', '2024-03-01', 0, 'user1234'),
('Petit', 'Thomas', 'thomas_petit', 'thomas.petit@gmail.com', '2024-03-20', 0, 'user1234'),
('Gauthier', 'Vincent', 'vincent_gauthier', 'vincent.gauthier@protonmail.com', '2024-07-12', 1, 'admin1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `nom_createur` (`nom_createur`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_cmt`),
  ADD KEY `id_article` (`id_article`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_cmt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`nom_createur`) REFERENCES `users` (`user_name`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Constraints for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `users` (`user_name`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-12-18 19:04:55', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
