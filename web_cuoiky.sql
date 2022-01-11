-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2022 at 05:51 PM
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

DROP PROCEDURE IF EXISTS `response_task`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `response_task` (IN `taskid` INT, IN `username` VARCHAR(20), IN `content` TEXT, IN `file` TEXT)  BEGIN
    INSERT INTO `response`(`content`, `taskid`, `username`,`file`) VALUES (content,taskid,username,file);
    
    IF (username IN (SELECT account.username FROM account WHERE chucvu = 'Trưởng phòng')) THEN
        IF (content = "") THEN
			UPDATE task SET trangthai = 'Completed', updatetime = NOW() WHERE ID = taskid;
        ELSE
        	UPDATE task SET trangthai = 'Rejected', updatetime = NOW() WHERE ID = taskid;
        END IF;

    ELSE 
    	UPDATE task SET trangthai = 'Waiting' WHERE ID = taskid;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `test`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `test` (IN `data` TEXT)  BEGIN
	IF (data <> "") THEN
    	SIGNAL sqlstate '45000' set message_text = "data khac rong.";
    END IF;
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
('51900751', '$2y$10$AAFWHNLuXPsVAQ.vY65az./FUOxy2cd61Bixve2KgIq7quKemmflG', 'Khoa Võ ', 'Nhân viên', 1, '177ee0eed34afd29b850dc57759fc32e_avatar.png'),
('51900752', '$2y$10$tEc8qiS38K/9XMhsiAU.RuJHDPB.tiVPUBsZG8rIJc.vaxfDIpLEe', 'Khoa Trần', 'Nhân viên', 1, 'f433a4924ff2681ff5fce424a537ef81_avatar.png'),
('51900753', '$2y$10$YOH5ADKXpFGfjS1zw/eaceRADktqisJchuL.gmDufOSMVSF8KAA1C', 'Khoa Lê ', 'Trưởng phòng', 1, '8047b1a0637f6696f2e0b3a305fa3889_avatar.png'),
('51900754', '$2y$10$0it7sS7dXJoM3Q5vFdE7qe2ei3etOfKyyIE4UsSAgIERfC1XZloE6', 'Khoa Phan', 'Nhân viên', 1, '5a6001401eec210fe055abad5d307521_avatar.png'),
('51900755', '$2y$10$qyMNLJUMIJDGZGqPV4DXvOMr8NOIhDX/0qigZS7OlJfYFb971RBy6', 'Khoa Phạm', 'Nhân viên', 1, 'e34dc03dca60bda11cf62bc74d6069a5_avatar.png'),
('51900756', '$2y$10$A/GCNsHCEHm1R4ejTja26OvBf.gbo6AQkKLSW25F8weAbKpYBlJWq', 'Khoa Nguyễn', 'Nhân viên', 2, '861c71f99761063252bbdfa253d204c9_avatar.png'),
('51900757', '$2y$10$dfAU2aK7LBLSoBd3DHilceDMpSzneGaQn/jiDMYic6pI8/pmJoQuK', 'Hiếu Phan', 'Trưởng phòng', 2, '86dcb6b309d84d4ae7f1896d69b26add_avatar.png'),
('51900758', '$2y$10$vLmqoGo8u/6IdUqVSY8pZ.D6x8CIGLUvo0Tm46sVeVBD1k7FB036q', 'Hiếu Huỳnh', 'Nhân viên', 2, '1c04397ae951d23a423b0dda4de88b4d_avatar.png'),
('51900759', '$2y$10$0FVDA.e6NYSo4xzmC0iUgOrkw7SEx.h5UrJP56b9yZyy4KS4TQqBi', 'Hiếu Nguyễn ', 'Nhân viên', 1, 'default_avatar.png'),
('51900760', '$2y$10$sWEifhnHWEI8RFvObsDIdeCpHC1NAYRxhFqlmqSmdwd0VYkYiMej.', 'Hiếu Trần', 'Nhân viên', 2, '9d0651a87ee1351d42d0e6e8501ef277_avatar.png'),
('51900761', '$2y$10$vQk.HLe0rIZ9Pgmv4U2DPOMC3OKzj8Z8GlpAzxl0G63ODsTPaHxcu', 'Hiếu Phạm', 'Nhân viên', 1, 'bf371d1c43eca49b50b4b09696a725fb_avatar.png'),
('51900762', '$2y$10$9i1wlsvKYmby2PFQCnDfd.v50qqE4j35jMtj3fqbCF2B4R8EXG9lq', 'Hiếu Lê', 'Nhân viên', 1, 'default_avatar.png'),
('51900763', '$2y$10$WLsf9IhcIJ.k4wUfcL3Pu.zDiLPm71pt8WoOUh3M.LxNS3ld7X5Ga', 'Hiếu Võ', 'Nhân viên', 1, 'default_avatar.png'),
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
(33, '51900760', 2, 'abcxy', '123.txt', '2021-12-30 21:22:00', 'refused'),
(34, '51900761', 0, '', '', '2021-12-30 13:22:00', 'refused'),
(35, '51900755', 4, '123123', 'jcpicker.ini', '2021-12-30 16:05:00', 'approved'),
(37, '51900765', 2, 'toi la Hiếu Vũ', '', '2021-12-31 20:01:08', 'approved'),
(45, '51900757', 14, 'trưởng phòng Hiếu phan xin nghỉ', '', '2021-12-31 21:14:26', 'refused'),
(48, '51900759', 3, 'Hiếu Nguyễn yêu cầu nghỉ 3 ngày', 'LICENSE.txt', '2022-01-01 12:30:39', 'refused'),
(49, '51900751', 5, 'trưởng phòng Khoa Võ xin nghỉ 5 ngày', '1.png', '2022-01-01 14:32:58', 'refused'),
(51, '51900758', 5, 'Hiếu Huỳnh -51900758 nghỉ 5 ngày', '1 (9).txt', '2022-01-05 13:32:40', 'waiting'),
(52, '51900766', 3, 'Hiếu Trương 51900766', '1.txt', '2022-01-06 15:33:27', 'approved');

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
(1, 'Kinh doanh', '51900753', 'Lorem ipsum olor sit amconsectetur adipisicing elit. Rem blanditiis atque illum natus suscipit x', 2),
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

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

