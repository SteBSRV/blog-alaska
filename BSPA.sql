-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mar 23 Mai 2017 à 14:40
-- Version du serveur :  5.6.33
-- Version de PHP :  5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `BSPA`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `state` int(1) NOT NULL,
  `parentId` int(11) DEFAULT NULL,
  `level` int(1) NOT NULL DEFAULT '1',
  `episodeId` int(11) NOT NULL,
  `report` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `author`, `message`, `date`, `state`, `parentId`, `level`, `episodeId`, `report`) VALUES
(1, 'Steve', 'Test commentaire 1 (parent - niveau 1)', '2017-04-08 13:26:47', 1, NULL, 1, 1, 0),
(2, 'Steve', 'Test commentaire 2 (parent - niveau 1)', '2017-04-08 13:27:21', 1, NULL, 1, 1, 0),
(3, 'Steve', 'Test commentaire 3 (enfant 1 - niveau 2)', '2017-04-08 13:27:41', 1, 1, 2, 1, 0),
(4, 'Steve', 'Test commentaire 4 (parent - niveau 1)', '2017-04-08 13:27:54', 1, NULL, 1, 1, 0),
(5, 'Steve', 'Test commentaire 5 (parent - niveau 1)', '2017-04-08 13:28:05', 1, NULL, 1, 1, 0),
(6, 'Steve', 'Test commentaire 6 (enfant 4 - niveau 2)', '2017-04-08 13:33:03', 1, 4, 2, 1, 0),
(7, 'Steve', 'Test commentaire 7 (parent - niveau 1)', '2017-04-08 13:33:17', 1, NULL, 1, 1, 0),
(8, 'Steve', 'Test commentaire 8 (enfant 6 - niveau 3)', '2017-04-08 13:33:53', 1, 6, 3, 1, 0),
(9, 'Steve', 'Test commentaire 9 (enfant 6 - niveau 3)', '2017-04-08 16:36:09', 1, 6, 3, 1, 0),
(10, 'Steve', 'Test commentaire 10 (parent - niveau 1)', '2017-04-09 20:08:22', 0, NULL, 1, 1, 12),
(11, 'Steve', 'Test commentaire 11 (parent - niveau 1)', '2017-04-13 16:30:37', 1, NULL, 1, 1, 7),
(12, 'Steve', 'Test commentaire 12 (enfant 11 - niveau 2)', '2017-04-14 15:03:04', 0, 11, 2, 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `addDate` datetime NOT NULL,
  `modDate` datetime NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `episodes`
--

INSERT INTO `episodes` (`id`, `title`, `author`, `content`, `addDate`, `modDate`, `state`) VALUES
(1, 'Episode 1', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Le passage de Lorem Ipsum standard, utilis&eacute; depuis 1500</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>', '2017-04-08 12:24:07', '2017-04-08 16:41:50', 1),
(2, 'Episode 2', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Section 1.10.32 du "De Finibus Bonorum et Malorum" de Ciceron (45 av. J.-C.)</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>', '2017-04-08 12:24:35', '2017-04-08 12:24:35', 1),
(3, 'Episode 3', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Traduction de H. Rackham (1914)</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"</p>', '2017-04-08 12:24:52', '2017-04-08 12:24:52', 1),
(4, 'Episode 4', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Section 1.10.33 du "De Finibus Bonorum et Malorum" de Ciceron (45 av. J.-C.)</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."</p>', '2017-04-08 12:25:10', '2017-04-08 12:25:10', 1),
(5, 'Episode 5', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Traduction de H. Rackham (1914)</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains."</p>', '2017-04-08 12:25:28', '2017-04-08 12:25:32', 1),
(6, 'Episode 6', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Le passage de Lorem Ipsum standard, utilis&eacute; depuis 1500</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>', '2017-04-08 12:25:49', '2017-04-08 16:47:35', 1),
(7, 'Episode 7', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Section 1.10.33 du "De Finibus Bonorum et Malorum" de Ciceron (45 av. J.-C.)</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."</p>', '2017-04-08 16:48:01', '2017-04-14 14:51:58', 0),
(8, 'Episode 8', 'Steve', '<h3 style="margin: 15px 0px; padding: 0px; font-size: 14px; font-family: \'Open Sans\', Arial, sans-serif;">Traduction de H. Rackham (1914)</h3>\r\n<p style="margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;">"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"</p>', '2017-04-09 19:43:51', '2017-04-09 19:43:51', 0),
(9, 'Episode 9', 'Steve', '<p>test</p>', '2017-04-24 17:59:13', '2017-04-24 18:14:31', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `lastVisitDate` datetime NOT NULL,
  `inscriptionDate` datetime NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `lastVisitDate`, `inscriptionDate`, `state`) VALUES
(1, 'Steve', '3de1f7f993c2f65a204ccfc98b55b8f52fc73360', 'ebizetsteve@gmail.com', '2017-04-24 18:14:20', '2017-04-03 19:18:19', 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ParentID` (`parentId`),
  ADD KEY `EpisodesID` (`episodeId`);

--
-- Index pour la table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`episodeId`) REFERENCES `episodes` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
