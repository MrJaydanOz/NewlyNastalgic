-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 10:22 AM
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
-- Database: `data`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `AccountID` int(11) NOT NULL,
  `AccountUUID` char(6) NOT NULL,
  `FullName` varchar(64) NOT NULL,
  `Email` varchar(320) NOT NULL,
  `PasswordHash` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountID`, `AccountUUID`, `FullName`, `Email`, `PasswordHash`) VALUES
(4, 'h_7PDQ', 'Name2', 'example@no.com', '$2y$10$INwo6VSL5Lk/L7xxEMcQv.LYZqmCcjn3bO9s8j36sdtQDy8FyKxcC'),
(5, 'F7PtQ8', 'Namey', 'namey@gmail.com.au', '$2y$10$5qYKp9FsJcn6LbuvJoesDelv3QCtmF564WLfcKfqA7UOWfpcfvGLq'),
(6, 'WDvMQo', 'Namious', 'namious@gmail.com', '$2y$10$z49SfRBPC1N.8F7ANDl62eUUeID7aausOin0bb.tOPGJNLMexXAF2'),
(7, 'nYj1nn', 'User1', 'user1@mail', '$2y$10$oxyjqQLQ9eMHQSzJDfyxeeS06.2Q3q7oLYTbCpwJCS6E9mWnKTrua');

-- --------------------------------------------------------

--
-- Table structure for table `certification`
--

CREATE TABLE `certification` (
  `CertificationIndex` tinyint(3) UNSIGNED NOT NULL,
  `CertificationName` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certification`
--

INSERT INTO `certification` (`CertificationIndex`, `CertificationName`) VALUES
(0, 'CTC'),
(1, 'G'),
(3, 'M'),
(4, 'MA15+'),
(2, 'PG'),
(5, 'R18+'),
(6, 'X18+');

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `CollectionID` int(11) NOT NULL,
  `CollectionUUID` char(6) NOT NULL,
  `Name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collectionitem`
--