DROP TABLE IF EXISTS `response`;
CREATE TABLE `response` (
  `ID` int(11) NOT NULL,
  `content` text NOT NULL,
  `responsedate` datetime NOT NULL DEFAULT current_timestamp(),
  `taskid` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`ID`, `content`, `responsedate`, `taskid`, `username`, `file`) VALUES
(6, '123321', '2022-01-09 19:45:38', 3, '51900753', ''),
(7, '', '2022-01-09 19:46:15', 3, '51900753', ''),
(8, 'toi submit lai ne', '2022-01-09 20:04:46', 3, '51900751', ''),
(9, 'van chua duoc ban oi', '2022-01-09 20:05:15', 3, '51900753', ''),
(11, 'Chua duoc em oi', '2022-01-09 22:25:07', 3, '51900753', ''),
(12, 'Da em moi gui lai a', '2022-01-09 22:26:15', 3, '51900751', ''),
(14, 'mang tien ve cho me', '2022-01-10 14:08:49', 15, '51900752', ''),
(15, 'DUNG CT', '2022-01-10 14:11:31', 15, '51900752', ''),
(16, 'THAY GIAO BA', '2022-01-10 14:15:37', 15, '51900752', '1641798937/Code.png'),
(17, '123123 THAY BA', '2022-02-09 14:40:01', 15, '51900752', '1641800401/1.txt'),
(18, 'toi da reject 123123', '2022-01-10 15:56:49', 15, '51900753', ''),
(19, 'Da em moi gui lai a xem thu a', '2022-01-10 15:58:56', 15, '51900752', '1641805136/Screenshot 2021-12-14 111041.jpg'),
(20, 'thu lai response-task.php', '2022-01-10 20:27:22', 15, '51900752', '1641821242/Hethongthongtin.png'),
(21, 'thu lai response-task lan 2', '2022-01-10 20:29:39', 15, '51900752', '1641821379/'),
(22, 'test submit-file xem co nop file rong hay k', '2022-01-10 20:43:47', 23, '51900751', ''),
(23, 'test submit-file xem co nop file rong hay k Part 2', '2022-01-10 20:44:56', 23, '51900751', '1641822296/C# note (2).txt'),
(24, 'test file rong part 3', '2022-01-10 20:48:56', 23, '51900751', '1641822536/css note.txt'),
(25, 'reject khoa võ', '2022-01-10 21:43:45', 23, '51900753', '1641825825/photothumb.db'),
(26, 'submit khoa vo', '2022-01-10 21:44:57', 23, '51900751', ''),
(27, 'reject lan 2', '2022-01-10 21:45:16', 23, '51900753', ''),
(28, 'submit lan cuoi', '2022-01-10 21:45:48', 23, '51900751', '1641825948/1 (16).txt'),
(29, 'reject lan cuoi', '2022-01-10 21:46:20', 23, '51900753', ''),
(30, 'ok', '2022-01-10 21:46:38', 23, '51900751', ''),
(31, '', '2022-01-11 20:42:47', 23, '51900753', ''),
(33, '', '2022-01-11 21:21:56', 23, '51900753', ''),
(34, '', '2022-01-11 21:23:17', 23, '51900753', ''),
(35, '', '2022-01-11 21:27:52', 23, '51900753', ''),
(36, '', '2022-01-11 21:28:21', 23, '51900753', ''),
(37, '', '2022-01-11 21:38:09', 3, '51900753', ''),
(38, '', '2022-01-11 22:09:38', 3, '51900753', ''),
(39, '', '2022-01-11 22:15:23', 3, '51900753', ''),
(40, '', '2022-01-11 22:15:56', 3, '51900753', ''),
(41, '', '2022-01-11 22:19:43', 3, '51900753', ''),
(42, '', '2022-01-11 22:22:34', 23, '51900753', ''),
(43, '', '2022-01-11 22:25:23', 23, '51900753', ''),
(44, '', '2022-01-11 22:27:15', 23, '51900753', ''),
(45, '', '2022-01-11 22:27:38', 3, '51900753', ''),
(46, '', '2022-01-11 22:29:06', 23, '51900753', ''),
(47, '', '2022-01-11 22:31:01', 3, '51900753', ''),
(48, '', '2022-01-11 22:43:04', 3, '51900753', ''),
(49, '', '2022-01-11 22:43:48', 3, '51900753', ''),
(50, '', '2022-01-11 22:46:54', 23, '51900753', ''),
(51, '', '2022-01-11 22:48:06', 23, '51900753', ''),
(52, '', '2022-01-11 22:48:32', 3, '51900753', ''),
(53, '', '2022-01-11 22:51:28', 3, '51900753', ''),
(54, '', '2022-01-11 22:52:09', 3, '51900753', ''),
(55, '', '2022-01-11 22:52:16', 23, '51900753', ''),
(56, '', '2022-01-11 22:53:31', 23, '51900753', ''),
(57, '', '2022-01-11 22:53:43', 3, '51900753', ''),
(58, '', '2022-01-11 22:55:12', 3, '51900753', ''),
(59, '', '2022-01-11 23:13:54', 3, '51900753', ''),
(60, '', '2022-01-11 23:14:44', 23, '51900753', ''),
(61, '', '2022-01-11 23:15:23', 23, '51900753', ''),
(62, '', '2022-01-11 23:15:30', 3, '51900753', ''),
(63, 'submit test file rong 2 Khoa Võ', '2022-01-11 23:24:54', 24, '51900751', '1641918294/images.jpg'),
(64, 'submit lai di em', '2022-01-11 23:33:48', 24, '51900753', '1641918828/GetAmped (4).ico'),
(65, 'submit lan 2', '2022-01-11 23:35:34', 24, '51900751', ''),
(66, '', '2022-01-11 23:38:57', 24, '51900753', '');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `ID` int(11) NOT NULL,
  `tieude` text NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `trangthai` text NOT NULL DEFAULT 'New',
  `updatetime` datetime NOT NULL DEFAULT current_timestamp(),
  `duedate` datetime NOT NULL,
  `mota` text NOT NULL,
  `file` text NOT NULL,
  `rating` text NOT NULL,
  `ngaylap` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`ID`, `tieude`, `username`, `trangthai`, `updatetime`, `duedate`, `mota`, `file`, `rating`, `ngaylap`) VALUES
