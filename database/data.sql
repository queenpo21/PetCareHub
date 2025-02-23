-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 03:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doan_petcarehub`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `PlaceOrder` (IN `product_id` INT, IN `quantity_needed` INT)   BEGIN
    -- Thiết lập isolation level SERIALIZABLE cho stored procedure
    SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE;

    -- Bắt đầu transaction
    START TRANSACTION;

    -- Đọc số lượng sản phẩm còn trong kho của một sản phẩm cụ thể
    SET @current_quantity = 0;
    
    SELECT inventory 
    INTO @current_quantity 
    FROM product 
    WHERE id = product_id 
    FOR UPDATE;

    -- Kiểm tra xem có đủ số lượng sản phẩm để đáp ứng nhu cầu đặt hàng không
    IF @current_quantity >= quantity_needed THEN
    
        -- Thêm một đơn hàng mới cho sản phẩm
        INSERT INTO orderdetail (product_id, num) VALUES (product_id, quantity_needed);
        
        -- Cập nhật số lượng sản phẩm trong kho sau khi đặt hàng
        UPDATE product 
        SET inventory = inventory - quantity_needed 
        WHERE id = product_id;
        
        -- Kết thúc transaction
        COMMIT;
    ELSE
        -- Nếu số lượng sản phẩm không đủ, hủy bỏ giao dịch
        ROLLBACK;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SaveImportBill` (IN `p_bill_id` INT, IN `p_product_id` INT, IN `p_num` INT, IN `p_price` DECIMAL(10,2))   BEGIN 
    -- Bắt đầu giao tác tường minh
    START TRANSACTION;

   -- Thêm chi tiết đơn hàng nhập hàng
   INSERT INTO detailimportbill (bill_id, product_id, num, price, total) 
   VALUES (p_bill_id, p_product_id, p_num, p_price, p_num * p_price);  -- Tính toán tổng giá trị dựa trên giá và số lượng

    -- Cập nhật số lượng sản phẩm trong kho
    UPDATE product SET inventory = inventory + p_num WHERE id = p_product_id;
    
    -- Cập nhật giá mới của sản phẩm
    UPDATE product SET price = p_price * 1.4 WHERE id = p_product_id;

    -- Hoàn thành giao tác
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Transaction_T2` (IN `product_id` INT, IN `quantity_needed` INT)   BEGIN
    -- Bắt đầu giao dịch T2 với mức độ cô lập SERIALIZABLE
    START TRANSACTION WITH CONSISTENT SNAPSHOT;

    -- Thực hiện cập nhật số lượng sản phẩm trong kho
    UPDATE product 
    SET inventory = inventory + quantity_needed 
    WHERE id = product_id;

    -- Kết thúc giao dịch T2
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateProductInventory` (IN `productId` INT, IN `quantityToAdd` INT, OUT `message` VARCHAR(255))   BEGIN
    -- Bắt đầu transaction
    START TRANSACTION;

    -- Tìm sản phẩm theo id và khóa dòng để cập nhật
    SELECT * FROM product WHERE id = productId FOR UPDATE;

    -- Cập nhật trường "inventory"
    UPDATE product
    SET inventory = inventory + quantityToAdd WHERE id = productId;

    -- Commit transaction
    COMMIT;
    SET message = 'Inventory updated successfully';
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CountNewCustomersInCurrentMonth` () RETURNS INT(11)  BEGIN
    DECLARE currentMonth INT;
    DECLARE currentYear INT;
    DECLARE newCustomersCount INT;

    -- Lấy tháng và năm hiện tại
    SET currentMonth = MONTH(NOW());
    SET currentYear = YEAR(NOW());

    -- Đếm số lượng khách hàng mới trong tháng hiện tại với điều kiện role = "customer"
    SELECT COUNT(*) INTO newCustomersCount
    FROM users
    WHERE MONTH(created_at) = currentMonth 
    AND YEAR(created_at) = currentYear 
    AND role = 'customer';

    RETURN newCustomersCount;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `CountTotalBills` () RETURNS INT(11)  BEGIN
    DECLARE totalBills INT;

    SELECT COUNT(*) INTO totalBills
    FROM bill;

    RETURN totalBills;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetTotalRevenue` () RETURNS DECIMAL(10,2)  BEGIN
    DECLARE TotalRevenue DECIMAL(10, 2);
    SELECT SUM(total) INTO TotalRevenue 
    FROM bill;
    IF TotalRevenue !=0 THEN
    	RETURN TotalRevenue;
    ELSE RETURN 0;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `number_service` int(11) NOT NULL,
  `number_days_send` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `timeslot` enum('8:00-9:30','9:30-11:00','13:30-14:00','14:00-15:30','15:30-17:00') NOT NULL,
  `discount` double NOT NULL,
  `discount_type` enum('tiền mặt','phần trăm') NOT NULL,
  `total` double NOT NULL,
  `method_payment` enum('Tiền mặt','Chuyển khoản') NOT NULL,
  `status_payment` enum('Chưa thanh toán','Đã thanh toán') NOT NULL,
  `appointment_status` enum('Cuộc hẹn đã được đặt','Sắp tới ngày hẹn','Tới ngày hẹn','Đã diễn ra','Hủy') NOT NULL,
  `cancellaton_reason` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointmentservice`
--

CREATE TABLE `appointmentservice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `shipcost` double NOT NULL,
  `discount` int(11) NOT NULL,
  `type_discount` enum('Tiền mặt','Phần trăm') NOT NULL,
  `total` double NOT NULL,
  `method_payment` enum('Tiền mặt','Thanh toán online') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `code`, `user_id`, `order_id`, `name`, `email`, `phone`, `address`, `note`, `shipcost`, `discount`, `type_discount`, `total`, `method_payment`, `created_at`, `updated_at`) VALUES