CREATE TABLE `collectionitem` (
  `ItemUUID` char(6) NOT NULL,
  `CollectionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `ImageID` int(11) NOT NULL,
  `ImageUUID` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`ImageID`, `ImageUUID`) VALUES
(1, 'I_0001'),
(2, 'I_0002'),
(3, 'I_0003'),
(4, 'I_0004');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `MediaID` int(11) NOT NULL,
  `MediaUUID` char(6) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `ReleaseDate` datetime NOT NULL,
  `CoverImageID` int(11) DEFAULT NULL,
  `TrailerVideoID` int(11) DEFAULT NULL,
  `CertificationIndex` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`MediaID`, `MediaUUID`, `Name`, `ReleaseDate`, `CoverImageID`, `TrailerVideoID`, `CertificationIndex`) VALUES
(1, 'M_0001', 'Iron Man', '2024-03-30 06:01:12', 1, NULL, 2),
(2, 'M_0002', 'Captain Marvel', '2024-03-30 06:01:12', 2, NULL, 2),
(3, 'M_0003', 'Avengers: Infinity War', '2024-03-30 10:16:40', 3, NULL, 2),
(4, 'M_0004', 'Avengers: Endgame', '2024-03-30 10:16:40', 4, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `media_episodecontainer`
--

CREATE TABLE `media_episodecontainer` (
  `MediaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_episodes`
--

CREATE TABLE `media_episodes` (
  `MediaID` int(11) NOT NULL,
  `EpisodeContainerID` int(11) NOT NULL,
  `EpisodeNumber` smallint(5) UNSIGNED NOT NULL,
  `SeasonNumber` smallint(5) UNSIGNED NOT NULL,
  `MinutesLong` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_standalone`
--

CREATE TABLE `media_standalone` (
  `MediaID` int(11) NOT NULL,
  `MinutesLong` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_standalone`
--

INSERT INTO `media_standalone` (`MediaID`, `MinutesLong`) VALUES
(1, 90),
(2, 120),
(3, 150),
(4, 180);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `RatingID` int(11) NOT NULL,
  `AuthorAccountID` int(11) NOT NULL,
  `AboutMediaID` int(11) NOT NULL,
  `Rating` tinyint(3) UNSIGNED NOT NULL,
  `ReviewText` varchar(2048) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`RatingID`, `AuthorAccountID`, `AboutMediaID`, `Rating`, `ReviewText`) VALUES
(4, 4, 1, 1, 'test2231'),
(11, 6, 1, 10, 'test2'),
(12, 6, 2, 8, 'This system is working!!!!!'),
(13, 7, 1, 10, 'Best sytem'),
(15, 7, 4, 7, 'Pretty much the end...'),
(16, 7, 3, 10, 'Infinitely Good'),
(17, 7, 2, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `uuitems`
--

CREATE TABLE `uuitems` (
  `UUID` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uuitems`
--

INSERT INTO `uuitems` (`UUID`) VALUES
('A_ADMN'),
('F7PtQ8'),
('GqTdeg'),
('h_7PDQ'),
('I_0001'),
('I_0002'),
('I_0003'),
('I_0004'),
('M_0001'),
('M_0002'),
('M_0003'),
('M_0004'),
('nYj1nn'),
('q2RJT9'),
('SCUbN9'),
('WDvMQo');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `VideoID` int(11) NOT NULL,
  `VideoUUID` char(6) NOT NULL,
  `URL` varchar(256) NOT NULL,
  `EmbeddedURL` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`AccountID`),
  ADD UNIQUE KEY `AccountUUID` (`AccountUUID`),
  ADD UNIQUE KEY `FullName` (`FullName`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `certification`
--
ALTER TABLE `certification`
  ADD PRIMARY KEY (`CertificationIndex`),
  ADD UNIQUE KEY `CertificationName` (`CertificationName`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`CollectionID`),
  ADD UNIQUE KEY `CollectionUUID` (`CollectionUUID`);

--
-- Indexes for table `collectionitem`
--
ALTER TABLE `collectionitem`
  ADD UNIQUE KEY `CollectionID` (`CollectionID`),
  ADD UNIQUE KEY `ItemUUID` (`ItemUUID`,`CollectionID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ImageID`),
  ADD UNIQUE KEY `ImageUUID` (`ImageUUID`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`MediaID`),
  ADD UNIQUE KEY `MediaUUID` (`MediaUUID`),
  ADD KEY `CoverImageID` (`CoverImageID`),
  ADD KEY `TrailerVideoID` (`TrailerVideoID`),
  ADD KEY `CertificationIndex` (`CertificationIndex`);

--
-- Indexes for table `media_episodecontainer`
--
ALTER TABLE `media_episodecontainer`
  ADD PRIMARY KEY (`MediaID`);

--
-- Indexes for table `media_episodes`
--
ALTER TABLE `media_episodes`
  ADD PRIMARY KEY (`MediaID`),
  ADD UNIQUE KEY `EpisodeContainerID` (`EpisodeContainerID`,`EpisodeNumber`,`SeasonNumber`);

--
-- Indexes for table `media_standalone`
--
ALTER TABLE `media_standalone`
  ADD PRIMARY KEY (`MediaID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`RatingID`),
  ADD UNIQUE KEY `AuthorAccountID` (`AuthorAccountID`,`AboutMediaID`),
  ADD KEY `AboutMediaID` (`AboutMediaID`);

--
-- Indexes for table `uuitems`
--
ALTER TABLE `uuitems`
  ADD PRIMARY KEY (`UUID`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`VideoID`),
  ADD UNIQUE KEY `VideoUUID` (`VideoUUID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `CollectionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `MediaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `VideoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`AccountUUID`) REFERENCES `uuitems` (`UUID`);

--
-- Constraints for table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`CollectionUUID`) REFERENCES `uuitems` (`UUID`);

--
-- Constraints for table `collectionitem`
--
ALTER TABLE `collectionitem`
  ADD CONSTRAINT `collectionitem_ibfk_1` FOREIGN KEY (`ItemUUID`) REFERENCES `uuitems` (`UUID`),
  ADD CONSTRAINT `collectionitem_ibfk_2` FOREIGN KEY (`CollectionID`) REFERENCES `collection` (`CollectionID`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`ImageUUID`) REFERENCES `uuitems` (`UUID`);

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`MediaUUID`) REFERENCES `uuitems` (`UUID`),
  ADD CONSTRAINT `media_ibfk_2` FOREIGN KEY (`CoverImageID`) REFERENCES `images` (`ImageID`),
  ADD CONSTRAINT `media_ibfk_3` FOREIGN KEY (`TrailerVideoID`) REFERENCES `video` (`VideoID`),
  ADD CONSTRAINT `media_ibfk_4` FOREIGN KEY (`CertificationIndex`) REFERENCES `certification` (`CertificationIndex`);

--
-- Constraints for table `media_episodecontainer`
--
ALTER TABLE `media_episodecontainer`
  ADD CONSTRAINT `media_episodecontainer_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`);

--
-- Constraints for table `media_episodes`
--
ALTER TABLE `media_episodes`
  ADD CONSTRAINT `media_episodes_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`),
  ADD CONSTRAINT `media_episodes_ibfk_2` FOREIGN KEY (`EpisodeContainerID`) REFERENCES `media_episodecontainer` (`MediaID`);

--
-- Constraints for table `media_standalone`
--
ALTER TABLE `media_standalone`
  ADD CONSTRAINT `media_standalone_ibfk_1` FOREIGN KEY (`MediaID`) REFERENCES `media` (`MediaID`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`AuthorAccountID`) REFERENCES `accounts` (`AccountID`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`AboutMediaID`) REFERENCES `media` (`MediaID`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`VideoUUID`) REFERENCES `uuitems` (`UUID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
