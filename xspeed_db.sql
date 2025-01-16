/*
 Navicat Premium Data Transfer

 Source Server         : Mysql - localhost
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : xspeed_db

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 13/01/2025 20:23:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bank_accounts
-- ----------------------------
DROP TABLE IF EXISTS `bank_accounts`;
CREATE TABLE `bank_accounts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_id` bigint UNSIGNED NULL DEFAULT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL DEFAULT 0 COMMENT '0=company;1=supplier;2=user;3=buyer',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_primary` int NOT NULL DEFAULT 0 COMMENT '0=primary;1=not_primary;',
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `bank_accounts_uuid_unique`(`uuid` ASC) USING BTREE,
  INDEX `bank_accounts_bank_id_foreign`(`bank_id` ASC) USING BTREE,
  CONSTRAINT `bank_accounts_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bank_accounts
-- ----------------------------

-- ----------------------------
-- Table structure for banks
-- ----------------------------
DROP TABLE IF EXISTS `banks`;
CREATE TABLE `banks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banks
-- ----------------------------

-- ----------------------------
-- Table structure for brands
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of brands
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Transmisi', 'GEAR', 'Sistem yang mentransfer tenaga dari mesin ke roda.', 'http://example.com/furniture.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (2, 'Rem', 'BRK', 'Sistem yang digunakan untuk memperlambat atau menghentikan motor.', 'http://example.com/clothing.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (3, 'Suspensi', 'SUS', 'Sistem yang menyerap guncangan dan menyediakan kenyamanan berkendara.', 'http://example.com/books.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (4, 'Roda dan Ban', 'TIRE', 'Komponen yang berhubungan langsung dengan jalan.', 'http://example.com/toys.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (5, 'Aki', 'ACCU', 'Sumber daya listrik untuk sepeda motor.', 'http://example.com/sports.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (6, 'Knalpot', 'EXAUST', 'Sistem yang mengeluarkan gas buang dari mesin.', 'http://example.com/beauty.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (7, 'Filter', 'FILTER', 'Komponen yang menyaring kotoran.', 'http://example.com/automotive.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (8, 'Lampu', 'LAMP', 'Sistem pencahayaan untuk keselamatan dan visibilitas.', 'http://example.com/jewelry.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (9, 'Body Kit', 'BODY', 'Bagian luar motor seperti fairing, spakbor,dan cover lainnya.', 'http://example.com/groceries.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');
INSERT INTO `categories` VALUES (10, 'Mesin', 'ENGN', 'Komponen utama yang menggerakkan sepeda motor.', 'http://example.com/electronics.jpg', 0, '2025-01-13 05:05:27', '2025-01-13 05:05:27', 'admin', 'admin');

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL DEFAULT 0 COMMENT '0=item;1=sales;2=order;3=payable;4=receivable',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `img_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ext` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '0=local;1=gdrive;',
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `index` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `images_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of images
-- ----------------------------

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NULL DEFAULT NULL,
  `subcategory_id` bigint UNSIGNED NULL DEFAULT NULL,
  `warehouse_id` bigint UNSIGNED NULL DEFAULT NULL,
  `rack_id` bigint UNSIGNED NULL DEFAULT NULL,
  `basic_price` decimal(10, 2) NOT NULL,
  `sell_price` decimal(10, 2) NOT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` decimal(10, 2) NOT NULL,
  `stock_min` decimal(10, 2) NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `history_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `items_uuid_unique`(`uuid` ASC) USING BTREE,
  INDEX `items_category_id_foreign`(`category_id` ASC) USING BTREE,
  INDEX `items_subcategory_id_foreign`(`subcategory_id` ASC) USING BTREE,
  INDEX `items_warehouse_id_foreign`(`warehouse_id` ASC) USING BTREE,
  INDEX `items_rack_id_foreign`(`rack_id` ASC) USING BTREE,
  CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `items_rack_id_foreign` FOREIGN KEY (`rack_id`) REFERENCES `racks` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `items_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `items_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES (21, '729bd9f5-eae3-4aa8-b507-01be2864d6b4', 'Item 1', 10, 4, 1, 1, 100.00, 150.00, 10, 'pcs', 'Red', 10.00, 2.00, 'USD', 'SKU001', 'Description for Item 1', 'http://example.com/image1.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');
INSERT INTO `items` VALUES (22, 'aaf6bbe3-58bc-4295-8520-61cce9fe8c3a', 'Item 2', 10, 3, 2, 1, 200.00, 250.00, 20, 'pcs', 'Blue', 20.00, 4.00, 'USD', 'SKU002', 'Description for Item 2', 'http://example.com/image2.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');
INSERT INTO `items` VALUES (23, 'b63b1180-4444-4f08-bf0e-a6fefde5b0c7', 'Item 3', 3, 3, 2, 1, 300.00, 350.00, 30, 'pcs', 'Green', 30.00, 6.00, 'USD', 'SKU003', 'Description for Item 3', 'http://example.com/image3.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');
INSERT INTO `items` VALUES (24, '4ed26573-7ee2-43b3-bda7-c2c6cc0c4528', 'Item 4', 4, 4, 1, 1, 400.00, 450.00, 40, 'pcs', 'Yellow', 40.00, 8.00, 'USD', 'SKU004', 'Description for Item 4', 'http://example.com/image4.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');
INSERT INTO `items` VALUES (25, '2f1283ff-c061-4099-a6e7-a0c46854ae1f', 'Item 5', 5, 5, 1, 1, 500.00, 550.00, 50, 'pcs', 'Orange', 50.00, 10.00, 'USD', 'SKU005', 'Description for Item 5', 'http://example.com/image5.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');
INSERT INTO `items` VALUES (26, '43a17007-2413-4cc9-8cc6-01080dd04816', 'Item 6', 6, 6, 1, 1, 600.00, 650.00, 60, 'pcs', 'Purple', 60.00, 12.00, 'USD', 'SKU006', 'Description for Item 6', 'http://example.com/image6.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');
INSERT INTO `items` VALUES (27, '8b56c9f9-0126-4380-a723-7198d51adc09', 'Item 7', 7, 6, 1, 1, 700.00, 750.00, 70, 'pcs', 'Pink', 70.00, 14.00, 'USD', 'SKU007', 'Description for Item 7', 'http://example.com/image7.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');
INSERT INTO `items` VALUES (28, 'b3dddb82-9793-4a63-a131-6df384d5a0d8', 'Item 8', 8, NULL, 1, 1, 800.00, 850.00, 80, 'pcs', 'Brown', 80.00, 16.00, 'USD', 'SKU008', 'Description for Item 8', 'http://example.com/image8.jpg', 0, 'admin', 'admin', '2025-01-13 08:03:14', '2025-01-13 08:03:14', 'Created by admin');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menus_parent_id_foreign`(`parent_id` ASC) USING BTREE,
  CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menus
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0000_01_01_045322_drop_all_item', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (3, '2025_01_08_072438_basic', 1);
INSERT INTO `migrations` VALUES (4, '2025_01_08_072438_items', 1);
INSERT INTO `migrations` VALUES (5, '2025_01_10_025040_menus', 1);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for racks
-- ----------------------------
DROP TABLE IF EXISTS `racks`;
CREATE TABLE `racks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of racks
-- ----------------------------
INSERT INTO `racks` VALUES (1, 'Rack A', 'RA', 'Rack A', NULL, 0, '0000-00-00 00:00:00', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('nIrPfIUn2PZBZWjKL3fSLkTWSMzPiuL6dz252FVL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNmt0V0xMVEJjRlBoTGg1bzk5V05RYndQZEhobmZTdWpwVHN1U3IzSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS90ZXNzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1736762793);
INSERT INTO `sessions` VALUES ('t709FIwLXr9TlyibAduIeUbV6GTtfjBJEAMNpNVN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidFVzMndWeDl5MkFiMHhUdWg0N0JvSkxWQWh2WlU0Y25zUFhobVFXcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1736761551);

-- ----------------------------
-- Table structure for sub_categories
-- ----------------------------
DROP TABLE IF EXISTS `sub_categories`;
CREATE TABLE `sub_categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sub_categories_category_id_foreign`(`category_id` ASC) USING BTREE,
  CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sub_categories
-- ----------------------------
INSERT INTO `sub_categories` VALUES (3, 10, 'Silinder', 'BORE', 'Komponen utama tempat pembakaran bahan bakar.', 'http://example.com/electronics.jpg', 0, '2025-01-13 05:07:25', '2025-01-13 05:07:25', 'admin', 'admin');
INSERT INTO `sub_categories` VALUES (4, 10, 'Piston', 'PIST', 'Komponen yang bergerak dalam silinder untuk menghasilkan tenaga.', 'http://example.com/furniture.jpg', 0, '2025-01-13 05:07:25', '2025-01-13 05:07:25', 'admin', 'admin');
INSERT INTO `sub_categories` VALUES (5, 10, 'Klep', 'KLP', 'Komponen yang mengatur aliran masuk dan keluar campuran udara-bahan bakar.', 'http://example.com/clothing.jpg', 0, '2025-01-13 05:07:25', '2025-01-13 05:07:25', 'admin', 'admin');
INSERT INTO `sub_categories` VALUES (6, 10, 'Camshaft', 'NOKEN', 'Komponen yang mengatur waktu buka-tutup katup.', 'http://example.com/books.jpg', 0, '2025-01-13 05:07:25', '2025-01-13 05:07:25', 'admin', 'admin');

-- ----------------------------
-- Table structure for suppliers
-- ----------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_district` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npwp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(10, 2) NOT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `suppliers_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of suppliers
-- ----------------------------

-- ----------------------------
-- Table structure for user_menus
-- ----------------------------
DROP TABLE IF EXISTS `user_menus`;
CREATE TABLE `user_menus`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_menus_menu_id_foreign`(`menu_id` ASC) USING BTREE,
  INDEX `user_menus_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `user_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_menus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_menus
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for warehouses
-- ----------------------------
DROP TABLE IF EXISTS `warehouses`;
CREATE TABLE `warehouses`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT 0 COMMENT '0=active;1=deleted;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who created the record',
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'username user who last updated the record',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of warehouses
-- ----------------------------
INSERT INTO `warehouses` VALUES (1, 'MainWarehouse', 'WH001', 'Mainwarehouseforelectronics', '1234MainSt,Anytown,USA', '+1234567890', 'http://example.com/warehouse1.jpg', 0, '2025-01-13 05:07:25', '2025-01-13 05:07:25', 'admin', 'admin');
INSERT INTO `warehouses` VALUES (2, 'SecondaryWarehouse', 'WH002', 'Secondarywarehouseforfurniture', '5678MarketSt,Anytown,USA', '+1234567891', 'http://example.com/warehouse2.jpg', 0, '2025-01-13 05:07:25', '2025-01-13 05:07:25', 'admin', 'admin');

SET FOREIGN_KEY_CHECKS = 1;
