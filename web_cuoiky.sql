-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2022 at 08:23 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_cuoiky`
--
CREATE DATABASE IF NOT EXISTS `web_cuoiky` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_cuoiky`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `bo_nhiem_truong_phong`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `bo_nhiem_truong_phong` (IN `manv` VARCHAR(20))  BEGIN
DECLARE idphongban INT;

SELECT maphongban
INTO idphongban
FROM account
WHERE username = manv;

UPDATE account set chucvu = 'Nhân viên' WHERE username IN (SELECT matruongphong FROM phongban WHERE ID = idphongban);

UPDATE account set chucvu = 'Trưởng phòng' WHERE username = manv ;

UPDATE phongban set matruongphong = manv WHERE id = idphongban;



END$$

DROP PROCEDURE IF EXISTS `xin_nghi_phep`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `xin_nghi_phep` (IN `manv` VARCHAR(20), IN `songay` TINYINT, IN `lydo` TEXT, IN `file` TEXT)  BEGIN
	IF (EXISTS (SELECT * FROM nghiphep WHERE username = manv AND trangthai = 'waiting')) THEN 
		SIGNAL sqlstate '45000' set message_text = "Không thể tạo đơn mới vì bạn có đơn khác đang chờ duyệt.";
    END IF;
    
    IF (EXISTS (SELECT * FROM nghiphep WHERE username = manv AND DATE_ADD(ngaylap,INTERVAL 7 DAY) > NOW())) THEN 
		SIGNAL sqlstate '45000' set message_text = "Ít nhất 7 ngày sau khi được duyệt đơn mới có thể tạo đơn khác.";
    END IF;
    
    INSERT INTO nghiphep (`username`, `songay`, `lydo`, `file`) VALUES (manv,songay,lydo,file);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `hoten` varchar(50) NOT NULL,
  `chucvu` varchar(20) NOT NULL DEFAULT 'Nhân viên',
  `maphongban` smallint(6) DEFAULT NULL,
  `avatar` text NOT NULL DEFAULT 'default_avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`username`, `password`, `hoten`, `chucvu`, `maphongban`, `avatar`) VALUES