(1, '', 1, 0, '', '', '', '', '', 0, 0, '', 250000, '', NULL, NULL),
(3, '', 2, 0, '', '', '', '', '', 0, 0, '', 300000, '', NULL, NULL);

--
-- Triggers `bill`
--
DELIMITER $$
CREATE TRIGGER `trg_delete_bill_update_customer_spending` AFTER DELETE ON `bill` FOR EACH ROW BEGIN
    DECLARE customer_spending DECIMAL(10, 2);

    -- Lấy giá trị total từ hóa đơn đã bị xóa
    SET customer_spending = OLD.total;

    -- Cập nhật tổng chi của khách hàng trong bảng customers
    UPDATE users
    SET total = total - customer_spending
    WHERE id = OLD.user_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_bill_update_customer_spending` AFTER UPDATE ON `bill` FOR EACH ROW BEGIN
    DECLARE update_customer_spending DECIMAL(10, 2);	
    SET update_customer_spending = NEW.total - OLD.total;

    -- Cập nhật tổng chi của khách hàng trong bảng customers
    UPDATE users
    SET total= total + update_customer_spending
    WHERE id = OLD.user_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_customer_total_spending` AFTER INSERT ON `bill` FOR EACH ROW BEGIN
    DECLARE customer_spending DECIMAL(10, 2);

    -- Lấy giá trị total từ hóa đơn mới được chèn
    SET customer_spending = NEW.total;

    -- Cập nhật tổng chi của khách hàng trong bảng customers
    UPDATE users
    SET total = total + customer_spending
    WHERE id = NEW.user_id
    AND role = "customer" ;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Đồ ăn', NULL, NULL),
