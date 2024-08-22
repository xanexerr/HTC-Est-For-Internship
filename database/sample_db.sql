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

INSERT INTO `comments` (`comment_id`, `user_id`, `workplace_id`, `comment_text`, `rating`, `comment_time`, `show`, `img`) VALUES
(58, '64209010015', 74, 'มายูน่าร้ากก งู้ยๆๆ', 5, '2024-01-23 16:11:23', 1, '../img/1851054153.jpg'),
(59, '64209010014', 74, 'เสื้อแดงหล่อจริง ลูกค้าคนนี้คอนเฟิร์ม', 5, '2024-01-23 16:19:49', 1, '../img/243261854.jpg'),
(60, '64209010006', 7827, 'สนุกดีพี่ ที่ฝึกงานให้ทำอะไรหลายๆอย่าง เฟรนลี่มากๆ', 5, '2024-01-23 17:52:37', 1, '../img/819127245.jpg'),
(61, '64209010003', 7827, 'ไก่อร่อยมาก\r\n', 5, '2024-01-24 01:51:27', 1, NULL),
(62, '64209010020', 7828, '', 5, '2024-01-24 03:00:25', 1, NULL),
(64, '64209010001', 7829, 'สบายมากก', 5, '2024-01-24 04:10:48', 1, '../img/2110434625.jpg'),
(66, '64209010002', 7830, 'ไม่เหมาะสำหรับคนที่รับแรงกดดันได้ไม่เยอะ', 3, '2024-01-24 05:44:08', 1, NULL),
(67, '64209010017', 7830, 'ได้ความรู้ดีได้ประสบการณ์', 3, '2024-01-24 05:49:34', 1, NULL),
(68, '64209010004', 74, 'รับมือกับลูกค้าเยอะมากๆ', 4, '2024-01-24 05:52:18', 1, NULL),
(69, '64209010018', 74, 'พี่ๆที่ฝึกงานน่ารัก งานไม่หนักแต่เหนื่อยกับลูกค้า', 4, '2024-01-24 05:56:41', 1, NULL),
(71, '64209010007', 7829, 'ได้ความรู้ ให้คําปรึกษาดี เป็นกันเองสุดๆ', 1, '2024-01-24 06:10:49', 1, '../img/951009030.jpg'),
(72, '64209010008', 7831, '', 4, '2024-01-24 06:26:43', 1, '../img/1324736204.jpg'),
(73, '64209010013', 7829, 'เวลานอนเยอะ', 5, '2024-01-24 06:51:49', 1, NULL),
(74, '64209010019', 7830, 'เจ้าของร้านทำรายเด็กฝึกงาน ชอบดุชอบด่า อย่าไปนะครับ ', 3, '2024-01-24 07:36:05', 1, NULL);

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

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `user_fname`, `user_lname`, `user_tel`, `workplace_id`) VALUES
('111', '111', '1', 'student', 'Natthapumin', 'Klammat', '1', NULL),
('222', '222', '222', 'student', 'Nattha2', 'Klam2', NULL, NULL),
('6406', '6406', '6406', 'student', 'NNNNN', 'KKKKK', NULL, 74),
('64209010001', '64209010001', '64209010001', 'student', 'กชพรรณ', 'รักคุ้ม', NULL, 7829),
('64209010002', '64209010002', '64209010002', 'student', 'กฤษณพงษ์  ', 'แก้วหล้า', NULL, 7830),
('64209010003', '64209010003', '64209010003', 'student', 'กันตินันท์', 'ศรีสุวรรณ์', NULL, 7827),
('64209010004', '64209010004', '64209010004', 'student', 'จินห์จุฑา', 'ปราบสงคราม', NULL, 74),
('64209010006', '64209010006', '64209010006', 'student', 'Natthapumin', 'Klammat', NULL, 7827),
('64209010007', '64209010007', '11', 'student', 'ณัฐสิทธิ', 'อินริสพงศ์', '0642259362', 7829),
('64209010008', '64209010008', '64209010008', 'student', 'ทนงศักดิ์', 'ปะโปตินัง', NULL, 7831),
('64209010010', '64209010010', '64209010010', 'student', 'ทักษ์ดนัย', 'เกิดลาภ', NULL, NULL),
('64209010011', '64209010011', '1', 'teacher', 'Thanachart', 'Namcharoen', '0123456789', NULL),
('64209010012', '64209010012', '64209010012', 'student', 'ธนวรรณ์', 'คงแก้วสี', NULL, NULL),
('64209010013', '64209010013', '64209010013', 'student', 'ธนากร', 'แซ่เก๊ก', NULL, 7829),
('64209010014', '64209010014', '1', 'student', 'Thiraphat', 'Saetang', '123456789', 74),
('64209010015', '64209010015', '64209010015', 'student', 'ธีรวัฒน์', 'หนูรอด', NULL, 74),
('64209010016', '64209010016', '64209010016', 'student', 'นิพิฐพนธ์', 'หมัดศรี', NULL, NULL),
('64209010017', '64209010017', '64209010017', 'student', 'ปรียานุช', 'อารมณฤทธิ์', NULL, 7830),
('64209010018', '64209010018', '64209010018', 'student', 'ปรียาพร', 'นิลแก้วดี', NULL, 74),
('64209010019', '64209010019', '64209010019', 'student', 'ปัณฑิมา', 'บุญรอง', NULL, 7830),
('64209010020', '64209010020', '64209010020', 'student', 'ปุณพงศ์', 'อรัญดร', NULL, 7828),
('admin', 'admin', '1', 'admin', 'Administrator', '001', '001', NULL);

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

