-- Migration: Luồng thanh toán đơn hàng bằng điểm thẻ/ví (mục 3 BUSINESS_RULES.md)
-- Date: 2026-07-11
-- Ref: docs/BUSINESS_RULES.md mục 3 (Quy tắc thanh toán đơn hàng), mục 7 (Rút tiền - cùng cơ chế hoàn tiền)
--
-- order_payments đã có sẵn (migration_2026-07-09_wallet_mlm_schema.sql) nhưng chưa có cột đánh dấu đã hoàn
-- tiền hay chưa. Cần thêm để chống hoàn tiền 2 lần nếu admin từ chối đơn nhiều lần (orders.status hiện bị
-- ghi đè vô điều kiện ở admin80/modules/order/approve.php và index.php trước khi gọi
-- processOrderRejection(), không có guard theo status cũ) - mục 8.1 Không được thực hiện hai lần.
ALTER TABLE `order_payments`
  ADD COLUMN `refunded_at` DATETIME NULL DEFAULT NULL AFTER `commission_base_amount`;
