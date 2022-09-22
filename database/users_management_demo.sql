-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th9 22, 2022 lúc 08:08 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `users_management_demo`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login_token`
--

CREATE TABLE `login_token` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `login_token`
--

INSERT INTO `login_token` (`id`, `userID`, `token`, `reateAt`) VALUES
(88, 89, '8f9c39c712583753075125a4bddc436e002bd4a4', '2022-09-22 14:50:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotToken` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activeToken` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `lastActivity` datetime DEFAULT NULL,
  `createAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `email`, `fullname`, `phone`, `password`, `forgotToken`, `activeToken`, `status`, `lastActivity`, `createAt`, `updateAt`) VALUES
(73, 'huy6688@gmail.com', ' huy ', '07084930000', '$2y$10$W2MCSs3nfn8NTg05RXNyR.chqR6Yt5EUGzqz017yHmwdRfzCI0sOS', NULL, NULL, 1, NULL, '2022-09-16 14:14:09', '2022-09-17 11:43:55'),
(74, 'nguyenvanB6688@gmail.com', 'nguyen van B', '07084930679', '$2y$10$W2MCSs3nfn8NTg05RXNyR.chqR6Yt5EUGzqz017yHmwdRfzCI0sOS', NULL, NULL, 1, NULL, '2022-09-16 14:14:09', '2022-09-17 11:43:55'),
(75, 'nguyenvanA6688@gmail.com', 'nguyen van A', '07084930001', '$2y$10$W2MCSs3nfn8NTg05RXNyR.chqR6Yt5EUGzqz017yHmwdRfzCI0sOS', NULL, NULL, 1, NULL, '2022-09-16 14:14:09', '2022-09-17 11:43:55'),
(76, 'nguyenvananh6688@gmail.com', 'nguyen van anh ', '07084930002', '$2y$10$W2MCSs3nfn8NTg05RXNyR.chqR6Yt5EUGzqz017yHmwdRfzCI0sOS', NULL, NULL, 1, NULL, '2022-09-16 14:14:09', '2022-09-17 11:43:55'),
(77, 'nguyenvanbinh6688@gmail.com', 'nguyen van binh', '07084930003', '$2y$10$W2MCSs3nfn8NTg05RXNyR.chqR6Yt5EUGzqz017yHmwdRfzCI0sOS', NULL, NULL, 0, NULL, '2022-09-16 14:14:09', '2022-09-17 11:43:55'),
(78, 'nguyenvanBa6688@gmail.com', 'nguyen van Ba', '07084930004', '$2y$10$W2MCSs3nfn8NTg05RXNyR.chqR6Yt5EUGzqz017yHmwdRfzCI0sOS', NULL, NULL, 0, NULL, '2022-09-16 14:14:09', '2022-09-17 11:43:55'),
(79, 'nguyenvanAn6688@gmail.com', 'nguyen van An', '07084930005', '$2y$10$W2MCSs3nfn8NTg05RXNyR.chqR6Yt5EUGzqz017yHmwdRfzCI0sOS', NULL, NULL, 1, NULL, '2022-09-16 14:14:09', '2022-09-17 11:43:55'),
(80, 'tanaka12345@gmail.com', 'tanaka', '07084930679', '$2y$10$FjsuU3yAa7mEuMcR1l01Puld8Puic0ns5.eP88nMTKgaiiCY2zLX.', NULL, NULL, 1, NULL, '2022-09-18 18:39:12', NULL),
(81, 'nakamura1632@gmail.com', 'naka mura', '07084930679', '$2y$10$N8VXLtkWG1wQOs6JZMmF/O3yj6MZXAyFv5EySDpmTaVLcMKTgOmbW', NULL, NULL, 0, NULL, '2022-09-18 18:43:54', NULL),
(82, 'nhungcutcho12423@gmail.com', 'Nguyễn Thị Hồng anh', '07084930679', '$2y$10$ze/cLLTSVeNLcNAIAEIb8e9S/F1oOgz5onY/whnXdcrXBjsnyROpS', NULL, NULL, 0, NULL, '2022-09-18 18:47:18', '2022-09-19 10:38:18'),
(83, 'levanan@gmail.com', 'Lê văn An 1', '07084930670', '$2y$10$/KVSY8ogu3N6JimbCZPJPeQsqksrvH/gUNOrr2Z3mb64VJOwJRA/G', NULL, NULL, 0, NULL, '2022-09-18 18:50:06', '2022-09-19 10:38:42'),
(87, 'lenguyentronghuy6688@gmail.com', ' le trong huy', '07084930679', '$2y$10$VP725R9f/u9SNneTeaG/tO8cmyJ8Ypwmz.N1kHrJnLTyyLCPckZba', NULL, NULL, 1, '2022-09-22 14:46:15', '2022-09-19 11:33:49', NULL),
(88, 'levantam12345@gmail.com', 'Lê văn Tam', '07084930679', '$2y$10$MboVxURPAhQOgmIHZqq22eMhRoZncGIk0sbJZb/emTFdZrl0jAXOa', NULL, NULL, 1, NULL, '2022-09-19 13:12:19', NULL),
(89, 'tanaka@gmail.com', 'ta na ka ', '07084930679', '$2y$10$/te/hxr.5l4CwMKzBoKDiebiSGqXIuCz/LsTw9i1H7QfPYJoKkO8K', NULL, NULL, 1, '2022-09-22 14:52:02', '2022-09-21 18:16:55', '2022-09-21 19:42:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `login_token`
--
ALTER TABLE `login_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `login_token`
--
ALTER TABLE `login_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `login_token`
--
ALTER TABLE `login_token`
  ADD CONSTRAINT `login_token_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
