-- Migration: Sản phẩm chấp nhận nguồn thanh toán nào (mục 3 BUSINESS_RULES.md)
-- Date: 2026-07-11
-- Ref: docs/BUSINESS_RULES.md mục 3 (Quy tắc thanh toán đơn hàng)
--
-- Admin tự tick chọn sản phẩm chấp nhận điểm thẻ / ví tiêu dùng / ví khả dụng hay không (chuyển khoản luôn
-- luôn cho phép, không cấu hình được - phương án dự phòng cuối cùng đảm bảo khách luôn đặt được đơn).
-- Mặc định = 1 (chấp nhận) cho TẤT CẢ sản phẩm hiện có, không gây gián đoạn luồng thanh toán vừa triển khai.
-- Giỏ hàng nhiều sản phẩm: 1 nguồn chỉ hiện cho khách chọn nếu TẤT CẢ sản phẩm trong giỏ đều chấp nhận
-- nguồn đó (lấy giao - intersection), xem calculateAcceptedPaymentSources() trong modules/basket/action.php.
ALTER TABLE `sys_product`
  ADD COLUMN `accept_card_payment` TINYINT(1) NOT NULL DEFAULT 1 AFTER `commission_amount`,
  ADD COLUMN `accept_tieu_dung_payment` TINYINT(1) NOT NULL DEFAULT 1 AFTER `accept_card_payment`,
  ADD COLUMN `accept_kha_dung_payment` TINYINT(1) NOT NULL DEFAULT 1 AFTER `accept_tieu_dung_payment`;
