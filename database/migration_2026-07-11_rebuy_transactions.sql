-- Migration: Giao dịch tái tiêu dùng tự động (Rebuy)
-- Date: 2026-07-11
-- Ref: docs/BUSINESS_RULES.md mục 6 (Giao dịch tái tiêu dùng tự động), mục 2 (Ví), mục 5 (pending/release)
--
-- Khi ví tái tiêu dùng của 1 thành viên đạt/vượt 5,000,000đ: trừ đúng 5,000,000đ, số tiền này chính là quỹ
-- hoa hồng của giao dịch Rebuy (không qua bước 40/60 như đơn hàng), chia 3 khoản (trực tiếp/điều tầng/danh
-- hiệu) dùng chung bảng `commissions` như hoa hồng theo đơn hàng. Cần cột `rebuy_id` (bên cạnh `order_id` sẵn
-- có, đều NULL-able) để phân biệt commission sinh ra từ đơn hàng hay từ giao dịch Rebuy.

START TRANSACTION;

CREATE TABLE `rebuy_transactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_rebuy_transactions_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `commissions`
  ADD COLUMN `rebuy_id` INT NULL DEFAULT NULL AFTER `order_id`;

ALTER TABLE `admin_fund_transactions`
  ADD COLUMN `rebuy_id` INT NULL DEFAULT NULL AFTER `order_id`,
  MODIFY `source` ENUM('direct_commission','card_bonus','rebuy') NOT NULL;

COMMIT;
