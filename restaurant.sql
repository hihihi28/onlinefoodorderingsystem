-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 19, 2025 lúc 05:33 PM
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
-- Cơ sở dữ liệu: `restaurant`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `catName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `itemName`, `price`, `image`, `quantity`, `catName`, `email`, `total_price`) VALUES
(5, 'Bò hầm rau củ', 350000, 'bo-ham.jpg', 1, 'Món chính', 'admin@gmail.com', 350000),
(6, 'Sinh tố dâu', 70000, 'strawberry-drink.png', 1, 'Đồ uống', 'admin@gmail.com', 70000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menucategory`
--

CREATE TABLE `menucategory` (
  `catId` int(11) NOT NULL,
  `catName` varchar(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menucategory`
--

INSERT INTO `menucategory` (`catId`, `catName`, `dateCreated`) VALUES
(1, 'Món khai vị', '2025-04-16 12:31:55'),
(2, 'Món chính', '2025-04-16 12:31:55'),
(4, 'Đồ uống', '2025-04-16 12:33:18'),
(5, 'Món tráng miệng', '2025-04-17 06:53:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menuitem`
--

CREATE TABLE `menuitem` (
  `itemId` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `catName` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `status` enum('Available','Unavailable','','') DEFAULT 'Available',
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime NOT NULL,
  `is_popular` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menuitem`
--

INSERT INTO `menuitem` (`itemId`, `itemName`, `catName`, `price`, `status`, `description`, `image`, `dateCreated`, `updatedDate`, `is_popular`) VALUES
(1, 'Súp khoai tây', 'Món khai vị', 150000, 'Available', 'Món súp kem mềm mịn, được nấu từ khoai tây nghiền nhuyễn cùng sữa hoặc kem, có thêm thịt xông khói hoặc phô mai để tăng hương vị béo ngậy và thơm ngon', 'sup-khoai-tay.jpg', '2025-04-17 07:07:37', '2025-04-17 14:07:37', 1),
(2, 'Mỳ Ý sốt bò bằm', 'Món chính', 80000, 'Available', 'Món ăn hấp dẫn với sợi mỳ mềm mại, kết hợp với sốt bò bằm thơm ngon, đậm đà', 'my-y.jpg', '2025-04-17 07:26:27', '2025-04-17 14:26:27', 1),
(3, 'Bánh táo', 'Món tráng miệng', 50000, 'Available', 'Món tráng miệng thơm ngon với lớp vỏ giòn vàng ruộm bao bọc phần nhân táo mềm ngọt, chua nhẹ và đậm đà hương quế.', 'index-banhtao.jpg', '2025-04-17 07:40:47', '2025-04-17 14:40:47', 0),
(4, 'Bánh mì bơ tỏi', 'Món khai vị', 55000, 'Available', ' Thơm ngon, giòn rụm, kết hợp giữa bánh mì nướng vàng ruộm với lớp bơ béo ngậy hòa quyện cùng vị tỏi dậy mùi', 'garlic-bread.avif', '2025-04-18 03:52:48', '2025-04-18 10:52:48', 1),
(5, 'Cá hồi áp chảo ', 'Món chính', 250000, 'Available', 'Món cá được nướng trên chảo, có da giòn và thịt mềm, thường được ướp gia vị đơn giản như muối, tiêu và chanh', 'ca-hoi-ap-chao.jpg', '2025-04-18 03:56:29', '2025-04-18 10:56:29', 1),
(6, 'Bánh kem dâu', 'Món tráng miệng', 60000, 'Available', 'Bánh kem tươi ngon, béo ngậy cùng với hương vị dâu tây thơm ngon hòa quyện', 'mousse-dau-1.jpg', '2025-04-18 03:59:17', '2025-04-18 10:59:17', 1),
(7, ' Salad cá ngừ', 'Món khai vị', 140000, 'Available', 'Món ăn kết hợp cá ngừ đóng hộp với rau xanh, cà chua, dưa chuột, và sốt mayonaise, tạo nên một món ăn nhẹ và bổ dưỡng', 'saladca.jpg', '2025-04-18 04:02:54', '2025-04-18 11:02:54', 1),
(8, 'Bít tết', 'Món chính', 450000, 'Available', 'Món thịt bò được nướng hoặc áp chảo, thường là phần thăn hoặc sườn, có lớp ngoài giòn, bên trong mềm và mọng nước', 'bit-tet.jpg', '2025-04-18 04:06:51', '2025-04-18 06:04:18', 1),
(9, 'Rượu vang đỏ', 'Đồ uống', 180000, 'Available', 'Loại rượu được làm từ nho đỏ hoặc đen, có màu sắc đậm và hương vị phong phú, từ chua đến ngọt', 'ruouvang.webp', '2025-04-18 04:10:46', '2025-04-18 06:07:48', 0),
(10, 'Bánh crepe', 'Món tráng miệng', 106000, 'Available', 'Món bánh mỏng, mềm, thường được làm từ bột mì, trứng và sữa, có thể ăn kèm với các loại nhân ngọt như trái cây, kem, hoặc nhân mặn như phô mai và thịt', 'banh-crepe.jpg', '2025-04-18 04:10:46', '2025-04-18 06:07:48', 0),
(11, 'Súp bí đỏ', 'Món khai vị', 85000, 'Available', ' Món canh mịn, ngọt tự nhiên từ bí đỏ, thường được nấu cùng với hành, tỏi, kem và gia vị, tạo nên hương vị ấm áp, nhẹ nhàng và thơm ngon', 'sup-bi.jpg', '2025-04-18 04:14:28', '2025-04-18 06:11:54', 0),
(12, 'Bò hầm rau củ', 'Món chính', 350000, 'Available', 'Món ăn bao gồm thịt bò được hầm mềm cùng với các loại rau củ như cà rốt, khoai tây, hành tây và gia vị, tạo nên một món ăn đậm đà, bổ dưỡng và dễ ăn', 'bo-ham.jpg', '2025-04-18 04:14:28', '2025-04-18 06:11:54', 1),
(13, 'Bánh su kem', 'Món tráng miệng', 45000, 'Available', 'Món bánh nhẹ, vỏ ngoài giòn và rỗng, bên trong chứa kem mềm mịn, thường làm từ nhân kem vani, sữa hoặc socola, mang đến hương vị ngọt ngào và thơm ngon', 'su-kem.jpg', '2025-04-18 04:18:17', '2025-04-18 06:14:56', 0),
(14, 'Matcha đá xay', 'Đồ uống', 110000, 'Available', 'Đồ uống làm từ bột trà matcha xanh pha với đá xay, tạo nên một thức uống mát lạnh, thơm ngon và đậm đà vị trà xanh', 'mattcha.jpg', '2025-04-18 04:18:17', '2025-04-18 06:14:56', 1),
(15, 'Nước cam tươi', 'Đồ uống', 55000, 'Available', 'Làm từ cam tươi, có vị ngọt tự nhiên và chua nhẹ, giàu vitamin C, giúp giải khát và cung cấp năng lượng cho cơ thể', 'orange-drink.png', '2025-04-18 04:22:01', '2025-04-18 06:19:29', 0),
(16, 'Sinh tố dâu', 'Đồ uống', 70000, 'Available', 'Đồ uống mát lạnh làm từ dâu tươi xay cùng sữa hoặc sữa chua, tạo nên hương vị ngọt ngào, chua nhẹ và thơm mát', 'strawberry-drink.png', '2025-04-18 04:22:01', '2025-04-18 06:19:29', 1),
(17, 'Mì ý sốt cà ri', 'Món chính', 125000, 'Available', ' Sợi mì Ý dai mềm hòa quyện cùng nước sốt cà ri béo ngậy, thơm nồng từ các loại gia vị như bột cà ri, nước cốt dừa', 'my-y.jpg', '2025-05-12 01:17:18', '2025-05-12 08:17:18', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(200) NOT NULL,
  `pmode` enum('Tiền mặt','Thẻ','Mang về','') NOT NULL DEFAULT 'Thẻ',
  `payment_status` enum('Đang chờ','Thành công','Bị từ chối','') NOT NULL DEFAULT 'Đang chờ',
  `sub_total` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` enum('Đang chờ','Đã hoàn thành','Đã hủy','Đang xử lý','Đang trên đường') NOT NULL DEFAULT 'Đang chờ',
  `cancel_reason` varchar(255) DEFAULT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `email`, `firstName`, `lastName`, `phone`, `address`, `pmode`, `payment_status`, `sub_total`, `grand_total`, `order_date`, `order_status`, `cancel_reason`, `note`) VALUES
(1, 'hienk54t1@gmail.com', 'Nguyễn Thị', 'Hiền', '0867795693', 'Hà Đông, Hà Nội', 'Tiền mặt', 'Thành công', 640000, 653000, '2025-05-09 06:19:16', 'Đã hoàn thành', '', 'Không'),
(2, 'h@gmail.com', 'Nguyễn Khánh', 'Linh', '0123456789', 'Hà Đông, Hà Nội', 'Tiền mặt', 'Thành công', 985000, 998000, '2025-05-11 08:23:05', 'Đang trên đường', '', 'Không'),
(3, 'ha@gmail.com', 'Lê Hà', 'Anh', '1244455655', 'Hà Đông', 'Mang về', 'Đang chờ', 505000, 505000, '2025-05-11 08:35:43', 'Đã hoàn thành', '', 'Không'),
(4, 'ha@gmail.com', 'Lê Hà', 'Anh', '0123456789', 'Hà nội', 'Mang về', 'Thành công', 225000, 225000, '2025-05-11 15:09:18', 'Đã hoàn thành', '', 'không'),
(5, 'van@gmail.com', 'Trần Thanh', 'Vân', '0867795693', 'hà nội', 'Tiền mặt', 'Thành công', 240000, 253000, '2025-05-11 15:12:14', 'Đang trên đường', '', 'không'),
(6, 'h@gmail.com', 'Nguyễn Khánh', 'Linh', '0867795693', 'hà nội', 'Mang về', 'Đang chờ', 150000, 150000, '2025-05-12 01:23:11', 'Đang chờ', NULL, 'không'),
(7, 'h@gmail.com', 'Nguyễn Khánh', 'Linh', '1244455655', 'hà nội', 'Mang về', 'Đang chờ', 60000, 60000, '2025-05-12 05:00:43', 'Đã hủy', 'ko', 'ko'),
(8, 'h@gmail.com', 'Nguyễn Khánh', 'Linh', '1244455655', 'hà nội', 'Tiền mặt', 'Thành công', 106000, 119000, '2025-05-12 05:21:36', 'Đang xử lý', '', 'ko'),
(9, 'h@gmail.com', 'Nguyễn Khánh', 'Linh', '1244455655', 'hà nội', 'Mang về', 'Thành công', 180000, 180000, '2025-05-12 05:52:21', 'Đã hoàn thành', '', 'ko'),
(10, 'ha@gmail.com', 'Lê Hà', 'Anh', '0867795693', 'hn', 'Tiền mặt', 'Thành công', 290000, 303000, '2025-05-12 10:47:55', 'Đã hoàn thành', '', 'ko');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `itemName`, `image`, `quantity`, `price`, `total_price`) VALUES
(1, 1, ' Salad cá ngừ', 'saladca.jpg', 1, 140000, 140000),
(2, 1, 'Cá hồi áp chảo ', 'ca-hoi-ap-chao.jpg', 2, 250000, 500000),
(3, 2, 'Súp bí đỏ', 'sup-bi.jpg', 1, 85000, 85000),
(4, 2, 'Bít tết', 'bit-tet.jpg', 2, 450000, 900000),
(5, 3, 'Bít tết', 'bit-tet.jpg', 1, 450000, 450000),
(6, 3, 'Bánh mì bơ tỏi', 'garlic-bread.avif', 1, 55000, 55000),
(7, 4, 'Bánh mì bơ tỏi', 'garlic-bread.avif', 1, 55000, 55000),
(8, 4, 'Súp bí đỏ', 'sup-bi.jpg', 2, 85000, 170000),
(9, 5, 'Sinh tố dâu', 'strawberry-drink.png', 1, 70000, 70000),
(10, 5, 'Súp bí đỏ', 'sup-bi.jpg', 2, 85000, 170000),
(11, 6, 'Súp khoai tây', 'sup-khoai-tay.jpg', 1, 150000, 150000),
(12, 7, 'Bánh kem dâu', 'mousse-dau-1.jpg', 1, 60000, 60000),
(13, 8, 'Bánh crepe', 'banh-crepe.jpg', 1, 106000, 106000),
(14, 9, 'Rượu vang đỏ', 'ruouvang.webp', 1, 180000, 180000),
(15, 10, 'Súp khoai tây', 'sup-khoai-tay.jpg', 1, 150000, 150000),
(16, 10, ' Salad cá ngừ', 'saladca.jpg', 1, 140000, 140000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reservations`
--

CREATE TABLE `reservations` (
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `noOfGuests` int(50) NOT NULL,
  `reservedTime` time NOT NULL,
  `reservedDate` date NOT NULL,
  `reservedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Đang chờ','Đang xử lý','Đã hoàn thành','Đã hủy','Đã tiếp nhận') NOT NULL DEFAULT 'Đang chờ',
  `reservation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reservations`
--

INSERT INTO `reservations` (`email`, `name`, `contact`, `noOfGuests`, `reservedTime`, `reservedDate`, `reservedAt`, `status`, `reservation_id`) VALUES
('hienk54t1@gmail.com', 'hin', '000000000', 4, '00:00:15', '2025-05-08', '2025-05-08 08:31:42', 'Đã hoàn thành', 18),
('ha@gmail.com', 'Lê Hà Anh', '0348678175', 5, '00:00:15', '2025-05-11', '2025-05-11 08:28:50', 'Đang xử lý', 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text DEFAULT NULL,
  `review_date` date DEFAULT current_timestamp(),
  `status` enum('Đã chấp nhận','Đang chờ xử lý','Bị từ chối') DEFAULT 'Đang chờ xử lý',
  `response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `email`, `order_id`, `rating`, `review_text`, `review_date`, `status`, `response`) VALUES
(1, 'hienk54t1@gmail.com', 1, 3, 'Đồ ăn ngon', '2025-05-09', 'Đã chấp nhận', 'Hãy ủng hộ chúng tôi lần sau'),
(2, 'ha@gmail.com', 3, 4, 'Tốt', '2025-05-11', 'Đã chấp nhận', 'Cảm ơn quý khách'),
(3, 'ha@gmail.com', 4, 2, 'Dịch vụ oke', '2025-05-11', 'Đang chờ xử lý', NULL),
(4, 'ha@gmail.com', 10, 3, 'ok', '2025-05-12', 'Đã chấp nhận', 'Hãy ủng hộ chúng tôi lần sau');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `role` enum('superadmin','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_image` varchar(255) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`id`, `firstName`, `lastName`, `email`, `contact`, `role`, `password`, `createdAt`, `updatedAt`, `profile_image`) VALUES
(5, 'Hiền', 'Nguyễn', 'admin@gmail.com', '0867795693', 'admin', 'admin2025', '2025-05-11 06:51:20', '2025-05-12 06:27:10', '344082561_811626767143975_4768563334252199310_n.jpg'),
(7, 'Lê Anh', 'Tuấn', 'tuan@gmail.com', '0123987456', 'superadmin', '12345', '2025-05-12 06:23:03', '2025-05-12 06:33:26', 'default.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`email`, `firstName`, `lastName`, `contact`, `password`, `dateCreated`, `profile_image`) VALUES
('h@gmail.com', 'Nguyễn Khánh', 'Linh', '0123456789', '12345', '2025-05-11 08:09:34', '471639099_1239230578211868_8254715943985306274_n.jpg'),
('ha@gmail.com', 'Lê Hà', 'Anh', '0348678175', '12345', '2025-05-11 08:27:07', 'Screenshot 2025-03-21 213010.png'),
('hienk54t1@gmail.com', 'Nguyễn Thị', 'Hiền', '0867795693', '12345', '2025-05-09 05:32:33', '471639099_1239230578211868_8254715943985306274_n.jpg'),
('van@gmail.com', 'Trần Thanh', 'Vân', '0987345321', '$2y$10$N8UTXKoITA7Gp', '2025-05-11 14:11:01', 'default.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menucategory`
--
ALTER TABLE `menucategory`
  ADD PRIMARY KEY (`catId`);

--
-- Chỉ mục cho bảng `menuitem`
--
ALTER TABLE `menuitem`
  ADD PRIMARY KEY (`itemId`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `email` (`email`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `itemId` (`itemName`) USING BTREE;

--
-- Chỉ mục cho bảng `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `email` (`email`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `menucategory`
--
ALTER TABLE `menucategory`
  MODIFY `catId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `menuitem`
--
ALTER TABLE `menuitem`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
