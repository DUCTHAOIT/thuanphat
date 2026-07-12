-- Migration: Thưởng tiêu dùng tuần hoàn (mục 6 BUSINESS_RULES.md)
-- Date: 2026-07-10
-- Ref: docs/BUSINESS_RULES.md mục 6 (thưởng tiêu dùng tuần hoàn), mục 5 (pending/release theo business_active)
--
-- Trích 10% quỹ chia hoa hồng của đơn kích hoạt khi thành viên được xếp vào cây lấp tầng:
-- 70% chia đều 8 tầng (chỉ ancestor đã đạt 1 danh hiệu trong user_ranks mới nhận), cộng thẳng vào
-- user_wallets.tieu_dung; 30% còn lại chuyển vào quỹ vận hành (admin_fund_transactions, source='card_bonus').
-- Cần bảng riêng thay vì dùng chung `commissions` vì khoản này cộng thẳng vào ví tiêu dùng (không qua
-- quy tắc chia ví tổng 60/20/10/10), giống cách `card_point_bonuses` đã tách riêng cho điểm thẻ tiêu dùng.

START TRANSACTION;

CREATE TABLE `recurring_consumption_bonuses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `level` INT NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `status` ENUM('pending','released') NOT NULL DEFAULT 'released',
  `released_at` DATETIME NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_recurring_consumption_bonuses_user_status` (`user_id`, `status`),
  KEY `idx_recurring_consumption_bonuses_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
