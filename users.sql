-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2025 lúc 10:13 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `streestsoul_store999`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `tendangnhap` varchar(50) NOT NULL,
  `matkhau` varchar(50) NOT NULL,
  `hoten` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ngaysinh` date DEFAULT NULL,
  `phai` tinyint(1) DEFAULT 0,
  `ngaydangky` datetime NOT NULL,
  `idgroup` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `randomkey` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `tendangnhap`, `matkhau`, `hoten`, `email`, `ngaysinh`, `phai`, `ngaydangky`, `idgroup`, `active`, `randomkey`) VALUES
(1, 'anh181205', 'tuyen221204', 'phi anh', 'anhlvpps39871@gmail.com', '2005-12-18', 1, '2025-04-08 18:23:28', 0, 1, '1234567890'),
(2, 'tuyen221204', 'anh181205', 'anh phi', 'tep221204@gmail.com', '2004-12-22', 0, '2025-04-08 18:26:49', 0, 1, '0987654321'),
(24, 'teo', 'ádfasdf', 'qẻqwer', 'anhlvpps871@gmail.com', '0012-04-13', 0, '0000-00-00 00:00:00', 0, 0, ''),
(25, 'adfadf', 'dsfasdf', 'adsfasdf', 'anhlv9871@gmail.com', '1324-12-31', 1, '0000-00-00 00:00:00', 0, 0, '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tendangnhap` (`tendangnhap`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
