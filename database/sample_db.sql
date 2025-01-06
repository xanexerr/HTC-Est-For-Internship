-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 06:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tryproject2`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `workplace_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `show` tinyint(1) NOT NULL DEFAULT 1,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `show_data`
--

CREATE TABLE `show_data` (
  `workplace_name` int(11) NOT NULL,
  `work_type` int(11) NOT NULL,
  `description` int(11) NOT NULL,
  `work_tel` int(11) NOT NULL,
  `workplace_address` int(11) NOT NULL,
  `comment_text` int(11) NOT NULL,
  `workplace_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `show_data_view`
-- (See below for the actual view)
--
CREATE TABLE `show_data_view` (
`workplace_id` int(11)
,`workplace_name` varchar(255)
,`work_type` varchar(50)
,`description` text
,`work_tel` varchar(11)
,`workplace_address` varchar(255)
,`comment_text` text
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `user_fname` varchar(50) DEFAULT NULL,
  `user_lname` varchar(50) DEFAULT NULL,
  `user_tel` varchar(12) DEFAULT NULL,
  `workplace_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--


-- --------------------------------------------------------

--
-- Table structure for table `workplaces`
--

CREATE TABLE `workplaces` (
  `workplace_id` int(11) NOT NULL,
  `workplace_name` varchar(255) NOT NULL,
  `workplace_address` varchar(255) NOT NULL,
  `work_type` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `work_tel` varchar(11) DEFAULT NULL,
  `user_id` varchar(11) DEFAULT NULL COMMENT 'ผู้เพิ่ม',
  `rating` varchar(4) NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT 1,
  `map` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workplaces`
--

-- --------------------------------------------------------

--
-- Structure for view `show_data_view`
--
DROP TABLE IF EXISTS `show_data_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `show_data_view`  AS SELECT `w`.`workplace_id` AS `workplace_id`, `w`.`workplace_name` AS `workplace_name`, `w`.`work_type` AS `work_type`, `w`.`description` AS `description`, `w`.`work_tel` AS `work_tel`, `w`.`workplace_address` AS `workplace_address`, `c`.`comment_text` AS `comment_text` FROM (`workplaces` `w` left join `comments` `c` on(`w`.`workplace_id` = `c`.`workplace_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `workplace_id` (`workplace_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_workplace` (`workplace_id`);

--
-- Indexes for table `workplaces`
--
ALTER TABLE `workplaces`
  ADD PRIMARY KEY (`workplace_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `workplaces`
--
ALTER TABLE `workplaces`
  MODIFY `workplace_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7832;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`workplace_id`) REFERENCES `workplaces` (`workplace_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
