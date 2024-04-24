-- Adminer 4.8.1 MySQL 5.7.11 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Mrs. Magnolia Schmidt Sr.',	'nicklaus.breitenberg@example.net',	'2024-04-23 05:44:08',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	1,	'SfBXrh0hKu',	'2024-04-23 05:44:08',	'2024-04-23 05:44:08'),
(2,	'Prof. Aimee Halvorson',	'lubowitz.anastacio@example.org',	'2024-04-23 05:44:08',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	1,	'DDG8890NIN',	'2024-04-23 05:44:08',	'2024-04-23 05:44:08'),
(4,	'ADMIN',	'furina200337@gmail.com',	NULL,	'$2y$12$2DNkyD01CQjLCSjSc1z7aOW.oEXxEL3Sqm5tqWXAj6S9WUmGsxL4e',	1,	NULL,	'2024-04-23 06:23:57',	'2024-04-23 06:23:57');

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`, `size`) VALUES
(4,	1,	1,	1,	'2024-04-10 23:08:45',	'2024-04-10 23:08:45',	'M'),
(5,	1,	10,	3,	'2024-04-10 23:08:45',	'2024-04-24 03:36:48',	'L');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `category_type`) VALUES
(1,	'短袖T-Shirt',	'2024-03-17 19:25:15',	'2024-03-17 19:25:15',	1),
(2,	'毛衣',	'2024-03-17 19:25:53',	'2024-03-17 19:25:53',	1),
(3,	'運動外套',	'2024-03-17 19:26:05',	'2024-03-17 19:26:05',	1),
(4,	'一般外套',	'2024-03-17 19:26:09',	'2024-03-17 19:29:42',	1),
(5,	'特殊風格',	'2024-03-17 19:30:10',	'2024-03-17 19:31:24',	1),
(6,	'防寒外套',	'2024-03-17 19:30:27',	'2024-03-17 19:30:27',	1),
(7,	'長袖上衣',	'2024-03-17 19:30:28',	'2024-03-17 19:31:54',	1),
(8,	'運動長褲',	'2024-03-17 19:37:05',	'2024-03-17 19:37:05',	2),
(9,	'運動短褲',	'2024-03-17 19:37:06',	'2024-03-17 19:38:16',	2),
(10,	'牛仔褲',	'2024-03-17 19:38:48',	'2024-03-17 19:38:48',	2),
(11,	'卡其褲',	'2024-03-17 19:38:49',	'2024-03-17 19:39:12',	2),
(12,	'運動褲',	'2024-03-27 19:40:44',	'2024-03-27 19:40:44',	2);

DROP TABLE IF EXISTS `combinations`;
CREATE TABLE `combinations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `combinations` (`id`, `staff_id`, `name`, `price`, `product_id`, `created_at`, `updated_at`) VALUES
(9,	0,	'Nike運動套裝',	1970,	1,	'2024-04-03 01:02:13',	'2024-04-03 01:02:13');

