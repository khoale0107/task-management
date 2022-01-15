-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2022 at 10:15 AM
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
DROP DATABASE IF EXISTS web_cuoiky;
CREATE DATABASE IF NOT EXISTS `web_cuoiky` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_cuoiky`;

DELIMITER $$
--
-- Procedures
--
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
('51900751', '$2y$10$EnkGKOD7t3HDO7A4u4y9BO4Bph7KWJcTVBR9fZx.kTbbsj04KQnhO', 'Hoàng Ân', 'Nhân viên', 1, 'e0960dd9d4b6a95447c069b71b8b2578_avatar.png'),
('51900752', '$2y$10$WE06DLr1ljMu9frPCP2nieGw5ycqfIC.yrOC/m/CewBkalePx7QM.', 'Duy Bảo', 'Nhân viên', 1, 'f433a4924ff2681ff5fce424a537ef81_avatar.png'),
('51900753', '$2y$10$wJsispdE0zYKgteSAJSCIew1VevDf2yj1FbfrkTWIhAobr4XuW01m', 'Khoa Lê', 'Trưởng phòng', 1, '8047b1a0637f6696f2e0b3a305fa3889_avatar.png'),
('51900754', '$2y$10$y.YX66Al.II2QzKCjeMcaeQAUxqJAteK2kP9ORd3pSQy88KLqO/Ou', 'Quốc Bảo', 'Nhân viên', 1, '5a6001401eec210fe055abad5d307521_avatar.png'),
('51900755', '$2y$10$GggCjLeGeIOLKIUsoiExZOTvhAKe3WlMdwHoNpBYVk5zQ.IkZmc5y', 'Thanh Bình', 'Nhân viên', 1, 'e34dc03dca60bda11cf62bc74d6069a5_avatar.png'),
('51900756', '$2y$10$UG3PNXMom9MLt1umdNG0O.pF652SJdXZgMcwiSwoWQrDyzOoBLZcq', 'Ngọc  Châu', 'Trưởng phòng', 2, '861c71f99761063252bbdfa253d204c9_avatar.png'),
('51900757', '$2y$10$Wad4C8vst/.alZZuh4GOzuhnEpWlm4vnSHIsrukVtdE9i8qpUYK22', 'Linh Chi', 'Nhân viên', 2, '86dcb6b309d84d4ae7f1896d69b26add_avatar.png'),
('51900758', '$2y$10$yxGL7JV.qe8kn1eitXaMT.bLbKT8agz8SfTXo7L1CqzV8VOomju/e', 'Hữu Chiến', 'Nhân viên', 2, '1c04397ae951d23a423b0dda4de88b4d_avatar.png'),
('51900759', '$2y$10$DQD4Ecoz2gsSdWKVYVXjK.PCt7Wqt5p8TKoGgYQJ/pNcgZPTCtgB6', 'Nhật Cường', 'Nhân viên', 2, 'b766f41243e494f32958f3b1bd17adf8_avatar.png'),
('51900760', '$2y$10$nfPmDT/iiD.AmTo.F6FMF.ljggEEbk3xhKUq.a/B1Z0b/biJ7qvzW', 'Thanh Dung', 'Nhân viên', 2, '9d0651a87ee1351d42d0e6e8501ef277_avatar.png'),
('51900761', '$2y$10$C20EVZIyRPXPfSCEZEVYHekWPUFZscbZviQIRtZInCfkq12C7WAOa', 'Anh Đức', 'Trưởng phòng', 3, 'bf371d1c43eca49b50b4b09696a725fb_avatar.png'),
('51900762', '$2y$10$RPqiZkR1Zm.DzkUK05YCf.jwIqNytcLKGVV5qhpzcpNEol7zs1eXK', 'Trường Giang', 'Nhân viên', 3, 'default_avatar.png'),
('51900763', '$2y$10$dQPMNo2L/GfPeiS4tREAY.4uvmZKI0w.fe9Y9y04wrxhJ1sMxb8mq', 'Ngọc Hân', 'Nhân viên', 3, 'default_avatar.png'),
('51900764', '$2y$10$VZmasXa04BPfd7LwIF34AuRg/vSDesHHIoNoX47UoEKaIQGCu84Im', 'Thu Hiền', 'Nhân viên', 3, 'default_avatar.png'),
('51900765', '$2y$10$ZAdZiocBlr0llNtSxwhzX.3J0uQHEXcHT8cZOs1xWhACnX50Jo33q', 'Quốc  Khang', 'Nhân viên', 3, 'default_avatar.png'),
('51900766', '$2y$10$QHvg9ixHfwyuDgaGc42sdu1cleoleWyPuquG7cUoRdyzxaWNGL.3K', 'Trung Kiên', 'Trưởng phòng', 4, '7e1ef3b615838daee8b145cf6ba3ac15_avatar.png'),
('51900767', '$2y$10$akBpPhgJMjF2sdoqEjBO3.OHqCI2gPhNdRBoAJ.1CE7beL.uNocC.', 'Hoàng Minh', 'Nhân viên', 4, 'default_avatar.png'),
('51900768', '$2y$10$f5UtkymvTCuZUs.Y4dDSlOK5GVpneMIsDDKm8OQ7rAQl62keYO3tW', 'Hoài Nam', 'Nhân viên', 4, 'default_avatar.png'),
('51900769', '$2y$10$EOTivwtv7.H.ZCiHy.x7Cuabxlc3K/eL4i1Vf1HmxYIrcIuLLFaR2', 'Quốc Thắng', 'Nhân viên', 4, 'default_avatar.png'),
('51900770', '$2y$10$hty64onBESIuqO/EXdM7yem7Ki1MTmkIClUhG4xHZi.MwARsoODKC', 'Phước Vinh', 'Nhân viên', 4, 'default_avatar.png'),
('admin', '$2y$10$dwfOQLxHgyjmCm2pf9.c0u6sa6AExakQJweO6oMtzXQy2SvuCFkBy', 'Admin', 'Admin', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `nghiphep`
--

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
(56, '51900766', 1, 'đi tiêm vaccin mũi 1', '', '2022-01-14 21:49:48', 'waiting'),
(57, '51900761', 1, 'đi tiêm vaccin mũi 3', '', '2022-01-14 21:50:21', 'waiting'),
(58, '51900753', 14, 'dương tính covid-19', 'testcovid.png', '2022-01-14 21:52:22', 'approved'),
(59, '51900751', 1, 'đi khám bệnh', 'Screenshot 2021-10-29 191307.jpg', '2022-01-14 21:58:01', 'waiting'),
(60, '51900767', 12, 'đi cách ly covid', 'cachly.png', '2022-01-14 22:01:50', 'waiting'),
(61, '51900762', 1, 'đưa con đi khám bệnh', '', '2022-01-14 22:03:15', 'refused');

-- --------------------------------------------------------

--
-- Table structure for table `phongban`
--

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
(1, 'Kinh doanh', '51900753', 'Phòng ban có trách nhiệm cung cấp, đưa ra những sản phẩm để mở rộng thị trường và thu hút nhiều khách hàng tiềm năng mới.', 4),
(2, 'Tài chính kế toán', '51900756', 'Phòng ban có trách nhiệm đảm bảo cho công ty về các chế độ như lương, thưởng, thu, chi,…', 3),
(3, 'Nhân sự', '51900761', 'Phòng ban có trách nhiệm quản lý vòng đời của nhân viên (tức là tuyển dụng, giới thiệu, đào tạo và sa thải nhân viên) và quản lý các phúc lợi của nhân viên.', 3),
(4, 'Marketing', '51900766', 'Phòng ban có trách nhiệm nghiên cứu thị trường, nghiên cứu khách hàng mục tiêu, sau đó sẽ định hướng xây dựng sản phẩm phù hợp với thị hiếu người tiêu dùng.', 3);

--
-- Triggers `phongban`
--
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
(71, 'đã huy động nguồn vốn', '2022-01-14 20:39:01', 33, '51900754', '1642167541/citation-221409577.ris'),
(72, 'Một số hình thức thanh toán thương mại điện tử phổ biến hiện nay.\r\nThanh toán bằng thẻ Thanh toán bằng thẻ là một trong những phương thức thanh toán khá phổ biến ở Việt Nam hiện nay. ...\r\nThanh toán bằng séc trực tuyến. ...\r\nThanh toán bằng ví điện tử ...\r\nThanh toán qua điện thoại di động. ...\r\nThanh toán qua chuyển khoản ngân hàng.', '2022-01-14 20:40:42', 35, '51900755', '1642167642/LICENSE (5).txt'),
(73, '', '2022-01-14 20:41:29', 35, '51900753', ''),
(74, 'Cần đưa ra chính sách cụ thể', '2022-01-14 20:43:31', 33, '51900753', ''),
(75, 'Báo cáo công nợ', '2022-01-14 20:48:21', 38, '51900758', '1642168101/congno.png'),
(76, 'doanh thu tháng của cty', '2022-01-14 20:52:31', 39, '51900759', '1642168351/doanhthu.png'),
(77, '', '2022-01-14 20:56:43', 39, '51900756', ''),
(78, 'báo cáo chấm công', '2022-01-14 21:32:32', 30, '51900764', '1642170752/chamcong.png'),
(79, 'báo cáo nghiên cứu thị trường', '2022-01-14 21:38:54', 45, '51900770', '1642171134/thitruong.npg.png'),
(80, '', '2022-01-14 21:40:14', 45, '51900766', ''),
(81, 'đây là số liệu thống kê', '2022-01-14 21:43:42', 46, '51900767', '1642171422/solieusanpham.png'),
(82, 'cần thống kê chi tiết hơn', '2022-01-14 21:44:55', 46, '51900766', '1642171495/Hethongthongtin.png');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

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
(26, 'Tuyển dụng nhân sự - lần 1', '51900762', 'In progress', '2022-01-14 21:29:54', '2022-01-16 23:59:00', 'Tìm nguồn ứng viên mới và đăng tin tuyển dụng.', '1642139963/Code.png', '', '2022-01-14 12:59:23'),
(27, 'Kiểm kê hồ sơ', '51900763', 'In progress', '2022-01-14 21:34:45', '2022-01-18 23:59:00', 'Kiểm tra và yêu cầu bổ sung thông tin đối với hồ sơ nhân viên bị thiếu.', '1642140103/css note.txt', '', '2022-01-14 13:01:43'),
(28, 'Bảo hiểm xã hội', '51900764', 'New', '2022-01-14 13:06:32', '2022-01-17 17:00:00', 'Tổng hợp thông tin các nhân viên cần đăng ký BHXH.', '', '', '2022-01-14 13:06:32'),
(29, 'Tuyển dụng nhân sự - lần 2', '51900762', 'Canceled', '2022-01-14 13:07:45', '2022-01-25 17:00:00', 'Tiếp nhận hồ sơ, sàng lọc hồ sơ và liên hệ với các ứng viên mới.', '', '', '2022-01-14 13:07:41'),
(30, 'Lập bảng lương tháng', '51900764', 'Waiting', '2022-01-14 21:32:18', '2022-01-18 23:59:00', 'Thống kê ngày nghỉ và thực hiện công tác chấm công.', '', '', '2022-01-14 13:09:15'),
(31, 'Phát triển sản phẩm mới - đợt 1', '51900751', 'In progress', '2022-01-14 20:31:49', '2022-01-15 23:59:00', 'Lên ý tưởng cho việc phát triển các loại sản phẩm, dịch vụ mới.', '1642140762/Hethongthongtin.png', '', '2022-01-14 13:12:42'),
(32, 'Tìm nguồn cung ứng mới', '51900752', 'New', '2022-01-14 13:14:00', '2022-01-20 23:59:00', 'Đưa ra danh sách các khách hàng mới có tiềm năng đối với các sản phẩm của công ty.', '1642140840/Code.png', '', '2022-01-14 13:14:00'),
(33, 'Huy động nguồn vốn', '51900754', 'Rejected', '2022-01-14 20:43:31', '2022-02-04 20:43:00', 'Đưa ra chính sách cụ thể về nguồn vốn cần có để cải thiện chất lượng sản phẩm.', '1642140923/1.txt', '', '2022-01-14 13:15:23'),
(34, 'Phát triển sản phẩm mới - đợt 2', '51900751', 'Canceled', '2022-01-14 13:17:16', '2022-02-15 23:59:00', 'Nghiên cứu cải tiến các sản phẩm cũ, dịch vụ đã có để đáp ứng nhu cầu của thị trường.', '', '', '2022-01-14 13:16:21'),
(35, 'Cải tiến hình thức thanh toán', '51900755', 'Completed', '2022-01-14 20:41:29', '2022-01-20 23:59:00', 'Lên danh sách các hình thức thanh toán cần thiết cho việc mua sắm sản phẩm.', '', 'Good', '2022-01-14 13:18:04'),
(36, 'Thiết kế ý tưởng hàng hoá', '51900757', 'Canceled', '2022-01-14 13:20:25', '2022-01-18 23:59:00', 'Lên ý tưởng thiết kế cho mặt hàng mới.', '1642141185/Code.png', '', '2022-01-14 13:19:45'),
(37, 'Lập báo cáo kế toán vốn', '51900757', 'In progress', '2022-01-14 20:46:11', '2022-01-22 17:00:00', 'Thực hiện kế toán vốn về tài sản cố định, nguyên vật liệu, công cụ, dụng cụ.', '1642141298/database1 (1).sql', '', '2022-01-14 13:21:38'),
(38, 'Lập báo cáo kế toán công nợ', '51900758', 'Waiting', '2022-01-14 20:46:32', '2022-01-25 23:59:00', 'Thực hiện kế toán công nợ đối với các khoản phí của ngân hàng.', '1642141345/photothumb.db', '', '2022-01-14 13:22:25'),
(39, 'Lập báo cáo doanh thu', '51900759', 'Completed', '2022-01-14 20:56:43', '2022-01-27 23:30:00', 'Tính toán doanh thu tháng của công ty.', '', 'OK', '2022-01-14 13:23:13'),
(40, 'Báo cáo chi phí hàng tháng', '51900759', 'In progress', '2022-01-14 20:50:23', '2022-01-28 17:30:00', 'Báo cáo chi phí quản lý doanh nghiệp, chi phí bán hàng, chi phí nhân công.', '', '', '2022-01-14 13:23:43'),
(41, 'Lập báo cáo các khoảng phí phát sinh', '51900760', 'New', '2022-01-14 13:24:22', '2022-02-01 23:59:00', 'Tính toán và báo cáo về các khoảng chi phí phát sinh tháng.', '', '', '2022-01-14 13:24:22'),
(42, 'Thiết kế ý tưởng hàng hoá', '51900767', 'Canceled', '2022-01-14 21:41:02', '2022-01-18 20:25:00', 'Lên ý tưởng thiết kế cho mặt hàng mới.', '1642166766/images (1) (1).jpg', '', '2022-01-14 20:26:06'),
(43, 'Quảng cáo hàng hoá mới', '51900768', 'New', '2022-01-14 20:26:54', '2022-01-27 20:26:00', 'Thiết kế quảng cáo cho các sản phẩm mới.', '', '', '2022-01-14 20:26:54'),
(44, 'Quảng cáo sản phẩm mới', '51900769', 'New', '2022-01-14 20:27:28', '2022-01-28 20:27:00', 'Lên ý tưởng về hình thức dịch vụ tiếp thị sản phẩm mới cho khách hàng.', '1642166848/1 (5).png', '', '2022-01-14 20:27:28'),
(45, 'Nghiên cứu thị trường', '51900770', 'Completed', '2022-01-14 21:40:14', '2022-01-12 20:27:00', 'Lập báo cáo về các sản phẩm có triễn vọng trên thị trường.', '1642166891/database1.sql', 'Bad', '2022-01-14 20:28:11'),
(46, 'Nghiên cứu mục tiêu khách hàng', '51900767', 'Rejected', '2022-01-14 21:44:55', '2022-01-28 20:28:00', 'Thống kê số liệu tổng quan về các loại sản phẩm khách hàng đang hướng đến.', '', '', '2022-01-14 20:29:09');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `phongban`
--
ALTER TABLE `phongban`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