(2, 'Vệ sinh', NULL, NULL),
(3, 'Đồ dùng thú cưng', NULL, NULL),
(4, 'Thời trang thú cưng', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `costservice`
--

CREATE TABLE `costservice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Cắt tỉa','Khách sạn') NOT NULL,
  `pet_type` enum('Chó','Mèo') NOT NULL,
  `service_id` int(11) NOT NULL,
  `pack_service` varchar(255) NOT NULL,
  `minkg` double NOT NULL,
  `maxkg` double NOT NULL,
  `cost` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailimportbill`
--

CREATE TABLE `detailimportbill` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galery`
--

CREATE TABLE `galery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `file_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `importbill`
--

CREATE TABLE `importbill` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date_import` datetime NOT NULL,
  `total` double NOT NULL,
  `method_payment` enum('Tiền mặt','Chuyển khoản') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2024_05_04_032752_create_role_table', 1),
(4, '2024_05_04_033611_create_category_table', 1),
(5, '2024_05_04_033953_create_product_table', 1),
(6, '2024_05_04_035808_create_galery_table', 1),
(7, '2024_05_04_040620_create_tag_table', 1),
(8, '2024_05_04_041041_create_tag_product_table', 1),
(9, '2024_05_04_055122_create_order_table', 1),
(10, '2024_05_04_061907_create_order_detail_table', 1),
(11, '2024_05_04_074957_create_supplier_table', 1),
(12, '2024_05_04_075104_create_import_bill_table', 1),
(13, '2024_05_04_075147_create_detail_import_bill_table', 1),
(14, '2024_05_04_083333_create_service_table', 1),
(15, '2024_05_04_083937_create_cost_service_table', 1),
(16, '2024_05_04_084622_create_pet_table', 1),
(17, '2024_05_04_085343_create_appointment_table', 1),
(18, '2024_05_04_092716_create_appointment_service_table', 1),
(19, '2024_05_05_152636_create_type_product_table', 1),
(20, '2024_05_13_185704_create_slider_table', 1),
(21, '2024_05_28_054858_create_bill_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `vote` enum('1','2','3','4','5') NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `shipcost` double NOT NULL DEFAULT 30000,
  `discount` int(11) NOT NULL DEFAULT 0,
  `total` double NOT NULL,
  `method_payment` enum('Tiền mặt','Thanh toán online') NOT NULL,
  `status` enum('Đang chờ xử lý','Đang xử lý','Đang giao hàng','Đã giao hàng','Hủy') NOT NULL,
  `cancelllation_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `code`, `user_id`, `name`, `email`, `phone`, `address`, `note`, `shipcost`, `discount`, `total`, `method_payment`, `status`, `cancelllation_reason`, `created_at`, `updated_at`) VALUES
(1, 'OD001', 1, 'Nguyễn Văn Lanh', 'nguyenvanlanh@gmail.com', '0353456789', '123 Đường 1, Quận 1, TP HCM', 'Ghi chú 1', 30000, 5000, 95000, 'Tiền mặt', 'Đang chờ xử lý', '', NULL, NULL),
(2, 'OD002', 2, 'Trần Thị Bé', 'tranbe@gmail.com', '0353456788', '234 Đường 2, Quận 2, TP HCM', 'Ghi chú 2', 30000, 10000, 90000, 'Thanh toán online', 'Đang xử lý', '', NULL, NULL),
(3, 'OD003', 3, 'Lê Văn Chinh', 'lechinh@gmail.com', '0373456787', '345 Đường 3, Quận 3, TP HCM', 'Ghi chú 3', 30000, 5000, 95000, 'Tiền mặt', 'Đang xử lý', '', NULL, NULL),
(4, 'OD004', 4, 'Phạm Thị Dung', 'phamthidung@gmail.com', '0363456786', '456 Đường 4, Quận 4, TP HCM', 'Ghi chú 4', 30000, 10000, 90000, 'Thanh toán online', 'Đang chờ xử lý', '', NULL, NULL),
(5, 'OD005', 5, 'Vũ Văn Thịnh', 'vuvanthinh@gmail.com', '0373456785', '567 Đường 5, Quận 5, TP HCM', 'Ghi chú 5', 30000, 5000, 95000, 'Tiền mặt', 'Đang giao hàng', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pet_type` enum('Chó','Mèo') NOT NULL,
  `pet_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `age` double NOT NULL,
  `weight` double NOT NULL,
  `medical_history` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `typeProduct_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `inventory` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `bestseller` int(11) NOT NULL DEFAULT 0,
  `new` int(11) NOT NULL DEFAULT 1,
  `number_of_sale` int(11) NOT NULL DEFAULT 0,
  `size` varchar(255) DEFAULT NULL,
  `pet` enum('Chó','Mèo') NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `typeProduct_name`, `price`, `discount_price`, `inventory`, `image`, `bestseller`, `new`, `number_of_sale`, `size`, `pet`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Su su', 'Đồ ăn eatclean', 30000, NULL, 300, 'chailong36.jpg', 0, 1, 0, NULL, 'Chó', 'siu thơm siu ngoll', '2024-05-30 05:57:01', '2024-05-30 05:57:01', NULL),
(2, 'Que ăn vặt cho pet', 'Đồ ăn eatclean', 50000, NULL, 250, 'best_seller674.png', 1, 0, 0, NULL, 'Chó', 'ngonnnn', '2024-05-30 05:58:40', '2024-05-30 06:01:22', NULL),
(4, 'Áo đầm', 'Áo đầm cho pet', 75000, NULL, 400, 'best_seller232.png', 0, 1, 0, NULL, 'Chó', 'siu đáng iu', '2024-05-30 06:01:11', '2024-05-30 06:01:11', NULL);

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `check_inventory` AFTER UPDATE ON `product` FOR EACH ROW BEGIN
    DECLARE inv INT;
    SET inv = NEW.inventory;
    IF inv < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Số lượng sản phẩm âm!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_inventory_i` AFTER INSERT ON `product` FOR EACH ROW BEGIN
    DECLARE inv INT;
    SET inv = NEW.inventory;
    IF inv < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Số lượng sản phẩm âm!';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services_pet`
--

CREATE TABLE `services_pet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `user_created_id` int(11) NOT NULL,
  `user_updated_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('mh4OEeozUxHKx2G11zUpmiUNB4ZvW71BVxzCeJgP', 12, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMHdSMEdxWm5JTFlVUmNjR2NnN3NwSWI1a2twNWx4a0xCQVRzVVdZSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly9sb2NhbGhvc3QvRG9Bbl9QZXRjYXJlSHViL3F1YW4tbHktc2FuLXBoYW0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjtzOjU6ImFkbWluIjtPOjE2OiJBcHBcTW9kZWxzXEFkbWluIjozMjp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czo1OiJ1c2VycyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE1OntzOjI6ImlkIjtpOjEyO3M6NDoibmFtZSI7czoxMzoiTmd1eeG7hW4gRHVuZyI7czo0OiJjb2RlIjtzOjg6IkVNUDgyNDQ4IjtzOjU6ImVtYWlsIjtzOjI1OiJkdW5nbmd1eWVuMTk3MjRAZ21haWwuY29tIjtzOjU6InBob25lIjtzOjEwOiIwOTQyMTU0NTI5IjtzOjEzOiJkYXRlX29mX2JpcnRoIjtOO3M6NDoicm9sZSI7czo1OiJBZG1pbiI7czo1OiJ0b3RhbCI7ZDowO3M6ODoicGFzc3dvcmQiO3M6MzoiMTIzIjtzOjk6ImRhdGVfam9pbiI7czoxMDoiMjAyNC0wNS0yMiI7czoxNDoicmVtZW1iZXJfdG9rZW4iO047czoyMDoicGFzc3dvcmRfcmVzZXRfdG9rZW4iO047czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNC0wNS0yMCAxMDoyNTo0NyI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNC0wNS0yMCAxMDoyOTo0MiI7czoxMDoiZGVsZXRlZF9hdCI7Tjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTU6e3M6MjoiaWQiO2k6MTI7czo0OiJuYW1lIjtzOjEzOiJOZ3V54buFbiBEdW5nIjtzOjQ6ImNvZGUiO3M6ODoiRU1QODI0NDgiO3M6NToiZW1haWwiO3M6MjU6ImR1bmduZ3V5ZW4xOTcyNEBnbWFpbC5jb20iO3M6NToicGhvbmUiO3M6MTA6IjA5NDIxNTQ1MjkiO3M6MTM6ImRhdGVfb2ZfYmlydGgiO047czo0OiJyb2xlIjtzOjU6IkFkbWluIjtzOjU6InRvdGFsIjtkOjA7czo4OiJwYXNzd29yZCI7czozOiIxMjMiO3M6OToiZGF0ZV9qb2luIjtzOjEwOiIyMDI0LTA1LTIyIjtzOjE0OiJyZW1lbWJlcl90b2tlbiI7TjtzOjIwOiJwYXNzd29yZF9yZXNldF90b2tlbiI7TjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTA1LTIwIDEwOjI1OjQ3IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTA1LTIwIDEwOjI5OjQyIjtzOjEwOiJkZWxldGVkX2F0IjtOO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6Mjp7aTowO3M6ODoicGFzc3dvcmQiO2k6MTtzOjE0OiJyZW1lbWJlcl90b2tlbiI7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjM6e2k6MDtzOjU6ImVtYWlsIjtpOjE7czo4OiJwYXNzd29yZCI7aToyO3M6NDoicm9sZSI7fXM6MTA6IgAqAGd1YXJkZWQiO2E6MTp7aTowO3M6MToiKiI7fXM6MTk6IgAqAGF1dGhQYXNzd29yZE5hbWUiO3M6ODoicGFzc3dvcmQiO3M6MjA6IgAqAHJlbWVtYmVyVG9rZW5OYW1lIjtzOjE0OiJyZW1lbWJlcl90b2tlbiI7fXM6NzoibWVzc2FnZSI7Tjt9', 1717074083);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` blob NOT NULL,
  `place` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagproduct`
--

CREATE TABLE `tagproduct` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typeproduct`
--

CREATE TABLE `typeproduct` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `typeproduct`
--

INSERT INTO `typeproduct` (`id`, `name`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Đồ ăn eatclean', 'Đồ ăn', NULL, NULL),
(2, 'Sữa tắm', 'Vệ sinh', NULL, NULL),
(3, 'Bong bóng', 'Đồ chơi thú cưng', NULL, NULL),
(4, 'Áo croptop cho pet', 'Thời trang thú cưng', NULL, NULL),
(5, 'Pate', 'Đồ ăn', NULL, NULL),
(6, 'Lược chải lông', 'Vệ sinh', NULL, NULL),
(7, 'Con lăn cho pet', 'Đồ chơi thú cưng', NULL, NULL),
(8, 'Áo đầm cho pet', 'Thời trang thú cưng', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Customer',
  `total` double NOT NULL DEFAULT 0,
  `password` varchar(255) DEFAULT NULL,
  `date_join` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `code`, `email`, `phone`, `date_of_birth`, `role`, `total`, `password`, `date_join`, `remember_token`, `password_reset_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nguyễnn Văn Lanh', '', 'nguyenvanlanh@gmail.com', '0353456788', '1990-01-01', 'Customer', 250000, '01011990', '2024-01-02', '010122', '19900101', '2024-05-16 09:31:02', '2024-05-20 03:25:27', NULL),
(2, 'Trần Thị Bé', '', 'tranbe@gmail.com', '0353456789', '1991-02-02', 'Customer', 300000, '02021991', '2023-03-02', '020224', '19910202', '2024-04-16 09:31:02', '2024-05-28 08:02:39', NULL),
(3, 'Lê Văn Chinh', '', 'lechinh@gmail.com', '0373456787', '1992-03-03', 'Customer', 0, '03031992', '2024-07-02', '030324', '19920303', '2024-05-30 12:38:57', NULL, NULL),
(4, 'Phạm Thị Dung', '', 'phamthidung@gmail.com', '0363456786', '1993-04-04', 'Customer', 0, '04041993', '2020-02-02', '040424', '19930404', '2024-05-29 12:39:46', NULL, NULL),
(5, 'Vũ Văn Thịnh', '', 'vuvanthinh@gmail.com', '0373456785', '1994-05-05', 'Customer', 0, '05051994', '2021-01-02', '050524', '19940505', '2024-04-29 12:40:12', NULL, NULL),
(6, 'Đặng Thị Phương Tuyền', '', 'dtphuongtuyen@gmail.com', '0333456784', '1995-06-06', 'Sale Staff', 0, '06061995', '2024-01-02', '060624', '19950606', NULL, '2024-05-20 03:37:46', NULL),
(7, 'Bùi Văn Khánh', '', 'buivankhanh@gmail.com', '0863456783', '1996-07-07', 'Sale Staff', 0, '07071996', '2020-01-01', '070724', '19960707', NULL, '2024-05-20 03:37:56', NULL),
(8, 'Ngô Thị Tuyết', '', 'ngothituyet@gmail.com', '0973456782', '1997-08-08', 'Manager', 0, '08081997', '2018-01-02', '080824', '19970808', NULL, '2024-05-20 03:29:23', NULL),
(9, 'Hoàng Văn Thám', '', 'hoangvantham@gmail.com', '0933456781', '1998-09-09', 'Service Staff', 0, '09091998', '2021-07-02', '090924', '19980909', NULL, '2024-05-20 03:38:09', NULL),
(10, 'Dương Thị Linh', '', 'duongthilinh@gmal.com', '0383456780', '1999-10-10', 'Customer', 0, '10101999', '2024-01-02', '101024', '19991010', NULL, NULL, NULL),
(12, 'Nguyễn Dung', 'EMP82448', 'dungnguyen19724@gmail.com', '0942154529', NULL, 'Admin', 0, '123', '2024-05-22', NULL, NULL, '2024-05-20 03:25:47', '2024-05-20 03:29:42', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointmentservice`
--
ALTER TABLE `appointmentservice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `costservice`
--
ALTER TABLE `costservice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailimportbill`
--
ALTER TABLE `detailimportbill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galery`
--
ALTER TABLE `galery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `importbill`
--
ALTER TABLE `importbill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_pet`
--
ALTER TABLE `services_pet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tagproduct`
--
ALTER TABLE `tagproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typeproduct`
--
ALTER TABLE `typeproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointmentservice`
--
ALTER TABLE `appointmentservice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `costservice`
--
ALTER TABLE `costservice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailimportbill`
--
ALTER TABLE `detailimportbill`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galery`
--
ALTER TABLE `galery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `importbill`
--
ALTER TABLE `importbill`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services_pet`
--
ALTER TABLE `services_pet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagproduct`
--
ALTER TABLE `tagproduct`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typeproduct`
--
ALTER TABLE `typeproduct`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_records` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-28 17:53:31' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM history WHERE created_at < NOW() - INTERVAL 30 DAY$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