DROP TABLE IF EXISTS `combinations_detail`;
CREATE TABLE `combinations_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `combination_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `combination_id` (`combination_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `combinations_detail_ibfk_1` FOREIGN KEY (`combination_id`) REFERENCES `combinations` (`id`),
  CONSTRAINT `combinations_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `combinations_detail` (`id`, `combination_id`, `product_id`, `created_at`, `updated_at`) VALUES
(3,	9,	10,	'2024-04-03 01:02:13',	'2024-04-03 01:02:13');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_reset_tokens_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2024_03_18_031429_create_categories_table',	2),
(6,	'2024_03_18_035120_create_products_table',	3),
(7,	'2024_03_18_114417_create_product_photos_table',	3),
(8,	'2024_03_20_022437_create_tracked_items_table',	4),
(9,	'2024_03_20_022457_create_cart_items_table',	4),
(10,	'2024_03_25_082058_create_orders_table',	5),
(11,	'2024_03_25_083318_create_order_detials_table',	5),
(12,	'2024_03_26_061938_add_is_admin_to_users_table',	6),
(13,	'2024_03_26_214224_create_combinations_table',	7),
(14,	'2024_03_28_025053_combinations_detail',	8),
(15,	'2024_04_04_082655_add_size_column_to_cart_items_table',	9),
(16,	'2024_04_04_082759_add_size_column_to_order_details_table',	9),
(17,	'2024_04_05_111559_add_category_type_to_categories_table',	10),
(18,	'2024_04_23_133307_create_admin_table',	11),
(20,	'2024_04_24_020756_create_stocks_table',	12),
(21,	'2024_04_24_084121_add_color_to_order_detials',	12);

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `paymentmethodid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trains_time` date NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remit` int(11) NOT NULL,
  `staff_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` (`id`, `user_id`, `amount`, `paymentmethodid`, `status`, `address`, `phone`, `trains_time`, `comment`, `remit`, `staff_id`, `created_at`, `updated_at`) VALUES
(1,	1,	4070,	1,	6,	'你心裡',	'0987878787',	'2024-03-26',	'',	0,	1,	'2024-03-25 19:38:57',	'2024-03-26 18:47:09'),
(2,	1,	2970,	2,	6,	'你心裡',	'0987878787',	'2024-03-27',	'',	0,	1,	'2024-03-26 18:46:57',	'2024-03-27 05:07:00'),
(3,	1,	6320,	1,	0,	'你心裡',	'0987878787',	'2024-03-27',	'',	0,	1,	'2024-03-27 05:06:50',	'2024-03-27 05:06:50'),
(4,	1,	880,	1,	0,	'我心裡',	'aaaaa',	'2024-03-28',	'',	0,	1,	'2024-03-27 21:37:20',	'2024-03-27 21:37:20'),
(5,	1,	1100,	1,	0,	'你心裡',	'0912345678',	'2024-03-28',	'',	0,	1,	'2024-03-27 21:51:19',	'2024-03-27 21:51:19'),
(6,	1,	1970,	0,	0,	'你心裡',	'我心裡',	'2024-04-04',	'',	0,	1,	'2024-04-04 04:59:37',	'2024-04-04 04:59:37'),
(7,	1,	5940,	1,	0,	'你心裡',	'0987878787',	'2024-04-10',	'',	0,	1,	'2024-04-09 19:45:29',	'2024-04-09 19:45:29'),
(8,	1,	1980,	1,	0,	'你心裡',	'0987878787',	'2024-04-11',	'',	0,	1,	'2024-04-10 18:37:10',	'2024-04-10 18:37:10'),
(9,	1,	4620,	0,	0,	'你心裡',	'0987878787',	'2024-04-11',	'',	0,	1,	'2024-04-10 21:35:59',	'2024-04-10 21:35:59'),
(10,	1,	11399,	0,	0,	'你心裡',	'0987878787',	'2024-04-11',	'',	0,	1,	'2024-04-10 22:51:51',	'2024-04-10 22:51:51');

DROP TABLE IF EXISTS `order_detials`;
CREATE TABLE `order_detials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_detials` (`id`, `order_id`, `product_id`, `quantity`, `created_at`, `updated_at`, `size`, `color`) VALUES
(1,	1,	1,	3,	'2024-03-25 19:38:57',	'2024-03-25 19:38:57',	'',	''),
(2,	1,	3,	1,	'2024-03-25 19:38:57',	'2024-03-25 19:38:57',	'',	''),
(3,	2,	1,	3,	'2024-03-26 18:46:57',	'2024-03-26 18:46:57',	'',	''),
(4,	3,	7,	4,	'2024-03-27 05:06:50',	'2024-03-27 05:06:50',	'',	''),
(5,	4,	2,	1,	'2024-03-27 21:37:20',	'2024-03-27 21:37:20',	'',	''),
(6,	5,	3,	1,	'2024-03-27 21:51:19',	'2024-03-27 21:51:19',	'',	''),
(7,	6,	1,	1,	'2024-04-04 04:59:37',	'2024-04-04 04:59:37',	'M',	''),
(8,	6,	10,	1,	'2024-04-04 04:59:37',	'2024-04-04 04:59:37',	'L',	''),
(9,	7,	1,	1,	'2024-04-09 19:45:29',	'2024-04-09 19:45:29',	'M',	''),
(10,	7,	1,	2,	'2024-04-09 19:45:29',	'2024-04-09 19:45:29',	'M',	''),
(11,	7,	1,	3,	'2024-04-09 19:45:29',	'2024-04-09 19:45:29',	'L',	''),
(12,	8,	13,	3,	'2024-04-10 18:37:10',	'2024-04-10 18:37:10',	'XL',	''),
(13,	9,	13,	7,	'2024-04-10 21:35:59',	'2024-04-10 21:35:59',	'L',	''),
(14,	10,	4,	1,	'2024-04-10 22:51:51',	'2024-04-10 22:51:51',	'XS',	''),
(15,	10,	3,	10,	'2024-04-10 22:51:51',	'2024-04-10 22:51:51',	'2XL',	'');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_shelf` int(11) NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `name`, `stock`, `price`, `description`, `is_shelf`, `category_id`, `created_at`, `updated_at`) VALUES
(1,	'NIKE T-Shirt',	0,	990,	'NIKE T-Shirt',	1,	1,	'2024-03-18 05:42:04',	'2024-03-18 05:42:04'),
(2,	'ADIDAS T-Shirt',	0,	880,	'ADIDAS T-Shirt',	1,	1,	'2024-03-18 05:45:38',	'2024-03-18 05:45:38'),
(3,	'uniqlo 毛衣',	0,	1100,	'uniqlo 毛衣',	1,	2,	'2024-03-18 05:47:50',	'2024-03-18 05:47:50'),
(4,	'La BellezaV領素色麻花長版針織毛衣',	0,	399,	'La BellezaV領素色麻花長版針織毛衣',	1,	2,	'2024-03-18 20:32:22',	'2024-03-18 20:32:22'),
(5,	'ADIDAS運動外套',	0,	1580,	'ADIDAS運動外套',	1,	3,	'2024-03-18 20:34:27',	'2024-03-18 20:34:27'),
(6,	'NIKE運動外套',	0,	1690,	'NIKE運動外套',	1,	3,	'2024-03-18 20:35:28',	'2024-03-18 20:35:28'),
(7,	'連帽夾克外套',	0,	1580,	'連帽夾克外套',	1,	4,	'2024-03-18 20:37:08',	'2024-03-18 20:37:08'),
(8,	'三合一外套',	0,	13504,	'三合一外套',	1,	4,	'2024-03-18 20:37:58',	'2024-03-18 20:37:58'),
(9,	'小紅帽洛麗塔',	0,	999,	'小紅帽洛麗塔',	1,	5,	'2024-03-18 20:39:30',	'2024-03-18 20:39:30'),
(10,	'Nike 運動束褲',	0,	980,	'Nike 運動束褲',	1,	12,	'2024-03-27 19:41:32',	'2024-03-27 19:41:32'),
(13,	'可瑪莉痛T',	0,	660,	'コマリン！コマリン！',	1,	1,	'2024-04-10 06:53:06',	'2024-04-10 06:53:06');