('51900751', '$2y$10$AAFWHNLuXPsVAQ.vY65az./FUOxy2cd61Bixve2KgIq7quKemmflG', 'Khoa Võ', 'Trưởng phòng', 1, 'fc5c699a27f5cc4e48d496e5c351549c_avatar.png'),
('51900752', '$2y$10$tTInCeI7DbOMZYtVNmewOeT2QmjLc5vPQRmjDYMoCR2JzyEU9t38q', 'Khoa Trần', 'Nhân viên', 1, '0fa1ebd1ec241c8a6db5b532d0c1607e_avatar.png'),
('51900753', '$2y$10$YOH5ADKXpFGfjS1zw/eaceRADktqisJchuL.gmDufOSMVSF8KAA1C', 'Khoa Lê ', 'Nhân viên', 1, '00661c5fd8977f6191332e42f9d604d7_avatar.png'),
('51900754', '$2y$10$0it7sS7dXJoM3Q5vFdE7qe2ei3etOfKyyIE4UsSAgIERfC1XZloE6', 'Khoa Phan', 'Nhân viên', 1, 'e608a2f52da846f00ad2e0a5200b7cb5_avatar.png'),
('51900755', '$2y$10$qyMNLJUMIJDGZGqPV4DXvOMr8NOIhDX/0qigZS7OlJfYFb971RBy6', 'Khoa Phạm', 'Nhân viên', 1, 'default_avatar.png'),
('51900756', '$2y$10$A/GCNsHCEHm1R4ejTja26OvBf.gbo6AQkKLSW25F8weAbKpYBlJWq', 'Khoa Nguyễn', 'Nhân viên', 2, '04aa6d8cd248daeb3f356079a9f4bda1_avatar.png'),
('51900757', '$2y$10$dfAU2aK7LBLSoBd3DHilceDMpSzneGaQn/jiDMYic6pI8/pmJoQuK', 'Hiếu Phan', 'Trưởng phòng', 2, 'default_avatar.png'),
('51900758', '$2y$10$vLmqoGo8u/6IdUqVSY8pZ.D6x8CIGLUvo0Tm46sVeVBD1k7FB036q', 'Hiếu Huỳnh', 'Nhân viên', 2, 'default_avatar.png'),
('51900759', '$2y$10$0FVDA.e6NYSo4xzmC0iUgOrkw7SEx.h5UrJP56b9yZyy4KS4TQqBi', 'Hiếu Nguyễn ', 'Nhân viên', 1, 'default_avatar.png'),
('51900760', '$2y$10$sWEifhnHWEI8RFvObsDIdeCpHC1NAYRxhFqlmqSmdwd0VYkYiMej.', 'Hiếu Trần', 'Nhân viên', 2, 'default_avatar.png'),
('51900761', '$2y$10$vQk.HLe0rIZ9Pgmv4U2DPOMC3OKzj8Z8GlpAzxl0G63ODsTPaHxcu', 'Hiếu Phạm', 'Nhân viên', 1, '09a7349202ed2f5c90660f61289fe729_avatar.png'),
('51900762', '$2y$10$bUpfKgFR0oTYV9X8iZJQA.cMcsJrrJfnu/HWqcpdwzs/4pag2CZk6', 'Hiếu Lê', 'Nhân viên', 1, 'default_avatar.png'),
('51900763', '$2y$10$xIaAz2UYolwNTexZZjehZeTJBpx1Mu16mH5nOjXxqAvbiyqesXkVS', 'Hiếu Võ', 'Nhân viên', 1, 'default_avatar.png'),
('51900764', '$2y$10$/O4htEVlwTBKwIW4MDHqh.mdtJ5NNDWLhovUowAGUwdlUqk235psO', 'Hiếu Vương', 'Nhân viên', 3, 'default_avatar.png'),
('51900765', '$2y$10$XalpRsdDV2MF3kCzboQnNeEeDZvJBc.pOa/gnDQcXZb5KmsBFF0Gu', 'Hiếu Vũ', 'Nhân viên', 1, 'default_avatar.png'),
('51900766', '$2y$10$EY9N2JUfzA2wk.8Gel3ZTefbPAxBQ9WY5fmdp2mZWTy1KdI2OkGQy', 'Hiếu Trương', 'Nhân viên', 1, 'default_avatar.png'),
('51900767', '$2y$10$cN7HAflcXSizbEFpKmxdMuIaYF/DsGTRhUCuY2fIUphH8KN/YARF2', 'Khoa Trương', 'Nhân viên', 3, 'default_avatar.png'),
('51900768', '$2y$10$e3i1Yx19dKq1EfV9DmXhUOHtDyw8ezxKDjhiJb9hUZub3o3cjZYWe', 'Khoa Huỳnh', 'Trưởng phòng', 4, 'default_avatar.png'),
('51900769', '$2y$10$KUTbPEBrD79j3ETUMrRVOuTSV5z46jpZPEFQJ67TlLrJSzPgaruqi', 'Khoa Pug', 'Nhân viên', 4, 'default_avatar.png'),
('51900770', '$2y$10$LF4g5i33LsOrBWMyP1Oa6eCKcXjM2LG0mPeAIdE900WCVaY33DvY.', 'Khoa Đỗ', 'Trưởng phòng', 3, 'default_avatar.png'),
('admin', '$2y$10$dwfOQLxHgyjmCm2pf9.c0u6sa6AExakQJweO6oMtzXQy2SvuCFkBy', 'Admin', 'Admin', NULL, 'default_avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `nghiphep`
--

DROP TABLE IF EXISTS `nghiphep`;
CREATE TABLE `nghiphep` (
  `ID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `songay` tinyint(4) NOT NULL,
  `lydo` text NOT NULL,
  `file` text NOT NULL,
  `ngaylap` datetime NOT NULL DEFAULT current_timestamp(),
  `trangthai` text NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nghiphep`
--

INSERT INTO `nghiphep` (`ID`, `username`, `songay`, `lydo`, `file`, `ngaylap`, `trangthai`) VALUES
(15, '51900752', 1, '1', '1', '2021-12-30 00:00:00', 'refused'),
(16, '51900752', 1, '1', '1', '2021-12-30 00:00:00', 'approved'),
(21, '51900753', 1, '2asd', '', '2021-12-08 05:30:00', 'refused'),
(22, '51900753', 1, 'JavaScript, theo phiên bản hiện hành, là một ngôn ngữ lập trình thông dịch được phát triển từ các ý niệm nguyên mẫu. Ngôn ngữ này được dùng rộng rãi cho các trang web cũng như phía máy chủ. Wikipedia', '', '2021-12-30 02:17:00', 'refused'),
(24, '51900753', 2, 'tao thik 4', '', '2021-12-30 14:52:00', 'approved'),
(29, '51900753', 1, 'tao thik 9', 'GetAmped.ico', '2021-12-30 07:32:00', 'approved'),
(30, '51900754', 1, 'lý do 1', 'keel_gl.dll', '2021-12-29 12:46:00', 'approved'),
(31, '51900754', 1, 'lý do 2', '', '2021-12-30 23:11:00', 'approved'),
(32, '51900754', 1, 'lý do 1', '', '2021-12-30 20:51:00', 'refused'),
(33, '51900760', 2, 'abcxy', '123.txt', '2021-12-30 21:22:00', 'waiting'),
(34, '51900761', 0, '', '', '2021-12-30 13:22:00', 'refused'),
(35, '51900755', 4, '123123', 'jcpicker.ini', '2021-12-30 16:05:00', 'approved'),
(36, '51900751', 1, 'asd', '', '2021-12-30 21:33:00', 'approved'),
(37, '51900765', 2, 'toi la Hiếu Vũ', '', '2021-12-31 20:01:08', 'approved'),
(38, '51900766', 2, 'tôi là Hiếu Trương', '', '2021-12-31 20:01:46', 'approved'),
(39, '51900756', 1, 'tôi là 51900756 Khoa Nguyễn', '', '2021-12-31 20:32:25', 'waiting'),
(45, '51900757', 14, 'trưởng phòng Hiếu phan xin nghỉ', '', '2021-12-31 21:14:26', 'refused'),
(48, '51900759', 3, 'Hiếu Nguyễn yêu cầu nghỉ 3 ngày', 'LICENSE.txt', '2022-01-01 12:30:39', 'refused');

-- --------------------------------------------------------

--
-- Table structure for table `phongban`
--

DROP TABLE IF EXISTS `phongban`;
CREATE TABLE `phongban` (
  `ID` smallint(6) NOT NULL,
  `tenphongban` varchar(20) NOT NULL,
  `matruongphong` varchar(20) DEFAULT NULL,
  `mota` varchar(255) NOT NULL,
  `sophong` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phongban`
--

INSERT INTO `phongban` (`ID`, `tenphongban`, `matruongphong`, `mota`, `sophong`) VALUES
(1, 'Kinh doanh', '51900751', 'Lorem ipsum olor sit amconsectetur adipisicing elit. Rem blanditiis atque illum natus suscipit x', 2),
(2, 'Tài chính', '51900757', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem blanditiis atque illum natus suscipit !', 4),
(3, 'Nhân sự', '51900770', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 2),
(4, 'Kỹ thuật', '51900768', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit.', 2);

--
-- Triggers `phongban`
--
DROP TRIGGER IF EXISTS `bo_nhiem_truong_phong`;
DELIMITER $$
CREATE TRIGGER `bo_nhiem_truong_phong` AFTER UPDATE ON `phongban` FOR EACH ROW BEGIN
	IF (NEW.matruongphong <=> NULL OR NEW.matruongphong <=> '') THEN 
    UPDATE account set chucvu="Nhân viên" WHERE username = OLD.matruongphong;
    ELSEIF (NEW.matruongphong NOT IN  (SELECT username FROM account WHERE maphongban = NEW.ID)) THEN
        SIGNAL sqlstate '45000' set message_text = "Nhân viên không thuộc về phòng ban này";
    ELSE 
    UPDATE account set chucvu="Nhân viên" WHERE username = OLD.matruongphong;
    UPDATE account set chucvu="Trưởng phòng" WHERE username = NEW.matruongphong;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`),
  ADD KEY `fk-account-phongban` (`maphongban`) USING BTREE;

--
-- Indexes for table `nghiphep`
--
ALTER TABLE `nghiphep`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk-truongphong` (`matruongphong`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nghiphep`
--
ALTER TABLE `nghiphep`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `phongban`
--
ALTER TABLE `phongban`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `fk-account-phongban` FOREIGN KEY (`maphongban`) REFERENCES `phongban` (`ID`);

--
-- Constraints for table `nghiphep`
--
ALTER TABLE `nghiphep`
  ADD CONSTRAINT `nghiphep_ibfk_1` FOREIGN KEY (`username`) REFERENCES `account` (`username`);

--
-- Constraints for table `phongban`
--
ALTER TABLE `phongban`
  ADD CONSTRAINT `fk-truongphong` FOREIGN KEY (`matruongphong`) REFERENCES `account` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
