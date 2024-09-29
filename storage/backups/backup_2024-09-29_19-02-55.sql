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

INSERT INTO admins VALUES ('1', 'Super Admin', 'admin@mail.com', NULL, '$2y$12$lInxxtECSnF4wI4R6o.t9eo7mpH4ihndE0PgU6a9O8reDW1yzzDwO', '1', NULL, '2024-09-16 08:44:43', '2024-09-16 08:44:43');
INSERT INTO admins VALUES ('2', 'Viewer', 'viewer@mail.com', NULL, '$2y$12$nwAANUzXAXtnScZTqcmUHOuJ71I0JRpWB4qD.I09D.8aPqEHwQjNy', '1', NULL, '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO admins VALUES ('3', 'Shahin', 'mdshahinmije96@gmail.com', NULL, '$2y$12$MeSre16Q57bEcdfNdnWxreeNfJ6UH6GBqHg/j.IjzN1LMunXs8Lu2', '1', NULL, '2024-09-16 08:44:44', '2024-09-16 08:44:44');

CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO brands VALUES ('1', 'হ্যামকো', 'Hamco', NULL, NULL);
INSERT INTO brands VALUES ('2', 'রহিম আফ্রো', 'Rahim Afroz', NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories VALUES ('1', NULL, 'Battery', 'Battery', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO categories VALUES ('2', NULL, 'Water', 'Water', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO categories VALUES ('3', NULL, 'Solar', 'Solar', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO customers VALUES ('1', 'মোঃ আবদুল্লাহ', 'abdullah@example.com', '01711111111', '01811111111', 'ঢাকা, বাংলাদেশ', NULL, NULL);
INSERT INTO customers VALUES ('2', 'মোঃ কামরুল হাসান', 'kamrul@example.com', '01722222222', NULL, 'চট্টগ্রাম, বাংলাদেশ', NULL, NULL);
INSERT INTO customers VALUES ('3', 'সুমাইয়া আক্তার', 'sumaiya@example.com', '01733333333', '01833333333', 'খুলনা, বাংলাদেশ', NULL, NULL);
INSERT INTO customers VALUES ('4', 'Tanisha Todd', 'negi@mailinator.com', '+1 (663) 923-3178', '+1 (418) 858-7674', 'Nisi esse ut quis m', '2024-09-16 14:38:50', '2024-09-16 14:38:50');
INSERT INTO customers VALUES ('5', 'Tatum Dixon', 'rymulapy@mailinator.com', '+1 (699) 196-6671', '+1 (821) 985-8555', 'Qui minim voluptate', '2024-09-16 14:39:11', '2024-09-16 14:39:11');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

INSERT INTO permissions VALUES ('1', 'admin-create', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('2', 'admin-view', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('3', 'admin-edit', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('4', 'admin-delete', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('5', 'role-create', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('6', 'role-view', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('7', 'role-delete', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('8', 'permission-create', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('9', 'permission-view', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('10', 'permission-update', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO permissions VALUES ('11', 'permission-delete', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO product_stocks VALUES ('1', '1', '94', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('2', '2', '63', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('3', '3', '21', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('4', '4', '34', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('5', '5', '87', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('6', '6', '86', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('7', '7', '47', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('8', '8', '10', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('9', '9', '10', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('10', '10', '90', 'add', 'When Product added!', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO product_stocks VALUES ('11', '1', '4', 'remove', 'Order Placed to customer 01711111111', '1', '2024-09-16 08:45:39', '2024-09-16 08:45:39');
INSERT INTO product_stocks VALUES ('12', '7', '7', 'remove', 'Order Placed to customer 01711111111', '1', '2024-09-16 08:45:39', '2024-09-16 08:45:39');
INSERT INTO product_stocks VALUES ('13', '7', '2', 'add', 'Customer 01711111111 removed from invoice', '1', '2024-09-16 08:48:15', '2024-09-16 08:48:15');
INSERT INTO product_stocks VALUES ('14', '7', '1', 'remove', 'Customer 01711111111 added to invoice', '1', '2024-09-16 08:52:41', '2024-09-16 08:52:41');
INSERT INTO product_stocks VALUES ('15', '1', '1', 'remove', 'Customer 01711111111 added to invoice', '1', '2024-09-16 08:54:20', '2024-09-16 08:54:20');
INSERT INTO product_stocks VALUES ('16', '1', '0', 'add', 'গ্রাহক 01711111111 ইনভয়েস থেকে সরানো হয়েছে।', '1', '2024-09-16 08:56:26', '2024-09-16 08:56:26');
INSERT INTO product_stocks VALUES ('17', '1', '1', 'add', 'গ্রাহক 01711111111 ইনভয়েস থেকে সরানো হয়েছে।', '1', '2024-09-16 08:57:14', '2024-09-16 08:57:14');
INSERT INTO product_stocks VALUES ('18', '1', '0', 'add', 'গ্রাহক 01711111111 ইনভয়েস থেকে সরানো হয়েছে।', '1', '2024-09-16 08:57:34', '2024-09-16 08:57:34');
INSERT INTO product_stocks VALUES ('19', '1', '1', 'remove', 'গ্রাহক 01711111111 ইনভয়েস আপডেট করা হয়েছে।', '1', '2024-09-16 08:58:34', '2024-09-16 08:58:34');
INSERT INTO product_stocks VALUES ('20', '2', '1', 'remove', 'গ্রাহক 01711111111 এর ইনভয়েসে পণ্য যোগ করা হয়েছে।', '1', '2024-09-16 09:01:26', '2024-09-16 09:01:26');
INSERT INTO product_stocks VALUES ('21', '2', '2', 'remove', 'গ্রাহক 01711111111 ইনভয়েস এড করা হয়েছে।', '1', '2024-09-16 09:01:49', '2024-09-16 09:01:49');
INSERT INTO product_stocks VALUES ('22', '2', '2', 'add', 'গ্রাহক 01711111111 ইনভয়েস থেকে সরানো হয়েছে।', '1', '2024-09-16 09:03:50', '2024-09-16 09:03:50');
INSERT INTO product_stocks VALUES ('23', '1', '1', 'remove', 'Order Placed to customer 01711111111', '1', '2024-09-16 09:27:01', '2024-09-16 09:27:01');
INSERT INTO product_stocks VALUES ('24', '6', '99', 'remove', 'Order Placed to customer 01733333333', '1', '2024-09-16 20:49:50', '2024-09-16 20:49:50');
INSERT INTO product_stocks VALUES ('25', '1', '95', 'remove', 'Order Placed to customer +1 (699) 196-6671', '1', '2024-09-22 20:51:49', '2024-09-22 20:51:49');
INSERT INTO product_stocks VALUES ('26', '4', '34', 'remove', 'Order Placed to customer +1 (699) 196-6671', '1', '2024-09-22 20:51:49', '2024-09-22 20:51:49');
INSERT INTO product_stocks VALUES ('27', '2', '15', 'remove', 'Order Placed to customer +1 (699) 196-6671', '1', '2024-09-22 20:51:49', '2024-09-22 20:51:49');
INSERT INTO product_stocks VALUES ('28', '5', '45', 'remove', 'Order Placed to customer +1 (699) 196-6671', '1', '2024-09-22 20:51:49', '2024-09-22 20:51:49');

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
  `description` text COLLATE utf8mb4_unicode_ci,
  `admin_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products VALUES ('1', '1', '1', '1', '1', 'হামকো ব্যাটারি', 'PN-1', '1', '-7', 'হামকো ব্যাটারি পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-22 20:51:49');
INSERT INTO products VALUES ('2', '1', '1', '1', '1', 'সোলার প্যানেল', 'PN-2', '1', '47', 'সোলার প্যানেল পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-22 20:51:49');
INSERT INTO products VALUES ('3', '1', '1', '1', '1', 'ল্যাপটপ', 'PN-3', '1', '21', 'ল্যাপটপ পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO products VALUES ('4', '1', '1', '1', '1', 'মোবাইল ফোন', 'PN-4', '1', '0', 'মোবাইল ফোন পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-22 20:51:49');
INSERT INTO products VALUES ('5', '1', '1', '1', '1', 'ক্যামেরা', 'PN-5', '1', '42', 'ক্যামেরা পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-22 20:51:49');
INSERT INTO products VALUES ('6', '1', '1', '1', '1', 'ইনভার্টার', 'PN-6', '1', '-13', 'ইনভার্টার পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-16 20:49:50');
INSERT INTO products VALUES ('7', '1', '1', '1', '1', 'টিভি', 'PN-7', '1', '41', 'টিভি পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-16 08:52:41');
INSERT INTO products VALUES ('8', '1', '1', '1', '1', 'ফ্রিজ', 'PN-8', '1', '10', 'ফ্রিজ পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO products VALUES ('9', '1', '1', '1', '1', 'মাইক্রোওভেন', 'PN-9', '1', '10', 'মাইক্রোওভেন পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO products VALUES ('10', '1', '1', '1', '1', 'ওয়াশিং মেশিন', 'PN-10', '1', '90', 'ওয়াশিং মেশিন পণ্যের বিবরণ', '1', '2024-09-16 08:44:44', '2024-09-16 08:44:44');

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

INSERT INTO roles VALUES ('1', 'Super Admin', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO roles VALUES ('2', 'Admin', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');
INSERT INTO roles VALUES ('3', 'Viewer', 'admin', '2024-09-16 08:44:44', '2024-09-16 08:44:44');

CREATE TABLE `sell_details` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sell_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sell_details_sell_id_foreign` (`sell_id`),
  KEY `sell_details_product_id_foreign` (`product_id`),
  CONSTRAINT `sell_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sell_details_sell_id_foreign` FOREIGN KEY (`sell_id`) REFERENCES `sells` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO sell_details VALUES ('1b0ca9ea-81c1-4a55-83ca-94b58a78da8e', '02bc3831-386d-40c3-a563-524c746e8f88', '2', '1', '2024-09-16 09:01:26', '2024-09-16 09:03:50');
INSERT INTO sell_details VALUES ('1f77cade-ba5a-4e2c-8773-b263748765c5', '26c0f124-b7f3-444a-a444-6a238a11508b', '1', '95', '2024-09-22 20:51:49', '2024-09-22 20:51:49');
INSERT INTO sell_details VALUES ('2000ee83-d833-4ff8-85c4-5771d134191c', 'a1697ecf-c165-4087-a8b7-11ab6cb06313', '6', '99', '2024-09-16 20:49:50', '2024-09-16 20:49:50');
INSERT INTO sell_details VALUES ('2b289bf6-d506-4c41-837b-19896ceded98', '26c0f124-b7f3-444a-a444-6a238a11508b', '5', '45', '2024-09-22 20:51:49', '2024-09-22 20:51:49');
INSERT INTO sell_details VALUES ('2e149248-566f-4fe4-910c-174e95a6cad8', '02bc3831-386d-40c3-a563-524c746e8f88', '1', '5', '2024-09-16 08:45:39', '2024-09-16 08:58:34');
INSERT INTO sell_details VALUES ('3c95cfb5-e9f4-4c51-991b-0badef396d05', '26c0f124-b7f3-444a-a444-6a238a11508b', '4', '34', '2024-09-22 20:51:49', '2024-09-22 20:51:49');
INSERT INTO sell_details VALUES ('99572d8c-b846-4025-bc6a-e6b4b48eb2e5', '02bc3831-386d-40c3-a563-524c746e8f88', '7', '6', '2024-09-16 08:45:39', '2024-09-16 08:52:41');
INSERT INTO sell_details VALUES ('9c09cdfe-7bc5-4b7a-b1f9-baa4fc1c3a64', 'e45a0de9-b60e-47c1-9a43-71225b80f48b', '1', '1', '2024-09-16 09:27:01', '2024-09-16 09:27:01');
INSERT INTO sell_details VALUES ('9de3c752-4990-4ccd-aef6-95af0872dccf', '26c0f124-b7f3-444a-a444-6a238a11508b', '2', '15', '2024-09-22 20:51:49', '2024-09-22 20:51:49');

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

INSERT INTO sells VALUES ('02bc3831-386d-40c3-a563-524c746e8f88', '1', '1', 'INV_1', '12', 'placed', 'Amet corrupti quia', '2024-09-16 08:45:39', '2024-09-16 09:03:50');
INSERT INTO sells VALUES ('26c0f124-b7f3-444a-a444-6a238a11508b', '5', '1', 'INV_4', '189', 'placed', 'Corporis omnis non d', '2024-09-22 20:51:49', '2024-09-22 20:51:49');
INSERT INTO sells VALUES ('a1697ecf-c165-4087-a8b7-11ab6cb06313', '3', '1', 'INV_3', '99', 'placed', 'Est impedit praese', '2024-09-16 20:49:50', '2024-09-16 20:49:50');
INSERT INTO sells VALUES ('e45a0de9-b60e-47c1-9a43-71225b80f48b', '1', '1', 'INV_2', '1', 'placed', 'kjh', '2024-09-12 09:27:01', '2024-09-16 09:27:01');

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

INSERT INTO sessions VALUES ('GXMP6S0ICuTYFKOtOt4QPFHD1kWsFnkeETqvkTzu', '1', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib0xpeTBudmo0QnRsQU9oRFlGVGEyMnFZMDNXa3ZHaUw4czVEQVRMdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', '1727614972');
INSERT INTO sessions VALUES ('LbU7c6PqeK4xnIdtXInyELVmUByPBgeN9XiGSXhw', '1', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicFV3bHhqYVJRb0toalZvRURDc21KNU1yM2NkSjRHVUdFeFo0a21sZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', '1727534187');
INSERT INTO sessions VALUES ('Lx5kPXTyU1gjaaFr4efVJPE8v1OUUbzlz25Mwlu3', '1', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEVwa2lCSkFkNXZmZkRHeGdrVnVydGdFaEUwcjI5WVd3dTJlNHgxMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vZGFzaGJvYXJkIjt9fQ==', '1726932349');
INSERT INTO sessions VALUES ('zRg8HkfGsBakknW9lj7f6xwQDuTPJI52O6qpDeYU', '1', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVDJjeWJUMGQ1SnM4QmNlZktPc1VOYXFXMDRXemwzaWE1bzJqSlBweSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vcHJvZHVjdC9zdG9jay8yIjt9fQ==', '1727018823');

CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO units VALUES ('1', 'কেজি', 'kg', NULL, NULL);
INSERT INTO units VALUES ('2', 'লিটার', 'liter', NULL, NULL);
INSERT INTO units VALUES ('3', 'পিস', 'piece', NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO vendors VALUES ('1', 'মোঃ আবদুল্লাহ', 'abdullah@example.com', '01711111111', '01811111111', 'ঢাকা, বাংলাদেশ', NULL, NULL);
INSERT INTO vendors VALUES ('2', 'মোঃ কামরুল হাসান', 'kamrul@example.com', '01722222222', NULL, 'চট্টগ্রাম, বাংলাদেশ', NULL, NULL);
INSERT INTO vendors VALUES ('3', 'সুমাইয়া আক্তার', 'sumaiya@example.com', '01733333333', '01833333333', 'খুলনা, বাংলাদেশ', NULL, NULL);

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

INSERT INTO website_infos VALUES ('1', 'Admin Panel', 'Admin Panel', 'admin@mail.com', '01754100439', '2024-09-16 08:44:44', '2024-09-16 08:44:44');