INSERT INTO `workplaces` (`workplace_id`, `workplace_name`, `workplace_address`, `work_type`, `description`, `work_tel`, `user_id`, `rating`, `show`, `map`) VALUES
(74, 'D.P Computer ', '99 / 29 ถนนราษฎร์ยินดี ตำบลหาดใหญ่ อำเภอหาดใหญ่ จังหวัดสงขลา 90110', 'ด้านบริการ', 'ซ่อม และประกอบคอมพิวเตอร์', '087 290 975', '64209010014', '4.25', 1, 'https://www.google.com/maps/search/dp+computer/@7.012293,100.4491077,12.75z?entry=ttu'),
(76, 'หจก. ที เอ คอมพิวเตอร์ \r\n', '21/1  ถนน เพชรเกษม  ต.หาดใหญ่  อ.หาดใหญ่ จ.สงขลา 90110 \r\n', 'ด้านบริการ', 'ขายคอมพิวเตอร์และอุปกรณ์คอมพิวเตอร์', '074258354', '', '', 1, ''),
(81, 'บริษัท เอมิ.โปร จำกัด', '652/8 ถนนเพชรเกษม ต.คอหงส์ อ.หาดใหญ่ จ.สงขลา 90110\r\n', 'ด้านบริการ', 'จำหน่าย-ให้เช่าคอมพิวเตอร์และอุปกรณ์', '074365454', '', '', 1, ''),
(82, '289 IT Service', '124 ถนนทุ่งเสา 2 ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110\r\n', 'ด้านบริการ', 'ร้านขายคอมพิวเตอร์', '0862896655', '', '', 1, ''),
(83, 'ฟิกซ์ แอนด์ เซอร์วิส \r\n', '368  ถนน พลพิชัย-บ้านพรุ  ต.คอหงส์  อ.หาดใหญ่ จ.สงขลา 90110 \r\n', 'ด้านบริการ', 'รับติดตั้งซ่อมแซม บำรุงรักษาเครื่องมือเครื่องใช้เกี่ยวกับระบบงานไฟฟ้า', '0994929889', '', '', 1, ''),
(84, 'I dol design', '103 ซอย 7 ราษฎร์ยินดี (คลองเรียน 1) อ.หาดใหญ่ จ.สงขลา 90110', 'ทำกราฟิก', 'ออกแบบสื่อสิ่งพิมพ์โฆษณา งานออกบูธ และงานป้ายทุกชนิด', '0869563608', NULL, '', 1, ''),
(85, 'ห้างหุ้นส่วนสามัญนิติบุคคล ศรีเฉลิม ดีไซน์ แอนด์ ปริ้นติ้ง', '333/77 หมู่ที่ 4 ต.คลองแห อ.หาดใหญ่ จ.สงขลา 90110', 'ทำเว็บไซต์', 'ทำเว็บไซต์ให้ห้าง', '089-7564956', NULL, '', 1, ''),
(86, 'บริษัท ไอที เวอร์เทคซ์ (ไทยแลนด์) จำกัด', '26/6 ถนนราษฎร์ยินดี ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'ระบบเครือข่าย', 'ทำเซิร์ฟเวอร์', '081-6097979', NULL, '', 1, ''),
(87, 'หจก. พิมพ์นิยม ปริ้นติ้ง', '23/25 ถนน โชติวิทยะกุล 2  ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'ด้านบริการ', 'ปริ้นท์งาน', '074-559519', NULL, '', 1, ''),
(88, 'พิมพการ บ้านกราฟิค', '859/23 ถนนเพชรเกษม ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'ทำกราฟิก', 'ออกแบบกราฟิก', '087-2123322', NULL, '', 1, ''),
(89, 'บริษัท ยูนิตี้ ไอที ซิสเต็ม จำกัด', 'แอดไวซ์ สาขา U055 (ก่อนถึงสามแยกธนาคารทหารไทย) 377,379-379/1 ถนนไทรบุรี ต.บ่อยาง อ.เมืองสงขลา จ.สงขลา 90000\r\n', 'ด้านบริการ', 'ขายสินค้า', '084-3008897', NULL, '', 1, ''),
(90, 'บริษัท อเลค-เทค เอ็นจิเนียริ่ง จำกัด', '121 ซอย 10 (เพชรเกษม) ถนนเพชรเกษม ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'เขียนโปรแกรม', 'Front-end Developer', '089-9223723', NULL, '', 1, ''),
(91, 'องค์การบริหารส่วนตำบลนาหม่อม', 'หมู่ 5 ต.นาหม่อม อ.นาหม่อม จ.สงขลา 90310', 'ทำเว็บไซต์', 'ทำเว็บไซต์องค์การบริหาร', '074-3830121', NULL, '', 1, ''),
(92, 'ร้าน เอกอุดม พริ้นติง', '6/27 ถ. นิพัทธ์สงเคราะห์ 1 ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'ด้านบริการ', 'ปริ้นท์งาน', '093-6465624', NULL, '', 1, ''),
(93, 'ท่าอากาศยานหาดใหญ่', '99 หมู่ 3 ตำบลคลองหลา อำเภอคลองหอยโข่ง จังหวัดสงขลา 90115', 'ทำกราฟิก', 'ทำกราฟิกโปรโมท', '074-227001-', NULL, '', 1, ''),
(94, 'ร้าน Core - it (คอ ไอที)', '204 ถนนราษฎร์บูรณะ ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'ด้านบริการ', 'ขายสินค้า', '084-9954997', NULL, '', 1, ''),
(95, 'แอดไซน์กราฟฟิค แอนด์ พริ้นติ้ง', '259 ถนนคลองเรียน 1 ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'ทำกราฟิก', 'ออกบบกราฟิก', '062-9644966', NULL, '', 1, ''),
(96, 'บริษัท พอช ครีเอชั่น จำกัด', '5 ถนนภาษีเจริญ 1 ต.บ้านพรุ อ.หาดใหญ่ จ.สงขลา 90250', 'เขียนโปรแกรม', 'Front-end Developer', '095-4382218', NULL, '', 1, ''),
(97, 'มรกต ดิจิตอล แอนด์ สตูดิโอ', '541/45 ถนนนครนายก ต.บ่อยาง อ.เมือง จ.สงขลา 90000', 'ทำกราฟิก', 'ถ่ายและตกแต่งภาพ', '091-0481468', NULL, '', 1, ''),
(7827, 'บริษัท บ้านเรา คอร์ปอเรชั่น จำกัด', '200/25 หมู่ที่ 4 ตำบลคลองแห อำเภอหาดใหญ่ จ.สงขลา 90110', 'ทำเว็บไซต์', 'เขียนเว็บ ทำ content ต่างๆ ', '0858975000', '64209010006', '5', 1, 'https://maps.app.goo.gl/oen8wgx9xduMY2xh9'),
(7828, 'MB IT Service', 'เลขที่ 108 ถนน โชติวิทยะกุล 3 ตำบล หาดใหญ่ อำเภอหาดใหญ่ สงขลา 90110', 'ด้านบริการ', 'ซ่อมคอมพิวเตอร์ โน๊ตบุ๊ค', '0847536352', '64209010020', '5', 1, 'https://maps.app.goo.gl/TvSRfgHPChpPzzeo7'),
(7829, '88 Comtech.it', '218 1 ถ. ประชาธิปัตย์ ตำบล หาดใหญ่ อำเภอหาดใหญ่ สงขลา 90110', 'ด้านบริการ', 'ซ่อมคอม', '0743432134', '64209010001', '4', 1, 'https://maps.app.goo.gl/KqFVJ2vZ94mryEZW7'),
(7830, 'O.K. work', '97/4 ถ.ราษฎร์ยินดี ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110 โทร:074-800704 เทศบาลนครหาดใหญ่ 90110', 'ด้านบริการ', 'ซ่อมคอม', '0805456397', '64209010002', '3', 1, 'https://www.google.com/maps/dir/?api=1&destination=7.003040550749%2C100.4803776741&fbclid=IwAR0Cwr7muslOZkcaUNGZCkYPj_jWktHALTa-F2CEjse7E1jaVcaYgOPYcC4'),
(7831, 'JZ computer and network ', '96 ซอย นวลแก้ว ถนน นวลแก้วอุทิศ  ต.หาดใหญ่  อ.หาดใหญ่ จ.สงขลา 90110', 'ระบบเครือข่าย', 'ติดอินเตอร์เน็ต ติดกล้อง', '0954381504', '64209010008', '4', 1, 'https://www.google.com/maps/place/Jz+Computer+And+Network/@7.0283966,100.4794691,15z/data=!4m2!3m1!1s0x0:0x486fa3f32eec54b7?sa=X&ved=2ahUKEwiCrcyJsfWDAxXVTmwGHdYjChwQ_BJ6BAg_EAA');

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
