-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2024 at 03:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ba-tuyet`
--
CREATE DATABASE IF NOT EXISTS `ba-tuyet` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ba-tuyet`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','adminOrder','adminNews','adminProduct') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(4, 'ni123', '$2y$10$5AlcVMAWDKpxXrQ3GDPwKO5I3Yn/mDyCSZJsR4h2K47KvaZ3TcGz6', 'adminOrder'),
(5, 'toni123', '$2y$10$KjuUkaplGgTT4NVkCFf6L.usolTs03.CQ.qJERv.1be8yqdDljdFq', 'adminProduct'),
(6, 'kietlax123', '$2y$10$jtjsUfEhbFjFuupGjqkv2uvn3BEI2YYP/t7FQOkh6JiMixWlb.gOO', 'adminNews'),
(7, 'duong', '$2y$10$0XR53kzb8aSyiy7WbDAy.u5MAoWv7NkOPM0L52wtt/NgVCL2lNaCW', 'adminProduct'),
(8, 'tin', '$2y$10$5ZdXTRkUG/ynbvDQTHNzTu2huK58wYRaC0IgbegvhjMuIWUOMlUiq', 'admin'),
(9, 'ngu', '$2y$10$VzLtiWLQrkF6st7MslIpr.mCK1npID4X83GZlbNdQd1pfQxwVyYtW', 'adminOrder'),
(10, 'admin', '$2y$10$u84E0lQ6OjYHKne64Sjnju.8xQ6GQ99T9zcEzywYaYPDvJjXYUjOK', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(54, 26, 56, 7);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'combo 123', '123trt6', '2024-12-01 15:56:09'),
(2, 'combo', 'cc123', '2024-12-01 16:21:42'),
(3, 'combo lax', 'dsdvsd', '2024-12-01 16:22:03');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `site_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `site_phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `additional_info` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `site_name`, `site_email`, `site_phone`, `updated_at`, `additional_info`) VALUES
(1, 'Tên trang web', 'email@domain.com', '0123456789', '2024-11-12 16:04:22', 'Thông tin bổ sung nếu có');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `status` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `author`, `created_at`, `status`) VALUES
(3, 'Bà Tuyết Diamond - chủ “đế chế” ăn vặt đình đám: Từng làm lao công cõng số nợ 350 triệu, đổi đời nhờ 1 quyết định táo bạo', 'Lên mạng sáng tạo nội dung, livestream bán hàng vốn không chỉ giới hạn độ tuổi dành cho những người trẻ mà các bậc phụ huynh khi “lên sóng” cũng hot không kém. Bà Tuyết Diamond là một trong những minh chứng rõ ràng cho điều này. Sức hút hiện tại của Bà Tuyết “không phải dạng vừa” khi sở hữu 1,9M người theo dõi, có lượng fan hùng hậu đáng kể trên MXH.\r\n\r\nKhông những thế, Bà Tuyết còn được nhiều người biết đến khi làm chủ một thương hiệu đồ ăn vặt đình đám. Rất nhiều người nổi tiếng, KOL đều yêu thích và review sản phẩm, mới Bà Tuyết tham gia những phiên livestream với doanh thu cao ngất. Ngoài ra, Bà Tuyết cũng thường livestream để quảng bá, bán sản phẩm của chính mình sản xuất. Những lúc không lên live, bà Tuyết sẽ quay clip sáng tạo nội dung hoặc đi “thị sát”, quay cận cảnh nhà máy sản xuất hoành tráng của mình.', '4.webp', '7 chọ', '2024-12-09', 'on'),
(5, 'Lý do giúp thương hiệu \'Ăn cùng bà Tuyết\' đứng vững trên thị trường', 'Chú trọng nguyên liệu đầu vào, đầu tư dây chuyền sản xuất hiện đại, \"Ăn cùng bà Tuyết\" mang tới những sản phẩm đồ ăn vặt đạt tiêu chuẩn chất lượng.\r\n\r\nĐại diện thương hiệu cho biết từ lâu, đồ ăn vặt ngoài cổng trường luôn được học sinh yêu thích nhưng lại khiến các bậc phụ huynh lo ngại về nguồn gốc xuất xứ cũng như chất lượng. Thấu hiểu điều này, thương hiệu \"Ăn cùng bà Tuyết\" ra đời nhằm mang đến những sản phẩm đạt vệ sinh an toàn thực phẩm.', 'image001-1727078990-2505-1727148390.png', '7 chọ', '2024-12-10', 'on'),
(6, '\'Ăn cùng bà Tuyết\': Tập trung vào công nghệ để tối ưu chất lượng sản phẩm', 'Xuất phát điểm đơn giản chỉ là món ăn vặt dành cho giới trẻ, đặc biệt là lứa tuổi học sinh, \"Ăn cùng bà Tuyết\" đã trở thành thương hiệu đồ ăn vặt uy tín, chất lượng trên thị trường.\r\n\r\nNhững món ăn vặt của \"Ăn cùng bà Tuyết\" đều được sản xuất dưới sự kiểm soát nghiêm ngặt từ nguyên liệu đầu vào đến thành phẩm. Mỗi sản phẩm đều được cấp giấy kiểm nghiệm đầy đủ, đáp ứng tiêu chuẩn vệ sinh an toàn thực phẩm.\r\n\r\nNhà máy sản xuất của \"Ăn cùng bà Tuyết\" được trang bị dây chuyền máy móc công nghệ tiên tiến, đảm bảo quy trình chế biến khép kín và sạch sẽ, loại bỏ các nguy cơ nhiễm khuẩn.', '5.webp', '7 chọ', '2024-12-10', 'on'),
(7, 'Ăn vặt Bà Tuyết có gì đặc biệt mà được hội food review khen nức nở, bán đến hàng chục nghìn đơn?', 'Thời gian gần đây, một thương hiệu đồ ăn vặt mang tên \"Ăn cùng Bà Tuyết\" đang là sản phẩm viral trên khắp các nền tảng mạng xã hội, đặc biệt là TikTok. Bà Tuyết Dimond tên thật là Đỗ Thị Tuyết vốn nổi tiếng là mẹ của TikToker Minh Trường ở Thái Nguyên, nhờ hỗ trợ con trai diễn xuất với các video mang nội dung vui nhộn, hài hước nên bà tạo được tiếng vang lớn dù bén duyên với nghề sáng tạo nội dung ở độ tuổi khá cao. Hiện, bà Tuyết đang bán các sản phẩm như bim bim, đồ ăn vặt trên sàn thương mại điện tử và được rất nhiều người ủng hộ.', 'photo6116095754230675287y-2102-1704758420026-17047584202521327900789.webp', '7 chọ', '2024-12-10', 'on'),
(8, 'Giúp bà Tuyết chữa bệnh', 'Bà Tuyết năm nay 60 tuổi nhưng nhìn già yếu hơn so với tuổi, phần vì bệnh tật, phần vì bà luôn suy nghĩ lo lắng về hoàn cảnh của mình. Bà có con gái nhưng do điều kiện kinh tế khó khăn nên phải đi làm ăn xa. Thế nhưng, đời sống của con bà cũng chật vật, cả năm không về thăm mẹ được một lần.\r\n\r\nBà Tuyết hiện mắc nhiều bệnh, rõ nhất là u ở mặt nhưng do hoàn cảnh nên bà không đi khám chữa, chỉ gắng gượng chịu đựng sống qua ngày. Cuộc sống cô đơn trong ngôi nhà cũ kỹ xuống cấp lúc tuổi già khi mang trong mình nhiều bệnh tật khiến bà thêm đau buồn, tủi thân. Tuần 2 buổi, bà vẫn gắng gượng đi xe buýt ra trung tâm thành phố để bán dạo ít đồ lặt vặt tự nuôi thân, song cuộc sống vẫn thường xuyên thiếu trước hụt sau. Hoàn cảnh của bà Tuyết rất cần giúp đỡ.\r\n\r\nMọi sự ủng hộ, giúp đỡ của các tổ chức, cá nhân, nhà hảo tâm liên hệ trực tiếp với bà Tuyết theo địa chỉ trên, số điện thoại 0963298038, hoặc Quỹ Trái tim nhân ái Báo Hànộimới, số 44 phố Lê Thái Tổ, quận Hoàn Kiếm, Hà Nội. Số tài khoản: 118000001371 - Ngân hàng thương mại cổ phần Công thương Việt Nam, Chi nhánh thành phố Hà Nội.', 'oip-1-.jpg', '7 chọ', '2024-12-10', 'on'),
(9, 'Vụ tờ vé số độc đắc nghi bị đánh tráo: Bà Tuyết nhận 200 triệu đầu tiên', 'Chiều 27-11, bà Nguyễn Thị Tuyết (ngụ ấp Thạnh Hoà, xã Mong Thọ A, huyện Châu Thành, tỉnh Kiên Giang) cho biết sáng cùng ngày, bà đã đến cơ quan Thi Hành án dân sự TP Rạch Giá (Kiên Giang) nhận số tiền 200 triệu đồng do chủ đại lý vé số Triều Phát chi trả theo bản án phúc thẩm đã tuyên trước đó.\r\n\r\nSáng cùng ngày, ông Ngô Xương Phúc, chủ đại lý vé số Triều Phát, đến Chi cục Thi Hành án dân sự TP Rạch Giá nhận quyết định thi hành án. Tại đây, ông Phúc nộp tiền thi hành án 200 triệu đồng và cam kết sẽ trả hết cho bà Tuyết số tiền còn lại.\r\n\r\nTheo quyết định thi hành án số 178 QĐ-CCTHADS ngày 23-11-2017 của Chi cục Thi hành án dân sự TP Rạch Giá, cho phép thi hành bản án số 194/2017/DS-PT có hiệu lực từ ngày 7-11-2017 của TAND tỉnh Kiên Giang. Theo đó, buộc ông Ngô Xương Phúc (bị đơn) và bà Ngô Minh Thu - đại diện pháp luật hộ kinh doanh cá thể của đại lý vé số Triều Phát phải trả cho bà Nguyễn Thị Tuyết (nguyên đơn) 1.344.000.000 đồng và chịu một phần án phí.', '3-1511767591558.jpg', '7 chọ', '2024-12-10', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('unread','read') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','shipped','delivered','canceled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cancel_reason` text COLLATE utf8mb4_general_ci,
  `canceled_at` timestamp NULL DEFAULT NULL,
  `is_canceled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `address`, `phone`, `total_price`, `status`, `created_at`, `cancel_reason`, `canceled_at`, `is_canceled`) VALUES
