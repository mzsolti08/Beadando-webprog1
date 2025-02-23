-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2022 at 06:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `games_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `forum_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `posts` varchar(500) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `removed_post` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`forum_id`, `topic_id`, `user_id`, `posts`, `create_time`, `removed_post`) VALUES
(1, 2, 12, 'Új updatetről vélemény?', '2022-03-23 11:07:09', NULL),
(2, 5, 9, 'Jó lett az új season?', '2022-03-23 11:08:11', NULL),
(25, 1, 10, 'Forum teszta', '2022-03-24 10:21:05', NULL),
(26, 5, 18, 'Sok a csaló', '2022-04-12 12:16:02', NULL),
(27, 2, 9, 'Könnyű játék...', '2022-04-12 01:10:14', NULL),
(28, 1, 10, 'Bocsi bocsi bocsia', '2022-04-20 09:28:56', '2022-04-22 06:17:04'),
(29, 4, 12, 'Ez az első valós posztom egy jó játékról', '2022-04-20 10:38:13', NULL),
(34, 4, 13, 'Remélem legközelebb sikerül nyernem. Kommentekben bővebben', '2022-04-21 07:46:39', NULL),
(35, 10, 14, 'Asder', '2022-04-21 08:15:41', '2022-04-23 17:05:17'),
(39, 13, 10, 'Szerintetek megéri megvenni a Far Cry 6-ot?', '2022-04-22 06:28:32', NULL),
(40, 13, 18, 'Nektek, hogy tetszett az új Far Cry?', '2022-04-22 06:51:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forum_comments`
--

CREATE TABLE `forum_comments` (
  `comment_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` varchar(500) NOT NULL DEFAULT '',
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum_comments`
--

INSERT INTO `forum_comments` (`comment_id`, `forum_id`, `user_id`, `comment`, `deleted`) VALUES
(1, 1, 9, 'asdasdasdsadsa', NULL),
(2, 1, 10, 'huauhdahuia', '2022-04-22 06:44:35'),
(3, 1, 4, 'aaaaaaaaaaaaa', '2022-04-22 18:04:32'),
(4, 2, 3, 'valami', '2022-04-23 05:58:06'),
(6, 28, 3, 'asder vagyok helo', NULL),
(7, 1, 10, 'sssssssssssssssssssssssssssssss', '2022-04-22 18:04:33'),
(8, 26, 10, 'posztnak a kommentsufg68r', NULL),
(9, 29, 12, 'sziasztok! a kérdésem az, hogy mennyi?', NULL),
(10, 27, 9, 'Úristen ki ez az nber?', NULL),
(11, 1, 9, '5. komment', NULL),
(12, 1, 9, '6.komment', NULL),
(13, 1, 9, 'Nagyon\r\nSzép\r\nMunka', NULL),
(14, 35, 14, 'Nagyon finom ez az étel', NULL),
(15, 1, 13, 'asd', '2022-04-22 05:51:15'),
(16, 39, 10, 'Igen!', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `forum_type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `forum_type`) VALUES
(1, 'Grand Theft Auto V'),
(2, 'Counter Strike: Global Offensive'),
(4, 'Rainbow Six: Siege'),
(5, 'Fortnite'),
(8, 'Call of Duty: Warzone'),
(9, 'Forza Horizon 5'),
(10, 'Valorant'),
(11, 'Apex Legends'),
(12, 'PUBG: BATTLEGROUNDS'),
(13, 'Far Cry 6');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_description` varchar(400) NOT NULL DEFAULT '',
  `removed` datetime DEFAULT NULL,
  `web_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_email`, `user_description`, `removed`, `web_admin`) VALUES
(2, 'aaaaaa', 'bfd59291e825b5f2bbf1eb76569f8fe7', 'aaaa@gmail.com', '', NULL, 1),
(3, 'asder', 'df3a40d680194628fc46cc1ba60f8cf8', 'asd@er.com', '', NULL, 1),
(4, 'Ememiniem', '025f82ffb1ff775f3f2c7d2e2b97fc85', 'eminemnememinem@gmail.com', 'asdasdddd', '2022-04-22 03:53:10', 1),
(9, 'zsolesz', '7815696ecbf1c96e6894b779456d330e', 'asd@asd.com', 'asdasdassssssss', '2022-04-23 16:58:33', 1),
(10, 'someone', '7815696ecbf1c96e6894b779456d330e', 'someone@hmail.com', '', NULL, 2),
(11, 'kumer', 'bfd59291e825b5f2bbf1eb76569f8fe7', 'kumeresz@gmail.com', 'asdadadasda', NULL, 1),
(12, 'valid', '9f7d0ee82b6a6ca7ddeae841f3253059', 'tqk25408@zcrcd.com', 'Ez egy valid profil, egy valid forma által', NULL, 1),
(13, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@about.games', '', NULL, 2),
(14, 'Idus1', '58c6a8d759049c368754a15658fe90e0', 'valami@gmail.com', 'Valami leírás', NULL, 1),
(15, 'valakimas', '7815696ecbf1c96e6894b779456d330e', 'asd@ajelszo', '', NULL, 1),
(16, 'gbl', '7815696ecbf1c96e6894b779456d330e', 'asd@jelszo', '', NULL, 1),
(17, 'aboutgamer', '7815696ecbf1c96e6894b779456d330e', 'asd@ittis', '', NULL, 1),
(18, 'Gamer', '7815696ecbf1c96e6894b779456d330e', 'Gamer@blathy', '', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `forum_id` (`forum_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `forum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `forum_comments`
--
ALTER TABLE `forum_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `forums_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD CONSTRAINT `FK_forum_comments_forums` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`forum_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_forum_comments_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
