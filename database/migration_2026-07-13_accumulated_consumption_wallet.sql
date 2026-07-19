-- Migration: Đổi "Thưởng điểm thẻ tiêu dùng" thành "Tích lũy tiêu dùng" (mục 6 BUSINESS_RULES.md)
-- Date: 2026-07-13
-- Ref: docs/BUSINESS_RULES.md mục 6 (Tích lũy tiêu dùng), mục 3 (thanh toán ưu tiên 2), mục 2 (Ví)
--
-- Thay đổi nghiệp vụ (đã chốt với Sếp 2026-07-13):
-- - Vẫn trích 10% quỹ chia hoa hồng, vẫn phát sinh lúc thành viên được xếp vào cây (giữ nguyên trigger cũ).
-- - Đổi đối tượng nhận: từ "8 tầng đi lên spillover_tree" -> chia đều cho TOÀN BỘ thành viên
--   business_active = 1 trong hệ thống, TRỪ chính người vừa được xếp cây (nguồn phát sinh quỹ).
-- - Đổi nơi lưu: tách khỏi consumption_cards.balance (điểm thẻ tiêu dùng, giữ nguyên không đổi) sang ví
--   riêng user_wallets.tich_luy_tieu_dung.
-- - Dùng thanh toán đơn hàng ưu tiên 2 (ngay sau điểm thẻ tiêu dùng), TRỪ khỏi quỹ chia hoa hồng giống
--   điểm thẻ (order_payments.tich_luy_amount, đọc lại trong calculateCommissionFund()).
-- - Bảng card_point_bonuses (cơ chế cũ) giữ nguyên, không xóa/migrate dữ liệu cũ - chỉ không còn ghi mới.

ALTER TABLE `user_wallets`
  ADD COLUMN `tich_luy_tieu_dung` DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER `tieu_dung`;

ALTER TABLE `wallet_transactions`
  MODIFY COLUMN `wallet_type` ENUM('tong','kha_dung','tieu_dung','tai_tieu_dung','thue_phi','tich_luy_tieu_dung') NOT NULL,
  MODIFY COLUMN `ref_type` ENUM('order','commission','withdraw','rebuy','refund','rank_bonus','card_bonus','admin_adjust','accumulated_consumption') NOT NULL;

CREATE TABLE `accumulated_consumption_bonuses` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `status` ENUM('pending','released') NOT NULL DEFAULT 'pending',
  `released_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_order_id` (`order_id`),
  KEY `idx_user_id_status` (`user_id`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `sys_product`
  ADD COLUMN `accept_tich_luy_payment` TINYINT(1) NOT NULL DEFAULT 1 AFTER `accept_card_payment`;

ALTER TABLE `order_payments`
  ADD COLUMN `tich_luy_amount` DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER `card_amount`;
