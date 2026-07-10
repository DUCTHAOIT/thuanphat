-- Migration: Đánh dấu sản phẩm "combo kích hoạt" (business_active) thay vì check theo số tiền đơn hàng
-- Date: 2026-07-10
-- Ref: docs/BUSINESS_RULES.md mục 3 (Mua hàng - kích hoạt gói 5 triệu)

START TRANSACTION;

-- Đánh dấu sản phẩm nào là combo kích hoạt. Admin tự tick chọn ngay trong form Thêm/Sửa sản phẩm
-- (admin80/?m=product), checkbox "Combo kích hoạt" cạnh checkbox "Nổi bật" đã có sẵn.
ALTER TABLE `sys_product`
  ADD COLUMN `is_activation_combo` TINYINT(1) NOT NULL DEFAULT 0 AFTER `special_promotion`;

COMMIT;