(3, 'task 3', '51900751', 'Completed', '2022-01-11 23:17:14', '2022-01-06 13:36:00', 'Lorem ipsum dolor sit amet consecteturg23423423423 adipisicing elit. Aut omnis eos officia, veniam exercitationem nulla at ad quis nostrum totam, error ducimus odit optio dicta suscipit consequatur possimus soluta. Dignissimos.', '1641548286/1.jpg', 'OK', '2022-01-11 23:18:41'),
(13, 'task1', '51900762', 'New', '2022-01-06 17:31:35', '2022-01-20 17:30:00', 'Lorem ipsum234234234 dolor sit amet consectetur adipisicing elit. Aut omnis eos officia, veniam exercitationem nulla at ad quis nostrum totam, error ducimus odit optio dicta suscipit consequatur possimus soluta. Dignissimos.', '1641465095/1.txt', '', '2022-01-11 23:18:41'),
(14, 'task2', '51900762', 'New', '2022-01-07 00:04:47', '2022-01-13 00:04:00', 'Lorem ipsu23423423m dolor sit amet consectetur adipisicing elit. Aut omnis eos officia, veniam exercitationem nulla at ad quis nostrum totam, error ducimus odit optio dicta suscipit consequatur possimus soluta. Dignissimos.', '1641488687/keel_clazz.dll', '', '2022-01-11 23:18:41'),
(15, 'task of Khoa Trần', '51900752', 'In progress', '2022-01-07 16:38:06', '2022-01-21 16:37:00', 'asdsad khoa trần345345345', '1641548286/1.jpg', '', '2022-01-11 23:18:41'),
(16, '123123', '51900763', 'New', '2022-01-07 17:55:16', '2022-01-22 17:55:00', '123123', '1641552915/unins000.dat', '', '2022-01-11 23:18:41'),
(17, 'aasd', '51900763', 'New', '2022-01-07 17:57:45', '2022-01-07 21:57:00', 'asd', '1641553065/photothumb.db', '', '2022-01-11 23:18:41'),
(18, '123', '51900763', 'New', '2022-01-07 17:59:19', '2022-01-22 17:59:00', '123', '1641553159/scraputil.dll', '', '2022-01-11 23:18:41'),
(19, 'asad', '51900766', 'New', '2022-01-07 18:00:52', '2022-01-21 18:00:00', 'asd', '1641553252/photothumb.db', '', '2022-01-11 23:18:41'),
(20, 'asd', '51900765', 'New', '2022-01-07 18:02:05', '2022-01-19 18:01:00', 'asd', '1641553325/scraputil.dll', '', '2022-01-11 23:18:41'),
(21, '123', '51900763', 'In progress', '2022-01-07 18:05:01', '2022-01-28 18:04:00', '123', '1641553501/voice.dll', '', '2022-01-11 23:18:41'),
(22, 'Lập báo cáo kế toán công nợ', '51900758', 'In progress', '2022-01-09 19:19:06', '2022-01-11 19:18:00', 'Thực hiện kế toán công nợ đối với các khoản phí của ngân hàng.', '1641730746/database1.sql', '', '2022-01-11 23:18:41'),
(23, 'test file rong', '51900751', 'Completed', '2022-01-10 20:38:39', '2022-01-13 21:46:00', 'test file rỗng', '1641821919/', 'Good', '2022-01-11 23:18:41'),
(24, 'test file rong  2', '51900751', 'Completed', '2022-01-11 23:38:57', '2022-01-10 23:33:00', '2qwqeq', '', 'OK', '2022-01-11 23:18:41'),
(25, 'test file rong  3', '51900751', 'Canceled', '2022-01-11 23:21:59', '2022-02-04 21:34:00', '132123', '1641825248/Code.png', '', '2022-01-11 23:18:41');

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
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk-response-task` (`taskid`),
  ADD KEY `fk-response-account` (`username`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk-task-account` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nghiphep`
--
ALTER TABLE `nghiphep`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `phongban`
--
ALTER TABLE `phongban`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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

--
-- Constraints for table `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `fk-response-account` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-response-task` FOREIGN KEY (`taskid`) REFERENCES `task` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk-task-account` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
