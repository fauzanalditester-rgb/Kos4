-- Kos Harmoni Pro - Database Schema
-- Import file ini ke phpMyAdmin untuk setup database
-- Database name: u353387484_koskosan (sesuai .env)

-- ============================================
-- CREATE DATABASE IF NOT EXISTS
-- ============================================

CREATE DATABASE IF NOT EXISTS `u353387484_koskosan` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `u353387484_koskosan`;

-- ============================================
-- DROP TABLES IF EXIST (CLEAN INSTALL)
-- ============================================

DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `personal_access_tokens`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `properties`;
DROP TABLE IF EXISTS `rooms`;
DROP TABLE IF EXISTS `tenants`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `expenses`;
DROP TABLE IF EXISTS `maintenance_requests`;
DROP TABLE IF EXISTS `whatsapp_settings`;
DROP TABLE IF EXISTS `whatsapp_templates`;
DROP TABLE IF EXISTS `email_settings`;
DROP TABLE IF EXISTS `email_templates`;
DROP TABLE IF EXISTS `template_inventories`;

-- ============================================
-- USERS TABLE
-- ============================================

CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    `is_active` TINYINT(1) NOT NULL DEFAULT '1',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin user (password: password)
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) VALUES
('Administrator', 'admin@sewavip.com', '$2y$12$8rT6s0xZW7ZfGiMcWJWZLeKqO3t5.3XrNdZG.vQFrlkF7B5h5nSm', 'admin', NOW(), NOW(), NOW()),
('Demo User', 'demo@example.com', '$2y$12$8rT6s0xZW7ZfGiMcWJWZLeKqO3t5.3XrNdZG.vQFrlkF7B5h5nSm', 'user', NOW(), NOW(), NOW());

-- ============================================
-- PROPERTIES TABLE
-- ============================================

CREATE TABLE `properties` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `address` TEXT NULL,
    `description` TEXT NULL,
    `type` ENUM('kos', 'apartemen', 'rumah', 'kontrakan') NOT NULL DEFAULT 'kos',
    `status` ENUM('active', 'inactive', 'maintenance') NOT NULL DEFAULT 'active',
    `user_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `properties` (`name`, `address`, `description`, `type`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
('Kos Harmoni', 'Jl. Melati No. 123, Jakarta', 'Kos nyaman dengan fasilitas lengkap', 'kos', 'active', 1, NOW(), NOW()),
('Kos Bahagia', 'Jl. Mawar No. 45, Bandung', 'Kos strategis dekat kampus', 'kos', 'active', 1, NOW(), NOW());

-- ============================================
-- ROOMS TABLE
-- ============================================

CREATE TABLE `rooms` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `property_id` BIGINT UNSIGNED NOT NULL,
    `room_number` VARCHAR(50) NOT NULL,
    `floor` INT UNSIGNED NULL DEFAULT '1',
    `type` ENUM('standard', 'deluxe', 'suite') NOT NULL DEFAULT 'standard',
    `price_monthly` DECIMAL(12,2) NOT NULL DEFAULT '0.00',
    `price_yearly` DECIMAL(12,2) NULL,
    `facilities` TEXT NULL,
    `status` ENUM('available', 'occupied', 'maintenance', 'reserved') NOT NULL DEFAULT 'available',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rooms` (`property_id`, `room_number`, `floor`, `type`, `price_monthly`, `facilities`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A-101', 1, 'standard', 1500000.00, 'AC, WiFi, Kamar Mandi Dalam', 'available', NOW(), NOW()),
(1, 'A-102', 1, 'standard', 1500000.00, 'AC, WiFi, Kamar Mandi Dalam', 'occupied', NOW(), NOW()),
(1, 'B-201', 2, 'deluxe', 2000000.00, 'AC, WiFi, TV, Kamar Mandi Dalam, Balcony', 'available', NOW(), NOW()),
(2, 'C-101', 1, 'standard', 1200000.00, 'Kipas Angin, WiFi, Kamar Mandi Luar', 'available', NOW(), NOW()),
(2, 'C-102', 1, 'standard', 1200000.00, 'Kipas Angin, WiFi, Kamar Mandi Luar', 'occupied', NOW(), NOW());

-- ============================================
-- TENANTS TABLE
-- ============================================

CREATE TABLE `tenants` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `room_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NULL,
    `phone` VARCHAR(20) NOT NULL,
    `id_card_number` VARCHAR(50) NULL,
    `id_card_photo` VARCHAR(255) NULL,
    `emergency_contact` VARCHAR(20) NULL,
    `emergency_name` VARCHAR(255) NULL,
    `address` TEXT NULL,
    `occupation` VARCHAR(100) NULL,
    `rent_start_date` DATE NULL,
    `rent_end_date` DATE NULL,
    `rent_type` ENUM('monthly', 'yearly') NOT NULL DEFAULT 'monthly',
    `status` ENUM('active', 'inactive', 'moved_out') NOT NULL DEFAULT 'active',
    `deposit_paid` DECIMAL(12,2) NULL DEFAULT '0.00',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tenants` (`room_id`, `name`, `email`, `phone`, `id_card_number`, `emergency_contact`, `emergency_name`, `occupation`, `rent_start_date`, `rent_end_date`, `rent_type`, `status`, `deposit_paid`, `created_at`, `updated_at`) VALUES
(2, 'Budi Santoso', 'budi@email.com', '081234567890', '3171234567890', '081234567891', 'Ibu Budi', 'Karyawan Swasta', '2024-01-01', '2024-12-31', 'yearly', 'active', 1500000.00, NOW(), NOW()),
(4, 'Ani Wijaya', 'ani@email.com', '081345678901', '3179876543210', '081345678902', 'Bapak Ani', 'Mahasiswa', '2024-03-01', '2024-08-31', 'monthly', 'active', 1200000.00, NOW(), NOW());

-- Update room status
UPDATE `rooms` SET `status` = 'occupied' WHERE `id` IN (2, 4);

-- ============================================
-- INVOICES TABLE
-- ============================================

CREATE TABLE `invoices` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tenant_id` BIGINT UNSIGNED NOT NULL,
    `room_id` BIGINT UNSIGNED NOT NULL,
    `property_id` BIGINT UNSIGNED NOT NULL,
    `invoice_number` VARCHAR(50) NOT NULL UNIQUE,
    `invoice_date` DATE NOT NULL,
    `due_date` DATE NOT NULL,
    `month` INT NOT NULL,
    `year` INT NOT NULL,
    `rent_amount` DECIMAL(12,2) NOT NULL,
    `electricity_amount` DECIMAL(12,2) NULL DEFAULT '0.00',
    `water_amount` DECIMAL(12,2) NULL DEFAULT '0.00',
    `other_amount` DECIMAL(12,2) NULL DEFAULT '0.00',
    `total_amount` DECIMAL(12,2) NOT NULL,
    `paid_amount` DECIMAL(12,2) NULL DEFAULT '0.00',
    `status` ENUM('pending', 'paid', 'overdue', 'cancelled') NOT NULL DEFAULT 'pending',
    `payment_date` DATE NULL,
    `payment_method` VARCHAR(50) NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `invoices` (`tenant_id`, `room_id`, `property_id`, `invoice_number`, `invoice_date`, `due_date`, `month`, `year`, `rent_amount`, `electricity_amount`, `water_amount`, `other_amount`, `total_amount`, `paid_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'INV-202403-001', '2024-03-01', '2024-03-10', 3, 2024, 1500000.00, 150000.00, 50000.00, 0.00, 1700000.00, 1700000.00, 'paid', NOW(), NOW()),
