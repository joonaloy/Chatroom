-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12.02.2024 klo 11:59
-- Palvelimen versio: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatroom`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `groupchat`
--

CREATE TABLE `groupchat` (
  `name` varchar(24) NOT NULL,
  `groupID` varchar(255) NOT NULL,
  `users` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`users`)),
  `inviteID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `groupchat`
--

INSERT INTO `groupchat` (`name`, `groupID`, `users`, `inviteID`) VALUES
('test', 'a7e7f12c610ee20bf6a87c44761abe82', '[{\"userID\": \"13\"}, \"{\\\"userID\\\":\\\"11\\\"}\", {\"userID\": \"11\"}]', '9f0b68cc0a5d3d563b351dbb2a7db2b1'),
('nätti group', 'c5905ce5de2cf27101520194756b1f97', '[{\"userID\": \"12\"}, {\"userID\": \"13\"}, {\"userID\": \"13\"}]', 'bc9ff57fee5348ce59e4bbe358df45e1');

-- --------------------------------------------------------

--
-- Rakenne taululle `message`
--

CREATE TABLE `message` (
  `MessageID` int(11) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `RecipentID` varchar(100) NOT NULL,
  `Text` varchar(2001) NOT NULL,
  `Timesent` datetime NOT NULL DEFAULT current_timestamp(),
  `File` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `message`
--

INSERT INTO `message` (`MessageID`, `SenderID`, `RecipentID`, `Text`, `Timesent`, `File`) VALUES
(1, 10, '9', 'koira', '2024-02-09 13:28:00', NULL),
(2, 10, '9', 'koira', '2024-02-09 13:28:45', NULL),
(3, 10, '9', 'koira', '2024-02-09 13:29:21', NULL),
(4, 10, '9', 'koira', '2024-02-09 13:29:48', NULL),
(5, 10, '9', 'koira', '2024-02-09 13:30:06', NULL),
(6, 11, '12', 'koira', '2024-02-09 13:34:52', NULL),
(7, 11, '12', '', '2024-02-09 13:41:55', NULL),
(8, 12, '11', 'fdfdsfd', '2024-02-09 13:51:58', NULL),
(9, 11, '12', 'tapa ittes', '2024-02-09 14:01:37', NULL),
(10, 11, '12', 'tapa ittes', '2024-02-09 14:01:54', NULL),
(11, 12, '6', 'dadsadsadsadas', '2024-02-09 14:04:32', NULL),
(12, 11, '9', 'dhabshdbwdwadwadwadwad', '2024-02-09 14:08:21', NULL),
(13, 9, '12', 'OLEN KOIRA', '2024-02-09 14:10:32', NULL),
(14, 13, '11', 'TAPA ITTES', '2024-02-09 14:12:58', NULL),
(15, 12, '13', 'oot vitun koira ong', '2024-02-09 14:42:42', NULL),
(16, 13, '12', 'on foenem grave et sano tota irl', '2024-02-09 14:42:59', NULL),
(17, 11, '13', 'VITTU SÄ OOT KOIRA', '2024-02-12 09:13:48', NULL),
(18, 13, 'a7e7f12c610ee20bf6a87c44761abe82', 'testtttdsadasdas', '2024-02-12 10:37:11', NULL),
(19, 11, 'a7e7f12c610ee20bf6a87c44761abe82', 'dwadwaddddwdawda', '2024-02-12 11:03:33', NULL),
(20, 13, 'c5905ce5de2cf27101520194756b1f97', 'tesadsasadsadsa', '2024-02-12 11:06:45', NULL);

-- --------------------------------------------------------

--
-- Rakenne taululle `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `picture`) VALUES
(1, 'test1', '$2y$10$7.FYE0z3GNQoHWWZh2/wp.M7zfbXlGkEQG1pX4rOsenXjFf/EHzG2', ''),
(4, 'test1d', '$2y$10$9GjGbJ4Nw8g97HWGJzJk4uQgLUNlRZYHNI7DiSG5gKqISQge0iPii', ''),
(6, 'test1ddd', '$2y$10$HHhfuPdMH2nErpzqEfbroecz2W1Z4W2W8ryXAIOkSmw2ztylxIN5G', ''),
(8, 'test1dddd', '$2y$10$n9jhNXVDyl6VwMqlxztmKOTmj3kxJ8W9.AHiA6MN3UAtZ3DH1AxXi', ''),
(9, 'koira', '$2y$10$y5UxxrctZ1M11zn872rzq.8XQ4OG7ewojMKTk16YjksJKyVw250T2', ''),
(10, 'test2', '$2y$10$hvQgHJak9Dj3K99u/5ZPS.suiBeMyP/e323JxRFVI/5493lyOGXkm', ''),
(11, 'chattest1', '$2y$10$2Nstgx0CQ.1aJSH8ARNTeuyRyIVK6IDxlsduusNr3aJNlqKpMnS02', ''),
(12, 'chattest2', '$2y$10$VPIWIU3E8iUGKg4azHVqAu2uPUcQ1U6cbxuEqouthahExKoO4wuBm', ''),
(13, 'joona', '$2y$10$UlMAvsEOMiL/tkzBz3TwwePaV6x9YZv9kEqV1I1oK0v1kMcZVlFta', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groupchat`
--
ALTER TABLE `groupchat`
  ADD UNIQUE KEY `groupID` (`groupID`),
  ADD UNIQUE KEY `inviteID` (`inviteID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MessageID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
