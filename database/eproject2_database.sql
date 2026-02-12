-- ============================================
-- DATABASE SCHEMA FOR EPROJECT_2 WEBSITE
-- Import this file into phpMyAdmin
-- ============================================

-- Create database
CREATE DATABASE IF NOT EXISTS `eproject2_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `eproject2_db`;

-- ============================================
-- TABLE: users
-- User management (admin and customer)
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL COMMENT 'Hashed password using password_hash()',
  `full_name` VARCHAR(100) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `role` ENUM('admin', 'customer') DEFAULT 'customer',
  `status` ENUM('active', 'inactive', 'banned') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_username` (`username`),
  INDEX `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: categories
-- Product categories (Aquarium, Boardwalk, Sweet Shop)
-- ============================================
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` INT(11) NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `display_order` INT(11) DEFAULT 0,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: products
-- Sản phẩm (tickets, merchandise, food items)
-- ============================================
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` INT(11) NOT NULL AUTO_INCREMENT,
  `category_id` INT(11) DEFAULT NULL,
  `product_name` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `short_description` VARCHAR(500) DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` DECIMAL(10,2) DEFAULT NULL COMMENT 'Giá khuyến mãi',
  `stock_quantity` INT(11) DEFAULT 0,
  `sku` VARCHAR(50) DEFAULT NULL UNIQUE COMMENT 'Stock Keeping Unit',
  `image` VARCHAR(255) DEFAULT NULL COMMENT 'Ảnh chính',
  `gallery` TEXT DEFAULT NULL COMMENT 'JSON array of image paths',
  `status` ENUM('active', 'inactive', 'out_of_stock') DEFAULT 'active',
  `featured` TINYINT(1) DEFAULT 0 COMMENT 'Sản phẩm nổi bật',
  `display_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX `idx_category` (`category_id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_status` (`status`),
  INDEX `idx_featured` (`featured`),
  INDEX `idx_price` (`price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: orders
-- Đơn hàng
-- ============================================
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL COMMENT 'NULL nếu guest checkout',
  `order_number` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Mã đơn hàng',
  `customer_name` VARCHAR(100) NOT NULL,
  `customer_email` VARCHAR(100) NOT NULL,
  `customer_phone` VARCHAR(20) NOT NULL,
  `customer_address` TEXT NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `tax` DECIMAL(10,2) DEFAULT 0.00,
  `shipping_fee` DECIMAL(10,2) DEFAULT 0.00,
  `discount` DECIMAL(10,2) DEFAULT 0.00,
  `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` VARCHAR(50) DEFAULT NULL COMMENT 'cash, bank_transfer, credit_card',
  `payment_status` ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
  `order_status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX `idx_user` (`user_id`),
  INDEX `idx_order_number` (`order_number`),
  INDEX `idx_status` (`order_status`),
  INDEX `idx_payment_status` (`payment_status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: order_items
-- Chi tiết đơn hàng
-- ============================================
CREATE TABLE IF NOT EXISTS `order_items` (
  `item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `product_name` VARCHAR(200) NOT NULL COMMENT 'Lưu tên sản phẩm tại thời điểm đặt hàng',
  `product_price` DECIMAL(10,2) NOT NULL COMMENT 'Giá tại thời điểm đặt hàng',
  `quantity` INT(11) NOT NULL DEFAULT 1,
  `subtotal` DECIMAL(10,2) NOT NULL COMMENT 'quantity * product_price',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX `idx_order` (`order_id`),
  INDEX `idx_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: cart
-- Giỏ hàng (tùy chọn - có thể dùng session thay thế)
-- ============================================
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL COMMENT 'NULL nếu guest (dùng session_id)',
  `session_id` VARCHAR(100) DEFAULT NULL COMMENT 'Cho guest users',
  `product_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY `unique_user_product` (`user_id`, `product_id`),
  UNIQUE KEY `unique_session_product` (`session_id`, `product_id`),
  INDEX `idx_user` (`user_id`),
  INDEX `idx_session` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERT SAMPLE DATA
-- ============================================

-- Insert default admin user
-- Password: admin123 (hashed with password_hash())
-- IMPORTANT: Change this password after first login!
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `role`, `status`) VALUES
('admin', 'admin@eproject2.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', 'active');

-- Insert categories
INSERT INTO `categories` (`category_name`, `slug`, `description`, `display_order`, `status`) VALUES
('Aquarium', 'aquarium', 'Aquarium tickets and experiences', 1, 'active'),
('Boardwalk', 'boardwalk', 'Boardwalk tickets and activities', 2, 'active'),
('Sweet Shop', 'sweet-shop', 'Sweet shop products and merchandise', 3, 'active');

-- Insert sample products (Sweet Shop)
INSERT INTO `products` (`category_id`, `product_name`, `slug`, `description`, `short_description`, `price`, `stock_quantity`, `image`, `status`, `featured`) VALUES
(3, 'Premium Chocolate Box', 'premium-chocolate-box', 'Delicious assortment of premium chocolates', 'Premium chocolate collection', 29.99, 50, 'img/sweetshop/p1.jpg', 'active', 1),
(3, 'Gourmet Candy Collection', 'gourmet-candy-collection', 'Assorted gourmet candies', 'Sweet candy assortment', 19.99, 100, 'img/sweetshop/p2.jpg', 'active', 1),
(3, 'Artisan Fudge Set', 'artisan-fudge-set', 'Handmade artisan fudge', 'Premium fudge selection', 24.99, 30, 'img/sweetshop/p3.jpg', 'active', 0),
(3, 'Classic Lollipops', 'classic-lollipops', 'Traditional lollipops', 'Classic lollipop collection', 9.99, 200, 'img/sweetshop/p4.jpg', 'active', 0),
(3, 'Deluxe Sweet Basket', 'deluxe-sweet-basket', 'Premium gift basket with assorted sweets', 'Luxury sweet gift basket', 49.99, 20, 'img/sweetshop/p5.jpg', 'active', 1),
(3, 'Sugar-Free Options', 'sugar-free-options', 'Healthy sugar-free alternatives', 'Sugar-free sweet treats', 18.99, 75, 'img/sweetshop/p6.avif', 'active', 0);

-- ============================================
-- END OF DATABASE SCHEMA
-- ============================================
