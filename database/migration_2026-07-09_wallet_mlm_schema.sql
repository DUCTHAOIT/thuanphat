-- Migration: Wallet & MLM schema (spillover tree, ranks, admin funds, order payments)
-- Date: 2026-07-09
-- Ref: docs/BUSINESS_RULES.md section 13
-- Backup before this migration: database/backup/thuanphat_backup_20260709.sql

START TRANSACTION;

-- 1. Sửa bảng hiện có

-- user.business_active đã tồn tại sẵn (được thêm thủ công trước migration này), bỏ qua.

ALTER TABLE `orders`
  ADD COLUMN `is_activation_package` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`,
  ADD COLUMN `commission_generated` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_activation_package`;

ALTER TABLE `commissions`
  ADD COLUMN `type` ENUM('direct','spillover','card','rank_bonus') NOT NULL DEFAULT 'direct' AFTER `level`,
  ADD COLUMN `status` ENUM('pending','released') NOT NULL DEFAULT 'released' AFTER `amount`,
  ADD COLUMN `released_at` DATETIME NULL DEFAULT NULL AFTER `status`;

-- 2. Bảng mới

CREATE TABLE `user_wallets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `tong` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `kha_dung` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `tieu_dung` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `tai_tieu_dung` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `thue_phi` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `rebuy_count` INT NOT NULL DEFAULT 0,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_wallets_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `wallet_transactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `wallet_type` ENUM('tong','kha_dung','tieu_dung','tai_tieu_dung','thue_phi') NOT NULL,
  `direction` ENUM('credit','debit') NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `balance_after` DECIMAL(15,2) NOT NULL,
  `ref_type` ENUM('order','commission','withdraw','rebuy','refund','rank_bonus','card_bonus','admin_adjust') NOT NULL,
  `ref_id` INT NULL DEFAULT NULL,
  `note` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_wallet_transactions_user` (`user_id`,`wallet_type`),
  KEY `idx_wallet_transactions_ref` (`ref_type`,`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `consumption_cards` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `balance` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_consumption_cards_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `spillover_tree` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `parent_id` INT NULL DEFAULT NULL,
  `sponsor_id` INT NOT NULL,
  `level` INT NOT NULL,
  `position` TINYINT(1) NOT NULL,
  `placed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_spillover_tree_user_id` (`user_id`),
  UNIQUE KEY `uq_spillover_tree_parent_position` (`parent_id`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `spillover_waiting_list` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `sponsor_id` INT NOT NULL,
  `placed` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_spillover_waiting_sponsor` (`sponsor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ranks` (
  `code` VARCHAR(30) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `required_level` INT NOT NULL,
  `required_members` INT NOT NULL,
  `required_f1` INT NOT NULL,
  `bonus_percent` DECIMAL(5,4) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user_ranks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `rank_code` VARCHAR(30) NOT NULL,
  `achieved_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_ranks_user` (`user_id`),
  KEY `idx_user_ranks_rank` (`rank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `admin_fund_transactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fund_code` ENUM('thi_truong_leader','van_phong','dao_tao','marketing','du_phong') NOT NULL,
  `source` ENUM('direct_commission','card_bonus') NOT NULL,
  `order_id` INT NULL DEFAULT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_admin_fund_fund_code` (`fund_code`),
  KEY `idx_admin_fund_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `order_payments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `card_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `tieu_dung_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `kha_dung_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `cash_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `commission_base_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_order_payments_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
