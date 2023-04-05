-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2023 at 02:48 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cis1202_premid_peteros`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(12) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `birthdate` date NOT NULL,
  `level` int(11) NOT NULL,
  `rank_id` int(11) DEFAULT NULL,
  `wins` int(11) NOT NULL,
  `losses` int(11) NOT NULL,
  `draws` int(11) NOT NULL,
  `account_type` enum('admin','player') NOT NULL DEFAULT 'player',
  `status` enum('active','locked','inactive','terminated') NOT NULL,
  `registration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(12) NOT NULL,
  `name` varchar(35) NOT NULL,
  `type` enum('CONTROLLER','DUELIST','INITIATOR','SENTINEL') NOT NULL,
  `1st_skill` varchar(35) NOT NULL,
  `2nd_skill` varchar(35) NOT NULL,
  `3rd_skill` varchar(35) NOT NULL,
  `ultimate_skill` varchar(35) NOT NULL,
  `img_loc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `type`, `1st_skill`, `2nd_skill`, `3rd_skill`, `ultimate_skill`, `img_loc`) VALUES
(1, 'KAY/O', 'INITIATOR', 'FRAG/MENT', 'FLASH/DRIVE', 'ZERO/POINT', 'NULL/CMD', 'img/agents/kay-o.jpeg'),
(2, 'NEON', 'DUELIST', 'FAST LANE', 'RELAY BOLT', 'HIGH GEAR', 'OVERDRIVE', 'img/agents/neon.jpeg'),
(3, 'OMEN', 'CONTROLLER', 'SHROUDED STEP', 'PARANOIA', 'DARK COVER', 'FROM THE SHADOWS', 'img/agents/omen.jpeg'),
(4, 'PHOENIX', 'DUELIST', 'BLAZE', 'CURVEBALL', 'HOT HANDS', 'RUN IT BACK', 'img/agents/phoenix.jpeg'),
(5, 'REYNA', 'DUELIST', 'LEER', 'DEVOUR', 'DISMISS', 'EMPRESS', 'img/agents/reyna.jpeg'),
(6, 'SAGE', 'SENTINEL', 'BARRIER ORB', 'SLOW ORB', 'HEALING ORB', 'RESURRECTION', 'img/agents/sage.jpeg'),
(7, 'KILLJOY', 'SENTINEL', 'NANOSWARM', 'ALARMBOT', 'TURRET', 'LOCKDOWN', 'img/agents/killjoy.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `map_id` int(11) NOT NULL,
  `mode` enum('unrated','competitive','swiftplay','spike rush','deathmatch','escalation','custom game') NOT NULL,
  `attacker_id` int(11) NOT NULL,
  `defender_id` int(11) NOT NULL,
  `winner` enum('attacker','defender','draw') NOT NULL,
  `status` enum('pending','processed','cancelled') NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE `maps` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` longtext NOT NULL,
  `img_loc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maps`
--

INSERT INTO `maps` (`id`, `name`, `description`, `img_loc`) VALUES
(1, 'FRACTURE', 'A top secret research facility split apart by a failed radianite experiment. With\ndefender options as divided as the map, the choice is yours: meet the attackers\non their own turf or batten down the hatches to weather the assault.', 'img/maps/fracture.jpeg'),
(2, 'BREEZE', 'Take in the sights of historic ruins or seaside caves on this tropical paradise.\nBut bring some cover. You\'ll need them for the wide open spaces and long\nrange engagements. Watch your flanks and this will be a Breeze.', 'img/maps/breeze.jpeg'),
(3, 'ICEBOX', 'Your next battleground is a secret Kingdom excavation site overtaken by the\narctic. The two plant sites protected by snow and metal require some horizontal\nfinesse. Take advantage of the ziplines and they’ll never see you coming.', 'img/maps/icebox.jpeg'),
(4, 'BIND', 'Two sites. No middle. Gotta pick left or right. What’s it going to be then? Both\noffer direct paths for attackers and a pair of one-way teleporters make it easier\nto flank.', 'img/maps/bind.jpeg'),
(5, 'HAVEN', 'Beneath a forgotten monastery, a clamour emerges from rival Agents clashing\nto control three sites. There’s more territory to control, but defenders can use\nthe extra real estate for aggressive pushes.', 'img/maps/haven.jpeg'),
(6, 'SPLIT', 'If you want to go far, you’ll have to go up. A pair of sites split by an elevated\ncenter allows for rapid movement using two rope ascenders. Each site is built\nwith a looming tower vital for control. Remember to watch above before it all\nblows sky-high.', 'img/maps/split.jpeg'),
(7, 'ASCENT', 'An open playground for small wars of position and attrition divide two sites on\nAscent. Each site can be fortified by irreversible bomb doors; once they’re\ndown, you’ll have to destroy them or find another way. Yield as little territory\nas possible.', 'img/maps/ascent.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `id` int(12) NOT NULL,
  `name` varchar(128) NOT NULL,
  `matchmaking_rating` int(11) NOT NULL,
  `img_loc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `name`, `matchmaking_rating`, `img_loc`) VALUES
(1, 'IRON 1', 5, 'img/ranks/iron1.jpeg'),
(2, 'IRON 2', 7, 'img/ranks/iron2.jpeg'),
(3, 'IRON 3', 10, 'img/ranks/iron3.jpeg'),
(4, 'BRONZE 1', 15, 'img/ranks/bronze1.jpeg'),
(5, 'BRONZE 2', 20, 'img/ranks/bronze2.jpeg'),
(6, 'BRONZE 3', 25, 'img/ranks/bronze3.jpeg'),
(7, 'SILVER 1', 30, 'img/ranks/silver1.jpeg'),
(8, 'SILVER 2', 35, 'img/ranks/silver2.jpeg'),
(9, 'SILVER 3', 40, 'img/ranks/silver3.jpeg'),
(10, 'GOLD 1', 45, 'img/ranks/gold1.jpeg'),
(11, 'GOLD 2', 50, 'img/ranks/gold2.jpeg'),
(12, 'GOLD 3', 55, 'img/ranks/gold3.jpeg'),
(13, 'PLATINUM 1', 60, 'img/ranks/platinum1.jpeg'),
(14, 'PLATINUM 2', 65, 'img/ranks/platinum2.jpeg'),
(15, 'PLATINUM 3', 70, 'img/ranks/platinum3.jpeg'),
(16, 'DIAMOND 1', 75, 'img/ranks/diamond1.jpeg'),
(17, 'DIAMOND 2', 80, 'img/ranks/diamond2.jpeg'),
(18, 'DIAMOND 3', 85, 'img/ranks/diamond3.jpeg'),
(19, 'IMMORTAL 1', 90, 'img/ranks/immortal1.jpeg'),
(20, 'IMMORTAL 2', 95, 'img/ranks/immortal2.jpeg'),
(21, 'IMMORTAL 3', 98, 'img/ranks/immortal3.jpeg'),
(22, 'RADIANT', 100, 'img/ranks/radiant.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
