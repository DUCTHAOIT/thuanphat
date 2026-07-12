-- Migration: Thưởng điểm thẻ tiêu dùng (chia đều 8 tầng cây lấp tầng) + Thưởng danh hiệu
-- Date: 2026-07-10
-- Ref: docs/BUSINESS_RULES.md mục 6 (thưởng điểm thẻ tiêu dùng, thưởng danh hiệu), mục 5 (pending/release)

START TRANSACTION;

-- Bảng `ranks`/`user_ranks` đã tạo sẵn ở migration_2026-07-09_wallet_mlm_schema.sql nhưng chưa có
-- dữ liệu danh hiệu và chưa có ràng buộc chống trùng. Seed 4 danh hiệu (mục 6) + thêm UNIQUE để 1
-- user không thể được ghi nhận trùng 1 danh hiệu 2 lần (mục 8.1 - chống thực hiện 2 lần).
INSERT INTO `ranks` (`code`, `name`, `required_level`, `required_members`, `required_f1`, `bonus_percent`) VALUES
  ('quan_ly', 'Quản lý', 4, 81, 2, 0.03),
  ('truong_phong', 'Trưởng phòng', 5, 243, 3, 0.03),
  ('pho_giam_doc', 'Phó giám đốc', 6, 729, 4, 0.02),
  ('giam_doc', 'Giám đốc', 7, 2187, 5, 0.02)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

ALTER TABLE `user_ranks`
  ADD UNIQUE KEY `uq_user_ranks_user_rank` (`user_id`, `rank_code`);

-- Log thưởng điểm thẻ tiêu dùng (mục 6): trích 10% quỹ chia hoa hồng, chia đều 8 tầng khi thành viên
-- được xếp vào cây lấp tầng. Cần bảng riêng thay vì dùng chung `commissions` vì khoản này cộng vào
-- `consumption_cards.balance` (không phải user_wallets), và cần track pending/released riêng theo
-- business_active (mục 5) vì `consumption_cards` chỉ lưu số dư hiện tại, không có cột trạng thái.
CREATE TABLE `card_point_bonuses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `level` INT NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `status` ENUM('pending','released') NOT NULL DEFAULT 'released',
  `released_at` DATETIME NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_card_point_bonuses_user_status` (`user_id`, `status`),
  KEY `idx_card_point_bonuses_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