(35, 26, 'Vũ Tô Ni', 'ruộng', '0372757362', 999999.00, 'canceled', '2024-12-12 17:43:54', '123', '2024-12-12 17:44:01', 1),
(36, 26, '123', '123', '123', 999999.00, 'pending', '2024-12-13 12:08:53', NULL, NULL, 0),
(37, 26, 'ng', 'ng', 'ng', 123464.00, 'pending', '2024-12-13 13:19:30', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `image`) VALUES
(29, 35, 31, 1, 999999.00, '20.webp'),
(30, 36, 32, 1, 999999.00, '11.webp'),
(31, 37, 47, 1, 123464.00, 'photo6116095754230675284y-2103-1704758422650-1704758422923890807597.webp');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int DEFAULT '0',
  `view_count` int DEFAULT '0',
  `purchase_count` int DEFAULT '0',
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `image`, `status`, `created_at`, `quantity`, `view_count`, `purchase_count`, `category_id`) VALUES
(31, 'Snack Rong Biển 123', 999999.00, '123', '20.webp', 1, '2024-12-01 16:39:32', 12, 96, 53, 1),
(32, 'Snack Rong Biển 465', 999999.00, 'abc', '11.webp', 1, '2024-12-10 01:17:50', 15, 16, 7, 3),
(33, 'Snack Rong Biển 789', 888888.00, 'xyz', '22.webp', 1, '2024-12-10 01:18:21', 22, 4, 2, 1),
(34, 'Snack Rong Biển 112', 222222.00, 'abc', '15.webp', 1, '2024-12-10 01:18:49', 33, 2, 1, 1),
(35, 'Snack Rong Biển 466', 555555.00, 'nmb', '23.webp', 1, '2024-12-10 01:19:25', 33, 2, 1, 1),
(36, 'Snack Rong Biển 465', 666666.00, 'naw', '22.webp', 1, '2024-12-10 01:21:33', 66, 0, 0, 1),
(37, 'Snack Rong Biển 465', 789132.00, 'nnn', '20.webp', 1, '2024-12-10 01:21:57', 24, 0, 0, 1),
(38, 'Snack Rong Biển 466', 798128.00, 'ggg', '11.webp', 1, '2024-12-10 01:22:24', 14, 2, 1, 1),
(39, 'Snack Rong Biển 789', 475821.00, 'hhh', '11.webp', 1, '2024-12-10 01:22:48', 25, 0, 0, 1),
(40, 'Snack Rong Biển 118', 444444.00, 'qqq', '23.webp', 1, '2024-12-10 01:23:29', 36, 0, 0, 1),
(41, 'Snack Rong Biển 466', 465789.00, 'twq', '20.webp', 1, '2024-12-10 01:23:48', 45, 0, 0, 1),
(42, 'Snack Rong Biển 789', 888888.00, 'ssadf', '22.webp', 1, '2024-12-10 01:24:08', 26, 0, 0, 1),
(43, 'Snack Rong Biển ', 456733.00, 'abc', 'photo6116095754230675284y-2103-1704758422650-1704758422923890807597.webp', 1, '2024-12-10 13:31:23', 33, 0, 0, 1),
(44, 'Snack Rong Biển ', 34.00, 'ahgd', 'photo6116095754230675287y-2102-1704758420026-17047584202521327900789.webp', 1, '2024-12-10 13:31:48', 22, 0, 0, 1),
(45, 'Snack Rong Biển ', 231111.00, 'dfgs', 'photo6116095754230675285y-2103-1704758421701-170475842194940629733.webp', 1, '2024-12-10 13:32:05', 22, 3, 1, 1),
(46, 'Snack Rong Biển ', 234135.00, 'sga', '22.webp', 1, '2024-12-10 13:32:55', 11, 0, 0, 1),
(47, 'Snack Rong Biển ', 123464.00, 'sdga', 'photo6116095754230675284y-2103-1704758422650-1704758422923890807597.webp', 1, '2024-12-10 13:33:08', 31, 2, 1, 1),
(48, 'Snack Rong Biển ', 132666.00, 'qtq', 'photo6116095754230675285y-2103-1704758421701-170475842194940629733.webp', 1, '2024-12-10 13:33:25', 33, 0, 0, 1),
(49, 'Snack Rong Biển ', 154151.00, 'ảt', 'photo6116095754230675287y-2102-1704758420026-17047584202521327900789.webp', 1, '2024-12-10 13:33:40', 55, 0, 0, 1),
(50, 'Snack Rong Biển ', 1111111.00, 'gưg', '23.webp', 1, '2024-12-10 13:34:08', 33, 5, 2, 1),
(51, 'Snack Rong Biển ', 234611.00, 'rưt', 'photo6116095754230675287y-2102-1704758420026-17047584202521327900789.webp', 1, '2024-12-10 13:34:31', 24, 0, 0, 1),
(52, 'Snack Rong Biển ', 1345.00, '444', 'photo6116095754230675288y-2104-1704758425014-1704758425181878032650.webp', 1, '2024-12-10 13:34:56', 13, 11, 6, 1),
(53, 'Snack Rong Biển ', 431511.00, 'dag', 'photo6116095754230675284y-2103-1704758422650-1704758422923890807597.webp', 1, '2024-12-10 13:35:12', 41, 0, 0, 1),
(54, 'Snack Rong Biển ', 431555.00, 'rqgrt', 'photo6116095754230675286y-2102-1704758420842-17047584210021925319423.webp', 1, '2024-12-10 13:35:28', 43, 0, 0, 1),
(55, 'Snack Rong Biển ', 135412.00, 'ewqt', 'photo6116095754230675287y-2102-1704758420026-17047584202521327900789.webp', 1, '2024-12-10 13:35:39', 31, 0, 0, 1),
(56, 'Snack Rong Biển ', 321451.00, '1qẻq', 'photo6116095754230675284y-2103-1704758422650-1704758422923890807597.webp', 1, '2024-12-10 13:35:52', 44, 4, 2, 1),
(57, 'Snack Rong Biển ', 234523.00, 'ưt', 'photo6116095754230675286y-2102-1704758420842-17047584210021925319423.webp', 1, '2024-12-10 13:36:10', 40, 8, 2, 1),
(58, 'Snack Rong Biển ', 6521231.00, 'ttr', 'photo6116095754230675288y-2104-1704758425014-1704758425181878032650.webp', 1, '2024-12-10 13:36:25', 47, 31, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`) VALUES
(44, 31, '22.webp'),
(45, 32, '15.webp'),
(46, 33, '23.webp'),
(47, 34, '15.webp'),
(48, 35, '15.webp'),
(49, 36, '11.webp'),
(50, 37, '23.webp'),
(51, 38, '15.webp'),
(52, 39, '22.webp'),
(53, 40, '11.webp'),
(54, 41, '22.webp'),
(55, 42, '15.webp'),
(56, 43, 'photo6116095754230675285y-2103-1704758421701-170475842194940629733.webp'),
(57, 44, 'photo6116095754230675288y-2104-1704758425014-1704758425181878032650.webp'),
(58, 45, 'photo6116095754230675286y-2102-1704758420842-17047584210021925319423.webp'),
(59, 46, 'photo6116095754230675288y-2104-1704758425014-1704758425181878032650.webp'),
(60, 47, '20.webp'),
(61, 48, '20.webp'),
(62, 49, '11.webp'),
(63, 50, '23.webp'),
(64, 51, 'photo6116095754230675288y-2104-1704758425014-1704758425181878032650.webp'),
(65, 52, '23.webp'),
(66, 53, 'photo6116095754230675287y-2102-1704758420026-17047584202521327900789.webp'),
(67, 54, '22.webp'),
(68, 55, 'photo6116095754230675286y-2102-1704758420842-17047584210021925319423.webp'),
(69, 56, '23.webp'),
(70, 57, '22.webp'),
(71, 58, '20.webp'),
(72, 31, '11.webp'),
(73, 58, '11.webp'),
(74, 58, '15.webp'),
(75, 58, '20.webp'),
(76, 58, '22.webp'),
(77, 58, '23.webp'),
(78, 58, 'photo6116095754230675288y-2104-1704758425014-1704758425181878032650.webp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(26, 'nii', 'ni@gmail.com', '123456789', '1234', '2024-11-14 00:50:04'),
(27, 'kietlax', 'kiet@gmail.com', '0123456789', '123', '2024-12-11 14:38:50'),
(28, 'Vũ Tô Ni', 'tungxeko0608@gmail.com', '0372757362', '123', '2024-12-12 00:22:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
