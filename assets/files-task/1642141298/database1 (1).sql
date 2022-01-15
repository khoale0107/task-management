-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 08, 2022 lúc 06:44 AM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `database1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `room` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `leader` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `departments`
--

INSERT INTO `departments` (`room`, `name`, `description`, `leader`) VALUES
('A001', 'Phòng quản trị', 'Tổ chức các cuộc họp theo quý để cập nhật tình hình về kinh doanh, và giải quyết các vấn đề về chiến lược phát triển của công ty. Trong những trường hợp khẩn cấp sẽ có cuộc họp bất thường.', ''),
('A002', 'Phòng tài chính kế toán', 'Phòng ban có trách nhiệm đảm bảo cho công ty về các chế độ như lương, thưởng, thu, chi,…', ''),
('A003', 'Phòng hành chính', 'Phòng ban có trách nhiệm về các loại văn bản, giấy tờ, hồ sơ, sổ sách trong công ty. Triển khai các nội quy của công ty, hoạt động khen thưởng, hoạt động phúc lợi.', ''),
('B001', 'Phòng nhân sự', 'Phòng ban có trách nhiệm quản lý vòng đời của nhân viên (tức là tuyển dụng, giới thiệu, đào tạo và sa thải nhân viên) và quản lý các phúc lợi của nhân viên.', ''),
('B002', 'Phòng Marketing', 'Phòng ban có trách nhiệm nghiên cứu thị trường, nghiên cứu khách hàng mục tiêu, sau đó sẽ định hướng xây dựng sản phẩm phù hợp với thị hiếu người tiêu dùng.', ''),
('B003', 'Phòng kinh doanh', 'Phòng ban có trách nhiệm cung cấp, đưa ra những sản phẩm để mở rộng thị trường và thu hút nhiều khách hàng tiềm năng mới.', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `department` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `task` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name_task` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `staff` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tasks`
--

INSERT INTO `tasks` (`department`, `task`, `name_task`, `description`, `staff`, `deadline`) VALUES
('B001', 'task001', 'Tuyển dụng nhân sự', 'Tìm nguồn ứng viên mới và đăng tin tuyển dụng.', '', '0000-00-00 00:00:00'),
('B001', 'task002', 'Tuyển dụng nhân sự', 'Tiếp nhận hồ sơ, sàng lọc hồ sơ và liên hệ với các ứng viên mới.', '', '0000-00-00 00:00:00'),
('B001', 'task003', 'Tuyển dụng nhân sự', 'Lên lịch phỏng vấn online/offline, thực hiện các bài kiểm tra đánh giá năng lực.', '', '0000-00-00 00:00:00'),
('B001', 'task004', 'Nhu cầu tuyển dụng nhân sự', 'Thu nhập báo cáo về nhu cầu và chất lượng nhân sự mà phòng ban cần tuyển.', '', '0000-00-00 00:00:00'),
('B001', 'task005', 'Kiểm kê hồ sơ', 'Kiểm tra và yêu cầu bổ sung thông tin đối với hồ sơ nhân viên bị thiếu.', '', '0000-00-00 00:00:00'),
('B001', 'task006', 'Bảo hiểm xã hội', 'Tổng hợp thông tin các nhân viên cần đăng ký BHXH.', '', '0000-00-00 00:00:00'),
('B001', 'task007', 'Đào tạo nhân sự', 'Lựa chọn phương pháp đào tạo và lên kế hoạch đào tạo.', '', '0000-00-00 00:00:00'),
('B001', 'task008', 'Đào tạo nhân sự', 'Tổ chức triển khai phương pháp đào tạo nhân sự mới.', '', '0000-00-00 00:00:00'),
('B001', 'task009', 'Đào tạo nhân sự', 'Lập báo cáo và đánh giá hiệu quả của kế hoạch đào tạo.', '', '0000-00-00 00:00:00'),
('B001', 'task010', 'Lập bảng lương tháng', 'Thống kê ngày nghỉ và thực hiện công tác chấm công.', '', '0000-00-00 00:00:00'),
('A002', 'task011', 'Lập báo cáo kế toán vốn', 'Thực hiện kế toán vốn về tài sản cố định, nguyên vật liệu, công cụ, dụng cụ.', '', '0000-00-00 00:00:00'),
('A002', 'task012', 'Lập báo cáo kế toán công nợ', 'Thực hiện kế toán công nợ đối với các khoản phí của ngân hàng.', '', '0000-00-00 00:00:00'),
('A002', 'task013', 'Lập báo cáo doanh thu', 'Tính toán doanh thu tháng của công ty. ', '', '0000-00-00 00:00:00'),
('A002', 'task014', 'Báo cáo chi phí hàng tháng', 'Báo cáo chi phí quản lý doanh nghiệp, chi phí bán hàng, chi phí nhân công.', '', '0000-00-00 00:00:00'),
('A002', 'task015', 'Lập báo cáo các khoảng phí phát sinh', 'Tính toán và báo cáo về các khoảng chi phí phát sinh tháng.', '', '0000-00-00 00:00:00'),
('B002', 'task016', 'Thiết kế ý tưởng hàng hoá', 'Lên ý tưởng thiết kế cho mặt hàng mới.', '', '0000-00-00 00:00:00'),
('B002', 'task017', 'Quảng cáo hàng hoá mới', 'Thiết kế quảng cáo cho các sản phẩm mới.', '', '0000-00-00 00:00:00'),
('B002', 'task018', 'Quảng cáo sản phẩm mới', 'Lên ý tưởng về hình thức dịch vụ tiếp thị sản phẩm mới cho khách hàng.', '', '0000-00-00 00:00:00'),
('B002', 'task019', 'Nghiên cứu thị trường', 'Lập báo cáo về các sản phẩm có triễn vọng trên thị trường.', '', '0000-00-00 00:00:00'),
('B002', 'task020', 'Nghiên cứu mục tiêu khách hàng', 'Thống kê số liệu tổng quan về các loại sản phẩm khách hàng đang hướng đến.', '', '0000-00-00 00:00:00'),
('B003', 'task021', 'Phát triển sản phẩm mới', 'Lên ý tưởng cho việc phát triển các loại sản phẩm, dịch vụ mới.', '', '0000-00-00 00:00:00'),
('B003', 'task022', 'Phát triển sản phẩm mới', 'Nghiên cứu cải tiến các sản phẩm cũ, dịch vụ đã có để đáp ứng nhu cầu của thị trường.', '', '0000-00-00 00:00:00'),
('B003', 'task023', 'Tìm nguồn cung ứng mới', 'Đưa ra danh sách các khách hàng mới có tiềm năng đối với các sản phẩm của công ty.', '', '0000-00-00 00:00:00'),
('B003', 'task024', 'Huy động nguồn vốn', 'Đưa ra chính sách cụ thể về nguồn vốn cần có để cải thiện chất lượng sản phẩm.', '', '0000-00-00 00:00:00'),
('B003', 'task025', 'Cải tiến hình thức thanh toán', 'Lên danh sách các hình thức thanh toán cần thiết cho việc mua sắm sản phẩm.', '', '0000-00-00 00:00:00'),
('A003', 'task026', 'Hợp đồng lao động', 'Đổi mới hợp đồng lao động cho các nhân viên trong công ty.', '', '0000-00-00 00:00:00'),
('A003', 'task027', 'Chính sách công ty', 'Biên soạn các chính cách, quy định chung khi làm việc trong công ty.', '', '0000-00-00 00:00:00'),
('A003', 'task028', 'Chính sách công ty', 'Cập nhật các chính sách mới về hợp đồng lao động, bảo hiểm xã hội.', '', '0000-00-00 00:00:00'),
('A001', 'task029', 'Bảo trì thiết bị', 'Lên danh sách các thiết bị cần được bảo trì hoặc thay thế mới.', '', '0000-00-00 00:00:00'),
('A001', 'task030', 'Nhập thiết bị mới', 'Lên danh sách kiểm kê các thiết bị mới được nhập khẩu về công ty.', '', '0000-00-00 00:00:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`room`);

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
