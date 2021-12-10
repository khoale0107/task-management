-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2021 at 02:22 PM
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
('51900751', '$2y$10$OwntMco8sfHkzCueRmO0c.ivpYCe9t57y3/KS9jW3GtdMdzTB8QPu', 'Khoa Võ', 'Trưởng phòng', 1, 'default_avatar.png'),
('51900752', '$2y$10$tTInCeI7DbOMZYtVNmewOeT2QmjLc5vPQRmjDYMoCR2JzyEU9t38q', 'Khoa Trần', 'Nhân viên', 1, 'default_avatar.png'),
('51900753', '$2y$10$YOH5ADKXpFGfjS1zw/eaceRADktqisJchuL.gmDufOSMVSF8KAA1C', 'Khoa Lê ', 'Nhân viên', 1, '51900753_1639142506_avatar.png'),
('51900754', '$2y$10$GF7ZV8rGBTJ75x7cp2ceu.eIBAtEk6nKaq4E32pTM5zHmzbQTXG3m', 'Khoa Phan', 'Nhân viên', 1, 'default_avatar.png'),
('51900755', '$2y$10$aZzwcbuy/dS9TQjxDgPzw.KNSkwjAk2EhRtrNBedQm0UKcxIstUb6', 'Khoa Phạm', 'Nhân viên', 1, 'default_avatar.png'),
('51900756', '$2y$10$A/GCNsHCEHm1R4ejTja26OvBf.gbo6AQkKLSW25F8weAbKpYBlJWq', 'Khoa Nguyễn', 'Nhân viên', 2, 'default_avatar.png'),
('51900757', '$2y$10$dfAU2aK7LBLSoBd3DHilceDMpSzneGaQn/jiDMYic6pI8/pmJoQuK', 'Hiếu Phan', 'Trưởng phòng', 2, 'default_avatar.png'),
('51900758', '$2y$10$H6LL0hTV9RHXelG1QGjy4e0OvF07PPY0IjQ93PxXgtTC8Jeyusfgq', 'Hiếu Huỳnh', 'Nhân viên', 2, 'default_avatar.png'),
('51900759', '$2y$10$nqoIC.zQaA8iqbib1Qfg7une0pmYOKSeb9HwodwSs06GIrjAwDTsm', 'Hiếu Nguyễn', 'Nhân viên', 1, 'default_avatar.png'),
('51900760', '$2y$10$sWEifhnHWEI8RFvObsDIdeCpHC1NAYRxhFqlmqSmdwd0VYkYiMej.', 'Hiếu Trần', 'Nhân viên', 2, 'default_avatar.png'),
('51900761', '$2y$10$vQk.HLe0rIZ9Pgmv4U2DPOMC3OKzj8Z8GlpAzxl0G63ODsTPaHxcu', 'Hiếu Phạm', 'Nhân viên', 1, 'default_avatar.png'),
('51900762', '$2y$10$bUpfKgFR0oTYV9X8iZJQA.cMcsJrrJfnu/HWqcpdwzs/4pag2CZk6', 'Hiếu Lê', 'Nhân viên', 1, 'default_avatar.png'),
('51900763', '$2y$10$xIaAz2UYolwNTexZZjehZeTJBpx1Mu16mH5nOjXxqAvbiyqesXkVS', 'Hiếu Võ', 'Nhân viên', 1, 'default_avatar.png'),
('51900764', '$2y$10$/O4htEVlwTBKwIW4MDHqh.mdtJ5NNDWLhovUowAGUwdlUqk235psO', 'Hiếu Vương', 'Nhân viên', 3, 'default_avatar.png'),
('51900765', '$2y$10$htzqYo1eR6UeLoU7tUQhJusB0XkG3fujfZH7XpA5xZs8WLbLaZ3Im', 'Hiếu Vũ', 'Nhân viên', 1, 'default_avatar.png'),
('51900766', '$2y$10$TfhtBykDliLrBR5eASQGgucJAOyDDPDMwosEFrxrcpgxCrS9fT.1S', 'Hiếu Trương', 'Nhân viên', 1, 'default_avatar.png'),
('51900767', '$2y$10$cN7HAflcXSizbEFpKmxdMuIaYF/DsGTRhUCuY2fIUphH8KN/YARF2', 'Khoa Trương', 'Nhân viên', 3, 'default_avatar.png'),
('51900768', '$2y$10$UsKdXuCSps.3zoSciJMHpO59SsOFpW/.GUrtp9uJj875SxApcbEim', 'Khoa Huỳnh', 'Trưởng phòng', 4, 'default_avatar.png'),
('51900769', '$2y$10$KUTbPEBrD79j3ETUMrRVOuTSV5z46jpZPEFQJ67TlLrJSzPgaruqi', 'Khoa Pug', 'Nhân viên', 4, 'default_avatar.png'),
('51900770', '$2y$10$LF4g5i33LsOrBWMyP1Oa6eCKcXjM2LG0mPeAIdE900WCVaY33DvY.', 'Khoa Đỗ', 'Trưởng phòng', 3, 'default_avatar.png'),
('admin', '$2y$10$GVmq3u8C4rWHnqlt6mxztuzC3iadDR5pUOZTNknRMWMx5W.737mGq', 'Admin', 'Admin', NULL, 'default_avatar.png');

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
(1, 'Phòng kinh doanh', '51900751', 'Lorem ipsum olor sit amconsectetur adipisicing elit. Rem blanditiis atque illum natus suscipit x', 2),
(2, 'Phòng tài chính', '51900757', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem blanditiis atque illum natus suscipit !', 4),
(3, 'Phòng nhân sự', '51900770', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 2),
(4, 'Phòng kỹ thuật', '51900768', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit.', 2);

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
-- Indexes for table `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk-truongphong` (`matruongphong`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- Constraints for table `phongban`
--
ALTER TABLE `phongban`
  ADD CONSTRAINT `fk-truongphong` FOREIGN KEY (`matruongphong`) REFERENCES `account` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
