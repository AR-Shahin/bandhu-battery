CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO admins VALUES ('1', 'Super Admin', 'admin@mail.com', NULL, '$2y$12$953M3e8c69kW27FByItbQuvsUj9A27W3okz3WbuM4Bv616Jqr30jO', '1', NULL, '2024-11-14 22:04:43', '2024-11-14 22:04:43');
INSERT INTO admins VALUES ('2', 'Viewer', 'viewer@mail.com', NULL, '$2y$12$ufUhlTYPyevmBvp0hrtZnu5aOQcm7RHnRwcUd.5L5DkE3is7xvfJy', '1', NULL, '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO admins VALUES ('3', 'Shahin', 'mdshahinmije96@gmail.com', NULL, '$2y$12$dvw5l8VEmVu.nqVQbg45TOzTr/PlqiXYSaI4FWalwhnE1eGggd/ES', '1', NULL, '2024-11-14 22:04:44', '2024-11-14 22:04:44');

CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO brands VALUES ('1', 'Hiroko Wood', 'Sigourney Hoover', '2024-11-14 22:07:34', '2024-11-14 22:07:34');

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories VALUES ('1', NULL, 'Signe Skinner', 'Blake Gutierrez', '1', '2024-11-14 22:07:39', '2024-11-14 22:07:39');

CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO customers VALUES ('1', 'Sybil Rose', 'feluwibi@mailinator.com', '+1 (321) 745-5984', '+1 (617) 912-9851', 'Enim ut ad quo labor', '2024-11-14 22:07:49', '2024-11-14 22:07:49');

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO migrations VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO migrations VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO migrations VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO migrations VALUES ('4', '2024_03_15_094043_create_admins_table', '1');
INSERT INTO migrations VALUES ('5', '2024_03_15_102545_create_permission_tables', '1');
INSERT INTO migrations VALUES ('6', '2024_03_16_095203_create_website_infos_table', '1');
INSERT INTO migrations VALUES ('7', '2024_07_02_140820_create_categories_table', '1');
INSERT INTO migrations VALUES ('8', '2024_08_20_012920_create_brands_table', '1');
INSERT INTO migrations VALUES ('9', '2024_08_20_012925_create_units_table', '1');
INSERT INTO migrations VALUES ('10', '2024_08_20_013025_create_vendors_table', '1');
INSERT INTO migrations VALUES ('11', '2024_08_20_013035_create_products_table', '1');
INSERT INTO migrations VALUES ('12', '2024_08_20_013054_create_customers_table', '1');
INSERT INTO migrations VALUES ('13', '2024_08_20_013108_create_product_stocks_table', '1');
INSERT INTO migrations VALUES ('14', '2024_08_20_013117_create_sells_table', '1');
INSERT INTO migrations VALUES ('15', '2024_08_20_013124_create_sell_details_table', '1');
INSERT INTO migrations VALUES ('16', '2024_11_09_181318_add_new_column_sell_details_table', '1');
INSERT INTO migrations VALUES ('17', '2024_11_14_215631_addnewcolumninproductstable', '1');
INSERT INTO migrations VALUES ('19', '2024_11_26_193758_add_new_column_in_sell_details_table', '2');

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO model_has_roles VALUES ('1', 'App\\Models\\Admin', '1');
INSERT INTO model_has_roles VALUES ('3', 'App\\Models\\Admin', '2');
INSERT INTO model_has_roles VALUES ('1', 'App\\Models\\Admin', '3');

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions VALUES ('1', 'admin-create', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('2', 'admin-view', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('3', 'admin-edit', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('4', 'admin-delete', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('5', 'role-create', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('6', 'role-view', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('7', 'role-delete', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('8', 'permission-create', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('9', 'permission-view', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('10', 'permission-update', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO permissions VALUES ('11', 'permission-delete', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');

CREATE TABLE `product_stocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `stock` int NOT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `admin_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO product_stocks VALUES ('1', '1', '11', 'add', 'When Product added!', '1', '2024-11-14 22:07:59', '2024-11-14 22:07:59');
INSERT INTO product_stocks VALUES ('2', '1', '9', 'remove', '', '1', '2024-11-14 22:18:14', '2024-11-14 22:18:14');
INSERT INTO product_stocks VALUES ('3', '2', '68', 'add', 'When Product added!', '1', '2024-11-14 22:21:16', '2024-11-14 22:21:16');
INSERT INTO product_stocks VALUES ('4', '2', '13', 'remove', 'Order Placed to customer +1 (321) 745-5984', '1', '2024-11-26 19:44:29', '2024-11-26 19:44:29');
INSERT INTO product_stocks VALUES ('5', '1', '3', 'remove', 'গ্রাহক +1 (321) 745-5984 এর ইনভয়েসে পণ্য যোগ করা হয়েছে।', '1', '2024-11-26 19:54:08', '2024-11-26 19:54:08');
INSERT INTO product_stocks VALUES ('6', '1', '3', 'add', 'গ্রাহক +1 (321) 745-5984 ইনভয়েস থেকে পণ্য বাতিল করা হয়েছে।', '1', '2024-11-26 19:54:56', '2024-11-26 19:54:56');
INSERT INTO product_stocks VALUES ('7', '1', '3', 'remove', 'গ্রাহক +1 (321) 745-5984 এর ইনভয়েসে পণ্য যোগ করা হয়েছে।', '1', '2024-11-26 20:00:47', '2024-11-26 20:00:47');
INSERT INTO product_stocks VALUES ('8', '1', '3', 'add', 'গ্রাহক +1 (321) 745-5984 ইনভয়েস থেকে পণ্য বাতিল করা হয়েছে।', '1', '2024-11-26 20:00:57', '2024-11-26 20:00:57');
INSERT INTO product_stocks VALUES ('9', '2', '51', 'remove', 'Order Placed to customer +1 (321) 745-5984', '1', '2024-11-29 21:53:03', '2024-11-29 21:53:03');
INSERT INTO product_stocks VALUES ('10', '1', '100', 'remove', 'Order Placed to customer +1 (321) 745-5984', '1', '2024-11-29 21:53:03', '2024-11-29 21:53:03');

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `brand_id` bigint unsigned NOT NULL,
  `unit_id` bigint unsigned NOT NULL,
  `vendor_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `stock` int NOT NULL,
  `price` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `admin_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products VALUES ('1', '1', '1', '1', '1', 'Hu Richmond', 'In nostrum nostrud m', '1', '-98', '1', 'Ratione eos ad repud', '1', '2024-11-14 22:07:59', '2024-11-29 21:53:03');
INSERT INTO products VALUES ('2', '1', '1', '1', '1', 'Isabella Cooper', 'Nobis quae libero au', '1', '4', '999999', 'Iusto voluptatem Si', '1', '2024-11-14 22:21:16', '2024-11-29 21:53:03');

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO role_has_permissions VALUES ('1', '1');
INSERT INTO role_has_permissions VALUES ('2', '1');
INSERT INTO role_has_permissions VALUES ('3', '1');
INSERT INTO role_has_permissions VALUES ('4', '1');
INSERT INTO role_has_permissions VALUES ('5', '1');
INSERT INTO role_has_permissions VALUES ('6', '1');
INSERT INTO role_has_permissions VALUES ('7', '1');
INSERT INTO role_has_permissions VALUES ('8', '1');
INSERT INTO role_has_permissions VALUES ('9', '1');
INSERT INTO role_has_permissions VALUES ('10', '1');
INSERT INTO role_has_permissions VALUES ('11', '1');
INSERT INTO role_has_permissions VALUES ('2', '3');
INSERT INTO role_has_permissions VALUES ('6', '3');
INSERT INTO role_has_permissions VALUES ('9', '3');

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles VALUES ('1', 'Super Admin', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO roles VALUES ('2', 'Admin', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');
INSERT INTO roles VALUES ('3', 'Viewer', 'admin', '2024-11-14 22:04:44', '2024-11-14 22:04:44');

CREATE TABLE `sell_details` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sell_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `product_codes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sell_details_sell_id_foreign` (`sell_id`),
  KEY `sell_details_product_id_foreign` (`product_id`),
  CONSTRAINT `sell_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sell_details_sell_id_foreign` FOREIGN KEY (`sell_id`) REFERENCES `sells` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO sell_details VALUES ('381c7547-bfda-44b4-8195-34afedfb7a51', 'add56da2-b932-4e5a-b521-2d936270d918', '2', '51', 'Earum beatae veniam', '2024-11-29 21:53:03', '2024-11-29 21:53:03', '2006-12-13 00:00:00');
INSERT INTO sell_details VALUES ('8fe83218-2c0c-49a7-bd00-de4e35b15261', '3d277886-58ef-4a25-aa47-63e96978ef1d', '2', '13', 'Ad cum ut fugit sap', '2024-11-26 19:44:29', '2024-11-26 19:53:21', '1986-10-05 00:00:00');
INSERT INTO sell_details VALUES ('f3c51f52-676e-44dd-a95c-7930cdaf02de', 'add56da2-b932-4e5a-b521-2d936270d918', '1', '100', 'Consequuntur aut bea', '2024-11-29 21:53:03', '2024-11-29 21:53:03', '1975-10-23 00:00:00');

CREATE TABLE `sells` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `admin_id` bigint unsigned NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'placed',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO sells VALUES ('3d277886-58ef-4a25-aa47-63e96978ef1d', '1', '1', 'INV_1', '13', 'placed', 'Fugit iste aute rep', '2024-11-26 19:44:29', '2024-11-26 20:00:57');
INSERT INTO sells VALUES ('add56da2-b932-4e5a-b521-2d936270d918', '1', '1', 'INV_2', '151', 'placed', 'Aut illo placeat si', '2024-11-29 21:53:03', '2024-11-29 21:53:03');

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO sessions VALUES ('efWgPxiO4l1v6uX5h9iQIsI2rb7KgKNLs2r63quA', '1', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOFZPZFhXS01LWEx0QlNJbEQ0eWZNQmUzU01mbElYQUJxNGZubmg3QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', '1733922043');
INSERT INTO sessions VALUES ('SlpYSY03A2hHz8UeN6WOqCTnYjs9Dg5hGkeKuZKx', '1', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQU1xTUcwRWVSN0xZMzdPU09HSjIyNzJRV0pPVW5MZklGRHJxaFpqMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vZGFzaGJvYXJkIjt9fQ==', '1733920271');

CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO units VALUES ('1', 'Latifah Stone', 'Eagan Hensley', '2024-11-14 22:07:43', '2024-11-14 22:07:43');

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vendors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO vendors VALUES ('1', 'Yuri Pace', 'sikunatox@mailinator.com', '+1 (659) 513-2623', '+1 (579) 598-6987', 'Consectetur omnis a', '2024-11-14 22:07:52', '2024-11-14 22:07:52');

CREATE TABLE `website_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Admin Panel',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Admin Panel',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'admin@mail.com',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '01754100439',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO website_infos VALUES ('1', 'Admin Panel', 'Admin Panel', 'admin@mail.com', '01754100439', '2024-11-14 22:04:44', '2024-11-14 22:04:44');

