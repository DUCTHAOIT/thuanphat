-- Migration: Hoa hồng sản phẩm (commission_amount) - nền tính "quỹ chia hoa hồng" mới
-- Date: 2026-07-11
-- Ref: docs/BUSINESS_RULES.md mục 3 (Quỹ công ty / Quỹ chia hoa hồng)
--
-- Thay cho công thức cũ "quỹ chia hoa hồng = 60% giá trị đơn hàng" (cố định cho mọi đơn), mỗi sản phẩm
-- giờ có 1 số tiền VND cố định do admin tự nhập ("hoa hồng sản phẩm"), dùng làm nền tính hoa hồng thay vì
-- suy ra từ giá bán. Sản phẩm chưa được admin nhập (NULL/0, kể cả toàn bộ sản phẩm cũ trước migration này)
-- mặc định đóng góp 0đ vào quỹ chia hoa hồng cho tới khi admin chủ động nhập.
ALTER TABLE `sys_product`
  ADD COLUMN `commission_amount` DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER `is_activation_combo`;