(2, 4, 2, 'INV-202403-002', '2024-03-01', '2024-03-10', 3, 2024, 1200000.00, 100000.00, 30000.00, 0.00, 1330000.00, 0.00, 'pending', NOW(), NOW()),
(1, 2, 1, 'INV-202402-001', '2024-02-01', '2024-02-10', 2, 2024, 1500000.00, 140000.00, 45000.00, 0.00, 1695000.00, 1695000.00, 'paid', NOW(), NOW());

-- ============================================
-- PAYMENTS TABLE
-- ============================================

CREATE TABLE `payments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `invoice_id` BIGINT UNSIGNED NOT NULL,
    `tenant_id` BIGINT UNSIGNED NOT NULL,
    `payment_date` DATE NOT NULL,
    `amount` DECIMAL(12,2) NOT NULL,
    `payment_method` ENUM('cash', 'transfer', 'e-wallet', 'debit', 'credit') NOT NULL DEFAULT 'transfer',
    `reference_number` VARCHAR(100) NULL,
    `notes` TEXT NULL,
    `proof_image` VARCHAR(255) NULL,
    `created_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `payments` (`invoice_id`, `tenant_id`, `payment_date`, `amount`, `payment_method`, `reference_number`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-03-05', 1700000.00, 'transfer', 'TRF-1234567890', 'Pembayaran Maret 2024', 1, NOW(), NOW()),
(3, 1, '2024-02-08', 1695000.00, 'transfer', 'TRF-0987654321', 'Pembayaran Februari 2024', 1, NOW(), NOW());

-- ============================================
-- EXPENSES TABLE
-- ============================================

CREATE TABLE `expenses` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `property_id` BIGINT UNSIGNED NULL,
    `category` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `amount` DECIMAL(12,2) NOT NULL,
    `expense_date` DATE NOT NULL,
    `receipt_number` VARCHAR(100) NULL,
    `receipt_image` VARCHAR(255) NULL,
    `created_by` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `expenses` (`property_id`, `category`, `description`, `amount`, `expense_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'maintenance', 'Service AC Kamar A-101', 500000.00, '2024-03-15', 1, NOW(), NOW()),
(1, 'utilities', 'Tagihan Listrik Maret 2024', 2500000.00, '2024-03-20', 1, NOW(), NOW()),
(2, 'maintenance', 'Perbaikan Keran Air', 300000.00, '2024-03-18', 1, NOW(), NOW());

-- ============================================
-- MAINTENANCE REQUESTS TABLE
-- ============================================

CREATE TABLE `maintenance_requests` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `room_id` BIGINT UNSIGNED NOT NULL,
    `tenant_id` BIGINT UNSIGNED NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `priority` ENUM('low', 'medium', 'high', 'urgent') NOT NULL DEFAULT 'medium',
    `status` ENUM('pending', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    `requested_at` TIMESTAMP NULL,
    `completed_at` TIMESTAMP NULL,
    `cost` DECIMAL(12,2) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `maintenance_requests` (`room_id`, `tenant_id`, `title`, `description`, `priority`, `status`, `requested_at`, `created_at`, `updated_at`) VALUES
(2, 1, 'AC Tidak Dingin', 'AC kamar tidak dingin sejak kemarin', 'high', 'pending', NOW(), NOW(), NOW()),
(4, 2, 'Lampu Mati', 'Lampu kamar tidak menyala', 'medium', 'completed', NOW(), NOW(), NOW());

-- ============================================
-- WHATSAPP SETTINGS TABLE
-- ============================================

CREATE TABLE `whatsapp_settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `api_key` VARCHAR(255) NULL,
    `api_url` VARCHAR(255) NULL,
    `device_id` VARCHAR(100) NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT '0',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- WHATSAPP TEMPLATES TABLE
-- ============================================

CREATE TABLE `whatsapp_templates` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `type` ENUM('reminder', 'confirmation', 'welcome', 'payment', 'other') NOT NULL DEFAULT 'other',
    `template` TEXT NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT '1',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `whatsapp_templates` (`user_id`, `name`, `type`, `template`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Tagihan Bulanan', 'reminder', 'Halo {{name}}, ini pengingat tagihan kos Anda sebesar Rp {{amount}} untuk bulan {{month}}. Silakan bayar sebelum {{due_date}}. Terima kasih!', 1, NOW(), NOW()),
(1, 'Konfirmasi Pembayaran', 'confirmation', 'Halo {{name}}, pembayaran Anda sebesar Rp {{amount}} telah kami terima. Terima kasih!', 1, NOW(), NOW()),
(1, 'Selamat Datang', 'welcome', 'Halo {{name}}, selamat datang di Kos Harmoni! Kamar Anda adalah {{room}}. Jika ada yang perlu ditanyakan, silakan hubungi kami.', 1, NOW(), NOW());

-- ============================================
-- EMAIL SETTINGS TABLE
-- ============================================

CREATE TABLE `email_settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `smtp_host` VARCHAR(255) NULL,
    `smtp_port` INT NULL,
    `smtp_username` VARCHAR(255) NULL,
    `smtp_password` VARCHAR(255) NULL,
    `smtp_encryption` VARCHAR(20) NULL,
    `from_email` VARCHAR(255) NULL,
    `from_name` VARCHAR(255) NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT '0',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- EMAIL TEMPLATES TABLE
-- ============================================

CREATE TABLE `email_templates` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `type` ENUM('invoice', 'payment', 'reminder', 'welcome', 'other') NOT NULL DEFAULT 'other',
    `body` TEXT NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT '1',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TEMPLATE INVENTORIES TABLE
-- ============================================

CREATE TABLE `template_inventories` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `property_id` BIGINT UNSIGNED NULL,
    `name` VARCHAR(255) NOT NULL,
    `quantity` INT NOT NULL DEFAULT '0',
    `unit` VARCHAR(50) NULL,
    `condition` ENUM('good', 'fair', 'poor', 'damaged') NOT NULL DEFAULT 'good',
    `last_maintenance` DATE NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `template_inventories` (`property_id`, `name`, `quantity`, `unit`, `condition`, `last_maintenance`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'AC 1 PK', 3, 'unit', 'good', '2024-02-15', 'Semua AC berfungsi normal', NOW(), NOW()),
(1, 'Lemari', 5, 'unit', 'good', NULL, 'Lemari 2 pintu', NOW(), NOW()),
(1, 'Kasur Spring Bed', 5, 'unit', 'good', NULL, 'Kasur single', NOW(), NOW()),
(2, 'AC 1/2 PK', 2, 'unit', 'fair', '2024-01-20', 'Perlu service', NOW(), NOW());

-- ============================================
-- LARAVEL SYSTEM TABLES
-- ============================================

CREATE TABLE `sessions` (
    `id` VARCHAR(128) NOT NULL PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX (`user_id`),
    INDEX (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    INDEX (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tokenable_type` VARCHAR(255) NOT NULL,
    `tokenable_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `token` VARCHAR(64) NOT NULL UNIQUE,
    `abilities` TEXT NULL,
    `last_used_at` TIMESTAMP NULL,
    `expires_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    INDEX (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DONE! Database ready for use
-- ============================================