DROP TABLE IF EXISTS `product_photos`;
CREATE TABLE `product_photos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `file_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product_photos` (`id`, `product_id`, `file_address`, `created_at`, `updated_at`) VALUES
(1,	1,	'1710769324.jpg',	'2024-03-18 05:42:04',	'2024-03-18 05:42:04'),
(2,	2,	'1710769538.jpg',	'2024-03-18 05:45:38',	'2024-03-18 05:45:38'),
(3,	3,	'1710769670.jpg',	'2024-03-18 05:47:50',	'2024-03-18 05:47:50'),
(4,	4,	'1710822742.jpg',	'2024-03-18 20:32:23',	'2024-03-18 20:32:23'),
(5,	5,	'1710822867.jpg',	'2024-03-18 20:34:27',	'2024-03-18 20:34:27'),
(6,	6,	'1710822928.jpg',	'2024-03-18 20:35:28',	'2024-03-18 20:35:28'),
(7,	7,	'1710823028.jpg',	'2024-03-18 20:37:08',	'2024-03-18 20:37:08'),
(8,	8,	'1710823078.jpg',	'2024-03-18 20:37:58',	'2024-03-18 20:37:58'),
(9,	9,	'1710823170.jpg',	'2024-03-18 20:39:30',	'2024-03-18 20:39:30'),
(10,	10,	'1711597292.jpg',	'2024-03-27 19:41:32',	'2024-03-27 19:41:32'),
(12,	13,	'GIwdd_xasAA0BKe.jpg',	'2024-04-10 06:53:06',	'2024-04-10 06:53:06'),
(13,	13,	'tw-11134207-7r98s-lomlaekg3v5oad.jfif',	'2024-04-10 06:53:06',	'2024-04-10 06:53:06');

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tracked_items`;
CREATE TABLE `tracked_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tracked_items` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1,	1,	6,	'2024-03-20 07:18:21',	'2024-03-20 07:18:21'),
(13,	1,	13,	'2024-04-24 03:32:31',	'2024-04-24 03:32:31');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `sex`, `birthday`, `address`, `phone`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Fuuzuki',	'yaesakura716207@gmail.com',	NULL,	'$2y$12$hA9OvXww9FpjuWLfjrHE..4Zeq/xUQYND9.lZHD75/ijiorFgfzyO',	1,	'2024-03-07',	'我心裡',	'0912345678',	NULL,	'2024-03-12 19:50:09',	'2024-03-13 19:47:45'),
(2,	'admin',	'yaesakura0417@gmail.com',	NULL,	'$2y$12$LBjX/J7yqIRvmxx3XrzANuGTKSy/L541GS0YRb4gXs3Kvq9ZXxbmm',	1,	'2009-05-21',	'你心裡',	'0987878787',	NULL,	'2024-04-10 18:08:22',	'2024-04-10 18:08:22');

-- 2024-04-24 16:44:33
